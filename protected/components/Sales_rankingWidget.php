<?php
class Sales_rankingWidget extends CWidget
{
	public function init()
	{
	}

	public function run()
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
        $k=0;
        $contribution_date="";
        $part_ranking_name="";
        foreach($part_ranking as $val){
           if($contribution_date!=$val['contribution_date'])
           {
                $k++;
                $m=0;
                $part_rankings[$k]['contribution_date']=$val['contribution_date'];
           } 
           if($part_ranking_name != $val['ranking_name']){
               $m++;
               $n=0; 
               $part_rankings[$k]['child'][$m]['ranking_name']=$val['ranking_name'];
           }
           if($part_ranking_name == $val['ranking_name']){
              $n++;
           } 
           $part_rankings[$k]['child'][$m]['list'][$n]['id']=$val['detail'];
           $part_rankings[$k]['child'][$m]['list'][$n]['rank']=$val['rank']; 
           $part_rankings[$k]['child'][$m]['list'][$n]['name']=$val['name']; 
           $part_rankings[$k]['child'][$m]['list'][$n]['unit']=$val['unit']; 
           $part_ranking_name=$val['ranking_name'];    
           $contribution_date=$val['contribution_date']; 
        }
        ?>	
				 <div class="box ranking pink">
                    <h2 class="ttl">販売ランキング</h2>
                    <div>
                    <?php if(!empty($personal_rankings) && !empty($machine)) { ?>
                    <dl class="rank_model">
                        <dt>個人部門</dt>
                        <?php foreach($machine as $val) {?>
                        <dd class="subttl" style="font-weight:normal" >対象機種：<?php echo htmlspecialchars($val->machine_name)?></dd>
                        <?php
                            $k=$val->id;
                            if(isset($personal_rankings[$k]['child']))
                            {
                            foreach($personal_rankings[$k]['child'] as $v){?>
                            <dt class="gray"><?php echo "＜".htmlspecialchars($v['ranking_name'])."＞"?></dt>
                            <dd>
                                <ul>
                                    <?php 
                                        $i=0;
                                        foreach ($v['list'] as $v1){
                                        $i++;
                                    ?>                               
                                    <li>
                                        <span class="number"><?php echo $v1['rank'] ?>.</span>
                                        <p class="text"><?php echo $v1['name']."<br />[".$v1['unit']?>]</p>
                                    </li>
                                    <?php } ?>
                                   
                                </ul>
                            </dd>
                            
                       
                        <?php } } } ?>
                    </dl>
                    <?php }
                    if(!empty($part_rankings)) {?>
                    <dl class="rank_individual">
                        <dt>拠点部門ランキング<br /></dt>
                        <?php foreach($part_rankings as $val){ ?>
                        <dd style="font-weight:normal" ><?php echo date('Y', strtotime($val['contribution_date']))."年".date('m', strtotime($val['contribution_date']))."月".date('d', strtotime($val['contribution_date']))."日"?></dd>
                        <?php foreach($val['child'] as $v){ ?>
                        <dt class="gray"><?php echo "＜".$v['ranking_name']."＞"?></dt>
                        <dd>
                            <ul>
                                <?php 
                                $j=0;
                                foreach($v['list'] as $v1){
                                $j++;    
                                ?>
                                <li>
                                    <span class="number"><?php echo $v1['rank'] ?>.</span>
                                    <p class="text"><?php echo $v1['name']."<br />[".$v1['unit']?>]</p>
                                  
                                </li>
                                <?php }?>
                               
                            </ul>
                        </dd>
                        <?php } } ?>
                    </dl>
                    <?php } ?>
                    </div>
                </div><!-- /box - ranking -->
         
<?php                  
	}
}

                       
                      