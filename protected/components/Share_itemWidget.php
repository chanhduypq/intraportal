<?php
class Share_itemWidget extends CWidget
{
	public function init()
	{
	}

	public function run()
	{
		

		$urlIndex	=	Yii::app()->baseUrl.'/majimeshare_item/';
		$urlRegist	=	Yii::app()->baseUrl.'/majimeshare_item/regist';

		echo '<div class="box kyouyuu">';                
		echo ' <h2 class="ttl">共有事項</h2>';                
		echo ' <div>';	                
                echo '<p class="descriptionTxt">－経営管理本部にて投稿－</p>';
		echo '<ul>';
		
		if(FunctionCommon::isViewFunction("share_item")==true)
		{
			
		$sql="select * from share_item order by created_date desc limit 5";
		$connection=Yii::app()->db; 
		$command	=	$connection->createCommand($sql); 
		$share_item  =	$command->queryAll();
		
		if(!is_null($share_item))
		{	
			foreach($share_item as $object)
			{
				if($object['attachment1'] !=""){								   
						$temp = explode(".", $object['attachment1']);
						$attachment1_ext = $temp[count($temp) - 1];
						$data[1] = strtolower($attachment1_ext);
						if($data[1]=="zip" || $data[1]=="rar"){ $ico="zip";}
						else if($data[1]=="doc" || $data[1]=="docx"){ $ico="word";}
						else if($data[1]=="xls" || $data[1]=="xlsx"){ $ico="excel";}
						else if($data[1]=="ppt" || $data[1]=="pptx"){ $ico="ppt";}
						else if($data[1]=="pdf"){ $ico="pdf";}
						else { $ico="";}
					}
				else if($object['attachment2'] !=""){								   
						$temp = explode(".", $object['attachment2']);
						$attachment1_ext = $temp[count($temp) - 1];
						$data[1] = strtolower($attachment1_ext);
						if($data[1]=="zip" || $data[1]=="rar"){ $ico="zip";}
						else if($data[1]=="doc" || $data[1]=="docx"){ $ico="word";}
						else if($data[1]=="xls" || $data[1]=="xlsx"){ $ico="excel";}
						else if($data[1]=="ppt" || $data[1]=="pptx"){ $ico="ppt";}
						else if($data[1]=="pdf"){ $ico="pdf";}
						else { $ico="";}
					}
				else if($object['attachment3'] !=""){								   
						$temp = explode(".", $object['attachment3']);
						$attachment1_ext = $temp[count($temp) - 1];
						$data[1] = strtolower($attachment1_ext);
						if($data[1]=="zip" || $data[1]=="rar"){ $ico="zip";}
						else if($data[1]=="doc" || $data[1]=="docx"){ $ico="word";}
						else if($data[1]=="xls" || $data[1]=="xlsx"){ $ico="excel";}
						else if($data[1]=="ppt" || $data[1]=="pptx"){ $ico="ppt";}
						else if($data[1]=="pdf"){ $ico="pdf";}
						else { $ico="";}
					}		
				else { $ico ="";}
					
			   echo '<li>';	
			   echo '<span class="date">'.FunctionCommon::formatDate($object['created_date']).'</span>';	
?>
			   <a class="<?php echo $ico;?>" href="<?php echo Yii::app()->request->baseUrl; ?>/majimeshare_item/detail/?id=<?php echo $object['id']; ?>">
					<?php echo FunctionCommon::crop(htmlspecialchars($object['title']),16)?>
			  </a>	
<?php			   
			   echo '</li>';
			}
		  }
		}	
		else{
			$sql="select COUNT(*) from share_item";
			$connection=Yii::app()->db; 
			$command	=	$connection->createCommand($sql); 
			$share_item  =	$command->queryScalar();
			echo Lang::MSG_0062.$share_item."件です。";
			}
			
		echo '</ul>';
		echo '<p class="listBtn">';
		if(FunctionCommon::isViewFunction("share_item")==true)
		{
			echo '<a class="middleBtn listview" href='.$urlIndex.'>一覧を見る</a>';	
		}
		echo '</p>';
		echo '</div>';	
		echo '</div>';	
		
	}
}