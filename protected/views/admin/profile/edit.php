<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/admin/css/user.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto_not_download_img.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>
<script type="text/javascript">
function checkId()
    {
            jQuery.ajax({   
            type: "POST", 
                    async:true,
                    url: "<?php echo Yii::app()->baseUrl;?>/adminclaim/checkId/",    
                    data:{id:"<?php echo $model->id;?>",table:"user"},
                    success: function(msg){	
                            if(msg=='0'){ 
                                    window.location='<?php echo Yii::app()->baseUrl;?>/admin';
                            }
                    }
            });
    }

    jQuery(function($) {
    $('img#not_download').contextmenu( function() {
            return false;
        });
        $("body").delegate("img#fullResImage","contextmenu",function(){
          return false;
        });
       
        $("body").attr('id', 'admin');
        /**
         * 
         */
        $('button#next').click(function() {
		   
                    checkId();
            $.ajax({
                type: "POST",
                async: true,
                url: "<?php echo Yii::app()->baseUrl; ?>/adminprofile/edit/?id=<?php echo $model->id;?>",
                data: jQuery('#user_form').serialize(),
                success: function(msg) {                    
                    jQuery('#User_employee_number').prev().remove();
                    jQuery('#User_passwd').prev().remove();
                    jQuery('#User_catchphrase').prev().remove();
                    jQuery('#User_comment').prev().remove();                    
                    jQuery("#error_message1").html("").removeClass("alert error_message");                    
                    jQuery('div.errorMessage ').remove();
                                     
                    if (msg != '[]') {
                        data = $.parseJSON(msg);
                        
                        if (data.User_passwd) {
                            div = document.createElement('div');
                            $(div).addClass('alert');
                            $(div).addClass('error_message');
                            $(div).html(data.User_passwd);
                            $(div).insertBefore($('#User_passwd'));
                        }
                        if (data.User_catchphrase) {
                            div = document.createElement('div');
                            $(div).addClass('alert');
                            $(div).addClass('error_message');
                            $(div).html(data.User_catchphrase);
                            $(div).insertBefore($('#User_catchphrase'));
                        }
                        if (data.User_comment) {
                            div = document.createElement('div');
                            $(div).addClass('alert');
                            $(div).addClass('error_message');
                            $(div).html(data.User_comment);
                            $(div).insertBefore($('#User_comment'));
                        }
                        $('body,html').animate({
                            scrollTop: 0
                        }, 500);
                    }
                    else {                                        
                        
                        if(confirm('変更します。よろしいですか？')){
                            jQuery('#user_form').submit();
                        }
                        
                    }
                }
            });
        });


        errorDivs = jQuery('div.errorMessage');
        for (i = 0, n = errorDivs.length; i < n; i++) {
            if (jQuery(errorDivs[i]).html() != "") {
                jQuery(errorDivs[i]).addClass('alert');
                jQuery(errorDivs[i]).addClass('error_message');
            }
        }
    });
