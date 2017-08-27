<?php

/**
 * This is the model class for table "ranking_details".
 *
 * The followings are the available columns in table 'ranking_details':
 * @property string $id
 * @property string $ranking_id
 * @property string $rank
 * @property string $name
 * @property string $unit
 * @property string $created_date
 * @property string $last_updated_date
 * @property string $last_updated_person
 */
class Ranking_details extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RankingDetails the static model class
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
		return 'ranking_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ranking_id, rank, name, unit, created_date, last_updated_date, last_updated_person', 'required'),
			array('ranking_id', 'length', 'max'=>10),
			array('rank', 'length', 'max'=>12),
			array('name', 'length', 'max'=>64),
			array('unit', 'length', 'max'=>48),
			array('last_updated_person', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ranking_id, rank, name, unit, created_date, last_updated_date, last_updated_person', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ranking_id' => 'Ranking',
			'rank' => 'Rank',
			'name' => 'Name',
			'unit' => 'Unit',
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
		$criteria->compare('ranking_id',$this->ranking_id,true);
		$criteria->compare('rank',$this->rank,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('unit',$this->unit,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('last_updated_date',$this->last_updated_date,true);
		$criteria->compare('last_updated_person',$this->last_updated_person,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}