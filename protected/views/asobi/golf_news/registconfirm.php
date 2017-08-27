<link href="<?php echo $this->assetsBase; ?>/css/asobi/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>





<div class="wrap majime secondary golf_news">

    <div class="container">
        <div class="contents confirm">

            <div class="mainBox detail">            	
                <div class="pageTtl"><h2>ゴルフもマジメ - 登録 確認</h2></div>
                <div class="box">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'golf_news_form',
                        'htmlOptions' => array('enctype' => 'multipart/form-data'),
                    ));
                    ?>
                    <input type="hidden" name="file_index"/>   

                    <div class="cnt-box">
                        <div class="form-horizontal">

                            <div class="control-group">
                                <div class="control-label">カテゴリー:</div>
                                <div class="controls">
                                    <p><span class="label" id="category"></span></p>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="control-label">アイキャッチ画像:</div>
                                <div class="controls">
                                    <div class="imgbox">
                                        
                                   <?php
                                    
                                    
                                    $attachements4 = $this->beginWidget('ext.helpers.Form_new');
                                $attachements4->registConfirm14($model, $form,'asobigolf_news','eye_catch',$this->assetsBase);
                                $this->endWidget();
                                    ?>

                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="control-label">タイトル:</div>
                                <div class="controls">
                                    <p><?php echo htmlspecialchars($model->title); ?></p>
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
<?php
$attachements = $this->beginWidget('ext.helpers.Form_new');
$attachements->registConfirm11($model, $form, 'asobigolf_news',$this->assetsBase);
$this->endWidget();
?>


                        </div>

                    </div><!-- /cnt-box -->	


<?php echo $form->hiddenField($model, 'title'); ?>  
                            <?php echo $form->hiddenField($model, 'content'); ?>
                            <?php echo $form->hiddenField($model, 'category_id');
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

        if ($('#Golfnews_eye_catch_checkbox_for_deleting').parent().find('a').length == 0) {

            ck = $('#Golfnews_eye_catch_checkbox_for_deleting').clone();            
            eye=$('#Golfnews_eye_catch').clone();
            $("#golf_news_form").append($(ck));
            $("#golf_news_form").append($(eye));          
            $('#Golfnews_eye_catch_checkbox_for_deleting').parent().parent().parent().remove();
        }
        

        $("body").attr('id', 'asobi');


        setCookie("golf_news_regist_title", $("#Golfnews_title").val());
        setCookie("golf_news_regist_content", $("#Golfnews_content").val());
        setCookie("golf_news_regist_category_id", $("#Golfnews_category_id").val());
        setCookie("golf_news_regist_attachment1_checkbox_for_deleting", $("#Golfnews_attachment1_checkbox_for_deleting").val());
        setCookie("golf_news_regist_attachment2_checkbox_for_deleting", $("#Golfnews_attachment2_checkbox_for_deleting").val());
        setCookie("golf_news_regist_attachment3_checkbox_for_deleting", $("#Golfnews_attachment3_checkbox_for_deleting").val());
        setCookie("golf_news_regist_eye_catch_checkbox_for_deleting", $("#Golfnews_eye_catch_checkbox_for_deleting").val());

        category_name = getCookie("golf_news_regist_category_name");
        if(category_name!=null&&category_name!="null"){
            background_color = getCookie("golf_news_regist_background_color");
            color = getCookie("golf_news_regist_color");
            $("span#category").html(category_name);
            $("span#category").css('background-color', background_color);
            $("span#category").css('color', color);
        }
        else{
            $("span#category").parent().parent().parent().remove();
        }
        



        $('button#submit').click(function() {


            jQuery("input#regist").val('1');
            jQuery("form#golf_news_form").submit();
        });
        $('button#back').click(function() {

            window.location = "<?php echo Yii::app()->baseUrl; ?>/asobigolf_news/regist/";
        });
        $('a').click(function() {

            if ($(this).attr('id') == undefined) {
                return;
            }
            window.location = "<?php echo Yii::app()->baseUrl; ?>/asobigolf_news/download/?file_name=" + $(this).attr('id');
        });


    });


</script>
<?php

function echoEmpty($has_img = FALSE) {
    if ($has_img === true) {
        echo '<img alt="" src="' . Yii::app()->baseUrl . '/css/common/img/img_photo01.jpg">';
    } else {
        echo '';
    }
}
?>