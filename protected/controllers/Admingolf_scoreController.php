<?php

class Admingolf_scoreController extends Controller {

	public $pageTitle;
    private $_golf_score = null;

    public function init() {
        parent::init();
		$this->pageTitle="ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null") {
            $this->redirect(array('newgin/'));
        }
    }

    
    /**
     * display list golf_score
     */
    public function actionIndex() {

        //set cookie
        $page = isset($_GET['page']) ? $_GET['page'] : '';
        $cookie = new CHttpCookie('page', $page);
        Yii::app()->request->cookies['page'] = $cookie;

        $criteria = new CDbCriteria();
        $criteria->select = 'DISTINCT(contributor_id), Min(score) as score';
        $criteria->condition = FunctionCommon::isAdmin() == FALSE ? "contributor_id=" . Yii::app()->request->cookies['id'] : "true";
		$criteria->group ='contributor_id';
		$criteria->order ='score';		
		
        $item_count = Golf_score::model()->count($criteria);
        $pages = new CPagination($item_count);
        $pages->pageSize = Yii::app()->params['listPerPage'];
        $pages->applyLimit($criteria);
		
		$criteria2 = new CDbCriteria();
        $criteria2->select = '*';
        $criteria2->condition = FunctionCommon::isAdmin() == FALSE ? "contributor_id=" . Yii::app()->request->cookies['id'] : "true";
		$criteria2->order ='score';		
		$golf_scores2 = Golf_score::model()->findAll($criteria2);
		
        $golf_scores = Golf_score::model()->findAll($criteria);
        $this->render('/admin/golf_score/index', array(
            'golf_scores' => $golf_scores,
			'golf_scores2' => $golf_scores2,
            'pages' => $pages));
    }

    /**
     * edit record id
     */
    public function actionEdit() {
        $parmas = array();
        $model  = $this->loadModel();
				
        if ($model == null || !isset($_GET['id'])) {
            $this->redirect(array('admingolf_score/index'));
        }
		$score_date = explode("/", FunctionCommon::formatDate($model->score_date));
		$model->deadline_day   = $score_date[2];
		$model->deadline_month = $score_date[1];
		$model->deadline_year  = $score_date[0];
        if (Yii::app()->request->isAjaxRequest) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
		$parmas['model']=$model;    
        $this->render('/admin/golf_score/edit', $parmas);
    }

    /**
     * edit confir,
     */
    public function actionEditconfirm() {

        $model = $this->loadModel();
		 if ($model== null) {
                $this->redirect(array('admingolf_score/index'));
         }
        if (Yii::app()->request->isPostRequest) {
            CActiveForm::validate($model);
           
            if ($model->id == null || $model->id == '') {
                $this->redirect(array('admingolf_score/index'));
            }
            if ($model->validate()) {
                if (isset($_POST['edit']) && $_POST['edit'] == '1') {
					
					$model->score_date = $model->deadline_year . '-' . $model->deadline_month . '-' . $model->deadline_day.' '.date('H:i:s');                    
					$now = date('Y-m-d H:i:s');
					$model->last_updated_date = $now; 
                   
                    if ($model->save() == true) {
                        if (Yii::app()->request->cookies['page'] != "") {
                            $page = "index?page=" . Yii::app()->request->cookies['page'];
                        } else {
                            $page = "";
                        }
                        $this->redirect(array('admingolf_score/' . $page . ''));
                    }
                }
            }
                
        }else {
            $this->redirect(array('admingolf_score/index'));
      	  }

        $this->render('/admin/golf_score/editconfirm', array('model' => $model));
    }
    /**
     * load model
     */
    public function loadModel() {
        if ($this->_golf_score === null) {
            if (isset($_GET['id'])) {
                $this->_golf_score = Golf_score::model()->findbyPk(intval($_GET['id']));
            } else if (isset($_POST['Golf_score'])) {
                $data = $_POST['Golf_score'];
                $id = $data['id'];
                $this->_golf_score = Golf_score::model()->findbyPk(intval($id));
            } else {
                $this->_golf_score = new Golf_score();
            }
        }
        return $this->_golf_score;
    }

    /**
     * Delete Record id
     */
    public function actionDelete() {

        $id = Yii::app()->request->getParam('id');

        $model = new Golf_score();

        $model = $model->findByPk($id);
        if ($model == NULL) {
            return;
        }

        $transaction = $model->dbConnection->beginTransaction();
        $affected_golf_score = $model->deleteByPk($id);
        $affected_update_information = Yii::app()->db->createCommand()->delete(
                "update_information", "table_name=:table_name and article_id=:article_id", array(
            "article_id" => $id,
            "table_name" => 'golf_score',
                ))
        ;
        if ($id) {
            $transaction->commit();
        } else {
            $transaction->rollback();
        }

        $this->redirect(array('/admingolf_score/index'));
    }

    /**
     * check id golf_score
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

    public function filters() {
        $backCookie = Yii::app()->request->cookies->contains('golf_score_edit_from') ? Yii::app()->request->cookies['golf_score_edit_from']->value : '';

        if ($backCookie != "" && $backCookie != NULL && $backCookie != "null") {
            return array(
                array('application.extensions.PerformanceFilter - edit'),
            );
        } else {
            return array(
                'accessControl',
            );
        }
    }
    public function actionDeleteall()
    {
        Yii::app()->db->createCommand()->delete("golf_score");
        $this->redirect(array('/admingolf_score/index'));           
    }
}