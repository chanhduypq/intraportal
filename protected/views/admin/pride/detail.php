



<script language="javascript">
jQuery(function($) {        
			$("body").attr('id','admin');      
		});
</script>
<?php $attachment1=$model->attachment1;?>
<?php $attachment2=$model->attachment2;?>
<?php $attachment3=$model->attachment3;?>
<?php $attachment1_ext=FunctionCommon::getExtensionFile($model->attachment1);?>
<?php $attachment2_ext=FunctionCommon::getExtensionFile($model->attachment2);?>
<?php $attachment3_ext=FunctionCommon::getExtensionFile($model->attachment3);?>
<div class="wrap admin secondary pride">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>あそびにマジメ！？あそび自慢＆対決！ - 詳細</h2>
                <?php 
					if(Yii::app()->request->cookies['page']!= "") 
					{
						   $page = "index?page=".Yii::app()->request->cookies['page'];
							
					}else {$page ="";}
					?>
                <span><a href="<?php echo Yii::app()->request->baseUrl; ?>/adminpride/<?php echo $page?>" class="btn btn-important"><i class="icon-chevron-left icon-white"></i> 一覧に戻る</a></span>        
                <span><a href="<?php echo Yii::app()->request->baseUrl; ?>/adminpride/edit/?id=<?php echo $model->id; ?>" class="btn btn-work"><i class="icon-pencil icon-white"></i> 修正</a></span>
                </div>
                <div class="box">
                	<div class="postsDate"><i class="icon-pencil"></i> 投稿日時：<span class="date"><?php echo FunctionCommon::formatDate($model->created_date); ?></span><span class="time"><?php echo FunctionCommon::formatTime($model->created_date); ?></span></div>
                	<div class="detailTtl">
                    	<h3 class="ttl">
							<?php echo htmlspecialchars($model->title);?>
						</h3>
                        <!--<p class="area"><span class="city">名古屋店：</span><span class="name">山田　太郎</span></p>-->
                        <p class="area">
                       	    <?php 
								$arrUser = FunctionCommon::getInforUser($model->contributor_id);
								if(isset($arrUser)){ echo $arrUser; }
							?>
                        </p>
                    </div>
                    <span class="pride-icon pride-icon-prize0<?php echo $model->icon?>">icon0<?php echo $model->icon?></span>
                    <div class="evaluate">
                    	<?php
                        	 $i = 0; 
                                 $count=0;
							 $rating = 0;
							 $id = $model->id;
							 foreach ($pride_list_comments as $comment) {
								 if($id == $comment['pride_id']){ 
                                                                     if($comment['valuation']>0){
                                                                         $count++;
                                                                     }
								 $i = $i+1;
								 $rating = $comment['valuation']+ $rating;
								 } 
							 }
							if($i!=0){
								if($count>0){
                                                                    $average = $rating/$count;
                                                                }
                                                                else{
                                                                    $average='0';
                                                                    
                                                                }
								$average = substr($average, 0, 3);
							}
							else {$average=0;}
						?>
                        <p class="rating"> 現在の評価：
                            <?php
                            if($average!='0'){                                             
										?>
                                        (<?php echo $average?>)
                                        <?php
                                                   }
                                                   else{?>
                                        未評価
                                                       <?php
                                                       
                                                   }
                                                   ?>
                            
                        </p>
                        <p class="comment">コメント数:<?php echo $i;?></p>
                        <span class="clearfix"></span>
                    </div>
                    <p class="cnt-box">
						 <?php echo nl2br(FunctionCommon::url_henkan($model->content));?>
					</p>
                    
					<div class="photo">
                        <div class="imgbox">                            
                            	  <?php 
								   if(trim($attachment1)!="")
								   {	
										 FunctionCommon::echoOldFile($attachment1_ext, 1, $model,"adminpride",$this->assetsBase);
                                   }
                                   ?>
                        </div>
                        <div class="imgbox">
                           		 <?php 
								   if(trim($attachment2)!="")
								   {
								 		  FunctionCommon::echoOldFile($attachment2_ext, 2, $model,"adminpride",$this->assetsBase);	     
                                   }
                                   ?>
                        </div>
                        <div class="imgbox">
                           		 <?php 
								   if(trim($attachment3)!="")
								   {
								 		  FunctionCommon::echoOldFile($attachment3_ext, 3, $model,"adminpride",$this->assetsBase);	
                                   }
                                   ?>
                        </div>
                    </div>                   
                
                </div><!-- /box -->
                <div class="box">
					<h4 class="ttl">コメント履歴</h4>
					
					<ul class="comments">
                    	 <?php
							$i=1;	
							 foreach ($pride_list_comments as $comment) {
								 if($model->id ==$comment['pride_id'])
								 { 
						?>
						<li style="border-bottom: 1px #CCC dashed;padding-bottom: 10px;">
                                                    <span class="badge badge-inverse">
								<?php echo $i;?>
							</span>
							<p class="comment">
							<?php echo nl2br(FunctionCommon::url_henkan($comment['comment']));?>
			
							</p>
                                                        <br/>
                                                        <div class="rating">評価：
                                                            <?php
                            if($comment['valuation']!='0'){                                             
										?>
                                        (<?php echo $comment['valuation'];?>)
                                        <?php
                                                   }
                                                   else{?>
                                        未評価
                                                       <?php
                                                       
                                                   }
                                                   ?>
                                                            
                                                        </div>
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
								<div class="post-date">投稿日時：<?php echo FunctionCommon::formatDate($comment['created_date']); ?> <?php echo FunctionCommon::formatTime($comment['created_date']); ?></div>
							</div>
							<div class="btn-comment-remove row"> 
									<div class="offset7 span1">
                                         <a class="btn btn-warning span2" onclick="if(confirm('コメントを削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/adminpride/deleteidpridecomment/?id=<?php echo $model->id; ?>&id2=<?php echo $comment['id']; ?>';" style="width:111px; color:#ffffff; font-family:Helvetica Neue,Helvetica,Arial,sans-serif; text-decoration:none; cursor:pointer;">削除</a>
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