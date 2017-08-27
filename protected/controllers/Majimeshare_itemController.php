<?php

class Majimeshare_itemController extends Controller {    

	public $pageTitle;
    private $_share_item = null;
	public function init() {
        parent::init();
		$this->pageTitle="共有事項 | ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id']=="null" ) {
         	$this->redirect(array('newgin/'));
        }
 
        
    }
	/**
     * display list president_msg
     */
    public function actionIndex() {
		
		//set cookie page
		$page	=isset($_GET['page']) ? $_GET['page'] : '';
		$cookie = new CHttpCookie('page', $page);
		Yii::app()->request->cookies['page'] = $cookie;	
		
		$criteria 			= new CDbCriteria();
		$criteria->select 	= '*';
		$criteria->condition=(FunctionCommon::isPostFunction("share_item")&&!FunctionCommon::isViewFunction("share_item"))?"contributor_id=".Yii::app()->request->cookies['id']:"true";
		$criteria->order 	='created_date DESC';
		
		$item_count 		= Share_item::model()->count($criteria); 
		$pages 				= new CPagination($item_count);         
		$pages->pageSize	= Yii::app()->params['listPerPage'];
		$pages->applyLimit($criteria);	
		
		$share_items 		= Share_item::model()->findAll($criteria);
		$this->render('/majime/share_item/index',array(
											'share_items'=>$share_items,
											'pages' => $pages)); 
    }
   
	/**
     * Detail id
     */
    public function actionDetail() {
        $model 	  = $this->loadModel();
		if(!empty($model->title))
		{ 
			$this->render('/majime/share_item/detail', array(
				'model' => $model,
					)
			);
		}
		else{
					$this->redirect(array('/majimeshare_item/index'));
			}
    } 
	 /**
     * Download attachment
     */
    public function actionDownload() {
    	 $attachment_index = 0;
        if (isset($_GET['1'])) {
            $attachment_index = 1;
        } else if (isset($_GET['2'])) {
            $attachment_index = 2;
        } else if (isset($_GET['3'])) {
            $attachment_index = 3;
        }
        if ($attachment_index != 0) {//download from detail                   
            $file_path=  Upload_file_common::getAttachmentById($_GET['id'], $attachment_index, 'share_item');
        }
        else{//download from registconfirm
            $file_path = $_GET['file_name'];
        }
        Yii::import('ext.helpers.EDownloadHelper');
        EDownloadHelper::download(Yii::getPathOfAlias('webroot') . $file_path);
        exit;
    }
    public function loadModel() {
        if ($this->_share_item === null) {
            if (isset($_GET['id'])) {
                $this->_share_item = Share_item::model()->findbyPk(intval($_GET['id']));
            } else {
                $this->_share_item = new Share_item();
            }
        }
        return $this->_share_item;
    }
	
}