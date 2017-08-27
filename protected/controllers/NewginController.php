<?php

class NewginController extends Controller
{

	
	 public $pageTitle;
	/**$this->redirect('/majime/index');
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->pageTitle="ログイン｜ニューギンスクエア";
		$model=new LoginForm;

		if (Yii::app()->request->isAjaxRequest) 
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			if($model->validate() && $model->login()){
				$id_user = Yii::app()->db->createCommand("select * from user where employee_number='".$_POST['LoginForm']['employee_number']."'")->queryRow();		                                
				$cookie = new CHttpCookie('id', $id_user['id']);
				$passwd = new CHttpCookie('passwd', $id_user['passwd']);
                                $passwd->secure=true;
                                //$cookie->secure=true;
				//$cookie->expire =time() + Config::TIME_OUT;
				//$passwd->expire =time() + Config::TIME_OUT;
				Yii::app()->request->cookies['id'] = $cookie;
				Yii::app()->request->cookies['passwd'] = $passwd;
				if($id_user['passwd'] != 7581 )
				{
					$this->redirect('/');
				}
				else
				{
					$this->redirect('adminprofile/detail/?id='.$id_user['id']);
				}
			}
		}
		
		
		$this->render('login',array('model'=>$model));

	}
	public function actionPw()
	{
		$this->pageTitle="ログイン｜ニューギンスクエア";
		$model		= new Pw;
		if (Yii::app()->request->isAjaxRequest) {
				echo CActiveForm::validate($model);
				Yii::app()->end();
			} 
			if (Yii::app()->request->isPostRequest) { 
				CActiveForm::validate($model);
				if ($model->validate()) {}
			}
	     
		$this->render('pw',array('model'=>$model));
		
	}
	public function actionPw_complete()
	{		
		$this->pageTitle="ログイン｜ニューギンスクエア";
		if(isset($_POST['Pw']['employee_number'])){
			$pass = Yii::app()->db->createCommand("select * from user where employee_number=".$_POST['Pw']['employee_number'])->queryRow();
			
			$body =
"".$pass['lastname']." ".$pass['firstname']."様

パスワードの再送信のご依頼に基づき
登録メールアドレス宛にパスワードを再送付致しました。

　パスワード： ".$pass['passwd']."

セキュリティ保持の為、ログイン後は必ずパスワードの変更
をお願いします。
";
			mb_language('Japanese');
			mb_internal_encoding('UTF-8');
			Yii::import('ext.yii-mail.YiiMailMessage');
			$message = new YiiMailMessage;
			$message->setBody(mb_convert_encoding($body, 'iso-2022-jp'));
			$message->subject = mb_convert_encoding(Yii::app()->params['subjectPw'], 'iso-2022-jp');
			$message->addTo($_POST['Pw']['mailaddr']);
			$message->from = Yii::app()->params['adminReminderEmailTo'];
			$message->CharSet = 'iso-2022-jp';
			if(Yii::app()->mail->send($message)==true){
				$this->redirect(array('/newgin/pw_complete'));
			}
		}
		$this->render('pw_complete');
	}

	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	public function actionLogout()
	{            
            $cookie_collection =Yii::app()->request->cookies;           
            $key_array=$cookie_collection->getKeys();           
            for($i=0,$n=count($key_array);$i<$n;$i++){
                $key=$key_array[$i];
                if(substr($key, 0,4)=='file'){
                    if (Yii::app()->request->cookies[$key]!=""&&Yii::app()->request->cookies[$key]!="null"&&file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value)) {
                        unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$key]->value);
                    }
                }
            }
           
            Yii::app()->request->cookies->clear();
            Yii::app()->user->logout();
            unset(Yii::app()->session['lastname']);
            unset(Yii::app()->session['firstname']);
            $this->redirect(Yii::app()->homeUrl);
	}
}