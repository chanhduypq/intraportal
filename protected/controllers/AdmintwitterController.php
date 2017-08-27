<?php

class AdmintwitterController extends Controller {    

	 public $pageTitle;
     public function init()
	 {
        parent::init();
		$this->pageTitle="ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id']=="null" ) {
          $this->redirect(array('newgin/'));
        }
     }
    /**
     * 
     */
    public function actionEdit() {    

        /**
         * 
         */
        $parmas=array();
        /**
         * 
         */
        $model = new Twitter_blogc();
        $success='';
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
            if ($model->validate()) {  
                
                
                
                $keyword_array=  explode("\n",$model->keyword); 
                $model->saveTwitter($keyword_array);
                
                
                                
               
                
                $success=  Lang::MSG_0093;
                
                
            }
            
            
            
            
            
        }
        $items=Yii::app()->db->createCommand()->select("keyword")->from("blogc_twitter")->where("type=2")->queryAll();
        $keywords=array();
        if(count($items)>0){
            foreach ($items as $item){
                $keywords[]=$item['keyword'];
            }
        }
        $parmas['keywords']=$keywords;
        $model->keyword='';
        $parmas['model']=$model;    
        $parmas['success']=$success;
        $this->render('/admin/twitter/edit', $parmas);
    }
    
   
}