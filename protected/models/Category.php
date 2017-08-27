<?php
/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property string $id
 * @property integer $type
 * @property string $category_name
 * @property string $contributor_id
 * @property string $created_date
 * @property string $last_updated_date
 * @property string $last_updated_person
 */
class Category extends CActiveRecord
{
    private $transaction;
   
    public $category_avatar_checkbox_for_deleting;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'category';
	}

	public function relations()
    {
        return array(
						'hobby_new' => array(self::HAS_MANY, 'Hobby_new', 'category_id'),
					);
    }
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_name', 'filter', 'filter'=>array($this, 'trimText')),
            array('category_name', 'required','message'=>Lang::MSG_0011),
			array('category_name', 'length', 'max'=>64),
                    array('category_avatar',
                'file', 'allowEmpty' => true, 'types' => '                                                          
                                                          jpg,gif,png,jpeg,
                                                          ',
                'wrongType'=>Lang::MSG_0004,
            ),
            /**
             * 
             */
           array('category_avatar',
                'file', 'allowEmpty' => true, 'maxSize' => Config::MAX_FILE_SIZE * 1024 * 1024,
                'tooLarge'=>Lang::MSG_0005,
            ),
                    array('category_avatar_checkbox_for_deleting',
                'follow'),
			
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, category_name, contributor_id, created_date, last_updated_date, last_updated_person', 'safe', 'on'=>'search'),
		);
	}
    
    public function trimText($str)
	{
		$str=preg_replace('/^\p{Z}+|\p{Z}+$/u','',$str);
		return $str;
	} 


	/****/
	public function follow($attribute){}
	
	/****/
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
	
	public function beforeSave() 
	{  
		$now_for_record = FunctionCommon::getDateTimeSys();      
        if($this->getIsNewRecord())
		{
        	$this->created_date = $now_for_record;
			$this->contributor_id = Yii::app()->request->cookies['id']->value;
        }     
		
		$employee_number= FunctionCommon::getEmplNum();
        $this->last_updated_person= $employee_number;
        $this->last_updated_date = $now_for_record;
    
        $this->setNullForElementsNotEntered();
        return parent::beforeSave();         
    }

}