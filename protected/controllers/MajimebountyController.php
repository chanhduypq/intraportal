<?php

class MajimebountyController extends Controller
{
	public $pageTitle;
	public function init() 
	{
        parent::init();
		$this->pageTitle="懸賞金付き募集コンテンツ | ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id']=="null" ) 
		{
         	$this->redirect(array('newgin/'));
        }
    }
	
	public function filters()
	{
		$backCookie=Yii::app()->request->cookies->contains('bounty_regist_form') ? Yii::app()->request->cookies['bounty_regist_form']->value : '';
		 if( $backCookie !="" && $backCookie != NULL && $backCookie !="null" )
		 {
            return array(array('application.extensions.PerformanceFilter - regist'),);
        }
		else
		{
            return array
			(
                'accessControl',
            );
        }
	}
	
	private $_bounty = null;
	public function loadModel()
	{
        if ($this->_bounty === null) 
		{
            if (isset($_GET['id'])) 
			{
                $this->_bounty = Bounty::model()->findbyPk(intval($_GET['id']));
            } 
			else 
			{
                $this->_bounty = new Bounty();
            }
        }
        return $this->_bounty;
    } 
	
	

	/** Create Date:20130825
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:Method using down load file
     * */
	public function actionDownload()
    {
		
		$attachment_index = 0;
        if (isset($_GET['1'])) 
		{
            $attachment_index = 1;
        } 
		else if (isset($_GET['2']))
		{
            $attachment_index = 2;
        } 
		else if (isset($_GET['3']))
		{
            $attachment_index = 3;
        }
		else if (isset($_GET['5']))
		{
            $attachment_index = 5;
        }
        if ($attachment_index != 0) 
		{	
            //download from detail        
			if( $attachment_index ==5)
			{
				$file_path=  Upload_file_common::getAttachmentById($_GET['id'], 1, 'bounty_apply');
			}
			else
			{
				$file_path=  Upload_file_common::getAttachmentById($_GET['id'], $attachment_index, 'bounty');
			}
		}
        else
		{
			//download from registconfirm
            $file_path = $_GET['file_name'];
        }
        Yii::import('ext.helpers.EDownloadHelper');
        EDownloadHelper::download(Yii::getPathOfAlias('webroot') . $file_path);

        exit;
    }
	
	
    public function actionDeleteattechments() 
	{
        if (Yii::app()->request->isAjaxRequest) 
		{
            $no = Yii::app()->request->getParam('no');
            if ($no == '1') 
			{
                $attachment1 = Yii::app()->request->getParam('attachment1');
                $attachment2 = Yii::app()->request->getParam('attachment2');
                $attachment3 = Yii::app()->request->getParam('attachment3');
                if ($attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment1)) 
				{
                    unlink(Yii::getPathOfAlias('webroot') . $attachment1);
                }
                if ($attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment2)) 
				{
                    unlink(Yii::getPathOfAlias('webroot') . $attachment2);
                }
                if ($attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment3)) 
				{
                    unlink(Yii::getPathOfAlias('webroot') . $attachment3);
                }
            }
        }
    }
	 
	private function processAttachments($bounty_apply)
	{   
		
        if ($file = CUploadedFile::getInstance($bounty_apply, 'attachment'))
		{       
            $file_name = $file->name;                    
            $bounty_apply->attachment_file_name=$file->name;            
            $bounty_apply->attachment_file_bytes=  base64_encode(file_get_contents($file->tempName));
            $bounty_apply->attachment_file_type=$file->type;
        }
        else
		{
            $model->attachment_file_name='';
        }
    }  
	 
	/** Create Date:23/07/2012
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:action using load all object bounty  
     * */  
	public function actionIndex()
	{
		//set cookie page
		$page	=isset($_GET['page']) ? $_GET['page'] : '';
		$cookie = new CHttpCookie('page', $page);
		Yii::app()->request->cookies['page'] = $cookie;	
		
		$criteria = new CDbCriteria();
		$criteria->select = '*';
        $criteria->condition=(FunctionCommon::isPostFunction("bounty")&&!FunctionCommon::isViewFunction("bounty"))?"contributor_id=".Yii::app()->request->cookies['id']:"true";
		$criteria->order ='created_date DESC';
		
		$item_count = Bounty::model()->count($criteria); 
		$pages = new CPagination($item_count);         
		$pages->pageSize = Yii::app()->params['listPerPage'];
		$pages->applyLimit($criteria);	
		
		$model = Bounty::model()->findAll($criteria);
		$this->render('/majime/bounty/index',array('model'=>$model,'pages' => $pages));
	}
	
	public function actionDetail()
	{
		$contributor_id = Yii::app()->request->cookies['id'];
        $model = $this->loadModel();
        if($contributor_id)
		{
			$employee_number=Yii::app()->db->createCommand()
			->select('employee_number')
			->from('user')
			->where('id=:id',array('id'=>$contributor_id))
			->queryScalar();
        }
        
		if(count($model)>0)
		{
			$bounty_apply	= new Bounty_apply();
			
			$criteria = new CDbCriteria();
			$criteria->select = '*';
			$criteria->addCondition('bounty_id ='.$_GET['id']);
            $criteria->addCondition('applicant_id ='.$employee_number);
			$criteria->order ='created_date DESC';
			$bounty_applies	= Bounty_apply::model()->findAll($criteria);
			
			if (Yii::app()->request->isAjaxRequest) 
			{
				echo CActiveForm::validate($bounty_apply);
				Yii::app()->end();
				
			} 
			if (Yii::app()->request->isPostRequest) 
			{ 
			   
				CActiveForm::validate($bounty_apply);
				if ($bounty_apply->validate()) 
				{ 
					$this->processAttachments($bounty_apply);  
					$textarea=$_POST['Bounty_apply']['applied_content'];
					$bounty_apply->applied_content =$textarea;

					if($model->saveBounty_apply())
					{
						$this->refresh();
					}
				}
			}
			$this->render('/majime/bounty/detail', array(
												'model' => $model,
												'bounty_apply'=>$bounty_apply,
												'bounty_applies'=>$bounty_applies));
		}
		else
		{
			$this->redirect(array('majimebounty/index'));
		}										
		
    }
	
	/** Create Date:20130904
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:action using load all object DetailAdo  
     * */  
	public function actionDetailAdo()
	{
		$this->pageTitle="懸賞金付き募集コンテンツ - 結果発表 | ニューギンスクエア";
		$contributor_id = Yii::app()->request->cookies['id'];
        $model = $this->loadModel();
        if($contributor_id)
		{
			$employee_number=Yii::app()->db->createCommand()
			->select('employee_number')
			->from('user')
			->where('id=:id',array('id'=>$contributor_id))
			->queryScalar();
        }
		if(count($model)>0)
		{
			$criteria = new CDbCriteria();
			$criteria->select = '*';
			$criteria->addCondition('bounty_id ='.$_GET['id']);
            $criteria->addCondition('adopted_comment IS NOT NULL');
			$criteria->addCondition('open_type IS NOT NULL');
			$criteria->order ='created_date DESC';
			$bounty_applies	= Bounty_apply::model()->findAll($criteria);
			$this->render('/majime/bounty/detail_ado', array('model' => $model,'bounty_applies'=>$bounty_applies));
			
		}
		else
		{
			$this->redirect(array('majimebounty/index'));
		}		
    }
    
  
    /** Create Date:25/07/2012
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:action using register object bounty
     * */
	public function actionRegist() 
	{
		$this->pageTitle="懸賞金付き募集コンテンツ - 投稿 | ニューギンスクエア";	
		$parmas = array(); 
        $model  = $this->loadModel(); 
		$model->deadline_year= date("Y");
		$model->deadline_month=date('n');
		$model->deadline_day=date('j');
	
		if (Yii::app()->request->isAjaxRequest) 
		{
            echo CActiveForm::validate($model);
            Yii::app()->end();
        } 

		$attachment1_error = isset(Yii::app()->session['attachment1']) ? Yii::app()->params['attachment1_error'] : '';
        $attachment2_error = isset(Yii::app()->session['attachment2']) ? Yii::app()->params['attachment2_error'] : '';
        $attachment3_error = isset(Yii::app()->session['attachment3']) ? Yii::app()->params['attachment3_error'] : '';
		unset(Yii::app()->session['attachment1']);
        unset(Yii::app()->session['attachment2']);
        unset(Yii::app()->session['attachment3']);
        $parmas['attachment1_error'] = $attachment1_error;
        $parmas['attachment2_error'] = $attachment2_error;
        $parmas['attachment3_error'] = $attachment3_error;
      
        $parmas['model']=$model;       
        $this->render('/majime/bounty/regist', $parmas);
    }
	
	
	
	/** Create Date:25/07/2012
     * Update Date:
     * Author:hungtc
     * User change:
     * Description:action using show info regist object bounty 
     * */  
	public function actionRegistConfirm() 
	{
		$this->pageTitle="懸賞金付き募集コンテンツ - 確認 | ニューギンスクエア";	
		$model = $this->loadModel();
        if (Yii::app()->request->isPostRequest)
		{
            CActiveForm::validate($model);  
		
            if (!isset($_POST['regist']) || $_POST['regist'] != '1') 
			{                
               Upload_file_common_new::processAttachments($model,'bounty',1);
               
            }           
            if ($model->validate())
			{
                if (isset($_POST['regist']) && $_POST['regist'] == '1')
				{
                    $model->attachment1 = $_POST['Bounty']['attachment1'];
                    $model->attachment2 = $_POST['Bounty']['attachment2'];
                    $model->attachment3 = $_POST['Bounty']['attachment3'];
                    if ($model->save() == true) {                        
									 if(FunctionCommon::isViewFunction("bounty")==false){
										 $this->redirect(array('majime/'));
									}
									else{
										$this->redirect(array('majimebounty/index'));
									}	
						}
                }
            }
			else 
			{
                if ($model->getError("attachment1") != "") 
				{
                    Yii::app()->session['attachment1'] = true;
                }

                if ($model->getError("attachment2") != "")
				{
                    Yii::app()->session['attachment2'] = true;
                }

                if ($model->getError("attachment3") != "") 
				{
                    Yii::app()->session['attachment3'] = true;
                }

                if ($model->attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment1)) 
				{
                    unlink(Yii::getPathOfAlias('webroot') . $model->attachment1);
                }
                if ($model->attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment2)) 
				{
                    unlink(Yii::getPathOfAlias('webroot') . $model->attachment2);
                }
                if ($model->attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $model->attachment3)) 
				{
                    unlink(Yii::getPathOfAlias('webroot') . $model->attachment3);
                }
                $cookie_collection = Yii::app()->request->cookies;
                $key_array = $cookie_collection->getKeys();
                for ($i = 0, $n = count($key_array); $i < $n; $i++) {
                    $key = $key_array[$i];
                    if (substr($key, 0, 4) == 'file') {
                        if (Yii::app()->request->cookies[$key] != "" && Yii::app()->request->cookies[$key] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value)) {
                            unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value);
                        }
                        unset(Yii::app()->request->cookies[$key]);
                    }
                }           
                $this->redirect(array('majimebounty/regist'));
            }
        } 
		else 
		{
           $this->redirect(array('majimebounty/index'));
        }
        $this->render('/majime/bounty/registconfirm', array('model' => $model));
    }
	
	public function actionDelete() 
	{
        $id=Yii::app()->request->getParam('id'); 
		$idapp=Yii::app()->request->getParam('idapp');        
		
		$model=$this->loadModel();
        $bounty_apply	= new Bounty_apply();
		$affected_row=Bounty_apply::model()->deleteAll('id =:id' , array('id' =>$idapp));
		
		$criteria = new CDbCriteria();
		$criteria->select = '*';
		$criteria->addCondition('bounty_id ='.$id);
		$criteria->order ='created_date DESC';
		$data= Bounty_apply::model()->findAll($criteria);
		$attachment=isset($data->attachment1) ? $data->attachment1 :'';
				
        if($affected_row==1)
        {

			 if(!empty($attachment)&&file_exists(Yii::getPathOfAlias('webroot') . $attachment))
			 {
				unlink(Yii::getPathOfAlias('webroot') . $attachment);
			 }
			
            //$this->render('/majime/bounty/detail', array('model' => $model,
											            // 'bounty_apply'=>$bounty_apply,
														 //'bounty_applies'=>$data));
                                              
        }
        
        $this->redirect(array('/majimebounty/detail/'.$id)); 
    }
	
	
	
	/*
     * Create Date:20130806
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:Method using check id bounty 
     * */
	public function actionCheckId()
	{
		$id=$_POST['id'];
		$row=0;
		$object = Yii::app()->db->createCommand("select * from bounty where id=".$id)->queryRow();
		if(!empty($object['id']))
		{
			$row = 1;
		}		
		echo $row;
    }
	
	
}
	