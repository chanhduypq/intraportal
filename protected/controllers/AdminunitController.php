<?php

/*
 * Create Date: 31/07/2013
 * Update Date: 03/07/2013
 * Author: Hungtc
 * User change: Hungtc
 * Description: Admin action index object from model Rival  
 * */

class AdminunitController extends Controller {

   
	public $pageTitle;
    //check if logined or not
    public function init() {
        parent::init();
	$this->pageTitle="ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null") {
            $this->redirect(array('newgin/'));
        }
    }


    protected function beforeAction($action) {        
        if($action->id=='index'){
            $beforeUrl=Yii::app()->request->urlReferrer;           
            if(                    
                    $beforeUrl!=Yii::app()->getBaseUrl(true) .'/adminunit'
                    &&$beforeUrl!=Yii::app()->getBaseUrl(true) .'/adminunit/'
                    &&$beforeUrl!=Yii::app()->getBaseUrl(true) .'/adminunit/index'
                    &&$beforeUrl!=Yii::app()->getBaseUrl(true) .'/adminunit/index/'                    
                    &&$beforeUrl!=Yii::app()->getBaseUrl(true) .'/adminunit/indexconfirm'
                    &&$beforeUrl!=Yii::app()->getBaseUrl(true) .'/adminunit/indexconfirm/'
                    &&isset(Yii::app()->session['unitedit'])
                
                    )
            {
                if(Yii::app()->request->cookies->contains('unitedit_from')&&Yii::app()->request->cookies['unitedit_from']->value=='confirm'){                                 
                }
                else{
                    $cookie_collection =Yii::app()->request->cookies;           
                    $key_array=$cookie_collection->getKeys(); 
                    unset(Yii::app()->session['unitedit']);
                    for($i=0,$n=count($key_array);$i<$n;$i++){
                        $key=$key_array[$i];
                        if(substr($key, 0,8)=='unitedit'){
                            unset(Yii::app()->request->cookies[$key]);
                        }
                    }
                }
                                    
            }
        }
        return parent::beforeAction($action);
        
    }
    
    
    public function actionIndex() {

        $model=new Unitedit();
        if (Yii::app()->request->isAjaxRequest) 
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        } 
        $division1 = Yii::app()->db->createCommand("select * from unit where id IN (select division1 from user where id=".Yii::app()->request->cookies['id']->value." AND div_intro_modifiable_flag1=1) and modifiable_flag=1")->queryRow();
        $division2 = Yii::app()->db->createCommand("select * from unit where id IN (select division2 from user where id=".Yii::app()->request->cookies['id']->value." AND div_intro_modifiable_flag2=1) and modifiable_flag=1")->queryRow();
        $division3 = Yii::app()->db->createCommand("select * from unit where id IN (select division3 from user where id=".Yii::app()->request->cookies['id']->value." AND div_intro_modifiable_flag3=1) and modifiable_flag=1")->queryRow();
        $division4 = Yii::app()->db->createCommand("select * from unit where id IN (select division4 from user where id=".Yii::app()->request->cookies['id']->value." AND div_intro_modifiable_flag4=1) and modifiable_flag=1")->queryRow();

        $division=array(
            $division1,
            $division2,
            $division3,
            $division4
        );     
        
        
        
        $params = array(
            'division' => $division,            
                );
        
        /**
         * 
         */
        $this->render('/admin/unit/index', $params);        
        
        
        
    }
    
    

    public function actionIndexconfirm(){
        
		
        if (Yii::app()->request->isPostRequest){
            Yii::app()->session['unitedit'] = 'true';        
            
            $model=new Unitedit();
            
            CActiveForm::validate($model);  
            $model->validate();
            if(isset($_POST['edit'])&&$_POST['edit']=='1'){  
                $model->setIsNewRecord(FALSE);
                $model->save();
                unset(Yii::app()->session['unitedit']);
                $cookie_collection =Yii::app()->request->cookies;           
                $key_array=$cookie_collection->getKeys();                 
                for($i=0,$n=count($key_array);$i<$n;$i++){
                    $key=$key_array[$i];
                    if(substr($key, 0,8)=='unitedit'){
                        unset(Yii::app()->request->cookies[$key]);
                    }
                }
                $this->redirect(array('adminunit/index'));                
            }
            $this->render('/admin/unit/indexconfirm', array('model'=>$model));
        }
        else{
            $this->redirect(array('adminunit/index'));
        }
        
    }
    

   

   

    //fix back browsers
    public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('unitedit_from') ? Yii::app()->request->cookies['unitedit_from']->value : '';

        if ($backCookie != "" && $backCookie != NULL && $backCookie != "null") {
            return array(
                array('application.extensions.PerformanceFilter - index'),
            );
        } else {
            return array(
                'accessControl',
            );
        }
    }

}