




<?php $attachment1=$model->attachment1;?>
<?php $attachment2=$model->attachment2;?>
<?php $attachment3=$model->attachment3;?>
<?php $attachment1_ext=FunctionCommon::getExtensionFile($model->attachment1);?>
<?php $attachment2_ext=FunctionCommon::getExtensionFile($model->attachment2);?>
<?php $attachment3_ext=FunctionCommon::getExtensionFile($model->attachment3);?>

<div class="wrap admin secondary rival">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>競合情報 - 詳細</h2>
                <span>
					<a href="<?php echo Yii::app()->baseUrl;?>/adminrival/index" class="btn btn-important">
					  <i class="icon-chevron-left icon-white"></i>一覧に戻る
					</a>
				</span>
                <span>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminrival/edit/?id=<?php echo $model->id;?>" class="btn btn-work">
					  <i class="icon-pencil icon-white"></i>修正
					</a>
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
								<?php FunctionCommon::echoOldFile($attachment1_ext, 1, $model,"adminrival",$this->assetsBase);	 ?>
						  <?php endif; ?>
						</div>
						<div class="imgbox">                            
							<?php if(!empty($attachment2)): ?>
								<?php FunctionCommon::echoOldFile($attachment2_ext, 2, $model,"adminrival",$this->assetsBase);	 ?>
							<?php endif; ?>
						</div>
						<div class="imgbox">                            
							<?php if(!empty($attachment3)): ?>
								<?php FunctionCommon::echoOldFile($attachment3_ext, 3, $model,"adminrival",$this->assetsBase);	 ?>
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
							 foreach ($rival_comments as $comment) {
								 if($model->id ==$comment['rival_id'])
								 { 
						?>
						<li style="border-bottom: 1px #CCC dashed;padding-bottom: 10px;margin-bottom: 20px;">
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
                                         <a class="btn btn-warning span2" onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/adminrival/deleteidrivalresponse/?id=<?php echo $model->id; ?>&id2=<?php echo $comment['id']; ?>';" style="width:111px; color:#ffffff; font-family:Helvetica Neue,Helvetica,Arial,sans-serif; text-decoration:none; cursor:pointer;">削除</a>
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