<?php

class Bounty extends CActiveRecord {

    public $attachment1_file_type;
    public $attachment1_checkbox_for_deleting;
    public $attachment2_file_type;
    public $attachment2_checkbox_for_deleting;
    public $attachment3_file_type;
    public $attachment3_checkbox_for_deleting;
    public $deadline_day;
    public $deadline_month;
    public $deadline_year;
    private $transaction;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Token the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'bounty';
    }

    /*     * no validate checkbox delete is check */

    protected function beforeValidate() {
        Upload_file_common::findCFileValidateAndRemove($this, $this->validatorList);
        return parent::beforeValidate();
    }

    /*     * * check array rules */

    private function findCFileValidateAndRemove(&$validator_list) {
        if ($validator_list->count() > 0) {
            for ($i = 0, $n = $validator_list->count(); $i < $n; $i++) {
                $item = $validator_list->itemAt($i);
                if ($item instanceof CFileValidator) {
                    break;
                }
            }
        }
        if (!($item instanceof CFileValidator)) {
            return;
        }
        $this->removeFileValidate($item->attributes);
    }

    /**
     * remove Validate
     */
    private function removeFileValidate(&$attributes) {
        if ($this->attachment1_checkbox_for_deleting == '1') {
            foreach ($attributes as $key => $value) {
                if ($value == 'attachment1') {
                    unset($attributes[$key]);
                }
            }
        }
        if ($this->attachment2_checkbox_for_deleting == '1') {
            foreach ($attributes as $key => $value) {
                if ($value == 'attachment2') {
                    unset($attributes[$key]);
                }
            }
        }
        if ($this->attachment3_checkbox_for_deleting == '1') {
            foreach ($attributes as $key => $value) {
                if ($value == 'attachment3') {
                    unset($attributes[$key]);
                }
            }
        }
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('title,content,prize', 'filter', 'filter' => array($this, 'trimText')),
            array('title', 'required', 'message' => Lang::MSG_0002),
            array('title', 'length', 'max' => 256),
            array('content', 'required', 'message' => Lang::MSG_0003),
            array('prize', 'required', 'message' => Lang::MSG_0048),
            array('attachment1,attachment2,attachment3',
                'file', 'allowEmpty' => true,
                'types' => 'doc,docx,xls,xlsx,ppt,pptx,pdf,zip,rar,jpg,gif,png,jpeg',
                'wrongType' => Lang::MSG_0004),
            array('attachment1,attachment2,attachment3',
                'file', 'allowEmpty' => true, 'maxSize' => Config::MAX_FILE_SIZE * 1024 * 1024,
                'tooLarge' => Lang::MSG_0005),
            array('deadline_day,deadline_month,deadline_year,attachment1,attachment2,attachment3,
		attachment1_file_type,attachment1_checkbox_for_deleting,
		attachment2_file_type,attachment2_checkbox_for_deleting,
		attachment3_file_type,attachment3_checkbox_for_deleting, 
		created_date,id,', 'follow'),
        );
    }

    /*     * using trim data* */

    public function trimText($str) {
        $str = preg_replace('/^\p{Z}+|\p{Z}+$/u', '', $str);
        return $str;
    }

    /*     * * */

    public function follow($attribute) {
        
    }

    /*     * * */

    private function setNullForElementsNotEntered() {
        $attributes = $this->getAttributes();
        foreach ($attributes as $key => $value) {
            if (null == $value || '' == $value) {
                $this->setAttribute($key, null);
            }
        }
    }

    public function beforeSave() {
        $this->transaction = $this->dbConnection->beginTransaction();

        $now_for_record = FunctionCommon::getDateTimeSys();
        if ($this->getIsNewRecord()) {
            $this->created_date = $now_for_record;
            $this->contributor_id = Yii::app()->request->cookies['id']->value;
        }
        $this->deadline = $this->deadline_year . '-' . $this->deadline_month . '-' . $this->deadline_day;
        $employee_number = FunctionCommon::getEmplNum();
        $this->last_updated_person = $employee_number;
        $this->last_updated_date = $now_for_record;

        if ($this->getIsNewRecord() == true) {
            if (Yii::app()->request->cookies['file_bounty_regist_attachment1'] != "" && Yii::app()->request->cookies['file_bounty_regist_attachment1'] != "null") {
                $this->attachment1 = Yii::app()->request->cookies['file_bounty_regist_attachment1']->value;
            } else {
                $this->attachment1 = '';
            }
            if (Yii::app()->request->cookies['file_bounty_regist_attachment2'] != "" && Yii::app()->request->cookies['file_bounty_regist_attachment2'] != "null") {
                $this->attachment2 = Yii::app()->request->cookies['file_bounty_regist_attachment2']->value;
            } else {
                $this->attachment2 = '';
            }
            if (Yii::app()->request->cookies['file_bounty_regist_attachment3'] != "" && Yii::app()->request->cookies['file_bounty_regist_attachment3'] != "null") {
                $this->attachment3 = Yii::app()->request->cookies['file_bounty_regist_attachment3']->value;
            } else {
                $this->attachment3 = '';
            }
            unset(Yii::app()->request->cookies['file_bounty_regist_attachment1']);
            unset(Yii::app()->request->cookies['file_bounty_regist_attachment2']);
            unset(Yii::app()->request->cookies['file_bounty_regist_attachment3']);
        } else {
            if (Yii::app()->request->cookies['file_bounty_edit_attachment1'] != "" && Yii::app()->request->cookies['file_bounty_edit_attachment1'] != "null") {
                $this->attachment1 = Yii::app()->request->cookies['file_bounty_edit_attachment1']->value;
            }

            if (Yii::app()->request->cookies['file_bounty_edit_attachment2'] != "" && Yii::app()->request->cookies['file_bounty_edit_attachment2'] != "null") {
                $this->attachment2 = Yii::app()->request->cookies['file_bounty_edit_attachment2']->value;
            }

            if (Yii::app()->request->cookies['file_bounty_edit_attachment3'] != "" && Yii::app()->request->cookies['file_bounty_edit_attachment3'] != "null") {
                $this->attachment3 = Yii::app()->request->cookies['file_bounty_edit_attachment3']->value;
            }
            unset(Yii::app()->request->cookies['file_bounty_edit_attachment1']);
            unset(Yii::app()->request->cookies['file_bounty_edit_attachment2']);
            unset(Yii::app()->request->cookies['file_bounty_edit_attachment3']);

            /**
             * process attachment1
             */
            $attachment1 = Upload_file_common::getAttachmentById($this->id, 1, 'bounty');
            if ($this->attachment1_checkbox_for_deleting == '1') {//delete
                /**
                 * delete old file if exists
                 */

                if ($attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment1)) {
                    unlink(Yii::getPathOfAlias('webroot') . $attachment1);
                    $thumnail_file_path = FunctionCommon::getFilenameInThumnail($attachment1);
                    if (file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)) {
                        unlink(Yii::getPathOfAlias('webroot') . $thumnail_file_path);
                    }
                }
                /**
                 * for update attachment1 field=null
                 */
                $this->attachment1 = NULL;
            } else if ($this->attachment1_checkbox_for_deleting == '0') {//keep old stastus
                /**
                 * 
                 */
                if ($this->attachment1 != $attachment1) {//upload new file
                    if ($attachment1 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment1)) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment1);
                        $thumnail_file_path = FunctionCommon::getFilenameInThumnail($attachment1);
                        if (file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)) {
                            unlink(Yii::getPathOfAlias('webroot') . $thumnail_file_path);
                        }
                    }
                }
            }
            /**
             * process attachment2
             */
            $attachment2 = Upload_file_common::getAttachmentById($this->id, 2, 'bounty');
            if ($this->attachment2_checkbox_for_deleting == '1') {//delete
                /**
                 * delete old file if exists
                 */

                if ($attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment2)) {
                    unlink(Yii::getPathOfAlias('webroot') . $attachment2);
                    $thumnail_file_path = FunctionCommon::getFilenameInThumnail($attachment2);
                    if (file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)) {
                        unlink(Yii::getPathOfAlias('webroot') . $thumnail_file_path);
                    }
                }
                /**
                 * for update attachment1 field=null
                 */
                $this->attachment2 = NULL;
            } else if ($this->attachment2_checkbox_for_deleting == '0') {//keep old stastus
                /**
                 * 
                 */
                if ($this->attachment2 != $attachment2) {//upload new file
                    if ($attachment2 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment2)) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment2);
                        $thumnail_file_path = FunctionCommon::getFilenameInThumnail($attachment2);
                        if (file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)) {
                            unlink(Yii::getPathOfAlias('webroot') . $thumnail_file_path);
                        }
                    }
                }
            }
            /**
             * process attachment3
             */
            $attachment3 = Upload_file_common::getAttachmentById($this->id, 3, 'bounty');
            if ($this->attachment3_checkbox_for_deleting == '1') {//delete
                /**
                 * delete old file if exists
                 */

                if ($attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment3)) {
                    unlink(Yii::getPathOfAlias('webroot') . $attachment3);
                    $thumnail_file_path = FunctionCommon::getFilenameInThumnail($attachment3);
                    if (file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)) {
                        unlink(Yii::getPathOfAlias('webroot') . $thumnail_file_path);
                    }
                }
                /**
                 * for update attachment1 field=null
                 */
                $this->attachment3 = NULL;
            } else if ($this->attachment3_checkbox_for_deleting == '0') {//keep old stastus
                /**
                 * 
                 */
                if ($this->attachment3 != $attachment3) {//upload new file
                    if ($attachment3 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment3)) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment3);
                        $thumnail_file_path = FunctionCommon::getFilenameInThumnail($attachment3);
                        if (file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)) {
                            unlink(Yii::getPathOfAlias('webroot') . $thumnail_file_path);
                        }
                    }
                }
            }
        }

        $this->setNullForElementsNotEntered();
        return parent::beforeSave();
    }

    /*     * save update information* */

    public function afterSave() {
        $cookie_collection =Yii::app()->request->cookies;           
        $key_array=$cookie_collection->getKeys(); 
        for($i=0,$n=count($key_array);$i<$n;$i++){
            $key=$key_array[$i];
            if(substr($key, 0,4)=='file'){                
                unset(Yii::app()->request->cookies[$key]);
            }
        }
        $affected = 1;
        $contributor_id = Yii::app()->request->cookies['id']->value;
        $data = array('type' => 1,
            'table_name' => 'bounty',
            'article_id' => $this->id,
            'contributor_id' => $contributor_id,
            'created_date' => $this->created_date,
            'last_updated_date' => $this->last_updated_date);

        if ($this->getIsNewRecord()) {
            $affected = Yii::app()->db->createCommand()->insert('update_information', $data);
        }

        if ($affected == 1) {
            $this->transaction->commit();
        } else {
            $this->transaction->rollback();
        }
    }

    public function saveBounty_apply() {
        $employee_number = FunctionCommon::getEmplNum();
        $model = new Bounty_apply();
        $model->bounty_id = $this->id;
        $now_for_file = date("YmdHis");

        $file = CUploadedFile::getInstance($model, 'attachment1');
        if ($file) {
//            $file_name = $file->name;
//            $bounty_apply->attachment_file_name = $file->name;
//            $bounty_apply->attachment_file_bytes = base64_encode(file_get_contents($file->tempName));
//            $bounty_apply->attachment_file_type = $file->type;
//
//            $path = Upload_config::getUploadPath('bounty_apply');
//            Upload_config::createFolder($path, Yii::getPathOfAlias('webroot'));
//            $attachment_path = $path . 'attachment1/';
//
//            $bounty_apply->attachment_file_name = FunctionCommon::fixFileName($bounty_apply->attachment_file_name);
//            $temp = explode(".", $bounty_apply->attachment_file_name);
//            $extension = $temp[count($temp) - 1];
//            if (in_array($extension, Constants::$imgExtention)) {
//                
//            }
//            $temp = explode("." . $extension, $bounty_apply->attachment_file_name);
//            $bounty_apply->attachment1 = $attachment_path . $temp[0] . '.' . $employee_number . '_' . $now_for_file . '.' . $extension;
//            fopen(Yii::getPathOfAlias('webroot') . $bounty_apply->attachment1, 'x');
//            file_put_contents(Yii::getPathOfAlias('webroot') . $bounty_apply->attachment1, base64_decode($bounty_apply->attachment_file_bytes));
                $path = Upload_config::getUploadPath('bounty_apply');
                Upload_config::createFolder($path, Yii::getPathOfAlias('webroot'));
                $attachment1_path = $path . 'attachment1/';
                $file_name = $file->name;


                $model->attachment_file_type = $file->type;

                $file_name =  Upload_file_common_new::fixFileName($file_name);
                $temp = explode(".", $file_name);
                $extension = $temp[count($temp) - 1];
                $temp = explode("." . $extension, $file_name);
                $model->attachment1 = $attachment1_path . $temp[0] . '.' . $employee_number . '_' . $now_for_file . '.' . $extension;
                if (in_array($extension, Constants::$imgExtention)) {
                    $file->saveAs(Yii::getPathOfAlias('webroot') . $model->attachment1, FALSE);
                    $thumnail_file_path = FunctionCommon::getFilenameInThumnail($model->attachment1);
                    $file->saveAs(Yii::getPathOfAlias('webroot') . $thumnail_file_path);
                } else {
                    $file->saveAs(Yii::getPathOfAlias('webroot') . $model->attachment1);
                }
               


                $url1 = ltrim($model->attachment1, '/');
                $size = getimagesize($url1);
                $w = $size[0];
                $h = $size[1];
                if (in_array($extension, Constants::$imgExtention)) {
                    if (($w >= Config::IMG_WIDTH_BIG && $h >= Config::IMG_HEIGHT_BIG) || ($w > Config::IMG_WIDTH_BIG && $h < Config::IMG_HEIGHT_BIG) || ($w < Config::IMG_WIDTH_BIG && $h > Config::IMG_HEIGHT_BIG)) {
                        $image = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . $model->attachment1);
                        $image->resize(Config::IMG_WIDTH_BIG, Config::IMG_HEIGHT_BIG);
                        $image->save();
                    }
                }
 
                if (in_array($extension, Constants::$imgExtention)) {
                    
                    $url2 = ltrim($thumnail_file_path, '/');
                    $size = getimagesize($url2);
                    $w = $size[0];
                    $h = $size[1];
                    if (($w >= Config::IMG_WIDTH_BIG && $h >= Config::IMG_HEIGHT_BIG) || ($w > Config::IMG_WIDTH_BIG && $h < Config::IMG_HEIGHT_BIG) || ($w < Config::IMG_WIDTH_BIG && $h > Config::IMG_HEIGHT_BIG)) {
                        $image = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . $thumnail_file_path);
                        $image->resize(Config::IMG_WIDTH_BIG, Config::IMG_HEIGHT_BIG);
                        $image->save();
                    }
                    $width = Config::IMG_WIDTH;
                    $height = 171;
                    list($width_orig, $height_orig) = getimagesize($url2);
                    $ratio_orig = $width_orig / $height_orig;
                    if ($width / $height > $ratio_orig) {
                        $width = $height * $ratio_orig;
                    } else {
                        $height = $width / $ratio_orig;
                    }
                    $image = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . $thumnail_file_path);
                    $image->resize($width, $height);
                    $image->save();
                   
                }

                
        }

        $textarea = $_POST['Bounty_apply']['applied_content'];
        $model->applied_content = $textarea;

        $model->applicant_id = FunctionCommon::getEmplNum();
        $model->created_date = FunctionCommon::getDateTimeSys();
        $model->last_updated_date = FunctionCommon::getDateTimeSys();
        $model->last_updated_person = FunctionCommon::getEmplNum();
        return $model->save();
    }

}

?>