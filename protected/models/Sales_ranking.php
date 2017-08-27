<?php
class Sales_ranking extends CActiveRecord
{
   
	private $transaction;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return sales_ranking the static model class
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
		return 'sales_ranking';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	 public function rules() {
        return array(
          
            //array('machine_name, ranking_name', 'required'),
            array('ranking_name', 'length', 'min'=>1 ,'max' => 128),
            
        );
    }    
    /**
     * @return array customized attribute labels (name=>label)
     */
   
}