<link href="<?php echo $this->assetsBase; ?>/css/asobi/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/golf_news.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>
<script type="text/javascript">
    jQuery(function($) {
        $("body").attr('id', 'asobi');
        if($.trim($("div.picture").eq(0).html())!=""){
            $("div.picture").find('a').eq(0).css('cursor','default');
            $("div.picture").find('img').eq(0).css('cursor','pointer');
        }
    });
</script>
<div class="wrap majime secondary golf_news">
    <div class="container">
        <div class="contents detail">
            <div class="mainBox detail">
                <div class="pageTtl"><h2>ゴルフもマジメ- 詳細</h2>
                    <span><a class="btn btn-important" href="<?php echo Yii::app()->request->baseUrl; ?>/asobigolf_news/index?page=<?php echo Yii::app()->request->cookies['page']; ?>"><i class="icon-chevron-left icon-white"></i> 一覧に戻る</a></span>
                </div>
                <div class="box">
                    <div class="postsDate"><i class="icon-pencil"></i> 投稿日時：<span class="date"><?php echo convertDateFromDbToView($model->created_date); ?></span><span class="time"><?php echo convertTimeFromDbToView($model->created_date); ?></span></div>
                    <div class="detailTtl">
                        <h3 class="ttl"><?php echo $model->title; ?></h3>

                        <p class="area">
                            <?php
                            $arrUser = FunctionCommon::getInforUser($model->contributor_id);
                            if (isset($arrUser)) {
                                echo $arrUser;
                            }
                            ?>
                        </p>
                    </div>
<?php if ($category_name != "") { ?>
                        <div class="category">
                            <span style="background-color: <?php echo $background_color; ?>; color:<?php echo $text_color; ?>;" class="label"><?php echo $category_name; ?></span>
                        </div>

                        <?php
                    }
                    if ($model->eye_catch != "") {
                        echo '<div class="picture">';




                        list($width_orig, $height_orig) = getimagesize(Yii::getPathOfAlias('webroot') . $model->eye_catch);

                        if($width_orig>600){
                            $width=600;
                        }
                        else{
                            $width=$width_orig;
                        }
                        $height= ceil($height_orig*$width/$width_orig);
                        if($height>400){
                            $height=400;
                            $ratio=$width_orig/$height_orig;
                            $width= ceil($height*$ratio);
                        }
                        
//                        if ($width > 600) {
//                            $width = '600';
//                        }
//
//                        if ($height > 400) {
//                            $height = '400';
//                        }

                        printf(' <a class="a_base" style="width:'.$width.'px; height:'.$height.'px;" rel="prettyPhoto" href="' . Yii::app()->request->baseUrl . $model->eye_catch . '"><img style="width:' . $width . 'px;height:' . $height . 'px;" class="img_base" src="' . Yii::app()->request->baseUrl . $model->eye_catch . '"/></a>');

                        echo '</div>';
                    }
                    ?>

                    <p class="cnt-box">
                        <?php echo nl2br(FunctionCommon::url_henkan($model->content)); ?>	
                    </p>
                    <?php
                    $attachements = $this->beginWidget('ext.helpers.Form');
                    $attachements->detail($model, 'admingolf_news', $this->assetsBase, $edit = true);
                    $this->endWidget();
                    ?>                  

                </div><!-- Box -->
                <div class="box">
                    <h3>レスポンス</h3>
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'golf_news_comment_form',
                        'htmlOptions' => array(
                            'class' => 'form-horizontal',
                            'onsubmit' => 'return false;',
                        ),
                    ));
                    echo $form->hiddenField($model, 'id');
                    echo $form->hiddenField($model, 'last_updated_person');
                    ?>
                    <input type="hidden" name="contributor_id" value="<?php echo Yii::app()->request->cookies['id']; ?>">
                    <div class="control-group">
                        <label class="control-label" for="title">レスポンス&nbsp;
                            <span class="label label-warning">必須</span></label>
                        <div class="controls">
                            <?php echo $form->error($golf_news_comment, 'comment'); ?>
                            <?php echo $form->textarea($golf_news_comment, 'comment', array('class' => 'input-xxlarge', 'rows' => 7)); ?>
                        </div>
                    </div>

                    <div class="form-last-btn">
                        <p class="btn170">
                            <button type="submit" class="btn btn-important"><i class="icon-chevron-right icon-white">　</i> 投稿する</button>
                        </p>
                    </div>                          
                    <?php $this->endWidget(); ?>                       
                    <h4 class="ttl">レスポンス履歴</h4>
                    <ul class="comments">
                        <?php
                        $i = 1;

                        foreach ($golf_news_list_comments as $comment) {
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
                                            if ($user_name['id'] == $comment['contributor_id']) {
                                                echo $user_name['lastname'] . " " . $user_name['firstname'];
                                            }
                                        }
                                        ?>
                                    </div>
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
            </div><!-- /mainBox -->


        </div><!-- /contents -->


        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>
    </div>

    <div class="footer">
        <p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>
