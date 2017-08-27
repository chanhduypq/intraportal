<?php
class FortuneWidget extends CWidget
{


  private $horoscope = array(
                               '牡羊座' => array('start' => '3/21/92' ,'end' => '4/19/92',),
                               '牡牛座' => array('start' => '4/20/92' ,'end' => '5/20/92'),
                               '双子座' => array('start' => '5/21/92' ,'end' => '6/21/92'),
                               '蟹座'   => array('start' => '6/22/92' ,'end' => '7/22/92'),
                               '獅子座' => array('start' => '7/23/92' ,'end' => '8/22/92'),
                               '乙女座' => array('start' => '8/23/92' ,'end' => '9/22/92'),
                               '天秤座' => array('start' => '9/23/92' ,'end' => '10/23/92'),
                               '蠍座'   => array('start' => '10/24/92','end' => '11/21/92'),
                               '射手座' => array('start' => '11/22/92','end' => '12/21/92'),
                               '山羊座' => array('start' => '1/1/92'  ,'end' => '1/19/92'),
                               '水瓶座' => array('start' => '1/20/92' ,'end' => '2/18/92'),
                               '魚座'   => array('start' => '2/19/92' ,'end' => '3/20/92')
                             );
							 
	private	$horoscope1 = array(
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
	
	private function getBirthdayByEmp()
	{
		if(isset(Yii::app()->request->cookies['id']))
		{
			$id=Yii::app()->request->cookies['id'];
			$command = Yii::app()->db->createCommand();
			$command->select('*')->from('user')->where("id=$id");
			$user = $command->queryRow();
			return $user['birthday'];
		}
	}
	
	private function locate($date)
    {
		$date1=FunctionCommon::formatDate($date);
		$temp2=explode("/",$date1);
	    $birth_time =strtotime($date1);
		
		if($temp2[1] == 12 && $temp2[2] >= 22 && $temp2[2] <= 31)
		{
			return '山羊座';
		}

        foreach($this->horoscope as $key => $value)
		{
            $temp=explode("/", $value['start']);
            $temp1=explode("/", $value['end']);
			
			
			$start_time=date("Y",strtotime($date)).'/'.$temp[0].'/'.$temp[1];
			$start_time=strtotime($start_time);
			$end_time=date("Y",strtotime($date)).'/'.$temp1[0].'/'.$temp1[1];
			$end_time=strtotime($end_time);

			if($start_time <= $birth_time && $birth_time <= $end_time )
			{
				return $key;
            }
        }
    }
	
	public function init(){}
	
	

		  
	public function run()
	{
		$birthday=$this->getBirthdayByEmp();
		$sign=$this->locate($birthday);
		
		$today = date("Y/m/d");
		$json = file_get_contents("http://api.jugemkey.jp/api/horoscope/free/".$today."","r");
		$obj = json_decode($json);
		$horos = $obj->horoscope->$today;
		
			$urlIndex=Yii::app()->baseUrl.'/asobifortune';
		
			foreach($horos as $object)
			{
				if($object->sign==$sign)
				{
					echo '<div class="box fortune top">';
					echo '<h2>今日の星座別運勢</h2>';
					if(FunctionCommon::isViewFunction("fortune")==true)
					{
						echo '<div class="box fortune bottom">';
						foreach($this->horoscope1 as $key => $value)
						{
							if($key==$object->sign)
							{
								echo '<div class="cntBox '.$value['id'].'">';
							}
						}
						echo '<ul>'; 
						foreach($this->horoscope1 as $key => $value)
						{
							if($object->sign==$key)
							{
								echo '<li><a href="'.$urlIndex.'#'.$value['id'].'">詳細・運勢ランキング</a></li>';
								echo '<li><span>'.$object->rank.'位　'.$value['start'].'</span></li>';
							}
						}	
						echo '</ul>';
						echo '<dl class="pointList">';
						echo '<dt>総合運</dt>';
						echo '<dd class="tortal point'.$object->total.'"></dd>';
						echo '<dt>恋愛運</dt>';
						echo '<dd class="love point'.$object->love.'"></dd>';
						echo '<dt>仕事運</dt>';
						echo '<dd class="work point'.$object->job.'"></dd>';
						echo '<dt>金　運</dt>';
						echo '<dd class="economic point'.$object->money.'"></dd>';
						echo '</dl>';
						echo '<dl class="luckyList">';
						echo '<dt>ラッキーカラー</dt>';
						echo '<dd>'.$object->color.'</dd>';
						echo '<dt>ラッキーアイテム</dt>';
						echo '<dd>'.$object->item.'</dd>';
						echo '</dl>';
						echo '</div>';
						echo '<p class="listBtn"><a href='.$urlIndex.' class="middleBtn listview">一覧を見る</a></p>';    
						echo '</div>';
					}
					echo '</div>';
				}
        }
	}		
}
