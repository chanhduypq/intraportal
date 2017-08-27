<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Pw extends CFormModel
{
	public $employee_number;
	public $mailaddr;
	
	public function rules()
	{
		return array(
			//array('employee_number', 'required','message'=>Lang::MSG_0032),
			//array('mailaddr', 'required','message'=>Lang::MSG_0018),
			//array('mailaddr', 'email','message'=>Lang::MSG_0019),
			array('employee_number', 'length','max'=>20),
			array('employee_number', 'checkPw_user'),
			array('mailaddr', 'checkPw_user'),
			
		);
	}
	public function checkPw_user($attribute,$params)
	{
		if(!$this->hasErrors())
		{
		   if(trim($this->employee_number)=="" && trim($this->mailaddr)==""){	
		   		$this->addError('employee_number',Lang::MSG_0097);
		   }
		   else
		   {
				if(trim($this->employee_number)=="" || trim($this->mailaddr)=="")
				{
					$this->addError('employee_number',Lang::MSG_0097);
				}
				else
				{
					if(trim($this->mailaddr)!="" && trim($this->employee_number)!="")
					{
						$mailaddr= User::model()->findByAttributes(array('mailaddr'=>$this->mailaddr,'employee_number'=>$this->employee_number));
						if($mailaddr==null) {
							
							$this->addError('employee_number',Lang::MSG_0094);
						}
					}
					/*if(preg_match("/(.*)\W(.*)/",$this->employee_number))
						{
							$this->addError('employee_number',Lang::MSG_0049);
							}
					else */
					
					//}
				}
				/*if(trim($this->mailaddr)=="")
					{
						$this->addError('mailaddr',Lang::MSG_0018);
					}*/
				/*else if (!filter_var($this->mailaddr,FILTER_VALIDATE_EMAIL))
					{
							$this->addError('mailaddr',Lang::MSG_0019);
					}	*/
		   }
		}
	}
}