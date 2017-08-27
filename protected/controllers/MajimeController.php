<?php
class MajimeController extends Controller
{
	public $pageTitle;
	public function init() 
	{
        parent::init();
		$this->pageTitle="ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id']=="null" ) {
         	$this->redirect(array('newgin/'));
        }
          
    }
	public function actionIndex()
	{
		$cookie = new CHttpCookie('beforelink', "majime");
		Yii::app()->request->cookies['beforelink'] = $cookie;
        $this->render('index');
	}
	
}
