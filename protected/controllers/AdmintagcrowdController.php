<?php
/*
 * Create Date: 31/07/2013
 * Update Date: 03/07/2013
 * Author: Hungtc
 * User change: Hungtc
 * Description: Admin action index object from model Rival  
 * */

class AdmintagcrowdController extends Controller {

    private $_tagcrowd = null;
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
        if ($this->_tagcrowd === null) {
            if (isset($_GET['id'])) {
                $this->_tagcrowd = Tagcrowd::model()->findbyPk(intval($_GET['id']));                
            } else if (isset($_POST['Tagcrowd'])) {
                $data = $_POST['Tagcrowd'];
                $id = $data['id'];
                $this->_tagcrowd = Tagcrowd::model()->findbyPk(intval($id));
                if($this->_tagcrowd==NULL){
                    $this->_tagcrowd=new Tagcrowd();
                }
            } else {
                $this->_tagcrowd = new Tagcrowd();
            }
        }
        return $this->_tagcrowd;
    }

    public function actionIndex() {
        $item_count = Yii::app()->db->createCommand()
                ->select('count(*) as tagcrowd')
                ->from('tagcrowd')               
                ->queryScalar();
        $page_size = Config::LIMIT_ROW;
        $page = (isset($_GET['page']) ? $_GET['page'] : 1);
        $tagcrowds = Yii::app()->db->createCommand()
                ->select(array(
                    '*'
                        )
                )
                ->from('tagcrowd')    
                
                ->limit($page_size, ($page - 1) * $page_size)
                ->order('display_order ASC')
                ->queryAll();
        
        
        $pages = new CPagination($item_count);
        $pages->setPageSize($page_size);
        $model=  $this->loadModel();
        $params = array('tagcrowds' => $tagcrowds,
            'model'=>$model,
            'item_count' => $item_count,
            'page_size' => $page_size,
            'pages' => $pages
                );
        /**
         * 
         */
        $this->render('/admin/tagcrowd/index', $params);
        
    }
    public function actionRegistedit(){
        
        if (Yii::app()->request->isAjaxRequest) {
            $model= new Tagcrowd();
            echo CActiveForm::validate($model); 
            
            Yii::app()->end();
        }
        if (Yii::app()->request->isPostRequest) {            
            $model= $this->loadModel();
            CActiveForm::validate($model); 
            
            if ($model->validate()) { 
                

                
                $model->save();
            }
            $this->redirect(array('/admintagcrowd/index'));
        }        
        
    }

   
    

    /**
     * 
     */
    public function actionDelete() {
        $id = Yii::app()->request->getParam('id');
        $model = new Tagcrowd();        
        $model->deleteByPk($id);        
        $this->redirect(array('/admintagcrowd/index'));
    }

   

    //fix back browsers
    public function filters() {
        return array(
                'accessControl',
            );
    }

}