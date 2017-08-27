<?php

class Adminto_officerController extends Controller {

	public $pageTitle;
    public function init() {
        parent::init();
		$this->pageTitle="ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null") {
            $this->redirect(array('newgin/'));
        }
    }

    public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('to_officer_edit_from') ? Yii::app()->request->cookies['to_officer_edit_from']->value : '';

        if ($backCookie != "" && $backCookie != NULL && $backCookie != "null") {
            return array(
                array('application.extensions.PerformanceFilter - edit'),
            );
        } else {
            return array(
                'accessControl',
            );
        }
    }

    /**
     *     
     */
    private $_toofficer = null;

    /**
     * 
     */
    public function actionIndex() {
        /**
         * 
         */
        $page = (isset($_GET['page']) ? $_GET['page'] : 1);
        $cookie = new CHttpCookie('page', $page);
        Yii::app()->request->cookies['page'] = $cookie;
        /**
         * 
         */
        $page_size = Config::LIMIT_ROW;
        /**
         * 
         */
        $item_count = Yii::app()->db->createCommand()
                ->select('count(*) as count')
                ->from('to_officer')
                ->where(FunctionCommon::isAdmin() == FALSE ? "contributor_id=" . Yii::app()->request->cookies['id'] : "true")
                ->queryScalar();
        /**
         * 
         */
        $to_officers = Yii::app()->db->createCommand()
                ->select(array(
                    'id',
                    'title',
                    'content',
                    'created_date',
                    'last_updated_date',
                        )
                )
                ->from('to_officer')
                ->where(FunctionCommon::isAdmin() == FALSE ? "contributor_id=" . Yii::app()->request->cookies['id'] : "true")
                ->limit($page_size, ($page - 1) * $page_size)
                ->order('created_date desc')
                ->queryAll();
        /**
         * 
         */
        $pages = new CPagination($item_count);
        $pages->setPageSize($page_size);
        /**
         * 
         */
        $params = array('to_officers' => $to_officers,
            'item_count' => $item_count,
            'page_size' => $page_size,
            'pages' => $pages);
        /**
         * 
         */
        $this->render('/admin/to_officers/index', $params);
    }

    /**
     * 
     */
    public function actionEdit() {

        /**
         * 
         */
        $parmas = array();
        /**
         * 
         */
        $model = $this->loadModel();
        if ($model == null || !isset($_GET['id'])) {
            $this->redirect(array('adminto_officer/index'));
        }
        /**
         * 
         */
        if (Yii::app()->request->isAjaxRequest) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        /**
         * 
         */
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

        $this->render('/admin/to_officers/edit', $parmas);
    }

    /**
     * 
     */
    public function actionEditconfirm() {
        /**
         * 
         */
        $model = $this->loadModel();
        /**
         * 
         */
        if (Yii::app()->request->isPostRequest) {
            CActiveForm::validate($model);
            if (!isset($_POST['edit']) || $_POST['edit'] != '1') {

                Upload_file_common_new::processAttachments($model, 'to_officer', 2);
            }
            if ($model->id == null || $model->id == '') {
                $this->redirect(array('adminto_officer/index'));
            }
            /**
             *
             */
            if ($model->validate()) {
                /**
                 *
                 */
                if (isset($_POST['edit']) && $_POST['edit'] == '1') {
                    $model->attachment1 = $_POST['Toofficer']['attachment1'];
                    $model->attachment2 = $_POST['Toofficer']['attachment2'];
                    $model->attachment3 = $_POST['Toofficer']['attachment3'];
                    if ($model->save() == true) {
                        if (Yii::app()->request->cookies['page'] != "") {
                            $page = "index?page=" . Yii::app()->request->cookies['page'];
                        } else {
                            $page = "";
                        }
                        $this->redirect(array('adminto_officer/' . $page . ''));
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
                    if ($model->attachment1 != Upload_file_common::getAttachmentById($model->id, 1, 'to_officer')) {
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment1);
                    }
                }
                if ($model->attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment2)) {
                    if ($model->attachment2 != Upload_file_common::getAttachmentById($model->id, 2, 'to_officer')) {
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment2);
                    }
                }
                if ($model->attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment3)) {
                    if ($model->attachment3 != Upload_file_common::getAttachmentById($model->id, 3, 'to_officer')) {
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
                $this->redirect(array('adminto_officer/edit/?id=' . $model->id));
            }
        }else{
            $this->redirect(array('adminto_officer/index'));
        }
        $this->render('/admin/to_officers/editconfirm', array('model' => $model));
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
                    if ($attachment1 != Upload_file_common::getAttachmentById($id, 1, 'to_officer')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment1);
                    }
                }
                if ($attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment2)) {
                    if ($attachment2 != Upload_file_common::getAttachmentById($id, 2, 'to_officer')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment2);
                    }
                }
                if ($attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment3)) {
                    if ($attachment3 != Upload_file_common::getAttachmentById($id, 3, 'to_officer')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment3);
                    }
                }
            }
        }
    }

    /**
     * 
     */
    public function actionDetail() {
        $model = $this->loadModel();
        if ($model == NULL || !isset($_GET['id'])) {
            $this->redirect(array('adminto_officer/index'));
        }

        $this->render('/admin/to_officers/detail', array(
            'model' => $model,
                )
        );
    }

    /**
     * 
     */
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
                        ->from('to_officer')
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
     *      
     */
    public function loadModel() {
        if ($this->_toofficer === null) {
            if (isset($_GET['id'])) {
                $this->_toofficer = Toofficer::model()->findbyPk(intval($_GET['id']));
            } else if (isset($_POST['Toofficer'])) {
                $data = $_POST['Toofficer'];
                $id = $data['id'];
                $this->_toofficer = Toofficer::model()->findbyPk(intval($id));
            } else {
                $this->_toofficer = new Toofficer();
            }
        }
        return $this->_toofficer;
    }

    /**
     * 
     */
    public function actionDelete() {
        /**
         * 
         */
        $id = Yii::app()->request->getParam('id');
        /**
         * 
         */
        $model = new Toofficer();
        /**
         * 
         */
        $model = $model->findByPk($id);
        if ($model == NULL) {
            return;
        }
        /**
         * 
         */
        $attachment1 = $model->attachment1;
        $attachment2 = $model->attachment2;
        $attachment3 = $model->attachment3;
        /**
         * 
         */
        $transaction = $model->dbConnection->beginTransaction();
        /**
         * 
         */
        $affected_to_officer = $model->deleteByPk($id);
        $affected_update_information = Yii::app()->db->createCommand()->delete(
                "update_information", "table_name=:table_name and article_id=:article_id", array(
            "article_id" => $id,
            "table_name" => 'to_officer',
                ))
        ;
        /**
         * 
         */
        if ($affected_to_officer != $affected_update_information) {
            $transaction->rollback();
        } else {
            $transaction->commit();
        }
        /**
         * 
         */
        if ($affected_to_officer == 1) {
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
        /**
         * 
         */
        $this->redirect(array('/adminto_officer/index'));
    }

}