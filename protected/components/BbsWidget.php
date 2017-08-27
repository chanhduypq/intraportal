<?php
class BbsWidget extends CWidget
{
	public function init()
	{
	}

	public function run()
	{
		$sql		=	"select * from bbs order by created_date desc limit 3";
		$connection =	Yii::app()->db; 
		$command	=	$connection->createCommand($sql); 
		$bbs 		=	$command->queryAll();

                                            
		$urlIndex	=	Yii::app()->baseUrl.'/majimebbs/';
		$urlRegist	=	Yii::app()->baseUrl.'/majimebbs/regist';
					
		echo '<div class="box suggestion">';

		if(FunctionCommon::isPostFunction("bbs")==true)
		{
			echo '<div class="ttl"><h2>ニューギン掲示板</h2><a href='.$urlRegist.' class="miniBtn submit01">投稿</a></div>';
		}
		
		echo '<p class="descriptionTxt">意見交換、わからないこと、改善案などご自由に！</p>';		
		if(FunctionCommon::isViewFunction("bbs")==true)
		{	
			echo '<ul>';
			if(!is_null($bbs))
				{	
					foreach($bbs as $object)
					{
                    
                    $sql2		=	"select * from bbs_response where bbs_id ='". $object['id']."'";
                    $connection2 =	Yii::app()->db; 
                    $command2	=	$connection2->createCommand($sql2); 
                    $bbs_response 		=	$command2->queryAll();
?>
				 <li>
                    <span class="date">
						<?php echo FunctionCommon::formatDate($object['created_date']); ?>
					</span>
                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/majimebbs/detail/?id=<?php echo $object['id']; ?>"  class="threadName">
						<?php echo FunctionCommon::crop(htmlspecialchars($object['title']),13); ?>
					</a>
                    <p class="count">回答数（
		 			<?php
						 $i = 0; 
						 foreach ($bbs_response as $comment) {
							 if($object['id']==$comment['bbs_id']){ $i = $i+1;} 
						 }
						 echo $i;
					?>
                    ）</p>
                </li>
<?php			
					}
				}
		echo '</ul>';
		echo '<p class="listBtn"><a href='.$urlIndex.' class="middleBtn listview">一覧を見る</a></p>';
		}
		else
		{
			echo '<ul>';
					$sql="select COUNT(*) from bbs";
					$connection=Yii::app()->db; 
					$command	=	$connection->createCommand($sql); 
					$bbs  =	$command->queryScalar();
					echo Lang::MSG_0062.$bbs."件です。";
			echo '</ul>';	
		
		}
		echo '</div>';	
		
	}
}        