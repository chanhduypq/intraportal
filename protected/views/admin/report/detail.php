<link href="<?php echo $this->assetsBase; ?>/css/common/css/report.css" rel="stylesheet"  media="screen" />
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
<div class="wrap admin secondary report">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>リアルタイム社内報告 - 詳細</h2>
                <span>
					<?php if(Yii::app()->request->cookies['page'] >'1'): ?>	
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminreport/index?page=<?php echo Yii::app()->request->cookies['page']?>" class="btn btn-important">
							<i class="icon-chevron-left icon-white"></i> 一覧に戻る
						</a>
					<?php else : ?>
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminreport/index" class="btn btn-important">
							<i class="icon-chevron-left icon-white"></i> 一覧に戻る
						</a>
					<?php endif; ?>
				</span>
                <span>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminreport/edit/?id=<?php echo $model->id;?>" class="btn btn-work">
						<i class="icon-pencil icon-white"></i> 修正
					</a>
				</span>
                </div>
                <div class="box">
				<?php if(!is_null($model)): ?>	
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
						<?php switch($model->icon)
							{
								case 1:
								echo '<p class="ico help">Help</p>';
								break;
								case 2:
								echo '<p class="ico eigyou">営業</p>';
								break;
								case 3:
								echo '<p class="ico uwasa">うわさ</p>';
								break;
								case 4:
								echo '<p class="ico seizou">製造</p>';
								break;
								case 5:
								echo '<p class="ico gyousei">行政</p>';
								break;
								case 6:
								echo '<p class="ico hall">ホール</p>';
								break;
								case 7:
								echo '<p class="ico kaihatsu">開発</p>';
								break;
								case 8:
								echo '<p class="ico other">他</p>';
								break;
							} ?>
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
                   	<p class="counter">
						閲覧数：<?php echo $model->view_number; ?>
					</p>
                    <p class="cnt-box">
						 <?php echo nl2br(FunctionCommon::url_henkan($model->content));?>
					</p>
					<div class="photo">
						<div class="imgbox">                            
							<?php if(!empty($attachment1)): ?>
							<?php FunctionCommon::echoOldFile($attachment1_ext, 1, $model,"adminreport",$this->assetsBase);	 ?>
							<?php endif; ?>
						</div>
						<div class="imgbox">                            
							<?php if(!empty($attachment2)): ?>
							<?php FunctionCommon::echoOldFile($attachment2_ext, 2, $model,"adminreport",$this->assetsBase);	 ?>
							<?php endif; ?>
						</div>
						<div class="imgbox">                            
							<?php if(!empty($attachment3)): ?>
							<?php FunctionCommon::echoOldFile($attachment3_ext, 3, $model,"adminreport",$this->assetsBase);	 ?>
							<?php endif; ?>
						</div>
					</div>  	
                <?php endif; ?>	
                </div><!-- /box -->
                <div class="box">
					<h4 class="ttl">この議題についたコメント</h4>
					
					<ul class="comments">
                    	 <?php
							$i=1;	
							 foreach ($report_comments as $comment) {
								 if($model->id ==$comment['report_id'])
								 { 
						?>
						<li style="border-bottom: 1px #CCC dashed;padding-bottom: 10px;">
                                                    <span class="badge badge-inverse">
								<?php echo $i;?>
							</span>
							<p class="comment">
							<?php echo nl2br(FunctionCommon::url_henkan($comment['content']));?>
							
							</p>
                                                        <br/>
							<div class="commenter">
								<div class="name">
                                <?php
								 foreach ($user as $user_name) {
									 if($user_name['id']== $comment['contributor_id'])
									 {
										echo $user_name['lastname']." ".$user_name['firstname'];
									 }
								 }
								 ?>
                                </div>
                                                            <div class="unit">
                                         <?php echo FunctionCommon::getUnitBranchBaseUser($comment['contributor_id']);?>
                                     </div>
								<div class="post-date">回答日時：：<?php echo FunctionCommon::formatDate($comment['created_date']); ?>&nbsp;<?php echo FunctionCommon::formatTime($comment['created_date']); ?></div>
							</div>
							<div class="btn-comment-remove row"> 
									<div class="offset7 span1">
                                         <a class="btn btn-warning span2" onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/adminreport/deleteidreportresponse/?id=<?php echo $model->id; ?>&id2=<?php echo $comment['id']; ?>';" style="width:111px; color:#ffffff; font-family:Helvetica Neue,Helvetica,Arial,sans-serif; text-decoration:none; cursor:pointer;">削除</a>
									</div>
							</div>
						</li>
						<?php		
                                                $i++;	
									}
								 }
						?>
					</ul>
				</div>   
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
<script language="javascript">
$("body").attr('id','admin');     
</script>