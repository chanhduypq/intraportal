<?php

class Twitterwidget extends CWidget {

    public function run() {     
        
        $blogc_twitter_contents = Yii::app()->db->createCommand()
                ->select(array(        
                    'screen_name',
                    'content',
                    'name'
                          
                        )
                )
                ->from('blogc_twitter_content')                  
                ->limit(2)
                ->where("type=:type",array('type'=>2)) 
                ->order("contributed_date desc")                        
                ->queryAll();
        
        /**
         * 
         */
        echo '<p class="descriptionTxt">話題のツイートをキャッチ！</p>';           
        if(FunctionCommon::isViewFunction("twitter")==true){
            echo '<ul><li>';        
            if (is_array($blogc_twitter_contents) && count($blogc_twitter_contents)) {
                foreach ($blogc_twitter_contents as $blogc_twitter_content) {
                    $temp=  explode("status", $blogc_twitter_content['screen_name']);
                    $list=$temp[0];
                    $list1=  substr($list,0,  strlen($list)-1);
                    ?>


                        <p>
                            
                            <a class="twitter-timeline" target="_blank" href="https://twitter.com/<?php echo $blogc_twitter_content['screen_name'];?>" data-screen-name="<?php echo $blogc_twitter_content['screen_name'];?>">
                                    <?php echo FunctionCommon::crop($blogc_twitter_content['content'],51);?>
                            </a>
                            
                        </p>



                    <?php
                }
            }
            echo '</li></ul>';
            }
            
    }

    

}

