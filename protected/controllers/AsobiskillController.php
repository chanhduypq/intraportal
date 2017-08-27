<?php

class AsobiskillController extends Controller {

	public $pageTitle;
    private $_skill = null;
    private $_model;

    public function init() {
        parent::init();
		$this->pageTitle="資格取得・スキルアップ！ | ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null") {
            $this->redirect(array('newgin/'));
        }
    }

    /**
     * display list skill
     */
    public function actionIndex() {

        $page = isset($_GET['page']) ? $_GET['page'] : '';
        $cookie = new CHttpCookie('page', $page);
        Yii::app()->request->cookies['page'] = $cookie;

        $criteria = new CDbCriteria();
		$category = Category::model()->findAll();
        $criteria->select = '*';
        $criteria->condition = (FunctionCommon::isPostFunction("skill") && !FunctionCommon::isViewFunction("skill")) ? "contributor_id=" . Yii::app()->request->cookies['id'] : "true";
        $criteria->order = 'created_date DESC';

        $item_count = Skill::model()->count($criteria);
        $pages = new CPagination($item_count);
        $pages->pageSize = Yii::app()->params['listPerPage'];
        $pages->applyLimit($criteria);

        $skills = Skill::model()->findAll($criteria);

        $this->render('/asobi/skill/index', array(
            'pages' => $pages,
			'category'=>$category,
            'skills' => $skills
        ));
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
            $file_path = Upload_file_common::getAttachmentById($_GET['id'], $attachment_index, 'skill');
        } else {//download from registconfirm
            $file_path = $_GET['file_name'];
        }
        Yii::import('ext.helpers.EDownloadHelper');
        EDownloadHelper::download(Yii::getPathOfAlias('webroot') . $file_path);
        exit;
    }

    /**
     * loadModel
     */
    public function loadModel() {
        if ($this->_skill === null) {
            if (isset($_GET['id'])) {
                $this->_skill = Skill::model()->findbyPk(intval($_GET['id']));
            } else {
                $this->_skill = new Skill();
            }
        }
        return $this->_skill;
    }

    

}