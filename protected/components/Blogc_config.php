<?php

class Blogc_config {      
    /**     
     * @return integer
     */
    public  function getNumberOfNewsPerKeyword() {   
        Yii::import('ext.helpers.EIniHelper');
        $ini = 'protected/config/blogc.ini';        
        $array = EIniHelper::Load($ini)->Get('news');   
        return intval($array['number_of_news_per_keyword']);        
    }

}

?>
