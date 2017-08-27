<?php
class MeigenWidget extends CWidget
{
	public function init()
	{

	}
	public function run()
	{
		 if(FunctionCommon::isViewFunction("meigen")==true)
		 {
			$urlIndex=Yii::app()->baseUrl.'/asobimeigen';
			echo '<li>';
			echo '<a href='.$urlIndex.' class="mot">今日の名言</a>';
			echo '</li>';
		}
	}
}





