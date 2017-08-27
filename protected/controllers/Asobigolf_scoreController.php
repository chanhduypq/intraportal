<?php

class Asobigolf_scoreController extends Controller {    

	public $pageTitle;
    private $_golf_score = null;
	private $_model;
	
	  public function init() {
        parent::init();
		$this->pageTitle="ゴルフもマジメ！年間スコアランキング | ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id']=="null" ) {
          $this->redirect(array('newgin/'));
        }
        
        
    }
	/**
     * display list golf_score
     */
    public function actionIndex() {

		//set cookie
		$page	= isset($_GET['page']) ? $_GET['page'] : '';
		$cookie = new CHttpCookie('page', $page);
		Yii::app()->request->cookies['page'] = $cookie;	
		
		//07/01/2014 baodt
		$criteria 	= new CDbCriteria();
		$criteria->select = 'contributor_id,contributor_id as contributorid, Min(score) as minscore,Min(score) as score, score_name, score_date';
		$criteria->condition=(FunctionCommon::isPostFunction("golf_score")&&!FunctionCommon::isViewFunction("golf_score"))?"contributor_id=".Yii::app()->session['id']:"true";
		$criteria->group ='contributor_id,score_name,score_date';
                $criteria->having='minscore <= (SELECT Min(score) as minscore FROM golf_score where contributor_id=contributorid LIMIT 1)';
		$criteria->order ='score';	
		
		$item_count = Golf_score::model()->count($criteria); 
		$pages 		= new CPagination($item_count);         
		$pages->pageSize = Yii::app()->params['listPerPage'];
		$pages->applyLimit($criteria);	
		
		$ide 		= Golf_score::model()->findAll($criteria);
                if($page==''||$page=='1'){
                    $page='0';
                }
                else{
                    $page--;
                }
		$this->render('/asobi/golf_score/index',array(
										'pages' => $pages,
										'ide' => $ide,
                                                                                'page'=>$page
										));  
    }
    /**
     * Regist 
     */
    public function actionRegist() { 
	
        $parmas 		= array(); 
        $model 			= $this->loadModel();   
		$model->deadline_year	= date("Y");
		$model->deadline_month	= date('n');
		$model->deadline_day	= date('j');      
        if (Yii::app()->request->isAjaxRequest) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        } 
        
        $parmas['model'] = $model;       
        $this->render('/asobi/golf_score/regist', $parmas);
    }
	 /**
     * Regist confirm
     */
    public function actionRegistconfirm()
	{ 
        $model 		= $this->loadModel(); 
        if (Yii::app()->request->isPostRequest)
		{            
			CActiveForm::validate($model);  
			if ($model->validate()) 
			{
				if (isset($_POST['regist']) && $_POST['regist'] == '1') 
				{
					$model->score_date = $model->deadline_year . '-' . $model->deadline_month . '-' . $model->deadline_day.' '.date('H:i:s');                  
					$now = date('Y-m-d H:i:s');
					$model->created_date = $now;  
					$model->last_updated_date = $now; 
					if ($model->save())
					{                        
						if(FunctionCommon::isViewFunction("golf_score")==false)
						{
							$this->redirect(array('asobi/'));
						}
						else
						{
							$this->redirect(array('asobigolf_score/index'));
						}	
					}
				}
			} 	
		}
        $this->render('/asobi/golf_score/registconfirm', array('model' => $model));
    } 
	
	/**
     * loadModel
     */
    public function loadModel() {
        if ($this->_golf_score === null) {
            if (isset($_GET['id'])) {
                $this->_golf_score = Golf_score::model()->findbyPk(intval($_GET['id']));
            } else {
                $this->_golf_score = new Golf_score();
            }
        }
        return $this->_golf_score;
    }
	
	public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('golf_score_regist_from') ? Yii::app()->request->cookies['golf_score_regist_from']->value : '';

        if( $backCookie !="" && $backCookie != NULL && $backCookie !="null" ){
            return array(
                array('application.extensions.PerformanceFilter - regist'),
            );
        } else {
            return array(
                'accessControl',
            );
        }
    }
	/**
     * check score golf_score 07/01/2014
     */
    public function actionCheckScore() {
		$postscore     = $_POST['score'];
		$contributor_id     = $_POST['contributor_id'];
        $row 	   	   = 0;
        $score = Yii::app()->db->createCommand("select DISTINCT(contributor_id), Min(score) as score from golf_score where contributor_id = '".$contributor_id."'")->queryRow();
       if (!empty($score['score']) && $postscore >= $score['score']) {
            $row = 1;
        }
        echo $row;
    }
}