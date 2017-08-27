<?php

class Adminbase_newsController extends Controller 
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
		
   /*
	* Create Date: 
	* Update Date: 
	* Author: 
	* User change: 
	* Description:
	**/
	public function actionIndex()
	{
		$model=new Base_news();
		if (Yii::app()->request->isAjaxRequest) 
		{
            if(isset($_GET['base_id']))
			{
				$base_id=$_GET['base_id'];
				$unit_info = Yii::app()->db->createCommand()
					->select('catchphrase,introduction')
					->from('unit') 
					->where("active_flag=1 and id=$base_id")
					->queryRow();
												
			   
				if(!is_null($unit_info)  && !empty($unit_info))
				{
                                    $unit_info['catchphrase']=  FunctionCommon::url_henkan($unit_info['catchphrase']);
                                    $unit_info['introduction']=  FunctionCommon::url_henkan($unit_info['introduction']);
                    echo CJSON::encode($unit_info);
                }
                else
				{
                    echo "[]";
                }
            }
            Yii::app()->end();
        }
		
	    if (Yii::app()->request->isPostRequest) 
		{ 
            CActiveForm::validate($model);
            if ($model->validate()) 
			{  
				
                $model->id=$_POST['Basenews_id'];
				$model->pickup_date=$_POST['pickup_date'];
				if(Unit::model()->findByPk($model->base_id)) 
				{
					if(!empty($model->id))
					{
						$model->isNewRecord = false;
					}
					if($model->save())
					{
						$model->id="";	
						$model->base_id="";
					}
					
				}	
            }	
			
        }
	    $parmas['model']=$model;       
        $this->render('/admin/base_news/index', $parmas);
    }
}