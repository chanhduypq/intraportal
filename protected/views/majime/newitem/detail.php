



<script type="text/javascript">
	jQuery(function($) 
	{
		$("body").attr('id','majime');      
	});
</script>
<?php $attachment1=$model->attachment1;?>
<?php $attachment2=$model->attachment2;?>
<?php $attachment3=$model->attachment3;?>
<?php $attachment1_ext=FunctionCommon::getExtensionFile($model->attachment1);?>
<?php $attachment2_ext=FunctionCommon::getExtensionFile($model->attachment2);?>
<?php $attachment3_ext=FunctionCommon::getExtensionFile($model->attachment3);?>
<div class="wrap majime secondary newitems">
    <div class="container">
        <div class="contents detail">
           <div class="mainBox detail">
            	<div class="pageTtl">
				<h2>新商品情報 - 詳細</h2>
                <span>
				<?php if(!empty(Yii::app()->request->cookies['page'])): ?>	
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/majimenewitem/index?page=<?php echo Yii::app()->request->cookies['page']?>" class="btn btn-important">
						<i class="icon-chevron-left icon-white"></i> 一覧に戻る
					</a>
				<?php else : ?>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/majimenewitem" class="btn btn-important">
						<i class="icon-chevron-left icon-white"></i> 一覧に戻る
					</a>
				<?php endif; ?>
				</span>
                </div>
                <div class="box">
					<?php if($model != null): ?>	
						<div class="postsDate">
								<i class="icon-pencil"></i> 
									投稿日時：
								<span class="date">
									<?php echo FunctionCommon::formatDate($model->created_date); ?>
								</span>
								<span class="time">
									<?php echo FunctionCommon::formatTime($model->created_date); ?>
								</span>
						</div>
						<div class="detailTtl">
							<h3 class="ttl">
								<?php echo htmlspecialchars($model->title);?>
							</h3>
							<p class="area">
								<?php 
									$arrUser = FunctionCommon::getInforUser($model->contributor_id);
									if(isset($arrUser)){ echo $arrUser; }
								?>
							</p>
						</div>
						<p class="cnt-box">
							<?php echo nl2br(FunctionCommon::url_henkan($model->content));?>
						</p>
					<div class="photo">	
						<div class="imgbox">                            
							<?php if(!empty($attachment1)): ?>
								<?php echo FunctionCommon::echoOldFile($attachment1_ext, 1, $model,"majimenewitem",$this->assetsBase);?>
							<?php endif; ?>
						</div>
						<div class="imgbox">
							<?php if(!empty($attachment2)): ?>
								<?php echo FunctionCommon::echoOldFile($attachment2_ext, 2, $model,"majimenewitem",$this->assetsBase);?>
							<?php endif; ?>
						</div>
						<div class="imgbox">
							<?php if(!empty($attachment3)): ?>
								<?php echo FunctionCommon::echoOldFile($attachment3_ext, 3, $model,"Majimenewitem",$this->assetsBase);?>
							<?php endif; ?>
						</div>
					 </div> 			
					<?php endif; ?>
                </div><!-- /box -->
            </div><!-- /mainBox -->
            
            
        </div><!-- /contents -->
        <p id="page-top">
			<a href="#wrap">PAGE TOP</a>
		</p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div><!-- /wrap -->
