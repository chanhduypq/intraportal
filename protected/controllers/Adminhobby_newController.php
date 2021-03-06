<?php

class Adminhobby_newController extends Controller {

    public $pageTitle;

    //check if logined or not
    public function init() {
        parent::init();
        $this->pageTitle = "ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null") {
            $this->redirect(array('newgin/'));
        }
    }

    public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('hobby_new_edit_form') ? Yii::app()->request->cookies['hobby_new_edit_form']->value : '';
        if ($backCookie != "" && $backCookie != NULL && $backCookie != "null") {
            return array(array('application.extensions.PerformanceFilter - edit'),);
        } else {
            return array('accessControl',);
        }
    }

    /*
     * Create Date:20130823
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:Method using load model hobby_new
     * */

    private $_hobby_new = null;

    public function loadModel() {
        if ($this->_hobby_new === null) {
            if (isset($_GET['id'])) {
                $this->_hobby_new = Hobby_new::model()->findbyPk(intval($_GET['id']));
            } else if (isset($_POST['Hobby_new'])) {
                $data = $_POST['Hobby_new'];
                $id = $data['id'];
                $this->_hobby_new = Hobby_new::model()->findbyPk(intval($id));
            } else {
                $this->_hobby_new = new Hobby_new();
            }
        }
        return $this->_hobby_new;
    }

    /** Create Date:20130823
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:Method using down load file
     * */
    public function actionDownloadedit() {

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
                        ->from('hobby_new')
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
                    if ($attachment1 != Upload_file_common::getAttachmentById($id, 1, 'hobby_new')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment1);
                    }
                }
                if ($attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment2)) {
                    if ($attachment2 != Upload_file_common::getAttachmentById($id, 2, 'hobby_new')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment2);
                    }
                }
                if ($attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment3)) {
                    if ($attachment3 != Upload_file_common::getAttachmentById($id, 3, 'hobby_new')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment3);
                    }
                }
            }
        }
    }

    /*
     * Create Date:20130822
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:Method using check id report 
     * */

    public function actionCheckId() {
        $id = $_POST['id'];
        $row = 0;
        $object = Yii::app()->db->createCommand("select * from hobby_new where id=" . $id)->queryRow();
        if (!empty($object['id'])) {
            $row = 1;
        }
        echo $row;
    }

    public function actionCheckCategory() {
        $id = $_POST['id'];
        $row = 0;
        $object = Yii::app()->db->createCommand("select * from category where id=" . $id)->queryRow();
        if (!empty($object['id'])) {
            $row = 1;
        }
        echo $row;
    }

    /** Create Date:23/07/2012
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:action index object from model Hobby_new  
     * */
    public function actionIndex() {
        $cookie_collection = Yii::app()->request->cookies;
        $key_array = $cookie_collection->getKeys();

        for ($i = 0, $n = count($key_array); $i < $n; $i++) {
            $key = $key_array[$i];
            if (substr($key, 0, 4) == 'file' && strpos($key, 'hobby_new') != FALSE) {

                if (Yii::app()->request->cookies[$key] != "" && Yii::app()->request->cookies[$key] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value)) {
                    unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value);
                }
                unset(Yii::app()->request->cookies[$key]);
            }
        }
        //set cookie page
        $page = isset($_GET['page']) ? $_GET['page'] : '';
        $cookie = new CHttpCookie('page', $page);
        Yii::app()->request->cookies['page'] = $cookie;

        $criteria = new CDbCriteria();
        $criteria->select = '*';
        $criteria->condition = FunctionCommon::isAdmin() == FALSE ? "contributor_id=" . Yii::app()->request->cookies['id'] : "true";
        $criteria->order = 'created_date DESC';

        $item_count = Hobby_new::model()->count($criteria);
        $pages = new CPagination($item_count);
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);

        $model = Hobby_new::model()->findAll($criteria);
        $this->render('/admin/hobby_new/index', array('model' => $model, 'pages' => $pages));
    }

    /** Create Date:20130823
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:action display info Detail object Hobby_new  
     * */
    public function actionDetail($id) {
        $model = $this->loadModel();
        
        $hobby_new_list_comments = Yii::app()->db->createCommand("select * from hobby_new_comment where hobby_new_id=" . $_GET['id'] . " order by created_date ASC")->queryAll();
        $user = User::model()->findAll();
        if (!empty($model->title)) {
            $this->render('/admin/hobby_new/detail', array(
                'model' => $model,
                'hobby_new_list_comments' => $hobby_new_list_comments,
                'user' => $user,
                    )
            );
        } else {
            $this->redirect(array('/adminhobby_new/index'));
        }
    }

    /** Create Date:23/07/2012
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:action using update info object report  
     * */
    public function actionEdit() {
        $parmas = array();
        $model = $this->loadModel();
        if (count($model) > 0) {
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
            $this->render('/admin/hobby_new/edit', $parmas);
        } else {
            $this->redirect(array('adminhobby_new/index'));
        }
    }

    /** Create Date:20130823
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:action display info edit model hobby_new  
     * */
    public function actionEditConfirm() {
        $model = $this->loadModel();
        if (count($model) > 0 && Yii::app()->request->isPostRequest) {
            CActiveForm::validate($model);
            if (!isset($_POST['edit']) || $_POST['edit'] != '1') {
                Upload_file_common_new::processAttachments($model, 'hobby_new', 2);
            }
            if ($model->validate()) {
                if (isset($_POST['edit']) && $_POST['edit'] == '1') {
                    $model->attachment1 = $_POST['Hobby_new']['attachment1'];
                    $model->attachment2 = $_POST['Hobby_new']['attachment2'];
                    $model->attachment3 = $_POST['Hobby_new']['attachment3'];
                    if ($model->save()) {
                        if (Yii::app()->request->cookies['page'] != "") {
                            $page = "index?page=" . Yii::app()->request->cookies['page'];
                        } else {
                            $page = "";
                        }
                        $this->redirect(array('adminhobby_new/' . $page . ''));
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
                    if ($model->attachment1 != Upload_file_common::getAttachmentById($model->id, 1, 'hobby_new')) {
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment1);
                    }
                }
                if ($model->attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment2)) {
                    if ($model->attachment2 != Upload_file_common::getAttachmentById($model->id, 2, 'hobby_new')) {
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment2);
                    }
                }
                if ($model->attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment3)) {
                    if ($model->attachment3 != Upload_file_common::getAttachmentById($model->id, 3, 'hobby_new')) {
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment3);
                    }
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
                $this->redirect(array('adminhobby_new/edit/?id=' . $model->id));
            }
            $this->render('/admin/hobby_new/editconfirm', array('model' => $model));
        } else {
            $this->redirect(array('adminhobby_new/index'));
        }
    }

    /** Create Date:20130910
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:action using delete object hobby_new 
     * */
    public function actionDelete() {
        $id = Yii::app()->request->getParam('id');
        $model = Hobby_new::model();
        $transaction = $model->dbConnection->beginTransaction();
        $model = $model->findByPk($id);

        if (!is_null($model)) {
            $attachment1 = $model->attachment1;
            $attachment2 = $model->attachment2;
            $attachment3 = $model->attachment3;

            $affected_row = $model->deleteByPk($id);

            $affected_update_information = Yii::app()->db->createCommand()->delete("update_information", "table_name=:table_name and article_id=:article_id", array("article_id" => $id, "table_name" => 'hobby_new',));


            if ($affected_row != $affected_update_information) {
                $transaction->rollback();
            } else {
                $transaction->commit();
                Yii::app()->db->createCommand("delete from hobby_new_comment where hobby_new_id=$id")->execute();
            }

            if ($affected_row == 1) {
                if ($attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment1)) {
                    unlink(Yii::getPathOfAlias('webroot') . $attachment1);
                    $thumnail_file_path = FunctionCommon::getFilenameInThumnail($attachment1);
                    if (file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)) {
                        unlink(Yii::getPathOfAlias('webroot') . $thumnail_file_path);
                    }
                }
                if ($attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment2)) {
                    unlink(Yii::getPathOfAlias('webroot') . $attachment2);
                    $thumnail_file_path = FunctionCommon::getFilenameInThumnail($attachment2);
                    if (file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)) {
                        unlink(Yii::getPathOfAlias('webroot') . $thumnail_file_path);
                    }
                }
                if ($attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment3)) {
                    unlink(Yii::getPathOfAlias('webroot') . $attachment3);
                    $thumnail_file_path = FunctionCommon::getFilenameInThumnail($attachment3);
                    if (file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)) {
                        unlink(Yii::getPathOfAlias('webroot') . $thumnail_file_path);
                    }
                }
            }
            $this->redirect(array('adminhobby_new/index'));
        }
    }

    /**
     * delete comment id hobby_new_comment with id hobby_new
     */
    public function actionDeleteidhobby_newcomment() {

        $id = Yii::app()->request->getParam('id');
        $id2 = Yii::app()->request->getParam('id2');

        $model = new Hobby_new_comment;
        $transaction = $model->dbConnection->beginTransaction();

        $delete_id_hobby_new_respnse = Yii::app()->db->createCommand()->delete("hobby_new_comment", 'id=:id', array('id' => $id2));

        if ($delete_id_hobby_new_respnse) {
            $transaction->commit();
        } else {
            $transaction->rollback();
        }

        $this->redirect(array('adminhobby_new/detail/?id=' . $id));
    }

}

?>