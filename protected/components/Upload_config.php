<?php

class Upload_config {

    /**
     * @param string $module_name 
     * @return string
     */
    public static function getUploadPath($module_name) {
        if ($module_name == NULL || !is_string($module_name) || trim($module_name) == "") {
            return NULL;
        }
        Yii::import('ext.helpers.EIniHelper');        
        $ini = 'protected/config/upload_path.ini';
        $path_array = EIniHelper::Load($ini)->Get('path');        
        return $path_array[$module_name];
    }

    /**
     * @param string $path_string
     * @param string $root_path
     * @return void
     */
    public static function createFolder($path_string, $root_path, $number_of_file = 3) {
        /**
         * 
         */
        if ($path_string == null || !is_string($path_string) || trim($path_string) == "") {
            return;
        }
        
        /**
         * 
         */
        $path_string = self::fixPathString($path_string);
        /**
         * 
         */
        $folder_name_array = explode("/", $path_string);
        $current_path = $root_path;
        if (is_array($folder_name_array) && count($folder_name_array) > 1) {
            foreach ($folder_name_array as $folder_name) {
                if (is_string($folder_name) && trim($folder_name) != "") {                    
                    $current_path.='/' . $folder_name;                    
                    if (!file_exists($current_path)) {
                        mkdir($current_path);                       
                    }
                }
            }
        }
        
        /**
         * 
         */
        if ($number_of_file == 3) {
            $attachment1_path = $current_path . '/attachment1';
            $attachment2_path = $current_path . '/attachment2';
            $attachment3_path = $current_path . '/attachment3';
            if (!file_exists($attachment1_path)) {
                mkdir($attachment1_path);  
                $attachment1_path.='/thumnail';
                if (!file_exists($attachment1_path)) {
                    mkdir($attachment1_path);
                }				
            }
            else{
                $attachment1_path.='/thumnail';
                if (!file_exists($attachment1_path)) {
                    mkdir($attachment1_path);
                }
            }
            if (!file_exists($attachment2_path)) {
                mkdir($attachment2_path);   
                $attachment2_path.='/thumnail';
                if (!file_exists($attachment2_path)) {
                    mkdir($attachment2_path);
                }			
            }
            else{
                $attachment2_path.='/thumnail';
                if (!file_exists($attachment2_path)) {
                    mkdir($attachment2_path);
                }
            }
            if (!file_exists($attachment3_path)) {
                mkdir($attachment3_path); 
                $attachment3_path.='/thumnail';
                if (!file_exists($attachment3_path)) {
                    mkdir($attachment3_path);
                }				
            }
            else{
                $attachment3_path.='/thumnail';
                if (!file_exists($attachment3_path)) {
                    mkdir($attachment3_path);
                }
            }
        } else {
            for ($i = 0; $i < $number_of_file; $i++) {
                $attachment_path = $current_path . '/attachment' . ($i + 1);
                if (!file_exists($attachment_path)) {
                    mkdir($attachment_path);
                    $attachment_path.='/thumnail';
                    if (!file_exists($attachment_path)) {
                        mkdir($attachment_path);
                    }
                }
				else{
                    $attachment_path.='/thumnail';
                    if (!file_exists($attachment_path)) {
                        mkdir($attachment_path);
                    } 				
				}
            }
        }
    }

    /**
     * @param string $path_string
     * @return string 
     */
    public static function fixPathString($path_string) {
        /**
         * 
         */
        if ($path_string == null || !is_string($path_string) || trim($path_string) == "") {
            return $path_string;
        }
        /**
         * 
         */
        if ($path_string[0] != '/') {
            $path_string = '/' . $path_string;
        }
        /**
         * 
         */
        if ($path_string[strlen($path_string) - 1] != '/') {
            $path_string = $path_string . '/';
        }
        return $path_string;
    }

}

?>
