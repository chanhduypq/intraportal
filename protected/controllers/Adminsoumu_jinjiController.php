<?php

class Adminsoumu_jinjiController extends Controller {    

    private $_soumu_jinji = null;
	public $pageTitle;
	  public function init()
	  {
        parent::init();
		$this->pageTitle="ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id']=="null" ) {
          $this->redirect(array('newgin/'));
        }
        
    }
	/**
     * display list soumu_jinji
     */
    public function actionIndex() {
		
		//set cookie
		$page	=isset($_GET['page']) ? $_GET['page'] : '';
		$cookie = new CHttpCookie('page', $page);
		Yii::app()->request->cookies['page'] = $cookie;	
		
        $criteria = new CDbCriteria();
		$category = Category::model()->findAll();
		$criteria->select = '*';
		$criteria->condition=FunctionCommon::isAdmin()==FALSE?"contributor_id=".Yii::app()->request->cookies['id']:"true";
		$criteria->order ='created_date DESC';
		
		$item_count = Soumu_jinji::model()->count($criteria); 
		$pages = new CPagination($item_count);         
		$pages->pageSize = Yii::app()->params['listPerPage'];
		$pages->applyLimit($criteria);	
		
		$soumu_jinji = Soumu_jinji::model()->findAll($criteria);
		
		$this->render('/admin/soumu_jinji/index',array(
											'soumu_jinji'=>$soumu_jinji,
											'pages' => $pages,
											'category'=>$category
											));
    }
	/**
     * Regist 
     */
	 public function actionRegist() { 
        $parmas 		= array(); 
        $model 			= new Soumu_jinji();  
		$model->deadline_year= date("Y");
		$model->deadline_month=date('n');
		$model->deadline_day=date('j');
		$category = Category::model()->findAll();
		
        if (Yii::app()->request->isAjaxRequest) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        } 
        if (Yii::app()->request->isPostRequest) { 
            CActiveForm::validate($model);
            if ($model->validate()) {                
                if(!isset($_POST['regist'])||$_POST['regist']!='0'){
                    $parmas['valid']=TRUE;                   
                                     
                }     
                
            }
        }
		 $params 		= array(
					   'model' => $model,
					   'category'=>$category);
		
        $parmas['model']=$model;  
		$parmas['category']=$category;      
        $this->render('/admin/soumu_jinji/regist', $parmas);
    } 
	 /**
     * Regist confirm
     */
    public function actionRegistconfirm() { 
		
         $model = new Soumu_jinji();
		 $category = Category::model()->findAll();
		
		 if(!empty($_POST['Soumu_jinji']['employee_name']) || !empty($_POST['Soumu_jinji']['category_id']))
		{ 
			if (Yii::app()->request->isPostRequest){            
				CActiveForm::validate($model);             
				if ($model->validate()) {             	
					if(isset($_POST['regist'])&&$_POST['regist']=='1'){  
						$model->achive_date = $model->deadline_year . '-' . $model->deadline_month . '-' . $model->deadline_day.' '.date('H:i:s');;              
						$now = date('Y-m-d H:i:s'); 
						$model->created_date = $now;  
						$model->last_updated_date = $now; 
						if ($model->save() == true) {
							$this->redirect(array('/adminsoumu_jinji/index'));
						}
					}  
				}
			}
		}
		else{
					$this->redirect(array('/adminsoumu_jinji/index'));
			}	
	
        $this->render('/admin/soumu_jinji/registconfirm', array('model' => $model,'category'=>$category));
        
    } 
	/**
     * edit record id
     */
 	public function actionEdit() {
					$parmas 		= array(); 
					$model		    = $this->loadModel(); 
					if(!empty($model->employee_name))
					{ 		
						$category = Category::model()->findAll();
						
						$achive_date = explode("/", FunctionCommon::formatDate($model->achive_date));
						$model->deadline_day = $achive_date[2];
						$model->deadline_month = $achive_date[1];
						$model->deadline_year = $achive_date[0];
				
						if (Yii::app()->request->isAjaxRequest) {		
							
							echo CActiveForm::validate($model);
							Yii::app()->end();
						} 
						if (Yii::app()->request->isPostRequest) { 
							CActiveForm::validate($model);
							if ($model->validate()) {                
								if(!isset($_POST['edit'])||$_POST['edit']!='0'){
									$parmas['valid']=TRUE;       
													 
								}     
								
							}
						}
						$parmas['model']=$model;    
						$parmas['category']=$category;        
						$this->render('/admin/soumu_jinji/edit',$parmas);
					}
					else{
								$this->redirect(array('/adminsoumu_jinji/index'));
						}	
						
	}
	/**
     * edit confirm,
     */
	public function actionEditconfirm() { 
		
        $model= new Soumu_jinji();
		$category = Category::model()->findAll();
		
		 if(!empty($_POST['Soumu_jinji']['employee_name']) || !empty($_POST['Soumu_jinji']['category_id']))
		 {
			if (Yii::app()->request->isPostRequest)
			{  
				CActiveForm::validate($model);    
				   
						if ($model->validate())
						{          	
							if(isset($_POST['edit'])&&$_POST['edit']=='1')
							{  
							$model->achive_date = $model->deadline_year . '-' . $model->deadline_month . '-' . $model->deadline_day.' '.date('H:i:s');;                    
							$now = date('Y-m-d H:i:s'); 
							$model->last_updated_date = $now; 
									if(is_numeric($model->id)){
										$model->setIsNewRecord(false);
									}             
									if ($model->save() == true) {
										if(Yii::app()->request->cookies['page']!= "") 
										{
											   $page = "index?page=".Yii::app()->request->cookies['page'];
												
										}else {$page ="";}
										$this->redirect(array('adminsoumu_jinji/'.$page.''));	
										
									}
							}
						}
						
							
			}
		}	
		else{
					$this->redirect(array('/adminsoumu_jinji/index'));
			}	
		
        $this->render('/admin/soumu_jinji/editconfirm', array('model' => $model,'category'=>$category));
    } 
	
	 /**
     * Detail id
     */
    public function actionDetail()
	{
					$model 	    = $this->loadModel();
					if(!empty($model->title))
					{ 
						$this->render('/admin/soumu_jinji/detail', array(
							'model' => $model,
								)
						);
					}
					else{
								$this->redirect(array('/majime/index'));
						}				
    } 
	
	 /**
     * load model
     */
     public function loadModel() {
        if ($this->_soumu_jinji === null) {
            if (isset($_GET['id'])) {
				$this->_soumu_jinji = Soumu_jinji::model()->findbyPk(intval($_GET['id']));              
            }
            else if(isset($_POST['Soumu_jinji'])){
                $data=$_POST['Soumu_jinji'];
                $id=$data['id'];
                $this->_soumu_jinji = Soumu_jinji::model()->findbyPk(intval($id));
            }
            else {
                $this->_soumu_jinji = new Soumu_jinji();
            }
        }		
        return $this->_soumu_jinji;
    }
     /**
     * Delete Record id
     */
     public function actionDelete() {

        $id=Yii::app()->request->getParam('id'); 

        $model= new Soumu_jinji();

        $model=$model->findByPk($id);
        if($model==NULL){
            return;
        }
        
        $transaction=$model->dbConnection->beginTransaction();

        $affected_soumu_jinji=$model->deleteByPk($id);
        $affected_update_information=Yii::app()->db->createCommand()->delete(
                                                                            "update_information",                                                                             
                                                                            "table_name=:table_name and article_id=:article_id",
                                                                            array(
                                                                                "article_id"=>$id,
                                                                                "table_name"=>'soumu_jinji',
                                                                            ));
        if($id){
			$transaction->commit();
            
        }
        else{
            $transaction->rollback();
        }
        $this->redirect(array('/adminsoumu_jinji/index'));
    } 
	 /**
     * check id soumu_jinji
     */
	 public function actionCheckId() {
		$id=$_POST['id'];
		$row=0;
		$id_soumu_jinji = Yii::app()->db->createCommand("select * from soumu_jinji where id=".$id)->queryRow();
		if($id_soumu_jinji['id']==""){$row = 1;}		
		echo $row;
    }
	public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('from_jini') ? Yii::app()->request->cookies['from_jini']->value : '';

        if( $backCookie !="" && $backCookie != NULL && $backCookie !="null" ){
            return array(
                array('application.extensions.PerformanceFilter - edit, regist'),
            );
        } else {
            return array(
                'accessControl',
            );
        }
    }
}