<?php

class AdminzentaishihyouController extends Controller {

    public $pageTitle;
    private $_zentaishihyou = null;

    public function init() {
        parent::init();
        $this->pageTitle = "ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id'] == "null") {
            $this->redirect(array('newgin/'));
        }
    }

    /**
     * edit record id
     */
    public function actionIndex() {
        $this->createFolder();
        $params = array();

        $path = 'zentaishihyou2';
        $path_new = "upload/zentaishihyou2/";

        if (isset($_FILES['zentaishihyou']['name'])) {
            $file_name = $_FILES['zentaishihyou']['name'];
            $file_size = $_FILES['zentaishihyou']['size'];
            $file_tmp = $_FILES['zentaishihyou']['tmp_name'];
        }

        if ((isset($_POST['file_ola']) && $_POST['file_ola'] != "")) {
//                      if (file_exists(Yii::getPathOfAlias('webroot').$path_new.$_POST['file_ola'])) {
//                          unlink($path_new.$_POST['file_ola']);
//                      }			  
//                          if (file_exists(Yii::getPathOfAlias('webroot').$path_new.'thumnail/'.$_POST['file_ola'])) {
//                              unlink($path_new.'thumnail/'.$_POST['file_ola']);
//                          }
        }

        if (isset($file_size) && $file_size > 0) {
            if (($file_size > Config::MAX_FILE_SIZE * 1024 * 1024) && isset($_POST['delete_file']) && $_POST['delete_file'] != "") {

                $parmas['error'] = "1";
            } else if (($file_size > Config::MAX_FILE_SIZE * 1024 * 1024)) {
                $parmas['error'] = "2";
            } else {
                $host_file_attachment_ext = FunctionCommon::getExtensionFile($file_name);
                if (in_array($host_file_attachment_ext, Constants::$imgExtention)) {

                    $this->deleteFile();

                    $path_new1 = $path_new . '/thumnail';

                    $up_dir = $path_new;


//                    $temp = explode(".", $file_name);
//                    $extension = $temp[count($temp) - 1];
//                    $file_name=sprintf('_%s.'.$extension, uniqid(md5(time()), true));  

                    $temp=  explode(".", $file_name);                    
                    $name_image =date('YmdHis').'.'.$temp[count($temp)-1];

                    @move_uploaded_file($file_tmp, $up_dir . $name_image);





                    $url = "upload/zentaishihyou2/" . $name_image;
                    $size = getimagesize($url);
                    $w = $size[0];
                    $h = $size[1];

                    if (($w >= Config::IMG_WIDTH_BIG && $h >= Config::IMG_HEIGHT_BIG) || ($w > Config::IMG_WIDTH_BIG && $h < Config::IMG_HEIGHT_BIG) || ($w < Config::IMG_WIDTH_BIG && $h > Config::IMG_HEIGHT_BIG)) {

                        $image = Yii::app()->image->load($path_new . $name_image);
                        $image->resize(Config::IMG_WIDTH_BIG, Config::IMG_HEIGHT_BIG);
                        $image->save();
                    }
                    if($w>=$h){
                        $width = Config::IMG_WIDTH_ZENTAISHIHYOU;
                        if ($width > $w) {
                            $width = $w;
                            
                        }
                        $ratio = $h / $w;
                        $height = floor($width * $ratio);
                    }
                    else{
                        $height=273;                        
                        if ($height > $h) {
                            $height = $h;
                            
                        }
                        $ratio = $w / $h;
                        $width = floor($height * $ratio);
                    }
                    
                    //$height = 728;
                    $image = Yii::app()->image->load($path_new . $name_image);


                    
                    $image->resize($width, $height);
                    $image->save($path_new1 . '/' . $name_image);
                    $this->refresh();
                    $parmas['file_name'] = $name_image;
                    $parmas['path_new'] = $path_new;
                }
            }
        }
        $parmas['1'] = '1';
        $this->render('/admin/zentaishihyou/index', $parmas);
    }

    private function deleteFile() {
        if (file_exists(Yii::getPathOfAlias('webroot') . '/upload/zentaishihyou2')) {
            if ($handle = opendir(Yii::getPathOfAlias('webroot') . '/upload/zentaishihyou2')) {
                while (($file = readdir($handle)) !== false) {
                    if ($file != "." && $file != ".."&&  is_file(Yii::getPathOfAlias('webroot') . '/upload/zentaishihyou2/' . $file)) {
                        unlink(Yii::getPathOfAlias('webroot') . '/upload/zentaishihyou2/' . $file);
                    }
                }
                closedir($handle);
            }
        }
        if (file_exists(Yii::getPathOfAlias('webroot') . '/upload/zentaishihyou2/thumnail')) {
            if ($handle = opendir(Yii::getPathOfAlias('webroot') . '/upload/zentaishihyou2/thumnail')) {
                while (($file = readdir($handle)) !== false) {
                    if ($file != "." && $file != ".."&&  is_file(Yii::getPathOfAlias('webroot') . '/upload/zentaishihyou2/thumnail/' . $file)) {
                        unlink(Yii::getPathOfAlias('webroot') . '/upload/zentaishihyou2/thumnail/' . $file);
                    }
                }
                closedir($handle);
            }
        }
    }

    private function createFolder() {
        if (!file_exists(Yii::getPathOfAlias('webroot') . '/upload/zentaishihyou2')) {
            mkdir(Yii::getPathOfAlias('webroot') . '/upload/zentaishihyou2');
        }
        if (!file_exists(Yii::getPathOfAlias('webroot') . '/upload/zentaishihyou2/thumnail')) {
            mkdir(Yii::getPathOfAlias('webroot') . '/upload/zentaishihyou2/thumnail');
        }
    }

    public function actionDeleteajax() {
        if (Yii::app()->request->isAjaxRequest) {
            $this->deleteFile();
        }
    }

}
