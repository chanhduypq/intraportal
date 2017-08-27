<?php

/**
 * FunctionCommon
 * Use contain function common
 * @author Hainh
 * @Company GMO Runsystem
 * @since 1.1 - 20130703
 */
class FunctionCommon {

    public static function url_henkan($mojiretu) {
        $mojiretu = htmlspecialchars($mojiretu, ENT_QUOTES);
        //$mojiretu = nl2br($mojiretu);
//文字列にURLが混じっている場合のみ下のスクリプト発動
        if (preg_match("/(http|https):\/\/[-\w\.]+(:\d+)?(\/[^\s]*)?/", $mojiretu)) {
            preg_match_all("/(http|https):\/\/[-\w\.]+(:\d+)?(\/[^\s]*)?/", $mojiretu, $pattarn);
            foreach ($pattarn[0] as $key => $val) {
                $replace[] = '<a href="' . $val . '" target="_blank">' . $val . '</a>';
            }
            $mojiretu = str_replace($pattarn[0], $replace, $mojiretu);
        }
        return $mojiretu;
    }

    /**
     * @author tuetc
     * @param type $table_name
     * @param int $id
     * @param boolean $up true:up, false:down
     * @return boolean
     */
    public static function updateDisplay_order($table_name, $id1, $id2) {
        if (!is_string($table_name) || trim($table_name) == "") {
            return FALSE;
        }
        if (!is_int((int) $id1) || !is_int((int) $id2)) {
            return FALSE;
        }

        $transction = Yii::app()->db->beginTransaction();
        $db = Yii::app()->db->createCommand();
        $display_order1 = Yii::app()->db->createCommand()->select("display_order")->from($table_name)->where("id=$id1")->queryScalar();
        $display_order2 = Yii::app()->db->createCommand()->select("display_order")->from($table_name)->where("id=$id2")->queryScalar();

        $affect1 = Yii::app()->db->createCommand("update $table_name set display_order=$display_order2 where id=$id1")->execute();
        $affect2 = Yii::app()->db->createCommand("update $table_name set display_order=$display_order1 where id=$id2")->execute();

        if ($affect1 == 1 && $affect2 == 1) {
            $transction->commit();
            return true;
        } else {
            $transction->rollback();
            return FALSE;
        }
    }

    /**
     * @author tuetc
     * @return string
     * @param string $file_name
     */
    public static function getFilenameInThumnail($file_name) {
        if ($file_name == NULL || !is_string($file_name) || trim($file_name) == "") {
            return $file_name;
        }
        $temp = explode("/", $file_name);
        $return_file_name = '';
        for ($i = 1, $n = count($temp) - 1; $i < $n; $i++) {
            $return_file_name.='/' . $temp[$i];
        }
        $return_file_name.='/thumnail';
        $return_file_name.='/' . $temp[count($temp) - 1];
        return $return_file_name;
    }

    /**
     * @author tuetc
     * @return integer
     */
    public static function getImageSizeLimit() {
        Yii::import('ext.helpers.EIniHelper');
        $ini = 'protected/config/image_store.ini';
        $array = EIniHelper::Load($ini)->Get('image');
        return intval($array['limit']);
    }

    /**
     * @author tuetc
     * @return integer
     */
    public static function getImageQuality() {
        Yii::import('ext.helpers.EIniHelper');
        $ini = 'protected/config/image_store.ini';
        $array = EIniHelper::Load($ini)->Get('image');
        return intval($array['quality_percent']);
    }

