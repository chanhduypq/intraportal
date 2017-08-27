<?php

class Upload_file_common {
    public static function echoOfficePhoto($path, $for_detail) {
        $attachment = $path;
        if (!file_exists(Yii::getPathOfAlias('webroot') . $attachment)) {
            echo '';
            return;
        }
        $filename = ltrim($attachment, '/');

        $thumnail_file_path = FunctionCommon::getFilenameInThumnail($attachment);
        $thumnail_file_path = ltrim($thumnail_file_path, '/');
        if ($for_detail == 'detail') {
            $height = 400;
            $width = 600;
        } else if ($for_detail == 'index') {
            $height = 52;
            $width = 69;
        } else {
            $height = 171;
            $width = Config::IMG_WIDTH;
        }

        if ($for_detail == 'detail') {
            printf(' <a class="a_base" style="width:600px; height:400px;" rel="prettyPhoto" href="' . Yii::app()->request->baseUrl . '/' . $filename . '"><img class="img_base" style="float:left; position: absolute; top: 0;" src="' . Yii::app()->request->baseUrl . '/' . $thumnail_file_path . '"/></a>');
        } else if ($for_detail == 'index') {
            printf(' <a class="a_base" style="width:70px; height:52px;" rel="prettyPhoto" href="' . Yii::app()->request->baseUrl . '/' . $filename . '"><img class="img_base" style="float:left; position: absolute; top: 0;" src="' . Yii::app()->request->baseUrl . '/' . $thumnail_file_path . '"/></a>');
        } else {
            printf(' <a class="a_base" style="width:228px; height:171px; float:left; position: relative;" rel="prettyPhoto" href="' . Yii::app()->request->baseUrl . '/' . $filename . '"><img class="img_base" style="float:left; position: absolute; top: 0;" src="' . Yii::app()->request->baseUrl . '/' . $thumnail_file_path . '"/></a>');
        }
    }

