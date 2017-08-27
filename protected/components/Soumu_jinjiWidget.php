<?php
class Soumu_jinjiWidget extends CWidget
{
	public function init()
	{
	}

	public function run()
	{

		
		$category_sql_2 = Yii::app()->db->createCommand("select * from category where category_name='入社' and type=3");
		$category_2	=	$category_sql_2->queryRow();
		
		$sql2 = Yii::app()->db->createCommand("select * from soumu_jinji where category_id='".$category_2['id']."' order by achive_date desc");
		$sql_id_2 = $sql2->queryRow();
		$soumu_jinji_2 	=	$sql2->queryAll();
		
		//
		$category_sql_3 = Yii::app()->db->createCommand("select * from category where category_name='退社' and type=3");
		$category_3	=	$category_sql_3->queryRow();
		
		$sql3 = Yii::app()->db->createCommand("select * from soumu_jinji where category_id='".$category_3['id']."' order by achive_date desc");
		$sql_id_3 = $sql3->queryRow();
		$soumu_jinji_3 	=	$sql3->queryAll();
		
		//
		$category_sql_4 = Yii::app()->db->createCommand("select * from category where category_name='異動' and type=3");
		$category_4	=	$category_sql_4->queryRow();
		
		$sql4 = Yii::app()->db->createCommand("select * from soumu_jinji where category_id='".$category_4['id']."' order by achive_date desc");
		$sql_id_4 = $sql4->queryRow();
		$soumu_jinji_4 	=	$sql4->queryAll();
	

		?>		
					<dl class="joined">
						<dt>入社・退社・異動 </dt>
                    </dl>
                
                    <?php
					 $now 	 = explode('/', date("Y/m/d"));
					if(FunctionCommon::isViewFunction("soumu_jinji")==true)
					{ 
					  if(!is_null($soumu_jinji_2))
						{
							$date = explode('/',FunctionCommon::formatDate($sql_id_2['achive_date']));
							if(($date['0'] > $now['0']) || ($date['0'] == $now['0'] && $date['1']>=$now['1']-1 && $date['2']>=01)){	
					?>
                    <dl class="joined">   
                    <dt class="gray">入社</dt>
                    <?php									
								foreach ($soumu_jinji_2 as $object) 
								{
									$date1 = explode('/',FunctionCommon::formatDate($object['achive_date']));
									if(($date1['0'] > $now['0']) || ( $date1['0'] == $now['0'] && $date1['1']>=$now['1']-1 && $date1['2']>=01))
											{	
					?>
                        <dd>
                            <span class="date"><?php echo FunctionCommon::formatDate($object['achive_date']); ?></span>
                            <!--<p class="area">＜東京営業＞</p>-->
                            <p class="text"><?php echo htmlspecialchars($object['employee_name'])?></p>
                        </dd>
                     <?php 
											}
								}
					echo '</dl>';
							}
						}	
					?>
                   
                    <?php		
					  if(!is_null($soumu_jinji_3))
						{	
							$date = explode('/',FunctionCommon::formatDate($sql_id_3['achive_date']));
								if(($date['0'] > $now['0']) || ($date['0'] == $now['0'] && $date['1']>=$now['1']-1 && $date['2']>=01)){
					 ?>  
                    <dl class="resignation">
                        <dt class="gray">退社（最終出勤日）</dt>
                        <?php				
							
								foreach ($soumu_jinji_3 as $object) 
								{
									$date2 = explode('/',FunctionCommon::formatDate($object['achive_date']));
									if(($date2['0'] > $now['0']) || ($date2['0']== $now['0'] && $date2['1']>=$now['1']-1 && $date2['2']>=01)){
					?>
                        <dd>
                            <span class="date"><?php echo FunctionCommon::formatDate($object['achive_date']); ?></span>
                            <!--<p class="area">＜東京営業＞</p>-->
                            <p class="text">
								<?php echo htmlspecialchars($object['employee_name'])?>
							</p>
                        </dd>
                     <?php 
									}
								}
					echo '</dl>';	
							}
						}		
					?>
                    <?php	
					  if(!is_null($soumu_jinji_3))
						{	
								$date = explode('/',FunctionCommon::formatDate($sql_id_4['achive_date']));
								if(($date['0'] > $now['0']) || ($date['0'] == $now['0'] && $date['1']>=$now['1']-1 && $date['2']>=01)){
					 ?>  
                    
                  
                    <dl class="transfer">
                        <dt class="gray">異動</dt>
                        <?php
                    			foreach ($soumu_jinji_4 as $object) 
								{
									$date3 = explode('/',FunctionCommon::formatDate($object['achive_date']));
									if(($date3['0'] > $now['0']) || ($date3['0'] == $now['0'] && $date3['1']>=$now['1']-1 && $date3['2']>=01)){
						?>
                        <dd>
                            <span class="date"><?php echo FunctionCommon::formatDate($object['achive_date']); ?></span>
                            <!--<p class="area">＜東京営業＞</p>-->
                            <p class="text"><?php echo htmlspecialchars($object['employee_name'])?></p>
                        </dd>
						 <?php 
									}
								}
						echo '</dl>';	
							}
						}	
						?>
                          </dl>
                        <?php		

						}
                   	?>  
                    <p class="listBtn">                        
                        <?php 
                           if(FunctionCommon::isViewFunction("soumu_jinji")==true){ 
                        ?>
                            <a href="<?php echo Yii::app()->baseUrl;?>/majimesoumu_jinji/" class="middleBtn listview">一覧を見る</a>
                        <?php 
                        }
                       
                        ?>
                    </p>
<?php                    
	}
}

                       
                      