    /**
     * @author tuetc     
     * @return void
     */
    public static function compressImage() {
        $param_count = func_num_args();
        if ($param_count < 1) {
            return;
        }
        $size = self::getImageSizeLimit() * 1024;
        $quality = self::getImageQuality();
        for ($i = 0; $i < $param_count; $i++) {
            $image_path = func_get_arg($i);
            if (is_string($image_path) && trim($image_path) != "" && strlen($image_path) > 1) {
                $source_url = substr($image_path, 1);
                list($width, $height) = getimagesize($source_url);
//                if($width>800&&$height>600){ 
//                    
//                    $info = getimagesize($source_url);
//                    if ($info != FALSE) {// is image
//                        $new_width = 800;
//                        $new_height = 600;
//
//                        // Resample
//                        
//                        if ($info['mime'] == 'image/jpeg') {
//                            $image = imagecreatefromjpeg($source_url);
//                        } elseif ($info['mime'] == 'image/gif') {
//                            $image = imagecreatefromgif($source_url);
//                        } elseif ($info['mime'] == 'image/png') {
//                            $image = imagecreatefrompng($source_url);
//                        }
//                        
//                        
//                        
//                        imagecopyresampled($image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
//
//                       
//                        
//                    }
//                }
                if (filesize($source_url) > $size) {//large size
                    $destination_url = substr($image_path, 1);
                    $info = getimagesize($source_url);
                    if ($info != FALSE) {// is image
                        if ($info['mime'] == 'image/jpeg') {
                            $image = imagecreatefromjpeg($source_url);
                        } elseif ($info['mime'] == 'image/gif') {
                            $image = imagecreatefromgif($source_url);
                        } elseif ($info['mime'] == 'image/png') {
                            $image = imagecreatefrompng($source_url);
                        }
                        imagejpeg($image, $destination_url, $quality);
                    }
                }
            }
        }
    }

    /**
     * Format date from string
     * @param String $str
     * @return String date
     * @author Hainhl
     */
    public static function formatDate($str, $format = "Y/m/d") {
        if (empty($str) || trim($str) == "0000-00-00 00:00:00") {
            return " ";
        }
        $date = new DateTime($str);
        $return = $date->format($format);

        return $return;
    }

    /**
     * Format time from string
     * @param String $str
     * @return String hour,minute
     * @author Hainhl
     */
    public static function formatTime($datetime) {
        if (empty($datetime) || $datetime == "0000-00-00 00:00:00") {
            return "";
        }

        $hour = date('G', strtotime($datetime));
        $minute = date('i', strtotime($datetime));
        $second = date('s', strtotime($datetime));
        return $hour . ":" . $minute;
    }

    /**
     * Format date from string
     * @param String $str
     * @return String date
     * @author Hainhl
     */
    public static function formatDateFromString($str, $format = "Y年m月d日") {
        if ($str == "" || trim($str) == "0000-00-00 00:00:00") {
            return " ";
        }
        $date = new DateTime($str);
        $return = $date->format($format);

        return $return;
    }

    /**
     * This is method use get date time in system 
     * @return date time
     * @author Hainhl
     */
    public static function getDateTimeSys() {
        return date('Y-m-d H:i:s');
    }

    /**
     * This is check deadline in system
     * @return boollean
     * @author Hainhl
     */
    public static function checkDeadline($deadline) {
        $isdeadline = true;
        $today = date("Y/m/d");
        $today = strtotime($today);
        if (!is_null($deadline) && !empty($deadline)) {
            $deadline = strtotime(date('Y/m/d', strtotime($deadline)));
            if ($today > $deadline) {
                $isdeadline = false;
            }
        }
        return $isdeadline;
    }

    /**
     * Get Object User by employee number
     * @param employee number
     * @return object User
     * @author Hainhl
     */
    public static function getInforUser_golf_score($id) {
        $connection = Yii::app()->db;
        $command = $connection->createCommand();
        $command->select('*')->from('user')->where("id=$id");
        $user = $command->queryRow();
        return $user;
    }