    public static function echoEyeCatch($host_file_attachment_ext, $path, $for_detail) {
        $attachment = $path;
        if (!file_exists(Yii::getPathOfAlias('webroot') . $attachment)) {
            echo '';
            return;
        }
        if (in_array($host_file_attachment_ext, Constants::$imgExtention)) {

            $filename = ltrim($attachment, '/');

            $thumnail_file_path = FunctionCommon::getFilenameInThumnail($attachment);
            $thumnail_file_path = ltrim($thumnail_file_path, '/');
            if ($for_detail == 'detail') {
                $height = 400;
                $width = 600;
            } else if ($for_detail == 'index') {
                $height = 52;
                $width = 69;
            } else {
                $height = 171;
                $width = Config::IMG_WIDTH;
            }

            if ($for_detail == 'detail') {
                printf(' <a class="a_base" style="width:600px; height:400px;" rel="prettyPhoto" href="' . Yii::app()->request->baseUrl . '/' . $filename . '"><img style="width:' . $width . 'px;height:' . $height . 'px;" class="img_base" style="float:left; position: absolute; top: 0;" src="' . Yii::app()->request->baseUrl . '/' . $thumnail_file_path . '"/></a>');
            } else if ($for_detail == 'index') {
                printf(' <a class="a_base" style="width:70px; height:52px;" rel="prettyPhoto" href="' . Yii::app()->request->baseUrl . '/' . $filename . '"><img style="width:' . $width . 'px;height:' . $height . 'px;" class="img_base" style="float:left; position: absolute; top: 0;" src="' . Yii::app()->request->baseUrl . '/' . $thumnail_file_path . '"/></a>');
            } else {
                printf(' <a class="a_base" style="width:228px; height:171px; float:left; position: relative;" rel="prettyPhoto" href="' . Yii::app()->request->baseUrl . '/' . $filename . '"><img style="width:' . $width . 'px;height:' . $height . 'px;" class="img_base" style="float:left; position: absolute; top: 0;" src="' . Yii::app()->request->baseUrl . '/' . $thumnail_file_path . '"/></a>');
            }
        }
    }
	public static function echoEyeCatch_popMemberdetail($host_file_attachment_ext, $path, $for_detail) {
        $attachment = $path;
        if (!file_exists(Yii::getPathOfAlias('webroot') . $attachment)) {
            echo '';
            return;
        }
        if (in_array($host_file_attachment_ext, Constants::$imgExtention)) {

            $filename = ltrim($attachment, '/');

            $thumnail_file_path = FunctionCommon::getFilenameInThumnail($attachment);
            $thumnail_file_path = ltrim($thumnail_file_path, '/');
            
                $height = 171;
                $width = Config::IMG_WIDTH;
                
                $imgbinary = fread(fopen($thumnail_file_path, "r"), filesize($thumnail_file_path));
                $img_str = base64_encode($imgbinary);
                $img="data:image/jpg;base64,".$img_str;    
                if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) { 
                    echo '<img src="'.Yii::app()->request->baseUrl . '/' . $filename.'" style="display:none;"/>';
                    echo '<img ondragstart="return false;" ondrop="return false;" id="not_download" style="width:252px;" src="' . Yii::app()->request->baseUrl.'/'.$thumnail_file_path . '"/>';
                    if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.') == false) { 
                        echo '<img src="data:image/jpg;base64,'.$img_str.'" style="display:none;"/>';
                    }
                    //echo '<img src="data:image/jpg;base64,'.$img_str.'" style="display:none;"/>';

                }
                else{   
                    $imgbinary1 = fread(fopen($filename, "r"), filesize($filename));
                    $img_str1 = base64_encode($imgbinary1);
                    echo '<img src="data:image/jpg;base64,'.$img_str1.'" style="display:none;"/>';
                    echo '<img ondragstart="return false;" ondrop="return false;" id="not_download" style="width:252px;" src="' . $img . '"/>';
                }
           
                
          
        }
    }

    public static function echoOldFile($host_file_attachment_ext, $order_index, $model, $url) {

        $attachment = "";

        $my_class = get_class($model);
        if ($order_index == 1) {
            $attachment = $model->attachment1;
        } else if ($order_index == 2) {
            $attachment = $model->attachment2;
        } elseif ($order_index == 3) {
            $attachment = $model->attachment3;
        } elseif ($order_index == 4 && $my_class == "Unit") {

            $attachment = $model->photo;
        }


        if (in_array($host_file_attachment_ext, Constants::$imgExtention)) {

            $filename = ltrim($attachment, '/');
            $thumnail_file_path = FunctionCommon::getFilenameInThumnail($attachment);
            if(!file_exists(Yii::getPathOfAlias('webroot') .$thumnail_file_path)){
                return;
            }
            $thumnail_file_path = ltrim($thumnail_file_path, '/');
            list($width, $height) = getimagesize($thumnail_file_path);
//            $width = Config::IMG_WIDTH;
//            $height = 171;
//            list($width_orig, $height_orig) = getimagesize($filename);
//            $ratio_orig = $width_orig / $height_orig;
//            if ($width / $height > $ratio_orig) {
//                $width = $height * $ratio_orig;
//            } else {
//                $height = $width / $ratio_orig;
//            }
//            $image_p = imagecreatetruecolor($width, $height);
//            if ($host_file_attachment_ext == 'jpg' || $host_file_attachment_ext == 'jpeg') {
//                $image = imagecreatefromjpeg($filename);
//            } else if ($host_file_attachment_ext == 'png') {
//                $image = imagecreatefrompng($filename);
//            } else if ($host_file_attachment_ext == 'gif') {
//                $image = imagecreatefromgif($filename);
//            }
            ?>  

            <?php
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
            printf(' <a  style="width:228px; height:171px;  position: relative; float:left" rel="prettyPhoto" href="' . Yii::app()->request->baseUrl . '/' . $filename . '"><img style="width:' . $width . 'px;height:' . $height . 'px;" class="img_base" style="float:left; position: absolute; top: 0;" src="' . Yii::app()->request->baseUrl . '/' . $thumnail_file_path . '"/></a>');

            //imagedestroy($image_p);
            ?>
            <br />
            <span style="width:228px; float:left;">
            <?php echo self::getFileNameFromValueInDatabase($attachment); ?>
            </span>
            <?php
        } else {
            ?>
            <a style="width:228px; float:left; cursor: pointer;" id="<?php echo $attachment; ?>">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/css/common/img/
            <?php
            if ($host_file_attachment_ext == 'pdf') {
                echo 'img_pdf.gif';
            } else if (in_array($host_file_attachment_ext, Constants::$zipExtention)) {
                echo 'img_zip.gif';
            } else if (in_array($host_file_attachment_ext, Constants::$excelExtention)) {
                echo 'img_excel.gif';
            } else if (in_array($host_file_attachment_ext, Constants::$wordExtention)) {
                echo 'img_word.gif';
            } else if (in_array($host_file_attachment_ext, Constants::$powerpointExtention)) {
                echo 'img_ppt.gif';
            }
            ?>"/>

            </a>
            <br />
            <span style="width:228px; float:left;">
                <?php echo self::getFileNameFromValueInDatabase($attachment); ?>
            </span>
            <?php
        }
    }

    public static function getFileNameFromValueInDatabase($full_file_name) {
        if ($full_file_name == null || !is_string($full_file_name) || trim($full_file_name) == "") {
            return null;
        }
        $string_array = explode("/", $full_file_name);
        if (count($string_array) == 1) {
            return NULL;
        }
        $file_name = $string_array[count($string_array) - 1];
        $string_array = explode(".", $file_name);
        $file_name = '';
        for ($i = 0, $n = count($string_array) - 2; $i < $n; $i++) {
            $file_name.=$string_array[$i];
        }
        $file_name.='.' . $string_array[count($string_array) - 1];
        return $file_name;
    }

    public static function getAttachmentById($id, $attachment_index, $table_name) {
        $attachment = Yii::app()->db->createCommand()->select('attachment' . $attachment_index)->from($table_name)->where("id=$id")->queryScalar();
        if ($attachment_index == 4 && $table_name == 'golf_news') {
            $attachment = Yii::app()->db->createCommand()->select('eye_catch')->from('golf_news')->where("id=$id")->queryScalar();
        } else if ($attachment_index == 4 && $table_name == 'hobby_itd') {
            $attachment = Yii::app()->db->createCommand()->select('eye_catch')->from('hobby_itd')->where("id=$id")->queryScalar();
        }
        if ($attachment == FALSE) {
            return '';
        }
        return $attachment;
    }

    public static function getFileNameExtension($file_name) {
        if ($file_name == null || !is_string($file_name) || trim($file_name) == "") {
            return null;
        }
        $string_array = explode(".", $file_name);
        if (count($string_array) == 1) {
            return null;
        }
        $ext = $string_array[count($string_array) - 1];
        return strtolower($ext);
    }

    /**
     * @param CList $validator_list
     * @param mixed $model
     * @return void 
     */
    public static function findCFileValidateAndRemove($model, &$validator_list) {
        $item1 = null;
        $item2 = null;
        if ($validator_list->count() > 0) {
            for ($i = 0, $n = $validator_list->count(); $i < $n; $i++) {
                $item = $validator_list->itemAt($i);
                if ($item instanceof CFileValidator) {
                    if ($item1 == null) {
                        $item1 = $item;
                    } else {
                        $item2 = $item;
                    }
                }
            }
        }
        if (!($item instanceof CFileValidator) && !($item2 instanceof CFileValidator)) {
            return;
        }
        self::removeFileValidate($model, $item1->attributes);
        self::removeFileValidate($model, $item2->attributes);
    }

    /**
     * @param array $attributes
     * @param mixed $model
     * @return void 
     */
    private static function removeFileValidate($model, &$attributes) {
        if ($model->attachment1_checkbox_for_deleting == '1') {
            foreach ($attributes as $key => $value) {
                if ($value == 'attachment1') {
                    unset($attributes[$key]);
                }
            }
        }
        if ($model->attachment2_checkbox_for_deleting == '1') {
            foreach ($attributes as $key => $value) {
                if ($value == 'attachment2') {
                    unset($attributes[$key]);
                }
            }
        }
        if ($model->attachment3_checkbox_for_deleting == '1') {
            foreach ($attributes as $key => $value) {
                if ($value == 'attachment3') {
                    unset($attributes[$key]);
                }
            }
        }
        try {
            if ($model->eye_catch_checkbox_for_deleting == '1') {
                foreach ($attributes as $key => $value) {
                    if ($value == 'eye_catch') {
                        unset($attributes[$key]);
                    }
                }
            }
        } catch (Exception $e) {
            
        }
    }

    /**
     * 
     */
    public static function processAttachments($model, $folder_name, $action_type) {
        $path = Upload_config::getUploadPath($folder_name);
        $my_class = strtolower(get_class($model));

        $number_of_file = 3;
        if ($my_class == 'golfnews' || $my_class == 'base' || $my_class == 'hobby_itd') {
            $number_of_file = 4;
        }

        Upload_config::createFolder($path, Yii::getPathOfAlias('webroot'), $number_of_file);
        $attachment1_path = $path . 'attachment1/';
        $attachment2_path = $path . 'attachment2/';
        $attachment3_path = $path . 'attachment3/';

        $cookie_key_name = 'file_' . $my_class . '_' . (($action_type == 1) ? 'regist' : 'edit') . '_attachment';
        if ($number_of_file == 4) {
            $attachment4_path = $path . 'attachment4/';
        }
        $employee_number = FunctionCommon::getEmplNum();
        $now_for_file = date("YmdHis");

        if ($model->attachment1_checkbox_for_deleting != '1') {
            if ($file = CUploadedFile::getInstance($model, 'attachment1')) {
                $file_name = $file->name;


                $model->attachment1_file_type = $file->type;

                $file_name = self::fixFileName($file_name);
                $temp = explode(".", $file_name);
                $extension = $temp[count($temp) - 1];
                $temp = explode("." . $extension, $file_name);
                $model->attachment1 = $attachment1_path . $temp[0] . '.' . $employee_number . '_' . $now_for_file . '.' . $extension;
                $file->saveAs(Yii::getPathOfAlias('webroot') . $model->attachment1);

                $url1 = ltrim($model->attachment1, '/');
                $size = getimagesize($url1);
                $w = $size[0];
                $h = $size[1];
                if (in_array($extension, Constants::$imgExtention)) {
                    if (($w >= Config::IMG_WIDTH_BIG && $h >= Config::IMG_HEIGHT_BIG) || ($w > Config::IMG_WIDTH_BIG && $h < Config::IMG_HEIGHT_BIG) || ($w < Config::IMG_WIDTH_BIG && $h > Config::IMG_HEIGHT_BIG)) {
                        $image = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . $model->attachment1);
                        $image->resize(Config::IMG_WIDTH_BIG, Config::IMG_HEIGHT_BIG);
                        $image->save();
                        // FunctionCommon::compressImage($model->attachment1);
                    }
                }

                if (Yii::app()->request->cookies[$cookie_key_name . '1'] != "" && Yii::app()->request->cookies[$cookie_key_name . '1'] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '1']->value)) {
                    unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '1']->value);
                }
                $cookie = new CHttpCookie($cookie_key_name . '1', $model->attachment1);
                Yii::app()->request->cookies[$cookie_key_name . '1'] = $cookie;
            }
        } else {
            if (Yii::app()->request->cookies[$cookie_key_name . '1'] != "" && Yii::app()->request->cookies[$cookie_key_name . '1'] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '1']->value)) {
                unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '1']->value);
            }


            unset(Yii::app()->request->cookies[$cookie_key_name . '1']);
            if ($action_type == 1) {
                $model->attachment1 = "";
            }
        }
        if ($model->attachment2_checkbox_for_deleting != '1') {
            if ($file = CUploadedFile::getInstance($model, 'attachment2')) {
                $file_name = $file->name;


                $model->attachment2_file_type = $file->type;

                $file_name = self::fixFileName($file_name);
                $temp = explode(".", $file_name);
                $extension = $temp[count($temp) - 1];
                $temp = explode("." . $extension, $file_name);
                $model->attachment2 = $attachment2_path . $temp[0] . '.' . $employee_number . '_' . $now_for_file . '.' . $extension;
                $file->saveAs(Yii::getPathOfAlias('webroot') . $model->attachment2);

                $url2 = ltrim($model->attachment2, '/');
                $size = getimagesize($url2);
                $w = $size[0];
                $h = $size[1];
                if (in_array($extension, Constants::$imgExtention)) {
                    if (($w >= Config::IMG_WIDTH_BIG && $h >= Config::IMG_HEIGHT_BIG) || ($w > Config::IMG_WIDTH_BIG && $h < Config::IMG_HEIGHT_BIG) || ($w < Config::IMG_WIDTH_BIG && $h > Config::IMG_HEIGHT_BIG)) {
                        $image = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . $model->attachment2);
                        $image->resize(Config::IMG_WIDTH_BIG, Config::IMG_HEIGHT_BIG);
                        $image->save();
                        // FunctionCommon::compressImage($model->attachment1);
                    }
                }

                if (Yii::app()->request->cookies[$cookie_key_name . '2'] != "" && Yii::app()->request->cookies[$cookie_key_name . '2'] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '2']->value)) {
                    unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '2']->value);
                }
                $cookie = new CHttpCookie($cookie_key_name . '2', $model->attachment2);
                Yii::app()->request->cookies[$cookie_key_name . '2'] = $cookie;
            }
        } else {
            if (Yii::app()->request->cookies[$cookie_key_name . '2'] != "" && Yii::app()->request->cookies[$cookie_key_name . '2'] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '2']->value)) {
                unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '2']->value);
            }


            unset(Yii::app()->request->cookies[$cookie_key_name . '2']);
            if ($action_type == 1) {
                $model->attachment2 = "";
            }
        }
        if ($model->attachment3_checkbox_for_deleting != '1') {
            if ($file = CUploadedFile::getInstance($model, 'attachment3')) {
                $file_name = $file->name;


                $model->attachment1_file_type = $file->type;

                $file_name = self::fixFileName($file_name);
                $temp = explode(".", $file_name);
                $extension = $temp[count($temp) - 1];
                $temp = explode("." . $extension, $file_name);
                $model->attachment3 = $attachment3_path . $temp[0] . '.' . $employee_number . '_' . $now_for_file . '.' . $extension;
                $file->saveAs(Yii::getPathOfAlias('webroot') . $model->attachment3);

                $url3 = ltrim($model->attachment3, '/');
                $size = getimagesize($url3);
                $w = $size[0];
                $h = $size[1];
                if (in_array($extension, Constants::$imgExtention)) {
                    if (($w >= Config::IMG_WIDTH_BIG && $h >= Config::IMG_HEIGHT_BIG) || ($w > Config::IMG_WIDTH_BIG && $h < Config::IMG_HEIGHT_BIG) || ($w < Config::IMG_WIDTH_BIG && $h > Config::IMG_HEIGHT_BIG)) {
                        $image = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . $model->attachment3);
                        $image->resize(Config::IMG_WIDTH_BIG, Config::IMG_HEIGHT_BIG);
                        $image->save();
                        // FunctionCommon::compressImage($model->attachment1);
                    }
                }

                if (Yii::app()->request->cookies[$cookie_key_name . '3'] != "" && Yii::app()->request->cookies[$cookie_key_name . '3'] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '3']->value)) {
                    unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '3']->value);
                }
                $cookie = new CHttpCookie($cookie_key_name . '3', $model->attachment3);
                Yii::app()->request->cookies[$cookie_key_name . '3'] = $cookie;
            }
        } else {
            if (Yii::app()->request->cookies[$cookie_key_name . '3'] != "" && Yii::app()->request->cookies[$cookie_key_name . '3'] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '3']->value)) {
                unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '3']->value);
            }


            unset(Yii::app()->request->cookies[$cookie_key_name . '3']);
            if ($action_type == 1) {
                $model->attachment3 = "";
            }
        }
        if ($number_of_file == 4) {
            $attr = '';
            if ($my_class == 'golfnews' || $my_class == 'hobby_itd') {
                $attr = 'eye_catch';
            } else if ($my_class == 'base') {
                $attr = 'photo';
            } else {
                $attr = '';
            }
            if ($attr != '') {
                if ((($my_class == 'golfnews' || $my_class == 'hobby_itd') && $model->eye_catch_checkbox_for_deleting != '1') || ($my_class == 'base' && $model->photo_checkbox_for_deleting != '1')) {
                    if (
                            $file = CUploadedFile::getInstance($model, $attr)
                    ) {
                        if (Yii::app()->request->cookies[$cookie_key_name . '4'] != "" && Yii::app()->request->cookies[$cookie_key_name . '4'] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '4']->value)) {
                            unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '4']->value);
                        }

                        $file_name = $file->name;


                        if ($my_class == 'golfnews' || $my_class == 'hobby_itd') {
                            $model->eye_catch_file_type = $file->type;
                        } else if ($my_class == 'base') {
                            $model->photo_file_type = $file->type;
                        }


                        $file_name = self::fixFileName($file_name);
                        $temp = explode(".", $file_name);
                        $extension = $temp[count($temp) - 1];
                        $temp = explode("." . $extension, $file_name);
                        if ($my_class == 'golfnews' || $my_class == 'hobby_itd') {
                            $model->eye_catch = $attachment4_path . $temp[0] . '.' . $employee_number . '_' . $now_for_file . '.' . $extension;
                            $file->saveAs(Yii::getPathOfAlias('webroot') . $model->eye_catch);

                            $url4 = ltrim($model->eye_catch, '/');
                            $size = getimagesize($url4);
                            $w = $size[0];
                            $h = $size[1];
                            if (in_array($extension, Constants::$imgExtention)) {
                                if (($w >= Config::IMG_WIDTH_BIG && $h >= Config::IMG_HEIGHT_BIG) || ($w > Config::IMG_WIDTH_BIG && $h < Config::IMG_HEIGHT_BIG) || ($w < Config::IMG_WIDTH_BIG && $h > Config::IMG_HEIGHT_BIG)) {
                                    $image = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . $model->eye_catch);
                                    $image->resize(Config::IMG_WIDTH_BIG, Config::IMG_HEIGHT_BIG);
                                    $image->save();
                                    // FunctionCommon::compressImage($model->attachment1);
                                }
                            }
                            $cookie = new CHttpCookie($cookie_key_name . '4', $model->eye_catch);
                        } else if ($my_class == 'base') {
                            //echo $attachment4_path;exit;
                            $model->photo = $attachment4_path . $temp[0] . '.' . $employee_number . '_' . $now_for_file . '.' . $extension;
                            $file->saveAs(Yii::getPathOfAlias('webroot') . $model->photo);

                            $url5 = ltrim($model->photo, '/');
                            $size = getimagesize($url5);
                            $w = $size[0];
                            $h = $size[1];
                            if (in_array($extension, Constants::$imgExtention)) {
                                if (($w >= Config::IMG_WIDTH_BIG && $h >= Config::IMG_HEIGHT_BIG) || ($w > Config::IMG_WIDTH_BIG && $h < Config::IMG_HEIGHT_BIG) || ($w < Config::IMG_WIDTH_BIG && $h > Config::IMG_HEIGHT_BIG)) {
                                    $image = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . $model->photo);
                                    $image->resize(Config::IMG_WIDTH_BIG, Config::IMG_HEIGHT_BIG);
                                    $image->save();
                                    // FunctionCommon::compressImage($model->attachment1);
                                }
                            }
                            $cookie = new CHttpCookie($cookie_key_name . '4', $model->photo);
                        }


                        Yii::app()->request->cookies[$cookie_key_name . '4'] = $cookie;
                    }
                } else {
                    if (Yii::app()->request->cookies[$cookie_key_name . '4'] != "" && Yii::app()->request->cookies[$cookie_key_name . '4'] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '4']->value)) {
                        unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '4']->value);
                    }


                    unset(Yii::app()->request->cookies[$cookie_key_name . '4']);
                    if ($action_type == 1) {
                        if ($my_class == 'golfnews' || $my_class == 'hobby_itd') {
                            $model->eye_catch = "";
                        } else if ($my_class == 'base') {
                            $model->photo = "";
                        }
                    }
                }
            }
        }
    }

    /**
     *
     */
    public static function fixFileName($fileName) {
        if ($fileName == null || (!is_string($fileName)) || trim($fileName) == "") {
            return $fileName;
        }
        $fileName = str_replace("%", "", $fileName);
        $fileName = str_replace(" ", "_", $fileName);
        $fileName = str_replace("[", "_", $fileName);
        $fileName = str_replace("]", "_", $fileName);
        return $fileName;
    }

    /**
     * @param integer $action_type edit:2; regist:1
     */
    public static function processAttachmentsuser($model, $action_type) {
        $path = Upload_config::getUploadPath('user');

        Upload_config::createFolder($path, Yii::getPathOfAlias('webroot'), 1);
        $attachment1_path = $path . 'attachment1/';


        $cookie_key_name = 'file_user_' . (($action_type == 1) ? 'regist' : 'edit') . '_attachment4';

        $employee_number = FunctionCommon::getEmplNum();
        $now_for_file = date("YmdHis");


        if ($model->photo_checkbox_for_deleting != '1') {
            if ($file = CUploadedFile::getInstance($model, 'photo')) {
                $file_name = $file->name;


                $model->photo_file_type = $file->type;

                $file_name = self::fixFileName($file_name);
                $temp = explode(".", $file_name);
                $extension = $temp[count($temp) - 1];
                $temp = explode("." . $extension, $file_name);
                $model->photo = $attachment1_path . $temp[0] . '.' . $employee_number . '_' . $now_for_file . '.' . $extension;
                $file->saveAs(Yii::getPathOfAlias('webroot') . $model->photo);

                $url5 = ltrim($model->photo, '/');
                $size = getimagesize($url5);
                $w = $size[0];
                $h = $size[1];
                if (in_array($extension, Constants::$imgExtention)) {
                    if (($w >= Config::IMG_WIDTH_BIG && $h >= Config::IMG_HEIGHT_BIG) || ($w > Config::IMG_WIDTH_BIG && $h < Config::IMG_HEIGHT_BIG) || ($w < Config::IMG_WIDTH_BIG && $h > Config::IMG_HEIGHT_BIG)) {
                        $image = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . $model->photo);
                        $image->resize(Config::IMG_WIDTH_BIG, Config::IMG_HEIGHT_BIG);
                        $image->save();
                        // FunctionCommon::compressImage($model->attachment1);
                    }
                }

                if (Yii::app()->request->cookies[$cookie_key_name] != "" && Yii::app()->request->cookies[$cookie_key_name] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name]->value)) {
                    unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name]->value);
                }
                $cookie = new CHttpCookie($cookie_key_name, $model->photo);
                Yii::app()->request->cookies[$cookie_key_name] = $cookie;
            }
        } else {
            if (Yii::app()->request->cookies[$cookie_key_name] != "" && Yii::app()->request->cookies[$cookie_key_name] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name]->value)) {
                unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name]->value);
            }


            unset(Yii::app()->request->cookies[$cookie_key_name]);
            if ($action_type == 1) {
                $model->photo = "";
            }
        }
    }

    public static function processAttachments1($model, $folder_name, $action_type) {
        $path = Upload_config::getUploadPath($folder_name);
        $my_class = strtolower(get_class($model));

        $number_of_file = 3;
        if ($my_class == 'golfnews' || $my_class == 'base' || $my_class == 'hobby_itd') {
            $number_of_file = 4;
        }

        Upload_config::createFolder($path, Yii::getPathOfAlias('webroot'), $number_of_file);
        $attachment1_path = $path . 'attachment1/';
        $attachment2_path = $path . 'attachment2/';
        $attachment3_path = $path . 'attachment3/';

        $cookie_key_name = 'file_' . $my_class . '_' . (($action_type == 1) ? 'regist' : 'edit') . '_attachment';
        if ($number_of_file == 4) {
            $attachment4_path = $path . 'attachment4/';
        }
        $employee_number = FunctionCommon::getEmplNum();
        $now_for_file = date("YmdHis");

        if ($model->attachment1_checkbox_for_deleting != '1') {
            if ($file = CUploadedFile::getInstance($model, 'attachment1')) {
                $file_name = $file->name;

                $model->attachment1_file_type = $file->type;

                $file_name = self::fixFileName($file_name);
                $temp = explode(".", $file_name);
                $extension = $temp[count($temp) - 1];
                $temp = explode("." . $extension, $file_name);
                $model->attachment1 = $attachment1_path . $temp[0] . '.' . $employee_number . '_' . $now_for_file . '.' . $extension;
                $file->saveAs(Yii::getPathOfAlias('webroot') . $model->attachment1);

                $url1 = ltrim($model->attachment1, '/');
                $size = getimagesize($url1);
                $w = $size[0];
                $h = $size[1];
                if (in_array($extension, Constants::$imgExtention)) {
                    if (($w >= Config::IMG_WIDTH_BIG && $h >= Config::IMG_HEIGHT_BIG) || ($w > Config::IMG_WIDTH_BIG && $h < Config::IMG_HEIGHT_BIG) || ($w < Config::IMG_WIDTH_BIG && $h > Config::IMG_HEIGHT_BIG)) {
                        $image = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . $model->attachment1);
                        $image->resize(Config::IMG_WIDTH_BIG, Config::IMG_HEIGHT_BIG);
                        $image->save();
                        // FunctionCommon::compressImage($model->attachment1);
                    }
                }

                if (Yii::app()->request->cookies[$cookie_key_name . '1'] != "" && Yii::app()->request->cookies[$cookie_key_name . '1'] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '1']->value)) {
                    unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '1']->value);
                }
                $cookie = new CHttpCookie($cookie_key_name . '1', $model->attachment1);
                Yii::app()->request->cookies[$cookie_key_name . '1'] = $cookie;
            }
        } else {
            if (Yii::app()->request->cookies[$cookie_key_name . '1'] != "" && Yii::app()->request->cookies[$cookie_key_name . '1'] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '1']->value)) {
                unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '1']->value);
            }


            unset(Yii::app()->request->cookies[$cookie_key_name . '1']);
            if ($action_type == 1) {
                $model->attachment1 = "";
            }
        }
        if ($model->attachment2_checkbox_for_deleting != '1') {
            if ($file = CUploadedFile::getInstance($model, 'attachment2')) {
                $file_name = $file->name;


                $model->attachment2_file_type = $file->type;

                $file_name = self::fixFileName($file_name);
                $temp = explode(".", $file_name);
                $extension = $temp[count($temp) - 1];
                $temp = explode("." . $extension, $file_name);
                $model->attachment2 = $attachment2_path . $temp[0] . '.' . $employee_number . '_' . $now_for_file . '.' . $extension;
                $file->saveAs(Yii::getPathOfAlias('webroot') . $model->attachment2);

                $url2 = ltrim($model->attachment2, '/');
                $size = getimagesize($url2);
                $w = $size[0];
                $h = $size[1];
                if (in_array($extension, Constants::$imgExtention)) {
                    if (($w >= Config::IMG_WIDTH_BIG && $h >= Config::IMG_HEIGHT_BIG) || ($w > Config::IMG_WIDTH_BIG && $h < Config::IMG_HEIGHT_BIG) || ($w < Config::IMG_WIDTH_BIG && $h > Config::IMG_HEIGHT_BIG)) {
                        $image = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . $model->attachment2);
                        $image->resize(Config::IMG_WIDTH_BIG, Config::IMG_HEIGHT_BIG);
                        $image->save();
                        // FunctionCommon::compressImage($model->attachment1);
                    }
                }

                if (Yii::app()->request->cookies[$cookie_key_name . '2'] != "" && Yii::app()->request->cookies[$cookie_key_name . '2'] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '2']->value)) {
                    unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '2']->value);
                }
                $cookie = new CHttpCookie($cookie_key_name . '2', $model->attachment2);
                Yii::app()->request->cookies[$cookie_key_name . '2'] = $cookie;
            }
        } else {
            if (Yii::app()->request->cookies[$cookie_key_name . '2'] != "" && Yii::app()->request->cookies[$cookie_key_name . '2'] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '2']->value)) {
                unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '2']->value);
            }


            unset(Yii::app()->request->cookies[$cookie_key_name . '2']);
            if ($action_type == 1) {
                $model->attachment2 = "";
            }
        }
        if ($model->attachment3_checkbox_for_deleting != '1') {
            if ($file = CUploadedFile::getInstance($model, 'attachment3')) {
                $file_name = $file->name;


                $model->attachment1_file_type = $file->type;

                $file_name = self::fixFileName($file_name);
                $temp = explode(".", $file_name);
                $extension = $temp[count($temp) - 1];
                $temp = explode("." . $extension, $file_name);
                $model->attachment3 = $attachment3_path . $temp[0] . '.' . $employee_number . '_' . $now_for_file . '.' . $extension;
                $file->saveAs(Yii::getPathOfAlias('webroot') . $model->attachment3);

                $url3 = ltrim($model->attachment3, '/');
                $size = getimagesize($url3);
                $w = $size[0];
                $h = $size[1];
                if (in_array($extension, Constants::$imgExtention)) {
                    if (($w >= Config::IMG_WIDTH_BIG && $h >= Config::IMG_HEIGHT_BIG) || ($w > Config::IMG_WIDTH_BIG && $h < Config::IMG_HEIGHT_BIG) || ($w < Config::IMG_WIDTH_BIG && $h > Config::IMG_HEIGHT_BIG)) {
                        $image = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . $model->attachment3);
                        $image->resize(Config::IMG_WIDTH_BIG, Config::IMG_HEIGHT_BIG);
                        $image->save();
                        // FunctionCommon::compressImage($model->attachment1);
                    }
                }

                if (Yii::app()->request->cookies[$cookie_key_name . '3'] != "" && Yii::app()->request->cookies[$cookie_key_name . '3'] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '3']->value)) {
                    unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '3']->value);
                }
                $cookie = new CHttpCookie($cookie_key_name . '3', $model->attachment3);
                Yii::app()->request->cookies[$cookie_key_name . '3'] = $cookie;
            }
        } else {
            if (Yii::app()->request->cookies[$cookie_key_name . '3'] != "" && Yii::app()->request->cookies[$cookie_key_name . '3'] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '3']->value)) {
                unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '3']->value);
            }


            unset(Yii::app()->request->cookies[$cookie_key_name . '3']);
            if ($action_type == 1) {
                $model->attachment3 = "";
            }
        }
        if ($number_of_file == 4) {
            $attr = '';
            if ($my_class == 'golfnews' || $my_class == 'hobby_itd') {
                $attr = 'eye_catch';
            } else if ($my_class == 'base') {
                $attr = 'photo';
            } else {
                $attr = '';
            }
            if ($attr != '') {
                if ($file = CUploadedFile::getInstance($model, $attr)) {
                    if (
                            (($my_class == 'golfnews' || $my_class == 'hobby_itd') && $model->eye_catch_checkbox_for_deleting != '1') || ($my_class == 'base' && $model->photo_checkbox_for_deleting != '1')
                    ) {
                        if (Yii::app()->request->cookies[$cookie_key_name . '4'] != "" && Yii::app()->request->cookies[$cookie_key_name . '4'] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '4']->value)) {
                            unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '4']->value);
                        }

                        $file_name = $file->name;


                        if ($my_class == 'golfnews' || $my_class == 'hobby_itd') {
                            $model->eye_catch_file_type = $file->type;
                        } else if ($my_class == 'base') {
                            $model->photo_file_type = $file->type;
                        }


                        $file_name = self::fixFileName($file_name);
                        $temp = explode(".", $file_name);
                        $extension = $temp[count($temp) - 1];
                        $temp = explode("." . $extension, $file_name);
                        if ($my_class == 'golfnews' || $my_class == 'hobby_itd') {
                            $model->eye_catch = $attachment4_path . $temp[0] . '.' . $employee_number . '_' . $now_for_file . '.' . $extension;
                            $file->saveAs(Yii::getPathOfAlias('webroot') . $model->eye_catch);

                            $url4 = ltrim($model->eye_catch, '/');
                            $size = getimagesize($url4);
                            $w = $size[0];
                            $h = $size[1];
                            if (in_array($extension, Constants::$imgExtention)) {
                                if (($w >= Config::IMG_WIDTH_BIG && $h >= Config::IMG_HEIGHT_BIG) || ($w > Config::IMG_WIDTH_BIG && $h < Config::IMG_HEIGHT_BIG) || ($w < Config::IMG_WIDTH_BIG && $h > Config::IMG_HEIGHT_BIG)) {
                                    $image = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . $model->eye_catch);
                                    $image->resize(Config::IMG_WIDTH_BIG, Config::IMG_HEIGHT_BIG);
                                    $image->save();
                                    // FunctionCommon::compressImage($model->attachment1);
                                }
                            }
                            $cookie = new CHttpCookie($cookie_key_name . '4', $model->eye_catch);
                        } else if ($my_class == 'base') {
                            //echo $attachment4_path;exit;
                            $model->photo = $attachment4_path . $temp[0] . '.' . $employee_number . '_' . $now_for_file . '.' . $extension;
                            $file->saveAs(Yii::getPathOfAlias('webroot') . $model->photo);

                            $url5 = ltrim($model->photo, '/');
                            $size = getimagesize($url5);
                            $w = $size[0];
                            $h = $size[1];
                            if (in_array($extension, Constants::$imgExtention)) {
                                if (($w >= Config::IMG_WIDTH_BIG && $h >= Config::IMG_HEIGHT_BIG) || ($w > Config::IMG_WIDTH_BIG && $h < Config::IMG_HEIGHT_BIG) || ($w < Config::IMG_WIDTH_BIG && $h > Config::IMG_HEIGHT_BIG)) {
                                    $image = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . $model->photo);
                                    $image->resize(Config::IMG_WIDTH_BIG, Config::IMG_HEIGHT_BIG);
                                    $image->save();
                                    // FunctionCommon::compressImage($model->attachment1);
                                }
                            }
                            $cookie = new CHttpCookie($cookie_key_name . '4', $model->photo);
                        }


                        Yii::app()->request->cookies[$cookie_key_name . '4'] = $cookie;
                    } else {
                        if (Yii::app()->request->cookies[$cookie_key_name . '4'] != "" && Yii::app()->request->cookies[$cookie_key_name . '4'] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '4']->value)) {
                            unlink(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . '4']->value);
                        }


                        unset(Yii::app()->request->cookies[$cookie_key_name . '4']);
                        if ($action_type == 1) {
                            if ($my_class == 'golfnews' || $my_class == 'hobby_itd') {
                                $model->eye_catch = "";
                            } else if ($my_class == 'base') {
                                $model->photo = "";
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * 
     * @param integer $action_type regist:1; edit:2    
     */
    public static function echoOldFile1($host_file_attachment_ext, $order_index, $model, $url, $action_type) {

        $attachment = "";

        $my_class = get_class($model);

        $cookie_key_name = 'file_' . strtolower($my_class) . '_' . ($action_type == 1 ? 'regist' : 'edit') . '_attachment';

        if (Yii::app()->request->cookies[$cookie_key_name . $order_index] != "" && Yii::app()->request->cookies[$cookie_key_name . $order_index] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name . $order_index])) {
            $attachment = Yii::app()->request->cookies[$cookie_key_name . $order_index]->value;
        } else {
            if ($action_type == 2) {
                if ($order_index == 1) {
                    $attachment = $model->attachment1;
                } else if ($order_index == 2) {
                    $attachment = $model->attachment2;
                } elseif ($order_index == 3) {
                    $attachment = $model->attachment3;
                } elseif ($order_index == 4 && ($my_class == "Base" || $my_class == 'User')) {
                    $attachment = $model->photo;
                } elseif ($order_index == 4 && ($my_class == "Hobby_itd" || $my_class == 'Golfnews')) {
                    $attachment = $model->eye_catch;
                }
            }
        }
        if (in_array($host_file_attachment_ext, Constants::$imgExtention)) {

            $filename = ltrim($attachment, '/');
            $thumnail_file_path = FunctionCommon::getFilenameInThumnail($attachment);
            if(!file_exists(Yii::getPathOfAlias('webroot') .$thumnail_file_path)){
                return;
            }
            $thumnail_file_path = ltrim($thumnail_file_path, '/');
            list($width, $height) = getimagesize($thumnail_file_path);
//            $width = Config::IMG_WIDTH;
//            $height = 171;
//            list($width_orig, $height_orig) = getimagesize($filename);
//            $ratio_orig = $width_orig / $height_orig;
//            if ($width / $height > $ratio_orig) {
//                $width = $height * $ratio_orig;
//            } else {
//                $height = $width / $ratio_orig;
//            }
//            $image_p = imagecreatetruecolor($width, $height);
//            if ($host_file_attachment_ext == 'jpg' || $host_file_attachment_ext == 'jpeg') {
//                $image = imagecreatefromjpeg($filename);
//            } else if ($host_file_attachment_ext == 'png') {
//                $image = imagecreatefrompng($filename);
//            } else if ($host_file_attachment_ext == 'gif') {
//                $image = imagecreatefromgif($filename);
//            }
            ?>  

            <?php
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
            printf(' <a  style="width:228px; height:171px;  position: relative; float:left" rel="prettyPhoto" href="' . Yii::app()->request->baseUrl . '/' . $filename . '"><img style="width:' . $width . 'px;height:' . $height . 'px;" class="img_base" style="float:left; position: absolute; top: 0;" src="' . Yii::app()->request->baseUrl . '/' . $thumnail_file_path . '"/></a>');
            //imagedestroy($image_p);
            ?>
            <br />
            <span style="width:228px;">
            <?php echo self::getFileNameFromValueInDatabase($attachment); ?>
            </span>
            <?php
        } else {
            ?>
            <a style="width:228px; float:left; cursor: pointer;" id="<?php echo $attachment; ?>">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/css/common/img/
            <?php
            if ($host_file_attachment_ext == 'pdf') {
                echo 'img_pdf.gif';
            } else if (in_array($host_file_attachment_ext, Constants::$zipExtention)) {
                echo 'img_zip.gif';
            } else if (in_array($host_file_attachment_ext, Constants::$excelExtention)) {
                echo 'img_excel.gif';
            } else if (in_array($host_file_attachment_ext, Constants::$wordExtention)) {
                echo 'img_word.gif';
            } else if (in_array($host_file_attachment_ext, Constants::$powerpointExtention)) {
                echo 'img_ppt.gif';
            }
            ?>"/>

            </a>
            <br />
            <span style="width:228px; float:left;">
            <?php echo self::getFileNameFromValueInDatabase($attachment); ?>
            </span>
            <?php
        }
    }

    //bao dt view majimemember detail 03/09/2013
    public static function echoPhotomember($host_file_attachment_ext, $path, $count) {
        $attachment = $path;
        if (!file_exists(Yii::getPathOfAlias('webroot') . $attachment)) {
            echo '';
            return;
        }
        if (in_array($host_file_attachment_ext, Constants::$imgExtention)) {
            $filename = ltrim($attachment, '/');
            $thumnail_file_path=  FunctionCommon::getFilenameInThumnail($attachment);    
            $thumnail_file_path=ltrim($thumnail_file_path, '/');            
            
            $width = 46;
            $height = 52;
            
               
            if ($count == '2') {                
                printf('<a rel="prettyPhoto" href="' . Yii::app()->request->baseUrl . '/' . $filename . '"><img class="img_base" style="height:60px; float:left;" src="'.Yii::app()->request->baseUrl.'/'.$thumnail_file_path.'"/></a>');            
            } else {   
                $imgbinary = fread(fopen($thumnail_file_path, "r"), filesize($thumnail_file_path));
                $img_str = base64_encode($imgbinary);
                $img="data:image/jpg;base64,".$img_str;  
                if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {  
                    echo '<img src="'.Yii::app()->request->baseUrl . '/' . $filename.'" style="display:none;"/>';
                    echo '<img ondragstart="return false;" ondrop="return false;" id="not_download" style="text-align:center; height:60px;" src="'.Yii::app()->request->baseUrl.'/'.$thumnail_file_path.'"/>';                    
                    if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.') == false) { 
                        echo '<img src="data:image/jpg;base64,'.$img_str.'" style="display:none;"/>';
                    }
                    

                }
                else{
                    $imgbinary1 = fread(fopen($filename, "r"), filesize($filename));
                    $img_str1 = base64_encode($imgbinary1);
                    echo '<img src="data:image/jpg;base64,'.$img_str1.'" style="display:none;"/>';
                    echo '<img ondragstart="return false;" ondrop="return false;" id="not_download" style="text-align:center; height:60px;" src="'.$img.'"/>';
                }
                
            }             
           
            
        }
    }

}
?>