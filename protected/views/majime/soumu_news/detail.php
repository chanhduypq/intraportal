



<script type="text/javascript">
    jQuery(function($) {
        $("body").attr('id','majime');      
    });
</script>
<?php $attachment1=$model->attachment1;?>
<?php $attachment2=$model->attachment2;?>
<?php $attachment3=$model->attachment3;?>
<?php $attachment1_ext=FunctionCommon::getExtensionFile($model->attachment1);?>
<?php $attachment2_ext=FunctionCommon::getExtensionFile($model->attachment2);?>
<?php $attachment3_ext=FunctionCommon::getExtensionFile($model->attachment3);?>
<div class="wrap majime secondary  soumu_news">

    <div class="container">
        <div class="contents detail">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
				<h2>総務からのお知らせ</h2>
				<span>
						<?php if(!empty(Yii::app()->request->cookies['page'])): ?>	
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/majimesoumu_news/index?page=<?php echo Yii::app()->request->cookies['page']?>" class="btn btn-important">
								<i class="icon-chevron-left icon-white"></i> 一覧に戻る
							</a>
						<?php else : ?>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/majimesoumu_news/index" class="btn btn-important">
								<i class="icon-chevron-left icon-white"></i> 一覧に戻る
							</a>
						<?php endif; ?>
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
					<div class="photo">
                                <div class="imgbox">                            
                                          <?php 
                                           if(trim($attachment1)!="")
                                           {
												 FunctionCommon::echoOldFile($attachment1_ext, 1, $model,"majimesoumu_news",$this->assetsBase);	
                                           }
                                           ?>
                                </div>
                                <div class="imgbox">
                                         <?php 
                                           if(trim($attachment2)!="")
                                           {
												 FunctionCommon::echoOldFile($attachment2_ext, 2, $model,"majimesoumu_news",$this->assetsBase);
                                           }
                                           ?>
                                </div>
                                <div class="imgbox">
                                         <?php 
                                           if(trim($attachment3)!="")
                                           {
												 FunctionCommon::echoOldFile($attachment3_ext, 3, $model,"majimesoumu_news",$this->assetsBase);
                                               
                                           }
                                           ?>
                                </div>
                            </div>                    
                
                </div><!-- /box -->
            </div><!-- /mainBox -->
            
            
        </div><!-- /contents -->
        <p id="page-top" style="display: none;"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div>