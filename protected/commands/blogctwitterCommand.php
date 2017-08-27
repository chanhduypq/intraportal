<?php

class blogctwitterCommand extends CConsoleCommand
{
    private function updateTwitter(){
        $keyword_array=  $this->getKeywords(2);
        if(!is_array($keyword_array)||count($keyword_array)==0){
            return;
        }
        $keyword_string=  $this->convert_array_to_string($keyword_array);
        if(!is_string($keyword_string)||trim($keyword_string)==""){
            return;
        }
        $content_in_twitter_array=  $this->getTwitterResult($keyword_string);
        if(!is_array($content_in_twitter_array)||count($content_in_twitter_array)==0){
            return;
        }
        //$this->deleteTwitter();
        $employee_number=  $this->getEmployeeNumber(2);
        $created_date=  $this->getCreatedDate(2);
        $this->insertTwitterContent($content_in_twitter_array, $employee_number, $created_date);        
//        $this->groupTwitter($created_date,$employee_number); 
        $this->groupTwitter1($created_date,$employee_number); 
    }
    private function updateBlogc(){
        $keyword_array=  $this->getKeywords(1);
        if(!is_array($keyword_array)||count($keyword_array)==0){
            return;
        }
        $keyword_string=  $this->convert_array_to_string($keyword_array);
        if(!is_string($keyword_string)||trim($keyword_string)==""){
            return;
        }
        require_once 'Zend/Loader.php';
        Zend_Loader::loadClass('Zend_Gdata');
        Zend_Loader::loadClass('Zend_Gdata_Query');
        Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
        $user = 'chanhduypq@gmail.com';
        $pass = 'buddha0812';
        $service = 'blogger';

        $client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $service, null, Zend_Gdata_ClientLogin::DEFAULT_SOURCE, null, null, Zend_Gdata_ClientLogin::CLIENTLOGIN_URI, 'GOOGLE');
        $gdClient = new Zend_Gdata($client);
        $query = new Zend_Gdata_Query('https://www.google.co.jp/search?hl=ja&lr=&q=' . $keyword_string . '&num=100&ie=utf-8&tbm=blg&c2coff=1&output=rss');
        
        $feed = $gdClient->getFeed($query);
        $feed = mb_convert_encoding($feed, "UTF-8", mb_detect_encoding($feed, "JIS,SJIS,eucjp-win"));
        $feed=  str_replace("<dc:date>", "<dcdate>", $feed);
        $feed=  str_replace("</dc:date>", "</dcdate>", $feed);
        $dom = new DOMDocument();
        $dom->encoding = 'UTF-8';
        $dom->loadXML($feed);
        $items = $dom->getElementsByTagName("item");
        if(count($items)==0){
            return;
        }        
        $this->deleteBlog();
        $employee_number=  $this->getEmployeeNumber(1);
        $created_date=  $this->getCreatedDate(1);
        
