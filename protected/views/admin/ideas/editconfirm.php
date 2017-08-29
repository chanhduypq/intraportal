




<div class="wrap admin secondary ideas"> 

    <div class="container">
        <div class="contents confirm">

            <div class="mainBox detail">
                <div class="pageTtl"><h2>製品アイデア投稿広場 - 修正 確認</h2></div>

                <div class="box">
                        <?php
						$form = $this->beginWidget('CActiveForm', array(
							'id' => 'ideas_form',
							'htmlOptions' => array('enctype' => 'multipart/form-data', 'action' => Yii::app()->baseUrl . '/adminideas/editconfirm'),
								));
						?>
						<input type="hidden" name="file_index"/>
						<?php echo $form->hiddenField($model, 'id'); ?>   
                        <?php echo $form->hiddenField($model, 'created_date'); ?> 
                    <div class="cnt-box">
                        <div class="form-horizontal">
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
										<?php echo nl2br(FunctionCommon::url_henkan($model->content));?>
                                    </p>
                                </div>
                            </div>
                        </div>                   
                        <div class="field attachements">
                            <?php                    
                            $attachements = $this->beginWidget('ext.helpers.Form_new');
                            $attachements->editConfirm11($model, $form,'adminideas',$this->assetsBase);
                            $this->endWidget();
                            ?>
                        </div>
                    </div><!-- /cnt-box -->	
					<?php echo $form->hiddenField($model, 'title'); ?>  
                    <?php echo $form->hiddenField($model, 'content'); ?>  
                    <input type="hidden" name="edit" id="edit" value="1"/>    
					<?php $this->endWidget(); ?>                                      
                    <div class="form-last-btn">
                        <div class="btn170">
                            <button type="submit" class="btn" id="back"><i class="icon-chevron-left"></i> もどる</button>                                    
                            <button class="btn btn-important" id="submit" type="submit"><i class="icon-chevron-right icon-white"></i> 更新</button>
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
            </div>

        </div><!-- /contents -->
        <p id="page-top" style="display: none;"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->

    <div class="footer">
        <p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div>
<script type="text/javascript">
    jQuery(function($) {  
        no=1;
        function getUrl(no){
            return "<?php echo Yii::app()->baseUrl;?>/common/deletecookie/?no="+no;
        }
        $(window).on('beforeunload', function(){
            setCookie("ideas_edit_from","confirm");            
            
            $.ajax({    
                    type: "GET", 
                    async:false,
                    url: getUrl(no)
            });
        }); 
        $('button#submit').click(function(){  
            no=2;
            deleteCookies("ideas_edit_from");
            jQuery("input#edit").val('1');            
            jQuery("form#ideas_form").submit();
        });
        $('button#back').click(function(){ 
            no=2;
            setCookie("ideas_edit_from","confirm");   
            
            window.location="<?php echo Yii::app()->baseUrl;?>/adminideas/edit/?id=<?php echo $model->id;?>";
        });
        $('a').click(function(){  
            img=$(this).find('img');
           
            if(img.length==1){
                no=2;
            }
            else{ 
                no=1;

            }
            if($(this).attr('id')==undefined){
                return;
            }
			 window.location="<?php echo Yii::app()->baseUrl;?>/majimeideas/download/?file_name="+$(this).attr('id');
        });
       
        setCookie("ideas_edit_title",$("#Ideas_title").val());
        setCookie("ideas_edit_content",$("#Ideas_content").val());
        setCookie("ideas_edit_attachment1_checkbox_for_deleting",$("#Ideas_attachment1_checkbox_for_deleting").val());
        setCookie("ideas_edit_attachment2_checkbox_for_deleting",$("#Ideas_attachment2_checkbox_for_deleting").val());
        setCookie("ideas_edit_attachment3_checkbox_for_deleting",$("#Ideas_attachment3_checkbox_for_deleting").val());        
        $("body").attr('id','admin');         

    });
	function back() {
						
		jQuery("input#edit").val('0');
		jQuery("form#ideas_form").attr('action', '<?php echo Yii::app()->baseUrl; ?>/adminideas/edit/?id=<?php echo $model->id;?>');
		jQuery("form#ideas_form").submit();
	}
	function submit() {
		jQuery("input#edit").val('1');
		jQuery("form#ideas_form").attr('action', '<?php echo Yii::app()->baseUrl; ?>/adminideas/editconfirm/');
		jQuery("form#ideas_form").submit();
	}
	function downloadFile(index) {
		jQuery("input[name='file_index']").val(index);
		jQuery("form#ideas_form").attr('action', '<?php echo Yii::app()->baseUrl; ?>/adminideas/download/');
		jQuery("form#ideas_form").submit();
		jQuery("form#ideas_form").attr('action', '<?php echo Yii::app()->baseUrl; ?>/adminideas/editconfirm/');
	}
</script>