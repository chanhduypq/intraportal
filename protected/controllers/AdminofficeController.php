<?php
/*
 * Create Date: 31/07/2013
 * Update Date: 03/07/2013
 * Author: Hungtc
 * User change: Hungtc
 * Description: Admin action index object from model Rival  
 * */

class AdminofficeController extends Controller {

    private $_office = null;
	public $pageTitle;
    //check if logined or not
    public function init() {
        parent::init();
		$this->pageTitle="ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null") {
            $this->redirect(array('newgin/'));
        }
    }

    /**
     *    load model   
     */
    public function loadModel() {
        if ($this->_office === null) {
            if (isset($_GET['id'])) {
                $this->_office = Office::model()->findbyPk(intval($_GET['id']));
            } else if (isset($_POST['Office'])) {
                $data = $_POST['Office'];
                $id = $data['id'];
                $this->_office = Office::model()->findbyPk(intval($id));
            } else {
                $this->_office = new Office();
            }
            
        }
        return $this->_office;
    }
    protected function beforeAction($action) {        
        if($action->id=='regist'){
            $beforeUrl=Yii::app()->request->urlReferrer;           
            if(  
                    
                    strpos($beforeUrl, 'adminoffice/regist')==FALSE                     
                    &&isset(Yii::app()->session['officeregist'])
                    
                
                    )
            {
                if(Yii::app()->request->cookies->contains('office_regist_from')&&Yii::app()->request->cookies['office_regist_from']->value=='confirm'){                                 
                }
                else{
                    $cookie_collection =Yii::app()->request->cookies;           
                    $key_array=$cookie_collection->getKeys(); 
                    unset(Yii::app()->session['officeregist']);
                    for($i=0,$n=count($key_array);$i<$n;$i++){
                        $key=$key_array[$i];
                        if(substr($key, 0,18)=='file_office_regist'){
                            if(file_exists(Yii::getPathOfAlias('webroot') . $_COOKIE[$key])){
                                unlink(Yii::getPathOfAlias('webroot') . $_COOKIE[$key]);                            
                            }
                        }
                        if(substr($key, 0,13)=='office_regist'||substr($key, 0,18)=='file_office_regist'){
                            unset(Yii::app()->request->cookies[$key]);
                        }
                    }
                }
                                    
            }
        }
        else if($action->id=='edit'){
            $beforeUrl=Yii::app()->request->urlReferrer;           
            if(            
                    
                    
                    strpos($beforeUrl, 'adminoffice/edit')==FALSE                    
                    &&isset(Yii::app()->session['officeedit'])
                
                    )
            {
                if(Yii::app()->request->cookies->contains('office_edit_from')&&Yii::app()->request->cookies['office_edit_from']->value=='confirm'){                                 
                }
                else{
                    $cookie_collection =Yii::app()->request->cookies;           
                    $key_array=$cookie_collection->getKeys(); 
                    unset(Yii::app()->session['officeedit']);
                    for($i=0,$n=count($key_array);$i<$n;$i++){
                        $key=$key_array[$i];
                        if(substr($key, 0,16)=='file_office_edit'){
                            if(file_exists(Yii::getPathOfAlias('webroot') . $_COOKIE[$key])){
                                unlink(Yii::getPathOfAlias('webroot') . $_COOKIE[$key]);                            
                            }
                        }
                        if(substr($key, 0,11)=='office_edit'||substr($key, 0,16)=='file_office_edit'){
                            unset(Yii::app()->request->cookies[$key]);
                        }
                    }
                }
                                    
            }
        }
        return parent::beforeAction($action);
        
    }

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
        $offices = Yii::app()->db->createCommand()
                ->select(array(
                    '*'
                        )
                )
                ->from('office')                
                ->limit($page_size, ($page - 1) * $page_size)
                ->order('office.created_date desc')
                ->queryAll();
        $item_count = Yii::app()->db->createCommand()
                ->select('count(*) as count')
                ->from('office')
                ->queryScalar();

        $pages = new CPagination($item_count);
        $pages->setPageSize($page_size);
        $this->render('/admin/office/index', array(
            'offices' => $offices,
            'pages' => $pages,            
            'item_count' => $item_count,
            'page_size' => $page_size));
    }

    /**
     * Regist 
     */
    public function actionRegist() {
        $parmas = array();
        $model = new Office();
        

        if (Yii::app()->request->isAjaxRequest) {
            $model = new Office();            
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }        
        $attachment4_error = isset(Yii::app()->session['attachment4']) ? Yii::app()->params['attachment4_error'] : '';
        
        unset(Yii::app()->session['attachment4']);
        $parmas['model'] = $model;        
        $parmas['attachment4_error'] = $attachment4_error;
        $this->render('/admin/office/regist', $parmas);
    }

    /**
     * Regist confirm
     */
    public function actionRegistConfirm() {
       
        $model = new Office();
        if (Yii::app()->request->isPostRequest) {
            Yii::app()->session['officeregist'] = 'true';  
            CActiveForm::validate($model);
            if (!isset($_POST['regist']) || $_POST['regist'] != '1') {
                Upload_file_common_new::processAttachmentsoffice($model, 1);
            }
            
            /**
             *
             */
            if ($model->validate()||$model->photo_checkbox_for_deleting=='1') {            
                if (isset($_POST['regist']) && $_POST['regist'] == '1') {                    
                    if(isset($_POST['Office']['photo'])){
                        $model->photo = $_POST['Office']['photo'];
                    }
                    else{
                        $model->photo = NULL;
                    }
                    
                    if ($model->save() == true) {
                        unset(Yii::app()->session['officeregist']);
                        $cookie_collection =Yii::app()->request->cookies;           
                        $key_array=$cookie_collection->getKeys();                 
                        for($i=0,$n=count($key_array);$i<$n;$i++){
                            $key=$key_array[$i];
                            if(substr($key, 0,13)=='office_regist'||substr($key, 0,18)=='file_office_regist'){
                                unset(Yii::app()->request->cookies[$key]);                                
                            }
                        }     
                        if (Yii::app()->request->cookies['page'] != "") {
                            $page = "index?page=" . Yii::app()->request->cookies['page'];
                        } else {
                            $page = "";
                        }
                        $this->redirect(array('adminoffice/' . $page . ''));
                    }
                }
            } else {                
                if ($model->getError("photo") != "") {
                    Yii::app()->session['attachment4'] = true;
                }

                
                if ($model->photo != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->photo)) {
                    unlink(Yii::getPathOfAlias('webroot') . $model->photo);
                }
                unset(Yii::app()->session['officeregist']);
                $cookie_collection =Yii::app()->request->cookies;           
                $key_array=$cookie_collection->getKeys();                 
                for($i=0,$n=count($key_array);$i<$n;$i++){
                    $key=$key_array[$i];
                    if(substr($key, 0,13)=='office_regist'||substr($key, 0,18)=='file_office_regist'){
                        unset(Yii::app()->request->cookies[$key]);
                        if(substr($key, 0,4)=='file'){
                            if (Yii::app()->request->cookies[$key]!=""&&Yii::app()->request->cookies[$key]!="null"&&file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value)) {
                                unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value);
                            }                            
                        }
                    }
                }      
                
                
                $this->redirect(array('adminoffice/regist'));
            }

            $parmas['model'] = $model;
            
            $this->render('/admin/office/registconfirm', $parmas);
        } else {
            $this->redirect(array('adminoffice/index'));
        }
    }

    

    

    public function actionEdit() {

        
        $model = $this->loadModel();
        if($model==NULL){
            $this->redirect(array('adminoffice/index'));
        }

        $parmas = array();
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel();
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if ($model == null || !isset($_GET['id'])) {
            $this->redirect(array('adminoffice/index'));
        }        
        $attachment4_error = isset(Yii::app()->session['attachment4']) ? Yii::app()->params['attachment4_error'] : '';        
        unset(Yii::app()->session['attachment4']);
        $parmas['model'] = $model;
        $parmas['attachment4_error'] = $attachment4_error;
        $this->render('/admin/office/edit', $parmas);
    }

    /**
     * 
     */
    public function actionEditconfirm() {
       
        $model = $this->loadModel();
        if (Yii::app()->request->isPostRequest) {
            Yii::app()->session['officeedit'] = 'true';  
            CActiveForm::validate($model);           
            if (!isset($_POST['edit']) || $_POST['edit'] != '1') {
                Upload_file_common_new::processAttachmentsoffice($model,2);
            }
            if ($model->id == null || $model->id == '') {
                $this->redirect(array('adminoffice/index'));
            }
            if ($model->validate()||$model->photo_checkbox_for_deleting=='1') {            
                if (isset($_POST['edit']) && $_POST['edit'] == '1') {
                    
                    if(isset($_POST['Office']['photo'])){
                        $model->photo = $_POST['Office']['photo'];
                    }
                    else{
                        $model->photo = NULL;
                    }
                    if ($model->save() == true) {
                        unset(Yii::app()->session['officeedit']);
                        $cookie_collection =Yii::app()->request->cookies;           
                        $key_array=$cookie_collection->getKeys();                 
                        for($i=0,$n=count($key_array);$i<$n;$i++){
                            $key=$key_array[$i];
                            if(substr($key, 0,11)=='office_edit'||substr($key, 0,16)=='file_office_edit'){
                                unset(Yii::app()->request->cookies[$key]);                                
                            }
                        }     
                        $this->redirect(array('adminoffice/index'));
                    }
                }
            } else {
                
                if ($model->getError("photo") != "") {
                    Yii::app()->session['attachment4'] = true;
                }
                
                if ($model->photo != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->photo)) {
                    unlink(Yii::getPathOfAlias('webroot') . $model->photo);
                }
                unset(Yii::app()->session['officeedit']);
                $cookie_collection =Yii::app()->request->cookies;           
                $key_array=$cookie_collection->getKeys();                 
                for($i=0,$n=count($key_array);$i<$n;$i++){
                    $key=$key_array[$i];
                    if(substr($key, 0,11)=='office_edit'||substr($key, 0,16)=='file_office_edit'){
                        unset(Yii::app()->request->cookies[$key]);
                        if(substr($key, 0,4)=='file'){
                            if (Yii::app()->request->cookies[$key]!=""&&Yii::app()->request->cookies[$key]!="null"&&file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value)) {
                                unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value);
                            }                            
                        }
                    }
                }                
                
                $this->redirect(array('adminoffice/edit/?id=' . $model->id));
            }
        }
        else{
            $this->redirect(array('adminoffice/index'));
        }
        $this->render('/admin/office/editconfirm', array('model' => $model));
    }

    /**
     * 
     */
    public function actionDetail() {
        
        $model = $this->loadModel();
        if ($_GET['id'] == "") {
            $this->redirect(array('adminoffice/index'));
        }

        if ($model->division_name == null) {
            $this->redirect(array('adminoffice/index'));
        } else {
            $this->render('/admin/office/detail', array(
                'model' => $model,
                
                    )
            );
        }
    }
    /**
     *  download regist
     */
    public function actionDownload() {
        $attachment_index = 0;
        if (isset($_GET['1'])) {
            $attachment_index = 1;
        } else if (isset($_GET['2'])) {
            $attachment_index = 2;
        } else if (isset($_GET['3'])) {
            $attachment_index = 3;
        } else if (isset($_GET['4'])) {
            $attachment_index = 4;
        }
        if ($attachment_index != 0) {//download from detail                   
            $file_path =  $this->getPhoto($_GET['id']);
        } else {//download from registconfirm
            $file_path = $_GET['file_name'];
        }
        Yii::import('ext.helpers.EDownloadHelper');
        EDownloadHelper::download(Yii::getPathOfAlias('webroot') . $file_path);
        exit;
    }
    private function getPhoto($id) {
        $attachment = Yii::app()->db->createCommand()->select('photo')->from('office')->where("id=$id")->queryScalar();
        
        if ($attachment == FALSE) {
            return '';
        }
        return $attachment;
    }

    /**
     *  download edit
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
                        ->from('office')
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
     * 
     */
    public function actionDelete() {
        $id = Yii::app()->request->getParam('id');
        $model = new Office();
        $model = $model->findByPk($id);
        if ($model == NULL) {
            return;
        }
        
        $attachment4 = $model->photo;
        $transaction = $model->dbConnection->beginTransaction();
        $affected_base = $model->deleteByPk($id);
        if (!$affected_base) {
            $transaction->rollback();
        } else {
            $transaction->commit();
        }
        if ($affected_base == 1) {
            
            if ($attachment4 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment4)) {
                unlink(Yii::getPathOfAlias('webroot') . $attachment4);
                $thumnail_file_path=  FunctionCommon::getFilenameInThumnail($attachment4);
                if(file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)){
                    unlink(Yii::getPathOfAlias('webroot') . $thumnail_file_path);
                }
            }
            
        }
        $this->redirect(array('/adminoffice/index'));
    }

    

    //fix back browsers
    public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('office_regist_from') ? Yii::app()->request->cookies['office_regist_from']->value : '';

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

}