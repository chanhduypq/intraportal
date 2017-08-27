<?php

class MajimeideasController extends Controller {

	public $pageTitle;
    private $_ideas = null;
    private $_model;

    public function init() {
        parent::init();
		$this->pageTitle="製品アイデア投稿広場 | ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null") {
            $this->redirect(array('newgin/'));
        }
    }

    /**
     * display list ideas
     */
    public function actionIndex() {

        //set cookie
        $page = isset($_GET['page']) ? $_GET['page'] : '';
        $cookie = new CHttpCookie('page', $page);
        Yii::app()->request->cookies['page'] = $cookie;

        $criteria = new CDbCriteria();
        $criteria->select = 'id,title,created_date';
        $criteria->condition = (FunctionCommon::isPostFunction("ideas") && !FunctionCommon::isViewFunction("ideas")) ? "contributor_id=" . Yii::app()->request->cookies['id'] : "true";
        $criteria->order = 'created_date DESC';

        $item_count = Ideas::model()->count($criteria);
        $pages = new CPagination($item_count);
        $pages->pageSize = Yii::app()->params['listPerPage'];
        $pages->applyLimit($criteria);

        $ide = Ideas::model()->findAll($criteria);
        $ideas_comments = Ideas_comment::model()->findAll();
        $this->render('/majime/ideas/index', array(
            'ideas_comments' => $ideas_comments,
            'pages' => $pages,
            'ide' => $ide
        ));
    }

    /**
     * Regist 
     */
    public function actionRegist() {
        $parmas = array();
        $model = $this->loadModel();
        if (Yii::app()->request->isAjaxRequest) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        $attachment1_error = isset(Yii::app()->session['attachment1']) ? Yii::app()->params['attachment1_error'] : '';
        $attachment2_error = isset(Yii::app()->session['attachment2']) ? Yii::app()->params['attachment2_error'] : '';
        $attachment3_error = isset(Yii::app()->session['attachment3']) ? Yii::app()->params['attachment3_error'] : '';
        unset(Yii::app()->session['attachment1']);
        unset(Yii::app()->session['attachment2']);
        unset(Yii::app()->session['attachment3']);
        $parmas['model'] = $model;
        $parmas['attachment1_error'] = $attachment1_error;
        $parmas['attachment2_error'] = $attachment2_error;
        $parmas['attachment3_error'] = $attachment3_error;
        $this->render('/majime/ideas/regist', $parmas);
    }

    /**
     * Regist confirm
     */
    public function actionRegistconfirm() {
        $model = $this->loadModel();
        if (Yii::app()->request->isPostRequest) {
            CActiveForm::validate($model);
            if (!isset($_POST['regist']) || $_POST['regist'] != '1') {

                Upload_file_common_new::processAttachments($model, 'ideas', 1);
            }
            if ($model->validate()) {
                if (isset($_POST['regist']) && $_POST['regist'] == '1') {
                    $model->attachment1 = $_POST['Ideas']['attachment1'];
                    $model->attachment2 = $_POST['Ideas']['attachment2'];
                    $model->attachment3 = $_POST['Ideas']['attachment3'];
                    if ($model->save() == true) {
                        if (FunctionCommon::isViewFunction("ideas") == false) {
                            $this->redirect(array('majime/'));
                        } else {
                            $this->redirect(array('majimeideas/index'));
                        }
                    }
                }
            } else {
                if ($model->getError("attachment1") != "") {
                    Yii::app()->session['attachment1'] = true;
                }

                if ($model->getError("attachment2") != "") {
                    Yii::app()->session['attachment2'] = true;
                }

                if ($model->getError("attachment3") != "") {
                    Yii::app()->session['attachment3'] = true;
                }
                /**
                 * 
                 */
                if ($model->attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment1)) {
                    unlink(Yii::getPathOfAlias('webroot') . $model->attachment1);
                }
                if ($model->attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment2)) {
                    unlink(Yii::getPathOfAlias('webroot') . $model->attachment2);
                }
                if ($model->attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment3)) {
                    unlink(Yii::getPathOfAlias('webroot') . $model->attachment3);
                }
                $cookie_collection = Yii::app()->request->cookies;
                $key_array = $cookie_collection->getKeys();
                for ($i = 0, $n = count($key_array); $i < $n; $i++) {
                    $key = $key_array[$i];
                    if (substr($key, 0, 4) == 'file') {
                        if (Yii::app()->request->cookies[$key] != "" && Yii::app()->request->cookies[$key] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value)) {
                            unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value);
                        }
                        unset(Yii::app()->request->cookies[$key]);
                    }
                }
                $this->redirect(array('majimeideas/regist'));
            }
        }else{
            $this->redirect(array('majimeideas/index'));
        }
        $this->render('/majime/ideas/registconfirm', array('model' => $model));
    }

    /**
     * delete file fordel
     */
    public function actionDeleteattechments() {
        if (Yii::app()->request->isAjaxRequest) {
            $no = Yii::app()->request->getParam('no');
            if ($no == '1') {
                $attachment1 = Yii::app()->request->getParam('attachment1');
                $attachment2 = Yii::app()->request->getParam('attachment2');
                $attachment3 = Yii::app()->request->getParam('attachment3');
                if ($attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment1)) {
                    unlink(Yii::getPathOfAlias('webroot') . $attachment1);
                }
                if ($attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment2)) {
                    unlink(Yii::getPathOfAlias('webroot') . $attachment2);
                }
                if ($attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment3)) {
                    unlink(Yii::getPathOfAlias('webroot') . $attachment3);
                }
            }
        }
    }

    /**
     * Detail id ideas & view valuation table ideas comment width id ideas
     */
    public function actionDetail() {

        $model = $this->loadModel();        
        $ideas_list_comments=Yii::app()->db->createCommand("select * from ideas_comment where ideas_id=".$_GET['id']." order by created_date ASC")->queryAll();
        $ideas_comment = new Ideas_comment;
        $user = User::model()->findAll();
        if (!empty($model->title)) {
            if (Yii::app()->request->isAjaxRequest) {
                echo CActiveForm::validate($ideas_comment);
                Yii::app()->end();
            }
            if (Yii::app()->request->isPostRequest) {
                CActiveForm::validate($ideas_comment);
                if ($ideas_comment->validate()) {

                    if ($model->saveIdeas_comment($ideas_comment)) {
                        $this->refresh();
                    }
                }
            }
            $this->render('/majime/ideas/detail', array(
                'model' => $model,
                'ideas_comment' => $ideas_comment,
                'ideas_list_comments' => $ideas_list_comments,
                'user' => $user,
                    )
            );
        } else {
            $this->redirect(array('/majimeideas/index'));
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
            $file_path = Upload_file_common::getAttachmentById($_GET['id'], $attachment_index, 'ideas');
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
        if ($this->_ideas === null) {
            if (isset($_GET['id'])) {
                $this->_ideas = Ideas::model()->findbyPk(intval($_GET['id']));
            } else {
                $this->_ideas = new Ideas();
            }
        }
        return $this->_ideas;
    }

    /**
     * check id criticism
     */
    public function actionCheckId() {
        $id = $_POST['id'];
        $row = 0;
        $ideas_id = Yii::app()->db->createCommand("select * from ideas where id=" . $id)->queryRow();
        if ($ideas_id['id'] == "") {
            $row = 1;
        }
        echo $row;
    }

    public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('ideas_regist_from') ? Yii::app()->request->cookies['ideas_regist_from']->value : '';

        if ($backCookie != "" && $backCookie != NULL && $backCookie != "null") {
            return array(
                array('application.extensions.PerformanceFilter - regist'),
            );
        } else {
            return array(
                'accessControl',
            );
        }
    }

}