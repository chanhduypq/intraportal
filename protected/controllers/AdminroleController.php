<?php

class AdminroleController extends Controller
{
	public $pageTitle;
	public function init() 
	{
        parent::init();
		$this->pageTitle="役割管理｜ニューギンスクエア";

        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id']=="null" ) {
          $this->redirect(array('newgin/'));
        }
        
    } 
    public function actionIndex()
	{
	    $criteria = new CDbCriteria();
		$criteria->select = '*';
		$criteria->order ='created_date DESC';
		$item_count = Role::model()->count($criteria); 
		$pages = new CPagination($item_count);         
		$pages->pageSize = Yii::app()->params['listPerPage'];
		$pages->applyLimit($criteria);
        $roles = Role::model()->findAll($criteria);
        $this->render('/admin/role/index',array('roles'=>$roles,'pages' => $pages));
	}
    public function actionRegist()
    {
       $role_model= new Role;
       $role_management_model=new Role_management;
       $functions=Functions::model()->findAll(array('order'=>'disp_order ASC'));
       if (Yii::app()->request->isAjaxRequest) {
            echo CActiveForm::validate($role_model);
            Yii::app()->end();
       }
       $this->render('/admin/role/regist',array('functions'=>$functions,'role_model'=>$role_model));   
    }
    public function actionRegist_confirm()
    {
        if(isset($_POST['Role']) && isset($_POST['Role_management']) )
        {
            $roles=$_POST['Role'];
            $management_roles=$_POST['Role_management'];
            $role_management=array();
            $i=0;
            foreach($management_roles as $val){
                $i++;
                    $function_name=Functions::model()->findByPk($val['function_id']);
                    $role_management[$i]['function_id']=$val['function_id'];
                    $role_management[$i]['function_name']=$function_name->function_name;
                    $role_management[$i]['view']="0";
                    $role_management[$i]['post']="0";
                    $role_management[$i]['admin']="0";
                    if(isset($val['chkview'])&& $val['chkview']=='on' )
                    {
                        $role_management[$i]['view']="1";
                    }
                    if(isset($val['chkpost'])&& $val['chkpost']=='on' )
                    {
                        $role_management[$i]['post']="1";
                    }
                    if(isset($val['chkadmin'])&& $val['chkadmin']=='on' )
                    {
                        $role_management[$i]['admin']="1";
                    }
            }
            $this->render('/admin/role/regist_confirm',array('roles'=>$roles,'role_management'=>$role_management));
     
        }
        if(isset($_POST['role_name']) && isset($_POST['data']))
        {
            $role_model=new Role;
            $role_model->setAttribute('role_name',$_POST['role_name']);
            $role_model->setAttribute('created_date',FunctionCommon::getDateTimeSys());
            $role_model->setAttribute('last_updated_date',FunctionCommon::getDateTimeSys());
            $role_model->setAttribute('last_updated_person',FunctionCommon::getEmplNum());
            $trans = Yii::app()->db->beginTransaction();
            if($role_model->save()){
                $role=$role_model->findByAttributes(array('role_name'=>$_POST['role_name']));
                $role_id=$role->id;
                if(!empty($_POST['data']))
                {
                    $role_management= new Role_management;
                    foreach($_POST['data'] as $key=>$val){
                        
                        if($val['view']==1){
                            $role_management= new Role_management;
                   
                            $role_management->setAttribute('role_id',$role_id);
                            $role_management->setAttribute('function_id',$val['function_id']);
                            $role_management->setAttribute('baserole_id',Constants::$baserole['view']);
                            $role_management->setAttribute('created_date',FunctionCommon::getDateTimeSys());
                            $role_management->setAttribute('last_updated_date',FunctionCommon::getDateTimeSys());
                            $role_management->setAttribute('last_updated_person',FunctionCommon::getEmplNum());
                            if(!$role_management->save()){
                                //$transaction->rollback();
                             }
            
                        }
                        if($val['post']==1){
                            $role_management= new Role_management;
                            $role_management->setAttribute('role_id',$role_id);
                            $role_management->setAttribute('function_id',$val['function_id']);
                            $role_management->setAttribute('baserole_id',Constants::$baserole['post']);
                            $role_management->setAttribute('created_date',FunctionCommon::getDateTimeSys());
                            $role_management->setAttribute('last_updated_date',FunctionCommon::getDateTimeSys());
                            $role_management->setAttribute('last_updated_person',FunctionCommon::getEmplNum());
                            if(!$role_management->save()){
                                //$transaction->rollback();
                             }
            
                        }
                        if($val['admin']==1){
                            $role_management= new Role_management;
                            $role_management->setAttribute('role_id',$role_id);
                            $role_management->setAttribute('function_id',$val['function_id']);
                            $role_management->setAttribute('baserole_id',Constants::$baserole['admin']);
                            $role_management->setAttribute('created_date',FunctionCommon::getDateTimeSys());
                            $role_management->setAttribute('last_updated_date',FunctionCommon::getDateTimeSys());
                            $role_management->setAttribute('last_updated_person',FunctionCommon::getEmplNum());
                            if(!$role_management->save()){
                                //$transaction->rollback();
                             }
                           
            
                        }
                        
                        
                    }
                    $this->redirect('index');
                }
                
            }
            else{
                //$transaction->rollback();
            }
        }
     }
     public function actionEdit($id)
     {
        $role_model =Role::model()->findByPk($id);
        $role_magement=Role_management::model()->findAll("role_id=$id");
        $functions=Functions::model()->findAll(array('order'=>'disp_order ASC'));
        if (Yii::app()->request->isAjaxRequest) {
            echo CActiveForm::validate($role_model);
            Yii::app()->end();
        }
        $this->render("/admin/role/edit",array('role_model'=>$role_model,"role_management"=>$role_magement,'functions'=>$functions));
     }
     public function actionEdit_confirm()
     {
        if(isset($_POST['Role']) && isset($_POST['Role_management']) )
        {
            $roles=$_POST['Role'];
            $management_roles=$_POST['Role_management'];
            $role_management=array();
            $i=0;
            foreach($management_roles as $val){
                $i++;
                $function_name=Functions::model()->findByPk($val['function_id']);
                $role_management[$i]['function_id']=$val['function_id'];
                $role_management[$i]['function_name']=$function_name->function_name;
                $role_management[$i]['view']="0";
                $role_management[$i]['post']="0";
                $role_management[$i]['admin']="0";
                if((isset($val['chkview']) || isset($val['chkpost']) || isset($val['chkadmin'])))
                {
                    
                    if(isset($val['chkview'])&& $val['chkview']=='on' )
                    {
                        $role_management[$i]['view']="1";
                    }
                    if(isset($val['chkpost'])&& $val['chkpost']=='on' )
                    {
                        $role_management[$i]['post']="1";
                    }
                    if(isset($val['chkadmin'])&& $val['chkadmin']=='on' )
                    {
                        $role_management[$i]['admin']="1";
                    }
                    
                }
               
                
            }

           $this->render('/admin/role/edit_confirm',array('roles'=>$roles,'role_management'=>$role_management));
     
        }
        if(isset($_POST['role']) && isset($_POST['data']))
        {
            $role=$_POST['role'];
            $role_model=new Role;
            $role_name=$role['role_name'];
            $last_updated_date=FunctionCommon::getDateTimeSys();
            $last_update_person=FunctionCommon::getEmplNum();
            if($role_model->updateByPk($role['id'],array("role_name"=>$role_name,"last_updated_date"=>$last_updated_date,'last_updated_person'=>$last_update_person))){
                $role_id=$role['id'];
                $transaction = Yii::app()->db->beginTransaction();
                if(!empty($_POST['data']))
                {
                    $role_management= new Role_management;
                    foreach($_POST['data'] as $key=>$val){
                        //Kiem tra xem truong do co trong co du lieu hay chua
                        $count_view=Role_management::model()->count("function_id=".$val['function_id']." AND baserole_id=".Constants::$baserole['view']." AND role_id=".$role['id']);
                        $count_post=Role_management::model()->count("function_id=".$val['function_id']." AND baserole_id=".Constants::$baserole['post']." AND role_id=".$role['id']);
                        $count_admin=Role_management::model()->count("function_id=".$val['function_id']." AND baserole_id=".Constants::$baserole['admin']." AND role_id=".$role['id']);
                        
                        if($count_view!=0 && $val['view']==0){
                          
                           $role_management->deleteAll("function_id=".$val['function_id']." AND baserole_id=".Constants::$baserole['view']." AND role_id=".$role['id']);
                        }
                        else if($count_view==0 && $val['view']==1)
                        {
                            $role_management= new Role_management;
                            $role_management->setAttribute('role_id',$role_id);
                            $role_management->setAttribute('function_id',$val['function_id']);
                            $role_management->setAttribute('baserole_id',Constants::$baserole['view']);
                            $role_management->setAttribute('created_date',FunctionCommon::getDateTimeSys());
                            $role_management->setAttribute('last_updated_date',FunctionCommon::getDateTimeSys());
                            $role_management->setAttribute('last_updated_person',$last_update_person);
                            if(!$role_management->save()){
                                $transaction->rollback();
                            }
                        }
                        
                        if($count_post!=0 &&$val['post']==0){
                             $role_management->deleteAll("function_id=".$val['function_id']." AND baserole_id=".Constants::$baserole['post']." AND role_id=".$role['id']);
                        }
                        else if($count_post==0 && $val['post']==1){
                            $role_management= new Role_management;
                            $role_management->setAttribute('role_id',$role_id);
                            $role_management->setAttribute('function_id',$val['function_id']);
                            $role_management->setAttribute('baserole_id',Constants::$baserole['post']);
                            $role_management->setAttribute('created_date',FunctionCommon::getDateTimeSys());
                            $role_management->setAttribute('last_updated_date',FunctionCommon::getDateTimeSys());
                            $role_management->setAttribute('last_updated_person',$last_update_person);
                            if(!$role_management->save()){
                                $transaction->rollback();
                             }
            
                        }
                        if($count_admin!=0 && $val['admin']==0){
                                 $role_management->deleteAll("function_id=".$val['function_id']." AND baserole_id=".Constants::$baserole['admin']." AND role_id=".$role['id']);
                        }
                        else if($count_admin==0 && $val['admin']==1){
                            $role_management= new Role_management;
                            $role_management->setAttribute('role_id',$role_id);
                            $role_management->setAttribute('function_id',$val['function_id']);
                            $role_management->setAttribute('baserole_id',Constants::$baserole['admin']);
                            $role_management->setAttribute('created_date',FunctionCommon::getDateTimeSys());
                            $role_management->setAttribute('last_updated_date',FunctionCommon::getDateTimeSys());
                            $role_management->setAttribute('last_updated_person',$last_update_person);
                            if(!$role_management->save()){
                                $transaction->rollback();
                             }
                           
            
                        }
                        
                        
                    }
                    $this->redirect('index');
                }
                
            }
            else{
                $transaction->rollback();
            }
        }
     }
     public function actionDetail($id)
     {
        $roles=Role::model()->findAll("id=$id");
        $functions=Functions::model()->findAll(array('order'=>'disp_order ASC'));
        $criteria = new CDbCriteria();
		$criteria->select = '*';
        $criteria->condition="role_id=$id";
		$criteria->order ='disp_order ASC';
        $role_magements=Role_management::model()->with('functions')->findAll($criteria);
        $role_relative=array();
        $function_name="";
        $i=0;
        if(!empty($role_magements)){
            foreach($role_magements as $key =>$val){
                if($function_name != $val->functions->function_name ){
                    $i=$val->functions->id;
                    $role_relative[$i]['function_name']=$val->functions->function_name;
                    $role_relative[$i]['view']=0;
                    $role_relative[$i]['post']=0;
                    $role_relative[$i]['admin']=0;
                }
                
                if($val->baserole_id==Constants::$baserole['view']){
                    $role_relative[$i]['view']=1;
                }
                if($val->baserole_id==Constants::$baserole['post']){
                    $role_relative[$i]['post']=1;
                }
                if($val->baserole_id==Constants::$baserole['admin']){
                    $role_relative[$i]['admin']=1;
                }
                $function_name = $val->functions->function_name;
            }
        $this->render("/admin/role/detail",array('roles'=>$roles,'role_relative'=>$role_relative,'functions'=>$functions));
        }
        else{
            $this->redirect("index");
        }
        
     }
     public function actionDelete($id)
     {
        $role=Role::model()->deleteByPk($id);
        $role_management=Role_management::model()->deleteAll("role_id=$id");
        if($role && $role_management)
        {
            $this->redirect('/adminrole/index');
        }
     }
          
   
}