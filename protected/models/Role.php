<?php

/**
 * This is the model class for table "role".
 *
 * The followings are the available columns in table 'role':
 * @property integer $id
 * @property string $role_name
 * @property string $created_date
 * @property string $last_updated_date
 * @property string $last_updated_person
 */
class Role extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Role the static model class
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
		return 'role';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('role_name', 'filter', 'filter'=>array($this, 'trimText')),
			array('role_name', 'required','message'=>Lang::MSG_0064),
            array('role_name', 'unique','message'=>Lang::MSG_0065),
			array('role_name', 'length', 'max'=>40),
            array('last_updated_person', 'length', 'max'=>20),
           	array('id, role_name, created_date, last_updated_date, last_updated_person', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'user'=>array(self::HAS_MANY,'User','role_id'),
            'role_management'=>array(self::HAS_MANY,'role_management','role_id'),
            
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'role_name' => 'Role Name',
			'created_date' => 'Created Date',
			'last_updated_date' => 'Last Updated Date',
			'last_updated_person' => 'Last Updated Person',
		);
	}
    public function trimText($str)
	{
		$str=preg_replace('/^\p{Z}+|\p{Z}+$/u','',$str);
		return $str;
	}
}