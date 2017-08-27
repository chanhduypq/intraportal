<?php
class AsobitopicsController extends Controller 
{ 
	public $pageTitle;
     public function init() 
	 {
        parent::init();
		$this->pageTitle="更新情報 | ニューギンスクエア";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id']=="null" ) {
          $this->redirect(array('newgin/'));
        }
        
    }   
    /**
     * 
     */
    public function actionIndex() {    	
        /**
         * 
         */
        $page = (isset($_GET['page']) ? $_GET['page'] : 1);
        /**
         * 
         */
        $page_size = Config::LIMIT_ROW;        
        /**
         * 
         */
        $select_command=Yii::app()->db->createCommand()->select();
        
        /**
         * select no row
         * for using union
         */
        $select_command->select(array(
                                'id',                                
                                'created_date',
                                "title",
                                "content as table_name",
                                ))
                       ->from('claim')//->from("any_table") anytable has 4 columns: id,title,last_updated_date,content
                       ->where('false')
                ;
        
        /**
         * 
         */            
        $tablename_articleid_array = $this->getUpdateInformation($page,$page_size);        
        /**
         * 
         */
        $items=array();  
       
        if(is_array($tablename_articleid_array)&&  count($tablename_articleid_array)>0){
            foreach ($tablename_articleid_array as $tablename_articleid){
                foreach ($tablename_articleid as $key => $value) {
                    $article_id=$key;
                    $table_name=$value;
                }
                
                $select_command->union("select id,created_date,title,'$table_name' as table_name from $table_name where id=$article_id");
                 
                
            }
            $items=$select_command->queryAll();
            
        }
        $item_count=  $this->getUpdateInformationCount();
        /**
         * 
         */
        $pages = new CPagination($item_count);
        $pages->setPageSize($page_size);
        /**
         * 
         */
        $params = array('items' => $items,
            'item_count' => $item_count,
            'page_size' => $page_size,
            'pages' => $pages);
        /**
         * 
         */
        $this->render('/asobi/topics/index', $params);
    }  
    private function getUpdateInformationCount(){

        $module_tile_array=  Constants::$module_tile_array;
        $table_array=array();
        foreach ($module_tile_array as $key=>$value){
            if(FunctionCommon::isViewFunction($key)==true){
                $table_array[]="'".$key."'";
            }
        }
        $table_string='';
        if(count($table_array)==0){
            $table_string='';
        }
        else if(count($table_array)==1){
            $table_string=$table_array[0];
        }
        else{
            $table_string=  implode(",", $table_array);
        }
            /**
             * 
             */
            $update_infomation_count = Yii::app()->db->createCommand()
                    ->select(array(
                        'count(*) as count',                                       
                            )
                    )
                    ->from('update_information')
                    ->where('type=2')                                   
                    ->andWhere("table_name IN($table_string)")
                    ->queryScalar();
            if($update_infomation_count==FALSE){
                return 0;
            }        
            return $update_infomation_count;            
            
    }
    /**
     * 
     */
    private function getUpdateInformation($page,$page_size){
        $module_tile_array=  Constants::$module_tile_array;
        $table_array=array();
        foreach ($module_tile_array as $key=>$value){
            if(FunctionCommon::isViewFunction($key)==true){
                $table_array[]="'".$key."'";
            }
        }
        $table_string="''";
        if(count($table_array)==0){
            $table_string="''";
        }
        else if(count($table_array)==1){
            $table_string=$table_array[0];
        }
        else{
            $table_string=  implode(",", $table_array);
        }
        /**
         * 
         */
        $update_infomations = Yii::app()->db->createCommand()
                ->select(array(
                    'article_id',
                    'table_name',                    
                        )
                )
                ->from('update_information')
                ->where('type=2')                                
                ->andWhere("table_name IN($table_string)")
                ->limit($page_size, ($page - 1) * $page_size)
                ->order('created_date desc')
                ->queryAll();
        /**
         * 
         */        
        $tablename_articleid_array = array();
        if (is_array($update_infomations) && count($update_infomations) > 0) {
            foreach ($update_infomations as $update_infomation) {                
                $tablename_articleid_array[] =array($update_infomation['article_id']=>$update_infomation['table_name']) ;
            }            
            return $tablename_articleid_array;
        }
        return array();        
    }
    
    

}