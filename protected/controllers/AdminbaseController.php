<?php
/*
 * Create Date: 31/07/2013
 * Update Date: 03/07/2013
 * Author: Hungtc
 * User change: Hungtc
 * Description: Admin action index object from model Rival  
 * */

class AdminbaseController extends Controller {

    private $_base = null;
	private $_branch = null;
	private $_unit = null;
	public $pageTitle;
    //check if logined or not
    public function init() {
        parent::init();
		$this->pageTitle="ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null") {
            $this->redirect(array('newgin/'));
        }
    }
    /**
     *  load model base
     */
    public function loadModel() {
        if ($this->_base === null) {
            if (isset($_GET['id'])) {
                $this->_base = Base::model()->findbyPk(intval($_GET['id']));
            } else if (isset($_POST['Base'])) {
                $data = $_POST['Base'];
                $id = $data['id'];
                $this->_base = Base::model()->findbyPk(intval($id));
				if($this->_base==NULL){
                    $this->_base=new Base();
                }
            } else {
                $this->_base = new Base();
            }
        }
        return $this->_base;
    }
    private function getUserCountInBase($base_id){
        $count = Yii::app()->db->createCommand()
                ->select("count(*) as count")
                ->from('user')
				->where('division1 in (select id from unit WHERE unit.branch_id in (SELECT id from branch WHERE branch.base_id='.$base_id.'))')
				->orwhere('division2 in (select id from unit WHERE unit.branch_id in (SELECT id from branch WHERE branch.base_id='.$base_id.'))')
				->orwhere('division3 in (select id from unit WHERE unit.branch_id in (SELECT id from branch WHERE branch.base_id='.$base_id.'))')
				->orwhere('division4 in (select id from unit WHERE unit.branch_id in (SELECT id from branch WHERE branch.base_id='.$base_id.'))')
                ->queryScalar();
        return $count;
    }

        /**
     * base index
     */
    public function actionIndex() {
//        if (Yii::app()->request->isAjaxRequest) {
//                $base_id=$_GET['base_id'];
//                
//                $count = Yii::app()->db->createCommand()
//                ->select("count(*) as count")
//                ->from('user')
//				->where('division1 in (select id from unit WHERE unit.branch_id in (SELECT id from branch WHERE branch.base_id='.$base_id.'))')
//				->orwhere('division2 in (select id from unit WHERE unit.branch_id in (SELECT id from branch WHERE branch.base_id='.$base_id.'))')
//				->orwhere('division3 in (select id from unit WHERE unit.branch_id in (SELECT id from branch WHERE branch.base_id='.$base_id.'))')
//				->orwhere('division4 in (select id from unit WHERE unit.branch_id in (SELECT id from branch WHERE branch.base_id='.$base_id.'))')
//                ->queryScalar();
//                echo $count;
//                Yii::app()->end();
//            }
		$bases = Yii::app()->db->createCommand()
                ->select(array(
                    'company_name',
                    'id',
					'modifiable_flag'
                        )
                )
                ->from('base')    
                ->order('display_order ASC')
                ->queryAll();
               for($i=0,$n=count($bases);$i<$n;$i++){
                   $bases[$i]['user_count']=  $this->getUserCountInBase($bases[$i]['id']);
               }
        $model=  $this->loadModel();
        $params = array('bases' => $bases,
            'model'=>$model,
                );
        $this->render('/admin/base/index', $params);	
    }
	/**
     * base index regist edit
     */
	public function actionRegistedit(){
       
        if (Yii::app()->request->isAjaxRequest) {
            $model= new Base();
            echo CActiveForm::validate($model); 
            Yii::app()->end();
        }
		
        if (Yii::app()->request->isPostRequest) {            
            $model= $this->loadModel();
            CActiveForm::validate($model); 
            if ($model->validate()) { 
                $model->save();
            }
            $this->redirect(array('/adminbase/index'));
        }        
        
    }
	/**
     * base up modifiable_flag
     */
    public function actionUpmodifiable() {
		
		if(!empty($_POST)){
			
			if(isset($_POST['Base']['id'])&&$_POST['Base']['id']!=""){
				$model		 = new Base();
				$id1		 = $_POST['Base']['id'];
				$id2		 = $_POST['Base']['modifiable_flag'];    
				$table_name  = $_POST['table_name'];
				$link		 = "index";	
                                
			}
			else if(isset($_POST['Unit']['id'])&&$_POST['Unit']['id']!=""){                            
				$model		 = new Unit();
				$id1		 = $_POST['Unit']['id'];
				$id2		 = $_POST['Unit']['modifiable_flag'];                
				$table_name  = $_POST['table_name'];  
				$link		 = "unit/?base_id=".$_POST['Unit']['base_id'];	      
			}
			else if(isset($_POST['Branch']['id'])&&$_POST['Branch']['id']!=""){
				$model		 = new Branch();
				$id1		 = $_POST['Branch']['id'];
				$id2		 = $_POST['Branch']['modifiable_flag'];                
				$table_name  = $_POST['table_name'];  
				$link		 = "branch/?base_id=".$_POST['Branch']['base_id'];	      
			}
			
			if($id2=='3'){
				
				$transction  = $model->dbConnection->beginTransaction();
				
					
				
				if($_POST['table_name']=='base'){
				//get list id branch		
				$list_branch_id   = Yii::app()->db->createCommand("select id from branch where base_id ='".$id1."'")->queryAll();
									//created list_array_branch_id
									$list_array_branch_id="";
									
									if (!empty($list_branch_id)) {
											//created array id branch
											$array_branch_id = array();
											foreach ($list_branch_id as $branch_id){
												   $array_branch_id[] = $branch_id['id'];	   
											}
											$list_array_branch_id = "'". implode("', '", $array_branch_id) ."'";
											
											
											//get list id unit
											$unit = Yii::app()->db->createCommand()
												->select('*')
												->from('unit')
												->where("branch_id IN ($list_array_branch_id)")
												->queryAll();
											$list_array_unit_id="";
											if (!empty($unit)) {
													//created array id unit
													$array_unit_id = array();
													foreach ($unit as $unit_id){
														   $array_unit_id[] = $unit_id['id'];	   
													}
													$list_array_unit_id = "'". implode("', '", $array_unit_id) ."'";
													//delete divison1 in () array_unit_id
													
													 Yii::app()->db->createCommand()->delete('user', 'division2 is null AND division3 is null AND division4 is null AND division1 IN ('.$list_array_unit_id.')');			
											}
											
											//delete id unit witd branch_id in () array_branch_id
											Yii::app()->db->createCommand()->delete('unit', array('in', 'branch_id', $array_branch_id));

									}
						Yii::app()->db->createCommand()->delete("branch","base_id=:base_id", array("base_id"=>$id1,));	
						$delete			  = $model->deleteByPk($id1);
					
				}
				else if($_POST['table_name']=='unit'){
					
						
					   //get list id unit
						$unit   = Yii::app()->db->createCommand("select id from unit where id ='".$id1."'")->queryRow();
						
						if (!empty($unit)) {
								//delete divison1 in () array_unit_id
								 Yii::app()->db->createCommand()->delete("user", "division2 is null AND division3 is null AND division4 is null AND division1 ='".$unit['id']."'");	
						}
						$delete			  = $model->deleteByPk($id1);
								
				}
				else if($_POST['table_name']=='branch'){
					
									$branch   = Yii::app()->db->createCommand("select id from branch where id ='".$id1."'")->queryRow();
									//created list_array_branch_id
									if (!empty($branch)) {
											
											//get list id unit
											$unit   = Yii::app()->db->createCommand("select id from unit where branch_id ='".$branch['id']."'")->queryAll();
											
											$list_array_unit_id="";
											if (!empty($unit)) {
													//created array id unit
													$array_unit_id = array();
													foreach ($unit as $unit_id){
														   $array_unit_id[] = $unit_id['id'];	   
													}
													$list_array_unit_id = "'". implode("', '", $array_unit_id) ."'";
													//delete divison1 in () array_unit_id
													
													 Yii::app()->db->createCommand()->delete('user', 'division2 is null AND division3 is null AND division4 is null AND division1 IN ('.$list_array_unit_id.')');			
											}
											
											//delete id unit witd branch_id in () array_branch_id
											 Yii::app()->db->createCommand()->delete("unit", "branch_id ='".$branch['id']."'");	
									}
						$delete			  = $model->deleteByPk($id1);
				}
				//
				if($delete){
					$transction->commit();
				}
				else{
					$transction->rollback();
				}
				 	 	
			}
			else{
				$transction  = $model->dbConnection->beginTransaction();
				$affect	 = Yii::app()->db->createCommand("update $table_name set modifiable_flag=$id2 where id=$id1")->execute();
				if($affect){
					$transction->commit();
				}
				else{
					$transction->rollback();
				}
			}
        }  
		$this->redirect(array('/adminbase/'.$link));	
    }
	/**
     * base/branch loadmodel
     */
	public function loadModel_branch() {
        if ($this->_branch === null) {
            if (isset($_GET['id'])) {
                $this->_branch = Branch::model()->findbyPk(intval($_GET['id']));
            } else if (isset($_POST['Branch'])) {
                $data = $_POST['Branch'];
                $id = $data['id'];
                $this->_branch = Branch::model()->findbyPk(intval($id));
				if($this->_branch==NULL){
                    $this->_branch=new Branch();
                }
            } else {
                $this->_branch = new Branch();
            }
        }
        return $this->_branch;
    }
	/**
     * base/branch index
     */
	 public function actionBranch() {
		$base_id = Yii::app()->request->getParam('base_id');
		$base_company   = Yii::app()->db->createCommand("select * from base where id = '".$base_id."'")->queryRow();
	    if ((isset($base_id) && $base_id == "") || $base_company['id']=="") {$this->redirect(array('/adminbase/'));}
		else if (isset($base_id) && $base_id != "") {
			$branchs = Yii::app()->db->createCommand()
					->select(array(
						'branch_name',
						'id',
						'modifiable_flag'
							)
					)
					->from('branch') 
					->where('active_flag=1 and base_id = "'.$base_id.'"')  
					->order('display_order ASC')
					->queryAll();
			$model=  $this->loadModel_branch();
			$params = array('branchs' => $branchs,
				'model'=>$model,
				'base_company'=>$base_company,
					);
			$this->render('/admin/base/branch', $params);	
		}
    }
	/**
     * base/branch regist_edit
     */
	public function actionRegisteditbranch(){
       
        if (Yii::app()->request->isAjaxRequest) {
            $model= new Branch();
            echo CActiveForm::validate($model); 
            Yii::app()->end();
        }
        if (Yii::app()->request->isPostRequest) { 
		           
            $model= $this->loadModel_branch();
            CActiveForm::validate($model); 
			
            if ($model->validate()) { 
			
                $model->save();
            }
            $this->redirect(array('/adminbase/branch/?base_id='.$_POST['Branch']['base_id']));
        }        
        
    }
	/**
     * base/branch loadmodel
     */
	public function loadModel_unit() {
        if ($this->_unit === null) {
            if (isset($_GET['id'])) {
                $this->_unit = Unit::model()->findbyPk(intval($_GET['id']));
            } else if (isset($_POST['Unit'])) {
                $data = $_POST['Unit'];
                $id = $data['id'];
                $this->_unit = Unit::model()->findbyPk(intval($id));
				if($this->_unit==NULL){
                    $this->_unit=new Unit();
                }
            } else {
                $this->_unit = new Unit();
            }
        }
        return $this->_unit;
    }
    private function getUserCountInUnit($unit_id){
        $count = Yii::app()->db->createCommand()
                ->select("count(*) as count")
                ->from('user')
				->where('division1="'.$unit_id.'"')
				->orwhere('division2="'.$unit_id.'"')
				->orwhere('division3="'.$unit_id.'"')
				->orwhere('division4="'.$unit_id.'"')                        
                ->queryScalar();
        return $count;
    }

    /**
     * base/unit index
     */
	 public function actionUnit() {
//             if (Yii::app()->request->isAjaxRequest) {
//                $unit_id=$_GET['unit_id'];
//                $count = Yii::app()->db->createCommand()
//                ->select("count(*) as count")
//                ->from('user')
//				->where('division1="'.$unit_id.'"')
//				->orwhere('division2="'.$unit_id.'"')
//				->orwhere('division3="'.$unit_id.'"')
//				->orwhere('division4="'.$unit_id.'"')                        
//                ->queryScalar();
//                echo $count;
//                Yii::app()->end();
//            }
		 
		$base_id = Yii::app()->request->getParam('base_id');
		$base_company   = Yii::app()->db->createCommand("select * from base where id = '".$base_id."'")->queryRow();
		if ((isset($base_id) && $base_id == "") || $base_company['id']=="") {$this->redirect(array('/adminbase/'));}

		else if (isset($base_id) && $base_id != "") {
			$branch_id   = Yii::app()->db->createCommand("select * from branch where base_id = '".$base_id."'")->queryAll();
			if (!empty($branch_id)) {
								
				$array_id = array();
				foreach ($branch_id as $id_branch){
					   $array_id[] = $id_branch['id'];	   
				}
				$list_id_unit = "'". implode("', '", $array_id) ."'";	
	
				$units = Yii::app()->db->createCommand()
						->select(array(
							'unit.unit_name',
							'unit.id',
							'unit.modifiable_flag',
							'branch.branch_name'
								)
						)
						->from('unit') 
						->join('branch', 'branch.id=unit.branch_id')
						->where("unit.active_flag=1 and unit.branch_id IN ($list_id_unit) and branch.modifiable_flag=1")
						->order('unit.display_order ASC')
						->queryAll();
                                for($i=0,$n=count($units);$i<$n;$i++){
                                   $units[$i]['user_count']=  $this->getUserCountInUnit($units[$i]['id']);
                               }
				
			}
		}
		if (!empty($units)) {		
			$model=  $this->loadModel_unit();
			$params = array('units' => $units,
			'model'=>$model,
			'base_company'=>$base_company
				);
		}else{
			$model=  $this->loadModel_unit();
			$params = array('model'=>$model,
			'base_company'=>$base_company
				);
		}				
       
        $this->render('/admin/base/unit', $params);	
    }
    /**
     * Regist 
     */
    public function actionRegist() {
		$base_id = Yii::app()->request->getParam('base_id');
		$base_company   = Yii::app()->db->createCommand("select * from base where id = '".$base_id."'")->queryRow();
		if ((isset($base_id) && $base_id == "") || $base_company['id']=="") {$this->redirect(array('/adminbase/'));}
		
		$branch   = Yii::app()->db->createCommand("select branch_name,id from branch where active_flag=1 and base_id='".$base_id."' and modifiable_flag=1")->queryAll();
		$office   = Yii::app()->db->createCommand("select id, division_name, address from office")->queryAll();
		
        $params = array();
        $model = new Unit();
        //$prefectures = Prefecture::model()->findAll();

        if (Yii::app()->request->isAjaxRequest) {
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
        $parmas['branch'] = $branch;
		$parmas['office'] = $office;
		$parmas['base_company'] = $base_company;
        $parmas['attachment1_error'] = $attachment1_error;
        $parmas['attachment2_error'] = $attachment2_error;
        $parmas['attachment3_error'] = $attachment3_error;
        $this->render('/admin/base/regist', $parmas);
    }

    /**
     * Regist confirm
     */
    public function actionRegistConfirm() {
		$base_id = Yii::app()->request->getParam('base_id');
		$base_company   = Yii::app()->db->createCommand("select * from base where id = '".$base_id."'")->queryRow();
		if ((isset($base_id) && $base_id == "") || $base_company['id']=="") {$this->redirect(array('/adminbase/'));}
		
        $branch   = Yii::app()->db->createCommand("select branch_name,id from branch where active_flag=1 and base_id='".$base_id."' and modifiable_flag=1")->queryAll();
		$office   = Yii::app()->db->createCommand("select id, division_name, address, zipcode from office")->queryAll();
        $model = new Unit();
        if (Yii::app()->request->isPostRequest) {
            Yii::app()->session['baseregist'] = 'true';  
            CActiveForm::validate($model);
            if (!isset($_POST['regist']) || $_POST['regist'] != '1') {
                Upload_file_common_new::processAttachments($model, 'unit', 1);
            }
            
            /**
             *
             */
            if ($model->validate()||$model->photo_checkbox_for_deleting=='1') {            
                if (isset($_POST['regist']) && $_POST['regist'] == '1') {
                    $model->attachment1 = $_POST['Unit']['attachment1'];
                    $model->attachment2 = $_POST['Unit']['attachment2'];
                    $model->attachment3 = $_POST['Unit']['attachment3'];
		    $model->cancel_random=$_POST['cancel_random'];			
                    if ($model->save() == true) {
                        unset(Yii::app()->session['baseregist']);
                        $cookie_collection =Yii::app()->request->cookies;           
                        $key_array=$cookie_collection->getKeys();                 
                        for($i=0,$n=count($key_array);$i<$n;$i++){
                            $key=$key_array[$i];
                            if(substr($key, 0,11)=='unit_regist'||substr($key, 0,16)=='file_unit_regist'){
                                unset(Yii::app()->request->cookies[$key]);                                
                            }
                        }     
                        $this->redirect(array('adminbase/unit/?base_id='.$base_id.''));
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

                if ($model->attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment1)) {
                    unlink(Yii::getPathOfAlias('webroot') . $model->attachment1);
                }
                if ($model->attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment2)) {
                    unlink(Yii::getPathOfAlias('webroot') . $model->attachment2);
                }
                if ($model->attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment3)) {
                    unlink(Yii::getPathOfAlias('webroot') . $model->attachment3);
                }

                unset(Yii::app()->session['baseregist']);
                $cookie_collection =Yii::app()->request->cookies;           
                $key_array=$cookie_collection->getKeys();                 
                for($i=0,$n=count($key_array);$i<$n;$i++){
                    $key=$key_array[$i];
                   if(substr($key, 0,11)=='unit_regist'||substr($key, 0,16)=='file_unit_regist'){
                        unset(Yii::app()->request->cookies[$key]);
                        if(substr($key, 0,4)=='file'){
                            if (Yii::app()->request->cookies[$key]!=""&&Yii::app()->request->cookies[$key]!="null"&&file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value)) {
                                unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value);
                            }                            
                        }
                    }
                }    
                $this->redirect(array('adminbase/regist'));
            }

            $parmas['model'] = $model;
			$parmas['branch'] = $branch;
			$parmas['office'] = $office;
			$parmas['base_company'] = $base_company;
            $this->render('/admin/base/registconfirm', $parmas);
        } else {
            $this->redirect(array('adminbase/index'));
        }
    }

    public function actionEdit() {
		$base_id = Yii::app()->request->getParam('base_id');
		$id = Yii::app()->request->getParam('id');
       
		$base_company   = Yii::app()->db->createCommand("select * from base where id = '".$base_id."'")->queryRow();
		$id_unit  	    = Yii::app()->db->createCommand("select * from unit where id = '".$id."'")->queryRow();
		if ((isset($base_id) && $base_id == "") || $base_company['id']=="" || $id_unit['id']=="" || (isset($id) && $id == "") ) {$this->redirect(array('/adminbase/'));}
		
		$branch   = Yii::app()->db->createCommand("select branch_name,id from branch where active_flag=1 and base_id='".$base_id."' and modifiable_flag=1")->queryAll();
		$office   = Yii::app()->db->createCommand("select id, division_name, address from office")->queryAll();
		
        $parmas = array();
        $model = $this->loadModel_unit();

        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel_unit();
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        if ($model == null || !isset($_GET['id'])) {
            $this->redirect(array('adminbase/index'));
        }
        $attachment1_error = isset(Yii::app()->session['attachment1']) ? Yii::app()->params['attachment1_error'] : '';
        $attachment2_error = isset(Yii::app()->session['attachment2']) ? Yii::app()->params['attachment2_error'] : '';
        $attachment3_error = isset(Yii::app()->session['attachment3']) ? Yii::app()->params['attachment3_error'] : '';
        unset(Yii::app()->session['attachment1']);
        unset(Yii::app()->session['attachment2']);
        unset(Yii::app()->session['attachment3']);
        if($model->unit_name==''){
            $model->unit_name=Yii::app()->db->createCommand("select branch_name from branch where id=".$model->branch_id)->queryScalar();
            if($model->unit_name==false){
                $model->unit_name='';
            }
        }
        $parmas['model'] = $model;
		$parmas['model'] = $model;
        $parmas['branch'] = $branch;
		$parmas['office'] = $office;
		$parmas['base_company'] = $base_company;
        $parmas['attachment1_error'] = $attachment1_error;
        $parmas['attachment2_error'] = $attachment2_error;
        $parmas['attachment3_error'] = $attachment3_error;
        $parmas['base_id']=$base_id;
		
        $this->render('/admin/base/edit', $parmas);
    }
    protected function beforeAction($action) {        
        if($action->id=='regist'){
            $beforeUrl=Yii::app()->request->urlReferrer;           
            if(  
                    
                    strpos($beforeUrl, 'adminbase/regist')==FALSE                     
                    &&isset(Yii::app()->session['baseregist'])
                    
                
                    )
            {
                if(Yii::app()->request->cookies->contains('unit_regist_from')&&Yii::app()->request->cookies['unit_regist_from']->value=='confirm'){                                 
                }
                else{
                    $cookie_collection =Yii::app()->request->cookies;           
                    $key_array=$cookie_collection->getKeys(); 
                    unset(Yii::app()->session['baseregist']);
                    for($i=0,$n=count($key_array);$i<$n;$i++){
                        $key=$key_array[$i];
                        if(substr($key, 0,16)=='file_unit_regist'){
                            if(file_exists(Yii::getPathOfAlias('webroot') . $_COOKIE[$key])){
                                unlink(Yii::getPathOfAlias('webroot') . $_COOKIE[$key]);                            
                            }
                        }
                        if(substr($key, 0,11)=='unit_regist'||substr($key, 0,16)=='file_unit_regist'){
                            unset(Yii::app()->request->cookies[$key]);
                        }
                    }
                }
                                    
            }
        }
        else if($action->id=='edit'){
            $beforeUrl=Yii::app()->request->urlReferrer;           
            if(            
                    
                    
                    strpos($beforeUrl, 'adminbase/edit')==FALSE                    
                    &&isset(Yii::app()->session['baseedit'])
                
                    )
            {
                if(Yii::app()->request->cookies->contains('unit_edit_from')&&Yii::app()->request->cookies['unit_edit_from']->value=='confirm'){                                 
                }
                else{
                    $cookie_collection =Yii::app()->request->cookies;           
                    $key_array=$cookie_collection->getKeys(); 
                    unset(Yii::app()->session['baseedit']);
                    for($i=0,$n=count($key_array);$i<$n;$i++){
                        $key=$key_array[$i];
                        if(substr($key, 0,14)=='file_unit_edit'){
                            if(file_exists(Yii::getPathOfAlias('webroot') . $_COOKIE[$key])){
                                unlink(Yii::getPathOfAlias('webroot') . $_COOKIE[$key]);                            
                            }
                        }
                        if(substr($key, 0,9)=='unit_edit'||substr($key, 0,14)=='file_unit_edit'){
                            unset(Yii::app()->request->cookies[$key]);
                        }
                    }
                }
                                    
            }
        }
        return parent::beforeAction($action);
        
    }

    /**
     * 
     */
    public function actionEditconfirm() {
        $base_id = Yii::app()->request->getParam('base_id');
		$id = Yii::app()->request->getParam('id');
       
		$base_company   = Yii::app()->db->createCommand("select * from base where id = '".$base_id."'")->queryRow();
		$id_unit  	    = Yii::app()->db->createCommand("select * from unit where id = '".$id."'")->queryRow();
		if ((isset($base_id) && $base_id == "") || $base_company['id']=="" || $id_unit['id']=="" || (isset($id) && $id == "") ) {$this->redirect(array('/adminbase/'));}
		
		$base_company   = Yii::app()->db->createCommand("select * from base where id = '".$base_id."'")->queryRow();
		
        $branch   = Yii::app()->db->createCommand("select branch_name,id from branch where active_flag=1 and base_id='".$base_id."' and modifiable_flag=1")->queryAll();
		$office   = Yii::app()->db->createCommand("select id, division_name, address, zipcode from office")->queryAll();
        $model = $this->loadModel_unit();
        if (Yii::app()->request->isPostRequest) {
			
            Yii::app()->session['baseedit'] = 'true';  
            CActiveForm::validate($model);
            if (!isset($_POST['edit']) || $_POST['edit'] != '1') {
                Upload_file_common_new::processAttachments($model, 'unit', 2);
            }
            if ($model->id == null || $model->id == '') {
                $this->redirect(array('adminbase/index'));
            }
			
            if ($model->validate()) {   
			     
                if (isset($_POST['edit']) && $_POST['edit'] == '1') {
					 
                    $model->attachment1 = $_POST['Unit']['attachment1'];
                    $model->attachment2 = $_POST['Unit']['attachment2'];
                    $model->attachment3 = $_POST['Unit']['attachment3'];                    
                    $model->cancel_random=$_POST['cancel_random'];
                    if ($model->save() == true) {
                        unset(Yii::app()->session['baseedit']);
                        $cookie_collection =Yii::app()->request->cookies;           
                        $key_array=$cookie_collection->getKeys();                 
                        for($i=0,$n=count($key_array);$i<$n;$i++){
                            $key=$key_array[$i];
                            if(substr($key, 0,9)=='unit_edit'||substr($key, 0,14)=='file_unit_edit'){
                                unset(Yii::app()->request->cookies[$key]);                                
                            }
                        }     
						$this->redirect(array('adminbase/unit/?base_id='.$base_id.'&id='.$model->id));
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
              
                if ($model->attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment1)) {
                    if ($model->attachment1 != Upload_file_common::getAttachmentById($model->id, 1, 'unit')) {
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment1);
                    }
                }
                if ($model->attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment2)) {
                    if ($model->attachment2 != Upload_file_common::getAttachmentById($model->id, 2, 'unit')) {
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment2);
                    }
                }
                if ($model->attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment3)) {
                    if ($model->attachment3 != Upload_file_common::getAttachmentById($model->id, 3, 'unit')) {
                        unlink(Yii::getPathOfAlias('webroot') . $model->attachment3);
                    }
                }
                
               
                    
                
                unset(Yii::app()->session['baseedit']);
                $cookie_collection =Yii::app()->request->cookies;           
                $key_array=$cookie_collection->getKeys();                 
                for($i=0,$n=count($key_array);$i<$n;$i++){
                    $key=$key_array[$i];
                    if(substr($key, 0,9)=='unit_edit'||substr($key, 0,14)=='file_unit_edit'){
                        unset(Yii::app()->request->cookies[$key]);
                        if(substr($key, 0,4)=='file'){
                            if (Yii::app()->request->cookies[$key]!=""&&Yii::app()->request->cookies[$key]!="null"&&file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value)) {
                                unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value);
                            }                            
                        }
                    }
                }    
				$this->redirect(array('adminbase/edit/?base_id='.$base_id.'&id='.$model->id));
               
            }
        }
        else{
            $this->redirect(array('adminbase/index'));
        }
		$parmas['model'] = $model;
		$parmas['branch'] = $branch;
		$parmas['office'] = $office;
		$parmas['base_company'] = $base_company;
        $this->render('/admin/base/editconfirm', array(
		'model' => $model, 
		'branch' => $branch,
		'office' => $office,
                'base_company'=>$base_company,                
		));
    }

    /**
     * 
     */
    public function actionDetail() {
		$base_id = Yii::app()->request->getParam('base_id');
		$id = Yii::app()->request->getParam('id');
       
		$base_company   = Yii::app()->db->createCommand("select * from base where id = '".$base_id."'")->queryRow();
		$id_unit  	    = Yii::app()->db->createCommand("select * from unit where id = '".$id."'")->queryRow();
		if ((isset($base_id) && $base_id == "") || $base_company['id']=="" || $id_unit['id']=="" || (isset($id) && $id == "") ) {$this->redirect(array('/adminbase/'));}
		
        $branch   = Yii::app()->db->createCommand("select branch_name,id from branch where active_flag=1 and base_id='".$base_id."'")->queryAll();
		
		$office   = Yii::app()->db->createCommand("select id, division_name, address, zipcode, photo from office")->queryAll();

        $model = $this->loadModel_unit();
        if ($_GET['id'] == "") {
            $this->redirect(array('adminbase/index'));
        }

        if ($model == null) {
            $this->redirect(array('adminbase/index'));
        } else {
            $this->render('/admin/base/detail', array(
                'model' => $model,
				'office' => $office,
                'branch' => $branch
                    )
            );
        }
    }
	/**
     * delete
     */
    public function actionDelete() {
        $id = Yii::app()->request->getParam('id');
        $model = new Post();        
        $model->deleteByPk($id);        
        $this->redirect(array('/adminpost/index'));
    }
    /**
     *  download regist
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
            $file_path = Upload_file_common::getAttachmentById($_GET['id'], $attachment_index, 'unit');
        } else {//download from registconfirm
            $file_path = $_GET['file_name'];
        }
        Yii::import('ext.helpers.EDownloadHelper');
        EDownloadHelper::download(Yii::getPathOfAlias('webroot') . $file_path);
        exit;
    }

    /**
     *  download edit
     */
    public function actionDownloadedit() {
        $model = $this->loadModel_unit();
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
                        ->from('unit')
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
     * check id base
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

    //fix back browsers
    public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('unit_regist_from') ? Yii::app()->request->cookies['unit_regist_from']->value : '';

        if ($backCookie != "" || $backCookie != NULL) {
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