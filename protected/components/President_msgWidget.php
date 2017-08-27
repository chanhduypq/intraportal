<?php
class President_msgWidget extends CWidget
{
	public function init()
	{
	}

	public function run()
	{
		
		$sql				=	"select * from president_msg order by created_date desc limit 1";
		$connection	 		=	Yii::app()->db; 
		$command			=	$connection->createCommand($sql); 
		$president_msg 		=	$command->queryAll();
		
		$urlIndex	=	Yii::app()->baseUrl.'/majimepresident_msg/';
		$urlDetail	=	Yii::app()->baseUrl.'/majimepresident_msg/detail/';
		
		echo '<div class="ttl msgBox" style="height: 180px;border:0px;">';
			echo '<h2>新井社長メッセージ</h2>';	
                        echo '<p style="padding: 10px;background: #F7CFCF;border-radius: 7px;-webkit-border-radius: 7px;-moz-border-radius: 7px;font-size: 11px;">＜今週のひとこと＞を不定期更新に変更</p>';           
			echo '<h3 style="margin-top:5px;">＜今週のひとこと＞</h3>';
                        
			
		if(FunctionCommon::isViewFunction("president_msg")==true){
		
			
			if(!is_null($president_msg))
				{	
					foreach($president_msg as $object){      
?>			
			<p>
            <?php 
			echo FunctionCommon::crop(FunctionCommon::url_henkan($object['content']),80); ?>
            </p>
<?php        
					}
				}
		}
			echo '<p class="listBtn" style="margin-top:34px;">';	
			if(FunctionCommon::isViewFunction("president_msg")==true)
			{		
				echo '<a class="middleBtn listview mr10 floatL" href='.$urlIndex.'>一覧を見る</a>';
				
			if(!is_null($president_msg))
			{	
					foreach($president_msg as $object)
					{    
						echo '<a class="middleBtn detailview floatL" href='.$urlDetail.$object['id'].'>詳細を見る</a>';	
					}		
			}
			echo '</p>';
			}
		echo '</div>';	
		
	}
}