    public static function getInforUser($id) {
        $connection = Yii::app()->db;
        $command = $connection->createCommand();
        $command->select('*')->from('user')->where("id=$id");
        $user = $command->queryRow();

        if ($user['division1'] != "") {
            $position = $user['division1'];
        } else if ($user['division2'] != "") {
            $position = $user['division2'];
        } else if ($user['division3'] != "") {
            $position = $user['division3'];
        } else {
            $position = $user['division4'];
        }
        $unit = Yii::app()->db->createCommand()
                ->select(array(
                    'unit.id',
                    'unit.unit_name',
                    'unit.branch_id',
                    'branch.branch_name',
                    'base.company_name'
                        )
                )
                ->from('unit')
                ->join('branch', 'branch.id=unit.branch_id')
                ->join('base', 'base.id=branch.base_id')
                ->where("unit.active_flag=1 and unit.id='" . $position . "'")
                ->queryRow();
        $last_first_name = "";
        $company_name = "";
        if (!empty($user)) {
            $last_first_name = "<span class='name'>" . $user['lastname'] . "&nbsp;" . $user['firstname'] . "</span>";
        }
        if (!empty($unit)) {
            $company_name = "<span class='city'>" . htmlspecialchars($unit['company_name']) . "&nbsp;" . htmlspecialchars($unit['branch_name']) . "&nbsp;" . htmlspecialchars($unit['unit_name']) . "&nbsp;:&nbsp;</span>";
        }
        return $company_name . $last_first_name;
    }
    public static function getUnitBranchBaseUser($id) {
        $connection = Yii::app()->db;
        $command = $connection->createCommand();
        $command->select('*')->from('user')->where("id=$id");
        $user = $command->queryRow();

        if ($user['division1'] != "") {
            $position = $user['division1'];
        } else if ($user['division2'] != "") {
            $position = $user['division2'];
        } else if ($user['division3'] != "") {
            $position = $user['division3'];
        } else {
            $position = $user['division4'];
        }
        if($position==""){
            return "";
        }
        $unit = Yii::app()->db->createCommand()
                ->select(array(
                    'unit.id',
                    'unit.unit_name',
                    'unit.branch_id',
                    'branch.branch_name',
                    'base.company_name'
                        )
                )
                ->from('unit')
                ->join('branch', 'branch.id=unit.branch_id')
                ->join('base', 'base.id=branch.base_id')
                ->where("unit.active_flag=1 and unit.id='" . $position . "'")
                ->queryRow();
        
        $company_name = "";
        
        if (is_array($unit)&&count($unit)>0) {
            $company_name = htmlspecialchars($unit['company_name']) . "&nbsp;" . htmlspecialchars($unit['branch_name']) . "&nbsp;" . htmlspecialchars($unit['unit_name']) . "&nbsp;";
        }
        return $company_name ;
    }

    /**
     * Get Object Base by employee number
     * @param employee number
     * @return object User
     * @author Hainhl
     */
    public function getInforBase($id) {
        $array = array();
        $connection = Yii::app()->db;
        $command = $connection->createCommand();
        $user = FunctionCommon::getInforUser($id);

        if (!is_null($user)) {
            $baseList = isset($user['base_list']) ? $user['base_list'] : '';
            if (!empty($baseList)) {
                $baseId = explode(",", $user['base_list']);
                foreach ($baseId as $base => $id) {
                    $command->select('*')->from('base')->where('id=:id', array(':id' => $id));
                    $base = $command->queryAll();
                    array_push($array, isset($base[0]['branch_name']) ? $base[0]['branch_name'] : '');
                }
            }
        }
        if (count($array) > 0) {
            $str = implode('、', $array);
        } else {
            $str = implode('', $array);
        }
        return $str;
    }

