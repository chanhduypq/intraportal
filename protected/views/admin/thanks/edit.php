<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>


<div class="wrap admin secondary thanks">
    <div class="container">
        <div class="contents regist">        	
            <div class="mainBox detail">
            	<div class="pageTtl">
                    <h2>今日のありがとう - 修正</h2>
                    <span>
                    <?php 
					if(Yii::app()->request->cookies['page']!= "") 
					{
						   $page = "index?page=".Yii::app()->request->cookies['page'];
							
					}else {$page ="";}
					?>
                        <a class="btn btn-important" href="<?php echo Yii::app()->request->baseUrl; ?>/adminthanks/<?php echo $page;?>">
                            <i class="icon-chevron-left icon-white"></i>  一覧に戻る
                        </a>
                    </span>
                </div>
                <div class="box">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'thanks_form',                     
                    'htmlOptions' => array(
                                          'enctype' => 'multipart/form-data',
                                          'class'=>'form-horizontal',                                         
                                          ),
                        ));
                ?>
                    <?php echo $form->hiddenField($model, 'id'); ?>      
                    <input type="hidden" name="photo" id="photo" value="<?php echo $photo;?>"/>
                    <input type="hidden" name="lastname" id="lastname" value="<?php echo $lastname;?>"/>
                    <input type="hidden" name="firstname" id="firstname" value="<?php echo $firstname;?>"/>
                    <input type="hidden" name="id_unit" id="id_unit" value="<?php if(isset($id_unit)){ echo $id_unit;}?>"/>
                
                                            
                <div class="cnt-box"> 
                    <div class="control-group">
                        <label for="title" class="control-label">部署名&nbsp;
	                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	    <?php
								
                                $array_unit = array();
								foreach ($unit as $unit_name){
									   $array_unit[$unit_name['id']] = $unit_name['company_name']." ".$unit_name['branch_name']." ".$unit_name['unit_name'];
									   
								}
								echo $form->dropDownList($model,'unit_id',$array_unit, array('prompt'=>'選んで下さい','options' => array($unit_id => array('selected' => true)))); ?>  			
								
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="title" class="control-label">お名前&nbsp;
                        	<span class="label label-warning">必須</span></label>
                        <div class="controls">                        	
                                <?php 
								echo $form->dropDownList($model, 'user_id', $model->allUsers, array('options' => array($model->user_id => array('selected' => true)))); ?> 
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="content" class="control-label">コメント&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">                        	
                                <?php echo $form->textarea($model, 'comment', array('placeholder' => 'コメントを入力してください。', 'class' => 'input-xxlarge', 'rows' => 7,'maxlength' => 512)); ?>   
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="content" class="control-label">差出人&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">                        	
                                <?php echo $form->textField($model, 'sender', array('placeholder' => 'お名前を入力してください。', 'class' => 'input-xlarge')); ?>
                        </div>
                    </div>
                    
                    
                    
                    
                  
                    
                </div><!-- /cnt-box -->
                <?php $this->endWidget(); ?>
                <div class="form-last-btn">
                	<p class="btn80">
	                    <button class="btn btn-important" type="submit"><i class="icon-chevron-right icon-white">&#12288;</i>  確認</button>
                    </p>
                    
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

