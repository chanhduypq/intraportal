<?php

class Admincelebrate_rptController extends Controller {

    public $pageTitle;

    //check if logined or not
    public function init() {
        parent::init();
        $this->pageTitle = "ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null") {
            $this->redirect(array('newgin/'));
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
                $path = Upload_config::getUploadPath('category');
                Upload_config::createFolder($path, Yii::getPathOfAlias('webroot'), 1);
                $attachment1_path = $path . 'attachment1/';
                $employee_number = FunctionCommon::getEmplNum();
                $now_for_file = date("YmdHis");

                if ($model->category_avatar_checkbox_for_deleting != '1') {
                    if ($file = CUploadedFile::getInstance($model, 'category_avatar')) {                        
                        $file_name = Upload_file_common_new::fixFileName($file->name);
                        $temp = explode(".", $file_name);
                        $extension = $temp[count($temp) - 1];
                        
                        if (in_array($extension, Constants::$imgExtention)) {
                            $model->category_avatar = $attachment1_path . $employee_number . '_' . $now_for_file . '.' . $extension;

                            $file->saveAs(Yii::getPathOfAlias('webroot') . $model->category_avatar);
                            
                        } 



                        $url1 = ltrim($model->category_avatar, '/');
                        $size = getimagesize($url1);
                        $w = $size[0];
                        $h = $size[1];
                        if (in_array($extension, Constants::$imgExtention)) {
                            if (($w >= 70 && $h >= 52) || ($w > 70 && $h < 52) || ($w < 70 && $h > 52)) {
                                $image = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . $model->category_avatar);
                                $image->resize(70,52);
                                $image->save();
                            }
                        }

                        
                    }
                }
                $model->type = 8;
                
