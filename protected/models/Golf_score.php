<?php

/**
 * This is the model class for table "golf_score".
 *
 * The followings are the available columns in table 'golf_score':
 * @property string $id
 * @property integer $category_id
 * @property string $achive_date
 * @property string $employee_name
 * @property string $contributor_id
 * @property string $created_date
 * @property string $last_updated_date
 * @property string $last_updated_person
 */
class Golf_score extends CActiveRecord
{
	//public $category_id; 
	public $deadline_year; 
	public $deadline_month; 
	public $deadline_day; 
	private $transaction;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Golf_score the static model class
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
		return 'golf_score';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('score,score_name', 'filter', 'filter'=>array($this, 'trimText')),	
			array('score,score_name', 'checkNumber'),
			array('score_name', 'length','max'=>64),
			array('deadline_year,deadline_day,deadline_month,id,created_date',
            		'follow'),
			
		);
	}
	
 	public function checkNumber($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			if(trim($this->score)==""){	
		   		$this->addError('score',Lang::MSG_0134);
		    }
			else if (!is_numeric(trim($this->score))) 
		    {	
		   		$this->addError('score',Lang::MSG_0136);
		    } 
			if(trim($this->score_name)==""){	
		   		$this->addError('score_name',Lang::MSG_0135);
		    }
		}
	}

	/**
     * trim spa and spage
     */
	public function trimText($str)
	{
		$str=preg_replace('/^\p{Z}+|\p{Z}+$/u','',$str);
		return $str;
	}
	public function follow($attribute) {           
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
	
	public function beforeSave()
	{  
		 //$this->transaction=$this->dbConnection->beginTransaction();  
		 if($this->getIsNewRecord())
		 {
			$this->contributor_id=Yii::app()->request->cookies['id'];  
		 }
		 $this->last_updated_person=FunctionCommon::getEmplNum();
		 return parent::beforeSave();    
	}
/**
	 *  save update information
	 */
   /* public function afterSave() 
	{  
        $contributor_id=Yii::app()->request->cookies['id'];  
		$now =  FunctionCommon::getDateTimeSys();
       
        $this->created_date 	 = $now;
        $this->last_updated_date = $now;  
		    
        $data=array(
                   'type'=>2,
                   'table_name'=>'golf_score',
                   'article_id'=>$this->id,
                   'contributor_id'=>$contributor_id,
                   'created_date'=>$this->created_date,
                   'last_updated_date'=>  $this->last_updated_date,
        );
		$affected=1;  
        if($this->getIsNewRecord()){
            $affected=Yii::app()->db->createCommand()
                ->insert('update_information', $data);
        }
        if($affected==1){
            $this->transaction->commit(); //convert  talbe type MyISAM -> InnoDB run transaction
        }
        else{
            $this->transaction->rollback();
        }       
        
    }	*/
}