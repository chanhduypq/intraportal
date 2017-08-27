<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>
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
<div class="wrap admin secondary president_msg" >

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
				<h2>新井社長メッセージ - 詳細</h2>
                <?php 
					if(Yii::app()->request->cookies['page']!= "") 
					{
						   $page = "index?page=".Yii::app()->request->cookies['page'];
							
					}else {$page ="";}
					?>
                <span><a href="<?php echo Yii::app()->request->baseUrl; ?>/adminpresident_msg/<?php echo $page ?>" class="btn btn-important"><i class="icon-chevron-left icon-white"></i> 一覧に戻る</a></span>
                <span><a href="<?php echo Yii::app()->request->baseUrl; ?>/adminpresident_msg/edit/?id=<?php echo $model->id; ?>" class="btn btn-work"><i class="icon-pencil icon-white"></i> 修正</a></span>
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
                    
                    <p class="cnt-box">
						 <?php echo nl2br(FunctionCommon::url_henkan($model->content));?>
					</p>
                    
					<div class="photo">
                        <div class="imgbox">                            
                            	  <?php 
								   if(trim($attachment1)!="")
								   {
									     FunctionCommon::echoOldFile($attachment1_ext, 1, $model,"adminpresident_msg",$this->assetsBase);
                                   }
                                   ?>
                        </div>
                        <div class="imgbox">
                           		 <?php 
								   if(trim($attachment2)!="")
								   {
								 		  FunctionCommon::echoOldFile($attachment2_ext, 2, $model,"adminpresident_msg",$this->assetsBase);	   
                                       
                                   }
                                   ?>
                        </div>
                        <div class="imgbox">
                           		 <?php 
								   if(trim($attachment3)!="")
								   {
								 		   FunctionCommon::echoOldFile($attachment3_ext, 3, $model,"adminpresident_msg",$this->assetsBase);
                                       
                                   }
                                   ?>
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