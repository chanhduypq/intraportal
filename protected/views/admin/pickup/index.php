<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<div class="wrap admin secondary pickup " id="admin">
	<div class="container">
		<div class="contents edit">
			<div class="mainBox detail">
            	<div class="pageTtl">
					<h2>今日の社員ピックアップ - 設定</h2>
				</div>
                <div class="box">
                	<div class="cnt-box">
                	<!--
						<div class="alert info">メッセージを表示します</div>
					-->
		                <table width="724" border="0" class="table list font14">
		                	<thead>
			                	<tr>
			                		<th>掲載予定日</th>
									<th>掲載内容</th>
								</tr>
							</thead>
							<tbody>	
								<?php if(isset($_GET['cur']))
									{
										$current = $_GET['cur'];
									}
									else
									{
										$current = time();
									}
									
									for($i = 0; $i < 15; $i++)
									{
										$ts= date('Y-m-d', $current); 
										$current = strtotime("+1 day", $current);?>
								
								<?php $criteria = new CDbCriteria;?>
								<?php $criteria->select = "*";?>
								<?php $criteria->condition='DATE_FORMAT(pickup_date, "%Y-%m-%d")="'.$ts.'"';?>
								<?php $client = Pickup::model()->find($criteria);?>
								<?php
								if(count($client)>0): ?>
                                	
									<tr>
										<td class="td-date alnC txtRed postsDate">
											<?php echo FunctionCommon::formatDate($client->pickup_date);?>
										</td>
										<td class="td-text">
											<div class="name">
                                            <?php
												if($client->user_id=="" || $client->user_id=="Null")						{
													echo "<p class='catchcopy' style='font-weight:bold'>".$client->title."</p>";
												}
												else{
											?>
                                         
												<div id="<?php echo "divchangeUserForm$i"?>" class="changeUserForm">
                                                                                                    
												<?php 
                                                                                                
                                                                                                
                                                                                               
//                                                                                                        echo $form->dropDownList($client, 'unit_id', $client->allBases,
//													array('options' => array($client->unit_id=> array('selected' => true)),
//													'onchange' => 'baseChange(this);','id'=>"cbbBase_$i")); 
                                                    
													 if($client->user_id !=""){		
													 	
														 $sql=  "select * from user where id=".$client->user_id;
														 $user = Yii::app()->db->createCommand($sql)->queryRow(); 														 
                                                                                                                 $division_temp=$client->unit_id;
                                                                                                                 if($division_temp!=""){
                                                                                                                     $temp_count=Yii::app()->db->createCommand("select count(*) as count from unit where id=$division_temp")->queryScalar();
                                                                                                                     if($temp_count==0){
                                                                                                                         $division_temp='';
                                                                                                                     }
                                                                                                                 }
                                                                                                                 if($division_temp==""){
                                                                                                                     $division_temp=$user['division1'];
                                                                                                                 }
                                                                                                                 if($division_temp==""){
                                                                                                                     $division_temp=$user['division2'];
                                                                                                                 }
                                                                                                                 if($division_temp==""){
                                                                                                                     $division_temp=$user['division3'];
                                                                                                                 }
                                                                                                                 if($division_temp==""){
                                                                                                                     $division_temp=$user['division4'];
                                                                                                                 }
                                                                                                                 
                                                                                                                 
                                                                                                                 $form = $this->beginWidget('CActiveForm', array(
													'id' => "pickup_form_$i",
													'htmlOptions' => array('onsubmit'=>'return false;',),));
                                                                                                                 

                                                                                                                 echo $form->dropDownList($client, 'unit_id', $client->allBases,
                                                                                                                    array('options' => array($division_temp=> array('selected' => true)),
                                                                                                                    'onchange' => 'baseChange(this);','id'=>"cbbBase_$i")); 
                                                                                                                 
                                                                                                                 if($division_temp!=""){                                                                                                                     
                                                                                                                     echo $form->dropDownList($client,'user_id', $model->getAllLastFirstNameByUnitId($division_temp),
														 array('options' => array($client->user_id => array('selected' => true)),
														'onchange' => 'userChange(this);','id'=>"cbbUse_$i")); 
                                                                                                                 }
                                                                                                                 else{
                                                                                                                     echo $form->dropDownList($client,'user_id', $model->allLastFirstName,
														 array('options' => array($client->user_id => array('selected' => true)),
														'onchange' => 'userChange(this);','id'=>"cbbUse_$i")); 
                                                                                                                 }

                                                                                                                 
														 
													 }
													?>
													<input type="hidden" name="pickup_id" value="<?php echo $client->id?>"/>
													<input type="hidden" name="pickup_date" value="<?php echo $client->pickup_date ?>"/>
													<input type="submit" class="btn btn-primary" value="更新" onclick="return isValidate(<?php echo $i ?>)">
													<?php $this->endWidget(); ?> 
												</div>
											</div>
                                            
											<p class="catchcopy">
												<?php echo !empty($user['catchphrase']) ?  nl2br(htmlspecialchars($user['catchphrase'])) :''?>
											</p>
											<p class="comment">
												<?php echo !empty($user['comment']) ?  nl2br(htmlspecialchars($user['comment'])) :''?>
											</p>
                                            <?php }?>
										</td>
									</tr>
								<?php else: ?>
			                        <td class="td-date alnC txtRed postsDate">
										<?php 
										echo FunctionCommon::formatDate($ts); 
										$pickup_date = str_replace("/","-",FunctionCommon::formatDate($ts));
										$explode_pickup_date =  explode('-',$pickup_date);
										$day=date($explode_pickup_date['2']);		
										$mon=date($explode_pickup_date['1']);		
										$year=date($explode_pickup_date['0']);
										
										$jd=cal_to_jd(CAL_GREGORIAN,$mon,$day,$year);
										$thu=jddayofweek($jd,0);
										
										$holiday_status0 = Yii::app()->db->createCommand("select title from holiday where DATE_FORMAT(achive_date, '%Y-%m-%d')='".$pickup_date."' and status=0")->queryRow();
										
										$holiday_status1 = Yii::app()->db->createCommand("select title from holiday where DATE_FORMAT(achive_date, '%Y-%m-%d')='".$pickup_date."' and status=1")->queryRow();
										
										?>
									</td>
			                        <td class="td-text">
			                        	<div class="name">
                                        	<?php
													
													if($thu =='6' && empty($holiday_status1)){
														 
														echo "<p class='catchcopy' style='font-weight:bold'>本日は土曜日です</p>";
													}
													else if($thu =='0' && empty($holiday_status1)){
															 
														echo "<p class='catchcopy' style='font-weight:bold'>本日は日曜日です</p>";
													}
													else if(!empty($holiday_status0)){
														echo "<p class='catchcopy' style='font-weight:bold'>本日は".$holiday_status0['title']."です</p>";
													}
													else 
													{ 
														
											 ?>
			                        		<div id="<?php echo "divchangeUserForm$i"?>" class="changeUserForm">
                                                                    
												<?php $form = $this->beginWidget('CActiveForm', array(
													'id' => "pickup_form_$i",
													'htmlOptions' => array('onsubmit'=>'return false;',),));?>       
												
												<?php echo $form->dropDownList($model, 'unit_id', $model->allBases, 
												array('options' => array($model->unit_id => array('selected' => true)), 
													  'onchange' => 'baseChange(this);','id'=>"cbbBase_$i")); ?> 
													  
												<?php echo $form->dropDownList($model, 'user_id', $model->allUsers, 
												array('options' => array($model->user_id => array('selected' => true)), 
												'onchange' => 'userChange(this);','id'=>"cbbUse_$i")); ?> 
												
												<input type="hidden" name="pickup_id" value="<?php echo $model->id?>"/>
												<input type="hidden" name="pickup_date" value="<?php echo $ts?>"/>
												<input type="submit" class="btn btn-primary" value="更新" onclick="return isValidate(<?php echo $i ?>)">
												<?php $this->endWidget(); ?> 
				                        		</div>
                                            <?php }?>    
			                        	</div>
		                        		<p class="catchcopy"></p>
		                        		<p class="comment"></p>
			                        </td>
			                    </tr>
								<?php endif; ?>	
								<?php }  ?>
							</tbody>
						</table>

					</div><!-- /cnt-box -->
                </div><!-- /box -->
            </div><!-- /mainBox -->
            
            <div class="sideBox">
        <ul>
        	<li>
            	 <?php $this->widget('MenuManager');?>
                 <?php $this->widget('AffairsManage');?>
                 <?php $this->widget('SystemManage');?>
                 <?php $this->widget('PostedByContentManage');?>
            </li>
        </ul>
      </div><!-- /sideBox -->
            
  </div><!-- /contents -->
        <p id="page-top" style="display: none;"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
