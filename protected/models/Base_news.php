<?php

class Base_news extends CActiveRecord 
{

     public $base_id;
    

    /**
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
     */
    public static function model($className = __CLASS__) 
	{
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() 
	{
        return 'base_news';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() 
	{
        return array(
          
            array('base_id', 'required','message'=>Lang::MSG_M0060),
        );
    }

    /**
     *
     */
    public function getAllBases() 
	{
		$unit = Yii::app()->db->createCommand()
						->select(array(
							'unit.id',
							'unit.unit_name',
							'branch.branch_name',
							'base.company_name'
								)
						)
						->from('unit') 
						->join('branch', 'branch.id=unit.branch_id')
						->join('base', 'base.id=branch.base_id')
						->where("unit.active_flag=1 and unit.modifiable_flag=1 and branch.modifiable_flag=1 and base.modifiable_flag=1")
                                                ->andWhere("unit.cancel_random = 0 or unit.cancel_random is null")
						->order("base.display_order asc , unit.display_order asc")
						
						->queryAll();
						
        $result = array('' => '選んで下さい');
        if (is_array($unit) && count($unit) > 0) 
		{
            foreach ($unit as $units) 
			{
                $result[$units['id']] = $units['company_name'].' '.$units['branch_name'].' '.$units['unit_name'];
            }
        }
		
        return $result; 
    }
	
    /**
     *
     */
    public function follow($attribute) {}

    /**
     *
     */
    private function setNullForElementsNotEntered() 
	{
        $attributes = $this->getAttributes();
        foreach ($attributes as $key => $value) 
		{
            if (null == $value || '' == $value) 
			{
                $this->setAttribute($key, null);
            }
        }
    }

    /**
     *
     */
    public function beforeSave() 
	{
		$now = FunctionCommon::getDateTimeSys();        
        $this->last_updated_person = FunctionCommon::getEmplNum();
        if ($this->getIsNewRecord()) 
		{ //insert
            $this->created_date = $now;
			$this->contributor_id =Yii::app()->request->cookies['id'];
        }
        $this->last_updated_date = $now;
//        $this->setNullForElementsNotEntered();
        return parent::beforeSave();
    }

}