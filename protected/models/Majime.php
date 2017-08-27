<?php
/**
 * This is the model class for table "tbl_cms".
 *
 * The followings are the available columns in table 'tbl_cms':
 * @property integer $id
 * @property string $ten
 * @property string $chu_thich
 * @property string $noi_dung
 * @property integer $hien_thi
 * @property integer $time
 * @property integer $user
 */
class Majime extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TblCms the static model class
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
		return 'soumu_jinji';
	}

}