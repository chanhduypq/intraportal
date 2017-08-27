<?php
 /*
 * Create Date: 17/07/2013
 * Update Date: 24/07/2013
 * Author: Hungtc
 * User change: Hungtc
 * Description: Admin action index object from model Category  
 * */


class AdmincategoryController extends Controller 
{
    public $pageTitle;
    private $_category = null;
	
	public function init() 
	{
        parent::init();
		$this->pageTitle="ニューギンスクエア";
    }
    public function loadModel() 
	{
        if ($this->_category === null) 
		{
            if (isset($_GET['id'])) 
			{
                $this->_category = Category::model()->findbyPk(intval($_GET['id']));
            }
            else if(isset($_POST['Category']))
			{
                $data=$_POST['Category'];
                $id=$data['id'];
                $this->_category = Category::model()->findbyPk(intval($id));
            }
            else 
			{
                $this->_category = new Category();
            }
        }
        return $this->_category;
    }
	
	  /*
     * Create Date:20130910
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:Method using check id category 
     * */

    public function actionCheckId() 
	{
        $id = $_POST['id'];
        $row = 0;
        $object = Yii::app()->db->createCommand("select * from category where id=" . $id)->queryRow();
        if (!empty($object['id'])) 
		{
            $row = 1;
        }
        echo $row;
    }
      /**
     * Index 
     */
    public function actionCategories($type)
	{
		if(isset($_GET['type']))
		{
			$page = isset($_GET['page']) ? $_GET['page'] : '';
			$cookie = new CHttpCookie('page', $page);
			Yii::app()->request->cookies['page'] = $cookie;
		
			$criteria = new CDbCriteria();
			$criteria->select = '*';
			$criteria->condition = "type =$type";
			$criteria->order ='created_date DESC';
			
			$item_count = Category::model()->count($criteria); 
			$pages = new CPagination($item_count);         
			$pages->pageSize = 10;
			$pages->applyLimit($criteria);	
			$category = Category::model()->findAll($criteria);
			
			switch ($type)
			{
				case 2:
				  $this->render('/admin/soumu_qa/categories',array('category'=>$category,'pages' => $pages));
				  break;
				case 4:
				  $this->render('/admin/skill/categories',array('category'=>$category,'pages' => $pages));	
				  break;    
				case 5:
				  $this->render('/admin/golf_news/categories',array('category'=>$category,'pages' => $pages));	
				  break;  
				case 6:
				  $this->render('/admin/hobby_new/categories',array('category'=>$category,'pages' => $pages));	
				  break;
				case 7:
				  $this->render('/admin/link/categories',array('category'=>$category,'pages' => $pages));	
				  break;  
			}
		}		
    }
	
    
    public function actionCategoryregist($type) 
	{ 
		if(isset($_GET['type']))
		{
			$parmas= array(); 
			$model= new Category();  
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
						$model->type=$type;
						$model->background_color=isset($_POST["Category"]["background_color"]) ? $_POST["Category"]["background_color"] :null;
						$model->text_color=isset($_POST["Category"]["text_color"]) ? $_POST["Category"]["text_color"] :null;
						if($model->save())
						{
							$this->redirect(array('admincategory/categories/?type='.$type));	
						}
				}	
			}
	
			
			$params	= array('model' => $model);
			$parmas['model']=$model;  
		//	$parmas['category']=$category;      
			switch ($type)
			{
				case 2:
					$this->render('/admin/soumu_qa/categoryregist', $parmas);
				break;
				case 4:
					$this->render('/admin/skill/category_regist', $parmas);
				break;  
				case 5:
					$this->render('/admin/golf_news/category_regist', $parmas);
				break;  
				case 6:
					$this->render('/admin/hobby_new/category_regist', $parmas);
				break;
				case 7:
					$this->render('/admin/link/category_regist', $parmas);
				break;
			}
		}
    }
    
    public function actionCategoryEdit($type) 
	{
		$parmas 		= array(); 
        $model=$this->loadModel();
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
					if(is_numeric($model->id))
					{
						$model->setIsNewRecord(false);
						$model->background_color=isset($_POST["Category"]["background_color"]) ? $_POST["Category"]["background_color"] :null;
						$model->text_color=isset($_POST["Category"]["text_color"]) ? $_POST["Category"]["text_color"] :null;
						if($model->update())
						{
							$this->redirect(array('admincategory/categories/?type='.$type));	
						}   
					}
				}	
			}      
			$parmas['model']=$model;
			switch ($type)
			{
				case 2:
					$this->render('/admin/soumu_qa/categoryedit',$parmas);
				  break;
				case 4:
					$this->render('/admin/skill/category_edit',$parmas);
				  break;   
				case 5:
					$this->render('/admin/golf_news/category_edit',$parmas);
				  break;  
				case 6:
					$this->render('/admin/hobby_new/category_edit', $parmas);
				  break;
				case 7:
					$this->render('/admin/link/category_edit', $parmas);
				  break; 
			}	
		}
		else
		{
			$this->redirect(array('admincategory/categories/?type='.$type));	
		}
	}
    
    
    public function actionCategoryDelete($type) 
	{
		$id=Yii::app()->request->getParam('id'); 
		$model =Category::model();
		$transaction = $model->dbConnection->beginTransaction();
        $model = $model->findByPk($id);
		if(count($model)>0)
		{
			$affected_row = $model->deleteByPk($id);
			switch ($type) 
			{
				//Delete skill
				case 4:
					$criteria = new CDbCriteria();
					$criteria->select = '*';
					$criteria->addCondition('category_id ='.$id);
					$skills = Skill::model()->findAll($criteria);
					try
					{
						foreach ($skills as $skill) 
						{
							$attachment1 = $skill->attachment1;
							$attachment2 = $skill->attachment2;
							$attachment3 = $skill->attachment3;
							if ($affected_row == 1) 
							{
								if (!empty($attachment1) && file_exists(Yii::getPathOfAlias('webroot') . $attachment1)) 
								{
								   unlink(Yii::getPathOfAlias('webroot') . $attachment1);
								}
								if (!empty($attachment2) && file_exists(Yii::getPathOfAlias('webroot') . $attachment2))
								{
									unlink(Yii::getPathOfAlias('webroot') . $attachment2);
								}
								if (!empty($attachment3) && file_exists(Yii::getPathOfAlias('webroot') . $attachment3))
								{
									unlink(Yii::getPathOfAlias('webroot') . $attachment3);
								}
							}
							$affected_skill= Yii::app()->db->createCommand()->delete("skill", "id=$skill->id");
						}
						$transaction->commit();
					}	
					catch(Exception $ex) 
					{
						$transaction->rollBack();
					}
				break;
				//Delete golf_news
				case 5:
					$criteria = new CDbCriteria();
					$criteria->select = '*';
					$criteria->addCondition('category_id ='.$id);
					$golfnews = Golfnews::model()->findAll($criteria);
					try
					{
						foreach ($golfnews as $golfnew) 
						{
							$attachment1 = $golfnew->attachment1;
							$attachment2 = $golfnew->attachment2;
							$attachment3 = $golfnew->attachment3;
							if ($affected_row == 1) 
							{
								if (!empty($attachment1) && file_exists(Yii::getPathOfAlias('webroot') . $attachment1)) 
								{
								   unlink(Yii::getPathOfAlias('webroot') . $attachment1);
								}
								if (!empty($attachment2) && file_exists(Yii::getPathOfAlias('webroot') . $attachment2))
								{
									unlink(Yii::getPathOfAlias('webroot') . $attachment2);
								}
								if (!empty($attachment3) && file_exists(Yii::getPathOfAlias('webroot') . $attachment3))
								{
									unlink(Yii::getPathOfAlias('webroot') . $attachment3);
								}
							}
							$affected_golfnew= Yii::app()->db->createCommand()->delete("golf_news", "id=$golfnew->id");
						}
						$transaction->commit();
					}	
					catch(Exception $ex) 
					{
						$transaction->rollBack();
					}
				break;
				//Delete hobby_new
				case 6:
					$criteria = new CDbCriteria();
					$criteria->select = '*';
					$criteria->addCondition('category_id ='.$id);
					$hobby_new = Hobby_new::model()->findAll($criteria);
					try
					{

						foreach ($hobby_new as $hobby_new) 
						{
							$attachment1 = $hobby_new->attachment1;
							$attachment2 = $hobby_new->attachment2;
							$attachment3 = $hobby_new->attachment3;
							if ($affected_row == 1) 
							{
								if (!empty($attachment1) && file_exists(Yii::getPathOfAlias('webroot') . $attachment1)) 
								{
								   unlink(Yii::getPathOfAlias('webroot') . $attachment1);
								}
								if (!empty($attachment2) && file_exists(Yii::getPathOfAlias('webroot') . $attachment2))
								{
									unlink(Yii::getPathOfAlias('webroot') . $attachment2);
								}
								if (!empty($attachment3) && file_exists(Yii::getPathOfAlias('webroot') . $attachment3))
								{
									unlink(Yii::getPathOfAlias('webroot') . $attachment3);
								}
							}
							$affected_hobby_new= Yii::app()->db->createCommand()->delete("hobby_new", "id=$hobby_new->id");
						}
						$transaction->commit();
					}	
					catch(Exception $ex) 
					{
						$transaction->rollBack();
					}
				break;
				//Delete sLink
				case 7:
					$criteria = new CDbCriteria();
					$criteria->select = '*';
					$criteria->addCondition('category_id ='.$id);
					$links = Slink::model()->findAll($criteria);
					
					try
					{
						foreach ($links as $link) 
						{
							$affected_hobby_new= Yii::app()->db->createCommand()->delete("slink", "id=$link->id");
						}
						$transaction->commit();
					}	
					catch(Exception $ex) 
					{
						$transaction->rollBack();
					}
				break;
		  }
		  $this->redirect(array('admincategory/categories/?type='.$type));	
		}
	}	
}