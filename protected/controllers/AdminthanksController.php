<?php

class AdminthanksController extends Controller {

	public $pageTitle;
    private $_thanks = null;

    /**
     * 
     */
    public function init() {
        parent::init();
		$this->pageTitle="ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null") {
            $this->redirect(array('newgin/'));
        }
    }

    public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('thanks_regist_from') ? Yii::app()->request->cookies['thanks_regist_from']->value : '';
        $backCookie1 = Yii::app()->request->cookies->contains('thanks_edit_from') ? Yii::app()->request->cookies['thanks_edit_from']->value : '';

        if ($backCookie != "" && $backCookie != NULL && $backCookie != "null") {
            return array(
                array('application.extensions.PerformanceFilter - regist'),
            );
        } else if ($backCookie1 != "" && $backCookie1 != NULL && $backCookie1 != "null") {
            return array(
                array('application.extensions.PerformanceFilter - edit'),
            );
        } else {
            return array(
                'accessControl',
            );
        }
    }

    /*     * Create Date:23/07/2012
     * Update Date:
     * Author:
     * User change:
     * Description: display list soumu_news object
     * */

    public function actionIndex() {
        $page = (isset($_GET['page']) ? $_GET['page'] : 1);
        $cookie = new CHttpCookie('page', $page);
        Yii::app()->request->cookies['page'] = $cookie;
        $page_size = 10;
        /**
         * 
         */
        $item_count = Yii::app()->db->createCommand()
                ->select('count(*) as count')
                ->from('thanks')
                ->where(FunctionCommon::isAdmin() == FALSE ? "contributor_id=" . Yii::app()->request->cookies['id'] : "true")
                ->queryScalar();
        /**
         * 
         */
        $thanks = Yii::app()->db->createCommand()
                ->select(array(
                    'thanks.id',
                    'thanks.comment',
                    'lastname',
                    'firstname',
                    'user.photo',
					'user.division1',
					'user.division2',
					'user.division3',
					'user.division4'
					//'unit.unit_name'
                    //'user.base_list'
                        )
                )
                ->from('thanks')
                ->join('user', 'user.id=thanks.user_id')
				//->join('unit', 'unit.id=user.division1 or unit.id=user.division2 or unit.id=user.division3 or unit.id=user.division4')
                ->where(FunctionCommon::isAdmin() == FALSE ? "contributor_id=" . Yii::app()->request->cookies['id'] : "true")
                ->limit($page_size, ($page - 1) * $page_size)
                ->order('thanks.created_date desc')
                ->queryAll();
				
       /* for ($i = 0, $n = count($thanks); $i < $n; $i++) {
            $base_list = $thanks[$i]['base_list'];
            $base_list_array = explode(",", $base_list);
            if(is_array($base_list_array)&&  count($base_list_array)>0&& is_numeric($base_list_array[0])){
                $branch_name = $this->getBaseById($base_list_array[0]);
            }
            else{
                $branch_name='';
            }            
            $thanks[$i]['branch_name'] = $branch_name;
        }*/
        /**
         * 
         */
        $pages = new CPagination($item_count);
        $pages->setPageSize($page_size);
        /**
         * 
         */
        $params = array('thanks' => $thanks,
            'item_count' => $item_count,
            'page_size' => $page_size,
            'pages' => $pages);
        /**
         * 
         */
        $this->render('/admin/thanks/index', $params);
    }

    private function getBaseById($id) {
        if(!is_numeric($id)){
            return '';
        }
        $branch_name = Yii::app()->db->createCommand()
                ->select('branch_name')
                ->from('base')
                ->where("id=$id")
                ->queryScalar();
        if ($branch_name == FALSE) {
            return '';
        }
        return $branch_name;
    }

   public function actionDownload() {        
        $file_path = $_GET['file_name'];
        Yii::import('ext.helpers.EDownloadHelper');
        EDownloadHelper::download(Yii::getPathOfAlias('webroot') . $file_path);       
        exit;
    }

    public function actionRegist() {
        $parmas = array();
        $model = new Thanks();
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
                ->where("unit.active_flag=1 and unit.modifiable_flag=1 and branch.modifiable_flag=1 and base.modifiable_flag=1")
                ->order("base.display_order asc , unit.display_order asc")
                ->queryAll();
		
        $parmas['model'] = $model;
		$parmas['unit'] = $unit;
        $this->render('/admin/thanks/regist', $parmas);
    }

    public function actionGetusers() {
        if (Yii::app()->request->isAjaxRequest) {
            $unit_id = Yii::app()->request->getParam('unit_id');
			$users    = Yii::app()->db->createCommand()
								     ->select('id,lastname,firstname')
								   ->from('user')
								   ->where("division1 ='".$unit_id."'")
								   ->orWhere("division2  ='".$unit_id."'")
								   ->orWhere("division3  ='".$unit_id."'")
								   ->orWhere("division4  ='".$unit_id."'")
								   ->queryAll();
								   
            //$users = Yii::app()->db->createCommand("select id,lastname,firstname from user where base_list like '%$base_id%'")->queryAll();
            echo CJSON::encode($users);
            Yii::app()->end();
        }
    }
    public function actionGetuser() {
        if (Yii::app()->request->isAjaxRequest) {
            $user_id = Yii::app()->request->getParam('user_id');
            $users = Yii::app()->db->createCommand("select photo,firstname,lastname from user where id=$user_id")->queryAll();            
            echo CJSON::encode($users);
            Yii::app()->end();
        }
    }

   

    public function actionRegistconfirm() {
		
        $model = new Thanks();
        if (Yii::app()->request->isPostRequest) {
            CActiveForm::validate($model);

            if ($model->validate()) {
                if (isset($_POST['regist']) && $_POST['regist'] == '1') {
                    $user_id=Yii::app()->db->createCommand()
                            ->select(array('count(*) as count'))
                            ->from("user")
                            ->where("id=".$model->user_id)
                            ->queryScalar()
                            ;
                    if($user_id=='0'){
                        $this->redirect(array('adminthanks/regist'));
                    }
                    if ($model->save() == true) {
                        $this->redirect(array('adminthanks/index'));
                    }
                }
            } else {
                $this->redirect(array('adminthanks/regist'));
            }
        } else {
            $this->redirect(array('adminthanks/index'));
        }
		$unit = Yii::app()->db->createCommand("select unit_name from unit where id='".$_POST['id_unit']."'")->queryRow();
		
        $params=array();
        $params['model']=$model;
        $params['lastname']=$_POST['lastname'];
        $params['firstname']=$_POST['firstname'];
        $params['photo']=$_POST['photo'];
        $params['unit_name']=$unit['unit_name'];
        $this->render('/admin/thanks/registconfirm', $params);
    }

    public function actionEdit() {
        $parmas = array();
        $model = $this->loadModel();
        if ($model == null || !isset($_GET['id'])) {
            $this->redirect(array('adminthanks/index'));
        }

        $user_id=Yii::app()->db->createCommand()
                ->select(array('count(*) as count'))
                ->from("user")
                ->where("id=".$model->user_id)
                ->queryScalar()
                ;
        if($user_id=='0'){
            $this->redirect(array('adminthanks/index'));
        }

        if (Yii::app()->request->isAjaxRequest) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        
        $user = Yii::app()->db->createCommand("select photo,firstname,lastname,division1,division2,division4,division3 from user where id=".$model->user_id)->queryRow();            
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
				->where("unit.active_flag=1  and unit.modifiable_flag=1 and branch.modifiable_flag=1 and base.modifiable_flag=1")
                ->order('unit.created_date desc')
                ->queryAll();
				  
        $parmas['lastname']=$user['lastname'];
        $parmas['firstname']=$user['firstname'];
        $parmas['photo']=$user['photo'];
		
        $unit_id=Yii::app()->db->createCommand()
								   ->select('*')
								   ->from('unit')
								   ->where("id ='".$user['division1']."'")
								   ->orwhere("id ='".$user['division2']."'")
								   ->orwhere("id ='".$user['division3']."'")
								   ->orwhere("id ='".$user['division4']."'")
								   ->queryRow();
								   
		
               
        $parmas['unit_id']=$unit_id['id'];
        
        //$model->base_id=$base_list_array[0];
        $parmas['model'] = $model;
		$parmas['unit'] = $unit;
        $this->render('/admin/thanks/edit', $parmas);
    }

    public function actionEditconfirm() {
        $model = $this->loadModel();        
        if (Yii::app()->request->isPostRequest) {
            CActiveForm::validate($model);
            
            if ($model->validate()) {
                if (isset($_POST['edit']) && $_POST['edit'] == '1') {
                    $user_id=Yii::app()->db->createCommand()
                            ->select(array('count(*) as count'))
                            ->from("user")
                            ->where("id=".$model->user_id)
                            ->queryScalar()
                            ;
                    if($user_id=='0'){
                        $this->redirect(array('adminthanks/edit/?id=' . $model->id));
                    }
                    if ($model->save() == true) {
                        if (Yii::app()->request->cookies['page'] != "") {
                            $page = "index?page=" . Yii::app()->request->cookies['page'];
                        } else {
                            $page = "";
                        }
                        $this->redirect(array('adminthanks/' . $page . ''));
                    }
                }
            } 
            else {                
                $this->redirect(array('adminthanks/edit/?id=' . $model->id));
            }
        }
        else{
            $this->redirect(array('adminthanks/index'));
        }
		$unit = Yii::app()->db->createCommand("select unit_name from unit where id='".$_POST['id_unit']."'")->queryRow();
        $params=array();
        $params['model']=$model;
        $params['lastname']=$_POST['lastname'];
        $params['firstname']=$_POST['firstname'];
        $params['photo']=$_POST['photo'];
        $params['unit_name']=$unit['unit_name'];
        $this->render('/admin/thanks/editconfirm', $params);
    }

   

    /*     * Create Date:23/07/2012
     * Update Date:
     * Author:
     * User change:
     * Description:Method using load model Soumu_news
     * */

    public function loadModel() {
        if ($this->_thanks === null) {
            if (isset($_GET['id'])) {
                $this->_thanks = Thanks::model()->findbyPk(intval($_GET['id']));
            } else if (isset($_POST['Thanks'])) {
                $data = $_POST['Thanks'];
                $id = $data['id'];
                $this->_thanks = Thanks::model()->findbyPk(intval($id));
            } else {
                $this->_thanks = new Thanks();
            }
        }
        return $this->_thanks;
    }

   
    public function actionDelete() {
        $id = Yii::app()->request->getParam('id');
        $model = new Thanks();
        $model->deleteByPk($id);
        $this->redirect(array('/adminthanks/index'));
    }
    public function actionDeleteall() {
        $id = Yii::app()->request->getParam('id');
        $model = new Thanks();
        $model->deleteAll();
        $this->redirect(array('/adminthanks/index'));
    }

    

}