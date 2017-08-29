



<script language="javascript">
    jQuery(function($) {
        $('input[type="checkbox"]').click(function() {
            if ($(this).is(':checked')) {
                $fileInput = $(this).parent().parent().prev().find('input[type="file"]').eq(0);
                name = $fileInput.attr('name');
                id = $fileInput.attr('id');
                classAttr = $fileInput.attr('class');
                if (name == undefined) {
                    name = "";
                }
                if (id == undefined) {
                    id = "";
                }
                if (classAttr == undefined) {
                    classAttr = "";
                }
                $fileInput.replaceWith("<input type='file' name='" + name + "' id='" + id + "' class='" + classAttr + "'/>");
                //
                $node1 = $(this).parent().parent().prev().prev();
                $node1.remove();

                $('<img alt="" src="<?php echo $this->assetsBase; ?>/css/common/img/img_building.jpg">').insertBefore($(this).parent().parent().prev());
            }
        });

        $("#office_form").attr('action', '<?php echo Yii::app()->baseUrl; ?>/adminoffice/registconfirm/');

        //check back browser 	    
        branch_name = getCookie("office_regist_division_name");
        if (branch_name != null && branch_name != "null") {
            $("#Office_division_name").val(branch_name);
        }
//        else {
//
//            jQuery('#photo_error').remove();
//        }
        zipcode = getCookie("office_regist_zipcode");
        if (zipcode != null && zipcode != "null") {
            $("#Office_zipcode").val(zipcode);
        }


        address = getCookie("office_regist_address");
        if (address != null && address != "null") {
            $("#Office_address").val(address);
        }
        googlemap = getCookie("office_regist_googlemap");
        if (googlemap != null && googlemap != "null") {
            googlemap=googlemap.replace(/<br ?\/?>|_/g, '\n');
            $("#Office_googlemap").val(googlemap);
        }        
        photo_checkbox_for_deleting = getCookie("office_regist_photo_checkbox_for_deleting");

        if (photo_checkbox_for_deleting != null && photo_checkbox_for_deleting != "null") {
            if (photo_checkbox_for_deleting == '1') {
                $("#Office_photo_checkbox_for_deleting").attr('checked', true);
            }
            else {
                $("#Office_photo_checkbox_for_deleting").attr('checked', false);
            }
        }


        $("body").attr('id', 'admin');

        $('button[type="submit"]').click(function() {


            deleteCookies("office_regist_from");

            $.ajax({
                type: "POST",
                async: true,
                url: "<?php echo Yii::app()->baseUrl; ?>/adminoffice/regist/",
                data: jQuery('#office_form').serialize(),
                success: function(msg)
                {

                    jQuery('#Office_division_name').prev().remove();

                    jQuery('#Office_zipcode').prev().remove();

                    jQuery('#Office_address').prev().remove();

                    jQuery('#photo_error').remove();
                    //jQuery('#photo_error').prev().remove();

                    if (msg != '[]' | checkFile() == false)
                    {
                        data = $.parseJSON(msg);
                        if (data.Office_division_name) {
                            div = document.createElement('div');
                            $(div).addClass('alert');
                            $(div).addClass('error_message');
                            $(div).html(data.Office_division_name);
                            $(div).insertBefore($('#Office_division_name'));

                        }

                        if (data.Office_zipcode && $('#divZipcodeErr').length == 0)
                        {
                            div = document.createElement('div');
                            $(div).attr('id', 'divTitleErr');
                            $(div).addClass('alert');
                            $(div).addClass('error_message');
                            $(div).html(data.Office_zipcode);
                            $(div).insertBefore($('#Office_zipcode'));
                        }


                        if (data.Office_address && $('#divAddressErr').length == 0)
                        {
                            div = document.createElement('div');
                            $(div).attr('id', 'divContendErr');
                            $(div).addClass('alert');
                            $(div).addClass('error_message');
                            $(div).html(data.Office_address);
                            $(div).insertBefore($('#Office_address'));
                        }

                        $('html, body').animate({scrollTop: 0}, 'slow');
                    }
                    else
                    {
                        setCookie("office_regist_division_name", $("#Office_division_name").val());

                        setCookie("office_regist_zipcode", $("#Office_zipcode").val());

                        setCookie("office_regist_address", $("#Office_address").val());
                        val=$("#Office_googlemap").val();
                        val=val.replace(/\n/g, "<br/>");
                        setCookie("office_regist_googlemap", val);




                        if ($("#Office_photo_checkbox_for_deleting").is(':checked')) {

                            setCookie("office_regist_photo_checkbox_for_deleting", '1');
                        }
                        else {

                            setCookie("office_regist_photo_checkbox_for_deleting", '0');
                        }
                        jQuery('#office_form').submit();
                    }
                }
            });

        });
    });
    function checkFile() {

        var result = true;

        $("#error_message4").removeClass("alert error_message");
        $("#error_message4").html("");


        var checkBox4 = jQuery('#Office_photo_checkbox_for_deleting').is(":checked");

        //check format file

        var arr_file1 = [".jpg", ".gif", ".png", ".jpeg"];


        var attachment4 = jQuery('#Office_photo').val();

        checkFile4 = attachment4.substr(attachment4.lastIndexOf('.'));
        checkFile4 = checkFile4.toLowerCase();


        file4 = jQuery.inArray(checkFile4, arr_file1);


        if (checkBox4 == true) {
            return true;
        }
        if (checkBox4 == false && file4 == -1 && attachment4 != "")
        {
            jQuery("#error_message4").html("<?php echo Lang::MSG_0004 ?>");
            jQuery("#error_message4").addClass("cerrorMessage alert error_message");
            result = false;

        }
        return result;
    }
