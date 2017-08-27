<?php

class Hobby_itdwidget extends CWidget {

    public $assets_base;

    public function init() {
        
    }

    public function run() {
        $sql = "select * from hobby_itd order by created_date desc limit 4";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $bobby = $command->queryAll();

        $urlIndex = Yii::app()->baseUrl . '/asobihobby_itd/index';
        $urlRegist = Yii::app()->baseUrl . '/asobihobby_itd/regist';
        ?>
        <div class="ttl"><h3>サークル紹介</h3>
            <?php
            if (FunctionCommon::isViewFunction("hobby_itd") == true) {
                ?>
                <a href="<?php echo $urlIndex ?>" class="middleBtn listview">一覧を見る</a>
                <?php
            } else {
                $bobby = array();
            }
            if (FunctionCommon::isPostFunction("hobby_itd") == true) {
                ?>
                <a href="<?php echo $urlRegist ?>" class="miniBtn regist02">登録</a>
            <?php } ?>
        </div>

        <div class="detailBox">
            <?php
            if (!is_null($bobby)) {
                foreach ($bobby as $object) {
                    if ($object['eye_catch'] == "") {
                        ?>
                        <p class="detail">
                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/asobihobby_itd/detail/?id=<?php echo $object['id']; ?>"><img src="<?php echo $this->assets_base; ?>/css/common/img/img_photo02.gif" /></a>
                            <span class="date"><?php echo FunctionCommon::crop(htmlspecialchars($object['title']), 9); ?></span><a href="<?php echo Yii::app()->request->baseUrl; ?>/asobihobby_itd/detail/?id=<?php echo $object['id']; ?>"><?php echo FunctionCommon::crop(FunctionCommon::url_henkan($object['content']), 52); ?></a>
                        </p>
                        <?php
                    } else {
                        echo ' <p class="detail">';
                        $host_file_attachment_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase($object['eye_catch']));

                        echo '<a style="width:105px; height:70px; float:left;"  href="' . Yii::app()->request->baseUrl . '/asobihobby_itd/detail/?id=' . $object['id'] . '">';
                        $thumnail_file_path = FunctionCommon::getFilenameInThumnail($object['eye_catch']);
                        $temp = explode(".", $thumnail_file_path);
                        $new_thumnail_file_path = $temp[0];
                        for ($i = 1, $n = count($temp) - 1; $i < $n; $i++) {
                            $new_thumnail_file_path.='.' . $temp[$i];
                        }
                        $new_thumnail_file_path.='_widget' . '.' . $temp[count($temp) - 1];
                        $thumnail_file_path = $new_thumnail_file_path;
                        if (in_array($host_file_attachment_ext, Constants::$imgExtention) && file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)) {




                            list($width, $height) = getimagesize(Yii::getPathOfAlias('webroot') . $thumnail_file_path);

                            if ($width > 104) {
                                $width = '104px';
                            } else {
                                $width.='px';
                            }
                            if ($height > 70) {
                                $height = '70px';
                            } else {
                                $height.='px';
                            }
                            echo '<img style="width:' . $width . ';height:' . $height . ';" src="' . Yii::app()->request->baseUrl . $thumnail_file_path . '"/>';



//										
                        } else {
                            echo '<img src="' . $this->assets_base . '/css/common/img/img_photo02.gif">';
                        }
                        echo '</a>';
                        ?>
                        <span class="date" style="margin-left: 5px;"><?php echo FunctionCommon::crop(htmlspecialchars($object['title']), 17); ?></span><a style="margin-left: 5px;" href="<?php echo Yii::app()->request->baseUrl; ?>/asobihobby_itd/detail/?id=<?php echo $object['id']; ?>"><?php echo FunctionCommon::crop(FunctionCommon::url_henkan($object['content']), 55); ?></a>
                    </p>
                    <?php
                }
            }
        }
        ?>

        </div>
        <?php
    }

}
