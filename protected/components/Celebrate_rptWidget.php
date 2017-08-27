<?php
class Celebrate_rptWidget extends CWidget
{
	public $assets_base;
	
	
	
	
	
        private function getCategories(){
            $categories=Yii::app()->db->createCommand()
                    ->select(array('id','category_avatar','category_name'))
                    ->from('category')                    
                    ->where('category.type=8')
                    ->order('created_date DESC')
                    ->queryAll()
                    ;
            return $categories;
                    
        }
        private function getCelebrates($category_id){
            $celebrates=Yii::app()->db->createCommand()
                    ->select(array('base.company_name','unit.unit_name','branch.branch_name','employee_name'))
                    ->from('celebrate')                    
                    ->leftJoin('unit','unit.id=celebrate.unit_id')
                    ->leftJoin('branch', 'unit.branch_id=branch.id')
                    ->leftJoin('base', 'base.id=branch.base_id')
                    ->where('celebrate.category_id='.$category_id)
                    ->order('celebrate.created_date DESC')
                    ->queryAll()
                    ;
            return $celebrates;
                    
        }

        public function run()
	{
            
	?>
    <style>
	li.listtxt, li.listPerson{ float:right !important; width:85px;}
	</style>
    <?php	
		if(FunctionCommon::isViewFunction("celebrate_rpt"))
		{
			$img_wedding	=$this->assets_base.'/css/asobi/img/img_wedding.jpg';
			$img_myhome		=$this->assets_base.'/css/asobi/img/img_myhome.jpg';
			$img_baby		=$this->assets_base.'/css/asobi/img/img_baby.jpg';
			
			echo '<div class="box celebration pink">';
			echo '<h2 class="ttl">お祝い報告</h2>';
			
			
                        $categories=  $this->getCategories();
                        if(is_array($categories)&&count($categories)>0){
                            foreach ($categories as $category){
                                $celebrates=  $this->getCelebrates($category['id']);
                                if(is_array($celebrates)&&count($celebrates)){
                                    echo '<dl class="celebrate_marriage">';
                                    echo '<dt>'.htmlspecialchars($category['category_name']).'</dt>';
                                    echo '<dd>';
                                    echo '<ul>';                                
                                    echo '<li class="listImg">';
                                    if($category['category_avatar']!=""&&  file_exists(Yii::getPathOfAlias('webroot').$category['category_avatar'])){
                                        echo '<img style="height:52px;" src="'.Yii::app()->baseUrl.$category['category_avatar'].'"/>';
                                    }
                                    echo '</li>';
                                    echo '<li class="listtxt">';


                                    foreach ($celebrates as $celebrate){
                                        echo '<p class="name">'.$celebrate['employee_name'].'</p>';
                                        if($celebrate['company_name']!=""||$celebrate['company_name']!=""||$celebrate['company_name']!=""){
                                            echo '<span class="area">（'.$celebrate['company_name'].' '.$celebrate['branch_name'].' '.$celebrate['unit_name'].'）</span>';
                                        }                                      
                                        
                                    }


                                    echo '</li>';
                                    echo '</ul>';
                                    echo '</dd>';
                                    echo '</dl>';
                                }
                                
                            }
                        }
				
			
						
			echo '</div>';
		}
	}
}





