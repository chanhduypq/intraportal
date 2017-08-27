<?php
class MenuManager extends CWidget
{
	public function init()
	{
	}

	public function run()
	{
?>
		<dl class="menu main">
            <dt>管理メニュー</dt>
            <dd class="admin"><a class="posts" href="<?php echo Yii::app()->baseUrl;?>/admin">投稿履歴</a></dd>
            
            <dd class="admin">
            <?php
				if(Yii::app()->request->cookies['passwd']=='7581'){
			?>	
				<script type='text/javascript'>
				 $(document).ready(function(){
					$("a.profile").attr("href", "<?php echo Yii::app()->baseUrl;?>/adminprofile/detail/?id=<?php echo Yii::app()->request->cookies['id'];?>");
					});
				</script>
			<?php		
            }
            ?>
            <a class="profile" href="<?php echo Yii::app()->baseUrl;?>/adminprofile/detail/?id=<?php echo Yii::app()->request->cookies['id'];?>">プロフィール</a></dd>
            <?php 
            $count=Yii::app()->db->createCommand("select count(*) AS count from user where id=".Yii::app()->request->cookies['id']->value." AND (div_intro_modifiable_flag1=1 OR div_intro_modifiable_flag2=1 OR div_intro_modifiable_flag3=1 OR div_intro_modifiable_flag4=1)")->queryScalar();                      
            if($count!=FALSE&&$count=='1'){?>
            <dd class="admin">
                <a class="unit" href="<?php echo Yii::app()->baseUrl;?>/adminunit/">部署紹介</a>	
            </dd>    
            <?php
            }
            ?>
 
        </dl>
<?php		
	}
}