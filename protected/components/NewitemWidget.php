<?php
class NewitemWidget extends CWidget
{
	public function init()
	{

	}

	public function run()
	{
		// SQL Query	
		$sql="select * from newitem order by created_date desc limit 5";
		// Define the DB connection for this page(to use your database first you have to remove the comment in code phrase in Config.php)
		$connection=Yii::app()->db; 
		// Execute the sql
		$command=$connection->createCommand($sql); 
		$newitem=$command->queryAll();

		$urlIndex=Yii::app()->baseUrl.'/majimenewitem/index';
		$urlRegist=Yii::app()->baseUrl.'/majimenewitem/regist';


		echo '<div class="box column2 newproduct">';
		echo '<div class="ttl">';
		echo '<h2>新商品情報</h2>';	
		if(FunctionCommon::isPostFunction("newitem")==true)
		{	
			echo '<a class="miniBtn regist01" href='.$urlRegist.'>登録</a>';	
		}
		
		echo '</div>';	
                echo '<p class="descriptionTxt">当社の新機種情報！　－営業本部にて投稿－</p>';		
		echo '<ul>';
		if(FunctionCommon::isViewFunction("newitem")==true)
		{
			if(!is_null($newitem))
			{	
				foreach($newitem as $object)
				{
				   if($object['type']==1)
				   {				   
						 echo '<li>';	
						 echo '<span class="date">'.FunctionCommon::formatDate($object['created_date']).'</span>';			
						 echo  CHtml::link(FunctionCommon::crop(htmlspecialchars($object['title']),8) ,array('/majimenewitem/detail','id'=>$object['id']));
						 echo '</li>';
					} 
					else
					{	
						 echo '<li>';	
						 echo '<span class="date">'.FunctionCommon::formatDate($object['created_date']).'</span>';	
						 echo '<i class="icon icon-share-alt"></i>';
						 echo  CHtml::link(FunctionCommon::crop(htmlspecialchars($object['title']),8),  FunctionCommon::url_henkan($object['content']), array('target'=>'_blank'));	
						 echo '</li>';
					}  
				}
			}	
		}
		else
		{
			$count=Yii::app()->db->createCommand('select count(*) from newitem')->queryScalar();
			echo Lang::MSG_0062.$count.'件です。';
		}
		echo '</ul>';
		if(FunctionCommon::isViewFunction("newitem")==true)
		{
			$sql_img="select attachment1,attachment2,attachment3 from newitem where type=1 order by created_date desc ";
			$connection=Yii::app()->db; 
			$command=$connection->createCommand($sql_img); 
			$images=$command->queryAll();
			
			$flag=false;
			foreach($images as $image)
			{
				if(!$flag)
				{
					$file_ext1=FunctionCommon::getExtensionFile($image["attachment1"]);
					$file_ext2=FunctionCommon::getExtensionFile($image["attachment2"]);
					$file_ext3=FunctionCommon::getExtensionFile($image["attachment3"]);
					if(!empty($image["attachment1"]) && in_array($file_ext1, Constants::$imgExtention))
					{
						
						$path=Yii::app()->baseUrl.$image["attachment1"];
						 echo '<img rel="prettyPhoto" src='.$path.'>';
						$flag=true;	
						
					}
					else if(!empty($image["attachment2"]) && in_array($file_ext2, Constants::$imgExtention))
					{
						
						$path=Yii::app()->baseUrl.$image["attachment2"];
						echo '<img rel="prettyPhoto" src='.$path.'>';
						$flag=true;	
					}
					else if(!empty($image["attachment3"]) && in_array($file_ext3, Constants::$imgExtention))
					{
						$path=Yii::app()->baseUrl.$image["attachment3"];
						echo '<img rel="prettyPhoto" src='.$path.'>';
						$flag=true;	
					}
				}
			}
		}
		
 	 	echo '<p class="listBtn">';
		if(FunctionCommon::isViewFunction("newitem")==true)
		{	
			echo '<a class="middleBtn listview" href='.$urlIndex.'>一覧を見る</a>';		
		}			
		echo '</p>';
		echo '</div>';	
	}
	
	
}


