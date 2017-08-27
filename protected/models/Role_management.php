<?php

/**
 * This is the model class for table "role_management".
 *
 * The followings are the available columns in table 'role_management':
 * @property string $id
 * @property integer $role_id
 * @property integer $function_id
 * @property integer $baserole_id
 * @property string $created_date
 * @property string $last_updated_date
 * @property string $last_updated_person
 */
class Role_management extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Role_management the static model class
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
		return 'role_management';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		/*	array('role_id, function_id, baserole_id, created_date, last_updated_date, last_updated_person', 'required'),
			array('role_id, function_id, baserole_id', 'numerical', 'integerOnly'=>true),
			array('last_updated_person', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, role_id, function_id, baserole_id, created_date, last_updated_date, last_updated_person', 'safe', 'on'=>'search'),
	   */
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
            'role'=>array(self::BELONGS_TO,'Role','role_id'),
            'functions'=>array(self::BELONGS_TO,'Functions','function_id'),
            
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'role_id' => 'Role',
			'function_id' => 'Function',
			'baserole_id' => 'Baserole',
			'created_date' => 'Created Date',
			'last_updated_date' => 'Last Updated Date',
			'last_updated_person' => 'Last Updated Person',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('role_id',$this->role_id);
		$criteria->compare('function_id',$this->function_id);
		$criteria->compare('baserole_id',$this->baserole_id);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('last_updated_date',$this->last_updated_date,true);
		$criteria->compare('last_updated_person',$this->last_updated_person,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}