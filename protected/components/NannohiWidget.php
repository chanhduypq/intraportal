<?php
class NannohiWidget extends CWidget
{
	public function init()
	{

	}
	public function run()
	{
		 if(FunctionCommon::isViewFunction("nannohi")==true)
		 {
			$urlIndex=Yii::app()->baseUrl.'/asobinannohi';
			echo '<li>';
			echo '<a href='.$urlIndex.' class="what_day">今日は何の日</a>';
			echo '</li>';
		}
	}
}





