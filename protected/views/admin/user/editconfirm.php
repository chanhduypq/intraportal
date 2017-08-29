
<link href="<?php echo $this->assetsBase; ?>/css/admin/css/user.css" rel="stylesheet" type="text/css"/>

<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto_not_download_img.js"></script>

<script type="text/javascript">
    jQuery(function($) {
        $('img#not_download').contextmenu( function() {
            return false;
        });
        $("body").delegate("img#fullResImage","contextmenu",function(){
          return false;
        });
       $("#User_cancel_random").attr("disabled","disabled");
        
        $(window).on('beforeunload', function(){
            setCookie("user_edit_from","confirm");             
        }); 

        $('button#submit').click(function(){  
            
           
            jQuery("input#edit").val('1');            
            jQuery("form#user_form").submit();
        });
        $('button#back').click(function(){  
            
            setCookie("user_edit_from","confirm");   
            
            window.location="<?php echo Yii::app()->baseUrl;?>/adminuser/edit/?id=<?php echo $model->id;?>";
        });
        $('a').click(function(){  
            
            
            if($(this).attr('id')==undefined||$(this).attr('id')=="demo"){
                return;
            }
            window.location="<?php echo Yii::app()->baseUrl;?>/adminuser/download/?file_name="+$(this).attr('id');
        });
    
        $("body").attr('id', 'admin');
        
       
       
        <?php if (isset($invalid) && $invalid == true) { ?>
                    $(window).load(function() {
                        jQuery('#user_form').attr('onsubmit','return true;')
                            $("#user_form").attr('action', '<?php echo Yii::app()->baseUrl; ?>/adminuser/edit/');                   
                            $("#user_form").submit();

                        
                    });
        <?php } ?>
    });
