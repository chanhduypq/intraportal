<?php

class Adminshare_itemController extends Controller {

    private $_share_item = null;
	public $pageTitle;
    public function init() {
        parent::init();
		$this->pageTitle="ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null") {
            $this->redirect(array('newgin/'));
        }
    }
    /**
     * display list share_item
     */
    public function actionIndex() {

        //set cookie
        $page = isset($_GET['page']) ? $_GET['page'] : '';
        $cookie = new CHttpCookie('page', $page);
        Yii::app()->request->cookies['page'] = $cookie;

        $criteria = new CDbCriteria();
        $criteria->select = '*';
        $criteria->condition = FunctionCommon::isAdmin() == FALSE ? "contributor_id=" . Yii::app()->request->cookies['id'] : "true";
        $criteria->order = 'created_date DESC';

        $item_count = Share_item::model()->count($criteria);
        $pages = new CPagination($item_count);
        $pages->pageSize = Yii::app()->params['listPerPage'];
        $pages->applyLimit($criteria);

        $share_items = Share_item::model()->findAll($criteria);
        $this->render('/admin/share_item/index', array(
            'share_items' => $share_items,
            'pages' => $pages));
    }

    /**
     * edit record id
     */
    public function actionEdit() {
        $parmas = array();
        $model = $this->loadModel();

        if ($model == null || !isset($_GET['id'])) {
            $this->redirect(array('adminshare_item/index'));
        }

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
        $this->render('/admin/share_item/edit', $parmas);
    }

    /**
     * edit confirm
     */
    public function actionEditconfirm() {
        $model = $this->loadModel();
		if(isset($_POST['Share_item']['id'])){
			$id_gol = Yii::app()->db->createCommand("select * from share_item where id=".$_POST['Share_item']['id'])->queryRow();
			if($id_gol==""){
				$this->redirect(array('adminshare_item/index'));
			}
		}
        if (Yii::app()->request->isPostRequest) {
            CActiveForm::validate($model);
            if (!isset($_POST['edit']) || $_POST['edit'] != '1') {

                Upload_file_common_new::processAttachments($model, 'share_item', 2);
            }
            if ($model->id == null || $model->id == '') {
                $this->redirect(array('adminshare_item/index'));
            }
            if ($model->validate()) {
                if (isset($_POST['edit']) && $_POST['edit'] == '1') {
                    $model->attachment1 = $_POST['Share_item']['attachment1'];
                    $model->attachment2 = $_POST['Share_item']['attachment2'];
                    $model->attachment3 = $_POST['Share_item']['attachment3'];
                    if ($model->save() == true) {
                        if (Yii::app()->request->cookies['page'] != "") {
                            $page = "index?page=" . Yii::app()->request->cookies['page'];
                        } else {
                            $page = "";
                        }
                        $this->redirect(array('adminshare_item/' . $page . ''));
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
                    if ($model->attachment1 != Upload_file_common::getAttachmentById($model->id, 1, 'share_item')) {
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment1);
                    }
                }
                if ($model->attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment2)) {
                    if ($model->attachment2 != Upload_file_common::getAttachmentById($model->id, 2, 'share_item')) {
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment2);
                    }
                }
                if ($model->attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment3)) {
                    if ($model->attachment3 != Upload_file_common::getAttachmentById($model->id, 3, 'share_item')) {
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
                $this->redirect(array('adminshare_item/edit/?id=' . $model->id));
            }
        }else {
            $this->redirect(array('adminshare_item/index'));
      	  }
        $this->render('/admin/share_item/editconfirm', array('model' => $model));
    }

    /**
     * Detail id
     */
    public function actionDetail() {
        $model = $this->loadModel();
        if (!empty($model->title)) {

            $this->render('/admin/share_item/detail', array(
                'model' => $model,
                    )
            );
        } else {
            $this->redirect(array('/adminshare_item/index'));
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
            $file_path = Upload_file_common::getAttachmentById($_GET['id'], $attachment_index, 'share_item');
        } else {//download from registconfirm
            $file_path = $_GET['file_name'];
        }
        Yii::import('ext.helpers.EDownloadHelper');
        EDownloadHelper::download(Yii::getPathOfAlias('webroot') . $file_path);
        exit;
    }

    public function actionDownloadedit() {
        $model = $this->loadModel();
        if (isset($_POST['file_index'])) { //download file from file_bytes  		
            CActiveForm::validate($model);
            $model->validate();
            $attachment_id = $_POST['file_index'];
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
                        ->from('share_item')
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

    /**
     * Regist 
     */
    public function actionRegist() {
        $parmas = array();
        $model = new Share_item();
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
        $this->render('/admin/share_item/regist', $parmas);
    }

    /**
     * Regist confirm
     */
    public function actionRegistconfirm() {
        $model = new Share_item();
        if (Yii::app()->request->isPostRequest) {
            CActiveForm::validate($model);
            if (!isset($_POST['regist']) || $_POST['regist'] != '1') {
                Upload_file_common_new::processAttachments($model, 'share_item', 1);
            }
            if ($model->validate()) {
                if (isset($_POST['regist']) && $_POST['regist'] == '1') {
                    $model->attachment1 = $_POST['Share_item']['attachment1'];
                    $model->attachment2 = $_POST['Share_item']['attachment2'];
                    $model->attachment3 = $_POST['Share_item']['attachment3'];
                    if ($model->save() == true) {
                        $this->redirect(array('adminshare_item/index'));
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
                $this->redirect(array('adminshare_item/regist'));
            }
        }else {
            $this->redirect(array('adminshare_item/index'));
      	  }
        $this->render('/admin/share_item/registconfirm', array('model' => $model));
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
    public function actionDeleteattechmentsedit() {
        if (Yii::app()->request->isAjaxRequest) {
            $no = Yii::app()->request->getParam('no');
            if ($no == '1') {
                $attachment1 = Yii::app()->request->getParam('attachment1');
                $attachment2 = Yii::app()->request->getParam('attachment2');
                $attachment3 = Yii::app()->request->getParam('attachment3');
                $id = Yii::app()->request->getParam('id');
                if ($attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment1)) {
                    if ($attachment1 != Upload_file_common::getAttachmentById($id, 1, 'share_item')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment1);
                    }
                }
                if ($attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment2)) {
                    if ($attachment2 != Upload_file_common::getAttachmentById($id, 2, 'share_item')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment2);
                    }
                }
                if ($attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment3)) {
                    if ($attachment3 != Upload_file_common::getAttachmentById($id, 3, 'share_item')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment3);
                    }
                }
            }
        }
    }

    /**
     * Delete Record id
     */
    public function actionDelete() {

        $id = Yii::app()->request->getParam('id');

        $model = new Share_item();

        $model = $model->findByPk($id);
        if ($model == NULL) {
            return;
        }

        $attachment1 = $model->attachment1;
        $attachment2 = $model->attachment2;
        $attachment3 = $model->attachment3;

        $transaction = $model->dbConnection->beginTransaction();

        $affected_share_item = $model->deleteByPk($id);
        $affected_update_information = Yii::app()->db->createCommand()->delete(
                "update_information", "table_name=:table_name and article_id=:article_id", array(
            "article_id" => $id,
            "table_name" => 'share_item',
                ))
        ;

        if ($id) {
            $transaction->commit();
        } else {
            $transaction->rollback();
        }

        if ($affected_share_item == 1) {
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

        $this->redirect(array('/adminshare_item/index'));
    }

    /**
     * loadModel
     */
    public function loadModel() {
        if ($this->_share_item === null) {
            if (isset($_GET['id'])) {
                $this->_share_item = Share_item::model()->findbyPk(intval($_GET['id']));
            } else if (isset($_POST['Share_item'])) {
                $data = $_POST['Share_item'];
                $id = $data['id'];
                $this->_share_item = Share_item::model()->findbyPk(intval($id));
            } else {
                $this->_share_item = new Share_item();
            }
        }
        return $this->_share_item;
    }

    /**
     * check id share_item
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

    public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('share_item_regist_from') ? Yii::app()->request->cookies['share_item_regist_from']->value : '';

        if ($backCookie != "" && $backCookie != NULL && $backCookie != "null") {
            return array(
                array('application.extensions.PerformanceFilter - edit, regist'),
            );
        } else {
            return array(
                'accessControl',
            );
        }
    }

}