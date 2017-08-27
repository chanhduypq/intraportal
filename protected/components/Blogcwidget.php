<?php

class Blogcwidget extends CWidget {

    public function run() {        
        
        $blogc_twitter_contents = Yii::app()->db->createCommand()
                ->select(array(        
                    'screen_name',
                    'content',
                    
                        )
                )
                ->from('blogc_twitter_content')                  
                ->limit(5)
                ->where('type=:type',array('type'=>1))
                ->order("contributed_date desc")                        
                ->queryAll();
        
        /**
         * 
         */
        echo '<p class="descriptionTxt">話題のブログをキャッチ！</p>';           
        if(FunctionCommon::isViewFunction("blogc")==true){
            echo '<ul><li>';        
            if (is_array($blogc_twitter_contents) && count($blogc_twitter_contents)) {
                foreach ($blogc_twitter_contents as $blogc_twitter_content) {
                    ?>
                        <p><a target="_blank" href="<?php echo $blogc_twitter_content['screen_name'];?>">
						<?php echo FunctionCommon::crop($blogc_twitter_content['content'],25); ?>
						</a></p>
                    <?php
                }
            }
            echo '</li></ul>';
        }
        
    }

    

}