<script type="text/javascript">  
        jQuery(function($){ 

        $("#Thanks_unit_id").change(function() {
               
                $.ajax({    
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/adminthanks/getusers/?unit_id="+$(this).val(),    				
				success: function(msg){	 
                                     users=$.parseJSON(msg);
                                     jQuery('#Thanks_user_id').html("");
                                     jQuery('#Thanks_user_id').append("<option value=''>選んで下さい</option>");
                                    for (i = 0,n=users.length; i <n; i++) {
                                        jQuery('#Thanks_user_id').append("<option value=" + users[i].id + ">" + users[i].lastname+' '+users[i].firstname + "</option>");
                                    }    
                                }
                });
                 id_unit=$("#Thanks_unit_id").val();
                $("input#id_unit").val(id_unit);
           }); 
           $("#Thanks_user_id").change(function() {
               
                $.ajax({    
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/adminthanks/getuser/?user_id="+$(this).val(),    				
				success: function(msg){
                                      users=$.parseJSON(msg);
                                      
                                    for (i = 0,n=users.length; i <n; i++) {
                                        
                                        $("input#firstname").val(users[i].firstname);
                                        $("input#lastname").val(users[i].lastname);
                                        $("input#photo").val(users[i].photo);
                                    }   
                                     
                                }
                });
                
           }); 
           $("#thanks_form").attr('action','<?php echo Yii::app()->baseUrl;?>/adminthanks/editconfirm/');          
           sender=getCookie("thanks_edit_sender");
           if(sender!=null&&sender!="null"){
               $("#Thanks_sender").val(sender);
           }
           comment=getCookie("thanks_edit_comment");         
           if(comment!=null&&comment!="null"){
               comment1=comment.replace(/<br ?\/?>|_/g, '\n');         
               $("#Thanks_comment").val(comment1);
           }
           unit_id=getCookie("thanks_edit_unit_id");     
           if(unit_id!=null&&unit_id!="null"){
               $("#Thanks_unit_id").val(unit_id);
               user_id=getCookie("thanks_edit_user_id"); 
               $.ajax({    
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/adminthanks/getusers/?unit_id="+unit_id,    				
				success: function(msg){	 
                                     users=$.parseJSON(msg);
                                     jQuery('#Thanks_user_id').html("");
                                     jQuery('#Thanks_user_id').append("<option value=''>選んで下さい</option>");
                                    for (i = 0,n=users.length; i <n; i++) {
                                        jQuery('#Thanks_user_id').append("<option value='" + users[i].id+"'" +(users[i].id==user_id?' selected':'')+ ">" + users[i].lastname+' '+users[i].firstname + "</option>");
                                    }    
                                }
                });
                $.ajax({    
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/adminthanks/getuser/?user_id="+user_id,    				
				success: function(msg){
                                      users=$.parseJSON(msg);
                                      
                                    for (i = 0,n=users.length; i <n; i++) {
                                        
                                        $("input#firstname").val(users[i].firstname);
                                        $("input#lastname").val(users[i].lastname);
                                        $("input#photo").val(users[i].photo);
                                    }   
                                     
                                }
                });
                id_unit=$("#Thanks_unit_id").val();
                $("input#id_unit").val(id_unit);
           }
           else{
               unit_id='<?php echo $unit_id;?>';
               user_id='<?php echo $model->user_id;?>';
			   
               $.ajax({    
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/adminthanks/getusers/?unit_id="+unit_id,    				
				success: function(msg){	 
                                     users=$.parseJSON(msg);
                                     jQuery('#Thanks_user_id').html("");
                                     jQuery('#Thanks_user_id').append("<option value=''>選んで下さい</option>");
                                    for (i = 0,n=users.length; i <n; i++) {
                                        jQuery('#Thanks_user_id').append("<option value='" + users[i].id+"'" +(users[i].id==user_id?' selected':'')+ ">" + users[i].lastname+' '+users[i].firstname + "</option>");
                                    }    
                                }
                });
                $.ajax({    
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/adminthanks/getuser/?user_id="+user_id,    				
				success: function(msg){
                                      users=$.parseJSON(msg);
                                      
                                    for (i = 0,n=users.length; i <n; i++) {
                                        
                                        $("input#firstname").val(users[i].firstname);
                                        $("input#lastname").val(users[i].lastname);
                                        $("input#photo").val(users[i].photo);
                                    }   
                                     
                                }
                });
              id_unit=$("#Thanks_unit_id").val();
              $("input#id_unit").val(id_unit);
           }
           
           setCookie("thanks_edit_sender",$("#Thanks_sender").val());
           setCookie("thanks_edit_comment",comment); 
            /**
             * 
             */
           $("body").attr('id','admin');      
        
           $('button[type="submit"]').click(function(){  
			$.ajax({    
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/adminthanks/edit/?id=<?php echo $model->id;?>",    
				data: jQuery('#thanks_form').serialize(),
				success: function(msg){	                        					  		
					  jQuery('#Thanks_sender').prev().remove();                                       						                                            					  	
					  jQuery('#Thanks_comment').prev().remove();
                                          jQuery('#Thanks_unit_id').prev().remove();
                                          jQuery('#Thanks_user_id').prev().remove();
					  	if(msg!='[]'){
                                                    data=$.parseJSON(msg);
                                                    if(data.Thanks_sender){
                                                         div=document.createElement('div');
                                                         $(div).addClass('alert');
                                                         $(div).addClass('error_message');
                                                         $(div).html(data.Thanks_sender);
                                                         $(div).insertBefore($('#Thanks_sender'));
                                                         
                                                    } 
                                                    if(data.Thanks_comment){
                                                         div=document.createElement('div');
                                                         $(div).addClass('alert');
                                                         $(div).addClass('error_message');
                                                         $(div).html(data.Thanks_comment);
                                                         $(div).insertBefore($('#Thanks_comment'));                                                         
                                                    }
                                                    if(data.Thanks_unit_id){
                                                         div=document.createElement('div');
                                                         $(div).addClass('alert');
                                                         $(div).addClass('error_message');
                                                         $(div).html(data.Thanks_unit_id);
                                                         $(div).insertBefore($('#Thanks_unit_id'));                                                         
                                                    }
                                                    if(data.Thanks_user_id){
                                                         div=document.createElement('div');
                                                         $(div).addClass('alert');
                                                         $(div).addClass('error_message');
                                                         $(div).html(data.Thanks_user_id);
                                                         $(div).insertBefore($('#Thanks_user_id'));                                                         
                                                    }
                                                }							  															
					else{                                           
                                                setCookie("thanks_edit_sender",$("#Thanks_sender").val());
                                                
                                                val=$("#Thanks_comment").val();
                                                val=val.replace(/\n/g, "<br/>");
                                                setCookie("thanks_edit_comment",val);
                                                setCookie("thanks_edit_unit_id",$("#Thanks_unit_id").val());
                                                setCookie("thanks_edit_user_id",$("#Thanks_user_id").val());
                                                jQuery('#thanks_form').submit(); 
                                        }							    			    
				}	  
			});			
		});                         
        });
</script>
