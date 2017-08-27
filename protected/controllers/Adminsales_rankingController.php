<?php

class Adminsales_rankingController extends Controller {    

	public $pageTitle;
    private $_sales_ranking = null;
	/**
     * regist sales_ranking
     */
    public function init() 
	{
        parent::init();
		$this->pageTitle="ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id']=="null" ) {
          $this->redirect(array('newgin/'));
        }
        
    } 
    public function actionIndex()
	{
        $machine=Machines::model()->findAll();
        $connection = Yii::app()->db;
        $command = $connection->createCommand();
        $command->select('s.id,s.machine_name_id,s.ranking_name,r.name,r.rank,r.unit,r.id as detail');
        $command->from(' sales_ranking s');
        $command->join('ranking_details r', 's.id=r.ranking_id');
        $command->where('s.type=1');
        $command->order('s.machine_name_id,s.id,r.id');
        $personal_ranking = $command->queryAll();
        $personal_rankings=array();
        $i=0;
        $k=0;
        $machine_name="";
        $ranking_name="";
        foreach($personal_ranking as $val){
            if($machine_name!=$val['machine_name_id']){
                $i=$val['machine_name_id'];
                $j=1;
        
                $personal_rankings[$i]['machine_name_id']=$val['machine_name_id'];
                $personal_rankings[$i]['child'][$j]['ranking_name']=$val['ranking_name'];
                $personal_rankings[$i]['child'][$j]['id']=$val['id'];
            }
            if($ranking_name !=$val['ranking_name'] && $machine_name==$val['machine_name_id']){
                $j++;
                $k=0;
                $personal_rankings[$i]['child'][$j]['ranking_name']=$val['ranking_name'];
                $personal_rankings[$i]['child'][$j]['id']=$val['id'];                
            
           }
           if($ranking_name ==$val['ranking_name'] && $machine_name==$val['machine_name_id'] ){
                $k++;
            }
            $personal_rankings[$i]['child'][$j]['list'][$k]['id']=$val['detail'];
            $personal_rankings[$i]['child'][$j]['list'][$k]['rank']=$val['rank'];
            $personal_rankings[$i]['child'][$j]['list'][$k]['name']=$val['name'];
            $personal_rankings[$i]['child'][$j]['list'][$k]['unit']=$val['unit'];
            $machine_name=$val['machine_name_id'];
            $ranking_name=$val['ranking_name'];
        }
        //get part_ranking
        $connection = Yii::app()->db;
        $command = $connection->createCommand();
        $command->select('s.id,s.contribution_date,s.ranking_name,r.name,r.rank,r.unit,r.id as detail');
        $command->from(' sales_ranking s');
        $command->join('ranking_details r', 's.id=r.ranking_id');
        $command->where('s.type=2');
        $command->order('s.id,r.id');
        $part_ranking = $command->queryAll();  
        $part_rankings=array();
        $m=0;
        $part_ranking_name="";
        foreach($part_ranking as $val){
           if($part_ranking_name != $val['ranking_name']){
               $m++;
               $n=0; 
               $part_rankings[$m]['contribution_date']=$val['contribution_date']; 
               $part_rankings[$m]['ranking_name']=$val['ranking_name'];
               $part_rankings[$m]['id']=$val['id'];
           }
           $n++;
           $part_rankings[$m]['list'][$n]['id']=$val['detail'];
           $part_rankings[$m]['list'][$n]['rank']=$val['rank']; 
           $part_rankings[$m]['list'][$n]['name']=$val['name']; 
           $part_rankings[$m]['list'][$n]['unit']=$val['unit']; 
           $part_ranking_name=$val['ranking_name'];    
            
        }
       $this->render('/admin/sales_ranking/index',array('personal_rankings'=>$personal_rankings,'part_rankings'=>$part_rankings,'machine'=>$machine));
    } 
    public function actionSaveData()
    {
        if(isset($_POST['personal_ranking']) || isset($_POST['part_ranking']))
        {

            $transaction = Yii::app()->db->beginTransaction();
            $contributor_id=Yii::app()->request->cookies['id']->value;
            $created_date=FunctionCommon::getDateTimeSys();
            $last_updated_date=FunctionCommon::getDateTimeSys();
            $last_updated_person=FunctionCommon::getEmplNum();
            if(!empty($_POST['personal_ranking']))
            {   
                 foreach($_POST['personal_ranking'] as $val){
                    $machine_name=$val['title'];
                    $id=$val['id'];
                    //var_dump($val['child']);exit;
                    if(!empty($id)){
                        $machine= new Machines;
                        $machine->updateByPk($id,array('machine_name'=>$machine_name));
                        if(isset($val['child']))
                        {
                            foreach($val['child'] as $v){
                                $sales_ranking=new Sales_ranking;
                                $type=1;
                                $ranking_name=$v['title_ranking'];
                                //update value

                                if(!empty($v['id'])){

                                    $arrUpdateParent=array(
                                        'ranking_name'=>$ranking_name,
                                        'last_updated_date'=>$last_updated_date,
                                        'last_updated_person'=>$last_updated_person);
                                    if($sales_ranking->updateByPk($v['id'],$arrUpdateParent)){
                                        foreach($v['list'] as $v1)
                                        {
                                            if(!empty($v1['list_rank_1']) && !empty($v1['title_rank_1']) && !empty($v1['units_rank_1'])){
                                                $ranking_detail=new Ranking_details;
                                                $raking_rank=$v1['list_rank_1'];
                                                $raking_name=$v1['title_rank_1'];
                                                $raking_unit=$v1['units_rank_1'];
                                                if(!empty($v1['id'])){
                                                    $arrayUpdate=array('rank'=>$raking_rank,
                                                        'name'=>$raking_name,
                                                        'unit'=>$raking_unit,
                                                        'last_updated_date'=>$last_updated_date,
                                                        'last_updated_person'=>$last_updated_person);
                                                    $ranking_detail->updateByPk($v1['id'],$arrayUpdate);
                                                }
                                                else{
                                                    $ranking_id=$v['id'];
                                                    $ranking_detail->setAttribute('ranking_id',$ranking_id);
                                                    $ranking_detail->setAttribute('rank',$raking_rank);
                                                    $ranking_detail->setAttribute('name',$raking_name);
                                                    $ranking_detail->setAttribute('unit',$raking_unit);
                                                    $ranking_detail->setAttribute('created_date',$created_date);
                                                    $ranking_detail->setAttribute('last_updated_date',$last_updated_date);
                                                    $ranking_detail->setAttribute('last_updated_person',$last_updated_person);
                                                    $ranking_detail->save();

                                                }

                                            }
                                            if(empty($v1['list_rank_1']) && empty($v1['title_rank_1']) && empty($v1['units_rank_1']) && !empty($v1['id'])){
                                                $id=(int)$v1['id'];
                                                $ranking_detail=new Ranking_details;
                                                $ranking_detail->deleteAll("id=$id");

                                            }
                                        }
                                    }

                                }
                                else{
                                    //save table machines
                                    $type=1;
                                    $sales_ranking->setAttribute('type',$type);
                                    $sales_ranking->setAttribute('machine_name_id',$id);
                                    $sales_ranking->setAttribute('ranking_name',$ranking_name);
                                    $sales_ranking->setAttribute('contribution_date',"");
                                    $sales_ranking->setAttribute('contributor_id',$contributor_id);
                                    $sales_ranking->setAttribute('created_date',$created_date);
                                    $sales_ranking->setAttribute('last_updated_date',$last_updated_date);
                                    $sales_ranking->setAttribute('last_updated_person',$last_updated_person);
                                    if($sales_ranking->save()){
                                        $ranking_id=$sales_ranking->id;
                                        foreach($v['list'] as $v1)
                                        {
                                            if(!empty($v1['list_rank_1']) && !empty($v1['title_rank_1']) && !empty($v1['units_rank_1'])){
                                                $ranking_detail=new Ranking_details;
                                                $raking_rank=$v1['list_rank_1'];
                                                $raking_name=$v1['title_rank_1'];
                                                $raking_unit=$v1['units_rank_1'];
                                                $ranking_detail->setAttribute('ranking_id',$ranking_id);
                                                $ranking_detail->setAttribute('rank',$raking_rank);
                                                $ranking_detail->setAttribute('name',$raking_name);
                                                $ranking_detail->setAttribute('unit',$raking_unit);
                                                $ranking_detail->setAttribute('created_date',$created_date);
                                                $ranking_detail->setAttribute('last_updated_date',$last_updated_date);
                                                $ranking_detail->setAttribute('last_updated_person',$last_updated_person);
                                                $ranking_detail->save();
                                            }
                                        }
                                    }

                                }

                            }
                        }

                    }
                    else{
                        $machine= new Machines;
                        $machine->setAttribute('machine_name',$machine_name);
                        if($machine->save())
                        {
                            $machine_name_id=$machine->id;
                            if(isset($val['child']))
                            {
                                foreach($val['child'] as $v){
                                    $type=1;
                                    $ranking_name=$v['title_ranking'];
                                    $sales_ranking = new Sales_ranking;

                                    $type=1;
                                    $sales_ranking->setAttribute('type',$type);
                                    $sales_ranking->setAttribute('machine_name_id',$machine_name_id);
                                    $sales_ranking->setAttribute('ranking_name',$ranking_name);
                                    $sales_ranking->setAttribute('contribution_date',"");
                                    $sales_ranking->setAttribute('contributor_id',$contributor_id);
                                    $sales_ranking->setAttribute('created_date',$created_date);
                                    $sales_ranking->setAttribute('last_updated_date',$last_updated_date);
                                    $sales_ranking->setAttribute('last_updated_person',$last_updated_person);
                                    if($sales_ranking->save()){
                                        $ranking_id=$sales_ranking->id;
                                        foreach($v['list'] as $v1)
                                        {
                                            if(!empty($v1['list_rank_1']) && !empty($v1['title_rank_1']) && !empty($v1['units_rank_1'])){
                                                $ranking_detail=new Ranking_details;
                                                $raking_rank=$v1['list_rank_1'];
                                                $raking_name=$v1['title_rank_1'];
                                                $raking_unit=$v1['units_rank_1'];
                                                $ranking_detail->setAttribute('ranking_id',$ranking_id);
                                                $ranking_detail->setAttribute('rank',$raking_rank);
                                                $ranking_detail->setAttribute('name',$raking_name);
                                                $ranking_detail->setAttribute('unit',$raking_unit);
                                                $ranking_detail->setAttribute('created_date',$created_date);
                                                $ranking_detail->setAttribute('last_updated_date',$last_updated_date);
                                                $ranking_detail->setAttribute('last_updated_person',$last_updated_person);
                                                $ranking_detail->save();
                                            }
                                        }
                                    }
                                }

                            }
                        }
                    }
                 }
            }
            if(!empty($_POST['part_ranking']))
            {
                
                $data=$_POST['part_ranking'];
                foreach($data as $v){
                    $sales_ranking_part=new Sales_ranking;
                    if(!empty($v['id'])){
                        
                        $type=2;
                        $ranking_name=$v['title_ranking'];
                        $contribution_date=$v['deadline_year']."-".$v['deadline_month']."_".$v['deadline_date'];
                       
                        $arrayPart=array('ranking_name'=>$ranking_name,
                                         'contribution_date'=>$contribution_date,
                                         'contributor_id'=>$contributor_id,
                                         'last_updated_date'=>$last_updated_date,
                                         'last_updated_person'=>$last_updated_person   
                                        );
                       if($sales_ranking_part->updateByPk($v['id'],$arrayPart))
                       {
                            foreach($v['list'] as $val)
                            {
                                $ranking_detail_part=new Ranking_details;
                                if(!empty($val['list_rank_1']) && !empty($val['title_rank_1']) && !empty($val['units_rank_1'])){
                                       $raking_rank=$val['list_rank_1'];
                                        $raking_name=$val['title_rank_1'];
                                        $raking_unit=$val['units_rank_1'];
                                        //update detail
                                        if(!empty($val['id']))
                                        {
                                            $arrList=array("rank"=>$raking_rank,
                                                          "name"=>$raking_name,
                                                          "unit"=>$raking_unit,
                                                          'last_updated_date'=>$last_updated_date,
                                                          'last_updated_person'=>$last_updated_person      
                                                          );
                                                $ranking_detail_part->updateByPk($val['id'],$arrList);
                                                      
                                        }
                                        //add detail
                                       else{
                                            $ranking_id=$v['id'];
                                            $ranking_detail_part->setAttribute('ranking_id',$ranking_id);
                                            $ranking_detail_part->setAttribute('rank',$raking_rank);
                                            $ranking_detail_part->setAttribute('name',$raking_name);
                                            $ranking_detail_part->setAttribute('unit',$raking_unit);
                                            $ranking_detail_part->setAttribute('created_date',$created_date);
                                            $ranking_detail_part->setAttribute('last_updated_date',$last_updated_date);
                                            $ranking_detail_part->setAttribute('last_updated_person',$last_updated_person);
                                            $ranking_detail_part->save();
                                           
                                        }
                                        
                                        
                                    }
                                   if(empty($val['list_rank_1']) && empty($val['title_rank_1']) && empty($val['units_rank_1']) && !empty($val['id'])){
                                        
                                        $id=(int)$val['id'];
                                        $ranking_detail_part=Ranking_details::model()->deleteAll("id=$id");
                                   }
                            }
                       }                 
                    }
                    else {
                        $type=2;
                        $ranking_name=$v['title_ranking'];
                        $contribution_date=$v['deadline_year']."-".$v['deadline_month']."_".$v['deadline_date'];
                   
                        $sales_ranking_part->setAttribute('type',$type);
                        $sales_ranking_part->setAttribute('ranking_name',$ranking_name);
                        $sales_ranking_part->setAttribute('contribution_date',$contribution_date);
                        $sales_ranking_part->setAttribute('contributor_id',$contributor_id);
                        $sales_ranking_part->setAttribute('created_date',$created_date);
                        $sales_ranking_part->setAttribute('last_updated_date',$last_updated_date);
                        $sales_ranking_part->setAttribute('last_updated_person',$last_updated_person);
                        if($sales_ranking_part->save()){
                            $ranking_id=$sales_ranking_part->id;
                            foreach($v['list'] as $val)
                            {
                                $ranking_detail_part=new Ranking_details;
                                if(!empty($val['list_rank_1']) && !empty($val['title_rank_1']) && !empty($val['units_rank_1'])){
                                        $raking_rank=$val['list_rank_1'];
                                        $raking_name=$val['title_rank_1'];
                                        $raking_unit=$val['units_rank_1'];
                                        $ranking_detail_part->setAttribute('ranking_id',$ranking_id);
                                        $ranking_detail_part->setAttribute('rank',$raking_rank);
                                        $ranking_detail_part->setAttribute('name',$raking_name);
                                        $ranking_detail_part->setAttribute('unit',$raking_unit);
                                        $ranking_detail_part->setAttribute('created_date',$created_date);
                                        $ranking_detail_part->setAttribute('last_updated_date',$last_updated_date);
                                        $ranking_detail_part->setAttribute('last_updated_person',$last_updated_person);
                                        $ranking_detail_part->save();
                                                
                                       
                                    }
                            }
                        }
                        
                    }
             
                   
                }
               
                
            }
            
        }
        Yii::app()->user->setFlash('delete_success', Lang::MSG_0073);
        $this->redirect("index");
    }
    public function actionDeletePersonalChild($id)
    {
           if(!empty($id))
            {
                $sale_raking=Sales_ranking::model()->deleteByPk(trim($id));
                $detail_ranking =true;
                
                if(Ranking_details::model()->exists("ranking_id=$id"))
                {
                    $detail_ranking=Ranking_details::model()->deleteAll("ranking_id=$id");
                }
                if($sale_raking && $detail_ranking)
                {
                    Yii::app()->user->setFlash('delete_success', Lang::MSG_0081);
                }
                else{
                    Yii::app()->user->setFlash('delete_success', Lang::MSG_0084);
                }
            }
            
            $this->redirect("../index");
       
    }
    public function actionCheckDupRkName()
    {
        if (Yii::app()->request->isAjaxRequest) {
           $id=trim($_POST['id']);
           $type=trim($_POST['type']);
           $ranking_name=trim($_POST['ranking_name']);
           if(!empty($id))
           {
                $count=Sales_ranking::model()->count("ranking_name='$ranking_name' AND type=$type AND id<>$id"); 
           }
           else $count=Sales_ranking::model()->count("ranking_name='$ranking_name' AND type=$type");
           echo $count;
           Yii::app()->end();
       }
    }
    public function actionCheckDupRkNamePersonal()
    {
        if (Yii::app()->request->isAjaxRequest) {
           $id=trim($_POST['id']);
           $type=trim($_POST['type']);
           $ranking_name=trim($_POST['ranking_name']);
           $machine_name_id=trim($_POST['machine_name_id']);
           if(!empty($id))
           {
                $count=Sales_ranking::model()->count("ranking_name='$ranking_name' AND type=$type AND id<>$id AND machine_name_id='$machine_name_id'"); 
           }
           else $count=Sales_ranking::model()->count("ranking_name='$ranking_name' AND type=$type AND machine_name_id='$machine_name_id'");
           echo $count;
           Yii::app()->end();
       }
    }
    public function actionDeletePersonalParent($id)
    {
            $machine_name_id=trim($id);
            $result=true;
            if(!empty($machine_name_id))
            {
                $connection=Yii::app()->db; 
    	       	$command=$connection->createCommand();
                $command->select("id");
                $command->from("sales_ranking");
                $command->where("machine_name_id='$machine_name_id'");
                $sales_ranking=$command->queryColumn();
                foreach($sales_ranking as $val){
                    $transaction = Yii::app()->db->beginTransaction();
                    $id=(int)$val['id'];
                    try{
                        $model=Ranking_details::model()->deleteAll("ranking_id=$id");
                        $sale_rakings=Sales_ranking::model()->deleteByPk("id=$id");
                        $transaction->commit();
                    }
                    catch(Exception $e){
                        $result=false;
                        $transaction->rollback();
                    }
                }
                $sale_rakings =true;
                if(Sales_ranking::model()->exists("machine_name_id='$machine_name_id'"))
                {
                     $sale_rakings=Sales_ranking::model()->deleteAll("machine_name_id='$machine_name_id'");
               
                }
                $machine=Machines::model()->deleteByPk($machine_name_id);
                if($result==true && $sale_rakings && $machine){
                    Yii::app()->user->setFlash('delete_success', Lang::MSG_0081);
                }
                else{
                    Yii::app()->user->setFlash('delete_success', Lang::MSG_0084);
                }
            }
            
            $this->redirect("../index");
       
    }
    public function actionDelete()
    {
            $sale_raking=Sales_ranking::model()->deleteAll();
            $detail_ranking=Ranking_details::model()->deleteAll();
			$machine=Machines::model()->deleteAll();
            if($sale_raking && $detail_ranking && $machine)
            {
                Yii::app()->user->setFlash('delete_success', Lang::MSG_0082);
            }
            else{
                Yii::app()->user->setFlash('delete_success', Lang::MSG_0084);
            }
            $this->redirect("index");
    }
    public function actionCheckDupMachinename()
    {
        if (Yii::app()->request->isAjaxRequest) {
           $id=trim($_POST['machine_id']);
           $machine_name=trim($_POST['machine_name']);
           if(!empty($id))
           {
                $count=Machines::model()->count("machine_name='$machine_name'  AND id<>$id"); 
           }
           else $count=Machines::model()->count("machine_name='$machine_name'");
           echo $count;
           Yii::app()->end();
       }
    }
   
}