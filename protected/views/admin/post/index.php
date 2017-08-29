
<link href="<?php echo $this->assetsBase; ?>/css/admin/css/post.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">

jQuery(function($) 
{
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
        jQuery('#post_form').attr("action","<?php echo Yii::app()->baseUrl;?>/adminpost/registedit/");
        $("td.actions a.btn-work").click(function(){             
            text=$(this).parents("tr").eq(0).find("td.branch").eq(0).html();
            $("input#Post_post_name").val(text);
            $("input#Post_id").val($(this).parents("tr").eq(0).attr("id"));
            $('button[type="submit"]').html('<i class="icon-chevron-right icon-white">&#12288;</i> 更新');            
        });
        $('button[type="button"]').click(function(){
//            if($("input#Post_id").val()==''&&lock_empty_text==false){
//                $("input#Post_post_name").val('');
//            }   
//            else{
//                lock_empty_text=true;
//            }
            $("input#Post_post_name").val('');
            $("input#Post_id").val('');
            $('button[type="submit"]').html('<i class="icon-chevron-right icon-white">&#12288;</i> 登録');                        
        });
        
        $('button[type="submit"]').click(function(){             
			$.ajax({                 			
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/adminpost/registedit/",    
				data: jQuery('#post_form').serialize(),
				success: function(msg){       					  		
					  jQuery('#Post_post_name').prev().remove(); 
					  	if(msg!='[]'){
                                                    data=$.parseJSON(msg);
                                                    if(data.Post_post_name){
                                                         div=document.createElement('div');
                                                         $(div).addClass('alert');
                                                         $(div).addClass('error_message');
                                                         $(div).html(data.Post_post_name);
                                                         $(div).insertBefore($('#Post_post_name'));
                                                         
                                                    }                                                  
                                                    
						  
					  	}							  															
					else{  
                                            if($("#Post_id").val()!=''){
                                                if(confirm('更新します。よろしいですか？')==true){
                                                    jQuery('#post_form').attr("onsubmit","return true;");                                             
                                                    jQuery('#post_form').submit();
                                                }
                                            }
                                            else{
                                                if(confirm('登録します。よろしいですか？')==true){
                                                    jQuery('#post_form').attr("onsubmit","return true;");                                             
                                                    jQuery('#post_form').submit();
                                                }
                                            }                                            
                                        }
					  	
											    			    
				}	  
			});
			
		});
        
});
</script>
<!--<input type="hidden" id="page_count" value="<?php //echo $pages->getPageCount();?>"/>-->
<div class="wrap admin secondary post">

    <div class="container index">
        <div class="contents detail">
        	
            <div class="mainBox">
            	<div class="pageTtl">
            		<h2>役職管理</h2>
            	</div>
                <div class="box">



                <p class="descriptionTxt">役職名を入力して下さい。</p>
                <?php
                
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'post_form',                     
                    'htmlOptions' => array(                                         
                                          'class'=>'form-horizontal',
                                          'onsubmit'=>'return false;',
                                          'action'=>Yii::app()->baseUrl."/adminpost/registedit/"
                                          ),
                        ));
                    
                ?>
                      
                <?php echo $form->hiddenField($model, 'id'); ?>  
                    <div class="cnt-box">
                        <div class="baseDetailBox">
                            <div class="field attachements">
                                <div class="title">役職Data</div>
							</div>

                            <div class="control-group">
                                <label for="title" class="control-label">役職名&nbsp;
                                <span class="label label-warning">必須</span></label>
                                <div class="controls">                                    
                                    
                                    <?php echo $form->error($model, 'post_name'); ?>
                        	    <?php echo $form->textField($model, 'post_name', array('class' => 'input-xlarge')); ?>
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
		                		<th class="post">役職名</th>
		                		<th class="updown">並び替え</th>
		                		<th class="actions">編集</th>
	                		</tr>
	                	</thead>
	                	<tbody>
                                    <?php 
                                    if(isset($posts)&&is_array($posts)&&count($posts)>0){
                                            foreach ($posts as $post){
                                               
                                    ?>                                    
                                    
	                		<tr class="newgin" id="<?php echo $post['id'];?>">
                                                <td class="branch"><?php echo $post['post_name'];?></td>
                                                <td class="updown">
                                                	<a id="down-btn" href="#" class="btn down-btn">↓</a>
													<a id="up-btn" href="#" class="btn up-btn">↑</a>	
                                                  
                                                </td>
                                                <td class="actions">
                                                        <a class="btn btn-work">修正</a>
                                                        <a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->baseUrl;?>/adminpost/delete/?id=<?php echo $post['id'];?>';" class="btn btn-correct">削除</a>
                                                        
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
        <p id="page-top" style="display: none;"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
</div>

</div>

<form id="up-down" action="<?php echo Yii::app()->baseUrl."/adminpost/updown/";?>">
    <input type="hidden" name="id1" id="id1"/>
    <input type="hidden" name="id2" id="id2"/>
    <input type="hidden" name="table_name" value="post"/>
</form>