                $model->last_updated_person = FunctionCommon::getEmplNum();
                $model->contributor_id = Yii::app()->request->cookies['id'];
                if ($model->save()) {
                    $this->redirect(array('admincelebrate_rpt/categories'));
                }
            }
            
        }
        $parmas['model'] = $model;
        $this->render('/admin/celebrate_rpt/categoryregist', $parmas);
    }

    public function actionCategoryedit() {
        Yii::app()->session['page'] = isset($_GET['page']) ? $_GET['page'] : '';
        $params = array();
        /**
         * 
         */
        $model = Category::model()->findbyPk(intval($_GET['id']));
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
                $path = Upload_config::getUploadPath('category');
                Upload_config::createFolder($path, Yii::getPathOfAlias('webroot'), 1);
                $attachment1_path = $path . 'attachment1/';
                $employee_number = FunctionCommon::getEmplNum();
                $now_for_file = date("YmdHis");

                if ($model->category_avatar_checkbox_for_deleting != '1') {
                    if ($file = CUploadedFile::getInstance($model, 'category_avatar')) {                        
                        $file_name = Upload_file_common_new::fixFileName($file->name);
                        $temp = explode(".", $file_name);
                        $extension = $temp[count($temp) - 1];
                        
                        if (in_array($extension, Constants::$imgExtention)) {
                            if($model->category_avatar!=''&&file_exists(Yii::getPathOfAlias('webroot') . $model->category_avatar)){
                                unlink(Yii::getPathOfAlias('webroot') . $model->category_avatar);
                            }
                            $model->category_avatar = $attachment1_path . $employee_number . '_' . $now_for_file . '.' . $extension;

                            $file->saveAs(Yii::getPathOfAlias('webroot') . $model->category_avatar);
                            
                        } 



                        $url1 = ltrim($model->category_avatar, '/');
                        $size = getimagesize($url1);
                        $w = $size[0];
                        $h = $size[1];
                        if (in_array($extension, Constants::$imgExtention)) {
                            if (($w >= 70 && $h >= 52) || ($w > 70 && $h < 52) || ($w < 70 && $h > 52)) {
                                $image = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . $model->category_avatar);
                                $image->resize(70,52);
                                $image->save();
                            }
                        }

                        
                    }
                }
                else{
                    if($model->category_avatar!=''&&file_exists(Yii::getPathOfAlias('webroot') . $model->category_avatar)){
                        unlink(Yii::getPathOfAlias('webroot') . $model->category_avatar);
                    }
                    $model->category_avatar='';
                    
                }
                $model->type = 8;            
                
                $model->last_updated_person = FunctionCommon::getEmplNum();
                $model->contributor_id = Yii::app()->request->cookies['id'];
                if ($model->save()) {
                    $this->redirect(array('admincelebrate_rpt/categories'));
                }
            }
            
        }
        $parmas['model'] = $model;
        $this->render('/admin/celebrate_rpt/categoryedit', $parmas);
    }
    
    public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('celebrate_rpt_edit_form') ? Yii::app()->request->cookies['celebrate_rpt_edit_form']->value : '';
        $backCookie1 = Yii::app()->request->cookies->contains('celebrate_rpt_regist_form') ? Yii::app()->request->cookies['celebrate_rpt_regist_form']->value : '';

        if ($backCookie != "" && $backCookie != NULL && $backCookie != "null") {
            return array(
                array('application.extensions.PerformanceFilter - edit'),
            );
        } else if ($backCookie1 != "" && $backCookie1 != NULL && $backCookie1 != "null") {
            return array(
                array('application.extensions.PerformanceFilter - regist'),
            );
        } else {
            return array(
                'accessControl',
            );
        }
    }

    /*
     * Create Date:20130823
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:Method using load model hobby_new
     * */

    private $_celebrate = null;

    public function loadModel() {
        if ($this->_celebrate === null) {
            if (isset($_GET['id'])) {
                $this->_celebrate = Celebrate::model()->findbyPk(intval($_GET['id']));
            } else if (isset($_POST['Celebrate'])) {
                $data = $_POST['Celebrate'];
                $id = $data['id'];
                $this->_celebrate = Celebrate::model()->findbyPk(intval($id));
            } else {
                $this->_celebrate = new Celebrate();
            }
        }
        return $this->_celebrate;
    }

    /*
     * Create Date:20130912
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:Method using check id celebrate 
     * */

    public function actionCheckId() {
        $id = $_POST['id'];
        $row = 0;
        $object = Yii::app()->db->createCommand("select * from celebrate where id=" . $id)->queryRow();
        if (!empty($object['id'])) {
            $row = 1;
        }
        echo $row;
    }

    /** Create Date:20130913
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:action index object from model Celebrate  
     * */
    public function actionIndex() {
        //set cookie page
        $page = isset($_GET['page']) ? $_GET['page'] : '';
        $cookie = new CHttpCookie('page', $page);
        Yii::app()->request->cookies['page'] = $cookie;

        $criteria = new CDbCriteria();
        $criteria->select = '*';
        $criteria->condition = "type=2";
        $criteria->order = 'created_date DESC';

        $item_count = Celebrate::model()->count($criteria);
        $pages = new CPagination($item_count);
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);

        $model = Celebrate::model()->findAll($criteria);
        $params = array('model' => $model,
            'item_count' => $item_count,
            'page_size' => Config::LIMIT_ROW,
            'pages' => $pages);
        $this->render('/admin/celebrate_rpt/index', $params);
    }

    // public function actionIndex()
    // {
    // $page = (isset($_GET['page']) ? $_GET['page'] : 1);
    // $cookie = new CHttpCookie('page', $page);
    // $page_size = Config::LIMIT_ROW;
    // $item_count = Yii::app()->db->createCommand()
    // ->select('count(*) as count')
    // ->from('celebrate')
    // ->join('category', 'category.id=celebrate.category_id')
    // ->leftJoin('base', 'base.id=celebrate.base_id')
    // ->queryScalar();
    // $celebrates = Yii::app()->db->createCommand()
    // ->select(array(
    // 'celebrate.id',
    // 'category_name',
    // 'employee_name',
    // 'record_date',
    // 'branch_name',
    // )
    // )
    // ->from('celebrate')
    // ->join('category', 'category.id=celebrate.category_id')
    // ->leftJoin('base', 'base.id=celebrate.base_id')
    // ->where(FunctionCommon::isAdmin()==FALSE?'celebrate.contributor_id='.Yii::app()->request->cookies["id"]:'true')
    // ->limit($page_size, ($page - 1) * $page_size)
    // ->order('celebrate.created_date desc')
    // ->queryAll();
    // $pages = new CPagination($item_count);
    // $pages->setPageSize($page_size);
    // $params = array('celebrates' => $celebrates,
    // 'item_count' => $item_count,
    // 'page_size' => $page_size,
    // 'pages' => $pages);
    // $this->render('/admin/celebrate/index', $params);
    // }

    /** Create Date:20130912
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:action using register object Celebrate  
     * */
    public function actionRegist() {
        $parmas = array();
        $model = new Celebrate();
        if (Yii::app()->request->isAjaxRequest) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        $unit = Yii::app()->db->createCommand()
                ->select(array(
                    'unit.id',
                    'unit.unit_name',
                    'unit.branch_id',
                    'branch.branch_name',
                    'base.company_name'

                        //'user.base_list'
                        )
                )
                ->from('unit')
                ->join('branch', 'branch.id=unit.branch_id')
                ->join('base', 'base.id=branch.base_id')
                ->where('unit.active_flag=1 and unit.modifiable_flag=1 and branch.modifiable_flag=1 and base.modifiable_flag=1')
                ->order("base.display_order asc ,branch.display_order asc, unit.display_order asc")
                ->queryAll();

        $parmas['model'] = $model;
        $parmas['unit'] = $unit;
        $this->render('/admin/celebrate_rpt/regist', $parmas);
    }

    public function actionRegistConfirm() {
        $model = new Celebrate();
        if (Yii::app()->request->isPostRequest) {
            CActiveForm::validate($model);
            if ($model->validate()) {
                if (isset($_POST['regist']) && $_POST['regist'] == '1') {
                    if ($model->save()) {
                        $this->redirect(array('admincelebrate_rpt/index'));
                    }
                }
            }
        } else {
            $this->redirect(array('admincelebrate_rpt/index'));
        }
        $this->render('/admin/celebrate_rpt/registconfirm', array('model' => $model));
    }

    /** Create Date:20130912
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:action using update info object report  
     * */
    public function actionEdit() {
        $id = Yii::app()->request->getParam('id');
        $model = Celebrate::model()->findByPk($id);
        if (count($model) > 0) {
            if (Yii::app()->request->isAjaxRequest) {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
            $unit = Yii::app()->db->createCommand()
                    ->select(array(
                        'unit.id',
                        'unit.unit_name',
                        'unit.branch_id',
                        'branch.branch_name',
                        'base.company_name'

                            //'user.base_list'
                            )
                    )
                    ->from('unit')
                    ->join('branch', 'branch.id=unit.branch_id')
                    ->join('base', 'base.id=branch.base_id')
                    ->where('unit.active_flag=1 and unit.modifiable_flag=1 and branch.modifiable_flag=1 and base.modifiable_flag=1')
             	    ->order("base.display_order asc , unit.display_order asc")
                    ->queryAll();

            $parmas['model'] = $model;
            $parmas['unit'] = $unit;
            $this->render('/admin/celebrate_rpt/edit', $parmas);
        } else {
            $this->redirect(array('admincelebrate_rpt/index'));
        }
    }

    /** Create Date:20130912
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:action display info edit model hobby_new  
     * */
    public function actionEditConfirm() {
        $model = $this->loadModel();
        if (count($model) > 0 && Yii::app()->request->isPostRequest) {
            CActiveForm::validate($model);
            if ($model->validate()) {
                if (isset($_POST['edit']) && $_POST['edit'] == '1') {
                    if ($model->save()) {
                        if (Yii::app()->request->cookies['page'] != "") {
                            $page = "index?page=" . Yii::app()->request->cookies['page'];
                        } else {
                            $page = "";
                        }
                        $this->redirect(array('admincelebrate_rpt/' . $page));
                    }
                }
            }
            $this->render('/admin/celebrate_rpt/editconfirm', array('model' => $model));
        } else {
            $this->redirect(array('admincelebrate_rpt/index'));
        }
    }

    /** Create Date:20130910
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:action using delete object hobby_new 
     * */
    public function actionDelete() {
        $id = Yii::app()->request->getParam('id');
        $model = Celebrate::model();
        $model = $model->findByPk($id);

        if (!is_null($model)) {
            $affected_row = $model->deleteByPk($id);
            if ($affected_row == 1) {
                $this->redirect(array('admincelebrate_rpt/index'));
            }
        }        
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
                //->where('type=:type', array('type' => 1))
                ->from('category')
                ->queryScalar();
        /**
         * 
         */
        $categories = Yii::app()->db->createCommand()
                ->select(array(
                    '*',
                        )
                )
                ->from('category')
                //->where('type=:type', array('type' => 8))
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
        $this->render('/admin/celebrate_rpt/categories', $params);
    }
    public function actionDeletecategory() {
        $id = Yii::app()->request->getParam('id');
        $model = Category::model()->findByPk($id);
        

        if (!is_null($model)) {
            $affected_row = $model->deleteByPk($id);
            if ($affected_row == 1) {
                if($model->category_avatar!=''&&file_exists(Yii::getPathOfAlias('webroot') . $model->category_avatar)){
                    unlink(Yii::getPathOfAlias('webroot') . $model->category_avatar);
                }  
                Yii::app()->db->createCommand("delete from celebrate where category_id=$id")->execute();
            }
        }        
        $this->redirect(array('admincelebrate_rpt/categories'));
    }

    public function actionDeleteAll() {
        $affected_row = Celebrate::model()->deleteAll("type = 2");
        if ($affected_row > 0) {
            $this->redirect(array('admincelebrate_rpt/index'));
        }
    }

}

?>