
<link href="<?php echo $this->assetsBase; ?>/css/majime/css/bbs.css" rel="stylesheet" type="text/css"/>



<?php $attachment1=$model->attachment1;?>
<?php $attachment2=$model->attachment2;?>
<?php $attachment3=$model->attachment3;?>
<?php $attachment1_ext=FunctionCommon::getExtensionFile($model->attachment1);?>
<?php $attachment2_ext=FunctionCommon::getExtensionFile($model->attachment2);?>
<?php $attachment3_ext=FunctionCommon::getExtensionFile($model->attachment3);?>
<script type="text/javascript">   
	jQuery(function($)
	{     
		 $("body").attr('id','majime');        
	});
</script>			
<div class="wrap majime secondary bounty">

    <div class="container">
        <div class="contents detail">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
				<h2>懸賞金付き募集コンテンツ - 結果発表</h2>
				<span>
				<?php if(!empty(Yii::app()->request->cookies['page'])): ?>	
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/majimebounty/index?page=<?php echo Yii::app()->request->cookies['page']?>" class="btn btn-important">
						<i class="icon-chevron-left icon-white"></i> 一覧に戻る
					</a>
				<?php else : ?>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/majimebounty" class="btn btn-important">
						<i class="icon-chevron-left icon-white"></i> 一覧に戻る
					</a>
				<?php endif; ?>
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
                    <p class="cnt-box">
						<?php echo nl2br(FunctionCommon::url_henkan($model->content));?>	
					</p>
					<div class="photo">	
						<div class="imgbox">                            
							<?php if(!empty($attachment1)): ?>
							<?php echo FunctionCommon::echoOldFile($attachment1_ext, 1, $model,"majimebounty",$this->assetsBase);?>
							<?php endif; ?>
						</div>
						<div class="imgbox">
							<?php if(!empty($attachment2)): ?>
							<?php echo FunctionCommon::echoOldFile($attachment2_ext, 2, $model,"majimebounty",$this->assetsBase);?>
							<?php endif; ?>
						</div>
						<div class="imgbox">
							<?php if(!empty($attachment3)): ?>
							<?php echo FunctionCommon::echoOldFile($attachment3_ext, 3, $model,"majimebounty",$this->assetsBase);?>
							<?php endif; ?>
						</div>
					</div> 	
                    <div class="cnt-box">
					<table class="table topics">
					  <tr>
						<td class="td-mon">
							懸賞内容：<?php echo nl2br(htmlspecialchars($model->prize));?>	
						</td>
						<td class="td-ded">
							募集締め切り：<?php echo FunctionCommon::formatDate($model->deadline); ?>
						</td>
						<td class="td-pos">
							応募数：<?php echo Yii::app()->db->createCommand('SELECT COUNT(*) FROM bounty_apply WHERE bounty_id='.$model->id)->queryScalar();?>
						</td>
					  </tr>
					</table>
				  </div>
				  <?php if(!is_null($bounty_applies)): ?>
				   <?php foreach($bounty_applies as $item): ?>
					<?php if(!empty($item->open_type) &&!empty($item->adopted_comment)): ?>
					  <div>
						<?php if($item->open_type==1):?>
						  <div class="detailTtl">
								<h3 class="ttl">
									<i class="icon-flag"></i>採用応募テキスト
								</h3>
								 <p class="area">
								  <?php $criteria = new CDbCriteria;?>
								  <?php $criteria->select = "*";?>
								  <?php $criteria->condition="employee_number=$item->applicant_id";?>
								  <?php $arrUser = User::model()->find($criteria);?>
								  <?php $branchName = FunctionCommon::getInforBase($arrUser['id']); ?>
								  <?php if(!empty($branchName)): ?>
									<span class="city">
										<?php echo $branchName?>&nbsp;:&nbsp;   
									</span>
									<?php endif; ?>	
									<?php if(isset($arrUser)): ?>
									<span class="name">
										<?php echo (!empty($arrUser['lastname']) ? $arrUser['lastname'] : null)?>
										&nbsp;
										<?php echo (!empty($arrUser['firstname']) ? $arrUser['firstname'] : null)?>
									</span>
									<?php endif; ?>
								</p>
							</div>
							<p class="cnt-box">
								<?php echo nl2br(htmlspecialchars($item->applied_content)); ?>		
							</p>
						
							<div class="photo">
								<div class="imgbox">
									<?php $attachbounty=$item->attachment1;?>
									<?php $attachabountyapp_ext=FunctionCommon::getExtensionFile($item->attachment1);?>
									<?php if(!empty($attachabountyapp_ext)): ?>
										<?php  FunctionCommon::echoOldFile($attachabountyapp_ext, 5, $item,"majimebounty",$this->assetsBase);?>
									<?php endif; ?>
								</div>
							</div>
							<div class="detailTtl">
								<h3 class="ttl">
									<i class="icon-gift"></i>採用コメント
								</h3>
							</div>
							<p class="cnt-box">
								<?php echo nl2br(htmlspecialchars($item->adopted_comment)); ?>		
							</p>
							<?php endif; ?>
							<?php if($item->open_type==2):?>
							 <div class="detailTtl">
								<h3 class="ttl">
									<i class="icon-flag"></i>採用応募テキスト
								</h3>
								<?php if($item->applicant_id==FunctionCommon::getEmplNum()):?>
								 <p class="area">
								  <?php $criteria = new CDbCriteria;?>
								  <?php $criteria->select = "*";?>
								  <?php $criteria->condition="employee_number=$item->applicant_id";?>
								  <?php $arrUser = User::model()->find($criteria);?>
								  <?php $branchName = FunctionCommon::getInforBase($arrUser['id']); ?>
								  <?php if(!empty($branchName)): ?>
									<span class="city">
										<?php echo $branchName?>&nbsp;:&nbsp;   
									</span>
									<?php endif; ?>	
									<?php if(isset($arrUser)): ?>
									<span class="name">
										<?php echo (!empty($arrUser['lastname']) ? $arrUser['lastname'] : null)?>
										&nbsp;
										<?php echo (!empty($arrUser['firstname']) ? $arrUser['firstname'] : null)?>
									</span>
									<?php endif; ?>
								</p>
								<?php endif; ?>
							</div>
							<p class="cnt-box">
								<?php echo nl2br(htmlspecialchars($item->applied_content)); ?>		
							</p>
							<div class="photo">
								<div class="imgbox">
									<?php $attachbounty=$item->attachment1;?>
									<?php $attachabountyapp_ext=FunctionCommon::getExtensionFile($item->attachment1);?>
									<?php if(!empty($attachabountyapp_ext)): ?>
										<?php  FunctionCommon::echoOldFile($attachabountyapp_ext, 5, $item,"majimebounty",$this->assetsBase);?>
									<?php endif; ?>
								</div>
							</div>
							<div class="detailTtl">
								<h3 class="ttl">
									<i class="icon-gift"></i>採用コメント
								</h3>
							</div>
							<p class="cnt-box">
								<?php echo nl2br(htmlspecialchars($item->adopted_comment)); ?>		
							</p>
							<?php endif; ?>
							<?php if($item->open_type==3):?>
								<div class="detailTtl">
									<h3 class="ttl">
										<i class="icon-gift"></i>採用コメント
									</h3>
								</div>
								<p class="cnt-box">
									<?php echo nl2br(htmlspecialchars($item->adopted_comment)); ?>		
								</p>
							<?php endif; ?>
						</div><!-- /box -->
					<?php endif; ?>	
					<?php endforeach; ?>	
					<?php endif; ?>	
            </div><!-- /mainBox -->
            
            
        </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div><!-- /wrap -->
    
<script src="../../common/js/bootstrap.min.js"></script>
</body>
</html>
