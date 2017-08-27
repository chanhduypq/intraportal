<?php

/**
 * This is the model class for table "bbs_response".
 *
 * The followings are the available columns in table 'bbs_response':
 * @property integer $id
 * @property string $bbs_id
 * @property string $content
 * @property string $contributor_id
 * @property string $created_date
 * @property string $last_updated_date
 * @property string $last_updated_person
 * @property integer $active_flag
 */
class Ideas_comment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ideas_comment the static model class
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
		return 'ideas_comment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			  array('comment', 'filter', 'filter'=>array($this, 'trimText')),
			  array('comment', 'required','message'=>Lang::MSG_0014),
			  array('valuation', 'required'), 
		);
	}
	/**
     * trim spa and spage
     */
	public function trimText($str)
	{
		$str=preg_replace('/^\p{Z}+|\p{Z}+$/u','',$str);
		return $str;
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
			'ideas_id' => 'Ideas',
			'comment' => 'Comment',
			'valuation' => 'Valuation',
			'contributor_id' => 'Contributor',
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