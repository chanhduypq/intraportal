<?php

/*
 * Create Date: 17/07/2013
 * Update Date: 24/07/2013
 * Author: Hungtc
 * User change: Hungtc
 * Description: Admin action index object from model Rival  
 * */

class AdminrivalController extends Controller {

	public $pageTitle;
    private $_rival = null;

    public function loadModel() {
        if ($this->_rival === null) {
            if (isset($_GET['id'])) {
                $this->_rival = Rival::model()->findbyPk(intval($_GET['id']));
            } else if (isset($_POST['Rival'])) {
                $data = $_POST['Rival'];
                $id = $data['id'];
                $this->_rival = Rival::model()->findbyPk(intval($id));
            } else {
                $this->_rival = new Rival();
            }
        }
        return $this->_rival;
    }

    //check if logined or not
    public function init() {
        parent::init();
		$this->pageTitle="ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null") {
            $this->redirect(array('newgin/'));
        }
    }

    //fix back browsers
    public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('rival_edit_from') ? Yii::app()->request->cookies['rival_edit_from']->value : '';
        if (!is_null($backCookie) && !empty($backCookie)) {
            return array(array('application.extensions.PerformanceFilter - edit'),);
        } else {
            return array('accessControl',);
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

    /**
     * Download attachment edit
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
                        ->from('rival')
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

    public function actionIndex() {

        //set cookie
        $page = isset($_GET['page']) ? $_GET['page'] : '';
        $cookie = new CHttpCookie('page', $page);
        Yii::app()->request->cookies['page'] = $cookie;

        $criteria = new CDbCriteria();
        $criteria->select = '*';
        $criteria->condition = FunctionCommon::isAdmin() == FALSE ? "contributor_id=" . Yii::app()->request->cookies['id'] : "true";
        $criteria->order = 'created_date DESC';

        $item_count = Rival::model()->count($criteria);
        $pages = new CPagination($item_count);
        $pages->pageSize = Yii::app()->params['listPerPage'];
        $pages->applyLimit($criteria);

        $model = Rival::model()->findAll($criteria);
        $this->render('/admin/rival/index', array('model' => $model, 'pages' => $pages));
    }

    public function actionDetail($id) {
        $model = $this->loadModel();
        if (count($model) > 0) {
            
            $rival_comments=Yii::app()->db->createCommand("select * from rival_response where rival_id=".$_GET['id']." order by created_date ASC")->queryAll();
						$user			= User::model()->findAll();										
						$this->render('/admin/rival/detail', array(
							'model' => $model,
							'rival_comments'=>$rival_comments,
							'user'=>$user,
								)
						);
            
        } else {
            $this->redirect(array('adminrival/index'));
        }
    }

    public function actionEdit() {
        $parmas = array();
        $model = $this->loadModel();
        if ($model == null || !isset($_GET['id'])) {
            $this->redirect(array('adminrival/index'));
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
        $this->render('/admin/rival/edit', $parmas);
    }

    public function actionEditconfirm() {

        $model = $this->loadModel();

        if (Yii::app()->request->isPostRequest) 
		{
            CActiveForm::validate($model);
            if (!isset($_POST['edit']) || $_POST['edit'] != '1') {
                Upload_file_common_new::processAttachments($model, 'rival', 2);
            }
            if ($model->id == null || $model->id == '') {
                $this->redirect(array('adminrival/index'));
            }
            if ($model->validate()) {
                if (isset($_POST['edit']) && $_POST['edit'] == '1') {
                    $model->attachment1 = $_POST['Rival']['attachment1'];
                    $model->attachment2 = $_POST['Rival']['attachment2'];
                    $model->attachment3 = $_POST['Rival']['attachment3'];
                    if ($model->save() == true) {
                        if (Yii::app()->request->cookies['page'] != "") {
                            $page = "index?page=" . Yii::app()->request->cookies['page'];
                        } else {
                            $page = "";
                        }
                        $this->redirect(array('adminrival/' . $page . ''));
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
                    if ($model->attachment1 != Upload_file_common::getAttachmentById($model->id, 1, 'rival')) {
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment1);
                    }
                }
                if ($model->attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment2)) {
                    if ($model->attachment2 != Upload_file_common::getAttachmentById($model->id, 2, 'rival')) {
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment2);
                    }
                }
                if ($model->attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment3)) {
                    if ($model->attachment3 != Upload_file_common::getAttachmentById($model->id, 3, 'rival')) {
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
                $this->redirect(array('adminrival/edit/?id=' . $model->id));
            }
		 $this->render('/admin/rival/editconfirm', array('model' => $model));		
        }
		else
		{
			  $this->redirect(array('adminrival/index'));
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
                    if ($attachment1 != Upload_file_common::getAttachmentById($id, 1, 'rival')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment1);
                    }
                }
                if ($attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment2)) {
                    if ($attachment2 != Upload_file_common::getAttachmentById($id, 2, 'rival')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment2);
                    }
                }
                if ($attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment3)) {
                    if ($attachment3 != Upload_file_common::getAttachmentById($id, 3, 'rival')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment3);
                    }
                }
            }
        }
    }
    public function actionDeleteidrivalresponse() {

        $id=Yii::app()->request->getParam('id'); 
		$id2=Yii::app()->request->getParam('id2'); 
		
        
        

  	 	Yii::app()->db->createCommand()->delete("rival_response",'id=:id',array('id'=>$id2));	



        $this->redirect(array('adminrival/detail/?id='.$id));
    } 

    public function actionDelete() {

        $id = Yii::app()->request->getParam('id');
        $model = Rival::model();

        $transaction = $model->dbConnection->beginTransaction();
        $model = $model->findByPk($id);

        //check if id existed
        if ($model->id != $id) {
            $this->redirect(array('adminrival/index'));
        }

        if (!is_null($model)) {
            $attachment1 = $model->attachment1;
            $attachment2 = $model->attachment2;
            $attachment3 = $model->attachment3;

            $affected_rival = $model->deleteByPk($id);

            $affected_update_information = Yii::app()->db->createCommand()->delete(
                    "update_information", "table_name=:table_name and article_id=:article_id", array("article_id" => $id, "table_name" => 'rival',));

            Yii::app()->db->createCommand()->delete(
                                                                            "rival_response",                                                                             
                                                                            "rival_id=:rival_id",
                                                                            array(
                                                                                "rival_id"=>$id,
                                                                            ));
            if ($affected_rival != $affected_update_information) {
                $transaction->rollback();
            } else {
                $transaction->commit();
            }
            

            if ($affected_rival == 1) {
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
            $this->redirect(array('adminrival/index'));
        }
    }

    /**
     * check id criticism
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

}