<?php
class MenutopWidget extends CWidget
{
	public function init()
	{
	}

	public function run()
	{
?>		
		<div class="tab">
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/asobi" class="asobi">あそび</a>
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/majime" class="majime">まじめ</a>
        </div>
        <div class="userName"><i class="icon icon-user"></i> こんにちは！<span><?php echo Yii::app()->session['lastname'].' '.Yii::app()->session['firstname'];?></span>さん</div>
        <div class="navi dropdown">
            <div class="btn-group">
                <a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/" class="admin">管理メニュー</a>
            </div>
            <div class="btn-group">
            <?php
				if(Yii::app()->request->cookies['passwd']=='7581'){
			?>	
				<script type='text/javascript'>
				 $(document).ready(function(){
					$("a.howto").attr("href", "#");
					});
				</script>
			<?php		
            }
            ?>
                <a href="/help" target="_blank" class="howto">使い方</a>
            </div>
            <div class="btn-group">
            <?php
				if(Yii::app()->request->cookies['passwd']=='7581'){
			?>	
				<script type='text/javascript'>
				 $(document).ready(function(){
					$("a.logout").attr("href", "<?php echo Yii::app()->request->baseUrl; ?>/newgin/Logout");
					});
				</script>
			<?php		
            }
            ?>
             <a href="<?php echo Yii::app()->request->baseUrl; ?>/newgin/Logout" class="logout">ログアウト</a></div>
        </div><!-- /navi -->
<?php	
	}
}
?>


