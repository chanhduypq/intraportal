<?php

class AdminskillController extends Controller {

	public $pageTitle;
    private $_skill = null;

    public function init() 
	{
        parent::init();
		$this->pageTitle="ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null")
		{
            $this->redirect(array('newgin/'));
        }
    }
	
    /**
     * display list skill
     */
    public function actionIndex() {

        //set cookie
        $page = isset($_GET['page']) ? $_GET['page'] : '';
        $cookie = new CHttpCookie('page', $page);
        Yii::app()->request->cookies['page'] = $cookie;

       $criteria = new CDbCriteria();
		// $category = Category::model()->findAll();
       $criteria->select = '*';
       $criteria->condition = FunctionCommon::isAdmin() == FALSE ? "contributor_id=" . Yii::app()->request->cookies['id'] : "true";
       $criteria->order = 'created_date DESC';

        $item_count = Skill::model()->count($criteria);
        $pages = new CPagination($item_count);
        $pages->pageSize = Yii::app()->params['listPerPage'];
        $pages->applyLimit($criteria);

        $skills = Skill::model()->findAll($criteria);
	
        $this->render('/admin/skill/index', array(
           'skills' => $skills,
	//	   'category'=>$category,
           'pages' => $pages));
    }

    /**
     * edit record id
     */
    public function actionEdit() 
	{
        $parmas = array();
        $model = $this->loadModel();
		$category = Category::model()->findAll('type=4');
        if ($model == null || !isset($_GET['id'])) 
		{
            $this->redirect(array('adminskill/index'));
        }

        if (Yii::app()->request->isAjaxRequest) 
		{
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
		$parmas['category']=$category;   
        $parmas['attachment1_error'] = $attachment1_error;
        $parmas['attachment2_error'] = $attachment2_error;
        $parmas['attachment3_error'] = $attachment3_error;
        $this->render('/admin/skill/edit', $parmas);
    }

    /**
     * edit confirm
     */
    public function actionEditconfirm() 
	{
        $model = $this->loadModel();
		$category = Category::model()->findAll();
		if(empty($_POST['Skill']['title']) || empty($_POST['Skill']['category_id']))
		{
			 $this->redirect(array('adminskill/index'));
		}

		$ca = Yii::app()->db->createCommand("select * from category where id=".$_POST['Skill']['category_id'])->queryRow();

		if(empty($ca['id']))
		{
			$this->redirect(array('adminskill/index'));
		}	
		
         
        if (Yii::app()->request->isPostRequest)
		{
            CActiveForm::validate($model);
            if (!isset($_POST['edit']) || $_POST['edit'] != '1') 
			{

                Upload_file_common_new::processAttachments($model, 'skill', 2);
            }
            if ($model->id == null || $model->id == '') {
                $this->redirect(array('adminskill/index'));
            }
            if ($model->validate())
			{
                if (isset($_POST['edit']) && $_POST['edit'] == '1') 
				{
                    $model->attachment1 = $_POST['Skill']['attachment1'];
                    $model->attachment2 = $_POST['Skill']['attachment2'];
                    $model->attachment3 = $_POST['Skill']['attachment3'];
                    if ($model->save())
					{
                        if (Yii::app()->request->cookies['page'] != "") 
						{
                            $page = "index?page=" . Yii::app()->request->cookies['page'];
                        } 
						else
						{
                            $page = "";
                        }
                        $this->redirect(array('adminskill/' . $page . ''));
                    }
                }
            }
			else 
			{
                if ($model->getError("attachment1") != "")
				{
                    Yii::app()->session['attachment1'] = true;
                }

                if ($model->getError("attachment2") != "")
				{
                    Yii::app()->session['attachment2'] = true;
                }

                if ($model->getError("attachment3") != "")
				{
                    Yii::app()->session['attachment3'] = true;
                }

                if ($model->attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment1))
				{
                    if ($model->attachment1 != Upload_file_common::getAttachmentById($model->id, 1, 'skill'))
					{
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment1);
                    }
                }
                if ($model->attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment2))
				{
                    if ($model->attachment2 != Upload_file_common::getAttachmentById($model->id, 2, 'skill')) 
					{
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment2);
                    }
                }
                if ($model->attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment3))
				{
                    if ($model->attachment3 != Upload_file_common::getAttachmentById($model->id, 3, 'skill')) 
					{
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment3);
                    }
                }
                $cookie_collection = Yii::app()->request->cookies;
                $key_array = $cookie_collection->getKeys();
                for ($i = 0, $n = count($key_array); $i < $n; $i++)
				{
                    $key = $key_array[$i];
                    if (substr($key, 0, 4) == 'file')
					{
                        if (Yii::app()->request->cookies[$key] != "" && Yii::app()->request->cookies[$key] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value)) {
                            unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value);
                        }
                        unset(Yii::app()->request->cookies[$key]);
                    }
                }
                $this->redirect(array('adminskill/edit/?id=' . $model->id));
            }
        }
        $this->render('/admin/skill/editconfirm', array('model' => $model,'category'=>$category));
    }

    /**
     * Detail id
     */
    public function actionDetail() {
        $model = $this->loadModel();
		$category = Category::model()->findAll();
        if (!empty($model->title)) {

            $this->render('/admin/skill/detail', array(
                'model' => $model,'category'=>$category));
        } else {
            $this->redirect(array('/adminskill/index'));
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
            $file_path = Upload_file_common::getAttachmentById($_GET['id'], $attachment_index, 'skill');
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
                        ->from('skill')
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
        $model = new Skill();
		$category = Category::model()->findAll('type=4');
        if (Yii::app()->request->isAjaxRequest)
		{
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
		$parmas['category']=$category;   
        $parmas['attachment1_error'] = $attachment1_error;
        $parmas['attachment2_error'] = $attachment2_error;
        $parmas['attachment3_error'] = $attachment3_error;
        $this->render('/admin/skill/regist', $parmas);
    }

    /**
     * Regist confirm
     */
    public function actionRegistconfirm() {
        $model = new Skill();
		$category = Category::model()->findAll();
		if(empty($_POST['Skill']['title']) || empty($_POST['Skill']['category_id']))
		 {
			 $this->redirect(array('adminskill/index'));
		 }
		$ca = Yii::app()->db->createCommand("select * from category where id=".$_POST['Skill']['category_id'])->queryRow();
		if($ca['id']==""){ $this->redirect(array('adminskill/index'));}	
		
		 
        if (Yii::app()->request->isPostRequest) {
            CActiveForm::validate($model);
            if (!isset($_POST['regist']) || $_POST['regist'] != '1') {
                Upload_file_common_new::processAttachments($model, 'skill', 1);
            }
            if ($model->validate())
			{
                if (isset($_POST['regist']) && $_POST['regist'] == '1')
				{
                    $model->attachment1 = $_POST['Skill']['attachment1'];
                    $model->attachment2 = $_POST['Skill']['attachment2'];
                    $model->attachment3 = $_POST['Skill']['attachment3'];
                    if ($model->save() == true)
					{
                        $this->redirect(array('adminskill/index'));
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
                $this->redirect(array('adminskill/regist'));
            }
        }
        $this->render('/admin/skill/registconfirm', array('model' => $model,'category'=>$category));
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
                    if ($attachment1 != Upload_file_common::getAttachmentById($id, 1, 'skill')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment1);
                    }
                }
                if ($attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment2)) {
                    if ($attachment2 != Upload_file_common::getAttachmentById($id, 2, 'skill')) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment2);
                    }
                }
                if ($attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment3)) {
                    if ($attachment3 != Upload_file_common::getAttachmentById($id, 3, 'skill')) {
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

        $model = new Skill();

        $model = $model->findByPk($id);
        if ($model == NULL) {
            return;
        }

        $attachment1 = $model->attachment1;
        $attachment2 = $model->attachment2;
        $attachment3 = $model->attachment3;

        $transaction = $model->dbConnection->beginTransaction();

        $affected_skill = $model->deleteByPk($id);
        $affected_update_information = Yii::app()->db->createCommand()->delete(
                "update_information", "table_name=:table_name and article_id=:article_id", array(
            "article_id" => $id,
            "table_name" => 'skill',
                ))
        ;

        if ($id) {
            $transaction->commit();
        } else {
            $transaction->rollback();
        }

        if ($affected_skill == 1) {
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

        $this->redirect(array('/adminskill/index'));
    }

    /**
     * loadModel
     */
    public function loadModel() {
        if ($this->_skill === null) {
            if (isset($_GET['id'])) {
                $this->_skill = Skill::model()->findbyPk(intval($_GET['id']));
            } else if (isset($_POST['Skill'])) {
                $data = $_POST['Skill'];
                $id = $data['id'];
                $this->_skill = Skill::model()->findbyPk(intval($id));
            } else {
                $this->_skill = new Skill();
            }
        }
        return $this->_skill;
    }

    /**
     * check id skill
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
        $backCookie = Yii::app()->request->cookies->contains('skill_regist_from') ? Yii::app()->request->cookies['skill_regist_from']->value : '';

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