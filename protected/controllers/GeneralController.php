<?php 
class GeneralController  extends Controller 
{
	public function actionError()
	{
		$error = Yii::app()->errorHandler->error;                
		if ($error)
		{
                    $errot_type=$error['type'];
                    if($errot_type instanceof CHttpException){               
                        $this->render('error', array('error'=>$error));
                    }
                    else{
                        $this->render('error', array('error'=>array('code'=>'404')));
                    }
			
		}
		else
		{
//			throw new CHttpException($error, 'Page not found.');
                    $this->render('error', array('error'=>array('code'=>'401')));
		}
	}
	
}	
?>