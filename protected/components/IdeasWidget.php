<?php
class IdeasWidget extends CWidget
{
	public function init()
	{
	}

	public function run()
	{

		$urlIndex	=	Yii::app()->baseUrl.'/majimeideas/';
		$urlRegist	=	Yii::app()->baseUrl.'/majimeideas/regist';
					
		echo '<div class="box idea">';
		echo '<div class="ttl"><h2>製品アイデア投稿広場</h2>';
		if(FunctionCommon::isPostFunction("ideas")==true){
			echo '<a class="miniBtn regist01" href='.$urlRegist.'>投稿</a>';		
		}
		
		echo '</div>';
		echo '<p class="descriptionTxt">機種開発や業務の改善、創意工夫など。<br>自由に意見を投稿して相互評価しましょう！</p>';			
		echo '<ul>';
		
		if(FunctionCommon::isViewFunction("ideas")==true)
		{
			
		$sql		=	"select * from ideas order by created_date desc limit 3";
		$connection =	Yii::app()->db; 
		$command	=	$connection->createCommand($sql); 
		$ideas 		=	$command->queryAll();
		
		$sql_comment		=	"select * from ideas_comment";
		$connection_comment =	Yii::app()->db; 
		$command_comment	=	$connection_comment->createCommand($sql_comment); 
		$ideas_comments 		=	$command_comment->queryAll();
		
				if(!is_null($ideas))
				{	
					foreach($ideas as $object){
?>
					<li>
					<span class="date">
						<?php echo FunctionCommon::formatDate($object['created_date']); ?>
					</span>
                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/majimeideas/detail/?id=<?php echo $object['id']; ?>"  class="threadName">
						<?php echo FunctionCommon::crop(htmlspecialchars($object['title']),21); ?>
					</a>
                    <div class="evaluate">
                                <p class="comment">コメント数（
                                 <?php
											     $i = 0; 
                                                                                             $count=0;
												 $rating = 0;
												 foreach ($ideas_comments as $comment) {
													 if($object['id']==$comment['ideas_id']){ 
                                                                                                             if($comment['valuation']>0){
                                                                                                                 $count++;
                                                                                                             }
													 $i = $i+1;
													 $rating = $comment['valuation']+ $rating;
													 } 
												 }
												 echo $i;
                                                                                                 
									?>
                                
                                ）</p>
                                 <?php 
												if($i!=0){
													if($count>0){
                                                                                                            $average = $rating/$count;
                                                                                                        }
                                                                                                        else{
                                                                                                            $average='0';
                                                                                                        }
													$average = substr($average, 0, 3);
													if($average==0){$star = "star0"; $average=0;}
													else if($average > 0 && $average <= '1.5'){ $star = "star1";}
													else if($average > '1.5' && $average <= '2.5'){ $star = "star2";}
													else if($average > '2.5' && $average <= '3.5'){ $star = "star3";}
													else if($average > '3.5' && $average <= '4.5'){ $star = "star4";}
													else if($average > '4.5' ){ $star = "star5";}
														}
												else {$star = "star0"; $average=0;}
									?>
                               <p class="rating"> 現在の評価：
                                   <?php 
                                   if($average!='0'){
                                       echo $average;
                                   }
                                   else{
                                       echo '<p class="not_rated">未評価</p>';
                                   }
                                           ?>
                               </p>
                               <?php
                               if($average!='0'){?>
                               <p class="star <?php echo $star?>"></p>
                               <?php
                               }
                               ?>
                            </div>
                    </li>
<?php
					}
				}
		}
		else
		{
			$sql="select COUNT(*) from ideas";
			$connection=Yii::app()->db; 
			$command	=	$connection->createCommand($sql); 
			$ideas  =	$command->queryScalar();
			echo Lang::MSG_0062.$ideas."件です。";
		}
					
		echo '</ul>';
		if(FunctionCommon::isViewFunction("ideas")==true)
		{
			echo '<p class="listBtn"><a href='.$urlIndex.' class="middleBtn listview">一覧を見る</a></p>';
		}
		echo '</div>';	
		
	}
}