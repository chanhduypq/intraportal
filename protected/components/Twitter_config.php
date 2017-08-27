<?php

class Twitter_config {
    /**
     * @var array 
     */
    private $user_array=array();
    /**
     * 
     */
    public function __construct($for_batch=true) {
        Yii::import('ext.helpers.EIniHelper');
        if($for_batch==true){
            $ini = '../config/twitter.ini';
        }
        else{
            $ini = 'protected/config/twitter.ini';
        }
        
        /**
         * 
         */
        $this->user_array = EIniHelper::Load($ini)->Get('user');        
    }    
    /**     
     * @return string
     */
    public  function getTwitterUserConsumerKey() {        
        return $this->user_array['consumerkey'];        
    }
    /**     
     * @return string
     */
    public  function getTwitterUserConsumerSecret() {        
        return $this->user_array['consumersecret'];        
    }
    /**     
     * @return string
     */
    public  function getTwitterUserAccessToken() {        
        return $this->user_array['accesstoken'];        
    }
    /**     
     * @return string
     */
    public  function getTwitterUserAccessTokenSecret() {        
        return $this->user_array['accesstokensecret'];        
    }
    /**     
     * @return integer
     */
    public  function getNumberOfNewsPerKeyword($for_batch=true) {   
        Yii::import('ext.helpers.EIniHelper');
        if($for_batch==true){
            $ini = '../config/twitter.ini';
        }
        else{
            $ini = 'protected/config/twitter.ini';
        }
        
        $array = EIniHelper::Load($ini)->Get('news');   
        return intval($array['number_of_news_per_keyword']);        
    }

}

?>
