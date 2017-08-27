<?php

class Unitedit extends CActiveRecord {

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
        return 'unit';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('catchphrase,introduction', 'filter', 'filter'=>array($this, 'trimText')),   
            array('catchphrase', 'length', 'max' => 128,'message'=>Lang::MSG_0116),  
            array('introduction', 'length', 'max' => 2000,'message'=>Lang::MSG_0117),  
            
            
            
            array('id,introduction,catchphrase',                  
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
            if ((null == $value || '' == $value)&&$key!='catchphrase'&&$key!='introduction'&&$key!='basenews_index'&&$key!='cancel_random') {
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
        
        
        
        
        $this->last_updated_person= $employee_number;
        $this->last_updated_date = $now;
        
        $this->catchphrase  = trim($this->catchphrase);
        $this->introduction = trim($this->introduction);
       
		$this->branch_id		= $_POST['Unitedit']['branch_id'];
		$this->office_id 		= $_POST['Unitedit']['office_id'];
		$this->display_order    = $_POST['Unitedit']['display_order'];
		$this->unit_name 		= $_POST['Unitedit']['unit_name'];
		
		$this->mailaddr			= $_POST['Unitedit']['mailaddr'];
		$this->attachment1 		= $_POST['Unitedit']['attachment1'];
		$this->attachment2      = $_POST['Unitedit']['attachment2'];
		$this->attachment3 		= $_POST['Unitedit']['attachment3'];
		$this->created_date 	= $_POST['Unitedit']['created_date'];
        
        $this->active_flag=true;
        $this->setNullForElementsNotEntered();
        
        return parent::beforeSave();
    }

    

    

   
    
    
    
    
}