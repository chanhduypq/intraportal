<?php
class RankingWidget extends CWidget
{
	public $assets_base;
	public function init() 
	{
        
    }
	
	private function formatDate($date)
	{
		if (preg_match("/[0-9]{4}\/[0-9]{2}\/[0-9]{2}/", $date))
		{
			return $date;
		}
		else
		{

			$year=substr($date, 0, 4);	
			$month=substr($date, 4, 2);	
			$day=substr($date, 6, 2);	
			$date="";
			if(!empty($year))
			{
				$date=$year;
			}
			if(!empty($month))
			{
				$date.='/'.$month;
			}
			if(!empty($day))
			{
				$date.='/'.$day;
			}
			return $date;
		}
	}
	
	private function getFileContent($filename)
	{
		if(!empty($filename))
		{
			$path=Config::RANKING_DATA_PATH.$filename;	
			if(file_exists($path) && is_readable($path))
			{
				if($file = fopen($path,"r+"))
				{
					$contents = array();
					while (!feof($file))
					{
						$contents[] = fgets($file);
					}

					fclose($file);
					ksort($contents);
					unset($contents[0]);
					$contents=array_slice($contents,0,3,true);
					return $contents ;
				}
			}
		}
	}	
	
	private function getFileName($filename)
	{
		$numbers=array();
		if (is_dir(Config::RANKING_DATA_PATH)) 
		{
			if ($handle = opendir(Config::RANKING_DATA_PATH)) 
			{
				while (false !== ($entry = readdir($handle))) 
				{
					if ($entry != "." && $entry != ".." && strstr($entry,$filename)) 
					{
						  preg_match("/[0-9]+/", $entry, $matches);
						  foreach($matches as $obj)
						  {
							 if(!is_null($obj))
							 {
								$numbers[] = $obj;
							 }
						  }
					}
				}
				if(count($numbers)>0)
				{
					$numbers=max($numbers);
					if(!is_null($numbers) && !empty($numbers))
					{
						return $filename.''.$numbers.'.txt';
					}
				}	
				closedir($handle);
			}
		}
	}
	
