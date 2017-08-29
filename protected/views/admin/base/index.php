
<link href="<?php echo $this->assetsBase; ?>/css/admin/css/post.css" rel="stylesheet" type="text/css"/>
<style>
    a.disable_change{
        opacity:0.3;filter: alpha(opacity = 30);
    }
</style>
<script type="text/javascript">
//function actionChange(actionSelect)
//	{
//            
//            jQuery(actionSelect).parent().parent().parent().parent().parent().find("td").css("border-top","1px #CCC dotted");
//            jQuery(actionSelect).parent().parent().find("a").eq(0).removeClass("disable_change");
//            jQuery(actionSelect).parent().parent().find("a").eq(0).bind("click", function() {
//                var ok = confirm('更新します。よろしいですか？');                
//                if(ok == true) {
//                    id=jQuery(this).attr("id");                    
//                    id=id.substr(16);                    
//                    jQuery('form#upmodifiable_'+id).attr('action','<?php echo Yii::app()->baseUrl; ?>/adminbase/upmodifiable/');
//                    jQuery('form#upmodifiable_'+id).submit();					
//                }  
//            });
//		trNode=jQuery(actionSelect).parent().parent().parent().parent().parent().prev();
//                if(jQuery(trNode).attr("class")==undefined||jQuery(trNode).attr("class")!="company"){
//                    jQuery(trNode).remove();
//                }
//        if(jQuery(actionSelect).val()=='1'){
//            return;
//        }
//        jQuery.ajax
//		({
//				type: "GET", 
//				async:true,
//				url: "<?php echo Yii::app()->baseUrl;?>/adminbase/index/?base_id="+jQuery(actionSelect).parent().find("input#Base_id").eq(0).val(),    
//				success: function(data)
//				{
//					
//					 
//                                         
//					 if(data!="0")
//					 {
//						 
//						 
//                                                 jQuery(actionSelect).parent().parent().find("a").eq(0).addClass("disable_change");
//                                                 jQuery(actionSelect).parent().parent().find("a").eq(0).unbind("click");
//                                                 div=document.createElement('div');
//                                                         jQuery(div).addClass('alert');
//                                                         jQuery(div).addClass('error_message');
//                                                         jQuery(div).html('会社に所属する'+data+'人のユーザーがいます。ユーザー管理にて所属部署を変更してください');
//                                                         tr=document.createElement('tr');
//                                                         td=document.createElement('td');
//                                                         jQuery(td).attr("colspan","4");                                                         
//                                                         jQuery(td).append(div);
//                                                         jQuery(tr).append(td); 
//                                                         jQuery(actionSelect).parent().parent().parent().parent().parent().find("td").css("border","none");;
//                                                         jQuery(tr).insertBefore(jQuery(actionSelect).parent().parent().parent().parent().parent());
//					 }
//				 }
//		});
//    }
jQuery(function($) 
{
    
	lock_empty_text=false;
	$("body").attr('id','admin');              
        jQuery('#base_form').attr("action","<?php echo Yii::app()->baseUrl;?>/adminbase/registedit/");
        $("td.actions a#btn-work").click(function(){             
            text=$(this).parents("tr").eq(0).find("td.name").eq(0).html();
            $("input#Base_company_name").val(text);
            a=$("input#Base_id").val($(this).parents("tr").eq(0).attr("id"));
            $('button[type="submit"]').html('<i class="icon-chevron-right icon-white">&#12288;</i> 更新');          
			
        });
        $('button[type="button"]').click(function(){            
            $("input#Base_id").val('');
            $("input#Base_company_name").val('');
            $('button[type="submit"]').html('<i class="icon-chevron-right icon-white">&#12288;</i> 登録');                        
        });
        
        $('button[type="submit"]').click(function(){ 
		
			$.ajax({                 			
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/adminbase/registedit/",    
				data: jQuery('#base_form').serialize(),
				success: function(msg){       					  		
					  jQuery('#Base_company_name').parent().prev().remove(); 
					  	if(msg!='[]'){
                                                    data=$.parseJSON(msg);
                                                    if(data.Base_company_name){
                                                         div=document.createElement('div');
                                                         $(div).addClass('alert');
                                                         $(div).addClass('error_message');
                                                         $(div).html(data.Base_company_name);
                                                         $(div).insertBefore($('#insertbefore'));
                                                         
                                                    }                                                  
					  	}							  															
					else{                            
					        
                                            if($("#Base_id").val()!=''){
                                                if(confirm('更新します。よろしいですか？')==true){
                                                    jQuery('#base_form').attr("onsubmit","return true;");                                             
                                                    jQuery('#base_form').submit();
                                                }
                                            }
                                            else{
                                                if(confirm('登録します。よろしいですか？')==true){
                                                    jQuery('#base_form').attr("onsubmit","return true;");                                             
                                                    jQuery('#base_form').submit();
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
        <div class="contents company">
        	
            <div class="mainBox">
            	<div class="pageTtl">
            		<h2>部署管理 > 会社選択</h2>
            		<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminoffice/" class="btn btn-important"><i class="icon-pencil icon-white"></i> 事業所管理</a>
            	</div>
            	
                <div class="box">
					<div id="company-form" class="cnt-box">
	                	<h3 class="title">会社名登録・修正フォーム</h3>
                        
						<?php
						$form = $this->beginWidget('CActiveForm', array(
							'id' => 'base_form',                     
							'htmlOptions' => array(                                         
												  'class'=>'form-inline',
												  'onsubmit'=>'return false;',
												  'action'=>Yii::app()->baseUrl."/adminbase/registedit/"
												  ),
								));
						?>	  
						<?php echo $form->hiddenField($model, 'id'); ?>  
                         <input id="Base2" type="hidden" name="Base2" value="">
                            <?php echo $form->error($model, 'company_name'); ?> 
                            <div id="insertbefore">
                           
                            <label class="control-label" for="name">会社名&nbsp;<span class="label label-warning">必須</span></label>
                            
                        	<?php echo $form->textField($model, 'company_name', array('class' => 'input-large')); ?>
                            <button type="submit" class="btn btn-important"><i class="icon-chevron-right icon-white">　</i> 登録</button>
                            <button type="button" class="btn"><i class="icon-remove">　</i> リセット</button>
                            </div>
                        <?php $this->endWidget(); ?>
					</div>

					<div id="company-list" class="cnt-box">				
						<h3 class="title">会社一覧</h3>
						
		                <table class="table list font14">
		                	<thead>
		                		<tr>
			                		<th class="company">名前</th>
			                		<th class="updown">並び替え</th>
			                		<th class="unit">部署管理</th>
			                		<th class="actions">編集</th>
		                		</tr>
		                	</thead>
		                	<tbody>
                                <?php
									
                                    if(isset($bases)&&is_array($bases)&&count($bases)>0){
                                            foreach ($bases as $base){     
                                    ?>        
		                		<tr class="company" id="<?php echo $base['id'];?>">
                                	<!--<input value="<?php echo $base['id'];?>" name="id" type="hidden"/>-->
									<td class="name"><?php echo $base['company_name']?></td>
									<td class="updown">
                                     <?php if($base['modifiable_flag']=='1'){?> 
										<a id="down-btn" href="#" class="btn down-btn">↓</a>
										<a id="up-btn" href="#" class="btn up-btn">↑</a>
                                     <?php }else{?>   
                                   	    <a style="opacity:0.3;filter: alpha(opacity = 30);"  href="#" class="btn down-btn">↓</a>
										<a style="opacity:0.3;filter: alpha(opacity = 30);"  href="#" class="btn up-btn">↑</a>
                                     <?php }?>
									</td>
									<td class="unit">
                                     <?php if($base['modifiable_flag']=='1'){?> 
                                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminbase/unit/?base_id=<?php echo $base['id'];?>" class="btn btn-edit">部署管理</a>
									<?php }else {?> 
									<a style="opacity:0.3;filter: alpha(opacity = 30);" class="btn btn-edit">部署管理</a>
                                    <?php }?> 
                                     </td>
									<td class="actions">
										<ul class="inline">
											<li class="edit">
                                            <?php if($base['modifiable_flag']=='1'){?> 
                                            <a id="btn-work" class="btn btn-work inline">修正</a>
											<?php }else {?> 
                                            <a style="opacity:0.3;filter: alpha(opacity = 30);" class="btn btn-work inline">修正</a>
                                            <?php }?> 
                                            </li>
											<li class="state inline" >
                                                <form style="display:inline-block;" method="post" id="upmodifiable_<?php echo $base['id']?>" action="<?php echo Yii::app()->baseUrl."/adminbase/upmodifiable/";?>">

                                                    <input type="hidden" name="table_name" value="base"/>
                                            	<?php 
                                                if($base['user_count']>0){
                                                    $typemodifiable_flag_array=array('1'	=> '有効');
                                                }
                                                else{
                                                    $typemodifiable_flag_array=  Constants::$typemodifiable_flag;
                                                }
												 echo $form->hiddenField($model, 'id',array('value'=>$base['id']));
												 echo $form->dropDownList($model,'modifiable_flag',$typemodifiable_flag_array
																		 ,
																		 array('class'=>'input-small',
																		 	  'options' => array($base['modifiable_flag']=>array('selected'=>true))));
												?>
                                              </form>
                                                                                            <?php
                                                                                            if($base['user_count']>0){?>
                                                                                            <a id="modifiable_flag_<?php echo $base['id']?>" class="btn btn-correct disable_change">更新</a>
                                                                                            <?php
                                                                                            }
                                                                                            else{
                                                                                            ?>
                                                                                            
                                              <script type="text/javascript">
												jQuery(function($) 
												{
													//up modifiable_flag
													$("td.actions a#modifiable_flag_<?php echo $base['id']?>").click(function(){          
															var ok = confirm('更新します。よろしいですか？');
															if(ok == true) {
																jQuery('form#upmodifiable_<?php echo $base['id']?>').attr('onsubmit','return true;');
																jQuery('form#upmodifiable_<?php echo $base['id']?>').submit();					
																}  
														});    
												});
											  </script>
                                                 <a id="modifiable_flag_<?php echo $base['id']?>" class="btn btn-correct">更新</a>
                                                 <?php
                                                                                            }
                                                 ?>
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
    <input type="hidden" name="table_name" value="base"/>
</form>