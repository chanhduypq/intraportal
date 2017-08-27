<?php
 
class AdminpickupController extends Controller 
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
	
	
	
	/*
	 * Create Date: 
	 * Update Date: 
	 * Author: 
	 * User change: 
	 * Description:
	 **/
    public function actionIndex()
	{

		$model=new Pickup();
		
        if (Yii::app()->request->isAjaxRequest) 
		{
            if(isset($_GET['unit_id']))
			{
                $users=$model->getAllUsersByBaseId($_GET['unit_id']);
				
                if($users!=NULL &&  is_array($users) &&  count($users)>0)
				{
                    echo CJSON::encode($users);
                }
                else
				{
                    echo "[]";
                }
            }

            if(isset($_GET['user_id']))
			{
                $user=$model->getCatchphraseAndCommentByUserId($_GET['user_id']);   
				if(!is_null($user) &&  is_array($user) && count($user)>0)
				{
				$user['catchphrase']=  FunctionCommon::url_henkan($user['catchphrase']);
                                    $user['comment']=  FunctionCommon::url_henkan($user['comment']);
                    echo CJSON::encode($user);
                }
                else
				{
                    echo "[]";
                }
            }
            Yii::app()->end();
        }
		if(isset($_POST['pickup_id']))
		{
			$status=Pickup::model()->findbyPk(intval($_POST['pickup_id']));
		}
		
        if (Yii::app()->request->isPostRequest) 
		{ 
		
            CActiveForm::validate($model);
            if ($model->validate()) 
			{  
			
                $pickup_date=$_POST['pickup_date'];
                $temp=  explode("/", $pickup_date);
                $model->pickup_date=  implode("-", $temp);  
				$model->id=$_POST['pickup_id'];
				if ($this->CheckUser($model->user_id))
				{
					
					if(count($status) >0)
					{
						$model->isNewRecord = false;
						if($model->save())
						{
							$model->id="";	
							$model->unit_id="";
						}
					}
					else
					{
					   if($model->save())
					   {
							$model->id="";	
							$model->unit_id="";
					   }
					}
				}
            }
			
			
			if(count($status) >0 && empty($_POST['Pickup']["unit_id"]) && empty($_POST['Pickup']["user_id"]))
			{ 	
				Yii::app()->db->createCommand('delete from pickup where id='.$_POST['pickup_id'])->query();
			}
        }
        $parmas['model']=$model;        
        $this->render('/admin/pickup/index', $parmas);
        
    }
	/*
	 * Create Date: 
	 * Update Date: 
	 * Author: 
	 * User change: 
	 * Description:
	 **/
	private function CheckUser($id=null)
	{
		$sql_user = "select id from user where id=".$id;
		$user_exist = Yii::app()->db->createCommand($sql_user)->queryRow();
		if($user_exist)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
}