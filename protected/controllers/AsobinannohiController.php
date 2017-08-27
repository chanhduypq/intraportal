<?php

class AsobinannohiController extends Controller
{

   public $pageTitle;
   //check if logined or not
   public function init()
   {
        parent::init();
		$this->pageTitle="今日は何の日 | ニューギンスクエア";
        if(Yii::app()->request->cookies['id'] =="")
		{ 
			$this->redirect(Yii::app()->baseUrl.'/index.php');
        }
    } 

	private function makeApiRequest() 
	{
		define('L_WIKIPEDIA_API_URL', 'https://ja.wikipedia.org/wiki/%E7%89%B9%E5%88%A5:%E3%83%87%E3%83%BC%E3%82%BF%E6%9B%B8%E3%81%8D%E5%87%BA%E3%81%97');
		$q =date('n').'月'.date('j').'日';
                
//      	$q ='12月5日';
        $url=L_WIKIPEDIA_API_URL. '/'. urlencode($q);
        $temp="";
		$fp = fopen($url, "r");
		if($url)
		{
			while(!feof($fp)) 
			{
				$tmp = fgets($fp, 8192);
				$temp .= $tmp;
			}
			fclose($fp);
		}
		return $temp;
	}
	
	public function actionIndex()
	{
            
		$data = $this->makeApiRequest(); 
                $q=date('n').  date('j');
//                $q='125';
//                echo $data;
                if($q=='613'){
                    $this->render('/asobi/nannohi/index_613',array('data'=>$data));
                }
                else if($q=='820'){
                    $this->render('/asobi/nannohi/index_820',array('data'=>$data));
                }
                else if($q=='1126'){
                    $this->render('/asobi/nannohi/index_1126',array('data'=>$data));
                }
                else if($q=='625'){
                    $this->render('/asobi/nannohi/index_625',array('data'=>$data));
                }
                else{
                    $this->render('/asobi/nannohi/index',array('data'=>$data));
                }
    	
	}
}
?>
