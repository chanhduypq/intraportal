<?php
 /*
 * Create Date: 17/07/2013
 * Update Date: 24/07/2013
 * Author: Hungtc
 * User change: Hungtc
 * Description: Majime action index object from model Soumu_qa  
 * */


class Majimesoumu_qaController extends Controller {
    
	public $pageTitle;
    private $_soumu_qa = null;
	
     public function init() 
	 {
        parent::init();
		$this->pageTitle="教えて総務さん！FAQ | ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id']=="null" ) {
          $this->redirect(array('newgin/'));
        }
        
    }
	
    public function loadModel() 
	{
        if ($this->_soumu_qa === null) 
		{
            if (isset($_GET['id'])) 
			{
                $this->_soumu_qa = Soumu_qa::model()->findbyPk(intval($_GET['id']));
            }
            else if(isset($_POST['Soumu_qa']))
			{
                $data=$_POST['Soumu_qa'];
                $id=$data['id'];
                $this->_soumu_qa = Soumu_qa::model()->findbyPk(intval($id));
            }
            else 
			{
                $this->_soumu_qa = new Soumu_qa();
            }
        }
        return $this->_soumu_qa;
    }
      /**
     * Index 
     */
    public function actionIndex()
	{
        
         $category = Yii::app()->db->createCommand()
                ->select(array(
                        '*',                    
                        )
                )
                ->from('View_CategoryAndSoumu_qa')    
                ->where('type=:type',array('type'=>2))
                ->order('created_date desc')
                ->queryAll();
                
		$criteria = new CDbCriteria();
		$criteria->select = '*';
		$criteria->order ='created_date DESC';
		
		$item_count = Soumu_qa::model()->count($criteria); 
		$pages = new CPagination($item_count);         
		$pages->pageSize = Yii::app()->params['listPerPage'];
		$pages->applyLimit($criteria);	
		$soumu_qa = Soumu_qa::model()->findAll($criteria);
		$this->render('/majime/soumu_qa/index',array('category'=>$category,'soumu_qa'=>$soumu_qa,'pages' => $pages));
    }
    
	public function actionListIndex($id)
	{
        $category = Category::model()->findAll();
        
        $category_name = Yii::app()->db->createCommand()
                ->select(array(
                        'category_name',                    
                        )
                )
                ->from('category')    
                ->where('type=:type',array('type'=>2))
                ->andWhere('id=:id',array('id'=>$id))
                ->queryAll();
        
		$criteria = new CDbCriteria();
		$criteria->select = '*';
        $criteria->compare('category_id', $id, true);
		$criteria->order ='created_date DESC';
		
		$item_count = Soumu_qa::model()->count($criteria); 
		$pages = new CPagination($item_count);         
		$pages->pageSize = Yii::app()->params['listPerPage'];
		$pages->applyLimit($criteria);	
		$soumu_qa = Soumu_qa::model()->findAll($criteria);
		$this->render('/majime/soumu_qa/listindex',array('category'=>$category,'soumu_qa'=>$soumu_qa,'pages' => $pages,'category_name'=>$category_name));
    }
    
    public function actionDownload()
         {
    	$model=$this->loadModel();
    	if(isset($_POST['file_index'])){ //download file from file_bytes  		
    		CActiveForm::validate($model);
    		/**
    		 *
    		 */
    		$model->validate();
    		/**
    		 *
    		 */
    		$attachment_id = $_POST['file_index'];
    		/**
    		 *
    		 */
    		if($attachment_id=='1'){
    			$file_name=$model->attachment1_file_name;
    			$file_type=$model->attachment1_file_type;
                        $content=base64_decode($model->attachment1_file_bytes);
    		}
    		else if($attachment_id=='2'){
    			$file_name=$model->attachment2_file_name;
    			$file_type=$model->attachment2_file_type;
    			$content=base64_decode($model->attachment2_file_bytes);
    		}
    		else if($attachment_id=='3'){
    			$file_name=$model->attachment3_file_name;
    			$file_type=$model->attachment3_file_type;
    			$content=base64_decode($model->attachment3_file_bytes);
    		}                
    		/**
    		 *
    		 */
    		header('Content-Type: '.$file_type);
    		header('Content-Disposition: attachment;filename="'.$file_name.'"');
    		header('Cache-Control: max-age=0');    		
    		echo $content;    		
    	}
    	else{//download file from host
    		$attachment_id=0;
    		if(isset($_GET['1'])){
    			$attachment_id=1;
    		}
    		else if(isset($_GET['2'])){
    			$attachment_id=2;
    		}
    		else if(isset($_GET['3'])){
    			$attachment_id=3;
    		}
    		if($attachment_id!=0){
    			$file_name=Yii::app()->db->createCommand()
    			->select('attachment'.$attachment_id)
    			->from('soumu_qa')
    			->where('id=:id',array('id'=>$_GET['id']))
    			->queryScalar();                        
    			/**
    			 *
    			 */
    			if($file_name!=""&&file_exists(Yii::getPathOfAlias('webroot').$file_name)){                            
                            /**
                             * 
                             */
                            Yii::import('ext.helpers.EDownloadHelper');    	                             
                            EDownloadHelper::download(Yii::getPathOfAlias('webroot').$file_name);
    			}
    			
    		}
		
    	}
    	
    	
    	
    	exit;        
    }
    
    
    public function actionDetail($id) 
	{
		$model = $this->loadModel();
        
        $contributor_id = Yii::app()->db->createCommand("select * from criticism where id=".$_GET['id']." and contributor_id=".Yii::app()->request->cookies['id'])->queryRow();
		
        
        if(empty($model->title) || ($model->id != $_GET['id'])){
            $this->redirect(array('majimesoumu_qa/index'));
        }
        $category = Category::model()->findAll();
		$this->render('/majime/soumu_qa/detail',array('model'=>$model,'category'=>$category));
    } 
       
    	/**
     * base64_encode file upload
     */
    private function processAttachments($model){   
    	
        if ($file 	   = CUploadedFile::getInstance($model, 'attachment1')) {        
            $file_name = $file->name;                    
            
            $model->attachment1_file_name=$file->name;            
            $model->attachment1_file_bytes=  base64_encode(file_get_contents($file->tempName));
            $model->attachment1_file_type=$file->type;
           
        }
        if ($file 	   = CUploadedFile::getInstance($model, 'attachment2')) {
        	$file_name = $file->name;        	
        	
        	$model->attachment2_file_name  = $file->name;        	
        	$model->attachment2_file_bytes = base64_encode(file_get_contents($file->tempName));
        	$model->attachment2_file_type  = $file->type;

        }
        if ($file 	   = CUploadedFile::getInstance($model, 'attachment3')) {
        	$file_name = $file->name;        	
        	
        	$model->attachment3_file_name  = $file->name;        	
        	$model->attachment3_file_bytes = base64_encode(file_get_contents($file->tempName));
        	$model->attachment3_file_type  = $file->type;
        }        
    }  
    
}