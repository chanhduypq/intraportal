<?php
class AsobifortuneController extends Controller
{
	public $pageTitle;
	private	$horoscope = array(
								'魚座'   => array('start' => 'うお座','id'=>'uo'),
								'蟹座'   => array('start' => 'かに座','id'=>'kani'),
								'蠍座'   => array('start' => 'さそり座','id'=>'sasori'),
								'水瓶座' => array('start' => 'みずがめ座','id'=>'mizugame'),
								'天秤座' => array('start' => 'てんびん座','id'=>'tenbin'),
								'双子座' => array('start' => 'ふたご座','id'=>'futago'),
								'牡羊座' => array('start' => 'おひつじ座','id'=>'ohitusji'),
								'獅子座' => array('start' => 'しし座','id'=>'shishi'),
								'射手座' => array('start' => 'いて座','id'=>'ite'),
								'乙女座' => array('start' => 'おとめ座','id'=>'otome'),
								'牡牛座' => array('start' => 'おうし座','id'=>'oushi'),
								'山羊座' => array('start' => 'やぎ座','id'=>'yagi')
							 );
   public function init()
   {
		parent::init();
		$this->pageTitle="今日の星座別運勢 | ニューギンスクエア";
		if(Yii::app()->request->cookies['id'] =="")
		{ 
			$this->redirect(Yii::app()->baseUrl.'/index.php');
		}
	} 
	
	private function makeApiRequest() 
	{
		$today = date("Y/m/d");
		$json = file_get_contents("http://api.jugemkey.jp/api/horoscope/free/".$today."","r");
		$obj = json_decode($json);
		$horos = $obj->horoscope->$today;
		return $horos;
	}

	
	public function actionIndex()
	{
		$data = $this->makeApiRequest();
		$horoscope=$this->horoscope;
		$this->render('/asobi/fortune/index',array('data'=>$data,'horoscope'=>$horoscope));
	}

}