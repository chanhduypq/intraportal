<?php
class Asobihobby_newController extends Controller
{
	public $pageTitle;
	//check if logined or not
     public function init()
	 {
        parent::init();
		$this->pageTitle="製品アイデア投稿広場 | ニューギンスクエア";
        if(Yii::app()->request->cookies['id'] =="")
		{ 
			$this->redirect(Yii::app()->baseUrl.'/index.php');
        }
        /**
         * 
         */
        //set_time_limit(3000);;
        //ini_set("memory_limit", -1);
    } 
     
	public function filters()
	{
		$backCookie=Yii::app()->request->cookies->contains('hobby_new_regist_form') ? Yii::app()->request->cookies['hobby_new_regist_form']->value : '';
		if(!is_null($backCookie) && !empty($backCookie))
		{    
            return array(array('application.extensions.PerformanceFilter - regist'),);
		}
		else
		{
            return array('accessControl',);
		}
	} 
	
	
	public function checkCategory() 
	{
		$id=$_POST['catId'];
		$count=0;
		if(!empty($id))
		{
			$count = Yii::app()->db->createCommand("select * from category where id=".$id)->queryRow();
		}
		echo $count;
    }


	 /*
     * Create Date:20130814
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:Method using load model Hobby_new
     * */
	private $_hobbynews = null; 
	public function loadModel()
	{
        if ($this->_hobbynews === null) 
		{
            if (isset($_GET['id'])) 
			{
                $this->_hobbynews = Hobby_new::model()->findbyPk(intval($_GET['id']));
            } 
			else 
			{
                $this->_hobbynews = new Hobby_new();
            }
        }
        return $this->_hobbynews;
    } 
	
	/** Create Date:20130822
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:Method using down load file
     * */
	 public function actionDownload() 
	 {
        $attachment_index = 0;
        if (isset($_GET['1'])) 
		{
            $attachment_index = 1;
        } 
		else if (isset($_GET['2']))
		{
            $attachment_index = 2;
        } 
		else if (isset($_GET['3']))
		{
            $attachment_index = 3;
        }
        if ($attachment_index != 0) 
		{
			//download from detail                   
            $file_path=  Upload_file_common::getAttachmentById($_GET['id'], $attachment_index, 'hobby_new');
        }
        else
		{
			//download from registconfirm
            $file_path = $_GET['file_name'];
        }
        Yii::import('ext.helpers.EDownloadHelper');
        EDownloadHelper::download(Yii::getPathOfAlias('webroot') . $file_path);

        exit;
    }
	
