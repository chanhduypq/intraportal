

<link href="<?php echo $this->assetsBase; ?>/css/common/css/report.css" rel="stylesheet"  media="screen" />


<div class="wrap admin secondary hobby_new">
    <div class="container">
        <div class="contents edit_confirm">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>趣味・サークルの広場What'sNew - 修正 確認</h2>
				</div>
                
                <div class="box">
				<?php $form = $this->beginWidget('CActiveForm', array(
					  'id' => 'hobby_new_editconfirm',
					  'htmlOptions' => array('enctype' => 'multipart/form-data',
					  'action'=>Yii::app()->baseUrl.'/adminhobby_new/editconfirm/'),));?>
					<input type="hidden" name="file_index"/>
					<input type="hidden" name="edit" id="edit" value="1"/>
					<?php echo $form->hiddenField($model, 'id'); ?> 
					<?php echo $form->hiddenField($model, 'category_id'); ?>	
					<?php echo $form->hiddenField($model, 'title'); ?>  
					<?php echo $form->hiddenField($model, 'content'); ?> 
					<?php echo $form->hiddenField($model, 'created_date'); ?>  
                    <div class="cnt-box">
                    <div class="form-horizontal">

                        <div class="control-group">
                            <div class="control-label">カテゴリー:</div>
  							<div class="controls">
								 <?php if(!is_null($model->category_id) && !empty($model->category_id)):?>
									<?php $categories=Yii::app()->db->createCommand()
									   ->select('*')
									   ->from('category')
									   ->where("id=$model->category_id")
									   ->queryRow();?>
									<p>
										<span class="label" style="background-color:<?php echo $categories['background_color']?>; color:<?php echo $categories['text_color']?>;">
											<?php echo htmlspecialchars($categories['category_name']);?>
										</span>
									</p>
								 <?php endif; ?>	
								</div>
                        </div>
                        
                        <div class="control-group">
                            <div class="control-label">タイトル:</div>
                            <div class="controls">
                                <p>
									<?php echo htmlspecialchars($model->title);?>
								</p>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <div class="control-label">本文</div>
                            <div class="controls">
                                <p>
									<?php echo nl2br(FunctionCommon::url_henkan($model->content)); ?>	
								</p>
                            </div>
                        </div>
                        
                    </div>
  					<div class="field attachements">
					  <?php $attachements = $this->beginWidget('ext.helpers.Form_new');?>
					  <?php $attachements->editConfirm11($model, $form,'adminhobby_new',$this->assetsBase);?>
					  <?php $this->endWidget();?>
					</div>
                    
                    </div><!-- /cnt-box -->	
                  <?php $this->endWidget(); ?>  
	                <div class="form-last-btn">
	                	<div class="btn170">
		                    <button type="submit" class="btn" id="back">
								<i class="icon-chevron-left"></i> もどる
							</button>
		                    <button class="btn btn-important" id="submit" type="submit">
								<i class="icon-chevron-right icon-white"></i> 更新
							</button>
	                    </div>
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
	
	//Method using check id category
	function checkCategory(id)
	{
		$.ajax({   
			type: "POST", 
			async:true,
			url: "<?php echo Yii::app()->baseUrl;?>/adminhobby_new/checkcategory/",    
			data:{id:id},
			success: function(msg)
			{	        
				if(msg=='0')
				{ 
					window.location.href="<?php echo Yii::app()->baseUrl;?>/adminhobby_new/index";
				}
			}
		});
	}
	
	jQuery(function($) 
	 {  
			$("body").attr('id','admin');  
			setCookie("hobby_new_edit_category_id",$("#Hobby_new_category_id").val());
			setCookie("hobby_new_edit_title",$("#Hobby_new_title").val());
			setCookie("hobby_new_edit_content",$("#Hobby_new_content").val());
			setCookie("hobby_new_edit_attachment1_checkbox_for_deleting",$("#Hobby_new_attachment1_checkbox_for_deleting").val());
			setCookie("hobby_new_edit_attachment2_checkbox_for_deleting",$("#Hobby_new_attachment2_checkbox_for_deleting").val());
			setCookie("hobby_new_edit_attachment3_checkbox_for_deleting",$("#Hobby_new_attachment3_checkbox_for_deleting").val());        
		
			
        
			$(window).on('beforeunload', function()
			{
				setCookie("hobby_new_edit_form","confirm");            
				
				$.ajax({    
						type: "GET", 
						async:false,
						url: getUrl(no)


				});
			}); 
        
			$('button#submit').click(function()
			{  
				var idcat = $("#Hobby_new_category_id").val();	
				checkCategory(idcat);
		   
				
				deleteCookies("hobby_new_edit_form");
				jQuery("input#edit").val('1');            
				jQuery("form#hobby_new_editconfirm").submit();
			});
		
			$('button#back').click(function()
			{  
			
				setCookie("hobby_new_edit_form","confirm");   
				
				window.location="<?php echo Yii::app()->baseUrl;?>/adminhobby_new/edit/?id=<?php echo $model->id;?>";
			});
		
			$('a').click(function()
			{  
				
				if($(this).attr('id')==undefined)
				{
					return;
				}
				window.location="<?php echo Yii::app()->baseUrl;?>/asobihobby_new/download/?file_name="+$(this).attr('id');
			});
		
    });
	
</script>