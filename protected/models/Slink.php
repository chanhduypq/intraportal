<?php
class Slink extends CActiveRecord
{
	private $transaction;
	/**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Token the static model class
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
        return 'slink';
    }
	
	public function rules() 
	{
        return array(
		array('title,url', 'filter', 'filter'=>array($this, 'trimText')),
		array('type', 'required'),
		array('title','length', 'max' => 256),
		array('title', 'required','message'=>Lang::MSG_0002),
	
		array('url','length', 'max' => 512),
		array('url', 'required','message'=>Lang::MSG_0006),
		array('url','match','pattern'=>'/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i',
			  'message'=> Lang::MSG_0007),
			);
    }  

	public function trimText($str)
	{
		$str=preg_replace('/^\p{Z}+|\p{Z}+$/u','',$str);
		return $str;
	} 
	
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
		$this->transaction=$this->dbConnection->beginTransaction();   	
        $now=FunctionCommon::getDateTimeSys();
        if($this->getIsNewRecord())
		{
        	$this->created_date = $now;
                
        $this->contributor_id = Yii::app()->request->cookies['id'];
        }       
        $this->last_updated_person=FunctionCommon::getEmplNum();
        $this->last_updated_date = $now;
        $this->title=$this->title;
        $this->url=$this->url;
		
        $this->setNullForElementsNotEntered();
        return parent::beforeSave();        
    }
	
	/**
	 *  save update information
	 */
    public function afterSave() 
	{  
        $data=array(
		'type'=>1,
		'table_name'=>'slink',
		'article_id'=>$this->id,
		'contributor_id'=>Yii::app()->request->cookies['id']->value,
		'created_date'=>$this->created_date,
		'last_updated_date'=>  $this->last_updated_date,);
		$affected=1; 
        if($this->getIsNewRecord())
		{
            $affected=Yii::app()->db->createCommand()->insert('update_information', $data);
        }

        if($affected==1)
		{
            $this->transaction->commit(); 
        }
        else
		{
            $this->transaction->rollback();
        }       
        
    }
}