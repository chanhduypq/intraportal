<?php
 /*
 * Create Date: 17/07/2013
 * Update Date: 24/07/2013
 * Author: Hungtc
 * User change: Hungtc
 * Description: Majime Inquiry Send mail
 * */


class MajimeinquiryController extends Controller
{
	public $pageTitle;
	private $_inquiry = null;
	public function init() {
        parent::init();
		$this->pageTitle="管理者へのお問い合わせ | ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id']=="null" ) {
         	$this->redirect(array('newgin/'));
        }
        
    }
	
	public function loadModel()
	{
        if ($this->_inquiry === null) 
		{
            if (isset($_GET['id'])) 
			{
                $this->_inquiry = NewItem::model()->findbyPk(intval($_GET['id']));
            } 
			else 
			{
                $this->_inquiry = new NewItem();
            }
        }
        return $this->_inquiry;
    }
    
    public function actionIndex() {
        $this->redirect(array('majime/index'));
    }

     public function actionAdd() { 
        
         $this->render('/majime/inquiry/add');
        
     }
     
      public function actionAddConfirm() {
      if(!isset($_POST['inquiry_name'])){
        $this->redirect(array('majimeinquiry/add'));
      }
        //session_start();
        $_SESSION['inquiry_name']=$_POST['inquiry_name'];  
        $_SESSION['inquiry_content']=$_POST['inquiry_content'];     
      if (Yii::app()->request->isPostRequest)
		{            
             if(isset($_POST['regist'])&&$_POST['regist']=='1')
				{    
                    //var_dump($_POST['inquiry_name']);exit;
                    mb_language('Japanese');
                    mb_internal_encoding('UTF-8');
                    Yii::import('ext.yii-mail.YiiMailMessage');
                    $message = new YiiMailMessage;
                    $user=Yii::app()->db->createCommand()
                            ->select('*')
                            ->from('user')
                            ->where('id='.Yii::app()->request->cookies['id'])
                            ->queryRow()
                            ;
                    
                    if(is_array($user)&&count($user)>0){
                        $mailaddr='メールアドレス: '.$user['mailaddr'];
                        $company_name='';
                        if($this->getCompanyName($user['division1'])!=''){
                            $company_name=$this->getCompanyName($user['division1']);
                        }
                        else if($this->getCompanyName($user['division2'])!=''){
                            $company_name=$this->getCompanyName($user['division2']);
                        }
                        else if($this->getCompanyName($user['division3'])!=''){
                            $company_name=$this->getCompanyName($user['division3']);
                        }
                        else if($this->getCompanyName($user['division4'])!=''){
                            $company_name=$this->getCompanyName($user['division4']);
                        }
                        if($company_name!=''){
                            $branch_name='所属拠点名: '.$company_name;
                        }
                        else{
                            $branch_name='';
                        }
                        
                        $br_name='';
                        if($this->getBranchName($user['division1'])!=''){
                            $br_name=$this->getBranchName($user['division1']);
                        }
                        else if($this->getBranchName($user['division2'])!=''){
                            $br_name=$this->getBranchName($user['division2']);
                        }
                        else if($this->getBranchName($user['division3'])!=''){
                            $br_name=$this->getBranchName($user['division3']);
                        }
                        else if($this->getBranchName($user['division4'])!=''){
                            $br_name=$this->getBranchName($user['division4']);
                        }
                        if($br_name!=''){
                            $department='所属部署名: '.$br_name;
                        }
                        else{
                            $department='';
                        }
                        
                        $unit_name='';
                        $position='';
                        if($this->getUnitName($user['division1'])!=''){
                            $unit_name=$this->getUnitName($user['division1']);
                            $position=  $this->getPosition($user['position1']);
                        }
                        else if($this->getUnitName($user['division2'])!=''){
                            $unit_name=$this->getUnitName($user['division2']);
                            $position=  $this->getPosition($user['position2']);
                        }
                        else if($this->getUnitName($user['division3'])!=''){
                            $unit_name=$this->getUnitName($user['division3']);
                            $position=  $this->getPosition($user['position3']);
                        }
                        else if($this->getUnitName($user['division4'])!=''){
                            $unit_name=$this->getUnitName($user['division4']);
                            $position=  $this->getPosition($user['position4']);
                        }
                        if($unit_name!=''){
                            $section='所属課: '.$unit_name;
                        }
                        else{
                            $section='';
                        }
                        if($position!=''){
                            $position='役職: '.$position;
                        }
                        else{
                            $position='';
                        }
                                               
                        
                        
                        
                        $name='氏名: '.$user['lastname'].' '.$user['firstname'];
                        $user_info=  $this->getUserInfo($user['id']);
                        
                        $company_name=$user_info['company_name'];
                        $branch_name=$user_info['branch_name'];
                        $unit_name=$user_info['unit_name'];
                    }
                    $content=$_POST['inquiry_content'];
                    
$body="$mailaddr 
$company_name $branch_name $unit_name 
$name 

問い合わせ内容：
$content";
                    $message->setBody(mb_convert_encoding($this->trimText($body), 'iso-2022-jp'));
                    $message->subject = mb_convert_encoding($this->trimText($_POST['inquiry_name']), 'iso-2022-jp');
					$mailsTo = Yii::app()->params['adminInquiryEmailTo'];
					/*Change by VuNDH*/
                    if(!empty($mailsTo)) {
                    	foreach ($mailsTo as $mail) {
                    		$message->addTo($mail);
                    	}
                    }
                    $message->from = Yii::app()->params['adminEmail'];
                    $message->CharSet = 'iso-2022-jp';
                    if(Yii::app()->mail->send($message)==true){
                        $this->redirect(array('majimeinquiry/addcomplete'));
                    }
                }
        }
        $this->render('/majime/inquiry/addconfirm');
         
      }
      private function getUserInfo($user_id){
          for($i=1;$i<=4;$i++){
              $user_info=  $this->getUserInfoByDivisionIndex($user_id,$i);
              if(is_array($user_info)&&  count($user_info)>0){
                  return $user_info;
              }
          }          
          return array('company_name'=>'','branch_name'=>'','unit_name'=>'');
      }
      private function getUserInfoByDivisionIndex($user_id,$division_index){
          $query="
SELECT
	`unit`.`unit_name` AS `unit_name`,
	`branch`.`branch_name` AS `branch_name`,
	`base`.`company_name` AS `company_name`
FROM
	(
		(
			(
				(
					`user`
					
				)
				LEFT JOIN `unit` ON(
					(
						(
							`unit`.`id` = `user`.`division$division_index`
						)
						
					)
				)
			)
			LEFT JOIN `branch` ON(
				(
					`branch`.`id` = `unit`.`branch_id`
				)
			)
		)
		LEFT JOIN `base` ON(
			(
				`base`.`id` = `branch`.`base_id`
			)
		)
	)
WHERE
	(
		(`unit`.`id` IS NOT NULL)
		AND(`base`.`id` IS NOT NULL)
		AND(`branch`.`id` IS NOT NULL)
	)
AND `user`.id =$user_id";
          return Yii::app()->db->createCommand($query)->queryRow();
          
      }
      public function actionAddComplete() { 
        
         $this->render('/majime/inquiry/addcomplete');
        
     }
     
     public function trimText($str)
	{
		$str=preg_replace('/^\p{Z}+|\p{Z}+$/u','',$str);
		return $str;
	}   
	
        private function getCompanyName($division){
            if($division==NULL||!is_numeric($division)){
                return '';
            }
            $division=(int)$division;
            $company_name=Yii::app()->db->createCommand()
                    ->select('company_name')
                    ->from('base')
                    ->join('branch', 'branch.base_id=base.id')
                    ->join('unit','unit.branch_id=branch.id')
                    ->where("unit.id=$division")
                    ->queryScalar();
            if($company_name==FALSE){
                return '';
            }
                    
        }
        private function getBranchName($division){
            if($division==NULL||!is_numeric($division)){
                return '';
            }
            $division=(int)$division;
            $company_name=Yii::app()->db->createCommand()
                    ->select('branch_name')                    
                    ->from('branch')
                    ->join('unit','unit.branch_id=branch.id')
                    ->where("unit.id=$division")
                    ->queryScalar();
            if($company_name==FALSE){
                return '';
            }
                    
        }
        private function getUnitName($division){
            if($division==NULL||!is_numeric($division)){
                return '';
            }
            $division=(int)$division;
            $company_name=Yii::app()->db->createCommand()
                    ->select('unit_name')                    
                    ->from('unit')
                    ->where("unit.id=$division")
                    ->queryScalar();
            if($company_name==FALSE){
                return '';
            }
                    
        }
        private function getPosition($division){
            if($division==NULL||!is_numeric($division)){
                return '';
            }
            $division=(int)$division;
            $company_name=Yii::app()->db->createCommand()
                    ->select('post_name')                    
                    ->from('post')
                    ->where("post.id=$division")
                    ->queryScalar();
            if($company_name==FALSE){
                return '';
            }
                    
        }
	
	
}
	