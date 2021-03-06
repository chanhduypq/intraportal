<?php

class MajimeclaimController extends Controller 
{
	public $pageTitle;
    /**
     *
     */
    public function init()
	{
        parent::init();
		$this->pageTitle="お客様クレーム | ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null") {
            $this->redirect(array('newgin/'));
        }

    }

    public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('claim_regist_from') ? Yii::app()->request->cookies['claim_regist_from']->value : '';

        if ($backCookie != "" && $backCookie != NULL && $backCookie != "null") {
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
    private $_claim = null;

    /**
     * 
     */
    public function actionIndex() {
        
            /**
             * 
             */
            $page = (isset($_GET['page']) ? $_GET['page'] : 1);
            $cookie = new CHttpCookie('page', $page);
            Yii::app()->request->cookies['page'] = $cookie;
            /**
             * 
             */
            $page_size = Config::LIMIT_ROW;
            /**
             * 
             */
            $item_count = Yii::app()->db->createCommand()
                    ->select('count(*) as count')
                    ->from('claim')
                    ->where((FunctionCommon::isPostFunction("claim") && !FunctionCommon::isViewFunction("claim")) ? "contributor_id=" . Yii::app()->request->cookies['id'] : "true")
                    ->queryScalar();
            /**
             * 
             */
            $claims = Yii::app()->db->createCommand()
                    ->select(array(
                        'id',
                        'title',
                        'content',
                        'created_date',
                            )
                    )
                    ->from('claim')
                    ->where((FunctionCommon::isPostFunction("claim") && !FunctionCommon::isViewFunction("claim")) ? "contributor_id=" . Yii::app()->request->cookies['id'] : "true")
                    ->limit($page_size, ($page - 1) * $page_size)
                    ->order('created_date desc')
                    ->queryAll();
            /**
             * 
             */
            $pages = new CPagination($item_count);
            $pages->setPageSize($page_size);
            /**
             * 
             */
            $params = array('claims' => $claims,
                'item_count' => $item_count,
                'page_size' => $page_size,
                'pages' => $pages);
            /**
             * 
             */
            $this->render('/majime/claim/index', $params);
//            $row=Yii::app()->db->createCommand()
//                    ->select("*")
//                    ->from("base_news")
//                    ->order("id desc")
//                    ->queryAll();
//            foreach ($row as $ro){
//                echo $ro['id'].' '.$ro['base_id'].'<br>';
//            }
//            Yii::app()->db->createCommand("update unit set cancel_random=0 where id IN (208,167,128,196)")->execute();
            
        
    }

    /**
     * 
     */
    public function actionRegist() {
        /**
         * 
         */
        $parmas = array();
        /**
         * 
         */
        $model = $this->loadModel();
        /**
         * 
         */
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
        $parmas['attachment1_error'] = $attachment1_error;
        $parmas['attachment2_error'] = $attachment2_error;
        $parmas['attachment3_error'] = $attachment3_error;

        $this->render('/majime/claim/regist', $parmas);
    }

    public function actionDeleteattechments() {
        if (Yii::app()->request->isAjaxRequest) {
            $no = Yii::app()->request->getParam('no');
            if ($no == '1') {
                $attachment1 = Yii::app()->request->getParam('attachment1');
                $attachment2 = Yii::app()->request->getParam('attachment2');
                $attachment3 = Yii::app()->request->getParam('attachment3');
                if ($attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment1)) {
                    unlink(Yii::getPathOfAlias('webroot') . $attachment1);
                }
                if ($attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment2)) {
                    unlink(Yii::getPathOfAlias('webroot') . $attachment2);
                }
                if ($attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment3)) {
                    unlink(Yii::getPathOfAlias('webroot') . $attachment3);
                }
            }
        }
    }
    /**
     * 
     */
    public function actionRegistconfirm() {
        /**
         * 
         */
        $model = $this->loadModel();
        /**
         * 
         */
        if (Yii::app()->request->isPostRequest) {
            CActiveForm::validate($model);            
            if (!isset($_POST['regist']) || $_POST['regist'] != '1') {                
                Upload_file_common_new::processAttachments($model,'claim',1);
            } 
             
            /**
             *
             */
            if ($model->validate()) {
                /**
                 *
                 */
                if (isset($_POST['regist']) && $_POST['regist'] == '1') {
                    $model->attachment1 = $_POST['Claim']['attachment1'];
                    $model->attachment2 = $_POST['Claim']['attachment2'];
                    $model->attachment3 = $_POST['Claim']['attachment3'];
                    if ($model->save() == true) {                        
									 if(FunctionCommon::isViewFunction("claim")==false){
										 $this->redirect(array('majime/'));
									}
									else{
										$this->redirect(array('majimeclaim/index'));
									}	
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
                /**
                 * 
                 */
                if ($model->attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment1)) {
                    unlink(Yii::getPathOfAlias('webroot') . $model->attachment1);
                }
                if ($model->attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment2)) {
                    unlink(Yii::getPathOfAlias('webroot') . $model->attachment2);
                }
                if ($model->attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment3)) {
                    unlink(Yii::getPathOfAlias('webroot') . $model->attachment3);
                }
                $cookie_collection =Yii::app()->request->cookies;           
                $key_array=$cookie_collection->getKeys(); 

                for($i=0,$n=count($key_array);$i<$n;$i++){
                    $key=$key_array[$i];
                    if(substr($key, 0,4)=='file'){
                        if (Yii::app()->request->cookies[$key]!=""&&Yii::app()->request->cookies[$key]!="null"&&file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value)) {
                            unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value);
                        }
                        unset(Yii::app()->request->cookies[$key]);
                    }
                }
                $this->redirect(array('majimeclaim/regist'));
            }
        } else {
            $this->redirect(array('majimeclaim/index'));
        }
        
        $this->render('/majime/claim/registconfirm', array('model' => $model));
        
    }

    /**
     * 
     */
    public function actionDetail() {

        $model = $this->loadModel();
        if ($model == NULL) {
            $this->redirect(array('majimeclaim/index'));
        }

        $this->render('/majime/claim/detail', array(
            'model' => $model,
                )
        );
    }

    /**
     * 
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
            $file_path=  Upload_file_common::getAttachmentById($_GET['id'], $attachment_index, 'claim');
        }
        else{//download from registconfirm
            $file_path = $_GET['file_name'];
        }
        Yii::import('ext.helpers.EDownloadHelper');
        EDownloadHelper::download(Yii::getPathOfAlias('webroot') . $file_path);
        
        
        
        exit;
    }

    /**
     *      
     */
    public function loadModel() {
        if ($this->_claim === null) {
            if (isset($_GET['id'])) {
                $this->_claim = Claim::model()->findbyPk(intval($_GET['id']));
            } else {
                $this->_claim = new Claim();
            }
        }
        return $this->_claim;
    }
    

}