<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>
<script type='text/javascript' src='https://maps-api-ssl.google.com/maps/api/js?sensor=false&language=ja'></script>
<script type="text/javascript">  
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
<div class="wrap admin secondary base" id="admin">

    <div class="container">
        <div class="contents detail">
        	
            <div class="mainBox">
            	<div class="pageTtl"><h2>部署管理 - 詳細</h2>
                <span>
                    <?php if(Yii::app()->request->cookies['page']!= "") 
                    {
                         $page = "index?page=".Yii::app()->request->cookies['page'];
					}
					else
					{
						$page ="";
					} ?>
                    <a href="<?php echo Yii::app()->baseUrl;?>/adminbase/unit/?base_id=<?php echo $_GET['base_id']; ?>" class="btn btn-important"><i class="icon-chevron-left icon-white"></i>部署一覧に戻る</a></span>
					<span>
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminbase/edit/?base_id=<?php echo $_GET['base_id']; ?>&id=<?php echo $model->id; ?>" class="btn btn-work">
						<i class="icon-pencil icon-white"></i> 修正
						</a>
					</span>
				</div>
                <div class="box">
                
                <p class="descriptionTxt">部署&amp;メンバー紹介ページに反映されます。</p>
                
                    <div class="cnt-box">
                        <div class="baseDetailBox">
                            <div class="field attachements">
                                <div class="title">ニューギン 部署Data</div>
							</div>
                            <div class="textBox boxL mt15 clearfix">
                            	 <div class="field branch">
                                    <div class="title">部門&nbsp;</div>
                                    <div class="data">
                                    <?php
									 foreach ($branch as $branch_name){
									   if($model->branch_id==$branch_name['id']){
										   echo htmlspecialchars($branch_name['branch_name']);
										   }
									}
									?>
                                    </div>
                                </div>
                                
                                <div class="field unitName">
                                    <div class="title">部署名&nbsp;</div>
                                    <div class="data"><?php echo htmlspecialchars($model->unit_name);?></div>
                                </div>
                              
                                <div class="field mail">
                                    <div class="title">連絡先メールアドレス&nbsp;</div>
                                    <div class="data"><?php echo htmlspecialchars($model->mailaddr); ?></div>
                                </div>
                                <div class="field mail">
                                    <div class="title">電話番号&nbsp;</div>
                                    <div class="data"><?php echo htmlspecialchars($model->tel_number); ?></div>
                                </div>
                                
                                <div class="field zipCode">
                                    <div class="title">郵便番号&nbsp;</div>
                                    <div class="data">
									<?php
                                    foreach ($office as $office_name){
									   if($model->office_id==$office_name['id']){
									   echo "〒".htmlspecialchars($office_name['zipcode']);
										}
									}
									?>
									</div>
                                </div>
                                
                                <div class="field address">
                                    <div class="title">住所&nbsp;</div>
                                    <div class="data">
                                    <?php
                                    foreach ($office as $office_name){
									   if($model->office_id==$office_name['id']){
									   echo htmlspecialchars($office_name['address']);
										}
									}
									?>
                                    </div>
                                </div>
                                <?php
                                foreach ($office as $office_name){
									   if($model->office_id==$office_name['id']){
										   if(!empty($office_name['photo'])){
											   
								?>
                                 
                                <div class="field buildingphoto">
                                    <div class="title">家屋写真&nbsp;</div>
                                    <div class="data">
                                    <style>
                                        a.a_base{float:none !important;}	
                                        img.img_base{ position:relative !important; float:none !important;}
                                    </style>	
                    						<?php
											$file_name=Upload_file_common::getFileNameFromValueInDatabase($office_name['photo']);
											$ext = strtolower(Upload_file_common::getFileNameExtension($file_name));
											Upload_file_common::echoEyeCatch($ext, $office_name['photo'],'');
																						
											?>
                                    </div>
                                </div>
                                  <?php
								  	 		}
								  	    }
								   } 
								  ?>
                               <div class="field googlemap">
                                    <div class="title">MAP&nbsp;</div>
                                    <div class="data-wide">
                                        
                                
                                 <div id="map"><?php                                  
                                 $google_map=Yii::app()->db->createCommand("select googlemap from office where id=".$model->office_id)->queryScalar();
                                 if($google_map!=FALSE){
                                     echo $google_map;
                                 }
                                 ?> </div>
                                
                                    </div>
                         	   </div>
                            </div><!-- /boxL -->
                           
                        </div><!-- /baseDetailBox -->
					</div><!-- /cnt-box -->
                    
                <p class="descriptionTxt">拠点&amp;メンバー紹介ページと、マジメのポータルトップページの今週の部署紹介に反映されます。</p>
                
                        <div class="baseDetailBox">
                            <div class="textBox clearfix">
                                <?php 
                        if($model->cancel_random=='1'){?>

                         <div class="field introduceTtl">
                            <div class="title">自動選出除外&nbsp;</div>
                            <div class="data">
                                                                        <p>
                                                                            <input type="checkbox" checked="checked" disabled="disabled"/>&nbsp;今週の部署紹介による自動選出から除外する 
                                                                                
                                                                        </p>
                                                                </div>
                        </div>
                        <?php
                        }
                        ?>
                                <div class="field introduceTtl">
                                    <div class="title">紹介タイトル&nbsp;</div>
                                    <div class="data">
									<p>
										<?php echo nl2br(FunctionCommon::url_henkan($model->catchphrase));?>	
									</p>
								</div>
                                </div>
                                
                                <div class="field introduceTxt">
                                    <div class="title">紹介文&nbsp;</div>
                                    <div class="data">
										<?php echo nl2br(FunctionCommon::url_henkan($model->introduction));?>	
									</div>
                                </div>
                                
                                <?php                    
								$attachements = $this->beginWidget('ext.helpers.Form');
								$attachements->detail($model, 'adminbase',$this->assetsBase);                        
								$this->endWidget();
								?>    
                            </div>
                        </div><!-- /baseDetailBox -->
                
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