<?php
class SystemManage extends CWidget
{
	public function init()
	{
	}

	public function run()
	{
?>
		<dl class="menu sub">
            <dt>マスタ管理</dt>
             <?php 
			if(FunctionCommon::isAdminFunction('base')==true){?>
            <dd class="admin"><a class="base" href="<?php echo Yii::app()->baseUrl;?>/adminbase/">部署管理</a></dd>
             <?php 
			}
			if(FunctionCommon::isAdminFunction('office')==true){?>
            <dd class="admin"><a class="office" href="<?php echo Yii::app()->baseUrl;?>/adminoffice/">事業所管理</a></dd>
             <?php 
			}
			if(FunctionCommon::isAdminFunction('role')==true){?>
            <dd class="admin"><a class="role" href="<?php echo Yii::app()->baseUrl;?>/adminrole/">役割管理</a></dd>
             <?php 
			}
			if(FunctionCommon::isAdminFunction('user')==true){?>
            <dd class="admin"><a class="user" href="<?php echo Yii::app()->baseUrl;?>/adminuser/">ユーザー管理</a></dd>
             <?php              
			}
                        if(FunctionCommon::isAdminFunction('post')==true){?>
            <dd class="admin"><a class="post" href="<?php echo Yii::app()->baseUrl;?>/adminpost/">役職管理</a></dd>
             <?php              
			}
                        if(FunctionCommon::isAdminFunction('holiday')==true){?>
            <dd class="admin"><a class="holiday" href="<?php echo Yii::app()->baseUrl;?>/adminholiday/">休日管理</a></dd>
             <?php              
			}
			if(FunctionCommon::isAdminFunction('twitter')==true){?>
            <dd class="majime"><a class="twitter" href="<?php echo Yii::app()->baseUrl;?>/admintwitter/edit">Twitterキャッチ！設定</a></dd>
             <?php 
			}
			if(FunctionCommon::isAdminFunction('blogc')==true){?>
            <dd class="majime"><a class="blogc" href="<?php echo Yii::app()->baseUrl;?>/adminblogc/edit">ブログキャッチ！設定</a></dd>
             <?php 
			}
			if(FunctionCommon::isAdminFunction('slink')==true){?>
            <dd class="majime"><a class="slink" href="<?php echo Yii::app()->baseUrl;?>/adminslink/">オススメのリンク設定</a></dd>
            <?php }?>
        </dl>
<?php		
	}
}