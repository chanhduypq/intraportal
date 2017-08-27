<?php

class Celebrate extends CActiveRecord {

    /**
     * 
     */
    public $record_year;
    public $record_month;
    public $record_day;
	public $unit;
    private $transaction;

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
        return 'celebrate';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
	{
        return array(
            array('employee_name', 'filter', 'filter'=>array($this, 'trimText')),
			array('type', 'required'),
            array('category_id', 'required','message'=>Lang::MSG_0010),
            array('employee_name','required','message'=>Lang::MSG_0109),
            /**
             * 
             */
            array('employee_name', 'length', 'max' => 64),
            /**
             * 
             */
            array('record_day,record_month,record_year,
                   created_date,
                   unit_id,
                   category_id,
                   id
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

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'employee_name' => '名前',
            'category_id' => 'カテゴリー',
        );
    }

    /**
     * 
     */
    public function getAllBases() {
        $items = Yii::app()->db->createCommand()
                ->select(array('id', 'unit_name'))
                ->from('unit')
                ->queryAll()
        ;
        $bases = array();
        $bases[''] = '選んで下さい';
        if (is_array($items) && count($items) > 0) {
            foreach ($items as $item) {
                $bases[$item['id']] = $item['unit_name'];
            }
        }
        return $bases;
    }

    public function getAllCategorys() {
        $items = Yii::app()->db->createCommand()
                ->select(array('id', 'category_name'))
                ->from('category')
                ->where('type=:type', array('type' => 1))
                ->queryAll()
        ;
        $categorys = array();
        $categorys[''] = '選んで下さい';
        if (is_array($items) && count($items) > 0) {
            foreach ($items as $item) {
                $categorys[$item['id']] = $item['category_name'];
            }
        }
        return $categorys;
    }

    /**
     *
     */
    public function getAllRecordMonth() {
        $result = array();
        for ($i = 1; $i <= 12; $i++) {
            $result[$i] = $i;
        }
        return $result;
    }

    /**
     *
     */
    public function getAllRecordYear() {
        $result = array();
        for ($i = date('Y'), $n = date('Y') + 5; $i <= $n; $i++) {
            $result[$i] = $i;
        }
        return $result;
    }

    /**
     *
     */
    public function getAllRecordDay() {
        $result = array();
        for ($i = 1; $i <= 31; $i++) {
            $result[$i] = $i;
        }
        return $result;
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
        /**
         *
         */  
        if($this->getIsNewRecord()){
                     
        }        
        /**
         *
         */
        $now = FunctionCommon::getDateTimeSys();
        if ($this->getIsNewRecord()) {//insert
            $this->created_date = $now;
			 $this->contributor_id = Yii::app()->request->cookies['id']->value;
        }
        $this->last_updated_date = $now;
        $this->last_updated_person= FunctionCommon::getEmplNum();
        /**
         * 
         */
        $this->employee_name = trim($this->employee_name);
        $this->record_date = $this->record_year . '-' . $this->record_month . '-' . $this->record_day;
        /**
         * 
         */
        $this->setNullForElementsNotEntered();
        /**
         * 
         */
        return parent::beforeSave();
    }

    

}