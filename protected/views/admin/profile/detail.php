<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/admin/css/user.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto_not_download_img.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>
<script type="text/javascript">
    jQuery(function($) {        
        $("body").attr('id','admin');  
        $('img#not_download').contextmenu( function() {
            return false;
        });
        $("body").delegate("img#fullResImage","contextmenu",function(){
          return false;
        });
    });
</script>
<div class="wrap admin secondary user">

    <div class="container">
        <div class="contents detail">
        	
            <div class="mainBox">
            	<div class="pageTtl"><h2>プロフィール - 詳細</h2>                
                <span>
               <?php
				if(Yii::app()->request->cookies['passwd']=='7581'){
				?>	
				<script type='text/javascript'>
				 $(document).ready(function(){
					$("a#edit_profile").attr("href", "<?php echo Yii::app()->baseUrl;?>/adminprofile/edit/?id=<?php echo Yii::app()->request->cookies['id'];?>");
					});
				</script>
				<?php		
				}
				?>
                <a id="edit_profile" class="btn btn-work" href="<?php echo Yii::app()->baseUrl;?>/adminprofile/edit/?id=<?php echo Yii::app()->request->cookies['id'];?>"><i class="icon-pencil icon-white"></i> パスワード・紹介文の変更</a></span></div>
                <div class="box">
                <?php
                if($user["passwd"]==7581){
				?>
                <p class="descriptionTxt initPassChangeMsg"><?php echo Lang::MSG_0090;?></p>
                <?php }?>
                <p class="descriptionTxt">部署&amp;メンバー紹介ページと、マジメのポータルトップページの今日の社員ピックアップに反映されます。</p>
                <div class="baseDetailBox">
                    <div class="field attachements">
                        <div class="title">個人Data</div>
                    </div>
                    <div class="textBox boxL mt15 clearfix">
                        <div class="field staff_nmb">
                            <div class="title">社員番号&nbsp;</div>
                            <div class="data"><p><?php echo htmlspecialchars($user["employee_number"]);?></p></div>
                        </div>
                        <div class="field staff_pw">
                            <div class="title">パスワード&nbsp;</div>
                            <div class="data"><?php $count=strlen($user["passwd"]);for($i=0;$i<$count;$i++) echo "*";?></div>
                        </div>
                        <div class="field mail">
                            <div class="title">メールアドレス&nbsp;</div>
                            <div class="data"><p><?php echo htmlspecialchars($user["mailaddr"]);?></p></div>
                        </div>
    
                        <div class="field last_name">
                            <div class="title">名前&nbsp;</div>
                            <div class="data"><p><?php echo htmlspecialchars($user["lastname"].' '.$user["firstname"]);?></p></div>
                        </div>
                        
                        <div class="field ruby">
                            <div class="title">ふりがな&nbsp;</div>
                            <div class="data"><p><?php echo htmlspecialchars($user["lastname_kana"].' '.$user["firstname_kana"]);?></p></div>
                        </div>
                        <div class="field birth_day">
                            <div class="title">生年月日&nbsp;</div>
                            <div class="data"><?php echo FunctionCommon::formatDate($user['birthday']); ?></div>
                        </div>
                        <div class="field joined_year">
                            <div class="title">入社年&nbsp;</div>
                            <div class="data"><?php echo $user["joindate"];?>年</div>
                        </div>
                    </div><!-- /boxL -->
                    
                    <div class="textBox boxR clearfix">
                    	<div class="building_photo">
                           
                            <?php 
                            if($user['photo']!=""&&file_exists(Yii::getPathOfAlias('webroot').$user['photo'])){
                                $img_src = ltrim($user["photo"], '/');
                                $imgbinary = fread(fopen($img_src, "r"), filesize($img_src));
                                $img_str = base64_encode($imgbinary);
                                echo '<a ondragstart="return false;" ondrop="return false;" id="demo" href="'.Yii::app()->request->baseUrl.$user["photo"].'" rel="prettyPhoto">';    
                                if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {                                    
                                    echo '<img id="not_download" src="'.Yii::app()->request->baseUrl.$user["photo"].'" style="width:228px; height:171px;"/>';
                                    if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.') == false) { 
                                        echo '<img src="data:image/jpg;base64,'.$img_str.'" style="display:none;"/>';
                                    }
                                    
                                    
                                }
                                else{
                                    echo '<img id="not_download" src="data:image/jpg;base64,'.$img_str.'" style="width:228px; height:171px;"/>';
                                }
                                
                                echo '</a>';
                                ?>
                               

                            <?php               
                            }
                            else{
                                echo '<img src="'.$this->assetsBase.'/css/common/img/img_dummyman.jpg">';
                            }
                            ?>
                            
                            <p><span>写真</span></p>
                        </div>
                    </div><!-- /boxR -->
                    
                </div><!-- /baseDetailBox -->
                <div class="baseDetailBox">
						<table>
                        	<tr>
                            	<th>所属＆役職1&nbsp;</th>
                            	<td>
                                <?php  
										foreach($unit as $units){
											if($user['division1']==$units['id']){
												echo "<span class='company'>".$units['company_name']."</span><span class='branch'>".$units['branch_name']."</span><span class='unit'>".$units['unit_name']."</span>";
												
												foreach($post as $post_name){
													if($user['position1']==$post_name['id']){
														echo '<span class="post">'.$post_name['post_name'].' </span>';
													}
												 }
												 
											}
										 }
								?>
                                
                                </td>                                
                            </tr> 
                            <tr>
                            	<th>所属＆役職2&nbsp;</th>
                            	<td>
                               <?php  
										foreach($unit as $units){
											if($user['division2']==$units['id']){
												echo "<span class='company'>".$units['company_name']."</span><span class='branch'>".$units['branch_name']."</span><span class='unit'>".$units['unit_name']."</span>";
												
												foreach($post as $post_name){
													if($user['position2']==$post_name['id']){
														echo '<span class="post">'.$post_name['post_name'].' </span>';
													}
												 }
												 
											}
										 }
								?>
                                </td>                                
                            </tr> 
                            <tr>
                            	<th>所属＆役職3&nbsp;</th>
                            	<td>
                               <?php  
										foreach($unit as $units){
											if($user['division3']==$units['id']){
												echo "<span class='company'>".$units['company_name']."</span><span class='branch'>".$units['branch_name']."</span><span class='unit'>".$units['unit_name']."</span>";
												
												foreach($post as $post_name){
													if($user['position3']==$post_name['id']){
														echo '<span class="post">'.$post_name['post_name'].' </span>';
													}
												 }
												 
											}
										 }
								?>
                                </td>                                
                            </tr> 
                            <tr>
                            	<th>所属＆役職4&nbsp;</th>
                            	<td>
                               <?php  
										foreach($unit as $units){
											if($user['division4']==$units['id']){
												echo "<span class='company'>".$units['company_name']."</span><span class='branch'>".$units['branch_name']."</span><span class='unit'>".$units['unit_name']."</span>";
												
												foreach($post as $post_name){
													if($user['position4']==$post_name['id']){
														echo '<span class="post">'.$post_name['post_name'].' </span>';
													}
												 }
												 
											}
										 }
								?>
                                </td>                                
                            </tr>                                                           	
                        </table>
                    </div><!-- /baseDetailBox -->
                <div class="baseDetailBox">
                    <div class="field attachements">
                        <div class="title">紹介内容</div>
                    </div>
                    <div class="textBox mt15 clearfix">
                        <div class="field copy">
                            <div class="title">キャッチコピー&nbsp;</div>
                            <div class="data"><p><?php echo nl2br(FunctionCommon::url_henkan($user["catchphrase"]));?></p></div>
                        </div>
                        
                        <div class="field comment">
                            <div class="title">コメント&nbsp;</div>
                            <div class="data"><p><?php echo nl2br(FunctionCommon::url_henkan($user["comment"]));?></p></div>
                        </div>
                        
                    </div><!-- /boxL -->
                   	 
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
        <p id="page-top" style="display: block;"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
</div>

</div>
