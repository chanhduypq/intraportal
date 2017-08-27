<link href="<?php echo $this->assetsBase; ?>/css/majime/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>

<div class="wrap majime secondary report">
    <div class="container">
        <div class="contents confirm">
            <div class="mainBox detail">
                <div class="pageTtl">
                    <h2>リアルタイム社内報告 - 登録 確認</h2>
                </div>
                <div class="box">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'report_registconfirm',
                        'htmlOptions' => array('enctype' => 'multipart/form-data'),));
                    ?>
                    <input type="hidden" name="file_index"/>
                    <input type="hidden" name="regist" id="regist" value="1"/>
                    <?php echo $form->hiddenField($model, 'icon'); ?>  
					<?php echo $form->hiddenField($model, 'title'); ?>  
                    <?php echo $form->hiddenField($model, 'content'); ?>  
                    <div class="cnt-box">
                        <div class="form-horizontal">
                            <div class="control-group">
                                <div class="control-label">アイコン:</div>
                                <div class="controls">
                                    <?php
                                    switch ($model->icon) {
                                        case 1:
                                            echo '<div class="ico help">ホール</div>';
                                            break;
                                        case 2:
                                            echo '<div class="ico eigyou">ホール</div>';
                                            break;
                                        case 3:
                                            echo '<div class="ico uwasa">ホール</div>';
                                            break;
                                        case 4:
                                            echo '<div class="ico seizou">ホール</div>';
                                            break;
                                        case 5:
                                            echo '<div class="ico gyousei">ホール</div>';
                                            break;
                                        case 6:
                                            echo '<div class="ico hall">ホール</div>';
                                            break;
                                        case 7:
                                            echo '<div class="ico kaihatsu">ホール</div>';
                                            break;
                                        case 8:
                                            echo '<div class="ico other">ホール</div>';
                                            break;
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="control-label">タイトル:</div>
                                <div class="controls">
                                    <p>
									<?php echo htmlspecialchars($model->title); ?>
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
                            <?php $attachements = $this->beginWidget('ext.helpers.Form_new'); ?>
                            <?php $attachements->registConfirm11($model, $form, 'majimereport',$this->assetsBase); ?>
							<?php $this->endWidget(); ?>
                        </div>

                    </div><!-- /cnt-box -->	
                    <?php $this->endWidget(); ?> 
                    <div class="form-last-btn">
                        <div class="btn170">
                            <button type="submit" class="btn" id="back">
                                <i class="icon-chevron-left"></i>もどる
                            </button>
                            <button class="btn btn-important" id="submit" type="submit">
                                <i class="icon-chevron-right icon-white"></i> 登録
                            </button>
                        </div>
                    </div>
                </div><!-- /box -->
            </div><!-- /mainBox -->
        </div><!-- /contents -->
        <p id="page-top">
            <a href="#wrap">PAGE TOP</a>
        </p>

    </div><!-- /container -->

    <div class="footer">
        <p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div><!-- /wrap -->
<script type="text/javascript">

    jQuery(function($)
    {
        $("body").attr('id', 'majime');
        $(window).on('beforeunload', function()
        {
            setCookie("report_regist_form", "confirm");
        });

        setCookie("report_reg_icon", $("#Report_icon").val());
        setCookie("report_reg_title", $("#Report_title").val());
        setCookie("report_reg_content", $("#Report_content").val());
        setCookie("report_reg_attachment1_checkbox_for_deleting", $("#Report_attachment1_checkbox_for_deleting").val());
        setCookie("report_reg_attachment2_checkbox_for_deleting", $("#Report_attachment2_checkbox_for_deleting").val());
        setCookie("report_reg_attachment3_checkbox_for_deleting", $("#Report_attachment3_checkbox_for_deleting").val());
        $('button#submit').click(function()
        {
            deleteCookies("report_regist_form");
            jQuery("input#regist").val('1');
            jQuery("form#report_registconfirm").submit();
        });

        $('button#back').click(function()
        {
            setCookie("report_regist_form", "confirm");
            window.location = "<?php echo Yii::app()->baseUrl; ?>/majimereport/regist";
        });

        $('a').click(function()
        {
            if ($(this).attr('id') == undefined)
            {
                return;
            }
            window.location = "<?php echo Yii::app()->baseUrl; ?>/majimereport/download/?file_name=" + $(this).attr('id');
        });
    });
</script>