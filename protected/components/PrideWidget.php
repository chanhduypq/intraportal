<?php
class PrideWidget extends CWidget
{
    public $assets_base;
	public function init()
	{
	}

	public function run()
	{

		$urlIndex	=	Yii::app()->baseUrl.'/asobipride/';
		$urlRegist	=	Yii::app()->baseUrl.'/asobipride/regist';
?>
		<div class="ttl"><h2>あそびにマジメ！？あそび自慢&amp;対決！</h2>
        <?php
		if(FunctionCommon::isPostFunction("pride")==true)
			  {
		?>
        <a href="<?php echo $urlRegist;?>" class="miniBtn submit02">投稿</a>
        <?php }?>
        </div>
                    <div class="box pride bottom">
                    	<div class="cntBox">
                        	
<?php					
		$sql		=	"select * from pride order by created_date desc limit 3";
		$connection =	Yii::app()->db; 
		$command	=	$connection->createCommand($sql); 
		$pride 		=	$command->queryAll();
		
		$sql_comment		=	"select * from pride_comment";
		$connection_comment =	Yii::app()->db; 
		$command_comment	=	$connection_comment->createCommand($sql_comment); 
		$pride_comments 	=	$command_comment->queryAll();
		if(FunctionCommon::isViewFunction("pride")==FALSE){
                    $pride=array();
                }
				if(!is_null($pride))
				{	
					foreach($pride as $object)
					{
						$icon=$this->assets_base.'/css/common/img/ico_prize0'.$object['icon'].'.jpg';
					
?>
					<ul>
					<li class="ico">
						<img src="<?php echo $icon;?>" />
					</li>
                    <li class="text">
                                	<p class="evaluate">
                                    	<span class="date"><?php echo FunctionCommon::formatDate($object['created_date']); ?></span>
                                    	<span class="comment">コメント数（<?php
											     $i = 0; 
                                                                                             $count=0;
												 $rating = 0;
												 foreach ($pride_comments as $comment) {
													 if($object['id']==$comment['pride_id']){
                                                                                                             if($comment['valuation']>0){
                                                                                                                 $count++;
                                                                                                             }
													 $i = $i+1;
													 $rating = $comment['valuation']+ $rating;
													 } 
												 }
												 echo $i;
										?>）</span>
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
                                                                                                if($average!='0'){
										?>
                                        
                                        <span class="rating"> 現在の評価：<?php echo $average?></span>
                                        <span class="star <?php echo $star?>"></span>
                                        <?php 
                                                                                                }
                                                                                                else{
                                                                                                    echo '<span class="rating"> 現在の評価：未評価</span>';
                                                                                                }
                                                                                                ?>
                                    </p>
                                    <p><a href="<?php echo Yii::app()->request->baseUrl; ?>/asobipride/detail/?id=<?php echo $object['id']; ?>" class="threadName"><?php echo FunctionCommon::crop(htmlspecialchars($object['title']),40); ?></a></p>
                                </li>
                             </ul> 
					
<?php
					}
				}
?>	

		  </div>
		 <p class="listBtn">
         <?php
			if(FunctionCommon::isViewFunction("pride")==true)
			{
		?>
         <a href="<?php echo $urlIndex;?>" class="middleBtn listview">一覧を見る</a>
         <?php }?>
         </p>          
</div><!-- /box - pride bottom -->
<?php				
	}
}