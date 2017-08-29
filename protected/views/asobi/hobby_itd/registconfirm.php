<link href="<?php echo $this->assetsBase; ?>/css/asobi/css/secondary.css" rel="stylesheet" type="text/css"/>




<div class="wrap majime secondary hobby_itd">
    <div class="container">
        <div class="contents confirm">
            <div class="mainBox detail">            	
                <div class="pageTtl"><h2>趣味・サークル広場　サークル紹介 - 登録 確認</h2></div>
                <div class="box">
                      <?php
						$form = $this->beginWidget('CActiveForm', array(
							'id' => 'hobby_itd_form',    
							'htmlOptions' => array('enctype' => 'multipart/form-data'),
								));
						?>
                        <?php echo $form->hiddenField($model, 'id'); ?> 
						<input type="hidden" name="file_index"/>   
                
                    <div class="cnt-box">
                    <div class="form-horizontal">
                    	
                        <div class="control-group">
                            <div class="control-label">アイキャッチ画像:</div>
                            <div class="controls">
<!--                                <div class="imgbox" style="width:228px;">-->
                                    <div class="imgbox">
                                	<?php
                                    
                                    
                                    $attachements4 = $this->beginWidget('ext.helpers.Form_new');
                                $attachements4->registConfirm14($model, $form,'asobihobby_itd','eye_catch',$this->assetsBase);
                                $this->endWidget();
                                    ?>	
                                   
                                </div>
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
                                <p>
                                    <?php  echo nl2br(FunctionCommon::url_henkan($model->content));?>
                                </p>
                            </div>
                        </div>
                        
                    </div>                   
                        <div class="field attachements">
                            <?php                    
                                $attachements = $this->beginWidget('ext.helpers.Form_new');
                                $attachements->registConfirm11($model, $form,'asobihobby_itd',$this->assetsBase);
                                $this->endWidget();
                            ?>
                  </div>
                    </div><!-- /cnt-box -->	
					<?php
					echo $form->hiddenField($model, 'title');  
					echo $form->hiddenField($model, 'content');
					?>               
                    <input type="hidden" name="regist" id="regist" value="1"/>
                    	   <?php $this->endWidget(); ?>  
	                <div class="form-last-btn">
	                	<div class="btn170">
                            <button type="submit" class="btn" id="back"><i class="icon-chevron-left"></i> もどる</button>                                    
                            <button class="btn btn-important" id="submit" type="submit"><i class="icon-chevron-right icon-white"></i> 登録</button>
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
        if ($('#Hobby_itd_eye_catch_checkbox_for_deleting').parent().find('a').length == 0) {

            ck = $('#Hobby_itd_eye_catch_checkbox_for_deleting').clone();
            eye=$('#Hobby_itd_eye_catch').clone();
            $("#hobby_itd_form").append($(ck));
            $("#hobby_itd_form").append($(eye));
            
            $('#Hobby_itd_eye_catch_checkbox_for_deleting').parent().parent().parent().remove();
        }
        
        
    
        $("body").attr('id', 'admin');
        $(window).on('beforeunload', function() {
            setCookie("base_regist_from", "confirm");
        });
        
        setCookie("hobby_itd_regist_title",$("#Hobby_itd_title").val());        
        setCookie("hobby_itd_regist_content",$("#Hobby_itd_content").val());
 
        setCookie("hobby_itd_regist_attachment1_checkbox_for_deleting",$("#Hobby_itd_attachment1_checkbox_for_deleting").val());
        setCookie("hobby_itd_regist_attachment2_checkbox_for_deleting",$("#Hobby_itd_attachment2_checkbox_for_deleting").val());
        setCookie("hobby_itd_regist_attachment3_checkbox_for_deleting",$("#Hobby_itd_attachment3_checkbox_for_deleting").val());
        setCookie("hobby_itd_regist_eye_catch_checkbox_for_deleting",$("#Hobby_itd_eye_catch_checkbox_for_deleting").val());

        $('button#submit').click(function(){  
            deleteCookies("hobby_itd_regist_from");
            jQuery("input#regist").val('1');            
            jQuery("form#hobby_itd_form").submit();
        });
        $('button#back').click(function(){  
            setCookie("hobby_itd_regist_from","confirm");   
            window.location="<?php echo Yii::app()->baseUrl;?>/asobihobby_itd/regist/";
        });
        $('a').click(function(){  
            if ($(this).attr('id') == undefined) {
                return;
            }
            window.location = "<?php echo Yii::app()->baseUrl; ?>/asobihobby_itd/download/?file_name=" + $(this).attr('id');
        });
    });
    
</script>
<?php
function echoEmpty($has_img=FALSE){
    if($has_img===true){
        echo '<img alt="" src="' . Yii::app()->baseUrl . '/css/common/img/img_photo01.jpg">';
    }
    else{
        echo '';
    }

}
?>