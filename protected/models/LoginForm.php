<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $employee_number;
	public $passwd;
	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			//array('employee_number', 'required','message'=>Lang::MSG_0032),
			//array('passwd', 'required','message'=>Lang::MSG_0044),
			array('employee_number', 'length','max'=>20),
			array('passwd', 'length','max'=>20),
			array('employee_number', 'authenticate'),
			array('passwd', 'authenticate'),
			
			
		);
	}
	
	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{	
			if(trim($this->employee_number)=="" && trim($this->passwd)==""){
				$this->addError('employee_number',Lang::MSG_0096);
			}
			else{
					if(trim($this->employee_number)=="" || trim($this->passwd)==""){
						$this->addError('employee_number',Lang::MSG_0096);
						}
					else
					{	
						if(trim($this->employee_number)!="" && trim($this->passwd)!=""){
							$employee_number= User::model()->findByAttributes(array('employee_number'=>$this->employee_number));
							$this->_identity=new UserIdentity($this->employee_number,$this->passwd);
							
							if($employee_number==null || !$this->_identity->authenticate()) {
								$this->addError('employee_number',Lang::MSG_0095);
						}
					}
					/*if(trim($this->passwd)==""){
						$this->addError('passwd',Lang::MSG_0044);
						}*/
					/*else{	
						if(preg_match("/(.*)\W(.*)/",$this->passwd))
						{
							$this->addError('passwd',Lang::MSG_0049);
							}
						else{
							if(strlen($this->passwd)<4){
								$this->addError('passwd',Lang::MSG_0049);
								}
							else
							{	
							$this->_identity=new UserIdentity($this->employee_number,$this->passwd);
							if(!$this->_identity->authenticate())
								$this->addError('passwd',Lang::MSG_0049);
							}
						}*/
					}
			}
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->employee_number,$this->passwd);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			Yii::app()->user->login($this->_identity);
			return true;
		}
		else
			return false;
	}
}
