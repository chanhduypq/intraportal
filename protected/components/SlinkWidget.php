<?php
class SlinkWidget extends CWidget
{
	public function init()
	{

	}
	public function run()
	{
		// SQL Query	
		$sql="select * from slink where slink.type=1 order by created_date desc";
		// Define the DB connection for this page(to use your database first you have to remove the comment in code phrase in Config.php)
		$connection=Yii::app()->db; 
		// Execute the sql
		$command=$connection->createCommand($sql); 
		$slink=$command->queryAll();
		
		echo '<div class="box portalMenu">';
		echo '<h2>オススメのリンク</h2>';
                echo '<p class="descriptionTxt">－マーケティング部にて投稿－</p>';           
		echo '<ul class="serviceLink">';
		if(FunctionCommon::isViewFunction("slink")==true)
		{
			if(!is_null($slink))
			{
				foreach($slink as $object)
				{
					echo '<li>';
					echo '<a href='.$object['url'].' target="_blank">';
					echo htmlspecialchars($object['title']); 
					echo '</a>';
					echo '</li>';
				}
			}	
		}
		echo '</ul>';
		echo '</div>';
	}
}





