<?php
class MajimememberController extends Controller
{

	public $pageTitle;
	public function init() {
        parent::init();
		$this->pageTitle="ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id']=="null" ) {
         	$this->redirect(array('newgin/'));
        }
        
    }
	
	public function actionIndex()
	{
		$base = Yii::app()->db->createCommand()
                ->select(array(
                    'company_name',
                    'id'
                        )
                )
                ->from('base') 
				->where('modifiable_flag=1')     
				->order('display_order ASC')
                ->queryAll();
		$this->render('/majime/member/index',array(
						'base'=>$base
						));
	}
	
	
	public function actionDetail($id_branch,$id_unit) 
	{
		$base  = Yii::app()->db->createCommand("select company_name from base where id ='".$id_branch."'")->queryRow();
		
		$branch  = Yii::app()->db->createCommand("select branch_name from branch where active_flag=1 and id ='".$id_branch."'")->queryRow();

		$unit_item   = Yii::app()->db->createCommand("select * from unit where active_flag=1 and id = '".$id_unit."'  order by created_date DESC")->queryRow();	
		
		$this->render('/majime/member/detail',array('branch'=>$branch,'unit_item'=>$unit_item,'base'=>$base));
		
    }
	
}
		
		