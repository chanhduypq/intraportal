<?php

class AdminBountyController extends Controller {

	public $pageTitle;
    //check if logined or not
    public function init() {
        parent::init();
		$this->pageTitle="ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null") {
            $this->redirect(array('newgin/'));
        }
    }

    public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('bounty_edit_form') ? Yii::app()->request->cookies['bounty_edit_form']->value : '';
        if (!is_null($backCookie) && !empty($backCookie)) {
            return array(array('application.extensions.PerformanceFilter - edit'),);
        } else {
            return array('accessControl',);
        }
    }

    private $_bounty = null;

    public function loadModel() {
        if ($this->_bounty === null) {
            if (isset($_GET['id'])) {
                $this->_bounty = Bounty::model()->findbyPk(intval($_GET['id']));
            } else if (isset($_POST['Bounty'])) {
                $data = $_POST['Bounty'];
                $id = $data['id'];
                $this->_bounty = Bounty::model()->findbyPk(intval($id));
            } else {
                $this->_bounty = new Bounty();
            }
        }
        return $this->_bounty;
    }

    public function actionDownload() {
        $model = $this->loadModel();
        if (isset($_POST['file_index'])) { //download file from file_bytes  		
            CActiveForm::validate($model);
            /**
             *
             */
            $model->validate();
            /**
             *
             */
            $attachment_id = $_POST['file_index'];
            /**
             *
             */
            if ($attachment_id == '1') {
                $file_name = $model->attachment1_file_name;
                $file_type = $model->attachment1_file_type;
                $content = base64_decode($model->attachment1_file_bytes);
            } else if ($attachment_id == '2') {
                $file_name = $model->attachment2_file_name;
                $file_type = $model->attachment2_file_type;
                $content = base64_decode($model->attachment2_file_bytes);
            } else if ($attachment_id == '3') {
                $file_name = $model->attachment3_file_name;
                $file_type = $model->attachment3_file_type;
                $content = base64_decode($model->attachment3_file_bytes);
            }
            /**
             *
             */
            header('Content-Type: ' . $file_type);
            header('Content-Disposition: attachment;filename="' . $file_name . '"');
            header('Cache-Control: max-age=0');
            echo $content;
        } else {
            //download file from host
            $attachment_id = 0;
            if (isset($_GET['1'])) {
                $attachment_id = 1;
            } else if (isset($_GET['2'])) {
                $attachment_id = 2;
            } else if (isset($_GET['3'])) {
                $attachment_id = 3;
            }
            if ($attachment_id != 0) {
                $file_name = Yii::app()->db->createCommand()
                        ->select('attachment' . $attachment_id)
                        ->from('bounty')
                        ->where('id=:id', array('id' => $_GET['id']))
                        ->queryScalar();
                if ($file_name != "" && file_exists(Yii::getPathOfAlias('webroot') . $file_name)) {
                    Yii::import('ext.helpers.EDownloadHelper');
                    EDownloadHelper::download(Yii::getPathOfAlias('webroot') . $file_name);
                }
            }
        }
        exit;
    }

    public function actionDeleteattechments() {
        if (Yii::app()->request->isAjaxRequest) {
            $no = Yii::app()->request->getParam('no');
            if ($no == '1') {
                $attachment1 = Yii::app()->request->getParam('attachment1');
                $attachment2 = Yii::app()->request->getParam('attachment2');
                $attachment3 = Yii::app()->request->getParam('attachment3');
                $id = Yii::app()->request->getParam('id');
                if ($attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment1)) {
                    if ($attachment1 != Upload_file_common::getAttachmentById($id, 1, 'bounty')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment1);
                    }
                }
                if ($attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment2)) {
                    if ($attachment2 != Upload_file_common::getAttachmentById($id, 2, 'bounty')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment2);
                    }
                }
                if ($attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment3)) {
                    if ($attachment3 != Upload_file_common::getAttachmentById($id, 3, 'bounty')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment3);
                    }
                }
            }
        }
    }

    /*
     * Create Date:20130802
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:Method using check id bounty 
     * */

    public function actionCheckId() {
        $id = $_POST['id'];
        $row = 0;
        $object = Yii::app()->db->createCommand("select * from bounty where id=" . $id)->queryRow();
        if (!empty($object['id'])) {
            $row = 1;
        }
        echo $row;
    }

    public function actionIndex() {

      // set cookie page
        $page = isset($_GET['page']) ? $_GET['page'] : '';
        $cookie = new CHttpCookie('page', $page);
        Yii::app()->request->cookies['page'] = $cookie;

        $criteria = new CDbCriteria();
        $criteria->select = '*';
        $criteria->condition = FunctionCommon::isAdmin() == FALSE ? "contributor_id=" . Yii::app()->request->cookies['id'] : "true";
        $criteria->order = 'created_date DESC';

        $item_count = Bounty::model()->count($criteria);
        $pages = new CPagination($item_count);
        $pages->pageSize = Yii::app()->params['listPerPage'];
        $pages->applyLimit($criteria);

        $model = Bounty::model()->findAll($criteria);
        $this->render('/admin/bounty/index', array('model' => $model, 'pages' => $pages));
    }

    public function actionDetail($id) {
        $model = $this->loadModel();
        if (count($model) > 0) {
            $this->render('/admin/bounty/detail', array('model' => $model));
        } else {
            $this->redirect(array('/adminbounty/index'));
        }
    }

    public function actionEdit() {
        $parmas = array();
        $model = $this->loadModel();
        if (count($model) > 0) {
            $deadline = explode("/", FunctionCommon::formatDate($model->deadline));
            $model->deadline_day = intval($deadline[2]);
            $model->deadline_month = intval($deadline[1]);
            $model->deadline_year = $deadline[0];

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
            $this->render('/admin/bounty/edit', $parmas);
        } else {
            $this->redirect(array('adminbounty/index'));
        }
    }

    public function actionEditconfirm() {
        $model = $this->loadModel();
        if (Yii::app()->request->isPostRequest) {
            CActiveForm::validate($model);
            if (!isset($_POST['edit']) || $_POST['edit'] != '1') {

                Upload_file_common_new::processAttachments($model, 'bounty', 2);
            }
            if ($model->validate()) {
                if (isset($_POST['edit']) && $_POST['edit'] == '1') {
                    $model->attachment1 = $_POST['Bounty']['attachment1'];
                    $model->attachment2 = $_POST['Bounty']['attachment2'];
                    $model->attachment3 = $_POST['Bounty']['attachment3'];
                    if ($model->save() == true) {
                        if (Yii::app()->request->cookies['page'] != "") {
                            $page = "index?page=" . Yii::app()->request->cookies['page'];
                        } else {
                            $page = "";
                        }
                        $this->redirect(array('adminbounty/' . $page . ''));
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
                /*                 * * */
                if ($model->attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment1)) {
                    if ($model->attachment1 != Upload_file_common::getAttachmentById($model->id, 1, 'bounty')) {
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment1);
                    }
                }
                if ($model->attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment2)) {
                    if ($model->attachment2 != Upload_file_common::getAttachmentById($model->id, 2, 'bounty')) {
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment2);
                    }
                }
                if ($model->attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment3)) {
                    if ($model->attachment3 != Upload_file_common::getAttachmentById($model->id, 3, 'bounty')) {
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment3);
                    }
                }
                $cookie_collection =Yii::app()->request->cookies;           
                $key_array=$cookie_collection->getKeys(); 
                for($i=0,$n=count($key_array);$i<$n;$i++){
                    $key=$key_array[$i];
                    if(substr($key, 0,4)=='file'){
                        if (Yii::app()->request->cookies[$key]!=""&&Yii::app()->request->cookies[$key]!="null"&&file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value)) {
                            unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value);
                        }
                        unset(Yii::app()->request->cookies[$key]);
                    }
                }
                $this->redirect(array('adminbounty/edit/?id=' . $model->id));
            }
            $this->render('/admin/bounty/editconfirm', array('model' => $model));
        } else {
            $this->redirect(array('/adminbounty/index'));
        }
    }

    public function actionDelete() {
        $id = Yii::app()->request->getParam('id');

        $model = $this->loadModel();
        $bounty_apply = new Bounty_apply();

        if (!is_null($model)) {

            $attachment1 = $model->attachment1;
            $attachment2 = $model->attachment2;
            $attachment3 = $model->attachment3;

            $transaction = $model->dbConnection->beginTransaction();

            $affected_row = $model->deleteByPk($id);
            $affected_update_information = Yii::app()->db->createCommand()->delete(
                    "update_information", "table_name=:table_name and article_id=:article_id", array("article_id" => $id, "table_name" => 'bounty'));

            if ($affected_row != $affected_update_information) {
                $transaction->rollback();
            } else {

                $criteria = new CDbCriteria();
                $criteria->select = '*';
                $criteria->addCondition('bounty_id =' . $id);
                $criteria->order = 'created_date DESC';
                $bounty_applies = Bounty_apply::model()->findAll($criteria);



                foreach ($bounty_applies as $item) {
                    if (!empty($item['attachment1']) && file_exists(Yii::getPathOfAlias('webroot') . $item['attachment1'])) {
                        unlink(Yii::getPathOfAlias('webroot') . $item['attachment1']);
                    }
                }
                $affected_update_bounty_apply = Yii::app()->db->createCommand()->delete("bounty_apply", "bounty_id=:bounty_id", array("bounty_id" => $id));
                $transaction->commit();
            }

            if ($affected_row == 1) {
                if ($attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment1)) {
                    unlink(Yii::getPathOfAlias('webroot') . $attachment1);
                    $thumnail_file_path=  FunctionCommon::getFilenameInThumnail($attachment1);
                    if(file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)){
                        unlink(Yii::getPathOfAlias('webroot') . $thumnail_file_path);
                    }
                }
                if ($attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment2)) {
                    unlink(Yii::getPathOfAlias('webroot') . $attachment2);
                    $thumnail_file_path=  FunctionCommon::getFilenameInThumnail($attachment2);
                    if(file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)){
                        unlink(Yii::getPathOfAlias('webroot') . $thumnail_file_path);
                    }
                }
                if ($attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment3)) {
                    unlink(Yii::getPathOfAlias('webroot') . $attachment3);
                    $thumnail_file_path=  FunctionCommon::getFilenameInThumnail($attachment3);
                    if(file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)){
                        unlink(Yii::getPathOfAlias('webroot') . $thumnail_file_path);
                    }
                }
                
            }

            $this->redirect(array('/adminbounty/index'));
        }
    }

}