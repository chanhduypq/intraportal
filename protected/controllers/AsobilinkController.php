<?php
class AsobilinkController extends Controller
{
	public $pageTitle;
   //check if logined or not
   public function init()
   {
        parent::init();
		$this->pageTitle="資格取得・スキルアップ！ | ニューギンスクエア";
        if(Yii::app()->request->cookies['id'] =="")
		{ 
			$this->redirect(Yii::app()->baseUrl.'/index.php');
        }
    } 
	
	/** Create Date:20130912
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:action index get all object in slink  
     * */ 
	public function actionIndex()
	{
		$criteria = new CDbCriteria();
		$criteria->select = '*';
		$criteria->condition=(FunctionCommon::isPostFunction("category")&&!FunctionCommon::isViewFunction("category"))?"contributor_id=".Yii::app()->request->cookies['id']:"true";
      	$criteria->condition="id IN(select category_id from slink)";
		$criteria->order ='category_name asc';
		
		$model = Category::model()->findAll($criteria);
		$this->render('/asobi/link/index',array('model'=>$model));
	}
	
}
?>