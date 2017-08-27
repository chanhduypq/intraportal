<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>
<script type="text/javascript">
    jQuery(function($) 
	{
        $("body").attr('id', 'admin');
    });
</script>

<?php $attachment1 = $model->attachment1; ?>
<?php $attachment2 = $model->attachment2; ?>
<?php $attachment3 = $model->attachment3; ?>
<?php $attachment1_ext = FunctionCommon::getExtensionFile($model->attachment1); ?>
<?php $attachment2_ext = FunctionCommon::getExtensionFile($model->attachment2); ?>
<?php $attachment3_ext = FunctionCommon::getExtensionFile($model->attachment3); ?>

<div class="wrap admin secondary soumu_news" id="admin">

    <div class="container">
        <div class="contents detail">

            <div class="mainBox detail">
                <div class="pageTtl">
				<h2>総務からのお知らせ - 詳細</h2>
					<span>
						<?php if(!empty(Yii::app()->request->cookies['page'])): ?>	
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminsoumu_news/index?page=<?php echo Yii::app()->request->cookies['page']?>" class="btn btn-important">
								<i class="icon-chevron-left icon-white"></i> 一覧に戻る
							</a>
						<?php else : ?>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminsoumu_news/index" class="btn btn-important">
								<i class="icon-chevron-left icon-white"></i> 一覧に戻る
							</a>
						<?php endif; ?>
					</span>
                    <span>
						<a class="btn btn-work" href="<?php echo Yii::app()->request->baseUrl; ?>/adminsoumu_news/edit/?id=<?php echo $model->id; ?>">
							<i class="icon-pencil icon-white"></i> 修正
						</a>
					</span>
                </div>
                <div class="box">
                    <div class="postsDate">
						<i class="icon-pencil"></i> 投稿日時：
							<span class="date">
								<?php echo FunctionCommon::formatDate($model->created_date); ?>
							</span>
							<span class="time">
								<?php echo FunctionCommon::formatTime($model->created_date); ?>
							</span>
						</div>
                    <div class="detailTtl">
                        <h3 class="ttl">
                        	<?php if($model->label=='1'){ echo '<span class="badge badge-important">重要</span>&nbsp;';}?>
							<?php echo htmlspecialchars($model->title);?>
						</h3>
                        <p class="area">
                            
                        </p>
                    </div>
                    <p class="cnt-box">
						 <?php echo nl2br(FunctionCommon::url_henkan($model->content));?>
					</p>
                    <?php  $attachements = $this->beginWidget('ext.helpers.Form');?>  
                    <?php  $attachements->detail($model, 'adminsoumu_news',$this->assetsBase,$edit=true);  ?>                         
                    <?php $this->endWidget(); ?>  
                </div><!-- /box -->
            </div><!-- /mainBox -->
            <div class="sideBox">
                <ul>
                    <li>
						<?php $this->widget('MenuManager'); ?>
						<?php $this->widget('AffairsManage'); ?>
                        <?php $this->widget('SystemManage'); ?>
                        <?php $this->widget('PostedByContentManage'); ?>
                    </li>
                </ul>
            </div>

            <!-- /sideBox -->

        </div><!-- /contents -->
        <p id="page-top" style="display: block;">
			<a href="#wrap">PAGE TOP</a>
		</p>

    </div><!-- /container -->

    <div class="footer">
        <p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div>