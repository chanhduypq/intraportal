<?php
class Base extends CLinkPager
{
   
    public $CPaginationObject;
   
    public function init() {
       
       $this->pages = $this->CPaginationObject;
       $this->cssFile = false;
       $this->maxButtonCount = 5;

       $this->htmlOptions = array();
       $this->id = 'pager';
       
       $this->footer = '';
       $this->header = '';    
         
	   $this->firstPageLabel = 'First';
	   $this->lastPageLabel = 'Last';
	 
       $this->nextPageLabel = 'Next';
	   $this->prevPageLabel = 'Prev';  
         
       parent::init();
    }  
   
    public function run()
	{
        $buttons=$this->createPageButtons();
        if(empty($buttons))
            return;
        $this->registerClientScript();
        echo '<div class="pagination">';
		echo $this->header;
        echo CHtml::tag('ul',$this->htmlOptions,implode("\n",$buttons));
		echo $this->footer;
        echo '</div>';
    }    

}