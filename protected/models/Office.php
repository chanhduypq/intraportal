<?php

class Office extends CActiveRecord {

    
    public $photo_file_type;
    public $photo_checkbox_for_deleting;
    

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
        return 'office';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            /**
             * 
             */
            array('division_name,zipcode,address', 'filter', 'filter' => array($this, 'trimText')),
            array('zipcode', 'length', 'max' => 8),
            array('zipcode', 'required', 'message' => Lang::MSG_M0058),
            array('zipcode', 'match', 'pattern' => '/^\d{3}(?:[-]?)\d{4}$/', 'message' => Lang::MSG_M0059),
            array('division_name', 'required', 'message' => Lang::MSG_0127),                        
            array('address', 'required', 'message' => Lang::MSG_0069),            
            array('division_name', 'length', 'max' => 256),            
            array('address', 'length', 'max' => 512),            
            array('photo',
                'file', 'allowEmpty' => true, 'types' => 'jpg,gif,png,jpeg',
                'wrongType' => Lang::MSG_0004,
            ),
            array('photo',
                'file', 'allowEmpty' => true, 'maxSize' => Config::MAX_FILE_SIZE * 1024 * 1024,
                'tooLarge' => Lang::MSG_0005,
            ),
            array('photo,photo_file_type,photo_checkbox_for_deleting,googlemap                          
                        id,
                        ',
                'follow'),
        );
    }

    /**
     *
     */
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
        $this->last_updated_person = FunctionCommon::getEmplNum();
        $now = FunctionCommon::getDateTimeSys();        
        if ($this->getIsNewRecord()) {//insert
            $this->created_date = $now;            
        }
        $this->last_updated_date = $now;

        $this->division_name = trim($this->division_name);
        $this->zipcode = trim($this->zipcode);
        $this->address = trim($this->address);
        

        if ($this->getIsNewRecord() == true) {
            if (Yii::app()->request->cookies['file_office_regist_attachment4'] != "" && Yii::app()->request->cookies['file_office_regist_attachment4'] != "null") {
                $this->photo = Yii::app()->request->cookies['file_office_regist_attachment4']->value;
            } else {
                $this->photo = '';
            }
            unset(Yii::app()->request->cookies['file_office_regist_attachment4']);
            unset(Yii::app()->request->cookies['file_office_regist_attachment4_thumnail']);
        } else {
            if (Yii::app()->request->cookies['file_office_edit_attachment4'] != "" && Yii::app()->request->cookies['file_office_edit_attachment4'] != "null") {
                $this->photo = Yii::app()->request->cookies['file_office_edit_attachment4']->value;
            }


            unset(Yii::app()->request->cookies['file_office_edit_attachment4']);
            unset(Yii::app()->request->cookies['file_office_edit_attachment4_thumnail']);


            /**
             * process attachment1
             */
            $attachment4 = Yii::app()->db->createCommand()->select('photo')->from('office')->where("id=" . $this->id)->queryScalar();

            if ($this->photo_checkbox_for_deleting == '1') {//delete
                /**
                 * delete old file if exists
                 */

                if ($attachment4 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment4)) {
                    unlink(Yii::getPathOfAlias('webroot') . $attachment4);
                    $thumnail_file_path = FunctionCommon::getFilenameInThumnail($attachment4);
                    if (file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)) {
                        unlink(Yii::getPathOfAlias('webroot') . $thumnail_file_path);
                    }
                }
                /**
                 * for update attachment1 field=null
                 */
                $this->photo = NULL;
            } else if ($this->photo_checkbox_for_deleting == '0') {//keep old stastus
                /**
                 * 
                 */
                if ($this->photo != $attachment4) {//upload new file
                    if ($attachment4 != "" && file_exists(Yii::getPathOfAlias('webroot') . $attachment4)) {
                        unlink(Yii::getPathOfAlias('webroot') . $attachment4);
                        $thumnail_file_path = FunctionCommon::getFilenameInThumnail($attachment4);
                        if (file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)) {
                            unlink(Yii::getPathOfAlias('webroot') . $thumnail_file_path);
                        }
                    }
                }
            }
        }
        /**
         *
         */
        $this->setNullForElementsNotEntered();
        /**
         * 
         */
        return parent::beforeSave();
    }

    private function getPhotoById($id) {
        $attachment = Yii::app()->db->createCommand()->select('photo')->from("office")->where("id=$id")->queryScalar();
        if ($attachment == FALSE) {
            return '';
        }
        return $attachment;
    }

    

    

    /**
     * 
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

        
    }

    /*     * using trim data* */

    public function trimText($str) {
        $str = preg_replace('/^\p{Z}+|\p{Z}+$/u', '', $str);
        return $str;
    }

//    protected function beforeValidate() {
//
//        Upload_file_common::findCFileValidateAndRemove($this, $this->validatorList);
//        return parent::beforeValidate();
//    }

    

}