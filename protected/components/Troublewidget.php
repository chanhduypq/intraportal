<?php

class Troublewidget extends CWidget {
	
	/**
     * 
     */
    public function run() 
	{
        $troubles = Yii::app()->db->createCommand()
                ->select(array(
                    'id',
                    'title',
                    'content',
                    'created_date',
                        )
                )
                ->from('trouble')
                ->limit(5)
                ->order('created_date desc')
                ->queryAll();
		$all_data = Yii::app()->db->createCommand("select id from trouble")->queryAll();
		$number= count($all_data);
        echo '<p class="descriptionTxt">当社の機種に関するトラブル＆不正情報。<br/>投稿者・サービス委員会以外の閲覧はできません。</p>';           
        echo ' <p>トラブル＆不正情報が'.$number.'件です。</p>';
        if(FunctionCommon::isViewFunction("trouble")==true){
            echo '<ul>';        
            if (is_array($troubles) && count($troubles)) 
                    {
                foreach ($troubles as $trouble) 
                            {
                    ?>

                    <li>
                        <span class="date">
							<?php echo FunctionCommon::formatDate($trouble['created_date']); ?>
						</span>
                        <a href="<?php echo Yii::app()->baseUrl;?>/majimetrouble/detail/?id=<?php echo $trouble['id']; ?>">
							<?php echo FunctionCommon::crop(htmlspecialchars($trouble['title']),19); ?>
						</a>
                    </li>               

                    <?php
                }
            }
            echo '</ul>';
        }
        else{?>
                 
        <?php    
        }
    }

  
}

