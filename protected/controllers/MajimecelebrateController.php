<?php

class MajimecelebrateController extends Controller {

	public $pageTitle;
    /**
     * 
     */
     public function init() {
        parent::init();
		$this->pageTitle="お祝い | ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id']=="null" ) {
          $this->redirect(array('newgin/'));
        }
        /**
         * 
         */
        //set_time_limit(3000);;
        
    }

    /**
     * 
     */
    public function actionIndex() {
        /**
         * 
         */
        $page = (isset($_GET['page']) ? $_GET['page'] : 1);
        /**
         * 
         */
        $page_size = Config::LIMIT_ROW;
        /**
         * 
         */
        $item_count = Yii::app()->db->createCommand()
                ->select('count(*) as count')
                ->from('celebrate')
                ->join('category', 'category.id=celebrate.category_id')
                ->leftJoin('base', 'base.id=celebrate.base_id')
                ->queryScalar();
        /**
         * 
         */
        $celebrates = Yii::app()->db->createCommand()
                ->select(array(
                    'category_name',
                    'employee_name',
                    'record_date',
                    'branch_name',
                        )
                )
                ->from('celebrate')
                ->join('category', 'category.id=celebrate.category_id')
                ->leftJoin('base', 'base.id=celebrate.base_id')
                ->limit($page_size, ($page - 1) * $page_size)
                ->order('celebrate.record_date desc')
                ->queryAll();
        /**
         * 
         */
        $pages = new CPagination($item_count);
        $pages->setPageSize($page_size);
        /**
         * 
         */
        $params = array('celebrates' => $celebrates,
            'item_count' => $item_count,
            'page_size' => $page_size,
            'pages' => $pages);
        /**
         * 
         */
        $this->render('/majime/celebrate/index', $params);
    }

}