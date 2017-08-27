<?php

class Asobigolf_newsController extends Controller
{
	public $pageTitle;
    /**
     *
     */
     public function init() 
	 {
        parent::init();
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id']=="null" ) {
          $this->redirect(array('newgin/'));
        }
        
    }

    public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('golf_news_regist_from') ? Yii::app()->request->cookies['golf_news_regist_from']->value : '';

        if ($backCookie != "" && $backCookie != NULL && $backCookie != "null") {
            return array(
                array('application.extensions.PerformanceFilter - regist'),
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
    public function actionIndex() {
        
		$this->pageTitle="あそびにマジメ！？あそび自慢＆対決！ | ニューギンスクエア";
        /**
         * 
         */
        if (FunctionCommon::isPostFunction("golf_news") == true && FunctionCommon::isViewFunction("golf_news") == false) {
            $this->redirect(array('asobi/'));
        } else {
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
                    ->from('golf_news')
                    ->where((FunctionCommon::isPostFunction("golf_news")&&!FunctionCommon::isViewFunction("golf_news"))?"contributor_id=".Yii::app()->request->cookies['id']:"true")
                    ->queryScalar();
            /**
             * 
             */
            $golf_news = Yii::app()->db->createCommand()
                    ->select(array(
                        'golf_news.id',
                        'golf_news.title',
                        'golf_news.content',
                        'golf_news.created_date',
                        'category.category_name',
                        'background_color',
                        'text_color',
                        'eye_catch'
                            )
                    )
                    ->from('golf_news')
                    ->leftJoin("category", "category.id=golf_news.category_id")
                    ->where((FunctionCommon::isPostFunction("golf_news")&&!FunctionCommon::isViewFunction("golf_news"))?"contributor_id=".Yii::app()->request->cookies['id']:"true")
                    ->limit($page_size, ($page - 1) * $page_size)
                    ->order('golf_news.created_date desc')
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
            $this->render('/asobi/golf_news/index', $params);
        }
    }

    /**
     * 
     */
    public function actionRegist() {
		
		$this->pageTitle="製品アイデア投稿広場 | ニューギンスクエア";
        /**
         * 
         */
        $parmas = array();
        /**
         * 
         */
        $model = new Golfnews();
        /**
         * 
         */
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
        $attachment4_error = isset(Yii::app()->session['attachment4']) ? Yii::app()->params['attachment4_error'] : '';
        unset(Yii::app()->session['attachment1']);
        unset(Yii::app()->session['attachment2']);
        unset(Yii::app()->session['attachment3']);
        unset(Yii::app()->session['attachment4']);
        
        $parmas['attachment1_error'] = $attachment1_error;
        $parmas['attachment2_error'] = $attachment2_error;
        $parmas['attachment3_error'] = $attachment3_error;
        $parmas['attachment4_error'] = $attachment4_error;
        $parmas['model'] = $model;
        $this->render('/asobi/golf_news/regist', $parmas);
    }
    
    
    /**
     * 
     */
    public function actionRegistconfirm() {
	
		$this->pageTitle="製品アイデア投稿広場 | ニューギンスクエア";
        /**
         * 
         */
        $model = new Golfnews();
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
            /**
             * 
             */
            CActiveForm::validate($model);
            if (!isset($_POST['regist']) || $_POST['regist'] != '1') {                
                Upload_file_common_new::processAttachments($model,'golf_news',1);
            }  
            /**
             *
             */
            if ($model->validate()) {
                /**
                 *
                 */
                if (isset($_POST['regist']) && $_POST['regist'] == '1') {
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
                        if(FunctionCommon::isViewFunction("golf_news")==true){
                            $this->redirect(array('asobigolf_news/index'));
                        }
                        else{
                            $this->redirect(array('asobi/'));
                        }
                        
                    }
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
                $this->redirect(array('asobigolf_news/regist'));
            }
        } else {
            $this->redirect(array('asobigolf_news/index'));
        }
        $this->render('/asobi/golf_news/registconfirm', array('model' => $model));
    }

     /** change Date:18/11/2013
     * Update Date:
     * Author:Baodt
     * User change:
     * Detail id golf_news & view valuation table golf_news comment width id golf_news
     * */ 
    public function actionDetail() {

		$this->pageTitle="製品アイデア投稿広場 | ニューギンスクエア";
        if (!isset($_GET['id'])||!is_numeric($_GET['id'])) {
            $this->redirect(array('asobigolf_news/index'));
        }
		$id_gol = Yii::app()->db->createCommand("select * from golf_news where id=".$_GET['id'])->queryRow();
		if($id_gol==""){
			$this->redirect(array('asobigolf_news/index'));
		}
        $model 						= Golfnews::model()->findbyPk(intval($_GET['id']));
		$golf_news_list_comments	= Yii::app()->db->createCommand("select * from golf_news_comment where golf_news_id=".$_GET['id']." order by created_date ASC")->queryAll();	
		
		$golf_news_comment			= new Golf_news_comment;
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
		if(!empty($model->title))
		{ 
			if (Yii::app()->request->isAjaxRequest) {
				echo CActiveForm::validate($golf_news_comment);
				Yii::app()->end();
			} 
			if (Yii::app()->request->isPostRequest) { 
				CActiveForm::validate($golf_news_comment);
				if ($golf_news_comment->validate()) { 
							 
					if($model->saveGolf_news_comment($golf_news_comment))
						{
							$this->refresh();
						}  
				}
			}
			$this->render('/asobi/golf_news/detail', array(
												'model' => $model,
												'golf_news_comment'=>$golf_news_comment,
												'golf_news_list_comments'=>$golf_news_list_comments,
												'user'=>$user,
												'category_name'=>$category['category_name'],
												'background_color'=>$category['background_color'],
												'text_color'=>$category['text_color'],
												)
			);
			
		}
		else{
					$this->redirect(array('/asobigolf_news/index'));
			}
        
    }
	
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
            $file_path=  Upload_file_common::getAttachmentById($_GET['id'], $attachment_index, 'golf_news');
        }
        else{//download from registconfirm
            $file_path = $_GET['file_name'];
        }
        Yii::import('ext.helpers.EDownloadHelper');
        EDownloadHelper::download(Yii::getPathOfAlias('webroot') . $file_path);
        
        
        
        exit;
    }

    

}