    /**
     * @this is method process Attachments
     * @param SubClass of CActiveRecord
     * @return void
     * @author tuetc
     */
    public function processAttachments($model) {

        if ($file = CUploadedFile::getInstance($model, 'attachment1')) {
            $file_name = $file->name;
            $model->attachment1_file_name = $file->name;
            $model->attachment1_file_bytes = base64_encode(file_get_contents($file->tempName));
            $model->attachment1_file_type = $file->type;
        } else {
            $model->attachment1_file_name = "";
        }

        if ($file = CUploadedFile::getInstance($model, 'attachment2')) {
            $file_name = $file->name;
            $model->attachment2_file_name = $file->name;
            $model->attachment2_file_bytes = base64_encode(file_get_contents($file->tempName));
            $model->attachment2_file_type = $file->type;
        } else {
            $model->attachment2_file_name = "";
        }

        if ($file = CUploadedFile::getInstance($model, 'attachment3')) {
            $file_name = $file->name;
            $model->attachment3_file_name = $file->name;
            $model->attachment3_file_bytes = base64_encode(file_get_contents($file->tempName));
            $model->attachment3_file_type = $file->type;
        } else {
            $model->attachment3_file_name = "";
        }
    }

    /**
     * @this is method use get extension file 
     * @param model
     * @return 
     * @author Hainhl
     */
    public static function getExtensionFile($attachment_file_name) {
        $attachment = $attachment_file_name;
        if (!empty($attachment)) {
            $attachmentExt = "";
            if ($attachment != NULL && !empty($attachment)) {
                $temp = explode(".", $attachment);
                $attachmentExt = $temp[count($temp) - 1];
                $attachmentExt = strtolower($attachmentExt);
            }
            return $attachmentExt;
        } else {
            return '';
        }
    }

    /**
     * @this is method use remove white space fimne name
     * @param model
     * @return 
     * @author Tuect
     */
    public static function fixFileName($fileName) {
        if (!empty($fileName)) {
            $fileName = str_replace("%", "", $fileName);
            $fileName = str_replace(" ", "_", $fileName);
        }
        return $fileName;
    }

    /**
     * @this is echo img_photo01.jpg
     * @param model
     * @return 
     * @author Baodt
     */
    public static function echoEmpty($assetsBase) {

        echo '<img alt="" src="' . $assetsBase . '/css/common/img/img_photo01.jpg">';
    }

    /**
     * @this is get name file database
     * @param model
     * @return 
     * @author Baodt
     * date: 11/07/2013
     */
    public function GetNamefile($content, $start, $end) {
        $r = explode($start, $content);
        if (isset($r[1])) {
            $r = explode($end, $r[1]);
            return $r[0];
        }
        return '';
    }

