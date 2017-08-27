<?php

class Majimepresident_msgController extends Controller {    

	public $pageTitle;
    private $_president_msg = null;
	public function init() {
        parent::init();
		$this->pageTitle="新井社長メッセージ | ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id']=="null" ) {
         	$this->redirect(array('newgin/'));
        }
        
    }
	/**
     * display list president_msg
     */
    public function actionIndex() {
		
	
		$criteria = new CDbCriteria();
		$criteria->select = 'id,title,created_date,attachment3,attachment2,attachment1';
		$criteria->condition=(FunctionCommon::isPostFunction("president_msg")&&!FunctionCommon::isViewFunction("president_msg"))?"contributor_id=".Yii::app()->request->cookies['id']:"true";
		$criteria->order ='created_date DESC';
		
		$item_count = President_msg::model()->count($criteria); 
		$pages = new CPagination($item_count);         
		$pages->pageSize = Yii::app()->params['listPerPage'];
		$pages->applyLimit($criteria);	
		
		$president_msgs 	= President_msg::model()->findAll($criteria);	
		$this->render('/majime/president_msg/index',array(
										'pages' => $pages,
										'president_msgs' => $president_msgs
										));  

    }
 	
   /**
     * Detail id bbs 
     */
    public function actionDetail() {
		$model 	  = $this->loadModel();
		if(!empty($model->title))
		{ 
			
			$this->render('/majime/president_msg/detail', array(
				'model' => $model,
					)
			);
		}
		else{
					$this->redirect(array('/majimepresident_msg/index'));
			}
    } 
	/**
     * Download attachment
     */
    public function actionDownload() {
    	$model=$this->loadModel();
    	if(isset($_POST['file_index'])){    		
    		CActiveForm::validate($model);
    		$model->validate();
    		$attachment_id = $_POST['file_index'];
    		if($attachment_id=='1'){
    			$file_name=$model->attachment1_file_name;
    			$file_type=$model->attachment1_file_type;
                        $content=base64_decode($model->attachment1_file_bytes);
    		}
    		else if($attachment_id=='2'){
    			$file_name=$model->attachment2_file_name;
    			$file_type=$model->attachment2_file_type;
    			$content=base64_decode($model->attachment2_file_bytes);
    		}
    		else if($attachment_id=='3'){
    			$file_name=$model->attachment3_file_name;
    			$file_type=$model->attachment3_file_type;
    			$content=base64_decode($model->attachment3_file_bytes);
    		}
 
    		header('Content-Type: '.$file_type);
    		header('Content-Disposition: attachment;filename="'.$file_name.'"');
    		header('Cache-Control: max-age=0');    		
    		echo $content;    		
    	}
    	else{
    		$attachment_id=0;
    		if(isset($_GET['1'])){
    			$attachment_id=1;
    		}
    		else if(isset($_GET['2'])){
    			$attachment_id=2;
    		}
    		else if(isset($_GET['3'])){
    			$attachment_id=3;
    		}
    		if($attachment_id!=0){
    			$file_name=Yii::app()->db->createCommand()
    			->select('attachment'.$attachment_id)
    			->from('president_msg')
    			->where('id=:id',array('id'=>$_GET['id']))
    			->queryScalar();

    			if(file_exists(Yii::getPathOfAlias('webroot').$file_name)){
    				Yii::import('ext.helpers.EDownloadHelper');    				
    				EDownloadHelper::download(Yii::getPathOfAlias('webroot').$file_name);
    			}
    		}
    	}
    	exit;        
    }
	/**
     * loadModel
     */
    public function loadModel() {
        if ($this->_president_msg === null) {
            if (isset($_GET['id'])) {
                $this->_president_msg = President_msg::model()->findbyPk(intval($_GET['id']));
            } else {
                $this->_president_msg = new President_msg();
            }
        }
        return $this->_president_msg;
    }
	
}