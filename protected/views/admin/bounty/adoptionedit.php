




<?php $attachment1_ext=FunctionCommon::getExtensionFile($model->attachment1);?>
<div class="wrap admin secondary bounty">
    <div class="container">
        <div class="contents index">        	
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>懸賞金付き募集コンテンツ - 採用決定修正</h2>
                <span>
					<?php if(!empty(Yii::app()->request->cookies['page'])): ?>	
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminbountyapply/subscription/?id=<?php echo Yii::app()->request->cookies['id_get']?>?page=<?php echo Yii::app()->request->cookies['page']?>" class="btn btn-important">
							<i class="icon-chevron-left icon-white"></i> 一覧に戻る
						</a>
					<?php else : ?>
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminbountyapply/subscription/?id=<?php echo Yii::app()->request->cookies['id_get']?>" class="btn btn-important">
							<i class="icon-chevron-left icon-white"></i>一覧に戻る
						</a>
					<?php endif; ?>
				</span>
                </div>
                <div class="box">
               	<?php $form = $this->beginWidget('CActiveForm', array(
						'id' => 'adoptionedit_form', 
						'focus'=>array($model,'adopted_comment'),	
						'htmlOptions' => array(
						'enctype' => 'multipart/form-data',
						'class'=>'form-horizontal',
					'onsubmit'=>'return false;',),));?>
				<?php echo $form->hiddenField($model,'id'); ?>  
				<?php echo $form->hiddenField($model,'bounty_id'); ?>  
				<?php echo $form->hiddenField($model,'applied_content'); ?> 
				<?php echo $form->hiddenField($model,'attachment1'); ?> 		
                <div class="cnt-box">
                	
                    <div class="control-group">
                        <label class="control-label" for="content">応募日時&nbsp;</label>
                        <div class="controls">
							<p>
								<?php echo FunctionCommon::formatDate($model->created_date); ?>
								&nbsp;&nbsp; 
								<?php echo FunctionCommon::formatTime($model->created_date); ?>
							</p>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label" for="content">応募内容&nbsp;</label>
                        <div class="controls">
                        	<p class="text">
								<?php echo nl2br(htmlspecialchars($model->applied_content));?>
							</p>
							<p class="file">
							<?php if(!empty($model->attachment1)): ?>
									<?php $path = Yii::app()->request->baseUrl.$model->attachment1;?>
									<?php $filename = basename($path);?>
										<?php if(!empty($filename)):?>
											<a href="<?php echo Yii::app()->request->baseUrl.$model->attachment1;?>" target="_blank">
												<span class="icon icon-file"></span>ファイル
											</a>
										<?php endif; ?> 
							<?php endif; ?> 	
							</p>	
				         </div>
                    </div>
                    
				</div>
				
                <div class="cnt-box">

                    <div class="control-group">
                        <label class="control-label" for="content">採用コメント&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
							<div id="divAdopted_commentErr" class="alert error_message">
								<?php echo Lang::MSG_0046?>
							</div>
							<?php echo $form->textarea($model,'adopted_comment', array('placeholder' => '採用コメントを入力してください。', 
								'class' => 'input-xxlarge',
								'rows' => 7,
								'maxlength' => 3000)); ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="title">応募データ公開&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	<div id="divOpentypeErr" class="alert error_message">
								<?php echo Lang::MSG_0047?>
							</div>	
							<?php echo $form->dropDownList($model,'open_type',
													Constants::$typeBountyApply,
													array('prompt' => '選んで下さい',
													'class'=>'input-medium'));?>
                        </div>
                    </div>

                </div><!-- /cnt-box -->
                <?php $this->endWidget(); ?>
                <div class="form-last-btn">
                	<p class="btn80">
	                    <button type="submit" class="btn btn-important">
							<i class="icon-chevron-right icon-white">　</i> 確認
						</button>
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
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
</div>
</div>
<!-- /wrap -->
<script type="text/javascript">
	from=getCookie("adoption_edit_form");        
	if(from=="confirm")
	{
		if(getCookie("adoption_edit_form")!=null && getCookie("adoption_edit_form")!=undefined)
	    {
			deleteCookies("adoption_edit_form");
			window.location="<?php echo Yii::app()->baseUrl;?>/adminbountyapply/adoptionedit/?id=<?php echo $model->id;?>";	
		}
	}
	
	jQuery(function($)
	{           
		   $("body").attr('id','admin');  
		   content=getCookie("adopted_edit_comment");
		   if(content!=null && content!="null")
		   {
			  content1=content.replace(/<br ?\/?>|_/g, '\n');
			  $("#Bounty_apply_adopted_comment").val(content1);
		   }
			
		   title=getCookie("adopted_edit_open_type");
		   if(title!=null && title!="null")
		   {
			  $("#Bounty_apply_open_type").val(title);
		   }
				
		   jQuery('#divAdopted_commentErr').hide(); 
		   jQuery('#divOpentypeErr').hide(); 			   
		   $('button[type="submit"]').click(function()
		   {    
			   deleteCookies("adoption_edit_form");	 
			   var adopted_comment = jQuery('#Bounty_apply_adopted_comment').val();
			   var open_type = jQuery('#Bounty_apply_open_type').val();
			  
			   var id = $('#Bounty_apply_id').val();	
			   if(!checkId(id)){}
			   
			   if(!adopted_comment)
			   {
					jQuery('#divAdopted_commentErr').show();
			   }
			   if(!open_type)
			   {
				   jQuery('#divOpentypeErr').show();
			   }
			   if(adopted_comment && open_type)
			   {
				   val=$("#Bounty_apply_adopted_comment").val();
				   val=val.replace(/\n/g, "<br/>");
                   setCookie("adopted_edit_comment",val);
				   setCookie("adopted_edit_open_type",$("#Bounty_apply_open_type").val());
				   
				   jQuery("#adoptionedit_form").attr('action','<?php echo Yii::app()->baseUrl;?>/adminbountyapply/adoptioneditconfirm');
				   jQuery('#adoptionedit_form').attr('onsubmit','return true;');
				   jQuery('#adoptionedit_form').submit();
			   }
		}); 
	});

	//Method using check id bounty_apply is exit
	function checkId(id)
	{
		$.ajax({   
			type: "POST", 
			async:true,
			url: "<?php echo Yii::app()->baseUrl;?>/adminbountyapply/checkId/",    
			data:{id:id},
			success: function(msg)
			{	        
				if(msg=='0')
				{ 
					 window.location.href="<?php echo Yii::app()->baseUrl;?>/adminbounty/index/";
				}
			}
		});
	}

</script>