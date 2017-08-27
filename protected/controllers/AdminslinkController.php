<?php
class AdminslinkController extends Controller 
{
	
	public $pageTitle;
	public function init() 
	{
        parent::init();
		$this->pageTitle="ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id']=="null" )
		{
          $this->redirect(array('newgin/'));
        }
    }
	
	private $_slink = null;
	public function loadModel() 
	{
        if ($this->_slink === null) 
		{
            if (isset($_GET['id'])) 
			{
                $this->_slink = Slink::model()->findbyPk(intval($_GET['id']));
            }
            else if(isset($_POST['Slink']))
			{
                $data=$_POST['Slink'];
                $id=$data['id'];
                $this->_slink = Slink::model()->findbyPk(intval($id));
            }
            else 
			{
                $this->_slink = new Slink();
            }
        }
        return $this->_slink;
    }
	
	
	// public function filters()
	// {
		// $backCookie=Yii::app()->request->cookies->contains('from') ? Yii::app()->request->cookies['from']->value : '';
		// if(!is_null($backCookie) && !empty($backCookie))
		// {    
            // return array(array('application.extensions.PerformanceFilter - regist, edit'),);
		// }
		// else
		// {
            // return array('accessControl',);
		// }
	// }
	
	/** Create Date:23/07/2012
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:action index using get all object from model newitem  
     * */ 	
	public function actionIndex()
	{
		//set cookie page
		$page	=isset($_GET['page']) ? $_GET['page'] : '';
		$cookie = new CHttpCookie('page', $page);
		Yii::app()->request->cookies['pagesub'] = $cookie;
		
		$criteria = new CDbCriteria();
		$criteria->select = '*';
        $criteria->condition=FunctionCommon::isAdmin()==FALSE?"contributor_id=".Yii::app()->request->cookies['id']:"true";
		$criteria->condition="type=1";
		$criteria->order ='created_date DESC';
		
		$item_count = Slink::model()->count($criteria); 
		$pages = new CPagination($item_count);         
		$pages->pageSize = 10;
		$pages->applyLimit($criteria);	
		
		$model = Slink::model()->findAll($criteria);
		$this->render('/admin/slink/index',array('model'=>$model,'pages' => $pages));
    }
	
	/** Create Date:23/07/2012
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:action Regist using create  object slink  
     * */ 
	public function actionRegist() 
	{
		$parmas = array(); 
        $model  = new Slink();
		
        if (Yii::app()->request->isPostRequest) 
		{ 
			if (Yii::app()->request->isAjaxRequest) 
			{
				echo CActiveForm::validate($model);
				Yii::app()->end();
			} 
            CActiveForm::validate($model);
            if ($model->validate()) 
			{                
				if ($model->save()) 
				{
					$this->redirect(array('adminslink/index'));
				}                                    
            }
        }
        $parmas['model']=$model;       
        $this->render('/admin/slink/regist', $parmas);
    }
	
	/** Create Date:23/07/2012
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:action edit using change object slink  
     * */ 
	public function actionEdit() 
	{
		$parmas= array(); 
		$model= $this->loadModel() ;
		if(count($model)>0)
		{
			if (Yii::app()->request->isAjaxRequest) 
			{
				echo CActiveForm::validate($model);
				Yii::app()->end();
			} 
			if (Yii::app()->request->isPostRequest) 
			{ 
				CActiveForm::validate($model);
				if ($model->validate()) 
				{                
						$parmas['valid']=TRUE;  
						if ($model->save())
						{
							if(Yii::app()->request->cookies['page']!= "") 
							{
								   $page = "index?page=".Yii::app()->request->cookies['page'];
									
							}
							else 
							{
								$page ="";
							}
							$this->redirect(array('adminslink/'.$page.''));	
						}	
				}
			}
			$parmas['model']=$model;        
			$this->render('/admin/slink/edit',$parmas);    
		}
		else
		{
			 $this->redirect(array('adminslink/index'));
		}		
    }
	
	/** Create Date:23/07/2012
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:action delete using delete object slink  
     * */ 
	public function actionDelete() 
	{
		
        $id=Yii::app()->request->getParam('id'); 
		$model=Slink::model();
		
		$transaction=$model->dbConnection->beginTransaction();
		$model=$model->findByPk($id);
		if(!is_null($model))
		{
			
			$affected_row=$model->deleteByPk($id);
			
			$affected_update_information=Yii::app()->db->createCommand()->delete(
			"update_information",                                                                             
			"table_name=:table_name and article_id=:article_id",
			array("article_id"=>$id,"table_name"=>'slink',));
			
			if($affected_row!=$affected_update_information)
			{
				 $transaction->rollback();
			}
			else
			{
				$transaction->commit();
			}
			$this->redirect(array('adminslink/index'));
        }
    } 	
    
	/*
     * Create Date:20130802
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:Method using id bounty_apply 
     * */
	public function actionCheckId()
	{
		$id=$_POST['id'];
		$row=0;
		$object = Yii::app()->db->createCommand("select * from slink where id=".$id)->queryRow();
		if(!empty($object['id']))
		{
			$row = 1;
		}		
		echo $row;
    }
	
}