</div>

</div>

<script type="text/javascript">
	
	jQuery(function($)
	{   
	
		$("body").attr('id','admin');  
                
	});
	
	/*Check validation*/
	function isValidate(id)
	{
		if ($("#divError"+id).length > 0)
		{
			$("#divError"+id).remove();
		}
		 var divError="divError"+id;
      	 var baseId=$("#cbbBase_"+id).val();	
		 var userId=$("#cbbUse_"+id).val();
		 if((baseId && !userId) || (!baseId && userId))
		 {
			$("#divchangeUserForm"+id).prepend( "<div id="+divError+" class='alert error_message'>拠点、および社員の名前を選択してください。</div>" );
		 }
		else
		{
			$('#pickup_form_'+id).attr('onsubmit','return true;');
			$('#pickup_form_'+id).submit();
		}		 

    }
	
   function baseChange(baseSelect)
	{
		
        catchcopy=jQuery(baseSelect).parent().parent().parent().next();
        comment=jQuery(baseSelect).parent().parent().parent().next().next();
        userSelect=jQuery(baseSelect).next();
        jQuery.ajax
		({
				type: "GET", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/adminpickup/index/?unit_id="+jQuery(baseSelect).val(),    
				success: function(data)
				{
					
					 jQuery(userSelect).html('');
					 jQuery(catchcopy).html('');
					 jQuery(comment).html('');
					 jQuery(userSelect).append("<option value=''>選んで下さい</option>");
                                         
					 if(data!="[]")
					 {
						 
						 data=jQuery.parseJSON(data);
                                                 count_user=data.length-1;
						 for(i=0,n=data.length;i<n;i++)
						 {
							
							jQuery(userSelect).append("<option value='"+data[i].id+"'>"+data[i].lastname+" "+data[i].firstname+"</option>");
						 }
                                                 
                                                 
					 }
				 }
		});
    }
	
    function userChange(userSelect)
	{
        catchcopy=jQuery(userSelect).parent().parent().parent().next();
        comment=jQuery(userSelect).parent().parent().parent().next().next();
       
        jQuery.ajax
		({
			type: "GET", 
			async:true,
			url: "<?php echo Yii::app()->baseUrl;?>/adminpickup/index/?user_id="+jQuery(userSelect).val(),    
			success: function(data)
			{
				 jQuery(catchcopy).html('');
				 jQuery(comment).html('');
				 if(data!="[]")
				 {
					data=jQuery.parseJSON(data);
					if(data.catchphrase!=null)
					{
						 jQuery(catchcopy).html(data.catchphrase);
					}
					if(data.comment!=null)
					{
						 jQuery(comment).html(data.comment+"<br/>&nbsp;<br/>&nbsp;<br/>&nbsp;");
					}
				}
			 }
		});
    }
	
	

</script>
