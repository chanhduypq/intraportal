<?php
class Enquetewidget extends CWidget
{
	public function init()
	{

	}

	public function run()
	{
		
		$urlIndex=Yii::app()->baseUrl.'/majimeenquete/index';
		$urlRegist=Yii::app()->baseUrl.'/majimeenquete/regist';
				
		echo '<div class="box question">';
		echo '<div class="ttl">';
		echo '<h2>みんなのアンケートBOX</h2>';	
        
        if(FunctionCommon::isPostFunction("enquete")==true)
		{	
		  echo '<a class="miniBtn create" href='.$urlRegist.'>作成</a>';
        }
		
        			
		echo '</div>';
		echo '<p class="descriptionTxt">';
		echo '誰でも気軽に社内アンケートを実施できます！';
		echo '</p>';
		echo '<ul>';
        
         if(FunctionCommon::isViewFunction("enquete")==true){
        // SQL Query	
		$sql="select * from enquete order by created_date desc limit 3";
		// Define the DB connection for this page(to use your database first you have to remove the comment in code phrase in Config.php)
		$connection=Yii::app()->db; 
		// Execute the sql
		$command=$connection->createCommand($sql); 
		$enquete=$command->queryAll();  //var_dump($enquete);exit;
        
		if(!is_null($enquete))
		{	
			$now = strtotime(date('Y/m/d'));
			foreach($enquete as $object)
			{
			   $title = FunctionCommon::crop(htmlspecialchars($object['title']),17);
			   $deadline = strtotime(date('Y/m/d', strtotime($object['deadline'])));
			   echo '<li>';
			   if($deadline >= $now)
			   {
				echo '<div class="ico open">開催</div>';
			   }
			   else
			   {
			    echo '<div class="ico syuuryou">終了</div>';
			   }
			   echo '<p>';
			   echo '<span class="date">'.FunctionCommon::formatDate($object['created_date']).'</span>';
			   if($deadline >= $now)
			   {
				 echo  CHtml::link($title,array('majimeenquete/detail','id'=>$object['id']));
			   }
			   else
			   {
			     echo  CHtml::link($title,array('majimeenquete/detail_result','id'=>$object['id']));
			   }
			  
			   echo '</p>';
			   echo '</li>';
			}
		  }
		}
		else
		{
			$count=Yii::app()->db->createCommand('select count(*) from enquete')->queryScalar();
			echo Lang::MSG_0062.$count.'件です。';
		}	
		echo '</ul>';		
		echo '<p class="listBtn">';		
        
        if(FunctionCommon::isViewFunction("enquete")==true)
		{		
		  echo '<a class="middleBtn listview" href='.$urlIndex.'>一覧を見る</a>';		
        }
        	 
		echo '</p>';
		echo '</div>';	
	}
}



