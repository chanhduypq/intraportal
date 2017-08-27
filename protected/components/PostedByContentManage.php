<?php
class PostedByContentManage extends CWidget
{
	public function init()
	{
	}

	public function run()
	{
?>
		<dl class="menu sub">
            <dt>コンテンツ別投稿管理</dt>
              <?php 
			if(FunctionCommon::isAdminFunction('newitem')==true){?>
            <dd class="majime"><a class="newitems" href="<?php echo Yii::app()->baseUrl;?>/adminnewitem/">新商品情報</a></dd>
             <?php 
			}
			if(FunctionCommon::isAdminFunction('criticism')==true){?>
            <dd class="majime"><a class="criticism" href="<?php echo Yii::app()->baseUrl;?>/admincriticism/">機種総評&amp;検証！</a></dd>
             <?php 
			}
			if(FunctionCommon::isAdminFunction('claim')==true){?>
            <dd class="majime"><a class="claim" href="<?php echo Yii::app()->baseUrl;?>/adminclaim/">お客様クレーム</a></dd>
             <?php 
			}
			if(FunctionCommon::isAdminFunction('trouble')==true){?>
            <dd class="majime"><a class="trouble" href="<?php echo Yii::app()->baseUrl;?>/admintrouble/">トラブル&amp;不正情報</a></dd>
             <?php 
			}
			if(FunctionCommon::isAdminFunction('rival')==true){?>
            <dd class="majime"><a class="rival" href="<?php echo Yii::app()->baseUrl;?>/adminrival/">競合情報</a></dd>
             <?php 
			}
			if(FunctionCommon::isAdminFunction('president_msg')==true){?>
            <dd class="majime"><a class="president_msg" href="<?php echo Yii::app()->baseUrl;?>/adminpresident_msg/">新井社長メッセージ</a></dd>
             <?php 
			}
			if(FunctionCommon::isAdminFunction('to_officer')==true){?>
            <dd class="majime"><a class="to_officers" href="<?php echo Yii::app()->baseUrl;?>/adminto_officer/">役員宛目安箱</a></dd>
             <?php 
			}
			if(FunctionCommon::isAdminFunction('report')==true){?>
            <dd class="majime"><a class="report" href="<?php echo Yii::app()->baseUrl;?>/adminreport/">リアルタイム社内報告</a></dd>
             <?php 
			}
			if(FunctionCommon::isAdminFunction('enquete')==true){?>
            <dd class="majime"><a class="enquete" href="<?php echo Yii::app()->baseUrl;?>/adminenquete/">みんなのアンケートBOX</a></dd>
             <?php 
			}
			if(FunctionCommon::isAdminFunction('ideas')==true){?>
            <dd class="majime"><a class="ideas" href="<?php echo Yii::app()->baseUrl;?>/adminideas/">製品アイデア投稿広場</a></dd>
             <?php 
			}
			if(FunctionCommon::isAdminFunction('bbs')==true){?>
            <dd class="majime"><a class="bbs" href="<?php echo Yii::app()->baseUrl;?>/adminbbs/">ニューギン掲示板</a></dd>
             <?php 
			}
			if(FunctionCommon::isAdminFunction('bounty')==true){?>
            <dd class="majime"><a class="bounty" href="<?php echo Yii::app()->baseUrl;?>/adminbounty/">懸賞金付き募集コンテンツ</a></dd>
             <?php 
			}
			if(FunctionCommon::isAdminFunction('pride')==true){?>
            <dd class="asobi"><a class="pride" href="<?php echo Yii::app()->baseUrl;?>/adminpride/">あそびにマジメ！<br>あそび自慢＆対決！</a></dd>
             <?php 
			}
			if(FunctionCommon::isAdminFunction('golf_news')==true){?>
            <dd class="asobi"><a class="golf_news" href="<?php echo Yii::app()->baseUrl;?>/admingolf_news/">ゴルフもマジメ<br>お知らせ・結果報告・<br>参加募集</a></dd>
             <?php 
			}
			if(FunctionCommon::isAdminFunction('golf_score')==true){?>
            <dd class="asobi"><a class="golf_score" href="<?php echo Yii::app()->baseUrl;?>/admingolf_score/">ゴルフもマジメ<br>年間スコアランキング</a></dd>
             <?php 
			}
			if(FunctionCommon::isAdminFunction('hobby_new')==true){?>
            <dd class="asobi"><a class="hobby_new" href="<?php echo Yii::app()->baseUrl;?>/adminhobby_new/">趣味・サークルの広場<br>What's New</a></dd>
             <?php 
			}
			if(FunctionCommon::isAdminFunction('hobby_itd')==true){?>
            <dd class="asobi"><a class="hobby_itd" href="<?php echo Yii::app()->baseUrl;?>/adminhobby_itd/">趣味・サークルの広場<br>サークル紹介</a></dd>
            <?php }
            if(FunctionCommon::isAdminFunction('tagcrowd')==true){?>
            <dd class="asobi"><a class="tagcrowd" href="<?php echo Yii::app()->baseUrl;?>/admintagcrowd/">タグクラウド設定</a></dd>
            <?php }
            ?>
        </dl>
<?php		
	}
}