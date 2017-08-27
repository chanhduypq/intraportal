<?php

class Celebratewidget extends CWidget {

    public function run() {
       
        $items = Yii::app()->db->createCommand()
                ->select(array('id', 'category_name'))
                ->from('category')
                ->where('type=:type', array('type' => 1))
                ->queryAll()
        ;
        $categories = array();        
        if (is_array($items) && count($items) > 0) {
            foreach ($items as $item) {
                $categories[$item['id']] = $item['category_name'];
            }
        } 
	    $now 	 = explode('/', date("Y/m/d"));
        if(FunctionCommon::isViewFunction("celebrate")==true){
            if(count($categories)>0){
                foreach ($categories as $key => $value) {
                   
                    $items=array();
                    $celebrates = Yii::app()->db->createCommand()
                                        ->select(array(                                        
                                            'employee_name',                                           
                                            'record_date',
                                            'branch_name',
                                                )
                                        )
                                        ->from('celebrate') 
                                        ->join('category', 'category.id=celebrate.category_id')                                        
                                        ->leftJoin('base', 'base.id=celebrate.base_id')
                                        ->where("category.id=$key")
                                        ->order('celebrate.record_date desc');
                                       
					$celebrates_row  =   $celebrates->queryRow();
					$celebrates 	 =	$celebrates->queryAll();
					$date = explode('/',FunctionCommon::formatDate($celebrates_row['record_date']));					
                    if(count($celebrates)>0){
						if(($date['0'] > $now['0']) || ($date['0'] == $now['0'] && $date['1']>=$now['1']-1 && $date['2']>=01)){	
                        echo '<dl class="first-contract">';
                        echo "<dt>$value</dt>";
                   		}
						
					}
                    if(is_array($celebrates)&&count($celebrates)>0){
                        foreach ($celebrates as $celebrate){
							$date1 = explode('/',FunctionCommon::formatDate($celebrate['record_date']));
							
						   if(($date1['0'] > $now['0']) || ($date1['0'] == $now['0'] && $date1['1']>=$now['1']-1 && $date1['2']>=01)){	
									
								echo '<dd><span class="date">';
								echo FunctionCommon::formatDate($celebrate['record_date']);
								echo '</span>';
								echo '<p class="area">';
										if($celebrate['branch_name']!=""){
											echo '< ';
											echo htmlspecialchars($celebrate['branch_name']);
											echo ' >';
										}
	
								echo '</p>';
								echo '<p class="text">';
								echo htmlspecialchars($celebrate['employee_name']);
								echo 'さん</p></dd>';
							}
							
                        }
                    }
                    if(count($celebrates)>0){
						if(($date['0'] > $now['0']) || ($date['0'] == $now['0'] && $date['1']>=$now['1']-1 && $date['2']>=01)){	
                        echo "</dl>";
						}
                    }
                    
                }
            }
        }
    }



}
?>



