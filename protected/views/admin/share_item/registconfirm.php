<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>
<div class="wrap admin secondary share_item">

    <div class="container">
        <div class="contents confirm">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>共有事項 - 登録 確認</h2></div>
                <div class="box">
                <?php
						$form = $this->beginWidget('CActiveForm', array(
							'id' => 'share_item_form',    
							'htmlOptions' => array('enctype' => 'multipart/form-data','action'=>Yii::app()->baseUrl.'/adminshare_item/registconfirm'),
								));
				?>
						<input type="hidden" name="file_index"/>          
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
                                $attachements->registConfirm11($model, $form,'adminshare_item',$this->assetsBase);
                                $this->endWidget();
                             ?>	                        
                 		 </div>
                </div><!-- /cnt-box -->	
						<?php echo $form->hiddenField($model, 'id'); ?>  
                        <?php echo $form->hiddenField($model, 'title'); ?>  
                        <?php echo $form->hiddenField($model, 'content'); ?>  
                        <input type="hidden" name="regist" id="regist" value="1"/>
                           <?php $this->endWidget(); ?>         		
                <div class="form-last-btn">
                    <div class="btn170">
                        <button type="submit" class="btn" id="back"><i class="icon-chevron-left"></i> もどる</button> 
                        <button class="btn btn-important" type="submit" id="submit"><i class="icon-chevron-right icon-white"></i> 登録</button>
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
        <p id="page-top" style="display: none;"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div>
<script type="text/javascript">
    jQuery(function($) { 
        
        $("body").attr('id','admin');          
        $(window).on('beforeunload', function(){
            setCookie("share_item_regist_from","confirm");            
        }); 
        setCookie("share_item_regist_title",$("#Share_item_title").val());
        setCookie("share_item_regist_content",$("#Share_item_content").val());
        setCookie("share_item_regist_attachment1_checkbox_for_deleting",$("#Share_item_attachment1_checkbox_for_deleting").val());
        setCookie("share_item_regist_attachment2_checkbox_for_deleting",$("#Share_item_attachment2_checkbox_for_deleting").val());
        setCookie("share_item_regist_attachment3_checkbox_for_deleting",$("#Share_item_attachment3_checkbox_for_deleting").val());
       
        $('button#submit').click(function(){  
            deleteCookies("share_item_regist_from");
            jQuery("input#regist").val('1');            
            jQuery("form#share_item_form").submit();
        });
        $('button#back').click(function(){  
            setCookie("share_item_regist_from","confirm");   
            window.location="<?php echo Yii::app()->baseUrl;?>/adminshare_item/regist/";
        });
        $('a').click(function(){  
            
            if($(this).attr('id')==undefined){
                return;
            }
            window.location="<?php echo Yii::app()->baseUrl;?>/adminshare_item/download/?file_name="+$(this).attr('id');
        });        
    });
</script>