<?php

class Admingolf_newsController extends Controller {

	public $pageTitle;
    public function init() {
        parent::init();
		$this->pageTitle="ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null") {
            $this->redirect(array('newgin/'));
        }
     
      
    }

    public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('golf_news_edit_title') ? Yii::app()->request->cookies['golf_news_edit_title']->value : '';

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
    private $_golf_news = null;

    /**
     * 
     */
    public function actionIndex() {
        /**
         * 
         */
        $page = (isset($_GET['page']) ? $_GET['page'] : 1);
        $cookie = new CHttpCookie('page', $page);
        $cookie->expire = Config::TIME_OUT;
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
                ->from('golf_news')
                ->where(FunctionCommon::isAdmin() == FALSE ? "contributor_id=" . Yii::app()->request->cookies['id'] : "true")
                ->queryScalar();
        /**
         * 
         */
        $golf_news = Yii::app()->db->createCommand()
                ->select(array(
                    'golf_news.id',
                    'golf_news.title',                    
                    'golf_news.created_date', 
                    'golf_news.last_updated_date', 
                        )
                )
                ->from('golf_news')
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
        $params = array('golf_news' => $golf_news,
            'item_count' => $item_count,
            'page_size' => $page_size,
            'pages' => $pages);
        /**
         * 
         */
        $this->render('/admin/golf_news/index', $params);
    }

    /**
     * 
     */
    public function actionEdit() {

        /**
         * 
         */
        $parmas = array();
        $items=Yii::app()->db->createCommand()
                ->select(array(
                    "id",
                    "category_name",
                    "background_color",
                    "text_color",                    
                ))
                ->from("category")
                ->where("type=5")
                ->queryAll();
        $cagories=array();
        if(count($items)>0){
            foreach ($items as $item){
                $cagories[$item['id']]=array(
                    'category_name'=>$item['category_name'],
                    'background_color'=>$item['background_color'],
                    'text_color'=>$item['text_color'],                    
                    );
            }
        }
        $parmas['cagories']=$cagories;                
        /**
         * 
         */
        $model = $this->loadModel();
        if ($model == null || !isset($_GET['id'])) {
            $this->redirect(array('admingolf_news/index'));
        }
        /**
         * 
         */
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
        $this->render('/admin/golf_news/edit', $parmas);
    }

    public function actionCategories() {
        $page = (isset($_GET['page']) ? $_GET['page'] : 1);
        $cookie = new CHttpCookie('page', $page);
        Yii::app()->request->cookies['page'] = $cookie;
        /**
         * 
         */
        $page_size = 10;
        /**
         * 
         */
        $item_count = Yii::app()->db->createCommand()
                ->select('count(*) as count')
                //->where('type=:type', array('type' => 4))
                ->from('View_CategoryAndGolfnews')
                ->queryScalar();
        /**
         * 
         */
        $categories = Yii::app()->db->createCommand()
                ->select(array(
                    '*',
                        )
                )
                ->from('View_CategoryAndGolfnews')
                //->where('type=:type', array('type' => 4))
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
        $params = array('categories' => $categories,
            'item_count' => $item_count,
            'page_size' => $page_size,
            'pages' => $pages);
        /**
         * 
         */
        $this->render('/admin/golf_news/categories', $params);
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
        if(isset($_POST['Golfnews']['category_id'])&&  is_numeric($_POST['Golfnews']['category_id'])){
                $id_gol = Yii::app()->db->createCommand("select id from category where id=".$_POST['Golfnews']['category_id'])->queryScalar();
                if($id_gol==FALSE){
                        $this->redirect(array('asobigolf_news/index'));
                }
         }
		 
        if (Yii::app()->request->isPostRequest) {
            CActiveForm::validate($model);
            if (!isset($_POST['edit']) || $_POST['edit'] != '1') {                
                Upload_file_common_new::processAttachments($model,'golf_news',2);
            }  
           
            
            if ($model->id == null || $model->id == '') {
                $this->redirect(array('admingolf_news/index'));
            }
            /**
             *
             */
            if ($model->validate()) {
                /**
                 *
                 */
                if (isset($_POST['edit']) && $_POST['edit'] == '1') {
                    $model->attachment1 = $_POST['Golfnews']['attachment1'];
                    $model->attachment2 = $_POST['Golfnews']['attachment2'];
                    $model->attachment3 = $_POST['Golfnews']['attachment3'];
                   
                    if(isset($_POST['Golfnews']['eye_catch'])){
                        $model->eye_catch = $_POST['Golfnews']['eye_catch'];
                    }
                    else{
                        $model->eye_catch = NULL;
                    }
                    if ($model->save() == true) {                        
                        if(Yii::app()->request->cookies['page']!= "") 
                        {
                                   $page = "index?page=".Yii::app()->request->cookies['page'];

                        }else {$page ="";}
                        $this->redirect(array('admingolf_news/'.$page.''));
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
                    if ($model->attachment1 != Upload_file_common::getAttachmentById($model->id, 1,'golf_news')) {
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment1);
                    }
                }
                if ($model->attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment2)) {
                    if ($model->attachment2 != Upload_file_common::getAttachmentById($model->id, 2,'golf_news')) {
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment2);
                    }
                }
                if ($model->attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment3)) {
                    if ($model->attachment3 != Upload_file_common::getAttachmentById($model->id, 3,'golf_news')) {
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment3);
                    }
                }
                if ($model->eye_catch != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->eye_catch)) {                    
                    if ($model->eye_catch != $model->getEyeCatch($model->id)) {
                        unlink(Yii::getPathOfAlias('webroot') . $model->eye_catch);
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
                $this->redirect(array('admingolf_news/edit/?id=' . $model->id));
            }
        }
        else{
            $this->redirect(array('admingolf_news/index'));
        }
        $this->render('/admin/golf_news/editconfirm', array('model' => $model));
    }

    

    

    /**
     * 
     */
    public function actionDetail() {

        if (!isset($_GET['id'])||!is_numeric($_GET['id'])) {
            $this->redirect(array('admingolf_news/index'));
        }
		$id_gol = Yii::app()->db->createCommand("select * from golf_news where id=".$_GET['id'])->queryRow();
		if($id_gol==""){
			$this->redirect(array('admingolf_news/index'));
		}
        $model = Golfnews::model()->findbyPk(intval($_GET['id']));
        $golf_news_list_comments	= Yii::app()->db->createCommand("select * from golf_news_comment where golf_news_id=".$_GET['id']." order by created_date ASC")->queryAll();	
		$user						= User::model()->findAll();
                
       if($model->category_id!=""){
            $category=Yii::app()->db->createCommand()
                ->select(array('category_name','background_color','text_color'))
                ->from('category')
                ->where('id='.$model->category_id)
                ->queryRow();
        }
        else{
            $category=array(
                'category_name'=>'',
                'background_color'=>'',
                'text_color'=>'',
            );
        }
        $this->render('/admin/golf_news/detail', array(
            'model' => $model,
            'category_name'=>$category['category_name'],
            'background_color'=>$category['background_color'],
            'text_color'=>$category['text_color'],
			'golf_news_list_comments'=>$golf_news_list_comments,
			'user'=>$user,
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
                        ->from('golf_news')
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
        if ($this->_golf_news === null) {
            if (isset($_GET['id'])) {
                $this->_golf_news = Golfnews::model()->findbyPk(intval($_GET['id']));
            } else if (isset($_POST['Golfnews'])) {
                $data = $_POST['Golfnews'];
                $id = $data['id'];
                $this->_golf_news = Golfnews::model()->findbyPk(intval($id));
            } else {
                $this->_golf_news = new Golfnews();
            }
        }
        return $this->_golf_news;
    }

    
    public function actionDelete() {
        if (isset($_GET['golf_new_id'])) {//delete celebrate
            $id=$_GET['golf_new_id'];
            if (!is_numeric($id)) {
                $this->redirect(array('admingolf_news/index'));
            }
            $model = new Golfnews();
            $model = $model->findByPk($id);
            if ($model == null) {
                $this->redirect(array('admingolf_news/index'));
            }
            $attachment1 = $model->attachment1;
            $attachment2 = $model->attachment2;
            $attachment3 = $model->attachment3;
            $eye_catch = $model->eye_catch;
            $transaction = $model->dbConnection->beginTransaction();            
            $affected_golf_news = $model->deleteByPk($id);
            $affected_update_information = Yii::app()->db->createCommand()->delete(
                    "update_information", "table_name=:table_name and article_id=:article_id", array(
                "article_id" => $id,
                "table_name" => 'golf_news',
                    ))
            ;
            if ($affected_golf_news != $affected_update_information) {
                $transaction->rollback();
            } else {
                $transaction->commit();
                Yii::app()->db->createCommand("delete from golf_news_comment where golf_news_id=$id")->execute();
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
                if ($eye_catch != "" && file_exists(Yii::getPathOfAlias('webroot') . $eye_catch)) {
                    unlink(Yii::getPathOfAlias('webroot') . $eye_catch);
                    $thumnail_file_path=  FunctionCommon::getFilenameInThumnail($eye_catch);
                    if(file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)){
                        unlink(Yii::getPathOfAlias('webroot') . $thumnail_file_path);
                    }
                }
                
            }
            $this->redirect(array('/admingolf_news/index'));
        } else if (isset($_GET['category_id'])) {//delete category
            $model = new Category();
            Yii::app()->db->createCommand()->delete("golf_news", "category_id=" . $_GET['category_id']);
            $model->deleteByPk($_GET['category_id']);
            $this->redirect(array('/admingolf_news/categories'));
        }
    }
    public function actionCategoryregist() {
        Yii::app()->session['page'] = isset($_GET['page']) ? $_GET['page'] : '';
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
                $model->type = 4;
                $now = FunctionCommon::getDateTimeSys();
                $model->created_date = $now;
                $model->last_updated_date = $now;
                $model->last_updated_person = FunctionCommon::getEmplNum();
                $model->contributor_id = Yii::app()->request->cookies['id'];
                if ($model->save()) {
                    $this->redirect(array('admingolf_news/categories'));
                }
            }
        }
        $parmas['model'] = $model;
        $this->render('/admin/golf_news/categoryregist', $parmas);
    }
	/**
     * delete comment id golf_news_comment with id golf_news
     */
	public function actionDeleteidgolf_newscomment() {

        $id=Yii::app()->request->getParam('id'); 
		$id2=Yii::app()->request->getParam('id2'); 
		
        $model	= new Golf_news_comment;
        $transaction=$model->dbConnection->beginTransaction();

  	 	$delete_id_golf_news_respnse = Yii::app()->db->createCommand()->delete("golf_news_comment",'id=:id',array('id'=>$id2));	

        if($delete_id_golf_news_respnse){
			 $transaction->commit();   
        }
        else{
             $transaction->rollback();
        } 

        $this->redirect(array('admingolf_news/detail/?id='.$id));
    } 
}