</script>
<div class="wrap admin secondary user">
    
    <div class="container">
        <div class="contents detail">

            <div class="mainBox">
                <div class="pageTtl"><h2>ユーザー管理 - 修正確認</h2></div>
                <div class="box">
                    <div class="cnt-box">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'user_form',
                            'htmlOptions' => array(
                                'enctype' => 'multipart/form-data',
                                'class' => 'form-horizontal',
                            ),
                        ));
                        ?>   
                        <?php echo $form->hiddenField($model, 'id'); ?>  
                        <?php echo $form->hiddenField($model, 'role_id'); ?>   
                        <?php echo $form->hiddenField($model, 'employee_number'); ?>   
                        <?php echo $form->hiddenField($model, 'passwd'); ?>   
                        <?php echo $form->hiddenField($model, 'mailaddr'); ?>   
                        <?php echo $form->hiddenField($model, 'lastname'); ?>   
                        <?php echo $form->hiddenField($model, 'firstname'); ?>   
                        <?php echo $form->hiddenField($model, 'lastname_kana'); ?>   
                        <?php echo $form->hiddenField($model, 'firstname_kana'); ?>   
                        <?php echo $form->hiddenField($model, 'birthday_year'); ?>   
                        <?php echo $form->hiddenField($model, 'birthday_month'); ?>   
                        <?php echo $form->hiddenField($model, 'birthday_day'); ?>   
                        <?php echo $form->hiddenField($model, 'joindate'); ?>                    
                        
                        <?php echo $form->hiddenField($model, 'catchphrase'); ?>   
                        <?php echo $form->hiddenField($model, 'comment'); ?>                      
                        <?php echo $form->hiddenField($model, 'role_name');
                        echo $form->hiddenField($model, 'photo_checkbox_for_deleting');                        
                        ?> 
        				<?php 
							for($i=1;$i<=4;$i++){
							echo $form->hiddenField($model, 'division'.$i); 
							echo $form->hiddenField($model, 'position'.$i); 
							echo $form->hiddenField($model, 'div_intro_modifiable_flag'.$i); 
							}
						?>
                        <input type="hidden" name="edit" id="edit" value="1"/>
                        <input type="hidden" name="submit_active" value="1"/>
                        <input type="hidden" name="cancel_random" value="<?php if($model->cancel_random =='1') echo '1'; else echo '0';?>"/>
                        <div class="baseDetailBox">
                            <div class="field attachements">
                                <div class="title">個人Data</div>
                            </div>
                            <div class="textBox boxL mt15 clearfix">
                                <div class="field staff_nmb">
                                    <div class="title">社員番号&nbsp;</div>
                                    <div class="data">
										<p>
										<?php echo htmlspecialchars($model->employee_number); ?>
										</p>
									</div>
                                </div>

                                <div class="field affili_post">
                                    <div class="title">役割名&nbsp;</div>
                                    <div class="data">
									<?php echo $model->role_name; ?>
									</div>
                                </div>

                                <div class="field mail">
                                    <div class="title">メールアドレス&nbsp;</div>
                                    <div class="data">
										<?php echo htmlspecialchars($model->mailaddr); ?>
									</div>
                                </div>

                                <div class="field last_name">
                                    <div class="title">名前&nbsp;</div>
                                    <div class="data">
										<?php echo htmlspecialchars($model->lastname . ' ' . $model->firstname); ?>
									</div>
                                </div>

                                <div class="field ruby">
                                    <div class="title">ふりがな&nbsp;</div>
                                    <div class="data">
										<?php echo htmlspecialchars($model->lastname_kana . ' ' . $model->firstname_kana); ?>
									</div>
                                </div>

                                <div class="field birth">
                                    <div class="title">生年月日&nbsp;</div>
                                    <div class="data">
									 <?php 
									  $birthday = explode("/",$model->birthday); 
									  echo $birthday['0']."年".$birthday['1']."月".$birthday['2']."日";
									 ?>
									</div>
                                </div>

                                <div class="field joined_year">
                                    <div class="title">入社年&nbsp;</div>
                                    <div class="data"><?php echo $model->joindate."年"; ?></div>
                                </div>

                            </div><!-- /boxL -->

                            
                            <div class="textBox boxR clearfix">
                            		<?php 
                                        $cookie_key_name='file_user_edit_attachment';
                                        if(Yii::app()->request->cookies[$cookie_key_name.'4']!=""&&Yii::app()->request->cookies[$cookie_key_name.'4']!="null"){
                                            $uploaded_file_attachment1_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase(Yii::app()->request->cookies[$cookie_key_name.'4']->value));
                                        }
                                        else{
                                            $uploaded_file_attachment1_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase($model->photo));      
                                        }
									if ($model->photo_checkbox_for_deleting == '0'){
                                                                                 if (trim($model->photo) != ""||(Yii::app()->request->cookies[$cookie_key_name.'4']!=""&&Yii::app()->request->cookies[$cookie_key_name.'4']!="null"&&file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name.'4']->value))) {//upload new file                                            
											
									?>
                                <div class="building_photo">
                                       	 <style>
											div.building_photo a{float:none !important;} 	
											a.a_base{float:none !important;}	
                                            img.img_base{ position:relative !important; float:none !important;}
                                        </style>	
    									<?php
                                 		                        $attachement4 = $this->beginWidget('ext.helpers.Form_new');									
                                                                        $attachement4->editConfirm14($model, $form,'adminuser',$this->assetsBase);
									$this->endWidget();
                                            
									 	?>
                                        <p style="width:228px; float:left; margin-left: 15px;"><span>写真</span></p>
                                    
                                </div>
                               <?php } }?>
                                
                            </div>
                            <!-- /boxR -->

                        </div><!-- /baseDetailBox -->
						<div class="baseDetailBox">
						<table>
                       	    <?php if($model->division1 !=""){?>
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
                            <?php }
							if($model->division2 !=""){
							?>
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
                              <?php }
							if($model->division3 !=""){
							?>
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
                              <?php }
							if($model->division4 !=""){
							?>
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
                            <?php }?>                                                       	
                        </table>
                    </div><!-- /baseDetailBox -->
                        <div class="baseDetailBox">
                            <div class="field attachements">
                                <div class="title">紹介内容</div>
                            </div>
                            <div class="textBox mt15 clearfix">
                                <div class="field copy">
                                    <div class="title">自動選出除外&nbsp;</div>
                                    <div class="data">
										<p>
											<?php echo $form->checkBox($model,'cancel_random'); ?>&nbsp;今週のピックアップによる自動選出から除外する
										</p>
									</div>
                                </div>
                                <div class="field copy">
                                    <div class="title">キャッチコピー&nbsp;</div>
                                    <div class="data">
										<p>
										<?php echo nl2br(FunctionCommon::url_henkan($model->catchphrase));?>	
										</p>
									</div>
                                </div>

                                <div class="field comment">
                                    <div class="title">コメント&nbsp;</div>
                                    <div class="data">
										<?php echo nl2br(FunctionCommon::url_henkan($model->comment));?>	
									</div>
                                </div>

                            </div><!-- /boxL -->

                        </div><!-- /baseDetailBox -->
                        <?php $this->endWidget(); ?> 
                    </div><!-- /cnt-box -->


                    <div class="form-last-btn">
                        <div class="btn170">
                            <button id="back" class="btn" type="submit">
								<i class="icon-chevron-left"></i> もどる
							</button>
                            <button id="submit" class="btn btn-important" type="submit">
								<i class="icon-chevron-right icon-white"></i> 更新
							</button>
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
        <p id="page-top" style="display: block;"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->

    <div class="footer">
        <p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div>
<?php

function getFileNameExtension($file_name) {
    if ($file_name == null || !is_string($file_name) || trim($file_name) == "") {
        return null;
    }
    $string_array = explode(".", $file_name);
    if (count($string_array) == 1) {
        return null;
    }
    return $string_array[count($string_array) - 1];
}
?>
