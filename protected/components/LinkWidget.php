<?php
class LinkWidget extends CWidget
{
	public function init()
	{

	}
	public function run()
	{
            
		if(FunctionCommon::isViewFunction("link")==true)
		{
			$urlIndex=Yii::app()->baseUrl.'/asobilink';
			echo '<li style="margin-bottom: 28px;width: 286px;height: 65px;color: black;font-size: 11px;text-indent: -9999px;">';                        
			echo '<a href='.$urlIndex.' class="link">リンク集</a>';
                        echo '<p style="margin-top: 2px;text-indent: 10px;background: none repeat scroll 0% 0% #F7CFCF;border-radius: 5px;font-size: 11px;width: 185px;">いろんな情報を共有しましょう！登録希望は総務課まで！</p>';
			echo '</li>';
		}
	}
}





