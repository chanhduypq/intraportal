




<?php $attachment1_ext=FunctionCommon::getExtensionFile($model->attachment1);?>
<div class="wrap admin secondary bounty">
    <div class="container">
        <div class="contents index">
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>懸賞金付き募集コンテンツ - 採用決定修正 - 確認</h2>
				</div>
                <div class="box">
				<?php $form = $this->beginWidget('CActiveForm', array(
						'id' => 'adoptioneditconfirm_form',    
						'htmlOptions' => array(
						'class'=>'form-horizontal',
						'enctype' => 'multipart/form-data',
						'action'=>Yii::app()->baseUrl.'/adminbountyapply/adoptionaddconfirm/'),));?>
				<input type="hidden" name="edit" id="edit" value="1"/>
				<?php echo $form->hiddenField($model,'id'); ?>  
				<?php echo $form->hiddenField($model,'bounty_id'); ?>  
				<?php echo $form->hiddenField($model,'applied_content'); ?> 
				<?php echo $form->hiddenField($model,'attachment1'); ?>	
				<?php echo $form->hiddenField($model,'open_type'); ?> 
				<?php echo $form->hiddenField($model,'adopted_comment'); ?>
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
											<a href="<?php echo Yii::app()->request->baseUrl.$model->attachment1; ?>" target="_blank">
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
                        <label class="control-label" for="content">採用コメント&nbsp;</label>
                        <div class="controls">
                        	<p class="text">
								<?php echo nl2br(htmlspecialchars($model->adopted_comment));?>	
                        	</p>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="title">応募データ公開&nbsp;</label>
                        <div class="controls">
                        	<p class="subscription-publish">
								<?php echo Constants::$typeBountyApply[$model->open_type];?>
							</p>
                        </div>
                    </div>

                </div><!-- /cnt-box -->
                <?php $this->endWidget(); ?>  
                <div class="form-last-btn">
                	<p class="btn170">
	                    <button type="submit" class="btn" onclick="back();">
							<i class="icon-chevron-left"></i> もどる
						</button>
                            <button type="submit" class="btn btn-important" onclick="submit();">
							<i class="icon-chevron-right icon-white"></i>採用
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

</div><!-- /wrap -->
<script type="text/javascript"> 
	jQuery(function($) 
	{     
		$("body").attr('id','admin');    
		$(window).on('beforeunload', function()
		{
            setCookie("adoption_edit_form","confirm"); 
        }); 	
	});  
	function submit()
	{
		if(getCookie("adoption_edit_form")!=null && getCookie("adoption_edit_form")!=undefined)
		{
			deleteCookies("adoption_edit_form");
		}
        jQuery("input#edit").val('1');
        jQuery("form#adoptioneditconfirm_form").attr('action','<?php echo Yii::app()->baseUrl;?>/adminbountyapply/adoptioneditconfirm/');
        jQuery("form#adoptioneditconfirm_form").submit();
    }
	function back()
	{      
		setCookie("adoption_edit_form","confirm");   
        jQuery("input#edit").val('0');        			 
        jQuery("form#adoptioneditconfirm_form").attr('action','<?php echo Yii::app()->request->baseUrl; ?>/adminbountyapply/adoptionedit/?id=<?php echo $model->id; ?>');
        jQuery("form#adoptioneditconfirm_form").submit();
    }
</script>		