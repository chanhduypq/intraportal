<?php

class To_officerWidget extends CWidget {

    public function run() 
	{
        $to_officers = Yii::app()->db->createCommand()
                ->select(array(
                    'id',
                    'title',
                    'content',
                    'created_date',
                        )
                )
                ->from('to_officer')
                ->limit(5)
                ->order('created_date desc')
                ->queryAll();
		
      
       ?>
        <div class="box management">
            <div class="ttl" style="background-position: 0 -41.5px;">
						<h2>役員宛目安箱</h2>
                        <?php 
						if(FunctionCommon::isPostFunction("to_officer")){
						?>
						<a href="<?php echo Yii::app()->baseUrl;?>/majimeto_officer/add" class="miniBtn submit01">投稿</a>
                        <?php }?>
                    </div>   
            <p class="descriptionTxt">会社に対して要望や質問を出すことができます。<br/>ファイル等も添付できます。※役員のみ閲覧可</p>      
                        
       <?php          
	    if(FunctionCommon::isViewFunction("to_officer")==true){
			echo '<ul>';        
            if (is_array($to_officers) && count($to_officers)) 
            {
                foreach ($to_officers as $to_officer) 
                {
                    ?>

                    <li>
                        <span class="date">
							<?php echo FunctionCommon::formatDate($to_officer['created_date']); ?>
						</span>
                        <a href="<?php echo Yii::app()->baseUrl;?>/majimeto_officer/detail/?id=<?php echo $to_officer['id']; ?>">
							<?php echo FunctionCommon::crop(htmlspecialchars($to_officer['title']),23); ?>
						</a>
                    </li>               

                    <?php
                }
            }
			echo '</ul>';
		}
        ?>
					<?php  if(FunctionCommon::isViewFunction("to_officer")){ ?>
						 <p class="listBtn">
                        <a href="<?php echo Yii::app()->baseUrl;?>/majimeto_officer/" class="middleBtn listview">一覧を見る</a>
                        </p>
                    <?php  } ?>
                
             </div>    
        <?php    
       
    } 
}