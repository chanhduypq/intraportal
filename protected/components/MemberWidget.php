<?php
class MemberWidget extends CWidget
{
    public $assets_base;
    public function init()
	{

	}

	public function run()
	{	
		$urlIndex=Yii::app()->baseUrl.'/majimemember';
		if(FunctionCommon::isViewFunction("member")==true)
		{
                    $a=new Controller(1);
			
			echo '<div class="mapBox">';
            echo '<h5>その他の拠点&amp;メンバー紹介</h5>';
            echo '<p>日本地図をクリックすると、その他の拠点の詳細情報やメンバー紹介をご覧いただけます。</p>';
            echo '<a href='.$urlIndex.'><img src="'.$this->assets_base.'/css/majime/img/img_top_map.gif" /></a>';
            echo '</div>';
		}
		
	}
}


