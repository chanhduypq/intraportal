<?php

class AdminuserController extends Controller {

    public $pageTitle;

    /**
     * 
     */
    public function init() {
        parent::init();
        $this->pageTitle = "ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null") {
            $this->redirect(array('newgin/'));
        }
    }

//    protected function beforeAction($action) {
//        if ($action->id == 'regist') {
//            $beforeUrl = Yii::app()->request->urlReferrer;
//            if (
//                    strpos($beforeUrl, 'adminuser/regist') == FALSE && isset(Yii::app()->session['userregist'])
//            ) {
//                if (Yii::app()->request->cookies->contains('user_regist_from') && Yii::app()->request->cookies['user_regist_from']->value == 'confirm') {
//                    
//                } else {
//                    $cookie_collection = Yii::app()->request->cookies;
//                    $key_array = $cookie_collection->getKeys();
//                    unset(Yii::app()->session['userregist']);
//                    for ($i = 0, $n = count($key_array); $i < $n; $i++) {
//                        $key = $key_array[$i];
//                        if (substr($key, 0, 16) == 'file_user_regist') {
//                            if (file_exists(Yii::getPathOfAlias('webroot') . $_COOKIE[$key])) {
//                                unlink(Yii::getPathOfAlias('webroot') . $_COOKIE[$key]);
//                            }
//                        }
//                        if (substr($key, 0, 11) == 'user_regist' || substr($key, 0, 16) == 'file_user_regist') {
//                            unset(Yii::app()->request->cookies[$key]);
//                        }
//                    }
//                }
//            }
//        } else if ($action->id == 'edit') {
//            $beforeUrl = Yii::app()->request->urlReferrer;
//            if (
//                    strpos($beforeUrl, 'adminuser/edit') == FALSE && isset(Yii::app()->session['useredit'])
//            ) {
//                if (Yii::app()->request->cookies->contains('user_edit_from') && Yii::app()->request->cookies['user_edit_from']->value == 'confirm') {
//                    
//                } else {
//                    $cookie_collection = Yii::app()->request->cookies;
//                    $key_array = $cookie_collection->getKeys();
//                    unset(Yii::app()->session['useredit']);
//                    for ($i = 0, $n = count($key_array); $i < $n; $i++) {
//                        $key = $key_array[$i];
//                        if (substr($key, 0, 14) == 'file_user_edit') {
//                            if (file_exists(Yii::getPathOfAlias('webroot') . $_COOKIE[$key])) {
//                                unlink(Yii::getPathOfAlias('webroot') . $_COOKIE[$key]);
//                            }
//                        }
//                        if (substr($key, 0, 9) == 'user_edit' || substr($key, 0, 14) == 'file_user_edit') {
//                            unset(Yii::app()->request->cookies[$key]);
//                        }
//                    }
//                }
//            }
//        }
//        return parent::beforeAction($action);
//    }

    public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('user_edit_from') ? Yii::app()->request->cookies['user_edit_from']->value : '';
        $backCookie1 = Yii::app()->request->cookies->contains('user_regist_from') ? Yii::app()->request->cookies['user_regist_from']->value : '';

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

    /**
     *     
     */
    private $_user = null;

    /**
     * 
     */
    public function actionIndex() {
        $cookie_collection = Yii::app()->request->cookies;
        $key_array = $cookie_collection->getKeys();
        unset(Yii::app()->session['userregist']);
        unset(Yii::app()->session['useredit']);
        for ($i = 0, $n = count($key_array); $i < $n; $i++) {
            $key = $key_array[$i];
            if (substr($key, 0, 9) == 'file_user') {
                if (file_exists(Yii::getPathOfAlias('webroot') . $_COOKIE[$key])) {
                    unlink(Yii::getPathOfAlias('webroot') . $_COOKIE[$key]);
                }
            }
            if (substr($key, 0, 4) == 'user' || substr($key, 0, 9) == 'file_user') {
                unset(Yii::app()->request->cookies[$key]);
            }
        }

        $page = (isset($_GET['page']) ? $_GET['page'] : 1);
        $cookie = new CHttpCookie('page', $page);
        Yii::app()->request->cookies['page'] = $cookie;
        $page_size = Config::LIMIT_ROW;
        if (isset($_GET['name_search']) && $_GET['name_search'] != "") {

            if (is_numeric($_GET['name_search'])) {

                $item_count = Yii::app()->db->createCommand()
                        ->select('count(*) as count')
                        ->from('multi_table')
                        ->where('employee_number="' . $_GET['name_search'] . '"')
                        ->queryScalar();
                $users = Yii::app()->db->createCommand()
                        ->select(array(
									'*'
										)
								)
						->from('multi_table')
                        ->where('employee_number="' . $_GET['name_search'] . '"')
                        ->limit($page_size, ($page - 1) * $page_size)
                        ->order('convert(multi_table.employee_number,UNSIGNED) ASC')
                        ->queryAll();
            } else {

                $post_name = mb_convert_kana($_GET['name_search'], "s", "UTF-8");
                $post_name = str_replace("'", "", $post_name);
                
                $search_post_name = "";
                for ($i = 0; $i < count($post_name); $i++) {
					if($post_name[$i]!=""){
                   		 $search_post_name .= " or post_name like '%" . $post_name[$i] . "%'";
					}
                }

                $post_id = Yii::app()->db->createCommand("select id from post where post_name like '%" . $post_name."'")->queryRow();
             
                if (!empty($post_id)) {
                    
                    $item_count = Yii::app()->db->createCommand()
                            ->select('count(*) as count')
                            ->from('multi_table')
							->where("position1 = '".$post_id['id']. "'")
                            ->orWhere("position2 = '".$post_id['id']. "'")
                            ->orWhere("position3 = '".$post_id['id']. "'")
                            ->orWhere("position4 = '".$post_id['id']. "'")
                            ->queryScalar();

                    $users = Yii::app()->db->createCommand()
                            ->select(array(
									'*'
										)
								)
							->from('multi_table')
                            ->where("position1 = '".$post_id['id']. "'")
                            ->orWhere("position2 = '".$post_id['id']. "'")
                            ->orWhere("position3 = '".$post_id['id']. "'")
                            ->orWhere("position4 = '".$post_id['id']. "'")
                            ->limit($page_size, ($page - 1) * $page_size)
                            ->order('convert(multi_table.employee_number,UNSIGNED) ASC')
                            ->queryAll();
                }//end search post
                else {
                    //list base branch unit
					$base_search = trim(mb_convert_kana($_GET['name_search'], "s", "UTF-8"));
					$company_name = str_replace("'", "", $base_search);
                    $company_name = explode(" ", $company_name);
					
                    $search_company_name = "";
                    $list_unit_branch_base = "";
					$count_base = count($company_name);
					
                    for ($i = 0; $i < count($company_name); $i++) {
						if($company_name[$i]!=""){
							
                        	$search_company_name .= " or company_name like '%" . $company_name[$i] . "%'";
						}
						
                    }
				
					
                    $get_base_search = Yii::app()->db->createCommand("select id from base where company_name like '%" . $base_search . "%'$search_company_name")->queryAll();
					
                    if (!empty($get_base_search)) {
						//array id branch
						
						$branch_search =trim(mb_convert_kana($_GET['name_search'], "s", "UTF-8"));
						$branch_name = str_replace("'", "", $branch_search);
						$branch_name = explode(" ", $branch_name);
						
						$search_branch_name = "";
						for ($i = 0; $i < count($branch_name); $i++) {
							if($branch_name[$i]!=""){
								$search_branch_name .= " or branch_name like '%" . $branch_name[$i] . "%'";
							}
						}
						//
                        $array_base = array();
                        foreach ($get_base_search as $base_id) {
                            $array_base[] = $base_id['id'];
                        }
                        $list_base = "'" . implode("', '", $array_base) . "'";
						//
						
						$list_unit_branch_base = "";
						$sql_branch=""; 
						if($count_base > 1){ $sql_branch = "(branch_name like '%" . $branch_search . "%'$search_branch_name) and ";}
						
                        $get_branch_search = Yii::app()->db->createCommand("select id from branch where ".$sql_branch." base_id IN ($list_base)")->queryAll();
						
                        if (!empty($get_branch_search)) {
                            
							$unit_search = trim(mb_convert_kana($_GET['name_search'], "s", "UTF-8"));
							$unit_name = str_replace("'", "", $unit_search);
							$unit_name = explode(" ", $unit_name);
							
							$search_unit_name="";
							for ($i = 0; $i < count($unit_name); $i++) {
								if($unit_name[$i]!=""){
									$search_unit_name .= " or unit_name like '%" . $unit_name[$i] . "%'";
								}
							}
							//
							$array_unit = array();
							foreach ($get_branch_search as $branch_id) {
								$array_unit[] = $branch_id['id'];
							}
							$list_unit = "'" . implode("', '", $array_unit) . "'";
							//
							$sql_unit="";
							if($count_base > 1){ $sql_unit = "(unit_name like '%" . $unit_search . "%'$search_unit_name) and ";}
							
                            $get_unit_search = Yii::app()->db->createCommand("select id from unit where ".$sql_unit."  branch_id IN ($list_unit)")->queryAll();
							
                            if (!empty($get_unit_search)) {

                                $array_unit = array();
                                foreach ($get_unit_search as $unit_id) {
                                    $array_unit[] = $unit_id['id'];
                                }
                                $list_unit_branch_base = "'" . implode("', '", $array_unit) . "'";
                            }//end  unit_search
                        }//end  branch_search
                    }
					
                    //search_branch_name with unit
                    $branch_search = trim(mb_convert_kana($_GET['name_search'], "s", "UTF-8"));
					$branch_name = str_replace("'", "", $branch_search);
                    $branch_name = explode(" ", $branch_name);
					
					$count_branch = count($branch_name);
					
                    $search_branch_name = "";
                    for ($i = 0; $i < count($branch_name); $i++) {
						if($branch_name[$i]!=""){
                      		 $search_branch_name .= " or branch_name like '%" . $branch_name[$i] . "%'";
						}
                    }

                    $branch_search = Yii::app()->db->createCommand("select id from branch where branch_name like '%" . $branch_search . "%'$search_branch_name")->queryAll();
					
                    $list_unit_branch = "";
                    if (!empty($branch_search)) {
						//array id unit		
						$unit_search = mb_convert_kana($_GET['name_search'], "s");
						$unit_name = str_replace("'", "", $unit_search);
						$unit_name = explode(" ", $unit_name);
						
						$search_unit_name="";
						for ($i = 0; $i < count($unit_name); $i++) {
							if($unit_name[$i]!=""){
								$search_unit_name .= " or unit_name like '%" . $unit_name[$i] . "%'";
							}
						}
						//
                        $array_branch = array();
                        foreach ($branch_search as $branch_id) {
                            $array_branch[] = $branch_id['id'];
                        }
                        $list_branch = "'" . implode("', '", $array_branch) . "'";
						$sql_branch ="";
						if($count_branch > 1){ $sql_branch = "(unit_name like '%" . $unit_search . "%'$search_unit_name) and ";}
                        //array id unit	
						$get_unit_search = Yii::app()->db->createCommand("select id from unit where ".$sql_branch." branch_id IN ($list_branch)")->queryAll();	


                        if (!empty($get_unit_search)) {

                            $array_unit = array();
                            foreach ($get_unit_search as $unit_id) {
                                $array_unit[] = $unit_id['id'];
                            }
                            $list_unit_branch = "'" . implode("', '", $array_unit) . "'";
                        }
                    }
                    //search_unit_name
                    $unit_search = trim(mb_convert_kana($_GET['name_search'], "s", "UTF-8"));
					$unit_name = str_replace("'", "", $unit_search);
                    $unit_name = explode(" ", $unit_name);
					
                    $search_unit_name = "";
                    for ($i = 0; $i < count($unit_name); $i++) {
						if($unit_name[$i]!=""){
                      		  $search_unit_name .= " or unit_name like '%" . $unit_name[$i] . "%'";
						}
                    }
                    $get_unit_search = Yii::app()->db->createCommand("select id from unit where unit_name like '%" . $unit_search . "%'$search_unit_name")->queryAll();
					
                    $list_unit = "";
                    if (!empty($get_unit_search)) {

                        $array_unit = array();
                        foreach ($get_unit_search as $unit_id) {
                            $array_unit[] = $unit_id['id'];
                        }
                        $list_unit = "'" . implode("', '", $array_unit) . "'";
                    }
					
                    $list_sum = "";
                    if ($list_unit != "" && isset($list_unit)) {
                        if ($list_unit_branch == "") {
                            $list_sum .=$list_unit;
                        } else {
                            $list_sum .=$list_unit . ",";
                        }
                    }
                    if ($list_unit_branch != "" && isset($list_unit_branch)) {

                        if ($list_unit_branch_base == "") {
                            $list_sum .=$list_unit_branch;
                        } else {
                            $list_sum .=$list_unit_branch . ",";
                        }
                    }
                    if ($list_unit_branch_base != "" && isset($list_unit_branch_base)) {

                        $list_sum .=$list_unit_branch_base;
                    }

                    //search_user
					
                    if ($list_sum != "") {
						
                        //end search_unit_name
                        $item_count = Yii::app()->db->createCommand()
                                ->select('count(*) as count')
                                ->from('multi_table')
                                ->Where("division1 IN ($list_sum)")
                                ->orWhere("division2 IN ($list_sum)")
                                ->orWhere("division3 IN ($list_sum)")
                                ->orWhere("division4 IN ($list_sum)")
                                ->queryScalar();

                        $users = Yii::app()->db->createCommand()
                                ->select(array(
									'*'
										)
								)
								->from('multi_table')
                                ->Where("division1 IN ($list_sum)")
                                ->orWhere("division2 IN ($list_sum)")
                                ->orWhere("division3 IN ($list_sum)")
                                ->orWhere("division4 IN ($list_sum)")
                                ->limit($page_size, ($page - 1) * $page_size)
                                ->order('convert(multi_table.employee_number,UNSIGNED) ASC')
                                ->queryAll();
                    }//end  list list_sum
                    else {
                        //search_user
                        $name = trim(mb_convert_kana($_GET['name_search'], "s", "UTF-8"));
						
						$name = str_replace("'", "", $name);
                        $name = explode(" ", $name);

                        $first_name = "";
                        if (count($name) > 1) {
                            $firstname = count($name) - 1;

                            $first_name = $name[$firstname];
                        } else {
                            $first_name = $name['0'];
                        }

                        //end search_unit_name
                        $item_count = Yii::app()->db->createCommand()
                                ->select('count(*) as count')
                                ->from('multi_table')
                                ->Where('lastname like "%' . $name['0'] . '%" or firstname like "%' . $first_name . '%"') 
								->orWhere('lastname_kana like "%' . $name['0'] . '%" or firstname_kana like "%' . $first_name . '%"') 			
                                ->queryScalar();

                        $users = Yii::app()->db->createCommand()
								 ->select(array(
									'*'
										)
								)
								->from('multi_table')
                                ->Where('lastname like "%' . $name['0'] . '%" or firstname like "%' . $first_name . '%"') 
								->orWhere('lastname_kana like "%' . $name['0'] . '%" or firstname_kana like "%' . $first_name . '%"') 			
                                ->limit($page_size, ($page - 1) * $page_size)
                                ->order('convert(multi_table.employee_number,UNSIGNED) ASC')
                                ->queryAll();
                    }
                }
            }
        } //else if
        else {
            $item_count = Yii::app()->db->createCommand()
                    ->select('count(*) as count')
                    ->from('multi_table')
                    ->queryScalar();
            $users = Yii::app()->db->createCommand()
                    ->select(array(
                        '*'
                            )
                    )
                    ->from('multi_table')
                    ->limit($page_size, ($page - 1) * $page_size)
                    ->order('convert(multi_table.employee_number,UNSIGNED) ASC')
                    ->queryAll();
        }
        $pages = new CPagination($item_count);
        $pages->setPageSize($page_size);		
        
        $post = Yii::app()->db->createCommand("select id, post_name from post")->queryAll();
        $params = array('users' => $users,
            'post' => $post,
           
            'item_count' => $item_count,
            'page_size' => $page_size,
            'pages' => $pages);

        $this->render('/admin/user/index', $params);
    }

    public function actionEdit() {

        $model = $this->loadModel();
        if ($model == null || !isset($_GET['id'])) {
            $this->redirect(array('adminuser/index'));
        }
        $parmas = array();

        if (!isset($_POST['submit_active'])) {
            $temp = explode(" ", $model->birthday);
            $birthday_y_m_d = explode("-", $temp[0]);
            $model->birthday_year = $birthday_y_m_d[0];
            $model->birthday_month = intval($birthday_y_m_d[1]);
            $model->birthday_day = intval($birthday_y_m_d[2]);
        }

        if (Yii::app()->request->isAjaxRequest) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        $attachment4_error = isset(Yii::app()->session['attachment4']) ? Yii::app()->params['attachment4_error'] : '';

        unset(Yii::app()->session['attachment4']);

       
		$post = Yii::app()->db->createCommand("select id, post_name from post order by display_order ASC")->queryAll();
        $unit = Yii::app()->db->createCommand()
                ->select(array(
                    'unit.id',
                    'unit.unit_name',
                    'unit.branch_id',
                    'branch.branch_name',
                    'base.company_name'
                        )
                )
                ->from('unit')
                ->join('branch', 'branch.id=unit.branch_id')
                ->join('base', 'base.id=branch.base_id')
                ->where("unit.active_flag=1 and branch.active_flag=1 and base.modifiable_flag=1 and unit.modifiable_flag=1 and branch.modifiable_flag=1")
				->order("base.display_order asc , unit.display_order asc")
                ->queryAll();

      
        $parmas['post'] = $post;
        $parmas['unit'] = $unit;
        $parmas['attachment4_error'] = $attachment4_error;
        $parmas['model'] = $model;

        $this->render('/admin/user/edit', $parmas);
    }

    private function processPhoto($model) {

        if ($file = CUploadedFile::getInstance($model, 'photo')) {
            $file_name = $file->name;

            $model->photo_file_name = $file->name;
            $model->photo_file_bytes = base64_encode(file_get_contents($file->tempName));
            $model->photo_file_type = $file->type;
        } else {
            $model->photo_file_name = '';
        }
    }

    /**
     * 
     */
    public function actionEditconfirm() {
        $params = array();
        /**
         * 
         */
        $model = $this->loadModel();
        if ($model == NULL) {
            $this->redirect(array('adminuser/index'));
        }
        if (Yii::app()->request->isPostRequest) {
            Yii::app()->session['useredit'] = 'true';
            $message = CActiveForm::validate($model);
            if (!isset($_POST['edit']) || $_POST['edit'] != '1') {
                Upload_file_common_new::processAttachmentsuser($model, 2);
            }
            if ($message != "[]" && $model->photo_checkbox_for_deleting != '1') {
                $params['invalid'] = TRUE;
            }
            /**
             *
             */
            if ($model->validate() || $model->photo_checkbox_for_deleting == '1') {
                /**
                 *
                 */
                if (isset($_POST['edit']) && $_POST['edit'] == '1') {
                    $model->cancel_random=$_POST['cancel_random'];
                    if ($model->save() == true) {
                        unset(Yii::app()->session['useredit']);
                        $cookie_collection = Yii::app()->request->cookies;
                        $key_array = $cookie_collection->getKeys();
                        for ($i = 0, $n = count($key_array); $i < $n; $i++) {
                            $key = $key_array[$i];
                            if (substr($key, 0, 9) == 'user_edit' || substr($key, 0, 14) == 'file_user_edit') {
                                unset(Yii::app()->request->cookies[$key]);
                            }
                        }
                        if (Yii::app()->request->cookies['page'] != "") {
                            $page = "index?page=" . Yii::app()->request->cookies['page'];
                        } else {
                            $page = "";
                        }
                        $this->redirect(array('adminuser/' . $page . ''));
                    }
                }
            } else {
                if ($model->getError("photo") != "") {
                    Yii::app()->session['attachment4'] = true;
                }
                if ($model->photo != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->photo)) {
                    unlink(Yii::getPathOfAlias('webroot') . $model->photo);
                }
                unset(Yii::app()->session['useredit']);
                $cookie_collection = Yii::app()->request->cookies;
                $key_array = $cookie_collection->getKeys();
                for ($i = 0, $n = count($key_array); $i < $n; $i++) {
                    $key = $key_array[$i];
                    if (substr($key, 0, 9) == 'user_edit' || substr($key, 0, 14) == 'file_user_edit') {
                        unset(Yii::app()->request->cookies[$key]);
                        if (substr($key, 0, 4) == 'file') {
                            if (Yii::app()->request->cookies[$key] != "" && Yii::app()->request->cookies[$key] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value)) {
                                unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value);
                            }
                        }
                    }
                }
                $this->redirect(array('adminuser/edit/?id=' . $model->id));
            }
        } else {
            if (Yii::app()->request->cookies['page'] != "" && Yii::app()->request->cookies['page'] != "1") {
                $page = "index?page=" . Yii::app()->request->cookies['page'];
            } else {
                $page = "";
            }
            //$this->redirect(array('adminuser/' . $page . ''));
        }
       
        $post = Yii::app()->db->createCommand("select id, post_name from post")->queryAll();
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

        $params['model'] = $model;
        $params['post'] = $post;
        $params['unit'] = $unit;
        $this->render('/admin/user/editconfirm', $params);
    }

    /**
     * 
     */
    public function actionDetail() {
        if (!isset($_GET['id'])) {
            $this->redirect(array('adminuser/index'));
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
                    'division1',
                    'division2',
                    'division3',
                    'division4',
                    'position1',
                    'position2',
                    'position3',
                    'position4',
                    'birthday',
                    'cancel_random'
                        )
                )
                ->from('user')
                ->leftJoin('role', 'user.role_id=role.id')
                ->where('user.id=:id', array('id' => $_GET['id']))
                ->queryRow()
        ;
        if ($user == FALSE) {
            $this->redirect(array('adminuser/index'));
        }
        /**
         * 
         */
     
        $post = Yii::app()->db->createCommand("select id, post_name from post")->queryAll();
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

        $this->render('/admin/user/detail', array(
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

        if (isset($_GET['id'])) {//download from detail    
            $file_path = Yii::app()->db->createCommand()->select('photo')->from('user')->where("id=$id")->queryScalar();
        } else {//download from registconfirm
            $file_path = $_GET['file_name'];
        }
        Yii::import('ext.helpers.EDownloadHelper');
        EDownloadHelper::download(Yii::getPathOfAlias('webroot') . $file_path);



        exit;
    }

    /**
     * 
     */
    public function actionRegist() {

        $parmas = array();

        $model = new User();
        $model->passwd = '7581';
        $model->birthday_year = 1980;
        /**
         * 
         */
		
        $unit = Yii::app()->db->createCommand()
                ->select(array(
                    'unit.id',
                    'unit.unit_name',
                    'unit.branch_id',
                    'branch.branch_name',
                    'base.company_name'
                        )
                )
                ->from('unit')
                ->join('branch', 'branch.id=unit.branch_id')
                ->join('base', 'base.id=branch.base_id')
                ->where("unit.active_flag=1 and branch.active_flag=1 and base.modifiable_flag=1 and unit.modifiable_flag=1 and branch.modifiable_flag=1")
				 ->order("base.display_order asc , unit.display_order asc")
                ->queryAll();
        $post = Yii::app()->db->createCommand("select id, post_name from post order by display_order ASC")->queryAll();

        if (Yii::app()->request->isAjaxRequest) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        $attachment4_error = isset(Yii::app()->session['attachment4']) ? Yii::app()->params['attachment4_error'] : '';

        unset(Yii::app()->session['attachment4']);


        $parmas['attachment4_error'] = $attachment4_error;
        /**
         * 
         */
        $parmas['model'] = $model;
        $parmas['unit'] = $unit;
        $parmas['post'] = $post;
        $this->render('/admin/user/regist', $parmas);
    }

    /**
     * 
     */
    public function actionRegistconfirm() {

        $params = array();
        /**
         * 
         */
        $model = new User();
        $model->passwd = '7581';
		
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
       
        $post = Yii::app()->db->createCommand("select id, post_name from post")->queryAll();

        /**
         * 
         */
        if (Yii::app()->request->isPostRequest) {
            Yii::app()->session['userregist'] = 'true';
            /**
             * 
             */
            $message = CActiveForm::validate($model);
            if (!isset($_POST['regist']) || $_POST['regist'] != '1') {
                Upload_file_common_new::processAttachmentsuser($model, 1);
            }
            if ($message != "[]" && $model->photo_checkbox_for_deleting != '1') {
                $params['invalid'] = TRUE;
            }
            /**
             *
             */
            if ($model->validate() || $model->photo_checkbox_for_deleting == '1') {
                /**
                 *
                 */
                if (isset($_POST['regist']) && $_POST['regist'] == '1') {
                    $model->photo = $_POST['User']['photo'];
                    $model->cancel_random=$_POST['cancel_random'];
                    if ($model->save() == true) {
                        unset(Yii::app()->session['userregist']);
                        $cookie_collection = Yii::app()->request->cookies;
                        $key_array = $cookie_collection->getKeys();
                        for ($i = 0, $n = count($key_array); $i < $n; $i++) {
                            $key = $key_array[$i];
                            if (substr($key, 0, 11) == 'user_regist' || substr($key, 0, 16) == 'file_user_regist') {
                                unset(Yii::app()->request->cookies[$key]);
                            }
                        }
                        $this->redirect(array('adminuser/index'));
                    }
                }
            } else {
                if ($model->getError("photo") != "") {
                    Yii::app()->session['attachment4'] = true;
                }
                if ($model->photo != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->photo)) {
                    unlink(Yii::getPathOfAlias('webroot') . $model->photo);
                }
                unset(Yii::app()->session['userregist']);
                $cookie_collection = Yii::app()->request->cookies;
                $key_array = $cookie_collection->getKeys();
                for ($i = 0, $n = count($key_array); $i < $n; $i++) {
                    $key = $key_array[$i];
                    if (substr($key, 0, 11) == 'user_regist' || substr($key, 0, 16) == 'file_user_regist') {
                        unset(Yii::app()->request->cookies[$key]);
                        if (substr($key, 0, 4) == 'file') {
                            if (Yii::app()->request->cookies[$key] != "" && Yii::app()->request->cookies[$key] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value)) {
                                unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value);
                            }
                        }
                    }
                }
                $this->redirect(array('adminuser/regist'));
            }
        } else {
            //$this->redirect(array('adminuser/index'));
        }
        $params['model'] = $model;
        $params['post'] = $post;
        $params['unit'] = $unit;
        $this->render('/admin/user/registconfirm', $params);
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
     * 
     */
    public function actionDelete() {
        /**
         * 
         */
        $id = Yii::app()->request->getParam('id');
        /**
         * 
         */
        $model = new User();
        $model = $model->findByPk($id);
        $attachment1 = $model->photo;
        $model->deleteByPk($id);
        if ($attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment1)) {
            unlink(Yii::getPathOfAlias('webroot') . $attachment1);
            $thumnail_file_path = FunctionCommon::getFilenameInThumnail($attachment1);
            if (file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)) {
                unlink(Yii::getPathOfAlias('webroot') . $thumnail_file_path);
            }
        }
        /**
         * 
         */
        if ($id == Yii::app()->request->cookies['id']) {
            Yii::app()->request->cookies->clear();
            Yii::app()->user->logout();
            $this->redirect(Yii::app()->homeUrl);
        } else {
            $this->redirect(array('/adminuser/index'));
        }
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

    public function actionDownloadedit() {


        if (isset($_GET['id'])) {
            $file_name = Yii::app()->db->createCommand()
                    ->select('photo')
                    ->from('user')
                    ->where('id=:id', array('id' => $_GET['id']))
                    ->queryScalar();

            if ($file_name != "" && file_exists(Yii::getPathOfAlias('webroot') . $file_name)) {

                Yii::import('ext.helpers.EDownloadHelper');
                EDownloadHelper::download(Yii::getPathOfAlias('webroot') . $file_name);
            }
        }




        exit;
    }

    public function actionImport() {
        $msg = "";
        $numRecordSuccess = 0;
        $error_row_array = array();
        $exist_employeenumber_row_array = array();
        $role_id = Yii::app()->db->createCommand()
                ->select("id")
                ->from("role")
                ->where("role_name='一般社員'")
                ->queryScalar()
        ;


        if (isset($_FILES) && !empty($_FILES['inport_file'])) {


            if ($_FILES['inport_file']['error'] == 0) {

                $name = $_FILES['inport_file']['name'];
                $size = $_FILES['inport_file']['size'];
                preg_match('/\.[^\.]+$/i', $name, $ext);
                if ($ext[0] == ".csv" || $ext[0] == ".CSV") {
                    $path = Upload_config::getUploadPath('user');
                    Upload_config::createFolder($path, Yii::getPathOfAlias('webroot'), 1);
                    $attachment1_path = $path . 'attachment1/';
                    if ($size > 0) {
                        $tmp = $_FILES['inport_file']['tmp_name'];
                        if (($handle = fopen($tmp, 'r')) !== FALSE) {
                            set_time_limit(0);
                            $row = 0;
                            $fieldError = false;


                            while (($data = fgetcsv($handle, $size, ',')) !== FALSE) {
                                $row++;
                                if ($row != 1) {
                                    $data=  implode(",",$data);
//                                    $data=mb_convert_kana(mb_convert_encoding($data, 'UTF-8', mb_detect_encoding($data,"ASCII,JIS,UTF-8,EUC-JP,SJIS")), "KV", "UTF-8");
                                    $data=mb_convert_encoding($data, "UTF-8", "UTF-8, sjis-win");
                                    $data=  explode(",",$data);
                                    $employee_number = $data[0];
                                    $mailadrr = $data[1];
//                                    $lastname=mb_convert_kana(mb_convert_encoding($data[2], 'UTF-8', mb_detect_encoding($data[2],"ASCII,JIS,UTF-8,EUC-JP,SJIS")), "KV", "UTF-8");
                                    $lastname=$data[2];
//                                    $firstname = mb_convert_kana(mb_convert_encoding($data[3], 'UTF-8', mb_detect_encoding($data[3], "ASCII,JIS,UTF-8,EUC-JP,SJIS")), "KV", "UTF-8");
                                    $firstname=$data[3];
//                                    $lastname_kana = mb_convert_kana(mb_convert_encoding($data[4], 'UTF-8', mb_detect_encoding($data[4], "ASCII,JIS,UTF-8,EUC-JP,SJIS")), "KV", "UTF-8");
                                    $lastname_kana=mb_convert_kana($data[4], "KV", "UTF-8");
//                                    $firstname_kana = mb_convert_kana(mb_convert_encoding($data[5], 'UTF-8', mb_detect_encoding($data[5], "ASCII,JIS,UTF-8,EUC-JP,SJIS")), "KV", "UTF-8");
                                    $firstname_kana=mb_convert_kana($data[5], "KV", "UTF-8");
                                    $birthdate = $data[7];
                                    $joindate = $data[8];
//                                    $company_name1 = mb_convert_kana(mb_convert_encoding($data[9], 'UTF-8', mb_detect_encoding($data[9], "ASCII,JIS,UTF-8,EUC-JP,SJIS")), "KV", "UTF-8");
                                    $company_name1=$data[9];
//                                    $branch_name1 = mb_convert_kana(mb_convert_encoding($data[10], 'UTF-8', mb_detect_encoding($data[10], "ASCII,JIS,UTF-8,EUC-JP,SJIS")), "KV", "UTF-8");
                                    $branch_name1=$data[10];
//                                    $unit_name1 = mb_convert_kana(mb_convert_encoding($data[11], 'UTF-8', mb_detect_encoding($data[11], "ASCII,JIS,UTF-8,EUC-JP,SJIS")), "KV", "UTF-8");
                                    $unit_name1=$data[11];
//                                    $position1 = mb_convert_kana(mb_convert_encoding($data[12], 'UTF-8', mb_detect_encoding($data[12], "ASCII,JIS,UTF-8,EUC-JP,SJIS")), "KV", "UTF-8");
                                    $position1=$data[12];

//                                    $company_name2 = mb_convert_kana(mb_convert_encoding($data[13], 'UTF-8', mb_detect_encoding($data[13], "ASCII,JIS,UTF-8,EUC-JP,SJIS")), "KV", "UTF-8");
                                    $company_name2=$data[13];
//                                    $branch_name2 = mb_convert_kana(mb_convert_encoding($data[14], 'UTF-8', mb_detect_encoding($data[14], "ASCII,JIS,UTF-8,EUC-JP,SJIS")), "KV", "UTF-8");
                                    $branch_name2=$data[14];
//                                    $unit_name2 = mb_convert_kana(mb_convert_encoding($data[15], 'UTF-8', mb_detect_encoding($data[15], "ASCII,JIS,UTF-8,EUC-JP,SJIS")), "KV", "UTF-8");
                                    $unit_name2=$data[15];
//                                    $position2 = mb_convert_kana(mb_convert_encoding($data[16], 'UTF-8', mb_detect_encoding($data[16], "ASCII,JIS,UTF-8,EUC-JP,SJIS")), "KV", "UTF-8");
                                    $position2=$data[16];

//                                    $company_name3 = mb_convert_kana(mb_convert_encoding($data[17], 'UTF-8', mb_detect_encoding($data[17], "ASCII,JIS,UTF-8,EUC-JP,SJIS")), "KV", "UTF-8");
                                    $company_name3=$data[17];
//                                    $branch_name3 = mb_convert_kana(mb_convert_encoding($data[18], 'UTF-8', mb_detect_encoding($data[18], "ASCII,JIS,UTF-8,EUC-JP,SJIS")), "KV", "UTF-8");
                                    $branch_name3=$data[18];
//                                    $unit_name3 = mb_convert_kana(mb_convert_encoding($data[19], 'UTF-8', mb_detect_encoding($data[19], "ASCII,JIS,UTF-8,EUC-JP,SJIS")), "KV", "UTF-8");
                                    $unit_name3=$data[19];
//                                    $position3 = mb_convert_kana(mb_convert_encoding($data[20], 'UTF-8', mb_detect_encoding($data[20], "ASCII,JIS,UTF-8,EUC-JP,SJIS")), "KV", "UTF-8");
                                    $position3=$data[20];
                                    $division1 = $this->getUnitId($company_name1, $branch_name1, $unit_name1);
                                    $division2 = $this->getUnitId($company_name2, $branch_name2, $unit_name2);
                                    $division3 = $this->getUnitId($company_name3, $branch_name3, $unit_name3);

                                    if (preg_match("/^([\x30-\x39]|\-)+$/", $employee_number) && preg_match("/[a-zA-Z0-9_\-\/\.]+\@[a-zA-Z0-9_\-]+\.[a-zA-Z0-9_\-]+/", $mailadrr) && preg_match("/[0-9]{4}\/[0-9]{2}|[0-9]{1}\/[0-9]{2}|[0-9]{1}/", $birthdate) && preg_match("/[0-9]{4}\/[0-9]{2}|[0-9]{1}\/[0-9]{2}|[0-9]{1}/", $joindate)
                                    ) {
                                        $joindate = substr($joindate, 0, 4);
                                        $model = new User();
                                        $model->employee_number = $employee_number;
                                        $model->mailaddr = $mailadrr;
                                        $model->firstname = $firstname;
                                        $model->lastname = $lastname;
                                        $model->lastname_kana = $lastname_kana;
                                        $model->firstname_kana = $firstname_kana;
                                        $model->birthday = date('Y-m-d H:i:s', strtotime($birthdate));
                                        $model->joindate = $joindate;
                                        $model->passwd = '7581';
                                        $model->role_id = $role_id;
                                        $model->division1 = $division1;
                                        $model->division2 = $division2;
                                        $model->division3 = $division3;
                                        $model->position1 =  $this->getPositionId($position1);
                                        $model->position2 = $this->getPositionId($position2);
                                        $model->position3 = $this->getPositionId($position3);

                                        if ($handle1 = opendir(Config::IMAGE_PATH)) {
                                            while (false !== ($entry = readdir($handle1))) {
                                                if ($entry != "." && $entry != "..") {
                                                    $temp = explode(".", $entry);
                                                    $extension = $temp[count($temp) - 1];
                                                    if (in_array($extension, Constants::$imgExtention)) {
                                                        $temp = explode("." . $extension, $entry);
                                                        $file_name_not_contain_extension = $temp[0];
                                                        if ($file_name_not_contain_extension == $employee_number) {
                                                            $this->processImage(Config::IMAGE_PATH . $entry, $attachment1_path . $entry);                                                            
                                                            $model->photo = $attachment1_path . $entry;                                                            
                                                            break;
                                                        }
                                                    }
                                                }
                                            }
                                            closedir($handle1);
                                        }


                                        
                                        if ($model->validate() && $this->isDate($birthdate) && $this->isDate($data[8]) && is_numeric($joindate) && is_numeric($division1)) {                                            
                                            $model->flag_for_save_by_upload_file_csv=true;
                                            if ($model->save() == true) {
                                                $numRecordSuccess ++;
                                            } else {
                                                $error_row_array[] = $row;
                                            }
                                        } else {
                                            $validate=json_decode(CActiveForm::validate($model));
                                            $validate=(array)$validate;
                                            if(isset($validate['User_employee_number'])){
                                                $exist_employeenumber_row_array[] = $row;
                                            }
                                            else{
                                                $error_row_array[] = $row;
                                            }
                                            
                                        }
                                    } else {
                                        $error_row_array[] = $row;
                                    }
                                }
                            }

                            fclose($handle);

                            $msg = "SUCCESS";
                        }
                    } else {
                        $msg = "ERROR";
                    }
                } else {
                    $msg = "ERROR";
                }
            } else {
                $msg = "ERROR";
            }
        } else {
            $msg = "";
        }

        $this->render('/admin/user/import', array('msg' => $msg, 'error_row_array' => $error_row_array,'exist_employeenumber_row_array'=>$exist_employeenumber_row_array, 'numRecordSuccess' => $numRecordSuccess));
    }

    private function getPositionId($positon) {
        if ($positon == NULL || trim($positon) == "") {
            return NULL;
        }
        
        
        $positon = Yii::app()->db->createCommand("select id from post where post_name='$positon'")->queryScalar();
        if ($positon == FALSE || !is_numeric($positon)) {
            return NULL;
        }
        return $positon;
    }

    private function getUnitId($company_name1, $branch_name1, $unit_name1) {
        if(trim($branch_name1)==  trim($unit_name1)){
            $unit_id = Yii::app()->db->createCommand()
                ->select("unit.id")
                ->from("unit")
                ->join('branch', 'branch.id=unit.branch_id')
                ->join('base', 'branch.base_id=base.id')                
                ->where("branch.branch_name='$branch_name1'")
                ->andWhere("base.company_name='$company_name1'")
                ->queryScalar();
        }
        else{
            $unit_id = Yii::app()->db->createCommand()
                ->select("unit.id")
                ->from("unit")
                ->join('branch', 'branch.id=unit.branch_id')
                ->join('base', 'branch.base_id=base.id')
                ->where("unit.unit_name='$unit_name1'")
                ->andWhere("branch.branch_name='$branch_name1'")
                ->andWhere("base.company_name='$company_name1'")
                ->queryScalar();
        }
        
        return $unit_id;
    }

    private function processImage($filename, $destination) {
        copy($filename, Yii::getPathOfAlias('webroot') . $destination);
        $thumnail_file_path = FunctionCommon::getFilenameInThumnail($destination);
        copy($filename, Yii::getPathOfAlias('webroot') . $thumnail_file_path);
        $url5 = ltrim($destination, '/');
        $size = getimagesize($url5);
        $w = $size[0];
        $h = $size[1];
        if (($w >= Config::IMG_WIDTH_BIG && $h >= Config::IMG_HEIGHT_BIG) || ($w > Config::IMG_WIDTH_BIG && $h < Config::IMG_HEIGHT_BIG) || ($w < Config::IMG_WIDTH_BIG && $h > Config::IMG_HEIGHT_BIG)) {
            $image = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . $destination);
            $image->resize(Config::IMG_WIDTH_BIG, Config::IMG_HEIGHT_BIG);
            $image->save();
        }
        $url2 = ltrim($thumnail_file_path, '/');
        $width = Config::IMG_WIDTH;
        $height = 171;
        list($width_orig, $height_orig) = getimagesize($url2);
        $ratio_orig = $width_orig / $height_orig;
        if ($width / $height > $ratio_orig) {
            $width = $height * $ratio_orig;
        } else {
            $height = $width / $ratio_orig;
        }
        $image = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . $thumnail_file_path);
        $image->resize($width, $height);
        $image->save();
    }

    private function isDate($date) {
        if ($date == null || !is_string($date) || trim($date) == '') {
            return FALSE;
        }
        $temp = explode("/", $date);
        if (count($temp) != 3) {
            return FALSE;
        }
        $day = $temp[2];
        $month = $temp[1];
        $year = $temp[0];
        if ($day < 1 || $day > 31) {
            return FALSE;
        }
        if ($month == '4' || $month == '6' || $month == '9' || $month == '11') {
            if ($day > 30) {
                return FALSE;
            }
        } else if ($month == '2') {
            if ($day > 29) {
                return FALSE;
            }
            if ($year % 4 != 0 && $day == 29) {
                return FALSE;
            }
        }
        return true;
    }

}
