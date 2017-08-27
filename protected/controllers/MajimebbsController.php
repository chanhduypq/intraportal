<?php

class MajimebbsController extends Controller {

	public $pageTitle;
    private $_bbs = null;
    private $_model;

    public function init() {
        parent::init();
		$this->pageTitle="ニューギン掲示板 | ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null") {
            $this->redirect(array('newgin/'));
        }
    }

    /**
     * display list bbs
     */
    public function actionIndex() {

        $page = isset($_GET['page']) ? $_GET['page'] : '';
        $cookie = new CHttpCookie('page', $page);
        Yii::app()->request->cookies['page'] = $cookie;

        $criteria = new CDbCriteria();
        $criteria->select = 'id,title,created_date';
        $criteria->condition = (FunctionCommon::isPostFunction("bbs") && !FunctionCommon::isViewFunction("bbs")) ? "contributor_id=" . Yii::app()->request->cookies['id'] : "true";
        $criteria->order = 'created_date DESC';

        $item_count = Bbs::model()->count($criteria);
        $pages = new CPagination($item_count);
        $pages->pageSize = Yii::app()->params['listPerPage'];
        $pages->applyLimit($criteria);

        $bbss = Bbs::model()->findAll($criteria);
        
        $bbs_comments=Yii::app()->db->createCommand("select * from bbs_response order by created_date ASC")->queryAll();
        $this->render('/majime/bbs/index', array(
            'bbs_comments' => $bbs_comments,
            'pages' => $pages,
            'bbss' => $bbss
        ));
    }

    /**
     * Regist 
     */
    public function actionRegist() {

		$this->pageTitle="ニューギン掲示板 - 投稿 | ニューギンスクエア";
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
        $this->render('/majime/bbs/regist', $parmas);
    }

    /**
     * Regist confirm
     */
    public function actionRegistconfirm() {
		$this->pageTitle="ニューギン掲示板 - 確認 | ニューギンスクエア";
        $model = $this->loadModel();
        if (Yii::app()->request->isPostRequest) {
            CActiveForm::validate($model);
            if (!isset($_POST['regist']) || $_POST['regist'] != '1') {

               
                Upload_file_common_new::processAttachments($model,'bbs',1);
            }
            if ($model->validate()) {
                if (isset($_POST['regist']) && $_POST['regist'] == '1') {
                    $model->attachment1 = $_POST['Bbs']['attachment1'];
                    $model->attachment2 = $_POST['Bbs']['attachment2'];
                    $model->attachment3 = $_POST['Bbs']['attachment3'];
                    if ($model->save() == true) {
                        if (FunctionCommon::isViewFunction("bbs") == false) {
                            $this->redirect(array('majime/'));
                        } else {
                            $this->redirect(array('majimebbs/index'));
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
                $this->redirect(array('majimebbs/regist'));
            }
        }else{
            $this->redirect(array('majimebbs/index'));
        }
        $this->render('/majime/bbs/registconfirm', array('model' => $model));
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
     * delete file fordel
     */
    public function actionDeleteattechmentsEdit() {
        if (Yii::app()->request->isAjaxRequest) {
            $no = Yii::app()->request->getParam('no');
            if ($no == '1') {
                $attachment1 = Yii::app()->request->getParam('attachment1');
                $attachment2 = Yii::app()->request->getParam('attachment2');
                $attachment3 = Yii::app()->request->getParam('attachment3');
                $id = Yii::app()->request->getParam('id');
                if ($attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment1)) {
                    if ($attachment1 != Upload_file_common::getAttachmentById($id, 1, 'bbs')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment1);
                    }
                }
                if ($attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment2)) {
                    if ($attachment2 != Upload_file_common::getAttachmentById($id, 2, 'bbs')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment2);
                    }
                }
                if ($attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment3)) {
                    if ($attachment3 != Upload_file_common::getAttachmentById($id, 3, 'bbs')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment3);
                    }
                }
            }
        }
    }

    /**
     * Detail id bbs & view comment table bbs response width id bbs
     */
    public function actionDetail() {

        $model = $this->loadModel();
        $bbs_comments = Bbs_response::model()->findAll('bbs_id=:id', array('id' => $_GET['id']));
        $bbs_response = new Bbs_response;
        $user = User::model()->findAll();
        if (!empty($model->title)) {
            if (Yii::app()->request->isAjaxRequest) {
                echo CActiveForm::validate($bbs_response);
                Yii::app()->end();
            }
            if (Yii::app()->request->isPostRequest) {
                CActiveForm::validate($bbs_response);
                if ($bbs_response->validate()) {

                    if ($model->saveBbs_response($bbs_response)) {
                        $this->refresh();
                    }
                }
            }
            $this->render('/majime/bbs/detail', array(
                'model' => $model,
                'bbs_response' => $bbs_response,
                'bbs_comments' => $bbs_comments,
                'user' => $user,
                    )
            );
        } else {
            $this->redirect(array('/majimebbs/index'));
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
            $file_path = Upload_file_common::getAttachmentById($_GET['id'], $attachment_index, 'bbs');
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
        if ($this->_bbs === null) {
            if (isset($_GET['id'])) {
                $this->_bbs = Bbs::model()->findbyPk(intval($_GET['id']));
            } else {
                $this->_bbs = new Bbs();
            }
        }
        return $this->_bbs;
    }

    /**
     * check id bbs
     */
    public function actionCheckId() {
        $id = $_POST['id'];
        $row = 0;
        $id_bbs = Yii::app()->db->createCommand("select * from bbs where id=" . $id)->queryRow();
        if ($id_bbs['id'] == "") {
            $row = 1;
        }
        echo $row;
    }

    public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('bbs_regist_from') ? Yii::app()->request->cookies['bbs_regist_from']->value : '';

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