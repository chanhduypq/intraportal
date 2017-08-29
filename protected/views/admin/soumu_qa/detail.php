




<?php $attachment1=$model->attachment1;?>
<?php $attachment2=$model->attachment2;?>
<?php $attachment3=$model->attachment3;?>
<?php $attachment1_ext=FunctionCommon::getExtensionFile($model->attachment1);?>
<?php $attachment2_ext=FunctionCommon::getExtensionFile($model->attachment2);?>
<?php $attachment3_ext=FunctionCommon::getExtensionFile($model->attachment3);?>

<div class="wrap admin secondary soumu_qa" id="admin">

    <div class="container">
        <div class="contents detail">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>教えて総務さん！FAQ - 詳細</h2>
                <span>
                    <a href="<?php echo Yii::app()->baseUrl;?>/adminsoumu_qa/index" class="btn btn-important">
                      <i class="icon-chevron-left icon-white"></i>一覧に戻る
                    </a>
                </span>
                <span>
                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminsoumu_qa/edit/?id=<?php echo $model->id;?>" class="btn btn-work">
                      <i class="icon-pencil icon-white"></i>修正
                    </a>
                </span>
                </div>
                <div class="box">
                	<div class="postsDate">
                        <i class="icon-pencil"></i> 
                        投稿日時：
                        <span class="date"><?php echo FunctionCommon::formatDate($model->created_date); ?></span>
                        <span class="time"><?php echo FunctionCommon::formatTime($model->created_date); ?></span>
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
                    
                    <p class="cnt-box category">
                        <?php 
                            foreach ($category as $category_id) {
								if($model->category_id==$category_id['id']){
									echo htmlspecialchars($category_id['category_name']);
								}
							}
						?>
                    </p>

                    <p class="cnt-box">
                        <?php echo nl2br(FunctionCommon::url_henkan($model->content));?>
                    </p>
                    
					<div class="photo">
                        <div class="imgbox">                            
        				  <?php if(!empty($attachment1)): ?>
        						<?php FunctionCommon::echoOldFile($attachment1_ext, 1, $model,"adminsoumu_qa",$this->assetsBase);	 ?>
        				  <?php endif; ?>
        				</div>
        				<div class="imgbox">                            
        					<?php if(!empty($attachment2)): ?>
        						<?php FunctionCommon::echoOldFile($attachment2_ext, 2, $model,"adminsoumu_qa",$this->assetsBase);	 ?>
        					<?php endif; ?>
        				</div>
        				<div class="imgbox">                            
        					<?php if(!empty($attachment3)): ?>
        						<?php FunctionCommon::echoOldFile($attachment3_ext, 3, $model,"adminsoumu_qa",$this->assetsBase);	 ?>
        					<?php endif; ?>
        				</div>
                    </div>                   
                
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