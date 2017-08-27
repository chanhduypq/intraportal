<?php

/**
 * This is the model class for table "functions".
 *
 * The followings are the available columns in table 'functions':
 * @property integer $id
 * @property string $function_name
 * @property string $controller
 * @property string $action
 * @property string $created_date
 * @property string $last_updated_date
 * @property string $last_updated_person
 */
class Functions extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Functions the static model class
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
		return 'functions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('function_name, controller, action, created_date, last_updated_date, last_updated_person', 'required'),
			array('function_name', 'length', 'max'=>50),
			array('controller', 'length', 'max'=>30),
			array('action', 'length', 'max'=>255),
			array('last_updated_person', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, function_name, controller, action, created_date, last_updated_date, last_updated_person', 'safe', 'on'=>'search'),
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
            'role_management'=>array(self::HAS_MANY,'Role_management','function_id'),
            
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'function_name' => 'Function Name',
			'controller' => 'Controller',
			'action' => 'Action',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('function_name',$this->function_name,true);
		$criteria->compare('controller',$this->controller,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('last_updated_date',$this->last_updated_date,true);
		$criteria->compare('last_updated_person',$this->last_updated_person,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}