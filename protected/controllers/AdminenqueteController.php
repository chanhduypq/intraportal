<?php

class AdminenqueteController extends Controller {

	public $pageTitle;
    private $_enquete = null;

    public function init() {
        parent::init();
		$this->pageTitle="ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null") {
            $this->redirect(array('newgin/'));
        }
    }

    /*     * Create Date:23/07/2012
     * Update Date:
     * Author: Baodt
     * User change:
     * Description: display list Enquete object
     * */

    public function actionIndex() {
        //set cookie
        $page = isset($_GET['page']) ? $_GET['page'] : '';
        $cookie = new CHttpCookie('page', $page);
        Yii::app()->request->cookies['page'] = $cookie;

        $criteria = new CDbCriteria();
        $criteria->select = '*';
        $criteria->condition = FunctionCommon::isAdmin() == FALSE ? "contributor_id=" . Yii::app()->request->cookies['id'] : "true";
        $criteria->order = 'created_date DESC';

        $item_count = Enquete::model()->count($criteria);
        $pages = new CPagination($item_count);
        $pages->pageSize = Yii::app()->params['listPerPage'];
        $pages->applyLimit($criteria);

        $model = Enquete::model()->findAll($criteria);
        $this->render('/admin/enquete/index', array(
            'enquetes' => $model,
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
        if (count($model) > 0) {
            $id = $_GET['id'];
            $enquete_choice = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('enquete_choice')
                    ->where("enquete_id=$id")
                    ->queryAll();
            $this->render('/admin/enquete/detail', array('model' => $model, 'enquete_choice' => $enquete_choice));
        } else {
            $this->redirect(array('adminenquete/index'));
        }
    }

    /*     * Create Date:23/07/2012
     * Update Date:
     * Author:
     * User change:
     * Description: edit enquete object
     * */

    public function actionEdit() {
        $parmas = array();
        $model = $this->loadModel();
        if ($model == null || !isset($_GET['id'])) {
            $this->redirect(array('adminenquete/index'));
        }
        $answers = Yii::app()->db->createCommand()
                ->select('*')
                ->from('enquete_choice')
                ->where('enquete_id=:enquete_id', array(':enquete_id' => $_GET['id']))
                ->queryAll();

        //array_content
        $a_content = array();
        foreach ($answers as $ansewr) {
            $a_content[] = $ansewr['answer_content'];
        }

        $model->content_anser_array = CJSON::encode($a_content);
        //	array_id
        $id_anser = array();
        foreach ($answers as $ansewr) {
            $id_anser[] = $ansewr['id'];
        }

        $model->id_anser_array = CJSON::encode($id_anser);
        $model->num_anser = count($answers);

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
        $this->render('/admin/enquete/edit', $parmas);
    }

    /*     * Create Date:23/07/2012
     * Update Date:
     * Author:
     * User change:
     * Description: confirm edit enquete object
     * */

    public function actionEditconfirm() {
        $model = $this->loadModel();
        if ($model == null) {
            $this->redirect(array('adminenquete/index'));
        }
        if (Yii::app()->request->isPostRequest) {
            CActiveForm::validate($model);
            if (!isset($_POST['edit']) || $_POST['edit'] != '1') {
                $model->answer_content_array = CJSON::encode($_POST['anser']);
                Upload_file_common_new::processAttachments($model, 'enquete', 2);
            }
            if ($model->validate()) {
                if (isset($_POST['edit']) && $_POST['edit'] == '1') {

                    $model->attachment1 = $_POST['Enquete']['attachment1'];
                    $model->attachment2 = $_POST['Enquete']['attachment2'];
                    $model->attachment3 = $_POST['Enquete']['attachment3'];
                    $now = FunctionCommon::getDateTimeSys();
                    $last_updated_person = FunctionCommon::getEmplNum();
                    $contributor_id = Yii::app()->request->cookies['id'];

                    Yii::app()->db->createCommand()->
                            update('enquete', array(
                                'title' => trim($model->title),
                                'content' => trim($model->content),
                                'comment' => trim($model->comment),
                                'deadline' => $model->deadline_year . '-' . $model->deadline_month . '-' . $model->deadline_day,
                                'answer_type' => $model->answer_type,
                                'contributor_id' => $contributor_id,
                                'last_updated_date' => $now,
                                'last_updated_person' => $last_updated_person,
                                'attachment1' => $model->attachment1,
                                'attachment2' => $model->attachment2,
                                'attachment3' => $model->attachment3,
                                    ), 'id = :id', array(':id' => $model->id)
                    ); //update in enquete table   


                    $data = array('last_updated_date' => $model->last_updated_date,);
                    $affected = Yii::app()->db->createCommand()
                            ->update('update_information', $data, "table_name=:table_name and article_id=:article_id", array("article_id" => $model->id, "table_name" => "enquete")
                    );

                    $answer_content_array = CJSON::decode($model->answer_content_array);

                    $id_anser_array = CJSON::decode($model->id_anser_array);

                    $contributor_id = Yii::app()->request->cookies['id'];
                    foreach ($answer_content_array as $key => $value) {

                        if ($key < $model->num_anser) {

                            if ($value != "") {
                                Yii::app()->db->createCommand()->
                                        update('enquete_choice', array(
                                            'answer_content' => trim($value),
                                            'contributor_id' => $contributor_id,
                                            'last_updated_date' => $now,
                                            'last_updated_person' => $last_updated_person,
                                                ), 'id = :id', array(':id' => $id_anser_array[$key])
                                );
                            } else {
                                $sql1 = "DELETE  FROM enquete_choice WHERE id=" . $id_anser_array[$key];
                                $sql2 = "DELETE  FROM enquete_result WHERE choice_id=" . $id_anser_array[$key];
                                Yii::app()->db->createCommand($sql1)->execute();
                                Yii::app()->db->createCommand($sql2)->execute();
                            }
                        } // update old answer, delete if answer is empty 
                        else {
                            if ($value) {
                                $model_enquete_choice = new Enquete_choice();
                                $model_enquete_choice->enquete_id = $model->id;
                                $model_enquete_choice->answer_content = trim($value);
                                $model_enquete_choice->contributor_id = $contributor_id;
                                $model_enquete_choice->created_date = $now;
                                $model_enquete_choice->last_updated_date = $now;
                                $model_enquete_choice->last_updated_person = $last_updated_person;
                                $model_enquete_choice->save();
                            }  //insert new record if add new answer 
                        }
                    }
                    if (Yii::app()->request->cookies['page'] != "") {
                        $page = "index?page=" . Yii::app()->request->cookies['page'];
                    } else {
                        $page = "";
                    }
                    unset(Yii::app()->request->cookies['file_enquete_edit_attachment1']);
                    unset(Yii::app()->request->cookies['file_enquete_edit_attachment2']);
                    unset(Yii::app()->request->cookies['file_enquete_edit_attachment3']);
                    $this->redirect(array('adminenquete/' . $page . ''));
                }
            }
			else {
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
                    if ($model->attachment1 != Upload_file_common::getAttachmentById($model->id, 1,'enquete')) {
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment1);
                    }
                }
                if ($model->attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment2)) {
                    if ($model->attachment2 != Upload_file_common::getAttachmentById($model->id, 2,'enquete')) {
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment2);
                    }
                }
                if ($model->attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment3)) {
                    if ($model->attachment3 != Upload_file_common::getAttachmentById($model->id, 3,'enquete')) {
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
                $this->redirect(array('adminenquete/edit/?id=' . $model->id));
            }
        }else{
            $this->redirect(array('adminenquete/index'));
        }
        $this->render('/admin/enquete/editconfirm', array('model' => $model));
    }

    /*     * Create Date:23/07/2012
     * Update Date:
     * Author:
     * User change:
     * Description: delete enquete object
     * */

    public function actionDelete($id = null) {
        $model = new Enquete();
        $model = $model->findByPk($id);
        if ($model == NULL) {
            return;
        }
        $attachment1 = $model->attachment1;
        $attachment2 = $model->attachment2;
        $attachment3 = $model->attachment3;
        $transaction = $model->dbConnection->beginTransaction();

        $affected_enquete = $model->deleteByPk($id);
        $affected_update_information = Yii::app()->db->createCommand()->delete(
                "update_information", "table_name=:table_name and article_id=:article_id", array(
            "article_id" => $id,
            "table_name" => 'enquete',
        ));
        if ($affected_enquete != $affected_update_information) {
            $transaction->rollback();
        } else {
            $transaction->commit();
        }

        if ($affected_enquete == 1) {
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

        $sql2 = 'DELETE FROM enquete_result WHERE enquete_result.choice_id in (select id FROM enquete_choice WHERE enquete_choice.enquete_id=' . $id . ')';
        $sql3 = 'DELETE FROM enquete_choice WHERE enquete_choice.enquete_id=' . $id;

        Yii::app()->db->createCommand($sql2)->execute();
        Yii::app()->db->createCommand($sql3)->execute();

        $this->redirect(array('adminenquete/index'));
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
            } else if (isset($_POST['Enquete'])) {
                $data = $_POST['Enquete'];
                $id = $data['id'];
                $this->_enquete = Enquete::model()->findbyPk(intval($id));
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
     * Description: download file upload
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
        } else {//download file from host
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
                        ->from('enquete')
                        ->where('id=:id', array('id' => $_GET['id']))
                        ->queryScalar();
                /**
                 *
                 */
                if ($file_name != "" && file_exists(Yii::getPathOfAlias('webroot') . $file_name)) {
                    /**
                     * 
                     */
                    Yii::import('ext.helpers.EDownloadHelper');
                    EDownloadHelper::download(Yii::getPathOfAlias('webroot') . $file_name);
                }
            }
        }
        exit;
    }

    /**
     * check id enquete
     */
    public function actionCheckId() {
        $id = $_POST['id'];
        $table = $_POST['table'];
        $id = Yii::app()->db->createCommand("select id from $table where id=$id limit 1")->queryScalar();
        if ($id == FALSE) {
            echo '0';
        } else {
            echo $id;
        }
    }

    //fix back browsers
    public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('enquete_edit_from') ? Yii::app()->request->cookies['enquete_edit_from']->value : '';
        if ($backCookie != "" || $backCookie != NULL) {
            return array(
                array('application.extensions.PerformanceFilter - edit, regist'),
            );
        } else {
            return array(
                'accessControl',
            );
        }
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
                $id = Yii::app()->request->getParam('id');
                if ($attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment1)) {
                    if ($attachment1 != Upload_file_common::getAttachmentById($id, 1, 'enquete')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment1);
                    }
                }
                if ($attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment2)) {
                    if ($attachment2 != Upload_file_common::getAttachmentById($id, 2, 'enquete')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment2);
                    }
                }
                if ($attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment3)) {
                    if ($attachment3 != Upload_file_common::getAttachmentById($id, 3, 'enquete')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment3);
                    }
                }
            }
        }
    }
}
?>