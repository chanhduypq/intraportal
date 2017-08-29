
<script src="<?php echo $this->assetsBase; ?>/js/lib/role.js"></script>
<script src="<?php echo $this->assetsBase; ?>/js/lib/json.js"></script>
<div class="wrap admin secondary role">

    <div class="container">
        <div class="contents index">

            <div class="mainBox detail">
                <div class="pageTtl"><h2>役割管理 - 登録</h2>
                    <span><a href="<?php echo Yii::app()->baseUrl.'/adminrole/' ?>" class="btn btn-important"><i class="icon-chevron-left icon-white"></i>
                            一覧に戻る</a></span>
                </div>
                <div class="box">
                    <?php $form = $this->beginWidget('CActiveForm', array(
						'id' => 'add_role_form', 
                        'action'=>Yii::app()->baseUrl.'/adminrole/regist_confirm',
                        'htmlOptions' => array(
						'enctype' => 'multipart/form-data',
						'class'=>'form-horizontal',
						'onsubmit'=>'return false;',
                        ),));?>
                       <div class="cnt-box">

                            <div class="control-group">
                                <label class="control-label" for="title">役割名&nbsp;
                                    <span class="label label-warning">必須</span></label>

                                <div class="controls">
                                     <?php echo $form->error($role_model, 'role_name'); ?>
                                     <?php echo $form->textField($role_model,'role_name',array('class'=>"input-xlarge",'id'=>'txtRoleName','placeholder'=>"役割名を入力してください。","autofocus"))?>
                                   
                                </div>
                            </div>
                            <?php
                            $i = 0;
                            foreach ($functions as $function) {
                                $i++;
                                ?>
                                <input name="Role_management[<?php echo $i ?>][function_id]" value="<?php echo $function->id ?>"
                                       type="hidden"/>
                                <div class="control-group">
                                    <label class="control-label"
                                           for="inputEmail"><?php echo htmlspecialchars($function->function_name) ?></label>

                                    <div class="controls">
                                        <div>
                                            <?php
                                            if((strcmp(trim($function->function_name),"部署管理")==0) 
                                              || (strcmp(trim($function->function_name),"社員管理")==0) 
                                              || (strcmp(trim($function->function_name),"役割管理")==0) 
                                              || (strcmp(trim($function->function_name),"役職管理")==0) 
                                              || (strcmp(trim($function->function_name),"休日管理")==0) 
                                              || (strcmp(trim($function->function_name),"事業所管理")==0) 
                                              || (strcmp(trim($function->function_name),"タグクラウド設定")==0) 
                                            ){?>
                                               <label class="checkbox inline"><input name="Role_management[<?php echo $i ?>][chkview]"
                                                                                  type="checkbox" id="chbview_<?php echo $i ?>" disabled="disabled"/><span
                                                    class="ico view_off">閲覧</span></label>
                                            <?php     }
                                             else { ?>
                                               <label class="checkbox inline"><input name="Role_management[<?php echo $i ?>][chkview]"
                                                                                  type="checkbox" id="chbview_<?php echo $i ?>"/><span
                                                    class="ico view">閲覧</span></label>
                                            <?php    
                                            }?>
                                            <?php 
                                            if(strcmp(trim($function->function_name),"今月の社員ピックアップ")==0 || (strcmp(trim($function->function_name),"Twitterキャッチ！")==0) 
                                              || (strcmp(trim($function->function_name),"ブログキャッチ！")==0)|| (strcmp(trim($function->function_name),"管理者へのお問い合わせ")==0)
                                              || (strcmp(trim($function->function_name),"今週の部署紹介")==0) || (strcmp(trim($function->function_name),"今週の部署紹介")==0) 
                                              || (strcmp(trim($function->function_name),"今日の名言")==0) || (strcmp(trim($function->function_name),"オススメのリンク")==0) 
                                              || (strcmp(trim($function->function_name),"全体指標")==0) || (strcmp(trim($function->function_name),"拠点＆メンバー紹介")==0) 
                                              || (strcmp(trim($function->function_name),"新井社長メッセージ")==0) || (strcmp(trim($function->function_name),"共有事項")==0) 
                                              || (strcmp(trim($function->function_name),"販売ランキング")==0) || (strcmp(trim($function->function_name),"お祝い報告")==0) 
                                              || (strcmp(trim($function->function_name),"今日のありがとう")==0) || (strcmp(trim($function->function_name),"資格取得・スキルアップ！")==0)
                                              || (strcmp(trim($function->function_name),"リンク集")==0) || (strcmp(trim($function->function_name),"部署管理")==0) 
                                              || (strcmp(trim($function->function_name),"社員管理")==0) || (strcmp(trim($function->function_name),"役割管理")==0) 
                                              || (strcmp(trim($function->function_name),"総務からのお知らせ その他")==0) || (strcmp(trim($function->function_name),"総務からのお知らせ 人事")==0) 
                                              || (strcmp(trim($function->function_name),"今日は何の日")==0)|| (strcmp(trim($function->function_name),"最新ランキング")==0)
                                              || (strcmp(trim($function->function_name),"今日の星座別運勢")==0) || (strcmp(trim($function->function_name),"今日の社員ピックアップ")==0)
                                              || (strcmp(trim($function->function_name),"役職管理")==0) || (strcmp(trim($function->function_name),"休日管理")==0)
                                              || (strcmp(trim($function->function_name),"事業所管理")==0) || (strcmp(trim($function->function_name),"タグクラウド設定")==0)
                                            ){?>
                                                <label class="checkbox inline"><input name="Role_management[<?php echo $i ?>][chkpost]"
                                                                                  name="" type="checkbox" id="chbpost_<?php echo $i ?>" disabled="disabled"/><span
                                                    class="ico posts_off">投稿</span></label>
                                            <?php     }
                                            else { ?>
                                                 <label class="checkbox inline"><input name="Role_management[<?php echo $i ?>][chkpost]"
                                                                                  name="" type="checkbox" id="chbpost_<?php echo $i ?>"/><span
                                                    class="ico posts">投稿</span></label>
                                            <?php    
                                            }?>
                                              <?php 
                                            if(strcmp(trim(htmlspecialchars($function->function_name)),"管理者へのお問い合わせ")==0 
                                              || (strcmp(trim(htmlspecialchars($function->function_name)),"拠点&メンバー紹介")==0) || (strcmp(trim(htmlspecialchars($function->function_name)),"今日の名言")==0)
                                              || (strcmp(trim(htmlspecialchars($function->function_name)),"今日は何の日")==0) || (strcmp(trim(htmlspecialchars($function->function_name)),"拠点＆メンバー紹介")==0)
                                              || (strcmp(trim(htmlspecialchars($function->function_name)),"最新ランキング")==0) || (strcmp(trim(htmlspecialchars($function->function_name)),"今日の星座別運勢")==0) ){?>
                                            
                                            <label class="checkbox inline"><input
                                                    name="Role_management[<?php echo $i ?>][chkadmin]" type="checkbox" id="chbadmin_<?php echo $i ?>" disabled="disabled"/><span
                                                    class="ico control_off">管理</span></label>
                                            <?php }
                                            else{?>
                                                 <label class="checkbox inline"><input
                                                    name="Role_management[<?php echo $i ?>][chkadmin]" type="checkbox" id="chbadmin_<?php echo $i ?>"/><span
                                                    class="ico control">管理</span></label>
                                         
                                            <?php    
                                            }    
                                            ?>    
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>


                        </div>
                        <!-- /cnt-box -->

                        <div class="form-last-btn">
                            <p class="btn80">
                                <button type="submit" class="btn btn-important"><i
                                        class="icon-chevron-right icon-white">　</i> 確認
                                </button>
                            </p>
                        </div>

                     <?php $this->endWidget(); ?>
                </div>
                <!-- /box -->
            </div>
            <!-- /mainBox -->

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

        </div>
        <!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

    </div>
    <!-- /container -->

    <div class="footer">
        <p>COPYRIGHT (C) Newgin ALL RIGHTS RESERVED.</p>
    </div>

</div><!-- /wrap -->
<script>
var submit=false;
$(window).load(function(){
   var roleName=getCookie('rolename');
   var arrCheck=getCookie('checkdata');
   if(roleName && roleName!="null"){
        $("#txtRoleName").val(roleName);
   }
   if(arrCheck)
   { 
        var item=jQuery.parseJSON(arrCheck);
        $.each(item, function(index){
           
           if(item[index]["1"]==1){
            $("input#chbview_"+item[index]["id"]).attr('checked','checked');
           } 
           if(item[index]["2"]==1){
            $("input#chbpost_"+item[index]["id"]).attr('checked','checked');
           } 
           if(item[index]["3"]==1){
            $("input#chbadmin_"+item[index]["id"]).attr('checked','checked');
           } 
        });
    }
   
    
});
$('button[type="submit"]').click(function(){
    submit=true;
    jQuery('#txtRoleName').prev().remove();
                           
    $.ajax({    
    				type: "POST", 
    				async:false,
    				url: "<?php echo Yii::app()->baseUrl;?>/index.php/adminrole/regist/",    
    				data: jQuery('#add_role_form').serialize(),
    
    				success: function(msg){	                        
    					  		
    					  jQuery('#txtRoleName').prev().remove();
                          if(msg!='[]'){
                                        data=$.parseJSON(msg);
                                        if(data.Role_role_name){
                                             div=document.createElement('div');
                                             $(div).addClass('alert');
                                             $(div).addClass('error_message');
                                             $(div).html(data.Role_role_name);
                                             $(div).insertBefore($('#txtRoleName'));
                                             
                                        } 
                                        $('html, body').animate({ scrollTop: 0 }, 'slow');                
                                        submit=false;                
    						  
    					  	}							  															
    					
    											    			    
    				}	  
    			});
                if( !validateCheckBox()){
                     div=document.createElement('div');
                     $(div).addClass('alert');
                     $(div).addClass('error_message');
                     $(div).html("<?php echo Lang::MSG_0066 ?>");
                     $(div).insertBefore($('#txtRoleName'));
                     $('html, body').animate({ scrollTop: 0 }, 'slow');  
                            
                     submit=false;                   
                }
               if(submit){
                    jQuery('#add_role_form').attr('onsubmit','return true;');
                    jQuery('#add_role_form').submit();
                    setCookie("rolename",$("#txtRoleName").val(),1);
                    setCookie("checkdata",getCheckboxData(),1);
               }
               
              
    					  	
    			
        
    });
   
</script>