</script>
<div class="wrap admin secondary user">

    <div class="container">
        <div class="contents detail">

            <div class="mainBox">
                <div class="pageTtl"><h2>プロフィール - パスワード・紹介文変更</h2>
                    <span>
                     <?php
					if(Yii::app()->request->cookies['passwd']=='7581'){
					?>	
					<script type='text/javascript'>
					 $(document).ready(function(){
						$("a#back_profile").attr("href", "<?php echo Yii::app()->baseUrl;?>/adminprofile/detail/?id=<?php echo $model->id;?>");
						});
					</script>
					<?php		
					}
					?>
                    <a id="back_profile" class="btn btn-important" href="<?php echo Yii::app()->baseUrl;?>/adminprofile/detail/?id=<?php echo $model->id;?>"><i class="icon-chevron-left icon-white"></i> もどる</a></span></div>
                <div class="box">
                    <p class="descriptionTxt">部署&amp;メンバー紹介ページと、マジメのポータルトップページの今日の社員ピックアップに反映されます。</p>
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'user_form',
                        'htmlOptions' => array(
                            'enctype' => 'multipart/form-data',
                            'class' => 'form-horizontal',  
                           
                        ),
                    ));
                    ?>                
                              
                    <?php echo $form->hiddenField($model, 'photo_file_type'); ?>  
                    <?php echo $form->hiddenField($model, 'role_name'); ?>    
                    <?php echo $form->hiddenField($model, 'id'); ?>    

                    <div class="cnt-box">

                        <div class="baseDetailBox">
                            <div class="field attachements">
                                <div class="title">個人Data</div>
                            </div>
                            <div class="textBox boxL mt15 clearfix">

                                <div class="field staff_nmb">
                                    <div class="title">社員番号&nbsp;</div>
                                    <div class="data"><p><?php echo $model->employee_number;?><?php echo $form->hiddenField($model, 'employee_number'); ?>  </p></div>
                                </div>
                                <div class="control-group">
                                    <label for="staff_pw" class="control-label">パスワード&nbsp;
                                    <span class="label label-warning">必須</span></label>
                                    <div class="controls">
                                        <?php echo $form->error($model, 'passwd'); ?>
                                        <?php echo $form->passwordField($model, 'passwd', array('class' => 'input-xlarge', 'placeholder' => '変更する場合は入力してください。')); ?>                                                                            
                                    </div>
                                </div>

                                <div class="field last_name">
                                    <div class="title">メールアドレス&nbsp;</div>
                                    <div class="data"><?php echo $model->mailaddr;?><?php echo $form->hiddenField($model, 'mailaddr'); ?>							 </div>
                                </div>

                                <div class="field last_name">
                                    <div class="title">名前&nbsp;</div>
                                    <div class="data"><?php echo $model->lastname.' '.$model->firstname;?><?php echo $form->hiddenField($model, 'firstname'); ?> <?php echo $form->hiddenField($model, 'lastname'); ?></div>
                                </div>
                                <div class="field ruby">
                                    <div class="title">ふりがな&nbsp;</div>
                                    <div class="data"><?php echo $model->lastname_kana.' '.$model->firstname_kana;?><?php echo $form->hiddenField($model, 'firstname_kana'); ?> <?php echo $form->hiddenField($model, 'lastname_kana'); ?> </div>
                                </div>
                                <div class="field birth_day">
                                    <div class="title">生年月日&nbsp;</div>
                                    <div class="data">
									<?php echo convertDateFromDbToView($model->birthday); ?><?php echo $form->hiddenField($model, 'birthday'); ?> </div>
                                </div>
                                <div class="field joined_year">
                                    <div class="title">入社年&nbsp;</div>
                                    <div class="data"><?php echo $model->joindate;?>年<?php echo $form->hiddenField($model, 'joindate'); ?> </div>
                                </div>

                            </div><!-- /boxL -->
							
                            <div class="textBox boxR clearfix">
                                <div class="building_photo">
                                    <?php
									
                                    $photo=Yii::app()->db->createCommand("select photo from user where id=".$model->id)->queryScalar();
                                    if($photo==FALSE){
                                        $photo='';
                                    }
                                    if (trim($photo) != ""&&file_exists(Yii::getPathOfAlias('webroot').$photo)) {
                                        $img_src = ltrim($model->photo, '/');
                                $imgbinary = fread(fopen($img_src, "r"), filesize($img_src));
                                $img_str = base64_encode($imgbinary);
                                echo '<a ondragstart="return false;" ondrop="return false;" id="demo" style="width:228px; margin: 0px 15px;" href="'.Yii::app()->request->baseUrl.$model->photo.'" rel="prettyPhoto">';    
                                if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {                                    
                                    echo '<img id="not_download" src="'.Yii::app()->request->baseUrl.$photo.'" style="width:228px; height:171px;"/>';
                                    if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.') == false) { 
                                        echo '<img src="data:image/jpg;base64,'.$img_str.'" style="display:none;"/>';
                                    }
                                    
                                    
                                }
                                else{
                                    echo '<img id="not_download" src="data:image/jpg;base64,'.$img_str.'" style="width:228px; height:171px;"/>';
                                }
                                
                                echo '</a>';
