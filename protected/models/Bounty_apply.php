<?php
class Bounty_apply extends CActiveRecord
{
	public $attachment_file_name;    
    public $attachment_file_bytes; 
    public $attachment_file_type; 
	public $attachment_checkbox_for_deleting;
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
        return 'bounty_apply';
    }
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() 
	{
        return array(
        array('applied_content', 'filter', 'filter'=>array($this, 'trimText')),
        array('applied_content', 'required','message'=>Lang::MSG_0003), 
        
    	array('attachment1','file','allowEmpty'=>true,
		  'types'=> 'doc,docx,xls,xlsx,ppt,pptx,pdf,zip,rar,jpg,gif,png,jpeg',
		  'wrongType'=>Lang::MSG_0004,
		  'maxSize'=>5*1024*1024,
		  'tooLarge'=>Lang::MSG_0005),    
		  
		array('attachment,attachment_file_name,attachment_file_bytes,attachment_file_type,
			  attachment_checkbox_for_deleting,
			  id,created_date,bounty_id,open_type,adopted_comment','follow'),);
    }  
	
     /**using trim data**/
	public function trimText($str)
	{
		$str=preg_replace('/^\p{Z}+|\p{Z}+$/u','',$str);
		return $str;
	} 
    
	/****/
	public function follow($attribute){}
	
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
		if(!$this->getIsNewRecord())
		{
			$this->last_updated_date = FunctionCommon::getDateTimeSys();
			$this->last_updated_person= FunctionCommon::getEmplNum();
		}
		$this->setNullForElementsNotEntered();
        return parent::beforeSave();
	}

}
?>