<?php

class AdminprofileController extends Controller {

	public $pageTitle;
    /**
     * 
     */
   //check if logined or not
   public function init()
   {
        parent::init();
		$this->pageTitle="ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id']=="null" ) 
		{
          $this->redirect(array('newgin/'));
        }
    }

    /**
     *     
     */
    private $_user = null;

    

    /**
     * 
     */
    public function actionEdit() {
        /**
         * 
         */
		 
        $model = $this->loadModel();
        if($model==null||!isset($_GET['id'])){
            $this->redirect(array('admin/index'));
        }
        /**
         * 
         */
        $parmas = array();         
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

            CActiveForm::validate($model);

			$model->photo_public_flag = $_POST['photo_pulic_flag'];
            //if ($model->validate()&&$error==FALSE) {    
			 if ($model->validate()) {                                   
                //Upload_file_common::processAttachmentsuser($model,2);
                if($model->save()==true){
					//baodt
					//time 19/08/2013
					//set cookie pass
					$id_user = Yii::app()->db->createCommand("select * from user where id=".$_GET['id'])->queryRow();		
					$passwd = new CHttpCookie('passwd', $id_user['passwd']);
					Yii::app()->request->cookies['passwd'] = $passwd;
					//end
                    $this->redirect(array('adminprofile/detail/?id='.$model->id));
                }             
            }            
        }
     
		$post   = Yii::app()->db->createCommand("select id, post_name from post")->queryAll();
		$unit = Yii::app()->db->createCommand()
						->select(array(
							'unit.id',
							'unit.branch_id',
							'unit.unit_name',
							'unit.modifiable_flag',
							'branch.branch_name',
							'base.company_name'
								)
						)
						->from('unit') 
						->join('branch', 'branch.id=unit.branch_id')
						->join('base', 'base.id=branch.base_id')
						->where("unit.active_flag=1 and unit.modifiable_flag=1 and branch.modifiable_flag=1 and branch.active_flag=1 and base.modifiable_flag=1")
						->order('unit.display_order ASC')
						->queryAll();
        $parmas['model'] = $model;       
		$parmas['post'] = $post;    
		$parmas['unit'] = $unit; 
       

        $this->render('/admin/profile/edit', $parmas);
    }  

    /**
     * 
     */
    public function actionDetail() {
        if(!isset($_GET['id'])){
            $this->redirect(array('admin/index'));
        }
        
        $user = Yii::app()->db->createCommand()
                ->select(array(
                    'user.id',
                    'employee_number',
                    'firstname',
                    'lastname',
                    'role_name',
                    'mailaddr',
                    'joindate',
                    'lastname_kana',
                    'firstname_kana',
                    'catchphrase',
                    'comment',
                    'photo',
                    'passwd',
                    'birthday',
					'division1',
					'division2',
					'division3',
					'division4',
					'position1',
					'position2',
					'position3',
					'position4',
                        )
                )
                ->from('user')
                ->leftJoin('role', 'user.role_id=role.id')
                ->where('user.id=:id', array('id' => $_GET['id']))
                ->queryRow()
        ;
        if($user==FALSE){
            $this->redirect(array('admin/index'));
        }
        /**
         * 
         */
		
		$post   = Yii::app()->db->createCommand("select id, post_name from post")->queryAll();
		$unit = Yii::app()->db->createCommand()
						->select(array(
							'unit.id',
							'unit.branch_id',
							'unit.unit_name',
							'unit.modifiable_flag',
							'branch.branch_name',
							'base.company_name'
								)
						)
						->from('unit') 
						->join('branch', 'branch.id=unit.branch_id')
						->join('base', 'base.id=branch.base_id')
						->where("unit.active_flag=1 and unit.modifiable_flag=1 and branch.modifiable_flag=1 and branch.active_flag=1 and base.modifiable_flag=1")
						->order('unit.display_order ASC')
						->queryAll();
        $this->render('/admin/profile/detail', array(
            'user' => $user,
			'post' => $post,
			'unit' => $unit,
                )
        );
    }

    /**
     * 
     */
    public function actionDownload() {
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
            $file_name = $model->photo_file_name;
            $file_type = $model->photo_file_type;
            $content = base64_decode($model->photo_file_bytes);
            /**
             *
             */
            header('Content-Type: ' . $file_type);
            header('Content-Disposition: attachment;filename="' . $file_name . '"');
            header('Cache-Control: max-age=0');
            echo $content;
        } else {//download file from host
            $attachment = 0;
            if (isset($_GET['1'])) {
                $attachment = 1;
            }
            if ($attachment != 0) {
                $file_name = Yii::app()->db->createCommand()
                        ->select('photo')
                        ->from('user')
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
        if ($this->_user === null) {
            if (isset($_GET['id'])) {
                $this->_user = User::model()->findbyPk(intval($_GET['id']));
            } else if (isset($_POST['User'])) {
                $data = $_POST['User'];
                $id = $data['id'];
                $this->_user = User::model()->findbyPk(intval($id));
            } else {
                $this->_user = new User();
            }
        }
        return $this->_user;
    }

    

    /**
     * @param array $branch_id_array 
     * @return array Description
     */
    private function getBranchNamesBybranchIds($branch_id_array) {
        if ($branch_id_array == null || !is_array($branch_id_array) || count($branch_id_array) == 0) {
            return array();
        }

        $select = Yii::app()->db->createCommand()->select(array(
            'branch_name',
        ));
        try {
            $items = $select
                    ->from('base')
                    ->where('id IN (' . implode(",", $branch_id_array) . ')')
                    ->queryAll()
            ;
        } catch (Exception $e) {
            return array();
        }
        $result = array();
        if (is_array($items) && count($items)) {
            foreach ($items as $item) {
                $result[] = $item['branch_name'];
            }
        }
        return $result;
    }

}