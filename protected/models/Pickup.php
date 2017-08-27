<?php

class Pickup extends CActiveRecord {

    public $unit_id;
    

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
        return 'pickup';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() 
	{
        return array(
             array('unit_id,user_id', 'required'),
            
        );
    }

    /**
     *
     */
    public function getAllBases() 
	{
       /* $unit = Yii::app()->db->createCommand()
                ->select(array('id', 'branch_name'))
                ->from('base')
                ->queryAll();*/
		
		$unit = Yii::app()->db->createCommand()
							->select(array(
								'unit.id',
								'unit.unit_name',
								'unit.branch_id',
								'branch.branch_name',
								'base.company_name',
                                                                'unit.modifiable_flag'
									)
							)
							->from('unit')
							->join('branch', 'branch.id=unit.branch_id')
							->join('base', 'base.id=branch.base_id')
							->where("unit.active_flag=1 and branch.active_flag=1")
							->order("base.display_order asc , unit.display_order asc")
							->queryAll();
									
        $result = array('' => '選んで下さい');
        if (is_array($unit) && count($unit) > 0) 
		{
            foreach ($unit as $units) 
			{
                $result[$units['id']] = $units['company_name']." ".$units['branch_name']." ".$units['unit_name'];
            }
        }
        return $result;
    }
	/**
     *
     */
    public function getAllUsers() 
	{
		$result = array('' => '選んで下さい');
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
      
        if ($this->getIsNewRecord()) 
		{
            $this->created_date 	 = FunctionCommon::getDateTimeSys();
			$this->contributor_id 	 = Yii::app()->request->cookies['id'];
			$this->last_choice			 = $this->user_id;
        }
	    $this->last_updated_person   = FunctionCommon::getEmplNum();
	    $this->last_updated_date 	 = FunctionCommon::getDateTimeSys();

//        $this->setNullForElementsNotEntered();
        return parent::beforeSave();
    }
	
	/**
	 *
	 */
    
    public function getAllUsersByBaseId($unit_id) 
	{
        if($unit_id==''||!is_numeric($unit_id))
		{
            return NULL;
        }
		
        $data = array();
		$users = Yii::app()->db->createCommand()
                ->select(array('id', 'lastname','firstname'))
                ->from('user')
				->where('division1="'.$unit_id.'"')
				->orwhere('division2="'.$unit_id.'"')
				->orwhere('division3="'.$unit_id.'"')
				->orwhere('division4="'.$unit_id.'"')                        
                ->queryAll(); 
		
		if(is_array($users) && count($users)>0)
		{
			foreach($users as $item) 
			{
				  $data[] = $item;
			}
		}                
        return $data;
    }
	
	/**
	 *
	 */
    public function getCatchphraseAndCommentByUserId($user_id) 
	{
        if($user_id==''||!is_numeric($user_id))
		{
            return NULL;
        }
        $user = Yii::app()->db->createCommand()
                ->select(array( 'comment','catchphrase'))
                ->from('user')
                ->where("id=:id",array('id'=>$user_id))
                ->queryRow();
        return $user;
    }
    public function getAllLastFirstNameByUnitId($unit_id) {        
        $user = Yii::app()->db->createCommand()
                ->select(array('id', 'lastname','firstname'))
                ->from('user')
                ->where('division1='.$unit_id)
				->orwhere('division2='.$unit_id)
				->orwhere('division3='.$unit_id)
				->orwhere('division4='.$unit_id)             
                ->queryAll()
        ;
        $result = array('' => '選んで下さい');
        if (is_array($user) && count($user) > 0) {
            foreach ($user as $role) {
                $result[$role['id']] = $role['lastname']." ".$role['firstname'];
            }
        }
        return $result;
    }
	
    public function getAllLastFirstName() {
        $user = Yii::app()->db->createCommand()
                ->select(array('id', 'lastname','firstname'))
                ->from('user')
                ->queryAll()
        ;
        $result = array('' => '選んで下さい');
        if (is_array($user) && count($user) > 0) {
            foreach ($user as $role) {
                $result[$role['id']] = $role['lastname']." ".$role['firstname'];
            }
        }
        return $result;
    }

}