//have file?>
                                    
                                        
                                    
                                    <?php
                                        
                                    } else {//do not have file?>
                                        <img style="width:228px; margin: 0px 15px;" src="<?php echo $this->assetsBase; ?>/css/common/img/img_dummyman.jpg">
                                    <?php    
                                    }                                    
                                    ?> 
                                    <p>
                                    <span class="checkUse">写真を&nbsp;&nbsp;
                                    <input type="radio" name="photo_pulic_flag" value="1" class="checkUse" <?php if($model->photo_public_flag=='1') echo "checked"?>>表示&nbsp;&nbsp;
                                    <input type="radio" name="photo_pulic_flag" value="0"  class="checkUse" <?php if($model->photo_public_flag=='0') echo "checked"?>>非表示
                                    </span>
                                    </p>
                                    
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
											if($model->division1==$units['id']){
												echo "<span class='company'>".$units['company_name']."</span><span class='branch'>".$units['branch_name']."</span><span class='unit'>".$units['unit_name']."</span>";
												
												foreach($post as $post_name){
													if($model->position1==$post_name['id']){
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
											if($model->division2==$units['id']){
												echo "<span class='company'>".$units['company_name']."</span><span class='branch'>".$units['branch_name']."</span><span class='unit'>".$units['unit_name']."</span>";
												
												foreach($post as $post_name){
													if($model->position2==$post_name['id']){
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
											if($model->division3==$units['id']){
												echo "<span class='company'>".$units['company_name']."</span><span class='branch'>".$units['branch_name']."</span><span class='unit'>".$units['unit_name']."</span>";
												
												foreach($post as $post_name){
													if($model->position3==$post_name['id']){
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
											if($model->division4==$units['id']){
												echo "<span class='company'>".$units['company_name']."</span><span class='branch'>".$units['branch_name']."</span><span class='unit'>".$units['unit_name']."</span>";
												
												foreach($post as $post_name){
													if($model->position4==$post_name['id']){
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
                                <div class="control-group">
                                    <label class="control-label" for="field_copy">キャッチコピー&nbsp;</label>
                                    <div class="controls">
                                        <?php echo $form->error($model, 'comment'); ?>
                                        <?php echo $form->textField($model, 'catchphrase', array('class' => 'input-xlarge', 'placeholder' => '役割名を入力してください。')); ?>                                                                                                                                                                                                                        
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="field_comment">コメント&nbsp;</label>
                                    <div class="controls">
                                        <?php echo $form->error($model, 'comment'); ?>
                                        <?php echo $form->textarea($model, 'comment', array('placeholder' => '本文を入力してください。', 'class' => 'input-xxlarge', 'rows' => 7,'maxlength' => 2000)); ?>                            
                                    </div>
                                </div>
                            </div><!-- /textBox -->

                        </div><!-- /baseDetailBox -->



                    </div><!-- /cnt-box -->
                    <?php $this->endWidget(); ?>
                    <div class="form-last-btn">
                        <p class="btn80">
                         <?php
						if(Yii::app()->request->cookies['passwd']=='7581'){
						?>	
						<script type='text/javascript'>
						 $(document).ready(function(){
							$('button#next').attr('type','submit');
							});
						</script>
						<?php		
						}
						?>
                            <button class="btn btn-important" type="submit" id="next"><i class="icon-refresh icon-white"></i> 更新</button>
                        </p>                        
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
        <p id="page-top" style="display: none;"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->

    <div class="footer">
        <p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div>
<?php

function convertDateFromDbToView($datetime) {
    if ($datetime == NULL || !is_string($datetime) || trim($datetime) == "") {
        return $datetime;
    }
    $date_time_array = explode(" ", $datetime);
    $date = $date_time_array[0];
    $y_m_d_array = explode("-", $date);
    return implode("/", $y_m_d_array);
}
?>