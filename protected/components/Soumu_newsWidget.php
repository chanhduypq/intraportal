<?php
class Soumu_newsWidget extends CWidget
{
	public function init()
	{
	}

	public function run()
	{
		$sql="select * from soumu_news order by created_date desc limit 3";
		$connection=Yii::app()->db; 
		$command	=	$connection->createCommand($sql); 
		$soumu_news  =	$command->queryAll();
		$now = strtotime(date('Y/m/d'));
        $item_count = Yii::app()->db->createCommand()
                    ->select('count(*) as count')
                    ->from('soumu_news')
                    ->queryScalar();
		$now = strtotime(date('Y/m/d'));			
		if(FunctionCommon::isViewFunction("soumu_news")==true)
		{
			if(is_array($soumu_news )&&count($soumu_news )>0)
			{
					foreach ($soumu_news as $soumu_new) 
					{
						$created_date =FunctionCommon::formatDate($soumu_new['created_date']);		
						$created_date_compare = strtotime(date('Y/m/d', strtotime($soumu_new['created_date'])));
						$title=FunctionCommon::crop(htmlspecialchars($soumu_new['title']),45);
						$content=FunctionCommon::crop(htmlspecialchars($soumu_new['title']),100);
						echo '<dd>';
						echo '<span class="date">'.$created_date.'</span>';
						echo '<p class="text">';
						if($created_date_compare > $now-650000)
						{
							echo '<span class="badge badge-warning mr10" style="width:30px;">NEW</span>';
						}
						if($soumu_new['label']=='1')
						{ 
							echo '<span class="badge badge-important" style="width:23px;">重要</span>&nbsp;';
						}
			?>			
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/majimesoumu_news/detail/?id=<?php echo $soumu_new['id']; ?>">
							<?php echo FunctionCommon::crop(htmlspecialchars($soumu_new['title']),43)?>
						</a>
            <?php            
						//echo '<br/>';
						//echo  FunctionCommon::crop(htmlspecialchars($content),25);
						echo '</p>';
						echo '</dd>';
					}
			}
          }
                
		
	}

}