<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<div class="wrap admin secondary base_news" id="admin">
	<div class="container">
		<div class="contents index">
			<div class="mainBox detail">
            	<div class="pageTtl">
					<h2>今週の部署紹介 - 設定</h2>
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
							
								
								<?php
								
									$current_day = date("N");
									$days_from_monday = $current_day - 1;
									$monday = date("Y-m-d", strtotime("- {$days_from_monday} Days"));
									for($i = 0; $i < 5; $i++)
									{	
										if($i==0)
										{
											$monday=$monday;
										}
										else
										{
											$monday = date('Y-m-d', strtotime($monday . ' + 7 day'));
										}
									?>
									<?php $criteria = new CDbCriteria;?>
									<?php $criteria->select = "*";?>
									<?php $criteria->condition='DATE_FORMAT(pickup_date, "%Y-%m-%d")="'.$monday.'"';?>
									<?php $client = Base_news::model()->find($criteria);?>
									<?php if(count($client)>0): ?>	
									<tr>
										<td class="td-date alnC txtRed postsDate">
											<?php echo FunctionCommon::formatDate($client->pickup_date); ?>
										</td>
										<td class="td-text">
											<div class="name">
												<div id="<?php echo "divchangeUserForm$i"?>"  class="changeUserForm">
													<?php $form = $this->beginWidget('CActiveForm', array(
														'id' =>"base_news_form_$i",                     
														'htmlOptions' => array(
														'onsubmit'=>'return false;'),));?> 
												
													<?php echo $form->dropDownList($client, 'base_id', $model->allBases, 
														array('options' => array($model->base_id => array('selected' => true)) ,
															  'onchange' => "valueChange($i)",'id'=>"cbbBase_$i")); ?> 
													<input type="hidden" name="Basenews_id" value="<?php echo $client->id?>"/>
													<input type="hidden" name="pickup_date" value="<?php echo $client->pickup_date ?>"/>
													<input type="submit" class="btn btn-primary" value="更新" onclick="return isValidate(<?php echo $i ?>)">
													<?php $this->endWidget(); ?>
												</div>
											</div>
											<?php  
											$unit = Yii::app()->db->createCommand()
												->select('catchphrase,introduction')
												->from('unit') 
												->where("active_flag=1 and id=$client->base_id")
												->queryRow();
												
											?>
											<p id="<?php echo 'catchcopy'.$i?>" class="catchcopy">
												<?php echo !empty($unit['catchphrase']) ? nl2br(htmlspecialchars($unit['catchphrase'])) :''?>
											</p>
											<p id="<?php echo 'comment'.$i?>" class="comment">
												<?php echo !empty($unit['introduction']) ? nl2br(htmlspecialchars($unit['introduction'])):''?>
											</p>
										</tr>	
										<?php else: ?> 	
                                      
										<tr>
											<td class="td-date alnC txtRed postsDate">
												<?php echo FunctionCommon::formatDate($monday); ?>
                                                  
											</td>
											<td class="td-text">
												<div class="name">
													<div id="<?php echo "divchangeUserForm$i"?>"  class="changeUserForm">
														<?php $form = $this->beginWidget('CActiveForm', array(
															'id' => "base_news_form_$i",                     
															'htmlOptions' => array(
															'onsubmit'=>'return false;'),));?> 
								
														<?php echo $form->dropDownList($model, 'base_id', $model->allBases, 
																	array('options' => array($model->base_id => array('selected' => true)) ,
																	'onchange' => "valueChange($i)",'id'=>"cbbBase_$i")); ?> 
														
														<input type="hidden" name="Basenews_id" value="<?php echo $model->id?>"/>
														<input type="hidden" name="pickup_date" value="<?php echo $monday?>"/>
														<input type="submit" class="btn btn-primary" value="更新" onclick="return isValidate(<?php echo $i ?>)">
														<?php $this->endWidget(); ?>
													</div>
												</div>
												<p id="<?php echo 'catchcopy'.$i?>" class="catchcopy"></p>
												<p id="<?php echo 'comment'.$i?>" class="comment"></p>
											</tr>
											<?php endif; ?>
										<?php } ?>	
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
			<!-- /sideBox -->
            
  </div><!-- /contents -->
        <p id="page-top" style="display: block;"><a href="#wrap">PAGE TOP</a></p>

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
		
		if(!baseId)
		{
			$("#divchangeUserForm"+id).prepend( "<div id="+divError+" class='alert error_message'>事業所名を入力してください。</div>" );
		}
		else
		{
			$('#base_news_form_'+id).attr('onsubmit','return true;');
			$('#base_news_form_'+id).submit();
		}		 
    }
   
    function valueChange(id)
	{
		$("#catchcopy"+id).html('');
		$("#comment"+id).html('');
		var baseId=$("#cbbBase_"+id).val();	
        jQuery.ajax
		({
				type: "GET", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/adminbase_news/?base_id="+baseId, 
				success: function(data)
				{
					 if(data!="[]")
					  {	
						 data=$.parseJSON(data);
						 if(data.catchpharse!=null)
						 {
							 $("#catchcopy"+id).html(data.catchpharse);
						 }
						 if(data.introduction!=null)
						 {
							 $("#comment"+id).html(data.introduction);
						 }
					 }
				}
		});
    }
</script>