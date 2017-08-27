<?php

class Majimesoumu_newsController extends Controller {    
	
	public $pageTitle;
    private $_soumu_news = null;
	/**
     * 
     */
	 public function init() 
	 {
        parent::init();
		$this->pageTitle="総務からのお知らせ | ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id']=="null" ) {
          $this->redirect(array('newgin/'));
        }
     }
	/**Create Date:23/07/2012
     * Update Date:
     * Author:
     * User change:
     * Description: display list soumu_news object
     * */
    public function actionIndex() 
	{
		$page	=isset($_GET['page']) ? $_GET['page'] : '';
        $cookie = new CHttpCookie('page', $page);
		Yii::app()->request->cookies['page'] = $cookie;	
	    
		$criteria = new CDbCriteria();
		$criteria->select = '*';
        $criteria->condition=(FunctionCommon::isPostFunction("soumu_news")&&!FunctionCommon::isViewFunction("soumu_news"))?"contributor_id=".Yii::app()->request->cookies['id']:"true";
		$criteria->order ='created_date DESC';
		
		$item_count = Soumu_news::model()->count($criteria); 
		$pages = new CPagination($item_count);         
		$pages->pageSize = Yii::app()->params['listPerPage'];
		$pages->applyLimit($criteria);	
		
		$model = Soumu_news::model()->findAll($criteria); 
		$this->render('/majime/soumu_news/index',array(
														'model'=>$model,
														'pages' => $pages,
														));
    }
	/**Create Date:23/07/2012
     * Update Date:
     * Author:
     * User change:
     * Description: display detail soumu_news object
     * */
    public function actionDetail() 
	{
        $model = $this->loadModel();
		if($model == null||!isset($_GET['id']))
		{
			 $this->redirect(array('majimesoumu_news/index'));
		}
		$this->render('/majime/soumu_news/detail', array(
															'model' => $model,
														)
					);
    }
	/**Create Date:23/07/2012
     * Update Date:
     * Author:
     * User change:
     * Description:Method using load model soumu_news
     * */
    public function loadModel() 
	{
        if ($this->_soumu_news === null) 
		{
            if (isset($_GET['id'])) 
			{
                $this->_soumu_news = Soumu_news::model()->findbyPk(intval($_GET['id']));
            } 
			else 
			{
                $this->_soumu_news = new Soumu_news();
            }
        }
        return $this->_soumu_news;
    }
	/**Create Date:23/07/2012
     * Update Date:
     * Author:
     * User change:
     * Description: download file upload
     * */
    public function actionDownload() 
	{
		$model=$this->loadModel();         
    	if(isset($_POST['file_index']))
		{ //download file from file_bytes  		
    		CActiveForm::validate($model);
    		$model->validate();
    		$attachment_id = $_POST['file_index'];
    		if($attachment_id=='1')
			{
    			$file_name=$model->attachment1_file_name;
    			$file_type=$model->attachment1_file_type;
                $content=base64_decode($model->attachment1_file_bytes);
    		}
    		else if($attachment_id=='2')
			{
    			$file_name=$model->attachment2_file_name;
    			$file_type=$model->attachment2_file_type;
    			$content=base64_decode($model->attachment2_file_bytes);
    		}
    		else if($attachment_id=='3')
			{
    			$file_name=$model->attachment3_file_name;
    			$file_type=$model->attachment3_file_type;
    			$content=base64_decode($model->attachment3_file_bytes);
    		}                
    		
    		header('Content-Type: '.$file_type);
    		header('Content-Disposition: attachment;filename="'.$file_name.'"');
    		header('Cache-Control: max-age=0');    		
    		echo $content;    		
    	}
    	else
		{//download file from host
    		$attachment_id=0;
    		if(isset($_GET['1']))
			{
    			$attachment_id=1;
    		}
    		else if(isset($_GET['2']))
			{
    			$attachment_id=2;
    		}
    		else if(isset($_GET['3']))
			{
    			$attachment_id=3;
    		}
    		if($attachment_id!=0)
			{
    			$file_name=Yii::app()->db->createCommand()
    			->select('attachment'.$attachment_id)
    			->from('soumu_news')
    			->where('id=:id',array('id'=>$_GET['id']))
    			->queryScalar();                        
    			
    			if($file_name!=""&&file_exists(Yii::getPathOfAlias('webroot').$file_name))
				{                            
                    Yii::import('ext.helpers.EDownloadHelper');    	                             
                    EDownloadHelper::download(Yii::getPathOfAlias('webroot').$file_name);
    			}
    			
    		}
    		
    	}
    
    	exit;        
    }

}