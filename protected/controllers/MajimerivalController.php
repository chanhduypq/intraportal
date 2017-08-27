<?php

/*
 * Create Date: 17/07/2013
 * Update Date: 24/07/2013
 * Author: Hungtc
 * User change: Hungtc
 * Description: Majime action index object from model Rival  
 * */

class MajimerivalController extends Controller {

	public $pageTitle;
    private $_rival = null;
    public function actionCheckid() {
        $id = $_POST['id'];
        $row = 0;
        $id_bbs = Yii::app()->db->createCommand("select * from rival where id=" . $id)->queryRow();
        if ($id_bbs['id'] == "") {
            $row = 1;
        }
        echo $row;
    }

    public function loadModel() {
        if ($this->_rival === null) {
            if (isset($_GET['id'])) {
                $this->_rival = Rival::model()->findbyPk(intval($_GET['id']));
            } else {
                $this->_rival = new Rival();
            }
        }
        return $this->_rival;
    }

    //check if logined or not
    public function init() {
        parent::init();
		$this->pageTitle="競合情報 | ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null") {
            $this->redirect(array('newgin/'));
        }
    }

    //fix back browsers
    public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('rival_regist_from') ? Yii::app()->request->cookies['rival_regist_from']->value : '';

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

    public function actionIndex() {

        //set cookie
        $page = isset($_GET['page']) ? $_GET['page'] : '';
        $cookie = new CHttpCookie('page', $page);
        Yii::app()->request->cookies['page'] = $cookie;

        $criteria = new CDbCriteria();
        $criteria->select = 'id,title,created_date';
        $criteria->condition = (FunctionCommon::isPostFunction("rival") && !FunctionCommon::isViewFunction("rival")) ? "contributor_id=" . Yii::app()->request->cookies['id'] : "true";
        $criteria->order = 'created_date DESC';

        $item_count = Rival::model()->count($criteria);
        $pages = new CPagination($item_count);
        $pages->pageSize = Yii::app()->params['listPerPage'];
        $pages->applyLimit($criteria);

        $model = Rival::model()->findAll($criteria);
        $rival_comments = Rival_response::model()->findAll();
        $this->render('/majime/rival/index', array('model' => $model, 'pages' => $pages,'rival_comments' => $rival_comments,));
    }

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
        $this->render('/majime/rival/regist', $parmas);
    }

    public function actionRegistConfirm() {
        $model = $this->loadModel();
        if (!empty($_POST['Rival']['title'])) {
            if (Yii::app()->request->isPostRequest) {
                CActiveForm::validate($model);
                if (!isset($_POST['regist']) || $_POST['regist'] != '1') {

                    Upload_file_common_new::processAttachments($model, 'rival', 1);
                }
                if ($model->validate()) {
                    if (isset($_POST['regist']) && $_POST['regist'] == '1') {
                        $model->attachment1 = $_POST['Rival']['attachment1'];
                        $model->attachment2 = $_POST['Rival']['attachment2'];
                        $model->attachment3 = $_POST['Rival']['attachment3'];
                        if ($model->save() == true) {
                            if (FunctionCommon::isViewFunction("rival") == false) {
                                $this->redirect(array('majime/'));
                            } else {
                                $this->redirect(array('majimerival/index'));
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
                    $this->redirect(array('majimerival/regist'));
                }
            }
        } else {
            $this->redirect(array('/majimerival/index'));
        }
        $this->render('/majime/rival/registconfirm', array('model' => $model));
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

    public function actionDetail() {
        
        $rival_comments=Yii::app()->db->createCommand("select * from rival_response where rival_id=".$_GET['id']." order by created_date ASC")->queryAll();
        
        $rival_response = new Rival_response();
        $user = User::model()->findAll();
        $model = $this->loadModel();
        if (count($model) > 0) {
            if (Yii::app()->request->isAjaxRequest) {
                echo CActiveForm::validate($rival_response);
                Yii::app()->end();
            }
            if (Yii::app()->request->isPostRequest) {
                CActiveForm::validate($rival_response);
                if ($rival_response->validate()) {

                    if ($model->saveRival_response($rival_response)) {
                        $this->refresh();
                    }
                }
            }
            $this->render('/majime/rival/detail', array(
                'model' => $model,
                'rival_response' => $rival_response,
                'rival_comments' => $rival_comments,
                'user' => $user,
                    )
            );
            
        } else {
            $this->redirect(array('majimerival/index'));
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
            $file_path = Upload_file_common::getAttachmentById($_GET['id'], $attachment_index, 'rival');
        } else {//download from registconfirm
            $file_path = $_GET['file_name'];
        }
        Yii::import('ext.helpers.EDownloadHelper');
        EDownloadHelper::download(Yii::getPathOfAlias('webroot') . $file_path);
        exit;
    }

}