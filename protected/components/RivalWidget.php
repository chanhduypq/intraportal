<?php
class Rivalwidget extends CWidget
{
	public function init()
	{

	}

	public function run()
	{
		
		
		$urlIndex=Yii::app()->baseUrl.'/majimerival/index';
		$urlRegist=Yii::app()->baseUrl.'/majimerival/regist';
		$urlDetail=Yii::app()->baseUrl.'/majimerival/detail';
		
		echo '<div class="box rival">';
		echo '<div class="ttl">';
		echo '<h2>競合情報</h2>';
        if(FunctionCommon::isPostFunction("rival")==true){	
		  echo '<a class="miniBtn regist01" href='.$urlRegist.'>登録</a>';
        }
			
		echo '</div>';	
                echo '<p class="descriptionTxt">競合メーカーの情報をいち早く共有！</p>';           
		echo '<ul>';
        
        if(FunctionCommon::isViewFunction("rival")==true)
		{
            
			// SQL Query	
			$sql="select * from rival order by created_date desc limit 5";
			// Define the DB connection for this page(to use your database first you have to remove the comment in code phrase in Config.php)
			$connection=Yii::app()->db; 
			// Execute the sql
			$command=$connection->createCommand($sql); 
			$rival=$command->queryAll(); 
            
			if(!is_null($rival))
			{	
				foreach($rival as $object)
				{
                                    $sql2		=	"select * from rival_response where rival_id ='". $object['id']."'";
                                    $connection2 =	Yii::app()->db; 
                                    $command2	=	$connection2->createCommand($sql2); 
                                    $rival_response 		=	$command2->queryAll();
				   echo '<li>';	
				   echo '<span class="date">'.FunctionCommon::formatDate($object['created_date']).'</span>';			
		?>
        		   <a href="<?php echo Yii::app()->baseUrl;?>/majimerival/detail/?id=<?php echo $object['id']; ?>">
						<?php echo FunctionCommon::crop(htmlspecialchars($object['title']),19); ?>
				   </a>

                           <p class="count">回答数（
		 			<?php
						 $i = 0; 
						 foreach ($rival_response as $comment) {
							 if($object['id']==$comment['rival_id']){ $i = $i+1;} 
						 }
						 echo $i;
					?>
                                        ）</p> 
        <?php		   
				   echo '</li>';
				}
			}
        
        }	
		else
		{
			$sql="select COUNT(*) from rival";
			$connection=Yii::app()->db; 
			$command	=	$connection->createCommand($sql); 
			$rival  =	$command->queryScalar();
			echo Lang::MSG_0062.$rival.'件です。';
		}
        	
		echo '</ul>';		
		echo '<p class="listBtn">';
        if(FunctionCommon::isViewFunction("rival")==true)
		{		
		  echo '<a class="middleBtn listview" href='.$urlIndex.'>一覧を見る</a>';	
        } 
		echo '</p>';
		echo '</div>';	
	}
}



