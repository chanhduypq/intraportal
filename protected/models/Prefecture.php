<?php

/**
 * This is the model class for table "prefecture".
 *
 * The followings are the available columns in table 'prefecture':
 * @property string $id
 * @property string $area_name
 * @property string $prefecture_name
 * @property string $created_date
 * @property string $last_updated_date
 * @property string $last_updated_person
 */
class Prefecture extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return prefecture the static model class
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
		return 'prefecture';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'area_name' => 'Area Name',
			'Prefecture Name' => 'Prefecture Name',
			'created_date' => 'Created Date',
			'last_updated_date' => 'Last Updated Date',
			'last_updated_person' => 'Last Updated Person',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
}