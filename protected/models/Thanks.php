<?php

class Thanks extends CActiveRecord {

    public $unit_id;
    

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
        return 'thanks';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('comment,sender', 'filter', 'filter' => array($this, 'trimText')),
            /**
             * 
             */
            array('sender', 'required', 'message' => Lang::MSG_0099),
            array('comment', 'required', 'message' => Lang::MSG_0014),
            array('unit_id', 'required', 'message' => Lang::MSG_0102),
            array('user_id', 'required', 'message' => Lang::MSG_0101),
            /**
             * 
             */
            array('sender', 'length', 'max' => 64, 'message' => Lang::MSG_0100),
            array('comment', 'length', 'max' => 512, 'message' => Lang::MSG_0013),
            /**
             * 
             */
            array('created_date,
                        id,
                        ',
                'follow'),
        );
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
    public function follow($attribute) {
        
    }

    public function getAllBases() {
        $bases = Yii::app()->db->createCommand()
                ->select(array('id', 'branch_name'))
                ->from('base')
                ->queryAll()
        ;
        $result = array('' => '選んで下さい');
        if (is_array($bases) && count($bases) > 0) {
            foreach ($bases as $base) {
                $result[$base['id']] = $base['branch_name'];
            }
        }
        return $result;
    }

    public function getAllUsers() {
        $result = array('' => '選んで下さい');
        return $result;
    }

    /**
     *
     */
    public function beforeSave() {
        //$this->transaction = $this->dbConnection->beginTransaction();
        $employee_number = FunctionCommon::getEmplNum();
        $this->last_updated_person = $employee_number;
        $now = FunctionCommon::getDateTimeSys();

        if ($this->getIsNewRecord()) {//insert
            $this->created_date = $now;
            $this->contributor_id = Yii::app()->request->cookies['id'];
        }
        $this->last_updated_date = $now;

        $this->sender = trim($this->sender);
        $this->comment = trim($this->comment);


        return parent::beforeSave();
    }

//    public function afterSave() {
//        $use_id=Yii::app()->db->createCommand("select count(*) as count from user where id=".$this->user_id)->queryScalar();
//        if($use_id=='0'){
//            if($this->getIsNewRecord()==FALSE){
//                $this->transaction->commit();
//                $this->deleteByPk($this->id);                
//            }
//            else{
//                $this->transaction->rollback();
//            }
//        }
//       
//    }

}