        $this->insertBlogcContent($dom, $employee_number, $created_date);
    }
    public function groupTwitter1($now,$employee_number){        
        $blogc_twitter_contents = Yii::app()->db->createCommand()
                ->select(array(
                    'screen_name',
                    'content',
                    'contributed_date',
                        )
                )
                ->from('blogc_twitter_content')                   
                ->where('type=:type', array('type' => 2))
                ->group("screen_name, content, contributed_date")
                ->queryAll();
        if(count($blogc_twitter_contents)==0){
            return;
        }
        Yii::app()->db->createCommand()->delete("blogc_twitter_content", "type=2");
        $screenname_content_array=array();
        foreach ($blogc_twitter_contents as $blogc_twitter_content){
            $screenname_content_array[$blogc_twitter_content['screen_name']]=array('content'=>$blogc_twitter_content['content'],'contributed_date'=>$blogc_twitter_content['contributed_date']);
        }
        foreach ($screenname_content_array as $screen_name=>$content_contributeddate){
            $content=$content_contributeddate['content'];
            $contributed_date=$content_contributeddate['contributed_date'];
            Yii::app()->db->createCommand()->insert('blogc_twitter_content', array(                    
                    'type'=>2,
                    'created_date' => $now,
                    'last_updated_date' => $now,
                    'last_updated_person' => $employee_number,
                    'content' => $content,
                    'screen_name' => $screen_name,
                    'contributed_date'=>$contributed_date
                        )
                );
        }
        $count = Yii::app()->db->createCommand()
                ->select(array(
                    'count(*) as count',                    
                        )
                )
                ->from('blogc_twitter_content')                   
                ->where('type=:type', array('type' => 2))
                ->queryScalar();
        $twitter_config = new Twitter_config($for_batch=true);                       
        $number_of_news_per_keyword=$twitter_config->getNumberOfNewsPerKeyword($for_batch=true);        
        if($count<=$number_of_news_per_keyword){
            return;
        }
        $rows=Yii::app()->db->createCommand()->select("id")->from("blogc_twitter_content")->where("type = 2")->order("contributed_date DESC")->limit($count, $number_of_news_per_keyword)->queryAll();

        $id_array=array();
        foreach ($rows as $row){
            $id_array[]=$row['id'];
        }        
        $is_string=  implode(",", $id_array);        
        Yii::app()->db->createCommand("DELETE FROM blogc_twitter_content WHERE type = 2 AND id IN($is_string)")->execute();
                
        
    }
    public function groupTwitter($now,$employee_number){        
        $blogc_twitter_contents = Yii::app()->db->createCommand()
                ->select(array(
                    'screen_name',
                    'content',
                    'contributed_date',
                        )
                )
                ->from('blogc_twitter_content')                   
                ->where('type=:type', array('type' => 2))
                ->group("screen_name, content, contributed_date")
                ->queryAll();
        if(count($blogc_twitter_contents)==0){
            return;
        }
        Yii::app()->db->createCommand()->delete("blogc_twitter_content", "type=2");
        $screenname_content_array=array();
        foreach ($blogc_twitter_contents as $blogc_twitter_content){
            $screenname_content_array[$blogc_twitter_content['screen_name']]=array('content'=>$blogc_twitter_content['content'],'contributed_date'=>$blogc_twitter_content['contributed_date']);
        }
        foreach ($screenname_content_array as $screen_name=>$content_contributeddate){
            $content=$content_contributeddate['content'];
            $contributed_date=$content_contributeddate['contributed_date'];
            Yii::app()->db->createCommand()->insert('blogc_twitter_content', array(                    
                    'type'=>2,
                    'created_date' => $now,
                    'last_updated_date' => $now,
                    'last_updated_person' => $employee_number,
                    'content' => $content,
                    'screen_name' => $screen_name,
                    'contributed_date'=>$contributed_date
                        )
                );
        }
        
    }
    private function getEmployeeNumber($type){
        if($type!=1&&$type!=2){
            return '1';
        }
        $employee_number=Yii::app()->db->createCommand()
                ->select('last_updated_person')
                ->from('blogc_twitter')
                ->where("type=$type")
                ->queryScalar();
        if($employee_number==FALSE){
            return '1';
        }
        return $employee_number;
    }
    private function getCreatedDate($type){
        if($type!=1&&$type!=2){
            return date("Y-m-d");
        }
        $employee_number=Yii::app()->db->createCommand()
                ->select('created_date')
                ->from('blogc_twitter')
                ->where("type=$type")
                ->queryScalar();
        if($employee_number==FALSE){
            return date("Y-m-d");
        }
        return $employee_number;
    }
    private function insertBlogcContent($dom,$employee_number,$created_date){
       

        foreach ($dom->getElementsByTagName('item') as $item) {
            $content = '';
            $screen_name = '';
            $created_at='';
            foreach ($item->getElementsByTagName('title') as $node) {
                $content = $node->nodeValue;
            }

            foreach ($item->getElementsByTagName('link') as $node) {
                $screen_name = $node->nodeValue;
            }
            foreach ($item->getElementsByTagName('dcdate') as $node) {
                $created_at = $node->nodeValue;                
            }            
            $created_at=  $this->convertToDBTimeFromBlogcTime($created_at);   
            $newtime = strtotime($created_at) + (9 * 60 * 60); 
            $created_at=date('Y-m-d H:i:s', $newtime);


            
            if($content!=""&&$screen_name!=""){
                Yii::app()->db->createCommand()->insert('blogc_twitter_content', array(                   
                    'type'=>1,
                    'created_date' => $created_date,
                    'last_updated_date' => $created_date,
                    'last_updated_person' => $employee_number,
                    'content' => $content,
                    'screen_name' => $screen_name,
                    'contributed_date'=>$created_at
                        )
                );
            }
            
        }
    }

    private function insertTwitterContent($content_in_twitter_array,$employee_number,$created_date){
        
        foreach ($content_in_twitter_array as $content_in_twitter){ 
                $created_at=$this->convertToDBTimeFromTwitterTime($content_in_twitter->created_at);
                $newtime = strtotime($created_at) + (9 * 60 * 60); 
                $created_at=date('Y-m-d H:i:s', $newtime);                
                Yii::app()->db->createCommand()->insert('blogc_twitter_content',array(                                                      
                                                        'type'=>2,
                                                        'created_date'=>$created_date,
                                                        'last_updated_date'=>$created_date,
                                                        'last_updated_person'=>$employee_number,
                                                        'content'=>$content_in_twitter->text,
                                                        'screen_name'=>$content_in_twitter->user->screen_name.'/status/'.$content_in_twitter->id_str,                                                        
                                                        'contributed_date'=>$created_at,
                                                        'name'=>$content_in_twitter->user->name
                                                        ) 

                                             );
            }
    }
    private function deleteTwitter(){
        Yii::app()->db->createCommand()->delete("blogc_twitter_content", "type=2");      
    }
    private function deleteBlog(){        
        Yii::app()->db->createCommand()->delete("blogc_twitter_content","type=1");
    }
    private function getTwitterResult($keyword_string){
        if(!is_string($keyword_string)||  trim($keyword_string)==""){
            return array();
        }
        require_once 'twitteroauth/twitteroauth.php';                        
        $twitter_config = new Twitter_config($for_batch=true);
        $consumer_key = $twitter_config->getTwitterUserConsumerKey();
        $consumer_secret = $twitter_config->getTwitterUserConsumerSecret();
        $access_token = $twitter_config->getTwitterUserAccessToken();
        $access_token_secret = $twitter_config->getTwitterUserAccessTokenSecret();                
        $number_of_news_per_keyword=$twitter_config->getNumberOfNewsPerKeyword($for_batch=true);
        $twitter = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret); 
        
        if(is_numeric($number_of_news_per_keyword)==FALSE){
            return;
        }
        $number_of_news_per_keyword=  intval($number_of_news_per_keyword);
        $times=0;
        $mod=0;
        if($number_of_news_per_keyword%100==0){
            $times=$number_of_news_per_keyword/100;
            $mod=0;
        }
        else{
            $times=intval($number_of_news_per_keyword/100)+1;
            $mod=$number_of_news_per_keyword%100;
        }
        if($times==0){
            return;
        }
        $now=date("Y-m-d");        
