<?php

class Asobihobby_itdController extends Controller {

	public $pageTitle;
    private $_hobby_itd = null;

    public function init() {
        parent::init();
		$this->pageTitle="製品アイデア投稿広場 | ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null") {
            $this->redirect(array('newgin/'));
        }
    }

    /**
     * 
     */
    public function actionIndex() {

		$this->pageTitle="あそびにマジメ！？あそび自慢＆対決！ | ニューギンスクエア";
        //set cookie page
        $page = isset($_GET['page']) ? $_GET['page'] : '';
        $cookie = new CHttpCookie('page', $page);
        Yii::app()->request->cookies['page'] = $cookie;

        $criteria = new CDbCriteria();
        $criteria->select = '*';
        $criteria->condition=(FunctionCommon::isPostFunction("hobby_itd")&&!FunctionCommon::isViewFunction("hobby_itd"))?"contributor_id=".Yii::app()->request->cookies['id']:"true";
        $criteria->order = 'created_date DESC';

        $item_count = Hobby_itd::model()->count($criteria);
        $pages = new CPagination($item_count);
        $pages->pageSize = Yii::app()->params['listPerPage'];
        $pages->applyLimit($criteria);

        $hobby_itds = Hobby_itd::model()->findAll($criteria);
        $this->render('/asobi/hobby_itd/index', array(
            'hobby_itds' => $hobby_itds,
            'pages' => $pages));
    }

    /**
     * 
     */
    public function actionRegist() {
        $parmas = array();
        $model = new Hobby_itd();
        if (Yii::app()->request->isAjaxRequest) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        $attachment1_error = isset(Yii::app()->session['attachment1']) ? Yii::app()->params['attachment1_error'] : '';
        $attachment2_error = isset(Yii::app()->session['attachment2']) ? Yii::app()->params['attachment2_error'] : '';
        $attachment3_error = isset(Yii::app()->session['attachment3']) ? Yii::app()->params['attachment3_error'] : '';
        $attachment4_error = isset(Yii::app()->session['attachment4']) ? Yii::app()->params['attachment4_error'] : '';
        unset(Yii::app()->session['attachment1']);
        unset(Yii::app()->session['attachment2']);
        unset(Yii::app()->session['attachment3']);
        unset(Yii::app()->session['attachment4']);
        $parmas['model'] = $model;
        $parmas['attachment1_error'] = $attachment1_error;
        $parmas['attachment2_error'] = $attachment2_error;
        $parmas['attachment3_error'] = $attachment3_error;
        $parmas['attachment4_error'] = $attachment4_error;
        $this->render('/asobi/hobby_itd/regist', $parmas);
    }

    /**
     * 
     */
    public function actionDeleteattechments() {
        if (Yii::app()->request->isAjaxRequest) {
            $no = Yii::app()->request->getParam('no');
            if ($no == '1') {
                $attachment1 = Yii::app()->request->getParam('attachment1');
                $attachment2 = Yii::app()->request->getParam('attachment2');
                $attachment3 = Yii::app()->request->getParam('attachment3');
                $attachment4 = Yii::app()->request->getParam('attachment4');
                if ($attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment1)) {
                    unlink(Yii::getPathOfAlias('webroot') . $attachment1);
                }
                if ($attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment2)) {
                    unlink(Yii::getPathOfAlias('webroot') . $attachment2);
                }
                if ($attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment3)) {
                    unlink(Yii::getPathOfAlias('webroot') . $attachment3);
                }
                if ($attachment4 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment4)) {
                    unlink(Yii::getPathOfAlias('webroot') . $attachment4);
                }
            }
        }
    }

    /**
     * 
     */
    public function actionRegistconfirm() {
        $model = new Hobby_itd();
        if (Yii::app()->request->isPostRequest) {
            CActiveForm::validate($model);
            if (!isset($_POST['regist']) || $_POST['regist'] != '1') {
                Upload_file_common_new::processAttachments($model, 'hobby_itd', 1);
            }
            if ($model->validate()) {                                
                if (isset($_POST['regist']) && $_POST['regist'] == '1') {
                    $model->attachment1 = $_POST['Hobby_itd']['attachment1'];
                    $model->attachment2 = $_POST['Hobby_itd']['attachment2'];
                    $model->attachment3 = $_POST['Hobby_itd']['attachment3'];
                    
                    if(isset($_POST['Hobby_itd']['eye_catch'])){
                        $model->eye_catch = $_POST['Hobby_itd']['eye_catch'];
                    }
                    else{
                        $model->eye_catch = NULL;
                    }
                    if ($model->save() == true) {
                         if(FunctionCommon::isViewFunction("hobby_itd")==false){
                        	 $this->redirect(array('asobi/'));
                        }
                        else{
                            $this->redirect(array('asobihobby_itd/index'));

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
                if ($model->getError("eye_catch") != "") {
                    Yii::app()->session['attachment4'] = true;
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
                if ($model->eye_catch != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->eye_catch)) {
                    unlink(Yii::getPathOfAlias('webroot') . $model->eye_catch);
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
                $this->redirect(array('asobihobby_itd/regist'));
            }
        }
        else{
            $this->redirect(array('asobihobby_itd/index'));
        }

        $this->render('/asobi/hobby_itd/registconfirm', array('model' => $model));
    }

    /**
     * 
     */
    public function actionDetail() {
        $model = $this->loadModel();
        //$model = Yii::app()->db->createCommand("select * from hobby_itd where id=".$_GET['id'])->queryRow();
        if (!empty($model->id)) {
            $this->render('/asobi/hobby_itd/detail', array(
                'model' => $model,
                    )
            );
        } else {
            $this->redirect(array('/asobihobby_itd/index'));
        }
    }

    public function loadModel() {
        if ($this->_hobby_itd === null) {
            if (isset($_GET['id'])) {
                $this->_hobby_itd = Hobby_itd::model()->findbyPk(intval($_GET['id']));
            } else if (isset($_POST['Hobbyt_itd'])) {
                $data = $_POST['Hobbyt_itd'];
                $id = $data['id'];
                $this->_hobby_itd = Hobby_itd::model()->findbyPk(intval($id));
            } else {
                $this->_hobby_itd = new Hobby_itd();
            }
        }
        return $this->_hobby_itd;
    }

    /**
     * 
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
            $file_path = Upload_file_common::getAttachmentById($_GET['id'], $attachment_index, 'hobby_itd');
        } else {//download from registconfirm
            $file_path = $_GET['file_name'];
        }
        Yii::import('ext.helpers.EDownloadHelper');
        EDownloadHelper::download(Yii::getPathOfAlias('webroot') . $file_path);
        exit;
    }

    //fix back browsers
    public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('hobby_itd_regist_from') ? Yii::app()->request->cookies['hobby_itd_regist_from']->value : '';
        if ($backCookie != "" || $backCookie != NULL) {
            return array(
                array('application.extensions.PerformanceFilter -  regist'),
            );
        } else {
            return array(
                'accessControl',
            );
        }
    }

}