</div>
<?php

function convertDateFromDbToView($datetime) {
    if ($datetime == NULL || !is_string($datetime) || trim($datetime) == "") {
        return $datetime;
    }
    $date_time_array = explode(" ", $datetime);
    $date = $date_time_array[0];
    $y_m_d_array = explode("-", $date);
    return implode("/", $y_m_d_array);
}

function convertTimeFromDbToView($datetime) {
    if ($datetime == NULL || !is_string($datetime) || trim($datetime) == "") {
        return $datetime;
    }
    $date_time_array = explode(" ", $datetime);
    $time = $date_time_array[1];
    $h_m_s_array = explode(":", $time);
    return $h_m_s_array[0] . ":" . $h_m_s_array[1];
}
?>
<!-- /wrap -->
<script type="text/javascript">
    jQuery(function($) {
        $('button[type="submit"]').click(function() {
            var ok = confirm('レスポンスを投稿します。よろしいですか？');
            if (ok == true)
            {
                checkId();
                $.ajax({
                    type: "POST",
                    async: true,
                    url: "<?php echo Yii::app()->baseUrl; ?>/asobigolf_news/detail/?id=<?php echo $model->id; ?>",
                                        data: jQuery('#golf_news_comment_form').serialize(),
                                        success: function(msg) {
                                            jQuery('#golf_news_comment_form input, #golf_news_comment_form textarea').prev().remove();
                                            if (msg != '[]') {
                                                data = $.parseJSON(msg);
                                                if (data.Golf_news_comment_comment) {
                                                    div = document.createElement('div');
                                                    $(div).addClass('alert');
                                                    $(div).addClass('error_message');
                                                    $(div).html(data.Golf_news_comment_comment);
                                                    $(div).insertBefore($('#Golf_news_comment_comment'));
                                                }
                                            }
                                            else {

                                                $("#golf_news_comment_form").attr('action', '<?php echo Yii::app()->baseUrl; ?>/asobigolf_news/detail/?id=<?php echo $model->id; ?>');
                                                                            jQuery('#golf_news_comment_form').attr('onsubmit', 'return true;');
                                                                            jQuery('#golf_news_comment_form').submit();

                                                                        }
                                                                    }
                                                                });
                                                            }
                                                        });
                                                        errorDivs = jQuery('div.errorMessage');
                                                        for (i = 0, n = errorDivs.length; i < n; i++) {
                                                            if (jQuery(errorDivs[i]).html() != "") {
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
                                                            async: true,
                                                            url: "<?php echo Yii::app()->baseUrl; ?>/asobigolf_news/checkId/",
                                                            data: {id: "<?php echo $model->id; ?>", table: "golf_news"},
                                                            success: function(msg) {
                                                                if (msg == '0') {
                                                                    window.location = '<?php echo Yii::app()->baseUrl; ?>/asobigolf_news/index';
                                                                }
                                                            }
                                                        });
                                                    }
</script>