<?php

class AdminlinkController extends Controller 
{
	public $pageTitle;
    public function init()
	{
        parent::init();
		$this->pageTitle="ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null")
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
	
	/** Create Date:20130911
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:action index using get all object from model slich by type 2
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
		$criteria->condition="type=2";
		$criteria->order ='created_date DESC';
		
		$item_count = Slink::model()->count($criteria); 
		$pages = new CPagination($item_count);         
		$pages->pageSize = Yii::app()->params['listPerPage'];
		$pages->applyLimit($criteria);	
		
		$model = Slink::model()->findAll($criteria);
		$this->render('/admin/link/index',array('model'=>$model,'pages' => $pages));
    }
	
	/** Create Date:20130911
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:actionusing create object slink  
     * */ 
	public function actionRegist() 
	{
		$parmas = array(); 
        $model  =  new Slink();
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
				$count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM category WHERE id='.$_POST["Slink"]["category_id"])->queryScalar();
				if($count>0)
				{
					$model->type= $_POST["Slink"]["type"];
					$model->category_id= $_POST["Slink"]["category_id"];	
					$model->comment= $_POST["Slink"] ["comment"];	
					if ($model->save()) 
					{
						$this->redirect(array('adminlink/index'));
					} 
				}
				else
				{
					$this->redirect(array('adminlink/index'));
				}		
            }
        }
        $parmas['model']=$model;       
        $this->render('/admin/link/regist', $parmas);
    }
	
	/** Create Date:20130911
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:action edit using change info object link  
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
					$count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM category WHERE id='.$_POST["Slink"]["category_id"])->queryScalar();
					if($count>0)
					{
						$model->category_id= $_POST["Slink"]["category_id"];	
						$model->comment= $_POST["Slink"] ["comment"];
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
							$this->redirect(array('adminlink/'.$page.''));	
						}
					}
					else
					{
						$this->redirect(array('adminlink/index'));
					}	
				}
			}
			$parmas['model']=$model;        
			$this->render('/admin/link/edit',$parmas);    
		}
		else
		{
			 $this->redirect(array('adminlink/index'));
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
			$this->redirect(array('adminlink/index'));
        }
    } 	

}
?>