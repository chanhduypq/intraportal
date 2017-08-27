<link href="<?php echo $this->assetsBase; ?>/css/asobi/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>
<script type="text/javascript">
    hobby_itd_regist_from = getCookie("hobby_itd_regist_title");
    if (hobby_itd_regist_from != "" || hobby_itd_regist_from == null)
    {
        deleteCookies("hobby_itd_regist_from", {path: '/'});
        deleteCookies("hobby_itd_regist_title", {path: '/'});
        deleteCookies("hobby_itd_regist_content", {path: '/'});
        deleteCookies("hobby_itd_regist_attachment1_checkbox_for_deleting", {path: '/'});
        deleteCookies("hobby_itd_regist_attachment2_checkbox_for_deleting", {path: '/'});
        deleteCookies("hobby_itd_regist_attachment3_checkbox_for_deleting", {path: '/'});
        deleteCookies("hobby_itd_regist_eye_catch_checkbox_for_deleting", {path: '/'});
    }
    jQuery(function($)
    {
        $("body").attr('id', 'asobi');
    });
</script>
<div class="wrap majime secondary hobby_itd">

    <div class="container">
        <div class="contents index">

            <div class="mainBox">
                <div class="pageTtl"><h2>趣味・サークル広場サークル紹介</h2>
                    <a href="<?php echo Yii::app()->baseUrl ?>/asobi/" class="btn btn-important"><i class="icon-home icon-white"></i> あそびのTopへ戻る</a>
                    <?php if (FunctionCommon::isPostFunction("hobby_itd") == true) {
                        ?>
                        <a href="<?php echo Yii::app()->baseUrl ?>/asobihobby_itd/regist" class="btn btn-important"><i class="icon-pencil icon-white"></i> 登録</a>
                    <?php } ?>
                </div>
                <div class="box">

                    <!--p class="descriptionTxt"></p-->
                    <?php echo CHtml::beginForm('', 'post', array('id' => 'index_frm')); ?>
                    <table width="724" border="0" class="table list font14">
                        <thead>
                            <tr>
                                <th class="td-picture">写真</th>
                                <th class="td-text">タイトル</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($hobby_itds != null && is_array($hobby_itds) && count($hobby_itds) > 0) {
                                foreach ($hobby_itds as $hobby) {
                                    ?>  
                                    <tr>
                                        <?php if ($hobby['eye_catch'] != "" && file_exists(Yii::getPathOfAlias('webroot') . $hobby['eye_catch'])) { ?>
                                            <td class="td-picture">
                                                <?php
                                                if ($hobby['eye_catch'] != "") {
                                                    $thumnail_file_path = FunctionCommon::getFilenameInThumnail($hobby['eye_catch']);
                                                    $temp = explode(".", $thumnail_file_path);
                                                    $new_thumnail_file_path = $temp[0];
                                                    for ($i = 1, $n = count($temp) - 1; $i < $n; $i++) {
                                                        $new_thumnail_file_path.='.' . $temp[$i];
                                                    }
                                                    $new_thumnail_file_path.='_widget' . '.' . $temp[count($temp) - 1];
                                                    $thumnail_file_path = $new_thumnail_file_path;
                                                }
                                                if ($hobby['eye_catch'] != "" && file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)) {
                                                    list($width_orig, $height_orig) = getimagesize(Yii::getPathOfAlias('webroot') . $thumnail_file_path);

                                                    if($width_orig>70){
                                                        $width=70;
                                                    }
                                                    else{
                                                        $width=$width_orig;
                                                    }
                                                    $height= ceil($height_orig*$width/$width_orig);
                                                    if($height>52){
                                                        $height=52;
                                                        $ratio=$width_orig/$height_orig;
                                                        $width= ceil($height*$ratio);
                                                    }
//                                                    if ($width > 70) {
//                                                        $width = '70';
//                                                    }
//
//                                                    if ($height > 52) {
//                                                        $height = '52';
//                                                    }
                                                    printf(' <a class="a_base" style="width:70px; height:52px;" rel="prettyPhoto" href="' . Yii::app()->request->baseUrl .  $hobby['eye_catch'] . '"><img style="width:' . $width . 'px;height:' . $height . 'px;" class="img_base" src="' . Yii::app()->request->baseUrl . $thumnail_file_path . '"/></a>');
                                                    
                                                } else {
                                                    echo '<img width="70" height="52" alt="" src="' . $this->assetsBase . '/css/common/img/img_photo01.gif">';
                                                }
                                                
//                                                $uploaded_file_attachment1_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase($hobby['eye_catch']));
//                                                Upload_file_common::echoEyeCatch($uploaded_file_attachment1_ext, $hobby['eye_catch'], 'index');
                                                ?>
                                            </td>
                                        <?php
                                        } else {
                                            ?>
                                            <td class="td-picture">
                                                <a><img src="<?php echo $this->assetsBase; ?>/css/common/img/img_photo01.gif" width="70" height="52" /></a>
                                            </td>
                                            <?php
                                        }
                                        ?>
                                        <td class="td-text">
                                            <p class="title"><?php echo htmlspecialchars($hobby['title']); ?></p>
                                            <p class="read"><a href="<?php echo Yii::app()->request->baseUrl; ?>/asobihobby_itd/detail/?id=<?php echo $hobby['id']; ?>"><?php echo FunctionCommon::crop(nl2br(htmlspecialchars($hobby['content'])), 65); ?></a></p>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>

                    <?php $this->widget('ext.Pagination.Base', array('CPaginationObject' => $pages)); ?>
                </div><!-- /box -->
            </div><!-- /mainBox -->

        </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->

    <div class="footer">
        <p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div><!-- /wrap -->