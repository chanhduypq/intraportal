<?php

class AdmincelebrateController extends Controller {

	 public $pageTitle;
     public function init() {
        parent::init();
		$this->pageTitle="ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id']=="null" ) {
          $this->redirect(array('newgin/'));
        }
          
    }

    public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('celebrate_edit_from') ? Yii::app()->request->cookies['celebrate_edit_from']->value : '';
        $backCookie1 = Yii::app()->request->cookies->contains('celebrate_regist_from') ? Yii::app()->request->cookies['celebrate_regist_from']->value : '';

        if ($backCookie != "" && $backCookie != NULL && $backCookie != "null") {
            return array(
                array('application.extensions.PerformanceFilter - edit'),
            );
        }
        else if($backCookie1 != "" && $backCookie1 != NULL && $backCookie1 != "null"){
            return array(
                array('application.extensions.PerformanceFilter - regist'),
            );
        }
        else {
            return array(
                'accessControl',
            );
        }
        
    }

    /**
     *     
     */
    private $_celebrate = null;

    /**
     * 
     */
    public function actionIndex() {
        $page = (isset($_GET['page']) ? $_GET['page'] : 1);
        $cookie = new CHttpCookie('page', $page);
        $page_size = Config::LIMIT_ROW;
        $item_count = Yii::app()->db->createCommand()
                ->select('count(*) as count')
                 ->from('celebrate')
                ->join('category', 'category.id=celebrate.category_id')
                ->leftJoin('base', 'base.id=celebrate.base_id')
                ->queryScalar();
        $celebrates = Yii::app()->db->createCommand()
                ->select(array(
                    'celebrate.id',
                    'category_name',
                    'employee_name',
                    'record_date',
                    'branch_name',
                        )
                )
                ->from('celebrate')
                ->join('category', 'category.id=celebrate.category_id')
                ->leftJoin('base', 'base.id=celebrate.base_id')
				->where(FunctionCommon::isAdmin()==FALSE?'celebrate.contributor_id='.Yii::app()->request->cookies["id"]:'true')
                ->limit($page_size, ($page - 1) * $page_size)
                ->order('celebrate.created_date desc')
                ->queryAll();
        $pages = new CPagination($item_count);
        $pages->setPageSize($page_size);

        $params = array('celebrates' => $celebrates,
            'item_count' => $item_count,
            'page_size' => $page_size,
            'pages' => $pages);
        $this->render('/admin/celebrate/index', $params);
    }

    /**
     * 
     */
    public function actionEdit() {
        Yii::app()->session['page'] = isset($_GET['page']) ? $_GET['page'] : '';
        /**
         * 
         */
        $parmas = array();
        /**
         * 
         */
        $model = $this->loadModel();
        if ($model == null || !isset($_GET['id'])) {
            $this->redirect(array('admin/index'));
        }
        $temp = explode(" ", $model->record_date);
        $temp = $temp[0];
        $temp = explode("-", $temp);
        $model->record_year = intval($temp[0]);
        $model->record_month = intval($temp[1]);
        $model->record_day = intval($temp[2]);
        /**
         * 
         */
        if (Yii::app()->request->isAjaxRequest) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        
        $parmas['model'] = $model;
        $this->render('/admin/celebrate/edit', $parmas);
    }

    /**
     * 
     */
    public function actionEditconfirm() {
        /**
         * 
         */
        $parmas = array();
        /**
         * 
         */
        $model = $this->loadModel();
        if ($model == null) {
            $this->redirect(array('admincelebrate/index'));
        }
        /**
         * 
         */
        if (Yii::app()->request->isPostRequest) {
            if (!isset($_POST['edit']) || $_POST['edit'] != '1') {                
                $parmas['record_date'] = $_POST['record_date'];
                $parmas['category_name'] = $_POST['category_name'];
                $parmas['base_name'] = $_POST['base_name'];
            }
            
            if ($model->id == null || $model->id == '') {
                $this->redirect(array('admincelebrate/index'));
            }
            /**
             * 
             */
            CActiveForm::validate($model);
            /**
             *
             */
            if ($model->validate()) {
                /**
                 *
                 */
                if (isset($_POST['edit']) && $_POST['edit'] == '1') {
                    if ($model->save() == true) {
								if(Yii::app()->request->cookies['page']!= "") 
								{
									   $page = "index?page=".Yii::app()->request->cookies['page'];
										
								}else {$page ="";}
								$this->redirect(array('admincelebrate/'.$page.''));	
                    }
                }
            }
            else{
                $this->redirect(array('admincelebrate/edit/?id=' . $model->id));
            }
        }
        $parmas['model'] = $model;
        $this->render('/admin/celebrate/editconfirm', $parmas);
    }

    public function actionCategoryedit() {
        Yii::app()->session['page'] = isset($_GET['page']) ? $_GET['page'] : '';
        $params = array();
        /**
         * 
         */
        $model = Category::model()->findByPk($_GET['id']);
        if ($model == null || !isset($_GET['id'])) {
            $this->redirect(array('admin/index'));
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
        if (Yii::app()->request->isPostRequest) {
            /**
             *
             */
            CActiveForm::validate($model);
            /**
             * 
             */
            if ($model->validate()) {
                $now = FunctionCommon::getDateTimeSys();
                $model->last_updated_date = $now;
                $model->last_updated_person = FunctionCommon::getEmplNum();
                if ($model->save()) {
                    $this->redirect(array('admincelebrate/categories'));
                }
            }
        }
        $parmas['model'] = $model;
        $this->render('/admin/celebrate/categoryedit', $parmas);
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
                $model->type = 1;
                $now = FunctionCommon::getDateTimeSys();
                $model->created_date = $now;
                $model->last_updated_date = $now;
                $model->last_updated_person = FunctionCommon::getEmplNum();
                $model->contributor_id = Yii::app()->request->cookies['id'];
                if ($model->save()) {
                    $this->redirect(array('admincelebrate/categories'));
                }
            }
        }
        $parmas['model'] = $model;
        $this->render('/admin/celebrate/categoryregist', $parmas);
    }

    public function actionCategories() {
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
                ->where('type=:type', array('type' => 1))
                ->from('View_CategoryAndCelebrate')
                ->queryScalar();
        /**
         * 
         */
        $categories = Yii::app()->db->createCommand()
                ->select(array(
                    '*',
                        )
                )
                ->from('View_CategoryAndCelebrate')
                ->where('type=:type', array('type' => 1))
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
        $this->render('/admin/celebrate/categories', $params);
    }

    /**
     * 
     */
    public function actionRegist() 
	{
        Yii::app()->session['page'] = isset($_GET['page']) ? $_GET['page'] : '';
        $parmas = array();
        $model = new Celebrate();
		$model->record_year= date("Y");
		$model->record_month=date('n');
		$model->record_day=date('j');
        if (Yii::app()->request->isAjaxRequest)
		{
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }        
        $parmas['model'] = $model;
        $this->render('/admin/celebrate/regist', $parmas);
    }

    /**
     * 
     */
    public function actionRegistconfirm() {
        if (!isset($_POST['record_date'])) {
            $this->redirect(array('admincelebrate/index'));
        }
        /**
         * 
         */
        $parmas = array();
        /**
         * 
         */
        $model = new Celebrate();
        /**
         * 
         */
        if (Yii::app()->request->isPostRequest) {
            $parmas['record_date'] = $_POST['record_date'];
            $parmas['category_name'] = $_POST['category_name'];
            $parmas['base_name'] = $_POST['base_name'];
            /**
             * 
             */
            CActiveForm::validate($model);
            /**
             *
             */
            if ($model->validate()) {
                /**
                 *
                 */
                if (isset($_POST['regist']) && $_POST['regist'] == '1') {
                    if ($model->save() == true) {
                        $this->redirect(array('admincelebrate/index'));
                    }
                }
            }
            else{
                $this->redirect(array('admincelebrate/regist'));
            }
        }
        $parmas['model'] = $model;

        $this->render('/admin/celebrate/registconfirm', $parmas);
    }

    /**
     *      
     */
    public function loadModel() {
        if ($this->_celebrate === null) {
            if (isset($_GET['id'])) {
                $this->_celebrate = Celebrate::model()->findbyPk(intval($_GET['id']));
            } else if (isset($_POST['Celebrate'])) {
                $data = $_POST['Celebrate'];
                $id = $data['id'];
                $this->_celebrate = Celebrate::model()->findbyPk(intval($id));
            } else {
                $this->_celebrate = new User();
            }
        }
        return $this->_celebrate;
    }

    /**
     * 
     */
    public function actionDelete() {
        if (isset($_GET['celebrate_id'])) {//delete celebrate
            $model = new Celebrate();
            $model->deleteByPk($_GET['celebrate_id']);
            $this->redirect(array('/admincelebrate/index'));
        } else if (isset($_GET['category_id'])) {//delete category
            $model = new Category();
            Yii::app()->db->createCommand()->delete("celebrate", "category_id=" . $_GET['category_id']);
            $model->deleteByPk($_GET['category_id']);
            $this->redirect(array('/admincelebrate/categories'));
        }
    }

}