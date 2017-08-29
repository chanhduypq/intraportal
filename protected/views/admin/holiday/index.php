
<link href="<?php echo $this->assetsBase; ?>/css/admin/css/holiday.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">

jQuery(function($){
//	$('ul.yiiPager li.selected').removeClass('selected');
//	$('ul.yiiPager li').removeClass('page');
//	$('ul.yiiPager li').removeClass('previous');
//	$('ul.yiiPager li').removeClass('next');
//	$('ul.yiiPager li').removeClass('last');
//	$('ul.yiiPager li').removeClass('first');
//	$('ul.yiiPager li').removeClass('hidden');
//	$('ul.yiiPager').removeClass('yiiPager');
	lock_empty_text=false;
	$("body").attr('id','admin');            
        jQuery('#holiday_form').attr("action","<?php echo Yii::app()->baseUrl;?>/adminholiday/registedit/");
        $("td.actions a.btn-work").click(function(){             
            text=$(this).parents("tr").eq(0).find("td.h_name").eq(0).html();
            $("input#Holiday_title").val(text);
            text=$(this).parents("tr").eq(0).find("td.h_year").eq(0).html();
            $("input#Holiday_achive_date").val(text);
            text=$(this).parents("tr").eq(0).find("td.h_st").eq(0).html();
            if(text=='休日'){
                text='0';
            }
            else{
                text='1';
            }
            
            $("select#Holiday_status").val(text);
            $("input#Holiday_id").val($(this).parents("tr").eq(0).attr("id"));
            $('button[type="submit"]').html('<i class="icon-chevron-right icon-white">&#12288;</i> 更新');            
        });
        $('button[type="button"]').click(function(){            
            $("input#Holiday_id").val('');
            $("input#Holiday_title").val('');
            $("input#Holiday_achive_date").val('');
            $("select#Holiday_status").val('');
            $('button[type="submit"]').html('<i class="icon-chevron-right icon-white">&#12288;</i> 登録');                        
        });
        
        $('button[type="submit"]').click(function(){
            //jQuery('#Holiday_achive_date').val($.trim(jQuery('#Holiday_achive_date').val()));
			$.ajax({                 			
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/adminholiday/registedit/",    
				data: jQuery('#holiday_form').serialize(),
				success: function(msg){       					  		
					  jQuery('#Holiday_title').prev().remove(); 
                                          jQuery('#Holiday_achive_date').prev().remove(); 
                                          jQuery('#Holiday_status').prev().remove(); 
					  	if(msg!='[]'){
                                                    data=$.parseJSON(msg);
                                                    if(data.Holiday_title){
                                                         div=document.createElement('div');
                                                         $(div).addClass('alert');
                                                         $(div).addClass('error_message');
                                                         $(div).html(data.Holiday_title);
                                                         $(div).insertBefore($('#Holiday_title'));
                                                         
                                                    }     
                                                    if(data.Holiday_achive_date){
                                                         div=document.createElement('div');
                                                         $(div).addClass('alert');
                                                         $(div).addClass('error_message');
                                                         $(div).html(data.Holiday_achive_date);
                                                         $(div).insertBefore($('#Holiday_achive_date'));
                                                         
                                                    }     
                                                    if(data.Holiday_status){
                                                         div=document.createElement('div');
                                                         $(div).addClass('alert');
                                                         $(div).addClass('error_message');
                                                         $(div).html(data.Holiday_status);
                                                         $(div).insertBefore($('#Holiday_status'));
                                                         
                                                    }     
                                                    
						  
					  	}							  															
					else{ 
                                            if($("#Holiday_id").val()!=''){
                                                if(confirm('更新します。よろしいですか？')==true){
                                                    jQuery('#holiday_form').attr("onsubmit","return true;");                                             
                                                    jQuery('#holiday_form').submit();
                                                }
                                            }
                                            else{
                                                if(confirm('登録します。よろしいですか？')==true){
                                                    jQuery('#holiday_form').attr("onsubmit","return true;");                                             
                                                    jQuery('#holiday_form').submit();
                                                }
                                            }
                                            
                                            
                                        }
					  	
											    			    
				}	  
			});
			
		});
        
});
</script>
<!--<input type="hidden" id="page_count" value="<?php //echo $pages->getPageCount();?>"/>-->
<div class="wrap admin secondary holiday">

    <div class="container index">
        <div class="contents detail">
        	
            <div class="mainBox">
            	<div class="pageTtl">
            		<h2>休日管理</h2>
            	</div>
                <div class="box">

                <p class="descriptionTxt">休日・休日出勤日を入力して下さい。（土日は休日扱いです）</p>
                <?php
                 
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'holiday_form',                     
                    'htmlOptions' => array(                                         
                                          'class'=>'form-horizontal',
                                          'onsubmit'=>'return false;',
                                          'action'=>Yii::app()->baseUrl."/adminholiday/registedit/"
                                          ),
                        ));
                    
                ?>
                <?php echo $form->hiddenField($model, 'id'); ?>  
                    <div class="cnt-box">
                        <div class="baseDetailBox">
                            <div class="field attachements">
							</div>
                            <div class="control-group">
                                <label for="title" class="control-label">日付
                                <span class="label label-warning">必須</span></label>
                                <div class="controls">
                                    <?php echo $form->error($model, 'achive_date'); ?>
                                    <?php echo $form->textField($model, 'achive_date', array('class' => 'input-xlarge bootdate')); ?>
                                    
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="title" class="control-label">名称</label>
                                <div class="controls">
                                    <?php echo $form->error($model, 'title'); ?>
                                    <?php echo $form->textField($model, 'title', array('class' => 'input-xlarge')); ?>                                    
                                </div>
                            </div>
							<div class="control-group">
                                <label for="title" class="control-label">ステータス
                                <span class="label label-warning">必須</span></label>
                                <div class="controls">
                                    <?php echo $form->error($model, 'status'); ?>
                                    <?php echo $form->dropDownList($model, 'status', $model->allStatus, array('options' => array($model->status => array('selected' => true)))); ?> 
										
                                </div>
                            </div>
                                                        
                        </div><!-- /baseDetailBox -->
					</div><!-- /cnt-box -->
                



                    <div class="form-last-btn">
                        <p class="btn200">
                            <button class="btn btn-important" type="submit"><i class="icon-chevron-right icon-white">&#12288;</i> 登録</button>
                            <button class="btn" type="button"><i class="icon-remove">&#12288;</i> リセット</button>
                        </p>
                    </div>
                        
              <?php $this->endWidget(); ?>

