<?php
class Hobby_newWidget extends CWidget
{
	public function init()
	{

	}
	
	public function run()
	{
		// SQL Query	
		$sql="select * from hobby_new order by created_date desc limit 3";
		// Define the DB connection for this page(to use your database first you have to remove the comment in code phrase in Config.php)
		$connection=Yii::app()->db; 
		// Execute the sql
		$command=$connection->createCommand($sql); 
		$hobby_new=$command->queryAll();

		$urlIndex=Yii::app()->baseUrl.'/asobihobby_new';
		$urlRegist=Yii::app()->baseUrl.'/asobihobby_new/regist';
		$hobby_new_comment = Yii::app()->db->createCommand()
                        ->select(array(
                            'hobby_new_id'
                                )
                        )
                        ->from('hobby_new_comment')
                        ->queryAll();		
						
		echo '<div class="ttl">';
		echo '<h3>What is New</h3>';
		if(FunctionCommon::isViewFunction("hobby_new"))
		{	
			echo '<a class="middleBtn listview" href='.$urlIndex.'>一覧を見る</a>';		
		}
                else{
                    $hobby_new=array();
                }
		if(FunctionCommon::isPostFunction("hobby_new"))
		{	
			echo '<a class="miniBtn regist02" href='.$urlRegist.'>登録</a>';	
		}
		
		echo '</div>';
		echo '<ul>';
		if(FunctionCommon::isViewFunction("hobby_new"))
		{
			foreach($hobby_new as $object)
			{
				echo '<li>';	
				echo '<span class="date">';
				echo  FunctionCommon::formatDate($object['created_date']);
				echo '</span>';	
				echo '<p>';		
				echo  CHtml::link(FunctionCommon::crop(htmlspecialchars($object["title"]),60) ,array('/asobihobby_new/detail','id'=>$object['id']));
				echo '</p>';
				$i = 0; 
				 foreach ($hobby_new_comment as $comment) {
					 if($object['id']==$comment['hobby_new_id']){ 
					 $i = $i+1;
					 } 
				 }
				echo "<span style='margin-left:12px;' class='count'>コメント数（".$i."）</span>";
				echo '</li>';
			}
		}
		echo '</ul>';
	}
}