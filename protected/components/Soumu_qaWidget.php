<?php
class Soumu_qaWidget extends CWidget
{
	public function init()
	{
	}

	public function run()
	{

		$urlIndex	=	Yii::app()->baseUrl.'/majimesoumu_qa/';
					
        echo '<div class="box faq">';
        echo '<h2 class="ttl">教えて総務さん！FAQ</h2>';
        echo '<ul class="faq">';
        
        if(FunctionCommon::isViewFunction("soumu_qa")==true)
		{
            
			$sql		=	"select * from soumu_qa order by created_date desc limit 5";
			$connection =	Yii::app()->db; 
			$command	=	$connection->createCommand($sql); 
			$soumu_qa 		=	$command->queryAll();    
        
        if(!is_null($soumu_qa))
		{	
		  foreach($soumu_qa as $object)
		  { ?>
             <li>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>/majimesoumu_qa/detail/<?php echo $object['id']; ?>">
					<?php echo FunctionCommon::crop(htmlspecialchars($object['title']),24); ?>
				</a>
			</li> 
        <?php			
		  }
		}
        }
           
        echo '</ul>';
        if(FunctionCommon::isViewFunction("soumu_qa")==true)
		{		
		  echo '<p class="listBtn"><a href='.$urlIndex.' class="middleBtn listview">一覧を見る</a></p>';	
        }
        echo '</div>';	
		
	}
}

                       
                      