    /**
     * @this is get file Old
     * @param model
     * @return 
     * @author Baodt
     * date: 11/07/2013
     */
    public static function echoOldFile($host_file_attachment_ext, $order_index, $model, $url, $assetsBase, $edit = false) {
        $cookie_name = 'file_' . strtolower(get_class($model)) . '_edit_attachment' . $order_index;        
        $attachment = "";
        $path_attachment = 'attachment';
        $myclass = get_class($model);
        if ($order_index == 0) {
            $attachment = $model->attachment;
        }
        if ($order_index == 1) {
            $attachment = $model->attachment1;
        } else if ($order_index == 2) {
            $attachment = $model->attachment2;
        } elseif ($order_index == 3) {
            $attachment = $model->attachment3;
        } elseif ($order_index == 4) {
            if ($myclass == "Base" || $myclass == 'User') {
                $attachment = $model->photo;
            } else if ($myclass == "Hobby_itd" || $myclass == 'Golfnews') {
                $attachment = $model->eye_catch;
            }
        } elseif ($order_index == 5 && $myclass == "Bounty_apply") {
            //$order_index=1;
            $attachment = $model->attachment1;
        }
        
        if (!file_exists(Yii::getPathOfAlias('webroot') . $attachment)) {
            if ($myclass == 'Base' && $order_index == 4) {
                echo '<img alt="" src="' . $assetsBase . '/css/common/img/img_building.jpg">';
            } else if ($myclass == 'User') {
                echo '<img alt="" src="' . $assetsBase . '/css/common/img/img_dummyman.jpg">';
            } else {
                echo '<img alt="" src="' . $assetsBase . '/css/common/img/img_photo01.jpg">';
            }
            return;
        }



        if (in_array($host_file_attachment_ext, Constants::$imgExtention)) {
            //resize images before view confirm

            $filename = ltrim($attachment, '/');
            $thumnail_file_path = FunctionCommon::getFilenameInThumnail($attachment);
            if (!file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)) {
                if ($myclass == 'Base' && $order_index == 4) {
                    echo '<img alt="" src="' . $assetsBase . '/css/common/img/img_building.jpg">';
                } else if ($myclass == 'User') {
                    echo '<img alt="" src="' . $assetsBase . '/css/common/img/img_dummyman.jpg">';
                } else {
                    echo '<img alt="" src="' . $assetsBase . '/css/common/img/img_photo01.jpg">';
                }
                return;
            }
            $thumnail_file_path = ltrim($thumnail_file_path, '/');
            list($width, $height) = getimagesize($thumnail_file_path);
            if($myclass=='User'){                
                $imgbinary = fread(fopen($thumnail_file_path, "r"), filesize($thumnail_file_path));
                $img_str = base64_encode($imgbinary);
                echo '<a ondragstart="return false;" ondrop="return false;" style="width:228px; height:171px;  position: relative; float:left" id="demo" href="'.Yii::app()->request->baseUrl . '/' . $filename.'" rel="prettyPhoto">';    
                if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {                    
                    echo '<img src="'.Yii::app()->request->baseUrl . '/' . $filename.'" style="display:none;"/>';
                    echo '<img style="width:' . $width . 'px;height:' . $height . 'px;" class="img_base" style="float:left; position: absolute; top: 0;" id="not_download" src="'.Yii::app()->request->baseUrl . '/' . $thumnail_file_path.'" style="width:228px; height:171px;"/>';
                    if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.') == false) { 
                        echo '<img src="data:image/jpg;base64,'.$img_str.'" style="display:none;"/>';
                    }
                    

                }
                else{
                    $imgbinary1 = fread(fopen($filename, "r"), filesize($filename));
                    $img_str1 = base64_encode($imgbinary1);
                    echo '<img src="data:image/jpg;base64,'.$img_str1.'" style="display:none;"/>';
                    echo '<img style="width:' . $width . 'px;height:' . $height . 'px;" class="img_base" style="float:left; position: absolute; top: 0;" id="not_download" src="data:image/jpg;base64,'.$img_str.'" style="width:228px; height:171px;"/>';
                }
                
                echo '</a>';
            }
            else{
                printf(' <a  style="width:228px; height:171px;  position: relative; float:left" rel="prettyPhoto" href="' . Yii::app()->request->baseUrl . '/' . $filename . '"><img style="width:' . $width . 'px;height:' . $height . 'px;" class="img_base" style="float:left; position: absolute; top: 0;" src="' . Yii::app()->request->baseUrl . '/' . $thumnail_file_path . '"/></a>');
            }

//            $image_p = imagecreatetruecolor($width, $height);
//            if ($host_file_attachment_ext == 'jpg' || $host_file_attachment_ext == 'jpeg') {
//                $image = imagecreatefromjpeg($filename);
//            } else if ($host_file_attachment_ext == 'png') {
//                $image = imagecreatefrompng($filename);
//            } else if ($host_file_attachment_ext == 'gif') {
//                $image = imagecreatefromgif($filename);
//            }
           
//            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
//            ob_start();
//            if ($host_file_attachment_ext == 'jpg' || $host_file_attachment_ext == 'jpeg') {
//                imagejpeg($image_p, null, 100);
//            } else if ($host_file_attachment_ext == 'png') {
//                $new_image = imagecreatetruecolor($width, $height); // new wigth and height
//                imagealphablending($new_image, false);
//                imagesavealpha($new_image, true);
//                imagecopyresampled($new_image, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));
//                $image = $new_image;
//                imagealphablending($image, false);
//                imagesavealpha($image, true);
//                imagepng($image);
//            } else if ($host_file_attachment_ext == 'gif') {
//                imagegif($image_p, null, 100);
//            }
            

