<?php

class Topicsasobiwidget extends CWidget 
{

    public function run() 
	{
        $select_command = Yii::app()->db->createCommand()->select();
        $select_command->select(array(
                    'id',
                    'created_date',
                    "title",
                    "content as table_name",
                ))
                ->from('claim')//->from("any_table") anytable has 4 columns: id,title,last_updated_date,content
                ->where('false')
        ;
        $items = array();
        $tablename_articleid_array = $this->getUpdateInformation();   
        if (is_array($tablename_articleid_array) && count($tablename_articleid_array) > 0) {
            foreach ($tablename_articleid_array as $tablename_articleid) {
                foreach ($tablename_articleid as $key => $value) {
                    $article_id = $key;
                    $table_name = $value;
                }
                $select_command->union("select id,created_date,title,'$table_name' as table_name from $table_name where id=$article_id");
            }
            $items = $select_command->limit(10)->queryAll();
        }
		$urlIndex=Yii::app()->baseUrl.'/asobitopics';
		echo '<div class="box topics">';
	    echo '<div class="ttl">';
		echo '<h2>更新情報</h2>';		
		echo '</div>';
		echo '<ul>';
                
                if(is_array($items)&&count($items)>0){
                    foreach($items as $item){
                                    $table=$item['table_name'];
                                    
                                    $urlDetail=Yii::app()->request->baseUrl.'/asobi'.$item['table_name'].'/detail/?id='.$item['id'];
                                    if(FunctionCommon::isViewFunction($table)==true)
                                    {
                                            echo '<li>';
                                            echo '<span class="date">';
                                            echo FunctionCommon::formatDate($item['created_date']);
                                            echo '</span>';
                                            echo '<p>';
                                            echo '<a href='.$urlDetail.'>';
                                            echo FunctionCommon::crop(htmlspecialchars($item['title']),12);
                                            echo '</a>';
                                            echo '</p>';
                                            echo '</li>';
                                    }
                            }
                    }
		echo '</ul>';
                echo '<p class="moreBtn"><a href="'.$urlIndex.'" class="middleBtn moreview">一覧を見る</a></p>';		
		echo '</div>';
    }

 	

    /*
     * Create Date:20130816
     * Update Date:
     * Author:Hainhl
     * User change:
     * Description:Method get 10 row in update_information
     * */
    private function getUpdateInformation() 
	{
        $module_tile_array=  Constants::$module_tile_array;
        $table_array=array();
        foreach ($module_tile_array as $key=>$value){
            if(FunctionCommon::isViewFunction($key)==true){
                $table_array[]="'".$key."'";
            }
        }
        $table_string='';
        if(count($table_array)==0){
            $table_string="''";
        }
        else if(count($table_array)==1){
            $table_string=$table_array[0];
        }
        else{
            $table_string=  implode(",", $table_array);
        }
		$update_infomations = Yii::app()->db->createCommand()
                ->select(array(
                    'article_id',
                    'table_name',
                        )
                )
                ->from('update_information')
                ->where('type=2')                
                ->andWhere("table_name IN($table_string)")        
                ->limit(10)        
                ->order('created_date desc')
                ->queryAll();
        /**
         * 
         */
        $tablename_articleid_array = array();
        if (is_array($update_infomations) && count($update_infomations) > 0) {
            foreach ($update_infomations as $update_infomation) {
                $tablename_articleid_array[] = array($update_infomation['article_id'] => $update_infomation['table_name']);
            }
            return $tablename_articleid_array;
        }
        return array();
    }

}

