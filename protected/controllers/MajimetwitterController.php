<?php
class MajimetwitterController extends Controller
{ 
	 public $pageTitle;
     public function init() 
	 {
        parent::init();
		$this->pageTitle="Twitterキャッチ！ | ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id']=="null" ) {
          $this->redirect(array('newgin/'));
        }
          
    }
    public function actionIndex() {
       
        /**
         * 
         */
        $page = (isset($_GET['page']) ? $_GET['page'] : 1);        
        $page_size = Config::LIMIT_ROW; 
        $blogc_twitter_contents = Yii::app()->db->createCommand()
                ->select(array(        
                    'screen_name',
                    'content',                    
                    'blogc_twitter_content.contributed_date',
                       
                        )
                )
                ->from('blogc_twitter_content')
                ->where("type=:type",array('type'=>2))    
                ->group("screen_name, content, contributed_date")                                    
                ->queryAll();
        $item_count = count($blogc_twitter_contents);
        /**
         * 
         */
        $blogc_twitter_contents = Yii::app()->db->createCommand()
                ->select(array(        
                    'screen_name',
                    'content',                    
                    'blogc_twitter_content.contributed_date',
                       
                        )
                )
                ->from('blogc_twitter_content')
                ->where("type=:type",array('type'=>2))    
                ->group("screen_name, content, contributed_date")
                ->limit($page_size, ($page - 1) * $page_size)                
                ->order("contributed_date desc")                         
                ->queryAll();
        /**
         * 
         */
        $pages = new CPagination($item_count);
        $pages->setPageSize($page_size);
        /**
         * 
         */
        $params = array('blogc_twitter_contents' => $blogc_twitter_contents,
            'item_count' => $item_count,
            'page_size' => $page_size,
            'pages' => $pages);
        /**
         * 
         */
        $this->render('/majime/twitter/index', $params);
    }
}
?>