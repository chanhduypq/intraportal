
<link href="<?php echo $this->assetsBase; ?>/css/admin/css/post.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">

jQuery(function($) 
{
	lock_empty_text=false;
	$("body").attr('id','admin');              
        jQuery('#branch_form').attr("action","<?php echo Yii::app()->baseUrl;?>/adminbase/registeditbranch/");
        $("td.actions a#btn-work").click(function(){             
            text=$(this).parents("tr").eq(0).find("td.name").eq(0).html();
            $("input#Branch_branch_name").val(text);
            a=$("input#Branch_id").val($(this).parents("tr").eq(0).attr("id"));
            $('button[type="submit"]').html('<i class="icon-chevron-right icon-white">&#12288;</i> 更新');          
			
        });
        $('button[type="button"]').click(function(){            
            $("input#Branch_id").val('');
            $("input#Branch_branch_name").val('');
            $('button[type="submit"]').html('<i class="icon-chevron-right icon-white">&#12288;</i> 登録');                        
        });
        
        $('button[type="submit"]').click(function(){ 
		
			$.ajax({                 			
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/adminbase/registeditbranch/",    
				data: jQuery('#branch_form').serialize(),
				success: function(msg){       					  		
					  jQuery('#Branch_branch_name').parent().prev().remove(); 
					  	if(msg!='[]'){
                                                    data=$.parseJSON(msg);
                                                    if(data.Branch_branch_name){
                                                         div=document.createElement('div');
                                                         $(div).addClass('alert');
                                                         $(div).addClass('error_message');
                                                         $(div).html(data.Branch_branch_name);
                                                         $(div).insertBefore($('#insertbefore'));
                                                         
                                                    }                                                  
					  	}							  															
					else{                            
					        
                                            if($("#Branch_id").val()!=''){
                                                if(confirm('更新します。よろしいですか？')==true){
                                                    jQuery('#branch_form').attr("onsubmit","return true;");                                             
                                                    jQuery('#branch_form').submit();
                                                }
                                            }
                                            else{
                                                if(confirm('登録します。よろしいですか？')==true){
                                                    jQuery('#branch_form').attr("onsubmit","return true;");                                             
                                                    jQuery('#branch_form').submit();
                                                }
                                            }  
                                            
                                        }									    			    
				}	  
			});
			
		});
        
});
</script>
<div class="wrap admin secondary base">

    <div class="container index">
       <div class="contents detail">
        	
            <div class="mainBox">
            	<div class="pageTtl">
            		<h2>部署管理 > 部門管理</h2>
            		<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminbase/unit/?base_id=<?php echo $_GET['base_id'];?>" class="btn btn-important"><i class="icon-chevron-left icon-white"></i> 前にもどる</a></span>
            	</div>
            	
                <div class="box">
					<div id="company-form" class="cnt-box">
	                	<h3 class="title"><?php echo $base_company['company_name']?> 部門名登録・修正フォーム</h3>
                        
						<?php
						$form = $this->beginWidget('CActiveForm', array(
							'id' => 'branch_form',                     
							'htmlOptions' => array(                                         
												  'class'=>'form-inline',
												  'onsubmit'=>'return false;',
												  'action'=>Yii::app()->baseUrl."/adminbase/registeditbranch/"
												  ),
								));
						?>	  
						<?php echo $form->hiddenField($model, 'id'); ?>
                        <?php echo $form->hiddenField($model, 'base_id',array('value' => $_GET['base_id'])); ?>
                        <input id="Branch_id2" type="hidden" name="Branch2">
                            <?php echo $form->error($model, 'branch_name'); ?> 
                            <div id="insertbefore">
                           
                             <label class="control-label" for="name">部門名&nbsp;<span class="label label-warning">必須</span></label>
                            
                        	<?php echo $form->textField($model, 'branch_name', array('class' => 'input-large')); ?>
                            <button type="submit" class="btn btn-important"><i class="icon-chevron-right icon-white">　</i> 登録</button>
                            <button type="button" class="btn"><i class="icon-remove">　</i> リセット</button>
                            </div>
                        <?php $this->endWidget(); ?>
					</div>

					<div id="company-list" class="cnt-box">				
						<h3 class="title"><?php echo $base_company['company_name']?>　部門一覧</h3>
						
		                <table class="table list font14">
		                	<thead>
		                		<tr>
			                		<th class="company">名前</th>
			                		<th class="updown">並び替え</th>
			                		<th class="actions">編集</th>
		                		</tr>
		                	</thead>
		                	<tbody>
                                <?php
									
                                    if(isset($branchs)&&is_array($branchs)&&count($branchs)>0){
                                            foreach ($branchs as $branch){     
                                    ?>        
		                		<tr class="company" id="<?php echo $branch['id'];?>">
  
									<td class="name"><?php echo $branch['branch_name']?></td>
									<td class="updown">
                                     <?php if($branch['modifiable_flag']=='1'){?> 
										<a id="down-btn" href="#" class="btn down-btn">↓</a>
										<a id="up-btn" href="#" class="btn up-btn">↑</a>
                                     <?php }else{?>   
                                   	    <a style="opacity:0.3;filter: alpha(opacity = 30);"  href="#" class="btn down-btn">↓</a>
										<a style="opacity:0.3;filter: alpha(opacity = 30);"  href="#" class="btn up-btn">↑</a>
                                     <?php }?>
									</td>
									
									<td class="actions">
										<ul class="inline">
											<li class="edit">
                                            <?php if($branch['modifiable_flag']=='1'){?> 
                                            <a id="btn-work" class="btn btn-work inline">修正</a>
											<?php }else {?> 
                                            <a style="opacity:0.3;filter: alpha(opacity = 30);" class="btn btn-work inline">修正</a>
                                            <?php }?> 
                                            </li>
											<li class="state inline">
                                            	<form style="display:inline-block;" method="post" id="upmodifiable_<?php echo $branch['id']?>" action="<?php echo Yii::app()->baseUrl."/adminbase/upmodifiable/";?>">

                                                    <input type="hidden" name="table_name" value="branch"/>
                                            	<?php 
												 echo $form->hiddenField($model, 'id',array('value'=>$branch['id']));
												 echo $form->hiddenField($model, 'base_id',array('value'=>$_GET['base_id']));
												 echo $form->dropDownList($model,'modifiable_flag',
																		 Constants::$typemodifiable_flag,
																		 array('class'=>'input-small',
																		 	  'options' => array($branch['modifiable_flag']=>array('selected'=>true))
																			  ));
												?>
                                              </form>
                                              <script type="text/javascript">
												jQuery(function($) 
												{
													//up modifiable_flag
													$("td.actions a#modifiable_flag_<?php echo $branch['id']?>").click(function(){         																	
															var ok = confirm('更新します。よろしいですか？');
															if(ok == true) {
																jQuery('form#upmodifiable_<?php echo $branch['id']?>').attr('onsubmit','return true;');
																jQuery('form#upmodifiable_<?php echo $branch['id']?>').submit();					
																}  
														});    
												});
											  </script>
                                               <a id="modifiable_flag_<?php echo $branch['id']?>" class="btn btn-correct">更新</a>                                             
											</li>
										</ul>
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
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
</div>

</div><!-- /wrap -->

<form id="up-down" action="<?php echo Yii::app()->baseUrl."/adminpost/updown/";?>">
    <input type="hidden" name="id1" id="id1"/>
    <input type="hidden" name="id2" id="id2"/>
    <input type="hidden" name="table_name" value="branch"/>
</form>