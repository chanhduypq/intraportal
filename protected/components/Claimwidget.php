<?php

class Claimwidget extends CWidget 
{

    public function run() 
	{
        $item_count = Yii::app()->db->createCommand()
                ->select('count(*) as count')
                ->from('claim')
                ->queryScalar();
        $claims = Yii::app()->db->createCommand()
                ->select(array(
                    'id',
                    'title',
                    'content',
                    'created_date',
                        )
                )
                ->from('claim')
                ->limit(5)
                ->order('created_date desc')
                ->queryAll();
        /**
         * 
         */
        echo '<p class="descriptionTxt">お客様から頂いたクレームを、サービス委員会に報告。<br/>投稿者・サービス委員会以外の閲覧はできません。</p>';   
        echo '<p>クレームが'.$item_count.'件です。</p>';        
        
        if(FunctionCommon::isViewFunction("claim")==true){
            echo '<ul>';        
            if (is_array($claims) && count($claims)) 
			{
                foreach ($claims as $claim) 
				{
                    ?>

                    <li>
                        <span class="date"><?php echo FunctionCommon::formatDate($claim['created_date']); ?></span>
                        <a href="<?php echo Yii::app()->baseUrl;?>/index.php/majimeclaim/detail/?id=<?php echo $claim['id']; ?>"><?php echo FunctionCommon::crop(htmlspecialchars($claim['title']),19)?></a>
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

