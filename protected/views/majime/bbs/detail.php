<link href="<?php echo $this->assetsBase; ?>/css/majime/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/majime/css/bbs.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>
<script language="javascript">
jQuery(function($) {        
			$("body").attr('id','majime');      
		});
</script>
<?php $attachment1=$model->attachment1;?>
<?php $attachment2=$model->attachment2;?>
<?php $attachment3=$model->attachment3;?>
<?php $attachment1_ext=FunctionCommon::getExtensionFile($model->attachment1);?>
<?php $attachment2_ext=FunctionCommon::getExtensionFile($model->attachment2);?>
<?php $attachment3_ext=FunctionCommon::getExtensionFile($model->attachment3);?>
<div class="wrap majime secondary bbs" >
    <div class="container">
        <div class="contents detail">
            <div class="mainBox detail">
                <div class="pageTtl"><h2>ニューギン掲示板 - 詳細</h2>
                	<?php 
					if(Yii::app()->request->cookies['page']!= "") 
					{
						   $page = "index?page=".Yii::app()->request->cookies['page'];
							
					}else {$page ="";}
					?>
                    <span><a class="btn btn-important" href="<?php echo Yii::app()->request->baseUrl; ?>/majimebbs/<?php echo $page;?>"><i class="icon-chevron-left icon-white"></i> 一覧に戻る</a></span>
                    
                </div>
                <div class="box">
                    <div class="postsDate"><i class="icon-pencil"></i> 投稿日時：<span class="date"><?php echo FunctionCommon::formatDate($model->created_date); ?></span><span class="time"><?php echo FunctionCommon::formatTime($model->created_date); ?></span></div>
                    <div class="detailTtl">
                        <h3 class="ttl">
							<?php echo htmlspecialchars($model->title);?>
						</h3>
                        <p class="area">
                         	<?php 
								$arrUser = FunctionCommon::getInforUser($model->contributor_id);
								if(isset($arrUser)){ echo $arrUser; }
							?>
                        </p>
                    </div>
                   <div class="cnt-box">
					
				     		<div class="cnt-box2">
							<?php echo nl2br(FunctionCommon::url_henkan($model->content));?>	
							</div>
                            <div class="photo">
                                <div class="imgbox">                            
                                          <?php 
                                           if(trim($attachment1)!="")
                                           {
												 FunctionCommon::echoOldFile($attachment1_ext, 1, $model,"majimebbs",$this->assetsBase);	
                                           }
                                           ?>
                                </div>
                                <div class="imgbox">
                                         <?php 
                                           if(trim($attachment2)!="")
                                           {
												 FunctionCommon::echoOldFile($attachment2_ext, 2, $model,"majimebbs",$this->assetsBase);
                                           }
                                           ?>
                                </div>
                                <div class="imgbox">
                                         <?php 
                                           if(trim($attachment3)!="")
                                           {
												 FunctionCommon::echoOldFile($attachment3_ext, 3, $model,"majimebbs",$this->assetsBase);
                                               
                                           }
                                           ?>
                                </div>
                            </div>   
                      </div><!-- /cnt-box -->
                      <h4 class="ttl">
						この議題についたコメント
					 </h4>
					<?php  $i = 1;	
						   foreach ($bbs_comments as $comment) {
					?>
                    		<div class="cnt-box">
                            <span class="badge badge-inverse">
								<?php echo $i;?>
							</span>
                            <p class="comment">
								<?php echo nl2br(FunctionCommon::url_henkan($comment['content'])); ?>	
							</p>
                                                        <br/>
                                 <div class="commenter">
                                     <div class="name">
                                    <?php
                                     foreach ($user as $user_name) {
                                         if($user_name['id']== $comment['contributor_id'])
                                         {
                                            echo $user_name['lastname']." ".$user_name['firstname'];
                                         }
                                     }
                                     ?>
                                    </div>
                                     <div class="unit">
                                         <?php echo FunctionCommon::getUnitBranchBaseUser($comment['contributor_id']);?>
                                     </div>
                                    <div class="post-date">
										回答日時：<?php echo FunctionCommon::formatDate($comment['created_date']); ?>&nbsp;
												 <?php echo FunctionCommon::formatTime($comment['created_date']); ?>
									</div>
                                </div>
                            </div>
                    <?php
						    $i++;	
						   }
                    	 
					?>
					
					<?php
					$form = $this->beginWidget('CActiveForm', array(
										'id' => 'bbs_response_form',                     
										'htmlOptions' => array(
															  'class'=>'form-horizontal',
															  'onsubmit'=>'return false;',
															  ),
										 ));
					echo $form->hiddenField($model, 'id');	
					echo $form->hiddenField($model, 'contributor_id');		
					echo $form->hiddenField($model, 'last_updated_person');			
					?>
                    <div class="cnt-box">
                         <div class="control-group">
                                        <label class="control-label" for="content">コメント&nbsp;
                                        <span class="label label-warning">必須</span></label>
                                        <div class="controls">
                                            <?php echo $form->error($bbs_response, 'content'); ?>
                                            <?php echo $form->textarea($bbs_response, 'content', array('placeholder' => '内容を入力してください。', 'class' => 'input-xxlarge', 'rows' => 7)); ?>
                                        </div>
                        </div>
                    </div>
                    <div class="form-last-btn">
							<p class="btn80">
							<?php if(FunctionCommon::isPostFunction("bbs")==true) :?>
								 <button type="submit" class="btn btn-important">
									<i class="icon-pencil icon-white"></i>回答
								</button>
							 <?php else :?>
									<button disabled="disabled" type="submit" class="btn btn-important">
										<i class="icon-pencil icon-white"></i>回答
									</button>
							 <?php endif ;?>       
							</p>
                    </div>               
                    <?php $this->endWidget(); ?>    
				 
				 

                </div><!-- /box -->
            </div><!-- /mainBox -->
        </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>
    </div>
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>
</div>
<script type="text/javascript">   
        jQuery(function($){            
           $('button[type="submit"]').click(function(){  
		   
		   if(checkId(<?php echo $model->id;?>)){} 
        
			$.ajax({    
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/majimebbs/detail/?id=<?php echo $model->id;?>",    
				data: jQuery('#bbs_response_form').serialize(),
				success: function(msg){	                        
					    jQuery('#bbs_response_form input, #bbs_response_form textarea').prev().remove();
					  	if(msg!='[]'){
                                                    data=$.parseJSON(msg);
                                                    if(data.Bbs_response_content){
                                                         div=document.createElement('div');
                                                         $(div).addClass('alert');
                                                         $(div).addClass('error_message');
                                                         $(div).html(data.Bbs_response_content);
                                                         $(div).insertBefore($('#Bbs_response_content')); 
                                                    } 
					  	}							  															
					else{   
					
											$("#bbs_response_form").attr('action','<?php echo Yii::app()->baseUrl;?>/majimebbs/detail/?id=<?php echo $model->id;?>');
                                            jQuery('#bbs_response_form').attr('onsubmit','return true;');
                                            jQuery('#bbs_response_form').submit();
											
                                        }					    			    
				}	  
			});
			
		});    
           errorDivs=jQuery('div.errorMessage');
            for(i=0,n=errorDivs.length;i<n;i++){
                if(jQuery(errorDivs[i]).html()!=""){                     
                    jQuery(errorDivs[i]).addClass('alert');
                    jQuery(errorDivs[i]).addClass('error_message');
                }
            }
            
        });
		//check id
		function checkId(id)
		{
			$.ajax({   
			type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/majimebbs/checkId/",    
				data:{id:id},
				success: function(msg){	                  
					if(msg>0){ 
						window.location.href='<?php echo Yii::app()->baseUrl;?>/majimebbs';
					}
				}
			});
		}
</script>