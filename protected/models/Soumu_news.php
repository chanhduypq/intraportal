<?php

class Soumu_news extends CActiveRecord {

    public $attachment1_file_type;
    public $attachment1_checkbox_for_deleting;
    public $attachment2_file_type;
    public $attachment2_checkbox_for_deleting;
    public $attachment3_file_type;
    public $attachment3_checkbox_for_deleting;
    public $label;
    private $transaction;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Soumu_news the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'soumu_news';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title,content', 'filter', 'filter' => array($this, 'trimText')),
            array('title', 'required', 'message' => Lang::MSG_0002),
            array('content', 'required', 'message' => Lang::MSG_0003),
            array('title', 'length', 'max' => 256, 'message' => Lang::MSG_0012),
            array('content', 'length', 'max' => 3000, 'message' => Lang::MSG_0008),
            array('attachment1,attachment2,attachment3',
                'file', 'allowEmpty' => true, 'types' => '
                                                          doc,docx,
                                                          xls,xlsx,
                                                          ppt,pptx,                                                          
                                                          pdf,
                                                          zip,rar,
                                                          jpg,gif,png,jpeg,
                                                          ',
                'wrongType' => Lang::MSG_0004,
            ),
            /**
             * validation for capacity file
             */
            array('attachment1,attachment2,attachment3',
                'file', 'allowEmpty' => true, 'maxSize' => Config::MAX_FILE_SIZE * 1024 * 1024,
                'tooLarge' => Lang::MSG_0005,
            ),
            // The following rule is used by search().
            array('id,created_date,
                   attachment1,attachment2,attachment3,
            	   attachment1_file_type,attachment1_checkbox_for_deleting,
            	   attachment2_file_type,attachment2_checkbox_for_deleting,
            	   attachment3_file_type,attachment3_checkbox_for_deleting,label',
                'follow'),
        );
    }

    /*     * * */

    public function follow($attribute) {
        
    }

    /**
     *
     */
    private function setNullForElementsNotEntered() {
        $attributes = $this->getAttributes();
        foreach ($attributes as $key => $value) {
            if (null == $value || '' == $value) {
                $this->setAttribute($key, null);
            }
        }
    }

    /**
     * 
     */
    public function beforeSave() {

        $this->transaction = $this->dbConnection->beginTransaction();
        $this->last_updated_person = FunctionCommon::getEmplNum();


        $now = FunctionCommon::getDateTimeSys();
        if ($this->getIsNewRecord()) {
            $this->created_date = $now;
            $this->contributor_id = Yii::app()->request->cookies['id'];
        }
        $this->last_updated_date = $now;
        $this->title = trim($this->title);
        $this->content = trim($this->content);


        if ($this->getIsNewRecord() == true) {
            if (Yii::app()->request->cookies['file_soumu_news_regist_attachment1'] != "" && Yii::app()->request->cookies['file_soumu_news_regist_attachment1'] != "null") {
                $this->attachment1 = Yii::app()->request->cookies['file_soumu_news_regist_attachment1']->value;
            } else {
                $this->attachment1 = '';
            }
            if (Yii::app()->request->cookies['file_soumu_news_regist_attachment2'] != "" && Yii::app()->request->cookies['file_soumu_news_regist_attachment2'] != "null") {
                $this->attachment2 = Yii::app()->request->cookies['file_soumu_news_regist_attachment2']->value;
            } else {
                $this->attachment2 = '';
            }
            if (Yii::app()->request->cookies['file_soumu_news_regist_attachment3'] != "" && Yii::app()->request->cookies['file_soumu_news_regist_attachment3'] != "null") {
                $this->attachment3 = Yii::app()->request->cookies['file_soumu_news_regist_attachment3']->value;
            } else {
                $this->attachment3 = '';
            }
            unset(Yii::app()->request->cookies['file_soumu_news_regist_attachment1']);
            unset(Yii::app()->request->cookies['file_soumu_news_regist_attachment2']);
            unset(Yii::app()->request->cookies['file_soumu_news_regist_attachment3']);
        } else {
            if (Yii::app()->request->cookies['file_soumu_news_edit_attachment1'] != "" && Yii::app()->request->cookies['file_soumu_news_edit_attachment1'] != "null") {
                $this->attachment1 = Yii::app()->request->cookies['file_soumu_news_edit_attachment1']->value;
            }

            if (Yii::app()->request->cookies['file_soumu_news_edit_attachment2'] != "" && Yii::app()->request->cookies['file_soumu_news_edit_attachment2'] != "null") {
                $this->attachment2 = Yii::app()->request->cookies['file_soumu_news_edit_attachment2']->value;
            }

            if (Yii::app()->request->cookies['file_soumu_news_edit_attachment3'] != "" && Yii::app()->request->cookies['file_soumu_news_edit_attachment3'] != "null") {
                $this->attachment3 = Yii::app()->request->cookies['file_soumu_news_edit_attachment3']->value;
            }
            unset(Yii::app()->request->cookies['file_soumu_news_edit_attachment1']);
            unset(Yii::app()->request->cookies['file_soumu_news_edit_attachment2']);
            unset(Yii::app()->request->cookies['file_soumu_news_edit_attachment3']);

            /**
             * process attachment1
             */
            $attachment1 = Upload_file_common::getAttachmentById($this->id, 1, 'soumu_news');
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
            $attachment2 = Upload_file_common::getAttachmentById($this->id, 2, 'soumu_news');
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
            $attachment3 = Upload_file_common::getAttachmentById($this->id, 3, 'soumu_news');
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
     *  save update information
     */
    public function afterSave() {
        $cookie_collection =Yii::app()->request->cookies;           
        $key_array=$cookie_collection->getKeys(); 
        for($i=0,$n=count($key_array);$i<$n;$i++){
            $key=$key_array[$i];
            if(substr($key, 0,4)=='file'){                
                unset(Yii::app()->request->cookies[$key]);
            }
        }
        $contributor_id = Yii::app()->request->cookies['id'];
        $data = array(
            'type' => 1,
            'table_name' => 'soumu_news',
            'article_id' => $this->id,
            'contributor_id' => $contributor_id,
            'created_date' => $this->created_date,
            'last_updated_date' => $this->last_updated_date,
        );
        $affected = 1;
        if ($this->getIsNewRecord()) {
            $affected = Yii::app()->db->createCommand()->insert('update_information', $data);
        }


        if ($affected == 1) {
            $this->transaction->commit();
        } else {
            $this->transaction->rollback();
        }
        //FunctionCommon::compressImage($this->attachment1,  $this->attachment2,$this->attachment3);
    }

    /**
     * no validate checkbox delete is check
     */
    protected function beforeValidate() {
        Upload_file_common::findCFileValidateAndRemove($this, $this->validatorList);
        return parent::beforeValidate();
    }

    /*     * using trim data* */

    public function trimText($str) {
        $str = preg_replace('/^\p{Z}+|\p{Z}+$/u', '', $str);
        return $str;
    }

}