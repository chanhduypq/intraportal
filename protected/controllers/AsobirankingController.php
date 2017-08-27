<?php
class AsobirankingController extends Controller 
{ 
	public $pageTitle;
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
						$contents=array_filter($contents);
						if(!empty($contents))
						{
							return $contents ;
						}
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

	public function actionAnimation()
	{
		$filename=$this->getFileName("MONTHLY_BLU-RAY_ANIME_");
		preg_match('/(\d{6})/', $filename, $matches);
		$yearmonth=isset($matches[1]) ? $matches[1]:null;
		$data = $this->getFileContent($filename);

		$page = (isset($_GET['page']) ? $_GET['page'] : 1);
		$page_size = Config::LIMIT_ROW ;
	   	$item_count = count($data);
		$pages = new CPagination($item_count);
        $pages->setPageSize($page_size);
		if(count($data)>0)
		{
			$data=array_slice($data,($page-1) * $page_size,$page_size,true);
		}
		$this->pageTitle="アニメDVDジャンル".substr($yearmonth, 4, 2)."月最新ランキング | ニューギンスクエア";
		$this->render('/asobi/ranking/animation',array('yearmonth'=>$yearmonth,
													   'data'=>$data,
													   'item_count' => $item_count,
													   'page_size' => $page_size,
													   'pages' => $pages));
	}	
	
	public function actionComic()
	{
		
		$filename=$this->getFileName("MONTHLY_BOOK_COMIC_");
		preg_match('/(\d{6})/', $filename, $matches);
		$yearmonth=isset($matches[1]) ? $matches[1]:null;
	    $data = $this->getFileContent($filename);	
	
		$page = (isset($_GET['page']) ? $_GET['page'] : 1);
 	    $page_size = Config::LIMIT_ROW ;
		$item_count = count($data);
		$pages = new CPagination($item_count);
        $pages->setPageSize($page_size);
		if(count($data)>0)
		{
			$data=array_slice($data,($page-1) * $page_size,$page_size,true);
		}
		$this->pageTitle="コミックジャンル ".substr($yearmonth, 0, 4)."年".substr($yearmonth, 4, 2)."月最新ランキング | ニューギンスクエア";
		$this->render('/asobi/ranking/comic',array('yearmonth'=>$yearmonth,
												   'data'=>$data,
												   'item_count' => $item_count,
												   'page_size' => $page_size,
												   'pages' => $pages));
	}	
	
	public function actionLightnovel()
	{
		$filename=$this->getFileName("MONTHLY_BOOK_LIGHTNOVEL_");
		preg_match('/(\d{6})/', $filename, $matches);
		$yearmonth=isset($matches[1]) ? $matches[1]:null;
	    $data = $this->getFileContent($filename);	
	    $page = (isset($_GET['page']) ? $_GET['page'] : 1);
 	    $page_size = Config::LIMIT_ROW ;
		$item_count = count($data);
		$pages = new CPagination($item_count);
        $pages->setPageSize($page_size);
		if(count($data)>0)
		{
			$data=array_slice($data,($page-1) * $page_size,$page_size,true);
		}
		$this->pageTitle='ライトノベルジャンル '.substr($yearmonth, 0, 4).'年'.substr($yearmonth, 4, 2).'月最新ランキング | ニューギンスクエア';
		$this->render('/asobi/ranking/lightnovel',array('yearmonth'=>$yearmonth,
														'data'=>$data,
												        'item_count' => $item_count,
												        'page_size' => $page_size,
												        'pages' => $pages));
	}	
}
?>