//        $start_date = strtotime ( '-'.($times-1).' day' , strtotime ( $now ) ) ;  
        $start_date = strtotime ( '-0 day' , strtotime ( $now ) ) ;  
        $start_date = strtotime ( '-0 day' , strtotime ( $now ) ) ;  
        $start_date = date ( 'Y-m-d' , $start_date );        
        $content_in_twitter_object = $twitter->get('https://api.twitter.com/1.1/search/tweets.json?q='.$keyword_string.' -rt -via&until='.$start_date.'&result_type=recent&count='.(($times==1&&$mod!=0)?$mod:'100'));                                               
        if(isset($content_in_twitter_object->errors)){
            return;
        }   
        
        $content_in_twitter_array= $content_in_twitter_object->statuses;          
        for($i=1;$i<$times;$i++){
//            $start_date = strtotime ( '+1 day' , strtotime ( $start_date ) ) ;  
            $start_date = strtotime ( '-1 day' , strtotime ( $start_date ) ) ; 
            $start_date = date ( 'Y-m-d' , $start_date );        
            $content_in_twitter_object = $twitter->get('https://api.twitter.com/1.1/search/tweets.json?q='.$keyword_string.' -rt -via&until='.$start_date.'&result_type=recent&count='.(($i==$times-1&&$mod!=0)?$mod:'100'));                                               
            if(isset($content_in_twitter_object->errors)){
                return;
            }  
            if(is_object($content_in_twitter_object)){
                $content_in_twitter_array=array_merge($content_in_twitter_array,$content_in_twitter_object->statuses);
            }
            
        } 
        
        
        return $content_in_twitter_array;
        
    }
    

    private function convert_array_to_string(array $keyword_array){
        if(!is_array($keyword_array)||count($keyword_array)==0){
            return '';
        }
        $keyword_string=trim($keyword_array[0]);
        for ($i = 1, $n = count($keyword_array); $i < $n; $i++) {            
            if($keyword_array[$i]!=""){
                $keyword_string.=' OR '.trim($keyword_array[$i]);
            }            
        }     
        return $keyword_string;
    }

    private function getKeywords($type){
        if($type!=1&&$type!=2){
            return;
        }
        $blogc_twitter_keywords = Yii::app()->db->createCommand()
                ->select(array(
                    'keyword'                    
                        )
                )
                ->from('blogc_twitter')                   
                ->where('type=:type', array('type' => $type))
                ->queryAll();
        if(count($blogc_twitter_keywords)==0){
            return array();
        }
        $keyword_array=array();
        foreach ($blogc_twitter_keywords as $blogc_twitter_keyword){
            $keyword_array[]=$blogc_twitter_keyword['keyword'];
        }
        return $keyword_array;
    }

    public function run($args)
    {
	$this->updateBlogc();
        $this->updateTwitter();        
    }
    private function convertToDBTimeFromTwitterTime($twitter_time){        
        if(!is_string($twitter_time)||trim($twitter_time)==""){
            return $twitter_time;
        }
        $month=substr($twitter_time,4, 3);
        if($month=='Jan'){
            $month='01';
        }
        else if($month=='Feb'){
            $month='02';
        }
        else if($month=='Mar'){
            $month='03';
        }
        else if($month=='Apr'){
            $month='04';
        }
        else if($month=='May'){
            $month='05';
        }
        else if($month=='Jun'){
            $month='06';
        }
        else if($month=='Jul'){
            $month='07';
        }
        else if($month=='Aug'){
            $month='08';
        }
        else if($month=='Sep'){
            $month='09';
        }
        else if($month=='Oct'){
            $month='10';
        }
        else if($month=='Nov'){
            $month='11';
        }
        else if($month=='Dec'){
            $month='12';
        }
        
        $day=substr($twitter_time,8, 2);
        $time=substr($twitter_time,11, 8);
        $temp=  explode(" ", $twitter_time);
        $year=$temp[count($temp)-1];
        return $year.'-'.$month.'-'.$day.' '.$time;        
        
    }
    private function convertToDBTimeFromBlogcTime($blogc_time){        
        if(!is_string($blogc_time)||trim($blogc_time)==""){
            return $blogc_time;
        }
       
        $month=substr($blogc_time,8, 3);
        if($month=='Jan'){
            $month='01';
        }
        else if($month=='Feb'){
            $month='02';
        }
        else if($month=='Mar'){
            $month='03';
        }
        else if($month=='Apr'){
            $month='04';
        }
        else if($month=='May'){
            $month='05';
        }
        else if($month=='Jun'){
            $month='06';
        }
        else if($month=='Jul'){
            $month='07';
        }
        else if($month=='Aug'){
            $month='08';
        }
        else if($month=='Sep'){
            $month='09';
        }
        else if($month=='Oct'){
            $month='10';
        }
        else if($month=='Nov'){
            $month='11';
        }
        else if($month=='Dec'){
            $month='12';
        }
        
        $day=substr($blogc_time,5, 2);
        $time=substr($blogc_time,17, 8);        
        $year=substr($blogc_time,12, 4);
        return $year.'-'.$month.'-'.$day.' '.$time;        
        
    }
}

