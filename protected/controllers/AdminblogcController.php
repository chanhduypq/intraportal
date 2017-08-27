<?php

class AdminblogcController extends Controller {   

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
                $employee_number = FunctionCommon::getEmplNum();
                $keyword_array=  explode("\n",$model->keyword); 
                $model->saveBlogc($keyword_array);
                $success=  Lang::MSG_0093;
            }
        }
        $items=Yii::app()->db->createCommand()->select("keyword")->from("blogc_twitter")->where("type=1")->queryAll();
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
        $this->render('/admin/blogc/edit', $parmas);
    } 
}