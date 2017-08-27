<link href="<?php echo $this->assetsBase;?>/css/asobi/css/zebra_dialog.css" rel="stylesheet" type="text/css">
<link href="<?php echo $this->assetsBase; ?>/css/majime/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<link href="<?php echo $this->assetsBase; ?>/css/majime/css/profile.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/js/lib/zebra_dialog.js"></script>
<script type='text/javascript' src='https://maps-api-ssl.google.com/maps/api/js?sensor=false&language=ja'></script>
<link href="<?php echo $this->assetsBase;?>/css/asobi/css/jquery-ui.css" rel="stylesheet" type="text/css">
<script src="<?php echo $this->assetsBase; ?>/js/lib/jquery-ui.js"></script>
<style>
    a.a_base{width:253px !important; height:195px !important;}

</style>
<div class="wrap single member">

    <div class="container">
        <div class="contents detail">
        	
            <div class="mainBox">
            	 <?php
				$units = Yii::app()->db->createCommand()
				->select(array(
					'unit.id',
					'unit.unit_name',
					'unit.branch_id',
					'branch.branch_name',
					'base.company_name'
						)
				)
				->from('unit')
				->join('branch', 'branch.id=unit.branch_id')
				->join('base', 'base.id=branch.base_id')
				->where("unit.id='".$_GET['id_unit']."' and unit.active_flag=1 and branch.active_flag=1")
				->queryRow();
				?>
               
            	<div class="pageTtl"><h1><?php echo $units['company_name']."&#12288;".$units['branch_name']."&#12288;".$units['unit_name']?></h1>
                <span><a href="<?php echo Yii::app()->request->baseUrl; ?>/majimemember/" class="btn btn-important"><i class="icon-chevron-left icon-white"></i> エリア選択に戻る</a></span></div>
                <div class="box">
                    <div class="baseDetailBox">
                        <div class="textBox boxL mt10 clearfix">
                            <?php  
							   $user=Yii::app()->db->createCommand()
								   ->select('*')
								   ->from('user')
								   ->join('post','
								   (post.id = user.position1 and user.division1 ='.$unit_item['id'].' and user.position1 is not null ) or 
								   (post.id = user.position2 and user.division2 ='.$unit_item['id'].' and user.position2 is not null) or 
								   (post.id = user.position3 and user.division3 ='.$unit_item['id'].' and user.position3 is not null) or 
								   (post.id = user.position4 and user.division4 ='.$unit_item['id'].' and user.position4 is not null)')
							       ->order("post.display_order ASC, user.employee_number ASC")
                                                                
								   ->queryAll();
									
								foreach($user as $user_item){   
											
							 ?>
                            <div class="profileBox">
                                <div class="face">
                                    <a style="cursor:pointer;" id="popup_user_<?php echo $user_item['id']?>" class="a_popup">
                                 <?php 
								 if(!is_null($user_item['photo']) && !empty($user_item['photo']) && $user_item['photo_public_flag']=='1'): ?>	
                                 		<?php $attachment1_ext=FunctionCommon::getExtensionFile($user_item['photo']);?> 
                                        <?php Upload_file_common::echoPhotomember($attachment1_ext,$user_item['photo'],1);?>
								 <?php else: ?>
									<img src="<?php echo  $this->assetsBase; ?>/css/common/img/img_dummyman.jpg">
								 <?php endif; ?>  
                                </a>
                                </div>
                                        <!-- popup id user-->
                                        <div class="popup_user" id="div_popup_user_<?php echo $user_item['id']?>" style="display:none;"> 
                                        
                                        <div class="wrap single department">
                                        
                                            <div class="container">
                                                <div class="contents detail">
                                                    <div class="mainBox">
                                                            <div class="pageTtl"><h1>社員プロフィール</h1>
                                                                <span style="display: none;"><a href="#" class="btn btn-important"><i class="icon-remove icon-white"></i> とじる</a></span></div>
                                                
                                                            <div class="box">
                                            
                                                            <div class="baseDetailBox">
                                                            
                                                            <div class="prf_all">
                                                            <div class="prf_left">
                                                            
                                                             
                                                             <?php 
                                                             if(!is_null($user_item['photo']) && !empty($user_item['photo']) && $user_item['photo_public_flag']=='1'){
                                                                $file_name=Upload_file_common::getFileNameFromValueInDatabase($user_item['photo']);
                                                                $ext = strtolower(Upload_file_common::getFileNameExtension($file_name));
                                                                Upload_file_common::echoEyeCatch_popMemberdetail($ext, $user_item['photo'],'');	
                                                                
                                                             } else{ ?>
                                                                <img style="width:252px;" src="<?php echo  $this->assetsBase; ?>/css/common/img/img_dummyman.jpg">
                                                             <?php } ?>  
                                                            
                                                            <br /><?php echo htmlspecialchars($user_item['lastname'].$user_item['firstname'])?>（<?php echo htmlspecialchars($user_item['lastname_kana'].$user_item['firstname_kana'])?>） 
                                                            </div>
                                                            <div class="prf_right">
                                                            <table>
                                                                <tr><th colspan="2"><?php echo FunctionCommon::url_henkan($user_item['catchphrase'])?></th></tr>
                                                            <tr><th>入社年</th><td><?php echo htmlspecialchars($user_item['joindate'])?>年</td></tr>
                                                            <tr><th>部署</th><td>
                                                                
                                                                 <?php echo htmlspecialchars($units['company_name']);?>
                                                            <br />
                                                            <span class="prf01">
                                                                <?php echo htmlspecialchars($units['branch_name']);?>
                                                            </span>　
                                                            <span class="prf02">
                                                                <?php echo htmlspecialchars($units['unit_name']);?>
                                                            </span>　
                                                            <span class="prf03">
                                                                <?php 
                                                                        if($_GET['id_unit']==$user_item['division1']){
                                                                              $position = $user_item['position1'];
                                                                        }
                                                                        else if($_GET['id_unit']==$user_item['division2']){
                                                                              $position = $user_item['position2'];
                                                                        }
                                                                        else if($_GET['id_unit']==$user_item['division3']){
                                                                              $position = $user_item['position3'];
                                                                        }
                                                                        else if($_GET['id_unit']==$user_item['division4']){
                                                                              $position = $user_item['position4']; }
                                                                    
                                                                        $post  = Yii::app()->db->createCommand("select post_name from post where id ='".$position."'")->queryRow();	
                                                                        echo htmlspecialchars($post['post_name']);	
                                                                 ?>
                                                            </span>
                                                            </td></tr>
                                                            <tr><th>コメント</th><td><p style="overflow-y: scroll;height: 260px;"><?php echo nl2br(FunctionCommon::url_henkan($user_item['comment']));?></p></td></tr>
                                                            </table>
                                                            </div>
                                                            <br class="prf_clear" />
                                                            
                                                            </div>
                                                                                
                                                            </div><!-- /baseDetailBox -->      
                                                        </div><!-- /box -->
                                                    </div><!-- /mainBox -->     
                                                            
                                          </div><!-- /contents -->
                                        
                                        </div><!-- /container -->
                                            
                                        </div><!-- /wrap -->                                               
                                        </div>
                                        <!-- end popup id user-->
                                <span class="userName"><?php echo htmlspecialchars($user_item['lastname'].$user_item['firstname'])?></span>
                                <dl>
                                    <?php 
										 	if($_GET['id_unit']==$user_item['division1']){
												  $position = $user_item['position1'];
											}
											else if($_GET['id_unit']==$user_item['division2']){
												  $position = $user_item['position2'];
											}
											else if($_GET['id_unit']==$user_item['division3']){
												  $position = $user_item['position3'];
											}
											else if($_GET['id_unit']==$user_item['division4']){
												  $position = $user_item['position4']; }
										
											$post  = Yii::app()->db->createCommand("select post_name from post where id ='".$position."'")->queryRow();	
											if(!empty($post)){
												echo "<dt>役職：</dt><dd>";
												echo htmlspecialchars($post['post_name']);	
												echo "</dd>";
												}	
									 ?>
                                    <dt>入社年：</dt><dd><?php echo $user_item['joindate'];?>年</dd>
                                </dl>
                            </div>
                            <?php }//}?>
                            <!--position null-->
                            <?php 
							   $user2 = Yii::app()->db->createCommand()
								   ->select('*')
								   ->from('user')
								   ->where('
										   (division1 ='.$unit_item['id'].' and position1 is null) or 
										   (division2 ='.$unit_item['id'].' and position2 is null) or 
										   (division3 ='.$unit_item['id'].' and position3 is null) or 
										   (division4 ='.$unit_item['id'].' and position4 is null)
										  ')
								   ->order("position1 ASC, position2 ASC, position3 ASC, position4 ASC,  user.employee_number ASC")	  
								   ->queryAll();
									
								foreach($user2 as $user_item){   
											
							 ?>
                            <div class="profileBox">
                                <div class="face">
                                    <a style="cursor:pointer;" id="popup_user_<?php echo $user_item['id']?>" class="a_popup">
                                 <?php 
								 if(!is_null($user_item['photo']) && !empty($user_item['photo']) && $user_item['photo_public_flag']=='1'): ?>	
                                 		<?php $attachment1_ext=FunctionCommon::getExtensionFile($user_item['photo']);?> 
                                        <?php Upload_file_common::echoPhotomember($attachment1_ext,$user_item['photo'],1);?>
								 <?php else: ?>
									<img src="<?php echo  $this->assetsBase; ?>/css/common/img/img_dummyman.jpg">
								 <?php endif; ?>  
                                </a>
                                </div>
                                        <!-- popup id user-->
                                        <div class="popup_user" id="div_popup_user_<?php echo $user_item['id']?>" style="display:none;"> 
                                        
                                        <div class="wrap single department">
                                        
                                            <div class="container">
                                                <div class="contents detail">
                                                    <div class="mainBox">
                                                            <div class="pageTtl"><h1>社員プロフィール</h1>
                                                                <span style="display: none;"><a href="#" class="btn btn-important"><i class="icon-remove icon-white"></i> とじる</a></span></div>
                                                
                                                            <div class="box">
                                            
                                                            <div class="baseDetailBox">
                                                            
                                                            <div class="prf_all">
                                                            <div class="prf_left">
                                                            
                                                             
                                                             <?php 
                                                             if(!is_null($user_item['photo']) && !empty($user_item['photo']) && $user_item['photo_public_flag']=='1'){
                                                                $file_name=Upload_file_common::getFileNameFromValueInDatabase($user_item['photo']);
                                                                $ext = strtolower(Upload_file_common::getFileNameExtension($file_name));
                                                                Upload_file_common::echoEyeCatch_popMemberdetail($ext, $user_item['photo'],'');	
                                                                
                                                             } else{ ?>
                                                                <img style="width:252px;" src="<?php echo  $this->assetsBase; ?>/css/common/img/img_dummyman.jpg">
                                                             <?php } ?>  
                                                            
                                                            <br /><?php echo htmlspecialchars($user_item['lastname'].$user_item['firstname'])?>（<?php echo htmlspecialchars($user_item['lastname_kana'].$user_item['firstname_kana'])?>） 
                                                            </div>
                                                            <div class="prf_right">
                                                            <table>
                                                                <tr><th colspan="2"><?php echo FunctionCommon::url_henkan($user_item['catchphrase'])?></th></tr>
                                                            <tr><th>入社年</th><td><?php echo htmlspecialchars($user_item['joindate'])?>年</td></tr>
                                                            <tr><th>部署</th><td>
                                                                
                                                                 <?php echo htmlspecialchars($units['company_name']);?>
                                                            <br />
                                                            <span class="prf01">
                                                                <?php echo htmlspecialchars($units['branch_name']);?>
                                                            </span>　
                                                            <span class="prf02">
                                                                <?php echo htmlspecialchars($units['unit_name']);?>
                                                            </span>　
                                                            <span class="prf03">
                                                                <?php 
                                                                        if($_GET['id_unit']==$user_item['division1']){
                                                                              $position = $user_item['position1'];
                                                                        }
                                                                        else if($_GET['id_unit']==$user_item['division2']){
                                                                              $position = $user_item['position2'];
                                                                        }
                                                                        else if($_GET['id_unit']==$user_item['division3']){
                                                                              $position = $user_item['position3'];
                                                                        }
                                                                        else if($_GET['id_unit']==$user_item['division4']){
                                                                              $position = $user_item['position4']; }
                                                                    
                                                                        $post  = Yii::app()->db->createCommand("select post_name from post where id ='".$position."'")->queryRow();	
                                                                        echo htmlspecialchars($post['post_name']);	
                                                                 ?>
                                                            </span>
                                                            </td></tr>
                                                            <tr><th>コメント</th><td><p style="overflow-y: scroll;height: 260px;"><?php echo nl2br(FunctionCommon::url_henkan($user_item['comment']));?></p></td></tr>
                                                            </table>
                                                            </div>
                                                            <br class="prf_clear" />
                                                            
                                                            </div>
                                                                                
                                                            </div><!-- /baseDetailBox -->      
                                                        </div><!-- /box -->
                                                    </div><!-- /mainBox -->     
                                                            
                                          </div><!-- /contents -->
                                        
                                        </div><!-- /container -->
                                            
                                        </div><!-- /wrap -->                                               
                                        </div>
                                        <!-- end popup id user-->
                                <span class="userName"><?php echo htmlspecialchars($user_item['lastname'].$user_item['firstname'])?></span>
                                <dl>
                                    <?php 
										 	if($_GET['id_unit']==$user_item['division1']){
												  $position = $user_item['position1'];
											}
											else if($_GET['id_unit']==$user_item['division2']){
												  $position = $user_item['position2'];
											}
											else if($_GET['id_unit']==$user_item['division3']){
												  $position = $user_item['position3'];
											}
											else if($_GET['id_unit']==$user_item['division4']){
												  $position = $user_item['position4']; }
										
											$post  = Yii::app()->db->createCommand("select post_name from post where id ='".$position."'")->queryRow();	
											if(!empty($post)){
												echo "<dt>役職：</dt><dd>";
												echo htmlspecialchars($post['post_name']);	
												echo "</dd>";
												}	
									 ?>
                                    <dt>入社年：</dt><dd><?php echo $user_item['joindate'];?>年</dd>
                                </dl>
                            </div>
                            <?php }//}?>
                        </div><!-- /boxL -->
                        
                        <div class="textBox boxR">
                            <h2>事業所Data</h2>
                            <?php
                            $office=Yii::app()->db->createCommand()
								   ->select('photo, zipcode, address,googlemap')
								   ->from('office')
								   ->where("id ='".$unit_item['office_id']."'")
								   ->queryRow();
							?>
                          
                            <?php if(!is_null($office)): ?>
								<?php if(!is_null($office['photo']) || !empty($office['photo'])): ?>	
                                	
                                <div class="building_photo">
                                	    <style>
											a.a_base{float:none !important;}	
											img.img_base{ position:relative !important; float:none !important;}
									    </style>	
											<?php
												$file_name=Upload_file_common::getFileNameFromValueInDatabase($office['photo']);
												$ext = strtolower(Upload_file_common::getFileNameExtension($file_name));
												Upload_file_common::echoEyeCatch($ext, $office['photo'],'');											
											?>
                                    <p><span>家屋写真</span></p>
                                </div>
                            <?php endif; ?>  
                            <dl>
                                <dt>住所：</dt>
                                <dd>
                                <span class="zipcode">〒<?php echo (!empty($office['zipcode']) ? $office['zipcode'] : '&nbsp;')?></span>
                                <p class="adress"><?php echo (!empty($office['address']) ? $office['address'] : '&nbsp;')?></p>
                                </dd>
                            </dl>
                            <dl>
                                <dt>TEL：</dt>
                                <dd><span class="phone_nmb"><?php echo $unit_item['tel_number'];?></span></dd>
                            </dl>
                            <?php endif; ?>  

                            
                            <div class="base-news">
                                <h2 class="mt20">部署紹介</h2>
                                <div>
                                    <h3 class="subttl">
									<?php echo $units['company_name']."&nbsp;".$units['branch_name']."&nbsp;".$units['unit_name']?>
									</h3>
                                    <p>
                                    <span>
                                    	<?php
										
										 if(!empty($unit_item['attachment1'])):?>	
											<?php $attachment1_ext=FunctionCommon::getExtensionFile($unit_item['attachment1']);?>
                                            	
												<?php if(in_array($attachment1_ext,Constants::$zipExtention)){?> 
												<a href="<?php echo Yii::app()->request->baseUrl.$unit_item['attachment1'];?>">
													<span class="imgBox">
														<img src="<?php echo $this->assetsBase; ?>/css/common/img/img_zip.gif">
													</span>	
												</a>
											
												<?php }else if(in_array($attachment1_ext,Constants::$excelExtention)){?> 
												<a href="<?php echo Yii::app()->request->baseUrl.$unit_item['attachment1']; ?>">
													<span class="imgBox">
														<img src="<?php echo $this->assetsBase; ?>/css/common/img/img_excel.gif">
													</span>	
												</a>
												
												<?php }else if(in_array($attachment1_ext,Constants::$wordExtention)){?> 
												<a href="<?php echo Yii::app()->request->baseUrl.$unit_item['attachment1']; ?>">
													<span class="imgBox">
													<img src="<?php echo $this->assetsBase; ?>/css/common/img/img_word.gif">
													</span>	
												</a>
												
												<?php }else if(in_array($attachment1_ext,Constants::$powerpointExtention)){?> 
												<a href="<?php echo Yii::app()->request->baseUrl.$unit_item['attachment1']; ?>">
													<span class="imgBox">
														<img src="<?php echo $this->assetsBase; ?>/css/common/img/img_ppt.gif">
													</span>	
												</a>
												
                                                <?php }else if(in_array($attachment1_ext,Constants::$pdfExtention)){?> 
												<a href="<?php echo Yii::app()->request->baseUrl.$unit_item['attachment1']; ?>">
													<span class="imgBox">
													<img src="<?php echo $this->assetsBase; ?>/css/common/img/img_pdf.gif">
													</span>	
												</a>
												<?php }else{?>
													<span class="imgBox">
													<?php Upload_file_common::echoPhotomember($attachment1_ext,$unit_item['attachment1'],2);?>
                                                    </span>
												<?php } ?>	
										<?php endif;?>
										<?php if(!empty($unit_item['attachment2'])):?>	
											<?php $attachment2_ext=FunctionCommon::getExtensionFile($unit_item['attachment2']);?>
                                                
												<?php if(in_array($attachment2_ext,Constants::$zipExtention)){?> 
												<a href="<?php echo Yii::app()->request->baseUrl.$unit_item['attachment2'];?>">
													<span class="imgBox">
														<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/common/img/img_zip.gif">
													</span>	
												</a>
												
												<?php } else if(in_array($attachment2_ext,Constants::$excelExtention)){?> 
												<a href="<?php echo Yii::app()->request->baseUrl.$unit_item['attachment2']; ?>">
													<span class="imgBox">
														<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/common/img/img_excel.gif">
													</span>	
												</a>
												
												<?php } else if(in_array($attachment2_ext,Constants::$wordExtention)){?> 
												<a href="<?php echo Yii::app()->request->baseUrl.$unit_item['attachment2']; ?>">
													<span class="imgBox">
														<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/common/img/img_word.gif">
													</span>	
												</a>
												
												<?php } else if(in_array($attachment2_ext,Constants::$powerpointExtention)){?> 
												<a href="<?php echo Yii::app()->request->baseUrl.$unit_item['attachment2']; ?>">
													<span class="imgBox">
														<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/common/img/img_ppt.gif">
													</span>	
												</a>
													
                                                <?php } else if(in_array($attachment2_ext,Constants::$pdfExtention)){?> 
												<a href="<?php echo Yii::app()->request->baseUrl.$unit_item['attachment2']; ?>">
													<span class="imgBox">
													<img src="<?php echo $this->assetsBase; ?>/css/common/img/img_pdf.gif">
													</span>	
												</a>
												<?php }else { ?>
                                                <span class="imgBox">
												<?php Upload_file_common::echoPhotomember($attachment2_ext,$unit_item['attachment2'],2);?>
                                                </span>
                                                <?php }?>	
										<?php endif;?>
										<?php if(!empty($unit_item['attachment3'])):?>	
											<?php $attachment3_ext=FunctionCommon::getExtensionFile($unit_item['attachment3']);?>
                                                
												<?php if(in_array($attachment3_ext,Constants::$zipExtention)){?> 
												<a href="<?php echo Yii::app()->request->baseUrl.$unit_item['attachment3'];?>">
													<span class="imgBox">
														<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/common/img/img_zip.gif">
													</span>	
												</a>
												
												<?php }else if(in_array($attachment3_ext,Constants::$excelExtention)){?> 
												<a href="<?php echo Yii::app()->request->baseUrl.$unit_item['attachment3']; ?>">
													<span class="imgBox">
														<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/common/img/img_excel.gif">
													</span>	
												</a>
												
												<?php } else if(in_array($attachment3_ext,Constants::$wordExtention)){?> 
												<a href="<?php echo Yii::app()->request->baseUrl.$unit_item['attachment3']; ?>">
													<span class="imgBox">
														<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/common/img/img_word.gif">
													</span>	
												</a>
												
												<?php } else if(in_array($attachment3_ext,Constants::$powerpointExtention)){?> 
												<a href="<?php echo Yii::app()->request->baseUrl.$unit_item['attachment3']; ?>">
													<span class="imgBox">
														<img src="<?php echo Yii::app()->request->baseUrl; ?>/css/common/img/img_ppt.gif">
													</span>	
												</a>
													
                                                <?php } else if(in_array($attachment3_ext,Constants::$pdfExtention)){?> 
												<a href="<?php echo Yii::app()->request->baseUrl.$unit_item['attachment3']; ?>">
													<span class="imgBox">
													<img src="<?php echo $this->assetsBase; ?>/css/common/img/img_pdf.gif">
													</span>	
												</a>
												<?php }else {?>
                                                 <span class="imgBox">
												 <?php Upload_file_common::echoPhotomember($attachment3_ext,$unit_item['attachment3'],2);?>
                                                 </span>
                                                 <?php }?>	
										<?php endif;?>
                                      
                                    </span>
                                   <?php echo nl2br(FunctionCommon::url_henkan($unit_item['catchphrase'])).'</br>';?>
								   <?php echo nl2br(FunctionCommon::url_henkan($unit_item['introduction'])) ;?></p>
                                </div>
                            </div><!-- /box - base-news -->
                            
                        </div><!-- /boxR -->
                    </div><!-- /baseDetailBox -->              
              </div><!-- /box -->
              
                <div class="box">
                <h2 class="mt20">地図</h2>
                             <div class="building_map">
                                <?php echo $office['googlemap'];?>
                            </div>
              </div><!-- /box -->            
              
         </div><!-- /mainBox -->
            
            
  </div><!-- /contents -->

</div><!-- /container -->
    
</div><!-- /wrap -->
<script language="javascript">
  jQuery(function($) 
	{ 
            $('img#not_download').contextmenu( function() {
            return false;
        });
        $("body").delegate("img#not_download","contextmenu",function(){
          return false;
        });
	$("a.a_popup").click(function (){                        
            html=$(this).parent().next().html();
            msg='<div class="popup_user" style="height:500px;">'+html+'</div>';
            $.Zebra_Dialog(msg, {                                
                                         'buttons':[' とじる'],
                                         width: 1000
                                       
                                     });                          
            
            
           
        });

	});
</script>