<hr>

				<div class="company_1">				
	          <table class="table list font14">
	                	<thead>
	                		<tr>
		                		<th class="h_year">年月日</th>                            
		                		<th class="h_name">名称</th>
                                <th class="h_st">ステータス</th>
		                		<th class="actions">編集</th>
	                		</tr>
	                	</thead>
                                <tbody>
                                <?php 
                                
                                if(isset($holidays)&&is_array($holidays)&&count($holidays)>0){
                                    foreach ($holidays as $holiday){?>
                                    
                                        <tr class="newgin" id="<?php echo $holiday['id'];?>">
                                            <td class="h_year"><?php echo FunctionCommon::formatDate($holiday['achive_date']);?></td> 
								<td class="h_name"><?php echo $holiday['title'];?></td>
                                <td class="h_st"><?php echo ($holiday['status']=='0')?'休日':'出勤';?></td>
								<td class="actions">
                                   <a class="btn btn-work">編集</a>
                                  <a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->baseUrl;?>/adminholiday/delete/?id=<?php echo $holiday['id'];?>';" class="btn btn-correct">削除</a>
								</td>
							</tr>
                                <?php
                                    }
                                }
                                ?>
	                	
	                		
	                		                                                                             
	                	</tbody>
	                </table>
             	</div>
             	
				
									

                
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
        <p id="page-top" style="display: block;"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
</div>

</div>
