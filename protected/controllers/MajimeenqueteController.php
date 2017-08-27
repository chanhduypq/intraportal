<?php

class MajimeenqueteController extends Controller {

	public $pageTitle;
    private $_enquete = null;

    /**
     * 
     */
    public function init() {
        parent::init();
		$this->pageTitle="みんなのアンケートBOX | ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null") {
            $this->redirect(array('newgin/'));
        }
    }

    /*     * Create Date:23/07/2012
     * Update Date:
     * Author:
     * User change:
     * Description: display list enquete object
     * */

    public function actionIndex() {
        //set cookie
        $page = isset($_GET['page']) ? $_GET['page'] : '';
        $cookie = new CHttpCookie('page', $page);
        Yii::app()->request->cookies['page'] = $cookie;

        $criteria = new CDbCriteria();
        $criteria->select = 'id,title,created_date,deadline';
        $criteria->condition = (FunctionCommon::isPostFunction("enquete") && !FunctionCommon::isViewFunction("enquete")) ? "contributor_id=" . Yii::app()->request->cookies['id'] : "true";
        $criteria->order = 'created_date DESC';

        $item_count = Enquete::model()->count($criteria);
        $pages = new CPagination($item_count);
        $pages->pageSize = Yii::app()->params['listPerPage'];
        $pages->applyLimit($criteria);

        $model = Enquete::model()->findAll($criteria);
        $this->render('/majime/enquete/index', array(
            'model' => $model,
            'pages' => $pages
                )
        );
    }

    /*     * Create Date:23/07/2012
     * Update Date:
     * Author:
     * User change:
     * Description: display detail enquete object
     * */

    public function actionDetail($id = null) {
        $model = $this->loadModel();
        if (count($model) > 0 && strtotime($model->deadline) >= strtotime(date("Y-m-d"))) {
            $id_user_login = Yii::app()->request->cookies['id']->value; //var_dump( $id_user_login);exit;//check user anser 
            $check_user_anser = "select id from enquete_result where respondent_id=" . $id_user_login;
            $check_user_anser = Yii::app()->db->createCommand($check_user_anser)->queryScalar(); //var_dump($check_user_anser);exit;
            if ($check_user_anser) {
                $user_anser = 1; //have anser
            } else {
                $user_anser = 0; //not any anser
            }
            $answers = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('enquete_choice')
                    ->where("enquete_id=$id")
                    ->queryAll();
            $now = FunctionCommon::getDateTimeSys();
            $last_updated_person = FunctionCommon::getEmplNum();
            if (isset($_POST) && isset($_POST['anser'])) {
                //once answers
                $model_anser = new Enquete_result();
                $model_anser->choice_id = $_POST['anser'];
                $model_anser->respondent_id = $id_user_login;
                $model_anser->created_date = $now;
                $model_anser->last_updated_date = $now;
                $model_anser->last_updated_person = $last_updated_person;
                $model_anser->save();
            }
            if (isset($_POST)) {
                for ($i = 1; $i <= count($answers); $i++) {      //many answers
                    if (isset($_POST["anser" . $i])) {
                        $model_anser = new Enquete_result();     //create new record for every anser
                        $model_anser->choice_id = $_POST["anser" . $i];
                        $model_anser->respondent_id = $id_user_login;
                        $model_anser->created_date = $now;
                        $model_anser->last_updated_date = $now;
                        $model_anser->last_updated_person = $last_updated_person;
                        $model_anser->save();
                    }
                }
            }
            $this->render('/majime/enquete/detail', array('answers' => $answers, 'model' => $model));
        } else {
            $this->redirect(array('majime/'));
            //$this->redirect(array('majimeenquete/index'));
        }
    }

    /*     * Create Date:23/07/2012
     * Update Date:
     * Author:
     * User change:
     * Description: display result detail enquete object
     * */

    public function actionDetail_result($id = null) {
        $model = $this->loadModel();
        $today = date("Y-m-d");
        if (count($model) > 0 && strtotime($today) > strtotime($model->deadline)) {
            $id = $_GET['id'];
            $enquete_choice = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('enquete_choice')
                    ->where("enquete_id=$id")
                    ->queryAll();
            $this->render('/majime/enquete/detail_result', array('model' => $model, 'enquete_choice' => $enquete_choice));
        } else {
            $this->redirect(array('majime/'));
            //$this->redirect(array('majimeenquete/index'));
        }
    }

    /*     * Create Date:23/07/2012
     * Update Date:
     * Author:
     * User change:
     * Description: regist enquete object
     * */

    public function actionRegist() 
	{
        $model = new Enquete();
        $model->deadline_year = date("Y");
        $model->deadline_month = date('n');
        $model->deadline_day = date('j');
        $model->answer_type = 1;
        $parmas = array();
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

        $parmas['attachment1_error'] = $attachment1_error;
        $parmas['attachment2_error'] = $attachment2_error;
        $parmas['attachment3_error'] = $attachment3_error;
        $parmas['model'] = $model;

        $this->render('/majime/enquete/regist', $parmas);
    }

    /*     * Create Date:23/07/2012
     * Update Date:
     * Author:
     * User change:
     * Description: confirm regist enquete object
     * */

    public function actionConfirm() 
	{

        $model = new Enquete();
        if (Yii::app()->request->isPostRequest) 
		{

            CActiveForm::validate($model);

            if (!isset($_POST['regist']) || $_POST['regist'] != '1') {
                $model->answer_content_array = CJSON::encode($_POST['anser']);
                Upload_file_common_new::processAttachments($model, 'enquete', 1);
            }
            if ($model->validate()) {
                if (isset($_POST['regist']) && $_POST['regist'] == '1') {
                    $model->attachment1 = $_POST['Enquete']['attachment1'];
                    $model->attachment2 = $_POST['Enquete']['attachment2'];
                    $model->attachment3 = $_POST['Enquete']['attachment3'];
                    $model->deadline = $model->deadline_year . '-' . $model->deadline_month . '-' . $model->deadline_day;

                    $answer_content_array = CJSON::decode($model->answer_content_array);

                    $now = FunctionCommon::getDateTimeSys();
                    $last_updated_person = FunctionCommon::getEmplNum();
                    $contributor_id = Yii::app()->request->cookies['id'];

                    if ($model->save() == true) {
                        $enquete_id = $model->id;
                        foreach ($answer_content_array as $key => $value) {
                            if ($value) {
                                $model_enquete_choice = new Enquete_choice();
                                $model_enquete_choice->enquete_id = $enquete_id;
                                $model_enquete_choice->answer_content = trim($value);
                                $model_enquete_choice->contributor_id = $contributor_id;
                                $model_enquete_choice->created_date = $now;
                                $model_enquete_choice->last_updated_date = $now;
                                $model_enquete_choice->last_updated_person = $last_updated_person;
                                $model_enquete_choice->save();
                            }
                        }
                        if (FunctionCommon::isViewFunction("enquete") == false) {
                            $this->redirect(array('majime/'));
                        } else {
                            $this->redirect(array('majimeenquete/index'));
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
                $this->redirect(array('majimeenquete/regist'));
            }
        }
		else
		{
            $this->redirect(array('majimeenquete/index'));
        }

        $this->render('/majime/enquete/confirm', array('model' => $model));
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

    /*     * Create Date:23/07/2012
     * Update Date:
     * Author:
     * User change:
     * Description:Method using load model enquete
     * */

    public function loadModel() {
        if ($this->_enquete === null) {
            if (isset($_GET['id'])) {
                $this->_enquete = Enquete::model()->findbyPk(intval($_GET['id']));
            } else {
                $this->_enquete = new Enquete();
            }
        }
        return $this->_enquete;
    }

    /*     * Create Date:23/07/2012
     * Update Date:
     * Author:
     * User change:
     * Description: process file upload
     * */

    private function processAttachments($model) {
        if ($file = CUploadedFile::getInstance($model, 'attachment1')) {
            $file_name = $file->name;
            $model->attachment1_file_name = $file->name;
            $model->attachment1_file_bytes = base64_encode(file_get_contents($file->tempName));
            $model->attachment1_file_type = $file->type;
        } else {
            $model->attachment1_file_name = '';
        }
        if ($file = CUploadedFile::getInstance($model, 'attachment2')) {
            $file_name = $file->name;
            $model->attachment2_file_name = $file->name;
            $model->attachment2_file_bytes = base64_encode(file_get_contents($file->tempName));
            $model->attachment2_file_type = $file->type;
        } else {
            $model->attachment2_file_name = '';
        }
        if ($file = CUploadedFile::getInstance($model, 'attachment3')) {
            $file_name = $file->name;
            $model->attachment3_file_name = $file->name;
            $model->attachment3_file_bytes = base64_encode(file_get_contents($file->tempName));
            $model->attachment3_file_type = $file->type;
        } else {
            $model->attachment3_file_name = '';
        }
    }

    /*     * Create Date:23/07/2012
     * Update Date:
     * Author:
     * User change:
     * Description: download file upload
     * */

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
            $file_path = Upload_file_common::getAttachmentById($_GET['id'], $attachment_index, 'enquete');
        } else {//download from registconfirm
            $file_path = $_GET['file_name'];
        }
        Yii::import('ext.helpers.EDownloadHelper');
        EDownloadHelper::download(Yii::getPathOfAlias('webroot') . $file_path);
        exit;
    }

    //fix back browsers
    public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('enquete_regist_from') ? Yii::app()->request->cookies['enquete_regist_from']->value : '';
        if ($backCookie != "" || $backCookie != NULL) {
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

?>