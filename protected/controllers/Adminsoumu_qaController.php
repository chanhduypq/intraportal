<?php

/*
 * Create Date: 17/07/2013
 * Update Date: 24/07/2013
 * Author: Hungtc
 * User change: Hungtc
 * Description: Admin action index object from model Soumu_qa  
 * */
?>
<?php

class Adminsoumu_qaController extends Controller {

		public $pageTitle;
    private $_soumu_qa = null;

    public function loadModel() {
        if ($this->_soumu_qa === null) {
            if (isset($_GET['id'])) {
                $this->_soumu_qa = Soumu_qa::model()->findbyPk(intval($_GET['id']));
            } else if (isset($_POST['Soumu_qa'])) {
                $data = $_POST['Soumu_qa'];
                $id = $data['id'];
                $this->_soumu_qa = Soumu_qa::model()->findbyPk(intval($id));
            } else {
                $this->_soumu_qa = new Soumu_qa();
            }
        }
        return $this->_soumu_qa;
    }

    //check if logined or not
    public function init() {
        parent::init();
		$this->pageTitle="ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null") {
            $this->redirect(array('newgin/'));
        }
    }

    /*     * Index */

    public function actionIndex() {

        //set cookie
        $page = isset($_GET['page']) ? $_GET['page'] : '';
        $cookie = new CHttpCookie('page', $page);
        Yii::app()->request->cookies['page'] = $cookie;

        $criteria = new CDbCriteria();
        $criteria->select = '*';
        $criteria->condition = FunctionCommon::isAdmin() == FALSE ? "contributor_id=" . Yii::app()->request->cookies['id'] : "true";
        $criteria->order = 'created_date DESC';
        $category = Category::model()->findAll();

        $item_count = Soumu_qa::model()->count($criteria);
        $pages = new CPagination($item_count);
        $pages->pageSize = Yii::app()->params['listPerPage'];
        $pages->applyLimit($criteria);

        $model = Soumu_qa::model()->findAll($criteria);
        $this->render('/admin/soumu_qa/index', array('model' => $model, 'pages' => $pages, 'category' => $category));
    }

    public function actionCategories() {
        /**
          //$page = (isset($_GET['page']) ? $_GET['page'] : 1);

          //$page_size = 20;
         */
        $page = (isset($_GET['page']) ? $_GET['page'] : 1);
        $page_size = Config::LIMIT_ROW;

        $item_counst = Yii::app()->db->createCommand()
                ->select('count(*) as count')
                ->where('type=:type', array('type' => 2))
                ->from('View_CategoryAndSoumu_qa')
                ->queryScalar();
        $item_count = Yii::app()->db->createCommand()
                ->select('count(*) as count')
                ->from('category')
                ->where('type=:type', array('type' => 2))
                ->queryScalar();
        /**
         * 
         */
        $categories = Yii::app()->db->createCommand()
                ->select(array(
                    '*',
                        )
                )
                ->from('View_CategoryAndSoumu_qa')
                ->where('type=:type', array('type' => 2))
                ->limit($page_size, ($page - 1) * $page_size)
                ->order('created_date desc')
                ->queryAll();




        /**
         * 
         */
        //$pages = new CPagination($item_count);
        //$pages->setPageSize($page_size);

        $pages = new CPagination($item_count);
        $pages->pageSize = Yii::app()->params['listPerPage'];
        //$pages->applyLimit($criteria);

        /**
         * 
         */
        $params = array('categories' => $categories,
            'item_count' => $item_count,
            'page_size' => $page_size,
            'pages' => $pages);
        /**
         * 
         */
        $this->render('/admin/soumu_qa/categories', $params);
    }

    /**
     * Regist 
     */
    public function actionRegist() {
        $parmas = array();
        $model = new Soumu_qa();
        $category = Category::model()->findAll();

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
        /* $params 		= array(
          'model' => $model,
          'category'=>$category);
         */
        $parmas['model'] = $model;
        $parmas['category'] = $category;
        $this->render('/admin/soumu_qa/regist', $parmas);
    }

    /**
     * Regist confirm
     */
    public function actionRegistConfirm() {
        if ($_POST['Soumu_qa']['category_id'] == "") {
            $this->redirect(array('adminsoumu_qa/index'));
        }
        $category = Category::model()->findAll();
        $model = new Soumu_qa();

        if (Yii::app()->request->isPostRequest) {
            CActiveForm::validate($model);
            if (!isset($_POST['regist']) || $_POST['regist'] != '1') {

                Upload_file_common_new::processAttachments($model, 'soumu_qa', 1);
            }
            if ($model->validate()) {
                if (isset($_POST['regist']) && $_POST['regist'] == '1') {
                    $model->attachment1 = $_POST['Soumu_qa']['attachment1'];
                    $model->attachment2 = $_POST['Soumu_qa']['attachment2'];
                    $model->attachment3 = $_POST['Soumu_qa']['attachment3'];
                    if ($model->save() == true) {
                        $this->redirect(array('adminsoumu_qa/index'));
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
                $this->redirect(array('adminsoumu_qa/regist'));
            }
        }
        $parmas['model'] = $model;
        $parmas['category'] = $category;
        $this->render('/admin/soumu_qa/registconfirm', $parmas);
    }

    public function actionCategoryregist() {
        $params = array();
        /**
         * 
         */
        $model = new Category();
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
        if (Yii::app()->request->isPostRequest) {
            /**
             *
             */
            CActiveForm::validate($model);
            /**
             * 
             */
            if ($model->validate()) {
                $model->type = 2;
                $now = FunctionCommon::getDateTimeSys();
                $model->created_date = $now;
                $model->last_updated_date = $now;
                $employee_number = FunctionCommon::getEmplNum();
                $model->last_updated_person = FunctionCommon::getEmplNum();
                $model->contributor_id = Yii::app()->request->cookies['id'];
                if ($model->save()) {
                    $this->redirect(array('adminsoumu_qa/categories'));
                }
            }
        }
        $parmas['model'] = $model;
        $this->render('/admin/soumu_qa/categoryregist', $parmas);
    }

    /**
     * edit record id
     */
    public function actionEdit() {
        $parmas = array();
        $model = $this->loadModel();

        if ($model == null || !isset($_GET['id'])) {
            $this->redirect(array('adminsoumu_qa/index'));
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
        $this->render('/admin/soumu_qa/edit', $parmas);
    }

    /**
     * edit confirm,
     */
    public function actionEditconfirm() {
        if ($_POST['Soumu_qa']['category_id'] == "") {
            $this->redirect(array('adminsoumu_qa/index'));
        }
        $model = $this->loadModel();
        $category = Category::model()->findAll();

        if (Yii::app()->request->isPostRequest) {
            CActiveForm::validate($model);
            if (!isset($_POST['edit']) || $_POST['edit'] != '1') {

                Upload_file_common_new::processAttachments($model, 'soumu_qa', 2);
            }
            if ($model->id == null || $model->id == '') {
                $this->redirect(array('adminsoumu_qa/index'));
            }
            if ($model->validate()) {
                if (isset($_POST['edit']) && $_POST['edit'] == '1') {
                    $model->attachment1 = $_POST['Soumu_qa']['attachment1'];
                    $model->attachment2 = $_POST['Soumu_qa']['attachment2'];
                    $model->attachment3 = $_POST['Soumu_qa']['attachment3'];
                    if ($model->save() == true) {
                        if (Yii::app()->request->cookies['page'] != "") {
                            $page = "index?page=" . Yii::app()->request->cookies['page'];
                        } else {
                            $page = "";
                        }
                        $this->redirect(array('adminsoumu_qa/' . $page . ''));
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
                    if ($model->attachment1 != Upload_file_common::getAttachmentById($model->id, 1, 'soumu_qa')) {
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment1);
                    }
                }
                if ($model->attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment2)) {
                    if ($model->attachment2 != Upload_file_common::getAttachmentById($model->id, 2, 'soumu_qa')) {
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment2);
                    }
                }
                if ($model->attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment3)) {
                    if ($model->attachment3 != Upload_file_common::getAttachmentById($model->id, 3, 'soumu_qa')) {
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
                $this->redirect(array('adminsoumu_qa/edit/?id=' . $model->id));
            }
        }
        $this->render('/admin/soumu_qa/editconfirm', array('model' => $model, 'category' => $category));
    }

    public function actionCategoryEdit($id) {
        $parmas = array();
        //$model=Category::model();
        //$model		    = Category::model()->loadModel();			
        //$model 			= new Category();  
        $model = Category::model()->findByPk($id);

        if (!empty($model->id)) {
            $this->redirect(array('adminsoumu_qa/categories'));
        }

        if (Yii::app()->request->isAjaxRequest) {

            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if (Yii::app()->request->isPostRequest) {
            CActiveForm::validate($model);
            //echo $model->validate();exit;  

            if ($model->validate()) {
;
                //if(isset($_POST['regist'])&&$_POST['regist']=='1'){                    
                $now = FunctionCommon::getDateTimeSys();
                $model->last_updated_date = $now;
                // echo $model->save();exit;
                if (is_numeric($model->id)) {
                    $model->setIsNewRecord(false);
                }
                if ($model->save() == true) {
                    $this->redirect(array('adminsoumu_qa/categories'));
                }
                //}
            }
        }
        $parmas['model'] = $model;
        $parmas['category'] = $category;
        $this->render('/admin/soumu_qa/categoryedit', $parmas);
    }

    public function actionDetail($id) {

        $model = $this->loadModel();

        //$contributor_id = Yii::app()->db->createCommand("select * from criticism where id=".$_GET['id']." and contributor_id=".Yii::app()->request->cookies['id'])->queryRow();		

        if (empty($model->title) || ($model->id != $_GET['id'])) {
            $this->redirect(array('adminsoumu_qa/index'));
        }
        $category = Category::model()->findAll();
        $this->render('/admin/soumu_qa/detail', array('model' => $model, 'category' => $category));
    }

    public function actionDelete() {

        $id = Yii::app()->request->getParam('id');
        $model = Soumu_qa::model();

        $transaction = $model->dbConnection->beginTransaction();
        $model = $model->findByPk($id);

        //check if id existed
        if ($model->id != $id) {
            $this->redirect(array('adminsoumu_qa/index'));
        }

        if (!is_null($model)) {
            $attachment1 = $model->attachment1;
            $attachment2 = $model->attachment2;
            $attachment3 = $model->attachment3;

            $affected_soumu_qa = $model->deleteByPk($id);

            $affected_update_information = Yii::app()->db->createCommand()->delete(
                    "update_information", "table_name=:table_name and article_id=:article_id", array("article_id" => $id, "table_name" => 'soumu_qa',));

            if ($affected_soumu_qa != $affected_update_information) {
                $transaction->rollback();
            } else {
                $transaction->commit();
            }

            if ($affected_soumu_qa == 1) {
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
            $this->redirect(array('adminsoumu_qa/index'));
        }
    }

    public function actionCategoryDelete() {

        $id = Yii::app()->request->getParam('id');
        $model = Category::model();
        $transaction = $model->dbConnection->beginTransaction();
        $model = $model->findByPk($id);

        if (empty($model->category_name) || ($model->id != $id)) {
            $this->redirect(array('adminsoumu_qa/categories'));
        }

        if (!is_null($model)) {


            //$affected_soumu_qa=$model->deleteByPk($id);
            //$affected_category=$model->deleteByPk($id);

            $affected_category =
                    Yii::app()->db->createCommand()->delete("category", "id=:id", array("id" => $id));


            /*
              $affected_update_information=Yii::app()->db->createCommand()->delete(
              "update_information",
              "table_name=:table_name and article_id=:article_id",
              array("article_id"=>$id,"table_name"=>'category',));

              var_dump($affected_update_information);exit;
             */
            //var_dump($affected_category);exit;
            if ($affected_category != 1) {
                $transaction->rollback();
            } else {
                $affected_update_soumu_qa =
                        Yii::app()->db->createCommand()->delete("soumu_qa", "category_id=:category_id", array("category_id" => $id));
                $transaction->commit();
            }

            $this->redirect(array('adminsoumu_qa/categories'));
        }
    }

    /**
     * base64_encode file upload
     */
    private function processAttachments($model) {

        if ($file = CUploadedFile::getInstance($model, 'attachment1')) {
            $file_name = $file->name;

            $model->attachment1_file_name = $file->name;
            $model->attachment1_file_bytes = base64_encode(file_get_contents($file->tempName));
            $model->attachment1_file_type = $file->type;
        } else {
            $model->attachment1_file_name = "";
        }
        if ($file = CUploadedFile::getInstance($model, 'attachment2')) {
            $file_name = $file->name;

            $model->attachment2_file_name = $file->name;
            $model->attachment2_file_bytes = base64_encode(file_get_contents($file->tempName));
            $model->attachment2_file_type = $file->type;
        } else {
            $model->attachment2_file_name = "";
        }

        if ($file = CUploadedFile::getInstance($model, 'attachment3')) {
            $file_name = $file->name;

            $model->attachment3_file_name = $file->name;
            $model->attachment3_file_bytes = base64_encode(file_get_contents($file->tempName));
            $model->attachment3_file_type = $file->type;
        } else {
            $model->attachment3_file_name = "";
        }
    }

    /**
     * check id soumu_qa
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
        $backCookie = Yii::app()->request->cookies->contains('soumu_qa_r_from') ? Yii::app()->request->cookies['soumu_qa_r_from']->value : '';

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
                    if ($attachment1 != Upload_file_common::getAttachmentById($id, 1, 'soumu_qa')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment1);
                    }
                }
                if ($attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment2)) {
                    if ($attachment2 != Upload_file_common::getAttachmentById($id, 2, 'soumu_qa')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment2);
                    }
                }
                if ($attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment3)) {
                    if ($attachment3 != Upload_file_common::getAttachmentById($id, 3, 'soumu_qa')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment3);
                    }
                }
            }
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
            $file_path = Upload_file_common::getAttachmentById($_GET['id'], $attachment_index, 'soumu_qa');
        } else {//download from registconfirm
            $file_path = $_GET['file_name'];
        }
        Yii::import('ext.helpers.EDownloadHelper');
        EDownloadHelper::download(Yii::getPathOfAlias('webroot') . $file_path);
        exit;
    }

    /**
     * Download attachment edit
     */
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
                        ->from('soumu_qa')
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

}