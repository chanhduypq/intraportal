<?php
class BountyWidget extends CWidget
{
	public function init()
	{

	}
	private function countComment($id)
	{
		$count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM bounty_apply WHERE bounty_id='.$id)->queryScalar();
		return $count;
	}
	public function run()
	{
		// SQL Query	
		$sql="select * from bounty order by created_date desc limit 3";
		// Define the DB connection for this page(to use your database first you have to remove the comment in code phrase in Config.php)
		$connection=Yii::app()->db; 
		// Execute the sql
		$command=$connection->createCommand($sql); 
		$bounty=$command->queryAll();
		
		$urlIndex=Yii::app()->baseUrl.'/majimebounty';
		$urlRegist=Yii::app()->baseUrl.'/majimebounty/regist';
		
		echo '<div class="box prize">';
		echo '<div class="ttl">';
		echo '<h2>懸賞金付き募集コンテンツ</h2>';
		if(FunctionCommon::isPostFunction("bounty")==true)
		{
			echo '<a class="miniBtn regist01" href='.$urlRegist.'>登録</a>';
		}
		
		echo '</div>';
		echo '<p class="descriptionTxt">意見やアイディアを投稿して懸賞金をGET！募集を行う際は申請が必要です。</p>';
		echo '<ul>';
		if(FunctionCommon::isViewFunction("bounty")==true)
		{
			if(!is_null($bounty))
			{	
				foreach($bounty as $object)
				{	
					echo '<li>';	
					echo '<span class="date">'.FunctionCommon::formatDate($object['created_date']).'</span>';
					if(!is_null($object["adopted_flag"]) && $object["adopted_flag"]== 1)
					{
						echo  CHtml::link(FunctionCommon::crop(htmlspecialchars($object['title']),21),array('majimebounty/detailado','id'=>$object['id']));
					}
					else
					{
						echo  CHtml::link(FunctionCommon::crop(htmlspecialchars($object['title']),21),array('majimebounty/detail','id'=>$object['id']));
					}
					echo '<div class="term">';
					echo '<p class="comment">募集締め切り：'.FunctionCommon::formatDate($object['deadline']).' 〆</p>';
					echo '<p class="count">投稿数（'.$this->countComment($object['id']).'）</p>';
					echo '</div>';
					echo '</li>';
				}
			}
		}
		else
		{
			$count=Yii::app()->db->createCommand('select count(*) from bounty')->queryScalar();
			echo Lang::MSG_0062.$count."件です。";
		}	
		echo '</ul>';
		echo '<p class="listBtn">';
		if(FunctionCommon::isViewFunction("bounty")==true)
		{	
			echo '<a class="middleBtn listview" href='.$urlIndex.'>一覧を見る</a>';	
		}
		echo '</p>';
		echo '</div>';	

	}
}





