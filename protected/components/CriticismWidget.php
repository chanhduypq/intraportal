<?php
class CriticismWidget extends CWidget
{
	public function init()
	{
	}

	public function run()
	{
		

		$urlIndex	=	Yii::app()->baseUrl.'/majimecriticism/';
		$urlRegist	=	Yii::app()->baseUrl.'/majimecriticism/regist';

		echo '<div class="box inspection">';
		echo '<div class="ttl">';
		echo '<h2>機種総評&amp;検証</h2>';	
		if(FunctionCommon::isPostFunction("criticism")==true)
		{
			echo '<a class="miniBtn regist01" href='.$urlRegist.'>登録</a>';		
		}
		
		echo '</div>';
                echo '<p class="descriptionTxt">販売後の機種総評／検証　－各開発部 ＆営業本部にて投稿－</p>';      
		echo '<ul>';
		
		if(FunctionCommon::isViewFunction("criticism")==true)
		{
			
		$sql="select * from criticism order by created_date desc limit 5";
		$connection=Yii::app()->db; 
		$command	=	$connection->createCommand($sql); 
		$criticism  =	$command->queryAll();
		
		if(!is_null($criticism))
		{	
			foreach($criticism as $object)
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
			   <a class="<?php echo $ico;?>" href="<?php echo Yii::app()->request->baseUrl; ?>/majimecriticism/detail/?id=<?php echo $object['id']; ?>">
					<?php echo FunctionCommon::crop(htmlspecialchars($object['title']),16)?>
			  </a>	
<?php			   
			   echo '</li>';
			}
		  }
		}	
		else{
			$sql="select COUNT(*) from criticism";
			$connection=Yii::app()->db; 
			$command	=	$connection->createCommand($sql); 
			$criticism  =	$command->queryScalar();
			echo Lang::MSG_0062.$criticism."件です。";
			}
			
		echo '</ul>';
		echo '<p class="listBtn">';
		if(FunctionCommon::isViewFunction("criticism")==true)
		{
			echo '<a class="middleBtn listview" href='.$urlIndex.'>一覧を見る</a>';	
		}
		echo '</p>';
		echo '</div>';	
		
		
	}
}

