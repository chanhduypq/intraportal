<link href="<?php echo $this->assetsBase; ?>/css/common/css/pride.css" rel="stylesheet" type="text/css">
<link href="<?php echo $this->assetsBase; ?>/css/asobi/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>
<div class="wrap asobi secondary pride">

     <div class="container">
        <div class="contents confirm">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>あそびにマジメ！？あそび自慢＆対決！ - 登録 確認</h2></div>
                <div class="box">
                <?php
				$form = $this->beginWidget('CActiveForm', array(
					'id' => 'pride_form',    
					'htmlOptions' => array('enctype' => 'multipart/form-data','action'=>Yii::app()->baseUrl.'/asobipride/registconfirm'),
						));
				?> 
					<input type="hidden" name="file_index"/>
                    <div class="cnt-box">
                        <div class="form-horizontal">
                        	<div class="control-group">
                                <div class="control-label">アイコン:</div>
                                <div class="controls">
                                    <p><span class="pride-icon pride-icon-prize0<?php echo $model->icon;?>">icon0<?php echo $model->icon;?></span></p>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="control-label">タイトル:</div>
                                <div class="controls">
                                    <p><?php echo htmlspecialchars($model->title);?></p>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="control-label">本文</div>
                                <div class="controls">
                                    <p><?php echo nl2br(FunctionCommon::url_henkan($model->content));?>	</p>
                                </div>
                            </div>
                        </div>                   
                        <div class="field attachements">
						  <?php $attachements = $this->beginWidget('ext.helpers.Form_new');?>
						  <?php $attachements->registConfirm11($model, $form,'asobipride',$this->assetsBase);?>
						  <?php $this->endWidget();?>
                	  </div>
                </div><!-- /cnt-box -->	
						<?php echo $form->hiddenField($model, 'id'); ?>  
                        <?php echo $form->hiddenField($model, 'icon'); ?> 
                        <?php echo $form->hiddenField($model, 'title'); ?>  
                        <?php echo $form->hiddenField($model, 'content'); ?>  
                        <input type="hidden" name="regist" id="regist" value="1"/>
                        <?php $this->endWidget(); ?>         	
                <div class="form-last-btn">
                    <div class="btn170">
                        <button type="submit" class="btn" id="back"><i class="icon-chevron-left"></i> もどる</button> 
                        <button class="btn btn-important" type="submit"  id="submit"><i class="icon-chevron-right icon-white"></i> 登録</button>
                    </div>
                </div>

            </div><!-- /box -->
        </div><!-- /mainBox -->
            
        </div><!-- /contents -->
        <p id="page-top" style="display: none;"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div>
<script type="text/javascript">
    jQuery(function($) { 
        
        $("body").attr('id','majime');          
        $(window).on('beforeunload', function(){
            setCookie("pride_regist_from","confirm");            
        }); 
		setCookie("pride_regist_icon",$("#Pride_icon").val());
        setCookie("pride_regist_title",$("#Pride_title").val());
        setCookie("pride_regist_content",$("#Pride_content").val());
        setCookie("pride_regist_attachment1_checkbox_for_deleting",$("#Pride_attachment1_checkbox_for_deleting").val());
        setCookie("pride_regist_attachment2_checkbox_for_deleting",$("#Pride_attachment2_checkbox_for_deleting").val());
        setCookie("pride_regist_attachment3_checkbox_for_deleting",$("#Pride_attachment3_checkbox_for_deleting").val());
       
        $('button#submit').click(function(){  
            
            deleteCookies("pride_regist_from");
            jQuery("input#regist").val('1');            
            jQuery("form#pride_form").submit();
        });
        $('button#back').click(function(){  
		  	
            setCookie("pride_regist_from","confirm");   
            window.location="<?php echo Yii::app()->baseUrl;?>/asobipride/regist/";
        });
       $('a').click(function(){  
            
            if($(this).attr('id')==undefined){
                return;
            }
            window.location="<?php echo Yii::app()->baseUrl;?>/asobipride/download/?file_name="+$(this).attr('id');
        });        
    });
</script>