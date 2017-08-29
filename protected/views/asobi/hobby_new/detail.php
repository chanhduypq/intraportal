<link href="<?php echo $this->assetsBase; ?>/css/asobi/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/asobi/css/hobby_new.css" rel="stylesheet" type="text/css"/>



<script type="text/javascript">
jQuery(function($) 
{
	$("body").attr('id','asobi');      
});
</script>
<?php $attachment1=$model->attachment1;?>
<?php $attachment2=$model->attachment2;?>
<?php $attachment3=$model->attachment3;?>
<?php $attachment1_ext=FunctionCommon::getExtensionFile($model->attachment1);?>
<?php $attachment2_ext=FunctionCommon::getExtensionFile($model->attachment2);?>
<?php $attachment3_ext=FunctionCommon::getExtensionFile($model->attachment3);?>
<div class="wrap majime secondary hobby_new">

    <div class="container">
        <div class="contents detail">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>趣味・サークルの広場 What'sNew- 詳細</h2>
                 <span>
					<?php if(!empty(Yii::app()->request->cookies['page'])): ?>	
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/asobihobby_new/index?page=<?php echo Yii::app()->request->cookies['page']?>" class="btn btn-important">
							<i class="icon-chevron-left icon-white"></i> 一覧に戻る
						</a>
					<?php else : ?>
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/asobihobby_new" class="btn btn-important">
							<i class="icon-chevron-left icon-white"></i> 一覧に戻る
						</a>
					<?php endif; ?>
				</span>
                </div>
                <div class="box">
				<?php if(!is_null($model)): ?>	
        			<div class="postsDate">
						<i class="icon-pencil"></i> 投稿日時：
						<span class="date">
							<?php echo FunctionCommon::formatDate($model->created_date); ?>
						</span>
						<span class="time">
							<?php echo FunctionCommon::formatTime($model->created_date); ?>
						</span>
					</div>
                	<div class="detailTtl">
                    	<h3 class="ttl">
							<?php  echo htmlspecialchars($model->title); ?>
						</h3>
                        <p class="area">
							<?php 
								$arrUser = FunctionCommon::getInforUser($model->contributor_id);
								if(isset($arrUser)){ echo $arrUser; }
							?>
						</p>
                    </div>
					
					<div class="category">
					 <?php if(!is_null($model->category_id) && !empty($model->category_id)):?>
						 <?php $count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM category WHERE id='.$model->category_id)->queryScalar();?>
						 <?php if($count>0):?>
								<?php $category=Yii::app()->db->createCommand()
								   ->select('*')
								   ->from('category')
								   ->where("id=$model->category_id")
								   ->queryRow();?>
						<span class="label" style="background-color:<?php echo !empty($category['background_color']) ? $category['background_color'] :'' ?>; color:<?php echo !empty($category['text_color']) ? $category['text_color'] :''?>;">		   
							<?php echo htmlspecialchars($category['category_name']);?>
						</span>
						<?php endif; ?>
					<?php endif; ?>	
                    </div>
                    <p class="cnt-box">
							<?php echo nl2br(FunctionCommon::url_henkan($model->content));?>
					</p>
					<div class="photo">	
						<div class="imgbox">                            
							<?php if(!empty($attachment1)): ?>
								<?php echo FunctionCommon::echoOldFile($attachment1_ext, 1, $model,"asobihobby_new",$this->assetsBase);?>
							<?php endif; ?>
						</div>
						<div class="imgbox">
							<?php if(!empty($attachment2)): ?>
							<?php echo FunctionCommon::echoOldFile($attachment2_ext, 2, $model,"asobihobby_new",$this->assetsBase);?>
							<?php endif; ?>
						</div>
						<div class="imgbox">
							<?php if(!empty($attachment3)): ?>
							<?php echo FunctionCommon::echoOldFile($attachment3_ext, 3, $model,"asobihobby_new",$this->assetsBase);?>
							<?php endif; ?>
						</div>
					</div> 		                  
                <?php endif; ?>
                </div>
				<!-- /box -->
                <div class="box">
                	<h3>コメント</h3>
					<?php
					$form = $this->beginWidget('CActiveForm', array(
										'id' => 'hobby_new_comment_form',                     
										'htmlOptions' => array(
															  'class'=>'form-horizontal',
															  'onsubmit'=>'return false;',
															  ),
										 ));
					echo $form->hiddenField($model, 'id');			
					echo $form->hiddenField($model, 'last_updated_person');			
					?>
                    <input type="hidden" name="contributor_id" value="<?php echo Yii::app()->request->cookies['id'];?>">
                     <div class="control-group">
                                    <label class="control-label" for="title">コメント&nbsp;
                                     <span class="label label-warning">必須</span></label>
                                    <div class="controls">
                                        <?php echo $form->error($hobby_new_comment, 'comment'); ?>
                                        <?php echo $form->textarea($hobby_new_comment, 'comment', array('class' => 'input-xxlarge', 'rows' => 7)); ?>
                                    </div>
                    </div>
                    
                    <div class="form-last-btn">
                        <p class="btn170">
									<button type="submit" class="btn btn-important"><i class="icon-chevron-right icon-white">　</i> 投稿する</button>
	                    </p>
                    </div>                          
                    <?php $this->endWidget(); ?>                        
                    <h4 class="ttl">コメント履歴</h4>
					<ul class="comments">
                    	<?php
						   $i = 1;	
						   foreach ($hobby_new_list_comments as $comment) {
						?>
								<li style="margin-bottom:20px;border-bottom: 1px #CCC dashed;padding-bottom: 10px;">
                                                                    <span class="badge badge-inverse">
								<?php echo $i;?>
							</span>
                                    <p class="comment"><?php echo nl2br(FunctionCommon::url_henkan($comment['comment']));?></p>
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
										 ?></div>
                                        <div class="unit">
                                         <?php echo FunctionCommon::getUnitBranchBaseUser($comment['contributor_id']);?>
                                     </div>
                                        <div class="post-date">投稿日時：<?php echo FunctionCommon::formatDate($comment['created_date']); ?> <?php echo FunctionCommon::formatTime($comment['created_date']); ?></div>
                                    </div>
                                    
                                </li>
						<?php
								$i++;	
							   }
							 
						?>
						
                    </ul>                      
				 </div><!-- Box -->
            </div>
			<!-- /mainBox -->
            
            
        </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div>
