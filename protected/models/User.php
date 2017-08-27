<?php

class User extends CActiveRecord {

    /**
     * 
     */
    public $flag_for_save_by_upload_file_csv;
    public $photo_file_type;
    public $photo_checkbox_for_deleting;
    public $birthday_year;
    public $birthday_month;
    public $birthday_day;
    public $role_name;
	
	public $div_intro_modifiable_flag1;
    public $div_intro_modifiable_flag2;
    public $div_intro_modifiable_flag3;
	public $div_intro_modifiable_flag4;
	
	
    private $transaction;

    // Baodt password validation
    // date 30/07/2013
    public function validatePassword($passwd) {
        return $passwd == $this->passwd;
    }

    /**
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('employee_number,mailaddr,
                  lastname,firstname,
                  lastname_kana,firstname_kana,
                  joindate,comment,catchphrase', 'filter', 'filter' => array($this, 'trimText')),
            array('role_id', 'required', 'message' => Lang::MSG_0015),
            /**
             * 
             */
            array('employee_number', 'required', 'message' => Lang::MSG_0032),
            array('mailaddr', 'required', 'message' => Lang::MSG_0018),
            array('lastname', 'required', 'message' => Lang::MSG_0024),
            array('firstname', 'required', 'message' => Lang::MSG_0025),
            array('lastname_kana', 'required', 'message' => Lang::MSG_0026),
            array('firstname_kana', 'required', 'message' => Lang::MSG_0027),
            array('joindate', 'required', 'message' => Lang::MSG_0021),
            array('passwd', 'required', 'message' => Lang::MSG_0044),
            /**
             * 
             */
            array('employee_number', 'length', 'max' => 24),
            array('mailaddr', 'length', 'max' => 256),
            array('lastname', 'length', 'max' => 32),
            array('firstname', 'length', 'max' => 32),
            array('lastname_kana', 'length', 'max' => 32),
            array('firstname_kana', 'length', 'max' => 32),
           
			
            
			
            array('catchphrase', 'length', 'max' => 128),
            array('comment', 'length', 'max' => 2000),
            array('passwd', 'length', 'max' => 20, 'message' => Lang::MSG_0061),
            /**
             * 
             */
            array('passwd', 'character'),
            /**
             * 
             */
            array('photo',
                'file', 'allowEmpty' => TRUE, 'types' => '                                                          
                                                          jpg,gif,png,jpeg,
                                                          ',
                'wrongType' => Lang::MSG_0033,
            ),
            /**
             * 
             */
            array('photo',
                'file', 'allowEmpty' => TRUE, 'maxSize' => Config::MAX_FILE_SIZE * 1024 * 1024,
                'tooLarge' => '添付ファイルの容量は' . Config::MAX_FILE_SIZE . 'MBを超えています。',
            ),
            /**
             * 
             */
            array('employee_number', 'unique', 'message' => Lang::MSG_0028),
            array('mailaddr', 'unique', 'message' => Lang::MSG_0020),
            /*
             * 
             */
            array('mailaddr', 'email', 'message' => Lang::MSG_0019),
            /**
             * 
             */
            array('joindate', 'numerical', 'integerOnly' => true, 'message' => Lang::MSG_0022),
            array('employee_number', 'numerical', 'integerOnly' => true, 'message' => Lang::MSG_0029),
            array('joindate', 'length', 'max' => 4),
            /**
             * 
             */
            array('role_id', 'exist', 'attributeName' => 'id', 'className' => 'Role', 'message' => Lang::MSG_0063),
            /**
             * 
             */
            array('     
                photo,
                photo_file_type,photo_checkbox_for_deleting,            		
                created_date,
                birthday,    
                birthday_year,birthday_month,birthday_day,                
                role_name,
                id,
                cancel_random,
				division1,
				division2,
				division3,
				division4,
				position1,
				position2,
				position4,
				position3,
				div_intro_modifiable_flag1,
				div_intro_modifiable_flag2,
				div_intro_modifiable_flag3,
				div_intro_modifiable_flag4
               ',
                'follow'),
        );
    }
 
    public function character($attribute) {
        if (preg_match("/^[a-zA-Z0-9]+$/", $this->$attribute) == 0) {
            $this->addError($attribute, Lang::MSG_0061);
        }
    }

    /**
     * 
     */
    public function trimText($str) {
        $str = preg_replace('/^\p{Z}+|\p{Z}+$/u', '', $str);
        return $str;
    }

    /**
     *
     */
    public function getAllRoles() {
        $roles = Yii::app()->db->createCommand()
                ->select(array('id', 'role_name'))
                ->from('role')
                ->queryAll()
        ;
        $result = array('' => '選んで下さい');
        if (is_array($roles) && count($roles) > 0) {
            foreach ($roles as $role) {
                $result[$role['id']] = $role['role_name'];
            }
        }
        return $result;
    }

    /**
     *
     */
    public function getAllBirthdayMonth() {
        $result = array();
        for ($i = 1; $i <= 12; $i++) {
            $result[$i] = $i;
        }
        return $result;
    }

    /**
     *
     */
    public function getAllBirthdayYear() {
        $result = array();
        for ($i = 1920; $i <= date('Y'); $i++) {
            $result[$i] = $i;
        }
        return $result;
    }

    /**
     *
     */
    public function getAllBirthdayDay() {
        $result = array();
        for ($i = 1; $i <= 31; $i++) {
            $result[$i] = $i;
        }
        return $result;
    }

    /**
     *
     */
    public function follow($attribute) {
        
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'employee_number' => '社員番号',
            'mailaddr' => 'メールアドレス',
            'role_id' => '役割名',
            'joindate' => '入社年',
        );
    }

    /**
     *
     */
    public function setNullForElementsNotEntered() {
        $attributes = $this->getAttributes();
        foreach ($attributes as $key => $value) {
            if (null == $value || '' == $value) {
                $this->setAttribute($key, null);
            }
        }
    }
    public function afterSave() {
        parent::afterSave();
        if($this->getIsNewRecord()==true){
                $index_max=Yii::app()->db->createCommand()
                    ->select("max(pickup_index) as max")
                    ->from("user")
                    ->queryScalar()
                    ;
            if($index_max==FALSE){
                $index_max=0;
            }
            if($index_max>0){
                $index_max--;
            }
            Yii::app()->db->createCommand("update user set pickup_index=$index_max where id=".$this->id)->execute();
        }
        else{
            if($this->cancel_random==1){
                $index_max=Yii::app()->db->createCommand()
                    ->select("max(pickup_index) as max")
                    ->from("user")
                    ->queryScalar()
                    ;
                if($index_max==FALSE){
                    $index_max=0;
                }
                if($index_max>0){
                    if($this->pickup_index<$index_max){
                        $index_max--;
                        Yii::app()->db->createCommand("update user set pickup_index=$index_max where id=".$this->id)->execute();
                    }

                }
            }
            
        }
    }

    /**
     *
     */
    public function beforeSave() {
		
        /**
         *
         */
        $this->last_updated_person = FunctionCommon::getEmplNum();
        /**
         *
         */
        $now = FunctionCommon::getDateTimeSys();

        if ($this->getIsNewRecord()) {//insert            
            $this->created_date = $now;
        }
        $this->last_updated_date = $now;
        /**
         * 
         */
        if ($this->getIsNewRecord()) {
            $this->passwd = '7581';
        }
//        Yii::import('ext.helpers.CPasswordHelper');
//        $password_helper=new CPasswordHelper();
//        $this->passwd=$password_helper->hashPassword($this->passwd);


        /**
         * 
         */
        $this->employee_number = trim($this->employee_number);
        $this->mailaddr = trim($this->mailaddr);
        $this->lastname = trim($this->lastname);
        $this->firstname = trim($this->firstname);
        $this->lastname_kana = trim($this->lastname_kana);
        $this->firstname_kana = trim($this->firstname_kana);
        $this->joindate = trim($this->joindate);
		$this->active_flag = true;
      
        
		
		$this->division1 = $this->division1;
		$this->position1 = trim($this->position1);
		$this->div_intro_modifiable_flag1 = $this->div_intro_modifiable_flag1;
		
		$this->division2 = $this->division2;
		$this->position2 = $this->position2;
		$this->div_intro_modifiable_flag2 = $this->div_intro_modifiable_flag2;
		
		$this->division3 = $this->division3;
		$this->position3 = $this->position3;
		$this->div_intro_modifiable_flag3 = $this->div_intro_modifiable_flag3;
		
		$this->division4 = $this->division4;
		$this->position4 = $this->position4;
		$this->div_intro_modifiable_flag4 = $this->div_intro_modifiable_flag4;
			
        
        $this->catchphrase = trim($this->catchphrase);
        $this->comment = trim($this->comment);
        if ($this->birthday_year != NULL && trim($this->birthday_year) != "") {
            $this->birthday = $this->birthday_year . '-' . $this->birthday_month . '-' . $this->birthday_day;
        }

        /**
         * 
         */
        /**
         * 
         */
        if ($this->getIsNewRecord() == true) {            
            if (Yii::app()->request->cookies['file_user_regist_attachment4'] != "" && Yii::app()->request->cookies['file_user_regist_attachment4'] != "null") {
                $this->photo = Yii::app()->request->cookies['file_user_regist_attachment4']->value;
            } else {
                if($this->flag_for_save_by_upload_file_csv==NULL||$this->flag_for_save_by_upload_file_csv!=TRUE){
                    $this->photo = '';
                }
                
            }
            unset(Yii::app()->request->cookies['file_user_regist_attachment4']);
            unset(Yii::app()->request->cookies['file_user_regist_attachment4_thumnail']);
        } else {
            if (Yii::app()->request->cookies['file_user_edit_attachment4'] != "" && Yii::app()->request->cookies['file_user_edit_attachment4'] != "null") {
                $this->photo = Yii::app()->request->cookies['file_user_edit_attachment4']->value;
            }


            unset(Yii::app()->request->cookies['file_user_edit_attachment4']);
            unset(Yii::app()->request->cookies['file_user_edit_attachment4_thumnail']);


            /**
             * process attachment1
             */
            $attachment4 = Yii::app()->db->createCommand()->select('photo')->from('user')->where("id=" . $this->id)->queryScalar();

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

    /**
     *
     */
    public static function fixFileName($fileName) {
        if ($fileName == null || (!is_string($fileName)) || trim($fileName) == "") {
            return $fileName;
        }
        $fileName = str_replace("%", "", $fileName);
        $fileName = str_replace("[", "_", $fileName);
        $fileName = str_replace("]", "_", $fileName);
        return $fileName;
    }

    protected function beforeValidate() {

        $this->findCFileValidateAndRemove($this->validatorList);
        return parent::beforeValidate();
    }

    /**
     * 
     */
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
     * 
     */
    private function removeFileValidate(&$attributes) {
        if ($this->photo_checkbox_for_deleting == '1') {
            foreach ($attributes as $key => $value) {
                if ($value == 'photo') {
                    unset($attributes[$key]);
                }
            }
        }
    }

    /*
     * Create Date:20130808 
     * Update Date: 
     * Author: Hai Nguyen 
     * User change: 
     * Return :Fullname
     * Description:This is method using get fullname
     * */

    public function getFullName() {
        $firstname = $this->firstname;
        $lastname = $this->lastname;
        return $lastname . ' ' . $firstname;
    }

}