<?php
class AdminbountyapplyController extends Controller 
{
	public $pageTitle;
   //check if logined or not
   public function init()
   {
        parent::init();
		$this->pageTitle="ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id']=="null" ) 
		{
          $this->redirect(array('newgin/'));
        }
    }
	

	public function filters() 
	{
		// $backCookie = Yii::app()->request->cookies->contains('adoption_reg_form') ? Yii::app()->request->cookies['adoption_reg_form']->value : '';
		// $backCookie1 = Yii::app()->request->cookies->contains('adoption_edit_form') ? Yii::app()->request->cookies['adoption_edit_form']->value : '';

		// if ($backCookie != "" && $backCookie != NULL && $backCookie != "null")
		// {
			// return array(
				// array('application.extensions.PerformanceFilter - regist'),
			// );
		// }
		// else if ($backCookie1 != "" && $backCookie1 != NULL && $backCookie1 != "null")
		// {
			// return array(
				// array('application.extensions.PerformanceFilter - edit'),
			// );
		// }
		// else {
			// return array(
				// 'accessControl',
			// );
		// }
    }
	private $_bounty_apply = null;
	public function loadModel() 
	{
        if ($this->_bounty_apply === null) 
		{
            if (isset($_GET['id'])) 
			{
                $this->_bounty_apply = Bounty_apply::model()->findbyPk(intval($_GET['id']));
            }
            else if(isset($_POST['Bounty_apply']))
			{
                $data=$_POST['Bounty_apply'];
                $id=$data['id'];
                $this->_bounty_apply = Bounty_apply::model()->findbyPk(intval($id));
            }
            else 
			{
                $this->_bounty_apply = new Bounty_apply();
            }
        }
        return $this->_bounty_apply;
    }
	

	public function actionSubscription($id)
	{
		//set cookie page
		$page	=isset($_GET['page']) ? $_GET['page'] : '';
		$cookie = new CHttpCookie('page', $page);
		Yii::app()->request->cookies['page'] = $cookie;	
		
		$id_get = $_GET['id'];
		$cookie_id_get = new CHttpCookie('id_get', $id_get);
		Yii::app()->request->cookies['id_get'] = $cookie_id_get;	
		
		$criteria = new CDbCriteria();
		$criteria->select = '*';
		$criteria->condition = 'bounty_id = :bounty_id';
		$criteria->params = array('bounty_id' => $id);
		$criteria->order ='created_date DESC';
		
		$item_count = Bounty_apply::model()->count($criteria); 
		$pages = new CPagination($item_count);         
		$pages->pageSize = Yii::app()->params['listPerPage'];
		$pages->applyLimit($criteria);	
		
		$model = Bounty_apply::model()->findAll($criteria);
		if(count($model)>0)
		{
			$this->render('/admin/bounty/subscription',array('model'=>$model,'pages' => $pages));
		}
		else
		{
			$this->redirect(array('/adminbounty/index'));
		}
    }
	
	public function actionAdoptionAdd() 
	{
		$parmas = array(); 
        $model  = $this->loadModel(); 
		if(count($model)>0)
		{
			 if (Yii::app()->request->isAjaxRequest) 
			 {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
			$parmas['model']=$model;       
			$this->render('/admin/bounty/adoptionadd', $parmas);
		}
		else
		{
			$this->redirect(array('/adminbounty/index'));
		}
    }
	
	public function actionAdoptionAddConfirm() 
	{
		$model= $this->loadModel(); 
		if (Yii::app()->request->isPostRequest)
		{  
			CActiveForm::validate($model);          
			if ($model->validate()) 
			{          	
				if(isset($_POST['edit'])&&$_POST['edit']=='1')
				{  
					if(is_numeric($model->id))
					{
						$model->setIsNewRecord(false);
					}            
					if ($model->save()) 
					{
						Bounty::model()->updateByPk($model->bounty_id, array('adopted_flag'=>1));
						$this->redirect(array('adminbountyapply/subscription?id='.$model->bounty_id));
					}
				}
					
			}
			$this->render('/admin/bounty/adoptionaddconfirm', array('model' => $model)); 
		}
		else
		{
			$this->redirect(array('/adminbounty/index'));
		}      
    }
	
	public function actionAdoptionEdit() 
	{
		$parmas = array(); 
        $model  = $this->loadModel(); 
		if(count($model)>0)
		{
			 if (Yii::app()->request->isAjaxRequest) 
			 {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
			$parmas['model']=$model;       
			$this->render('/admin/bounty/adoptionedit', $parmas);
		}
		else
		{
			$this->redirect(array('/adminbounty/index'));
		}
    }
	
	public function actionAdoptionEditConfirm() 
	{
		$model= $this->loadModel(); 
		if (Yii::app()->request->isPostRequest)
		{  
			CActiveForm::validate($model);          
			if ($model->validate()) 
			{          	
				if(isset($_POST['edit'])&&$_POST['edit']=='1')
				{  
					if(is_numeric($model->id))
					{
						$model->setIsNewRecord(false);
					}            
					if ($model->save()) 
					{
						$this->redirect(array('adminbountyapply/subscription?id='.$model->bounty_id));
					}
				}
				
			}
			$this->render('/admin/bounty/adoptioneditconfirm', array('model' => $model)); 
		}
		else
		{
			$this->redirect(array('/adminbounty/index'));
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
		$object = Yii::app()->db->createCommand("select * from bounty_apply where id=".$id)->queryRow();
		if(!empty($object['id']))
		{
			$row = 1;
		}		
		echo $row;
    }
}