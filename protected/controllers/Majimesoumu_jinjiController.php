<?php

class Majimesoumu_jinjiController extends Controller {    

	public $pageTitle;
    private $_soumu_jinji = null;
	public function init()
	{
        parent::init();
		$this->pageTitle="総務からのお知らせ：人事情報 | ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id']=="null" ) {
         	$this->redirect(array('newgin/'));
        }
    }
	
	 /**
     * display list soumu_jinji
     */
    public function actionIndex() {
		

	    $criteria = new CDbCriteria();
		$category = Category::model()->findAll();
		$criteria->select = '*';
		$criteria->condition=(FunctionCommon::isPostFunction("soumu_jinji")&&!FunctionCommon::isViewFunction("soumu_jinji"))?"contributor_id=".Yii::app()->request->cookies['id']:"true";
		$criteria->order ='created_date DESC';
		
		$item_count = Soumu_jinji::model()->count($criteria); 
		$pages = new CPagination($item_count);         
		$pages->pageSize = Yii::app()->params['listPerPage'];
		$pages->applyLimit($criteria);	
		
		$soumu_jinji = Soumu_jinji::model()->findAll($criteria);
		$this->render('/majime/soumu_jinji/index',array(
											'soumu_jinji'=>$soumu_jinji,
											'pages' => $pages,
											'category'=>$category));
    }
	
	 /**
     * load model
     */
    public function loadModel() {
        if ($this->_soumu_jinji === null) {
            if (isset($_GET['id'])) {
                $this->_soumu_jinji = Soumu_jinji::model()->findbyPk(intval($_GET['id']));
            } else {
                $this->_soumu_jinji = new Soumu_jinji();
            }
        }
        return $this->_soumu_jinji;
    }
	
}