            //imagedestroy($image_p);
            ?>


        <?php
        } else {
            if ($edit == true && Yii::app()->request->cookies[$cookie_name] != "" && Yii::app()->request->cookies[$cookie_name] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_name]->value)) {
                $url = substr($url, 5);
                $asobi_array = array('golf_news', 'hobby_itd', 'hobby_new', 'pride');
                $url1 = '';
                if (in_array($url, $asobi_array)) {
                    $url1.='asobi';
                } else {
                    $url1.='majime';
                }
                $url1.=$url;
                ?>
                <a style="width:228px; float:left; cursor: pointer;" href="<?php echo Yii::app()->request->baseUrl; ?>/<?php echo $url1; ?>/download/?file_name=<?php echo Yii::app()->request->cookies[$cookie_name]->value; ?>">
            <?php
            } else {
                ?>
                    <a style="width:228px; float:left; cursor: pointer;" href="<?php echo Yii::app()->request->baseUrl; ?>/<?php echo $url ?>/download<?php if ($edit == true) echo 'edit'; ?>/?id=<?php echo $model->id . "&" . $order_index; ?>">
            <?php } ?>
                    <img src="<?php echo $assetsBase; ?>/css/common/img/<?php
            if ($host_file_attachment_ext == 'pdf')
                echo 'img_pdf.gif';
            else if (in_array($host_file_attachment_ext, Constants::$zipExtention))
                echo 'img_zip.gif';
            else if (in_array($host_file_attachment_ext, Constants::$excelExtention))
                echo 'img_excel.gif';
            else if (in_array($host_file_attachment_ext, Constants::$wordExtention))
                echo 'img_word.gif';
            else if (in_array($host_file_attachment_ext, Constants::$powerpointExtention))
                echo 'img_ppt.gif';
            ?>"/>

                </a>

            <?php
        }
    }

    /**
     * @this is get file Old
     * @param model
     * @return 
     * @author Baodt
     * date: 11/07/2013
     */
    public function echoNewFile($uploaded_file_attachment_ext, $order_index, $model) {
        $attachment_file_name = "";
        switch ($order_index) {
            case 1:
                $attachment_file_name = $model->attachment1_file_name;
                $attachment_file_bytes = $model->attachment1_file_bytes;
                break;
            case 2:
                $attachment_file_name = $model->attachment2_file_name;
                $attachment_file_bytes = $model->attachment2_file_bytes;
                break;
            case 3:
                $attachment_file_name = $model->attachment3_file_name;
                $attachment_file_bytes = $model->attachment3_file_bytes;
                break;
            case 4:
                $myclass = get_class($model);
                if ($myclass == "Base") {
                    $attachment_file_name = $model->attachment4_file_name;
                    $attachment_file_bytes = $model->attachment4_file_bytes;
                }
                break;
        }


        if (in_array($uploaded_file_attachment_ext, Constants::$imgExtention)) {
            $filename = "data:image/" . $uploaded_file_attachment_ext . ";base64," . $attachment_file_bytes . "";
            $width = Config::IMG_WIDTH;
            $height = 671;
            list($width_orig, $height_orig) = getimagesize($filename);
            $ratio_orig = $width_orig / $height_orig;
            if ($width / $height > $ratio_orig) {
                $width = $height * $ratio_orig;
            } else {
                $height = $width / $ratio_orig;
            }
            $image_p = imagecreatetruecolor($width, $height);
            if ($uploaded_file_attachment_ext == 'jpg' || $uploaded_file_attachment_ext == 'jpeg') {
                $image = imagecreatefromjpeg($filename);
            } else if ($uploaded_file_attachment_ext == 'png') {
                $image = imagecreatefrompng($filename);
            } else if ($uploaded_file_attachment_ext == 'gif') {
                $image = imagecreatefromgif($filename);
            }
            ?>
                <?php
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                ob_start();
                if ($uploaded_file_attachment_ext == 'jpg' || $uploaded_file_attachment_ext == 'jpeg') {
                    imagejpeg($image_p, null, 100);
                } else if ($uploaded_file_attachment_ext == 'png') {
                    $new_image = imagecreatetruecolor($width, $height);
                    imagealphablending($new_image, false);
                    imagesavealpha($new_image, true);
                    imagecopyresampled($new_image, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));
                    $image = $new_image;
                    imagealphablending($image, false);
                    imagesavealpha($image, true);
                    imagepng($image);
                } else if ($uploaded_file_attachment_ext == 'gif') {
                    imagegif($image_p, null, 100);
                }
                printf(' <a style="width:228px; height:171px; float:left; position: relative;" rel="prettyPhoto" href="data:image/jpeg;base64,%1$s"><img style="float:left; position: absolute; top: 0;" src="data:image/jpeg;base64,%1$s"/></a>', base64_encode(ob_get_clean()));

                imagedestroy($image_p);
                ?>
                <br />
                <span style="width:228px; float:left;">
                <?php echo $attachment_file_name ?>
                </span>
            <?php } else { ?>

                <a style="width:228px; float:left; cursor: pointer;" onclick="downloadFile(<?php echo $order_index; ?>);">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/css/common/img/<?php
                if ($uploaded_file_attachment_ext == 'pdf')
                    echo 'img_pdf.gif';
                else if (in_array($uploaded_file_attachment_ext, Constants::$zipExtention))
                    echo 'img_zip.gif';
                else if (in_array($uploaded_file_attachment_ext, Constants::$excelExtention))
                    echo 'img_excel.gif';
                else if (in_array($uploaded_file_attachment_ext, Constants::$wordExtention))
                    echo 'img_word.gif';
                else if (in_array($uploaded_file_attachment_ext, Constants::$powerpointExtention))
                    echo 'img_ppt.gif';
                ?>"/>
                </a>
                <br />
                <span style="width:228px; float:left;">
                <?php echo $attachment_file_name ?>
                </span>
                <?php
            }
        }

        /**
         * @this is crop text
         * @param model
         * @return 
         * @author Baodt
         * date: 24/07/2013
         */
        public static function crop($text, $len) {
            $arr_replace = array("<p>", "</p>", "<b>", "</b>", "<br>", "<br />", "");
            $text = str_replace($arr_replace, "", $text);
            if ($len > strlen(utf8_decode($text))) {
                $string = $text;
            } else {
                $string_cop = mb_substr($text, 0, $len, 'UTF-8');
                $string = $string_cop . "...";
            }
            return $string;
        }

        /**
         * @This is method get employee_number wehen user login
         * @param 
         * @return employee_number
         * @author Hainhl
         */
        public static function getEmplNum() {
            return is_numeric(Yii::app()->user->name) ? Yii::app()->user->name : '';
        }

        /**
         * @This is method to check role 
         * @param 
         * @return boolean
         * @author Haipt
         */
        public static function isAdmin($bounty = null) {
            if (Yii::app()->request->cookies['id'] != "" && isset(Yii::app()->request->cookies['id'])) {
                $userId = Yii::app()->request->cookies->contains('id') ? Yii::app()->request->cookies['id']->value : '';
                if (!empty($userId)) {
                    $user = User::model()->findByPk($userId);
                    $role_id = $user->role_id;
                    $connection = Yii::app()->db;
                    $command = $connection->createCommand();
                    $command->select('controller');
                    $command->from(' functions f');
                    $command->join('role_management r', 'r.function_id=f.id');
                    $command->where("r.role_id=$role_id AND r.baserole_id=" . Constants::$baserole['admin']);

                    $role = $command->queryColumn();
                    if ($bounty != NULL && $bounty == true) {
                        if (is_array($role) && count($role) > 0) {
                            foreach ($role as $temp) {
                                if ($temp == 'bounty') {
                                    $role[] = 'bountyapply';
                                }
                            }
                        }
                    }

                    $function_name = Yii::app()->controller->id;
                    $pos = strpos($function_name, "admin");
                    if ($pos !== false && $function_name != "admin") {
                        $name = str_replace("admin", "", $function_name);
                        if (in_array($name, $role)) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        if ($function_name == "admin") {
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
                return false;
            }
        }

        /**
         * @This is method to check view
         * @param name of controller
         * @return boolean
         * @author Haipt
         */
        public static function isViewFunction($function_name) {
            if (Yii::app()->request->cookies['id'] != "" && isset(Yii::app()->request->cookies['id'])) {
                $userId = Yii::app()->request->cookies['id']->value;
                $user = User::model()->findByPk($userId);
                $role_id = $user->role_id;
                $connection = Yii::app()->db;
                $command = $connection->createCommand();
                $command->select('controller');
                $command->from(' functions f');
                $command->join('role_management r', 'r.function_id=f.id');
                $command->where("r.role_id=$role_id AND r.baserole_id=" . Constants::$baserole['view']);
                $role = $command->queryColumn();
                if (in_array($function_name, $role)) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        /**
         * @This is method to check post
         * @param name of controller
         * @return boolean
         * @author Haipt
         */
        public static function isPostFunction($function_name) {
            if (Yii::app()->request->cookies['id'] != "" && isset(Yii::app()->request->cookies['id'])) {
                $userId = Yii::app()->request->cookies['id']->value;
                $user = User::model()->findByPk($userId);
                $role_id = $user->role_id;
                $connection = Yii::app()->db;
                $command = $connection->createCommand();
                $command->select('controller');
                $command->from(' functions f');
                $command->join('role_management r', 'r.function_id=f.id');
                $command->where("r.role_id=$role_id AND r.baserole_id=" . Constants::$baserole['post']);
                $role = $command->queryColumn();
                if (in_array($function_name, $role)) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        /**
         * @This is method to get list function
         * @param name of controller
         * @return array 
         * @author Haipt
         */
        public static function isAdminFunction($function_name) {
            if (Yii::app()->request->cookies['id'] != "" && isset(Yii::app()->request->cookies['id'])) {
                $userId = Yii::app()->request->cookies['id']->value;
                $user = User::model()->findByPk($userId);
                $role_id = $user->role_id;
                $connection = Yii::app()->db;
                $command = $connection->createCommand();
                $command->select('controller');
                $command->from(' functions f');
                $command->join('role_management r', 'r.function_id=f.id');
                $command->where("r.role_id=$role_id AND (r.baserole_id=" . Constants::$baserole['admin'] . " OR r.baserole_id=" . Constants::$baserole['post'] . ")");
                $role = $command->queryColumn();
                if (in_array($function_name, $role)) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        /**
         * @This is method to get list function
         * @param name of controller
         * @return Contributor_id 
         * @author Baodt
         */
        public static function isContributorFunction($function_name) {
            if (Yii::app()->request->cookies['id'] != "" && isset(Yii::app()->request->cookies['id'])) {
                if (isset($_GET["id"])) {
                    if ($function_name != 'role' || $function_name != 'user') {
                        $role = Yii::app()->db->createCommand("select * from " . $function_name . " where contributor_id = " . Yii::app()->request->cookies['id']->value)->queryAll();

                        foreach ($role as $id_r) {
                            if ($id_r["id"] != "" && isset($_GET["id"])) {
                                if ($id_r["id"] == $_GET["id"]) {
                                    return true;
                                }
                            }
                        }
                    } else if ($function_name == 'role' || $function_name == 'user') {
                        return false;
                    }
                } else {
                    return true;
                }
            }
        }

    }
    