<!-- /wrap -->
<script type="text/javascript">   
        jQuery(function($){            
           $('button[type="submit"]').click(function(){ 
		   var ok = confirm('コメントを投稿します。よろしいですか？');  
		   if(ok ==true)
		   { 
		   			checkId();
					$.ajax({    
						type: "POST", 
						async:true,
						url: "<?php echo Yii::app()->baseUrl;?>/asobihobby_new/detail/?id=<?php echo $model->id;?>",    
						data: jQuery('#hobby_new_comment_form').serialize(),
						success: function(msg){	                        
								jQuery('#hobby_new_comment_form input, #hobby_new_comment_form textarea').prev().remove();
								if(msg!='[]'){
															data=$.parseJSON(msg);
															if(data.Hobby_new_comment_comment){
																 div=document.createElement('div');
																 $(div).addClass('alert');
																 $(div).addClass('error_message');
																 $(div).html(data.Hobby_new_comment_comment);
																 $(div).insertBefore($('#Hobby_new_comment_comment')); 
															} 
								}							  															
							else{   
							
													$("#hobby_new_comment_form").attr('action','<?php echo Yii::app()->baseUrl;?>/asobihobby_new/detail/?id=<?php echo $model->id;?>');
													jQuery('#hobby_new_comment_form').attr('onsubmit','return true;');
													jQuery('#hobby_new_comment_form').submit();
													
												}					    			    
						}	  
					});
				  }	
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
		function checkId()
		{
        jQuery.ajax({   
        type: "POST", 
                async:true,
                url: "<?php echo Yii::app()->baseUrl;?>/asobihobby_new/checkId/",    
                data:{id:"<?php echo $model->id;?>",table:"hobby_new"},
                success: function(msg){	  
                        if(msg=='0'){ 
                                window.location='<?php echo Yii::app()->baseUrl;?>/asobihobby_new/index';
                        }
                }
        });
		}
</script>