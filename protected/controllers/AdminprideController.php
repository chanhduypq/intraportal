<?php

class AdminprideController extends Controller {    

	public $pageTitle;
    private $_pride = null;
	
	public function init() {
        parent::init();
		$this->pageTitle="ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id']=="null" ) {
          $this->redirect(array('newgin/'));
        }       
    }
	/**
     * display list pride
     */
    public function actionIndex() {
		
		//set cookie
		$page	=isset($_GET['page']) ? $_GET['page'] : '';
		$cookie = new CHttpCookie('page', $page);
		Yii::app()->request->cookies['page'] = $cookie;	
		$criteria = new CDbCriteria();
		$criteria->select = '*';
		$criteria->condition=FunctionCommon::isAdmin()==FALSE?"contributor_id=".Yii::app()->request->cookies['id']:"true";
		$criteria->order ='created_date DESC';
		
		$item_count = Pride::model()->count($criteria); 
		$pages = new CPagination($item_count);         
		$pages->pageSize = 10;
		$pages->applyLimit($criteria);	
		
		$ide = Pride::model()->findAll($criteria);
		$this->render('/admin/pride/index',array(
											'ide'=>$ide,
											'pages' => $pages));
		
        
    }
	/**
     * edit record id
     */
 	public function actionEdit() {
			$parmas 		= array(); 
			$model		    = $this->loadModel();
			 if ($model == null || !isset($_GET['id'])) {
         	   $this->redirect(array('adminpride/index'));
        	}
			
			 if (Yii::app()->request->isAjaxRequest) {
				echo CActiveForm::validate($model);
				Yii::app()->end();
			}
	
			$attachment1_error = isset(Yii::app()->session['attachment1']) ? Yii::app()->params['attachment1_error'] : '';
			$attachment2_error = isset(Yii::app()->session['attachment2']) ? Yii::app()->params['attachment2_error'] : '';
			$attachment3_error = isset(Yii::app()->session['attachment3']) ? Yii::app()->params['attachment3_error'] : '';
			unset(Yii::app()->session['attachment1']);
			unset(Yii::app()->session['attachment2']);
			unset(Yii::app()->session['attachment3']);
			$parmas['model'] = $model;
			$parmas['attachment1_error'] = $attachment1_error;
			$parmas['attachment2_error'] = $attachment2_error;
			$parmas['attachment3_error'] = $attachment3_error;
			$this->render('/admin/pride/edit',$parmas);
	}
	/**
     * edit confir,
     */
	public function actionEditconfirm() { 
		
         $model 		= $this->loadModel(); 
		 if(isset($_POST['Pride']['id'])){
		    $id_gol = Yii::app()->db->createCommand("select * from pride where id=".$_POST['Pride']['id'])->queryRow();
			if($id_gol==""){
				$this->redirect(array('adminpride/index'));
			}
		 }
			if (Yii::app()->request->isPostRequest){  
				CActiveForm::validate($model);    
				if (!isset($_POST['edit']) || $_POST['edit'] != '1') {
                    Upload_file_common_new::processAttachments($model,'pride',2);
				}
				
				if ($model->id == null || $model->id == '') {
					$this->redirect(array('adminpride/index'));
				}     
				
				 if ($model->validate()) {
					if (isset($_POST['edit']) && $_POST['edit'] == '1') {
						$model->attachment1 = $_POST['Pride']['attachment1'];
						$model->attachment2 = $_POST['Pride']['attachment2'];
						$model->attachment3 = $_POST['Pride']['attachment3'];
						if ($model->save() == true) {
							 if (Yii::app()->request->cookies['page'] != "") {
								$page = "index?page=" . Yii::app()->request->cookies['page'];
							} else {
								$page = "";
							}
							$this->redirect(array('adminpride/' . $page . ''));
						}
					}
				} else {
					if ($model->getError("attachment1") != "") {
						Yii::app()->session['attachment1'] = true;
					}
	
					if ($model->getError("attachment2") != "") {
						Yii::app()->session['attachment2'] = true;
					}
	
					if ($model->getError("attachment3") != "") {
						Yii::app()->session['attachment3'] = true;
					}
					/**
					 * 
					 */
					if ($model->attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment1)) {
						if ($model->attachment1 != Upload_file_common::getAttachmentById($model->id, 1,'pride')) {
							unlink(Yii::getPathOfAlias('webroot') . $model->attachment1);
						}
					}
					if ($model->attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment2)) {
						if ($model->attachment2 != Upload_file_common::getAttachmentById($model->id, 2,'pride')) {
							unlink(Yii::getPathOfAlias('webroot') . $model->attachment2);
						}
					}
					if ($model->attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment3)) {
						if ($model->attachment3 != Upload_file_common::getAttachmentById($model->id, 3,'pride')) {
							unlink(Yii::getPathOfAlias('webroot') . $model->attachment3);
						}
					}
					$cookie_collection = Yii::app()->request->cookies;
					$key_array = $cookie_collection->getKeys();
					for ($i = 0, $n = count($key_array); $i < $n; $i++) {
						$key = $key_array[$i];
						if (substr($key, 0, 4) == 'file') {
							if (Yii::app()->request->cookies[$key] != "" && Yii::app()->request->cookies[$key] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value)) {
								unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value);
							}
							unset(Yii::app()->request->cookies[$key]);
						}
					}
					$this->redirect(array('adminpride/edit/?id=' . $model->id));
				}
			}
		 else {
            $this->redirect(array('adminpride/index'));
      	  }
        $this->render('/admin/pride/editconfirm', array('model' => $model)); 
    } 
	/**
     * delete file fordel
     */
    public function actionDeleteattechments() {
        if (Yii::app()->request->isAjaxRequest) {
            $no = Yii::app()->request->getParam('no');
            if ($no == '1') {
                $attachment1 = Yii::app()->request->getParam('attachment1');
                $attachment2 = Yii::app()->request->getParam('attachment2');
                $attachment3 = Yii::app()->request->getParam('attachment3');
                $id = Yii::app()->request->getParam('id');
                if ($attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment1)) {
                    if ($attachment1 != Upload_file_common::getAttachmentById($id, 1,'pride')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment1);
                    }
                }
                if ($attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment2)) {
                    if ($attachment2 != Upload_file_common::getAttachmentById($id, 2,'pride')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment2);
                    }
                }
                if ($attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment3)) {
                    if ($attachment3 != Upload_file_common::getAttachmentById($id, 3,'pride')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment3);
                    }
                }
            }
        }
    }
	 /**
     * Detail id pride
     */
    public function actionDetail() {
				$model 	    = $this->loadModel();
				
				$pride_list_comments	= Yii::app()->db->createCommand("select * from pride_comment where pride_id=".$_GET['id']." order by created_date ASC")->queryAll();		
				$user					= User::model()->findAll();
				if(!empty($model->title))
				{ 										
					$this->render('/admin/pride/detail', array(
						'model' => $model,
						'pride_list_comments'=>$pride_list_comments,
						'user'=>$user,
							)
					);
				}
				else{
							$this->redirect(array('/adminpride/index'));
					}
    } 
	 /**
     * Download attachment
     */
     /**
     * Download attachment
     */
	public function actionDownload() {
    	 $attachment_index = 0;
        if (isset($_GET['1'])) {
            $attachment_index = 1;
        } else if (isset($_GET['2'])) {
            $attachment_index = 2;
        } else if (isset($_GET['3'])) {
            $attachment_index = 3;
        }
        if ($attachment_index != 0) {//download from detail                   
            $file_path=  Upload_file_common::getAttachmentById($_GET['id'], $attachment_index, 'pride');
        }
        else{//download from registconfirm
            $file_path = $_GET['file_name'];
        }
        Yii::import('ext.helpers.EDownloadHelper');
        EDownloadHelper::download(Yii::getPathOfAlias('webroot') . $file_path);
        exit;
    }
	 /**
     * Download attachment edit
     */
	public function actionDownloadedit(){
    	$model   =$this->loadModel();
    	if(isset($_POST['file_index'])){    		
    		CActiveForm::validate($model); 
    		$model->validate(); 
    		$attachment_id = $_POST['file_index']; 
			
    		if($attachment_id=='1'){
    			$file_name=$model->attachment1_file_name;
    			$file_type=$model->attachment1_file_type;
    				$content=base64_decode($model->attachment1_file_bytes);
    		}
    		else if($attachment_id=='2'){
    			$file_name=$model->attachment2_file_name;
    			$file_type=$model->attachment2_file_type;
    			$content=base64_decode($model->attachment2_file_bytes);
    		}
    		else if($attachment_id=='3'){
    			$file_name=$model->attachment3_file_name;
    			$file_type=$model->attachment3_file_type;
    			$content=base64_decode($model->attachment3_file_bytes);
    		} 
    		header('Content-Type: '.$file_type);
    		header('Content-Disposition: attachment;filename="'.$file_name.'"');
    		header('Cache-Control: max-age=0');    		
    		echo $content;    		
    	}
    	else{
    		$attachment_id=0;
    		if(isset($_GET['1'])){
    			$attachment_id=1;
    		}
    		else if(isset($_GET['2'])){
    			$attachment_id=2;
    		}
    		else if(isset($_GET['3'])){
    			$attachment_id=3;
    		}
    		if($attachment_id!=0){
    			$file_name=Yii::app()->db->createCommand()
    			->select('attachment'.$attachment_id)
    			->from('pride')
    			->where('id=:id',array('id'=>$_GET['id']))
    			->queryScalar(); 
    			if(file_exists(Yii::getPathOfAlias('webroot').$file_name)){
    				Yii::import('ext.helpers.EDownloadHelper');    				
    				EDownloadHelper::download(Yii::getPathOfAlias('webroot').$file_name);
    			}
    			
    		}
    		
    	}

    	exit;        
    } 
	 /**
     * load model
     */
	 
     public function loadModel() {
        if ($this->_pride === null) {
            if (isset($_GET['id'])) {
                $this->_pride = Pride::model()->findbyPk(intval($_GET['id']));
            }
            else if(isset($_POST['Pride'])){
                $data=$_POST['Pride'];
                $id=$data['id'];
                $this->_pride = Pride::model()->findbyPk(intval($id));
            }
            else {
                $this->_pride = new Pride();
            }
        }
        return $this->_pride;
    }
     /**
     * Delete Record id
     */
     public function actionDelete() {

        $id=Yii::app()->request->getParam('id'); 
		
        $model= new Pride();

        $model=$model->findByPk($id);
        if($model==NULL){
            return;
        }

        $attachment1=$model->attachment1;
        $attachment2=$model->attachment2;
        $attachment3=$model->attachment3;
        
        $transaction=$model->dbConnection->beginTransaction();

        $affected_pride=$model->deleteByPk($id);
        $affected_update_information=Yii::app()->db->createCommand()->delete(
                                                                            "update_information",                                                                             
                                                                            "table_name=:table_name and article_id=:article_id",
                                                                            array(
                                                                                "article_id"=>$id,
                                                                                "table_name"=>'pride',
                                                                            ))
                                     ;
		$affected_pride_comment=Yii::app()->db->createCommand()->delete(
                                                                            "pride_comment",                                                                             
                                                                            "pride_id=:pride_id",
                                                                            array(
                                                                                "pride_id"=>$id,
                                                                            ))
                                     ;							 

        if($id){
			$transaction->commit();
            
        }
        else{
            $transaction->rollback();
        }
		
        if($affected_pride==1){
            if ($attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment1)) {
                unlink(Yii::getPathOfAlias('webroot') . $attachment1);
                $thumnail_file_path=  FunctionCommon::getFilenameInThumnail($attachment1);
                if(file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)){
                    unlink(Yii::getPathOfAlias('webroot') . $thumnail_file_path);
                }
            }
            if ($attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment2)) {
                unlink(Yii::getPathOfAlias('webroot') . $attachment2);
                $thumnail_file_path=  FunctionCommon::getFilenameInThumnail($attachment2);
                if(file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)){
                    unlink(Yii::getPathOfAlias('webroot') . $thumnail_file_path);
                }
            }
            if ($attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment3)) {
                unlink(Yii::getPathOfAlias('webroot') . $attachment3);
                $thumnail_file_path=  FunctionCommon::getFilenameInThumnail($attachment3);
                if(file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)){
                    unlink(Yii::getPathOfAlias('webroot') . $thumnail_file_path);
                }
            }
              
        }

        $this->redirect(array('/adminpride/index'));
    } 
	 /**
     * delete comment id pride_comment with id pride
     */
	public function actionDeleteidpridecomment() {

        $id=Yii::app()->request->getParam('id'); 
		$id2=Yii::app()->request->getParam('id2'); 
		
        $model	= new Pride_comment;
        $transaction=$model->dbConnection->beginTransaction();

  	 	$delete_id_pride_respnse = Yii::app()->db->createCommand()->delete("pride_comment",'id=:id',array('id'=>$id2));	

        if($delete_id_pride_respnse){
			 $transaction->commit();   
        }
        else{
             $transaction->rollback();
        } 

        $this->redirect(array('adminpride/detail/?id='.$id));
    } 
	 /**
     * check id pride
     */
	  public function actionCheckId() {
        $id = $_POST['id'];
        $table = $_POST['table'];
        $id = Yii::app()->db->createCommand("select id from $table where id=$id limit 1")->queryScalar();
        if ($id == FALSE) {
            echo '0';
        } else {
            echo $id;
        }
    }
	public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('pride_edit_from') ? Yii::app()->request->cookies['pride_edit_from']->value : '';

       if( $backCookie !="" && $backCookie != NULL && $backCookie !="null" ){
            return array(
                array('application.extensions.PerformanceFilter - edit'),
            );
        } else {
            return array(
                'accessControl',
            );
        }
    }
}