<?php
class Reportwidget extends CWidget
{
	public function init()
	{

	}

	public function run()
	{
		// SQL Query	
		$sql="select * from report order by created_date desc limit 8";
		// Define the DB connection for this page(to use your database first you have to remove the comment in code phrase in Config.php)
		$connection=Yii::app()->db; 
		// Execute the sql
		$command=$connection->createCommand($sql); 
		$report=$command->queryAll();
		
		$urlIndex=Yii::app()->baseUrl.'/majimereport/index';
		$urlRegist=Yii::app()->baseUrl.'/majimereport/regist';
	
		echo '<div class="box realtime">';
		echo '<div class="ttl">';
		echo '<h2>リアルタイム社内報告</h2>';	
		if(FunctionCommon::isPostFunction("report")==true)
		{
			echo '<a class="miniBtn submit01" href='.$urlRegist.'>投稿</a>';		
		}		
		
		echo '</div>';		
		echo '<p class="descriptionTxt">社内の情報共有広場です。他部署への質問や投げかけ、噂話や競合他社情報など気軽に書き込んで投稿してください！</p>';		
		echo '<ul>';
		if(FunctionCommon::isViewFunction("report")==true)
		{
			if(!is_null($report))
			{	
				foreach($report as $object)
				{
                                    $sql2		=	"select * from report_response where report_id ='". $object['id']."'";
                                    $connection2 =	Yii::app()->db; 
                                    $command2	=	$connection2->createCommand($sql2); 
                                    $report_response 		=	$command2->queryAll();
					echo '<li>';
					switch($object['icon'])
					{
						case 1:
						echo '<div class="ico help">HELP</div>';
						break;
						case 2:
						echo '<div class="ico eigyou">営業</div>';
						break;
						case 3:
						echo '<div class="ico uwasa">うわさ</div>';
						break;
						case 4:
						echo '<div class="ico seizou">製造</div>';
						break;
						case 5:
						echo '<div class="ico gyousei">行政</div>';
						break;
						case 6:
						echo '<div class="ico hall">ホール</div>';
						break;
						case 7:
						echo '<div class="ico kaihatsu">開発</div>';
						break;
						case 8:
						echo '<div class="ico other">他</div>';
						break;
					}
					echo '<div>';	
					echo '<span class="date">'.FunctionCommon::formatDate($object['created_date']).'</span>';			
					echo  CHtml::link(FunctionCommon::crop(htmlspecialchars($object['title']),17),array('majimereport/detail','id'=>$object['id']));
                                        echo ' <p style="word-break: normal;width:287px;">'.FunctionCommon::crop(FunctionCommon::url_henkan($object['content']),30).' <span class="counter">'.$object['view_number'].'</span></p>';	
                                        ?>
                                        <p class="count">回答数（
		 			<?php
						 $i = 0; 
						 foreach ($report_response as $comment) {
							 if($object['id']==$comment['report_id']){ $i = $i+1;} 
						 }
						 echo $i;
					?>
                                        ）</p>
                                        <?php
					
					echo '</div>';                                       
					echo '</li>';
				}
			}
		}
		else
		{
			$count=Yii::app()->db->createCommand('select count(*) from report')->queryScalar();
			echo Lang::MSG_0062.$count.'件です。';
		}		
		echo '</ul>';		
		echo '<p class="listBtn">';		
		if(FunctionCommon::isViewFunction("report")==true)
		{	
			echo '<a class="middleBtn listview" href='.$urlIndex.'>一覧を見る</a>';		 		
		}			
		echo '</p>';
		echo '</div>';	
	}
}