</script>
<div class="wrap admin secondary office">

    <div class="container index">
        <div class="contents detail regist">

            <div class="mainBox">
                <div class="pageTtl">
                    <h2>事業所管理 - 登録</h2>
                    <?php
                    if (Yii::app()->request->cookies['page'] != "") {
                        $page = "index?page=" . Yii::app()->request->cookies['page'];
                    } else {
                        $page = "";
                    }
                    ?>
                    <span><a class="btn btn-important" href="<?php echo Yii::app()->baseUrl; ?>/adminoffice/<?php echo $page; ?>"><i class="icon-chevron-left icon-white"></i> 一覧に戻る</a></span>
                </div>

                <div class="box">

                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'office_form',
                        'htmlOptions' => array(
                            'enctype' => 'multipart/form-data',
                            'class' => 'form-horizontal',
                        ),
                    ));
                    ?>	
                    <div class="cnt-box">
                        <div class="control-group">
                            <label for="name" class="control-label">事業所名&nbsp;
                                <span class="label label-warning">必須</span></label>
                            <div class="controls">	                            
                                <?php echo $form->error($model, 'division_name'); ?>
                                <?php echo $form->textField($model, 'division_name', array('class' => 'input-large')); ?>
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="zipcode" class="control-label">郵便番号&nbsp;
                                <span class="label label-warning">必須</span></label>
                            <div class="controls">
                                <?php echo $form->error($model, 'zipcode'); ?>
                                <?php echo $form->textField($model, 'zipcode', array('class' => 'input-large')); ?>
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="address" class="control-label">住所&nbsp;
                                <span class="label label-warning">必須</span></label>
                            <div class="controls">	                            
                                <?php echo $form->error($model, 'address'); ?>
                                <?php echo $form->textField($model, 'address', array('class' => 'input-xxlarge')); ?>
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="address" class="control-label">家屋写真&nbsp;</label>
                            <div class="controls">
                                <!--	                            <div class="alert error_message">エラーメッセージを表示します</div>
                                                                    <img src="../../common/img/img_building.jpg">
                                                                    <p><input type="file" size="15" name="building"></p>-->
                                <div id="error_message4"></div>                                    
                                <style>
                                    div.building_photo a{float:none !important;} 	
                                    a.a_base{float:none !important;}	
                                    img.img_base{ position:relative !important; float:none !important;}
                                </style>	                      
                                <?php
                                
                                $attachement4 = $this->beginWidget('ext.helpers.Form_new');
                                $attachement4->registOffice($model, $form, $attachment4_error, 'adminoffice', $this->assetsBase);
                                $this->endWidget();
                                ?>
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="address" class="control-label">GoogleMap</label>
                            <div class="controls">

                                <?php echo $form->error($model, 'googlemap'); ?>
                                <?php echo $form->textarea($model, 'googlemap', array('class' => 'input-xxlarge', 'rows' => 4)); ?> 
                            </div>
                        </div>
                    </div><!--// .cnt-box -->
                    <?php $this->endWidget(); ?>
                    <div class="form-last-btn">
                        <p class="btn80">
                            <button class="btn btn-important" type="submit"><i class="icon-chevron-right icon-white">&#12288;</i> 確認</button>
                        </p>
                    </div>



                </div><!-- /box -->
            </div><!-- /mainBox -->

            <div class="sideBox">
                <ul>
                    <li>
                        <?php $this->widget('MenuManager'); ?>
                        <?php $this->widget('AffairsManage'); ?>
                        <?php $this->widget('SystemManage'); ?>
                        <?php $this->widget('PostedByContentManage'); ?>
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