	public function actionDeleteattechments() 
	{
        if (Yii::app()->request->isAjaxRequest) 
		{
            $no = Yii::app()->request->getParam('no');
            if ($no == '1') 
			{
                $attachment1 = Yii::app()->request->getParam('attachment1');
                $attachment2 = Yii::app()->request->getParam('attachment2');
                $attachment3 = Yii::app()->request->getParam('attachment3');
                if ($attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment1)) 
				{
                    unlink(Yii::getPathOfAlias('webroot') . $attachment1);
                }
                if ($attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment2)) 
				{
                    unlink(Yii::getPathOfAlias('webroot') . $attachment2);
                }
                if ($attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment3)) 
				{
                    unlink(Yii::getPathOfAlias('webroot') . $attachment3);
                }
            }
        }
    }
	
	/** Create Date:20130814
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:action index get all object in hobby_new  
     * */ 
	public function actionIndex()
	{
            $cookie_collection =Yii::app()->request->cookies;           
                $key_array=$cookie_collection->getKeys(); 

                for($i=0,$n=count($key_array);$i<$n;$i++){
                    $key=$key_array[$i];
                    if(substr($key, 0,4)=='file'&&strpos($key,'hobby_new')!=FALSE){
                        
                        if (Yii::app()->request->cookies[$key]!=""&&Yii::app()->request->cookies[$key]!="null"&&file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value)) {
                            unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value);
                        }
                        unset(Yii::app()->request->cookies[$key]);
                    }
                }
		$this->pageTitle="あそびにマジメ！？あそび自慢＆対決！ | ニューギンスクエア";
		//set cookie page
		$page	=isset($_GET['page']) ? $_GET['page'] : '';
		$cookie = new CHttpCookie('page', $page);
		Yii::app()->request->cookies['page'] = $cookie;	
		
		$criteria = new CDbCriteria();
		$criteria->select = '*';
        $criteria->condition=(FunctionCommon::isPostFunction("hobby_new")&&!FunctionCommon::isViewFunction("hobby_new"))?"contributor_id=".Yii::app()->request->cookies['id']:"true";
		$criteria->order ='created_date DESC';
		
		$item_count = Hobby_new::model()->count($criteria); 
		$pages = new CPagination($item_count);         
		$pages->pageSize = Yii::app()->params['listPerPage'];
		$pages->applyLimit($criteria);	
		
		$model = Hobby_new::model()->findAll($criteria);
		$this->render('/asobi/hobby_new/index',array('model'=>$model,'pages' => $pages));
                
	}
	
	
	
	/** Create Date:20130814
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:action using register object hobby_new  
     * */ 
	public function actionRegist() 
	{
		$parmas = array(); 
        $model  = $this->loadModel(); 
		
		if (Yii::app()->request->isAjaxRequest) 
		{
            echo CActiveForm::validate($model);
            Yii::app()->end();
        } 

		$attachment1_error = isset(Yii::app()->session['attachment1']) ? Yii::app()->params['attachment1_error'] : '';
        $attachment2_error = isset(Yii::app()->session['attachment2']) ? Yii::app()->params['attachment2_error'] : '';
        $attachment3_error = isset(Yii::app()->session['attachment3']) ? Yii::app()->params['attachment3_error'] : '';
		unset(Yii::app()->session['attachment1']);
        unset(Yii::app()->session['attachment2']);
        unset(Yii::app()->session['attachment3']);
        $parmas['attachment1_error'] = $attachment1_error;
        $parmas['attachment2_error'] = $attachment2_error;
        $parmas['attachment3_error'] = $attachment3_error;
      
        $parmas['model']=$model;       
        $this->render('/asobi/hobby_new/regist', $parmas);

    }
	
	/** Create Date:20130815
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:action display info register object hobby_new
     * */ 
    public function actionRegistConfirm() 
	{
		$model = $this->loadModel();
	    if (Yii::app()->request->isPostRequest)
		{
			CActiveForm::validate($model);  
			if (!isset($_POST['regist']) || $_POST['regist'] != '1') 
			{                
				Upload_file_common_new::processAttachments($model,'hobby_new',1);
			}           
			if ($model->validate())
			{
				if (isset($_POST['regist']) && $_POST['regist'] == '1')
				{
				
					$model->attachment1 = $_POST['Hobby_new']['attachment1'];
					$model->attachment2 = $_POST['Hobby_new']['attachment2'];
					$model->attachment3 = $_POST['Hobby_new']['attachment3'];
					if ($model->save()) 
					{                        
						if(FunctionCommon::isViewFunction("hobby_new")==false)
						{
							 $this->redirect(array('asobi/'));
						}
						else
						{
							$this->redirect(array('asobihobby_new/index'));
						}	
					}
				}
			}
			else 
			{
				if ($model->getError("attachment1") != "") 
				{
					Yii::app()->session['attachment1'] = true;
				}

				if ($model->getError("attachment2") != "")
				{
					Yii::app()->session['attachment2'] = true;
				}

				if ($model->getError("attachment3") != "") 
				{
					Yii::app()->session['attachment3'] = true;
				}

				if ($model->attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment1)) 
				{
					unlink(Yii::getPathOfAlias('webroot') . $model->attachment1);
				}
				if ($model->attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment2)) 
				{
					unlink(Yii::getPathOfAlias('webroot') . $model->attachment2);
				}
				if ($model->attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment3)) 
				{
					unlink(Yii::getPathOfAlias('webroot') . $model->attachment3);
				}
				$cookie_collection = Yii::app()->request->cookies;
				$key_array = $cookie_collection->getKeys();
				for ($i = 0, $n = count($key_array); $i < $n; $i++)
				{
					$key = $key_array[$i];
					if (substr($key, 0, 4) == 'file') 
					{
						if (Yii::app()->request->cookies[$key] != "" && Yii::app()->request->cookies[$key] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value)) 
						{
							unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value);
						}
						unset(Yii::app()->request->cookies[$key]);
					}
				}           
				$this->redirect(array('asobihobby_new/regist'));
			}
				
        } 
		else 
		{
           // $this->redirect(array('asobihobby_new/index'));
        }
        $this->render('/asobi/hobby_new/registconfirm', array('model' => $model));
    }
	
	/** Create Date:18/11/2013
     * Update Date:
     * Author:Baodt
     * User change:
     * Detail id hobby_new & view valuation table hobby_new comment width id hobby_new
     * */ 
	
    public function actionDetail() {
		
        $model 	  					= $this->loadModel();
		//$hobby_new_list_comments	= Hobby_new_comment::model()->findAll('hobby_new_id=:id',array('id'=>$_GET['id']));
		$hobby_new_list_comments	= Yii::app()->db->createCommand("select * from hobby_new_comment where hobby_new_id=".$_GET['id']." order by created_date ASC")->queryAll();	
		$hobby_new_comment			= new Hobby_new_comment;
		$user						= User::model()->findAll();
		
		
		if(!empty($model->title))
		{ 
			if (Yii::app()->request->isAjaxRequest) {
				echo CActiveForm::validate($hobby_new_comment);
				Yii::app()->end();
			} 
			if (Yii::app()->request->isPostRequest) { 
				CActiveForm::validate($hobby_new_comment);
				if ($hobby_new_comment->validate()) { 
								 
					if($model->saveHobby_new_comment($hobby_new_comment))
						{
							$this->refresh();
						}  
				}
			}
			$this->render('/asobi/hobby_new/detail', array(
												'model' => $model,
												'hobby_new_comment'=>$hobby_new_comment,
												'hobby_new_list_comments'=>$hobby_new_list_comments,
												'user'=>$user,
												)
			);
		}
		else{
					$this->redirect(array('/asobihobby_new/index'));
			}
    } 
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
}