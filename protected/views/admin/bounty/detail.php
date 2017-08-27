<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>

<?php $attachment1=$model->attachment1;?>
<?php $attachment2=$model->attachment2;?>
<?php $attachment3=$model->attachment3;?>
<?php $attachment1_ext=FunctionCommon::getExtensionFile($model->attachment1);?>
<?php $attachment2_ext=FunctionCommon::getExtensionFile($model->attachment2);?>
<?php $attachment3_ext=FunctionCommon::getExtensionFile($model->attachment3);?>
<div class="wrap admin secondary bounty">
    <div class="container">
        <div class="contents index">
        	<div class="mainBox detail">
            	<div class="pageTtl">
				<h2>懸賞金付き募集コンテンツ - 詳細</h2>
                <span>
					<a href="<?php echo Yii::app()->baseUrl;?>/adminbounty/" class="btn btn-important">
						<i class="icon-chevron-left icon-white"></i> 一覧に戻る
					</a>
				</span>
                <span>
					 <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminbounty/edit/?id=<?php echo $model->id;?>" class="btn btn-work">
						<i class="icon-pencil icon-white"></i> 修正
					</a>
				</span>
                </div>
                <div class="box">
                	<div class="postsDate">
						<i class="icon-pencil"></i>投稿日時：
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
                    
                    <div class="cnt-box">
                    	<p class="deadline">募集締め切り：<?php echo FunctionCommon::formatDate($model->deadline); ?>
							<?php if(strtotime($model->deadline) >= strtotime(FunctionCommon::getDateTimeSys())):?>
							<?php echo '<span class="label label-info">募集中</span>' ?>
							<?php endif; ?>
						</p>
                    	<p class="subscription">応募数：
							<?php $count= Yii::app()->db->createCommand('SELECT COUNT(*) FROM bounty_apply WHERE bounty_id='.$model->id)->queryScalar(); ?>
							<?php if( $count >0): ?>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminbountyapply/subscription/?id=<?php echo $model->id; ?>">
								<?php echo '('.$count.')'?>
							</a>
							<?php else : ?>
								<?php echo'('.$count.')'?>
							<?php endif ?>
						</p>
					</div>
			        <p class="cnt-box">
						<?php echo nl2br(FunctionCommon::url_henkan($model->content));?>	
					</p>
                    
					<div class="photo">
						<div class="imgbox">                            
							<?php if(!empty($attachment1)): ?>
							<?php FunctionCommon::echoOldFile($attachment1_ext, 1, $model,"adminbounty",$this->assetsBase);	 ?>
							<?php endif; ?>
						</div>
						<div class="imgbox">                            
							<?php if(!empty($attachment2)): ?>
							<?php FunctionCommon::echoOldFile($attachment2_ext, 2, $model,"adminbounty",$this->assetsBase);	 ?>
							<?php endif; ?>
						</div>
						<div class="imgbox">                            
							<?php if(!empty($attachment3)): ?>
							<?php FunctionCommon::echoOldFile($attachment3_ext, 3, $model,"adminbounty",$this->assetsBase);	 ?>
							<?php endif; ?>
						</div>
					</div>                      
                
                	<div class="detailTtl">
                    	<h3 class="ttl">懸賞内容</h3>
                    </div>
                    <p class="cnt-box">
						<?php echo nl2br(FunctionCommon::url_henkan($model->prize));?>	
					</p>
                    
                </div><!-- /box -->
            </div><!-- /mainBox -->
            
            <div class="sideBox">
            	<ul>
                	<li>
                    	 <?php $this->widget('MenuManager');?>
                         <?php $this->widget('AffairsManage');?>
                         <?php $this->widget('SystemManage');?>
                         <?php $this->widget('PostedByContentManage');?>
                    </li>
                </ul>
            </div><!-- /sideBox -->
            
  </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
</div>

</div><!-- /wrap -->