	public function run()
	{
		echo '<script type="text/javascript">';
		echo '$(document).ready(function () {';
		echo '$("#divComic").hide();';
		echo '$("#divLightnovel").hide();';
		echo '});';
		echo 'function showAnimation()';
		echo '{';
		echo '$("#divComic").hide();';
		echo '$("#divLightnovel").hide();';
		echo '$("#divAnimation").show();';
		echo  '}';
		echo 'function showComic()';
		echo '{';
		echo '$("#divAnimation").hide();';
		echo '$("#divLightnovel").hide();';
		echo '$("#divComic").show();';
		echo  '}';
		echo 'function showLightnovel()';
		echo '{';
		echo '$("#divAnimation").hide();';
		echo '$("#divComic").hide();';
		echo '$("#divLightnovel").show();';
		echo  '}';
		echo '</script>';

		$file_animation =$this->getFileName("MONTHLY_BLU-RAY_ANIME_");	
		preg_match('/(\d{6})/', $file_animation, $matches);
		$yearmonth_animation=isset($matches[1]) ? $matches[1]:null;
		$data_animation = $this->getFileContent($file_animation);	
	    $index_animation=Yii::app()->baseUrl.'/asobiranking/animation';
		
		$file_comic =$this->getFileName("MONTHLY_BOOK_COMIC_");
		preg_match('/(\d{6})/', $file_comic, $matches);
		$yearmonth_comic=isset($matches[1]) ? $matches[1]:null;	
		$data_comic = $this->getFileContent($file_comic);		
	    $index_comic=Yii::app()->baseUrl.'/asobiranking/comic';
		
		$file_lightnovel =$this->getFileName("MONTHLY_BOOK_LIGHTNOVEL_");
		preg_match('/(\d{6})/', $file_lightnovel, $matches);
		$yearmonth_lightnovel=isset($matches[1]) ? $matches[1]:null;		
		$data_lightnovel = $this->getFileContent($file_lightnovel);		
	    $index_lightnovel=Yii::app()->baseUrl.'/asobiranking/lightnovel';
		
		echo '<div class="box newranking top">';
		echo '<h2>最新ランキング</h2>';
        if(FunctionCommon::isViewFunction("ranking"))
		{
				
				echo '<ul class="rankingMenu" id="tabs">';
				echo '<li class="anime"><a onclick="return showAnimation();"></a></li>';
				echo '<li class="comic"><a onclick="return showComic();"></a></li>';
				echo '<li class="bunko"><a onclick="return showLightnovel();"></a></li>';
				echo '</ul>';
				if(count($data_animation)>0)
				{
					echo '<div id="divAnimation" class="box newranking bottom">';
					echo '<div class="cntBox">';
					echo '<h3>アニメBlu-rayジャンル：'.substr($yearmonth_animation, 4, 2).'月最新ランキング</h3>';
					
					echo '<div id="ranktab1">';
					echo '<ul>';
				
						foreach($data_animation as $animation)
						{
							 $animation=(explode("	",$animation));
							 switch ($animation[0]) 
							 {
								case 1:
									echo '<li class="rank1">';
									break;
								case 2:
									echo '<li class="rank2">';
									break;
								case 3:
									echo '<li class="rank3">';
									break;
							 }
							 echo '<span>発売日：'.$this->formatDate($animation[6]).'</span>';
							 echo '<p><a target="_blank" href="http://www.amazon.co.jp/s/ref=nb_sb_noss?__mk_ja_JP=カタカナ&url=search-alias%3Daps&field-keywords='.$animation[5].'">'.$animation[5].'</a></p>';
							 echo '</li>';
						}
					echo '</ul>';
					echo '</div>';
					echo '</div>';
					echo '<p class="listBtn"><a class="middleBtn listview" href='.$index_animation.'>一覧を見る</a></p>';
					echo '</div>';
				}
				if(count($data_comic)>0)
				{
					//ranktab2
					echo '<div id="divComic" class="box newranking bottom">';
					echo '<div class="cntBox">';
					echo '<h3>コミックジャンル：'.substr($yearmonth_comic, 4, 2).'月最新ランキング</h3>';
					
					echo '<div id="ranktab2">';
					echo '<ul>';
					
					foreach($data_comic as $comic)
					{
						 $comic=(explode("	",$comic));
						 switch ($comic[0]) 
						 {
							case 1:
								echo '<li class="rank1">';
								break;
							case 2:
								echo '<li class="rank2">';
								break;
							case 3:
								echo '<li class="rank3">';
								break;
						 }
						 echo '<span>発売日：'.$this->formatDate($comic[6]).'</span>';
						 echo '<p><a target="_blank" href="http://www.amazon.co.jp/s/ref=nb_sb_noss?__mk_ja_JP=カタカナ&url=search-alias%3Daps&field-keywords='.$comic[3].'">'.$comic[3].'</a></p>';
						 echo '</li>';
					}
					echo '</ul>';
					echo '</div>';
					echo '</div>';
					echo '<p class="listBtn"><a class="middleBtn listview" href='.$index_comic.'>一覧を見る</a></p>';
					echo '</div>';
				}
				if(count($data_lightnovel)>0)
				{
					//ranktab3
					echo '<div id="divLightnovel" class="box newranking bottom">';
					echo '<div class="cntBox">';
					echo '<h3>ライトノベルジャンル：'.substr($yearmonth_lightnovel, 4, 2).'月最新ランキング</h3>';
					
					echo '<div id="ranktab3">';
					echo '<ul>';
					foreach($data_lightnovel as $lightnovel)
					{
						 $lightnovel=(explode("	",$lightnovel));
						 switch ($lightnovel[0]) 
						 {
							case 1:
								echo '<li class="rank1">';
								break;
							case 2:
								echo '<li class="rank2">';
								break;
							case 3:
								echo '<li class="rank3">';
								break;
						 }
						 echo '<span>発売日：'.$this->formatDate($lightnovel[6]).'</span>';
						 echo '<p><a target="_blank" href="http://www.amazon.co.jp/s/ref=nb_sb_noss?__mk_ja_JP=カタカナ&url=search-alias%3Daps&field-keywords='.$lightnovel[3].'">'.$lightnovel[3].'</a></p>';
						 echo '</li>';
					}
					echo '</ul>';
					echo '</div>';
					echo '</div>';
					echo '<p class="listBtn"><a class="middleBtn listview" href='.$index_lightnovel.'>一覧を見る</a></p>';
					echo '</div>';
			}
		}
        echo '</div>';
		
	}
}?>