<?php

class Holiday extends CActiveRecord {

    /**
     * 
     */
    
    
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'holiday';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('title', 'filter', 'filter'=>array($this, 'trimText')),        
            array('title', 'length', 'max' => 256,'message'=>Lang::MSG_0012),  
            array('achive_date','required','message'=>Lang::MSG_0114),
            array('achive_date', 'type', 'type'=>'date', 'dateFormat'=>'yyyy/M/d','message'=>Lang::MSG_0115),
            array('status','required','message'=>Lang::MSG_0113),
            
            array('id,title',                  
                   'follow'),
        );
    }
    public function follow($attribute) {}
    public function getAllStatus() {
        
        $result = array(
            '' => '選択して下さい',
            '0'=>'休日',
            '1'=>'出勤'
            );
        
        return $result;
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
        $now = FunctionCommon::getDateTimeSys();        
        $employee_number = FunctionCommon::getEmplNum();
        
        if ($this->getIsNewRecord()) {//insert
            $this->created_date = $now;      
            
        }
        $temp=  explode("/", $this->achive_date);
        $this->achive_date=$temp[0].'-'.$temp[1].'-'.$temp[2];
        
        $this->last_updated_person= $employee_number;
        $this->last_updated_date = $now;
        
        $this->title = trim($this->title);
        
        
        
        $this->setNullForElementsNotEntered();
        
        return parent::beforeSave();
    }

    

    

   
    
    
    
    
}