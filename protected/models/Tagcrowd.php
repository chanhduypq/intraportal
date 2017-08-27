<?php

class Tagcrowd extends CActiveRecord {

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
        return 'tagcrowd';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('keyword', 'filter', 'filter'=>array($this, 'trimText')),            
            array('keyword','required','message'=>Lang::MSG_0129),            
            array('keyword', 'length', 'max' => 512,'message'=>Lang::MSG_0130), 
            array('fontsize','required','message'=>Lang::MSG_0131),            
            
            array('id',
                   'follow'),
        );
    }
    public function follow($attribute) {}

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
    public function getAllFontsizes() {
        
        $result = array(
            '' => '選択して下さい',
            'S'=>'S',
            'M'=>'M',
            'L'=>'L',
            );
        
        return $result;
    }

    /**
     *
     */
    public function beforeSave() {        
        $now = FunctionCommon::getDateTimeSys();        
        $employee_number = FunctionCommon::getEmplNum();
        
        if ($this->getIsNewRecord()) {//insert
            $this->created_date = $now;      
            $max_dispaly_order=Yii::app()->db->createCommand()->select("max(display_order) as max")->from("tagcrowd")->queryScalar();
            if($max_dispaly_order==FALSE||$max_dispaly_order=='0'){
                $max_dispaly_order=1;
            }
            else{
                $max_dispaly_order++;
            }
            $this->display_order=$max_dispaly_order;
        }
        
        $this->last_updated_person= $employee_number;
        $this->last_updated_date = $now;
        
        $this->keyword = trim($this->keyword);
        
        
        
        $this->setNullForElementsNotEntered();
        
       
        return parent::beforeSave();
    }

    

    

   
    
    
    
    
}