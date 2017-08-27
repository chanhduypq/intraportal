<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>

<div class="wrap admin secondary share_item"> 

    <div class="container">
        <div class="contents confirm">

            <div class="mainBox detail">
                <div class="pageTtl">
					<h2>共有事項 - 修正 確認</h2>
				</div>

                <div class="box">
                        <?php
						$form = $this->beginWidget('CActiveForm', array(
							'id' => 'share_item_form',
							'htmlOptions' => array('enctype' => 'multipart/form-data', 'action' => Yii::app()->baseUrl . '/adminshare_item/editconfirm'),
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
                            $attachements->editConfirm11($model, $form,'adminshare_item',$this->assetsBase);
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
       
        $(window).on('beforeunload', function(){
            setCookie("share_item_edit_from","confirm");            
        }); 
        $('button#submit').click(function(){  
            deleteCookies("share_item_edit_from");
            jQuery("input#edit").val('1');            
            jQuery("form#share_item_form").submit();
        });
        $('button#back').click(function(){  
            setCookie("share_item_edit_from","confirm");   
            window.location="<?php echo Yii::app()->baseUrl;?>/adminshare_item/edit/?id=<?php echo $model->id;?>";
        });
        $('a').click(function(){  
         
            if($(this).attr('id')==undefined){
                return;
            }
			 window.location="<?php echo Yii::app()->baseUrl;?>/adminshare_item/download/?file_name="+$(this).attr('id');
        });
       
        setCookie("share_item_edit_title",$("#Share_item_title").val());
        setCookie("share_item_edit_content",$("#Share_item_content").val());
        setCookie("share_item_edit_attachment1_checkbox_for_deleting",$("#Share_item_attachment1_checkbox_for_deleting").val());
        setCookie("share_item_edit_attachment2_checkbox_for_deleting",$("#Share_item_attachment2_checkbox_for_deleting").val());
        setCookie("share_item_edit_attachment3_checkbox_for_deleting",$("#Share_item_attachment3_checkbox_for_deleting").val());        
        $("body").attr('id','admin');         

    });
	
</script>