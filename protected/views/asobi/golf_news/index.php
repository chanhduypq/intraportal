<link href="<?php echo $this->assetsBase; ?>/css/asobi/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>
<script type="text/javascript">
    golf_news = getCookie("golf_news_regist_title");
    if (golf_news != "" && golf_news != null && golf_news != "null")
    {
        deleteCookies("golf_news_regist_from", {path: '/'});
        deleteCookies("golf_news_regist_title", {path: '/'});
        deleteCookies("golf_news_regist_content", {path: '/'});
        deleteCookies("golf_news_regist_attachment1_checkbox_for_deleting", {path: '/'});
        deleteCookies("golf_news_regist_attachment2_checkbox_for_deleting", {path: '/'});
        deleteCookies("golf_news_regist_attachment3_checkbox_for_deleting", {path: '/'});
        deleteCookies("golf_news_regist_eye_catch_checkbox_for_deleting", {path: '/'});

        golf_news_regist_category = getCookie("golf_news_regist_category_id");
        if (golf_news_regist_category != "" && golf_news_regist_category != null && golf_news_regist_category != "null")
        {
            deleteCookies("golf_news_regist_category_id", {path: '/'});
            deleteCookies("golf_news_regist_category_name", {path: '/'});
            deleteCookies("golf_news_regist_background_color", {path: '/'});
            deleteCookies("golf_news_regist_color", {path: '/'});
        }
    }

    jQuery(function($)
    {
        $('ul.yiiPager li.selected').removeClass('selected');
        $('ul.yiiPager li').removeClass('page');
        $('ul.yiiPager li').removeClass('previous');
        $('ul.yiiPager li').removeClass('next');
        $('ul.yiiPager li').removeClass('last');
        $('ul.yiiPager li').removeClass('first');
        $('ul.yiiPager li').removeClass('hidden');
        $('ul.yiiPager').removeClass('yiiPager');

        $("body").attr('id', 'asobi');
    });
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount(); ?>"/>
<div class="wrap majime secondary golf_news">
    <div class="container">
        <div class="contents index">
            <div class="mainBox detail">
                <div class="pageTtl"><h2>ゴルフもマジメ</h2><a class="btn btn-important" href="<?php echo Yii::app()->baseUrl ?>/asobi"><i class="icon-home icon-white"></i> あそびのTopへ戻る</a>
                    <?php
                    if (FunctionCommon::isPostFunction("golf_news")) {
                        ?>
                        <a class="btn btn-important" href="<?php echo Yii::app()->baseUrl ?>/asobigolf_news/regist"><i class="icon-pencil icon-white"></i> 登録</a>
                        <?php
                    }
                    ?>
                </div>
                <div class="box">




                    <div class="cnt-box">
                        <?php echo CHtml::beginForm('', 'post', array('id' => 'index_frm')); ?>
                        <table width="724" border="0" class="table list font14">
                            <thead>
                                <tr>
                                    <th class="td-picture">写真</th>
                                    <th class="td-date">日付</th>
                                    <th class="td-text">タイトル</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($golf_news != null && is_array($golf_news) && count($golf_news) > 0) {
                                    foreach ($golf_news as $golf_new) {
                                        ?>    

                                        <tr>
                                            <td class="td-picture">
                                                <?php
                                                if ($golf_new['eye_catch'] != "") {
                                                    $thumnail_file_path = FunctionCommon::getFilenameInThumnail($golf_new['eye_catch']);
                                                    $temp = explode(".", $thumnail_file_path);
                                                    $new_thumnail_file_path = $temp[0];
                                                    for ($i = 1, $n = count($temp) - 1; $i < $n; $i++) {
                                                        $new_thumnail_file_path.='.' . $temp[$i];
                                                    }
                                                    $new_thumnail_file_path.='_widget' . '.' . $temp[count($temp) - 1];
                                                    $thumnail_file_path = $new_thumnail_file_path;
                                                }
                                                if ($golf_new['eye_catch'] != "" && file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)) {
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
                                                    echo '<img style=width:'.$width.'px;height:'.$height.'px;" alt="" src="' . Yii::app()->request->baseUrl . $thumnail_file_path . '">';
                                                } else {
                                                    echo '<img width="70" height="52" alt="" src="' . $this->assetsBase . '/css/common/img/img_photo01.gif">';
                                                }
                                                ?>
                                            </td>
                                            <td class="td-date alnC txtRed"><?php echo convertDateFromDbToView($golf_new['created_date']); ?></td>
                                            <td class="td-text">
        <?php if ($golf_new['category_name'] != "") { ?>
                                                    <span style="background-color: <?php echo $golf_new['background_color']; ?>; color:<?php echo $golf_new['text_color']; ?>;" class="label"><?php echo $golf_new['category_name']; ?></span>
                                                <?php } ?>
                                                <p class="text">                                        
                                                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/asobigolf_news/detail/?id=<?php echo $golf_new['id']; ?>"><?php echo $golf_new['title']; ?></a>
                                                </p>
                                            </td>
                                        </tr>



        <?php
    }
}
?>


                            </tbody>
                        </table>
                        <div class="pagination">
<?php
$this->widget('CLinkPager', array(
    'currentPage' => $pages->getCurrentPage(),
    'itemCount' => $item_count,
    'pageSize' => $page_size,
    'maxButtonCount' => 5,
    'nextPageLabel' => 'Next',
    'prevPageLabel' => 'Prev',
    'lastPageLabel' => 'Last',
    'firstPageLabel' => 'First',
    'header' => '',
    'htmlOptions' => array('class' => 'yiiPager'),
));
?>

                        </div>
<?php echo CHtml::endForm(); ?>

                    </div>
                </div>

            </div>
        </div>
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
?>
