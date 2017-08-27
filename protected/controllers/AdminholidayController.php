<?php
/*
 * Create Date: 31/07/2013
 * Update Date: 03/07/2013
 * Author: Hungtc
 * User change: Hungtc
 * Description: Admin action index object from model Rival  
 * */

class AdminholidayController extends Controller {

    private $_post = null;
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
     *    load model   
     */
    public function loadModel() {
        if ($this->_post === null) {
            if (isset($_GET['id'])) {
                $this->_post = Holiday::model()->findbyPk(intval($_GET['id']));                
            } else if (isset($_POST['Holiday'])) {
                $data = $_POST['Holiday'];
                $id = $data['id'];
                $this->_post = Holiday::model()->findbyPk(intval($id));
                if($this->_post==NULL){
                    $this->_post=new Holiday();
                }
            } else {
                $this->_post = new Holiday();
            }
        }
        return $this->_post;
    }

    public function actionIndex() {
//        $item_count = Yii::app()->db->createCommand()
//                ->select('count(*) as post')
//                ->from('post')               
//                ->queryScalar();
      
        $holidays = Yii::app()->db->createCommand()
                ->select(array(
                    'title',
                    'id',
                    'achive_date',
                    'status'
                        )
                )
                ->from('holiday')  
                
                //->limit($page_size, ($page - 1) * $page_size)
                //->order('display_order ASC')
                ->queryAll();
       
//        $pages = new CPagination($item_count);
//        $pages->setPageSize($page_size);
        $model=  $this->loadModel();
        $params = array('holidays' => $holidays,
            'model'=>$model,
//            'item_count' => $item_count,
//            'page_size' => $page_size,
//            'pages' => $pages
                );
        /**
         * 
         */
        $this->render('/admin/holiday/index', $params);
        
    }
    public function actionRegistedit(){
        
        if (Yii::app()->request->isAjaxRequest) {
            $model= new Holiday();
            echo CActiveForm::validate($model); 
            
            Yii::app()->end();
        }
        if (Yii::app()->request->isPostRequest) {            
            $model= $this->loadModel();
            CActiveForm::validate($model); 
            
            if ($model->validate()) { 
                

                
                $model->save();
            }
            $this->redirect(array('/adminholiday/index'));
        }        
        
    }

    
    

    /**
     * 
     */
    public function actionDelete() {
        $id = Yii::app()->request->getParam('id');
        $model = new Holiday();        
        $model->deleteByPk($id);        
        $this->redirect(array('/adminholiday/index'));
    }

   

    //fix back browsers
    public function filters() {
        return array(
                'accessControl',
            );
    }

}