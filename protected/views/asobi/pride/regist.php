<link href="<?php echo $this->assetsBase; ?>/css/common/css/pride.css" rel="stylesheet" type="text/css">
<link href="<?php echo $this->assetsBase; ?>/css/asobi/css/secondary.css" rel="stylesheet" type="text/css"/>



<div class="wrap asobi secondary pride">
    <div class="container">
        <div class="contents regist">        	
            <div class="mainBox detail">
            	<div class="pageTtl">
                    <h2>あそびにマジメ！？あそび自慢＆対決！ - 登録</h2>
                    <span>
						 <?php 
                        if(Yii::app()->request->cookies['page']!= "") 
                        {
                               $page = "index?page=".Yii::app()->request->cookies['page'];
                                
                        }else {$page ="";}
                        ?>
                        <a class="btn btn-important" href="<?php echo Yii::app()->request->baseUrl; ?>/asobipride/<?php echo $page;?>">
                            <i class="icon-chevron-left icon-white"></i> 一覧に戻る
                        </a>
                    </span>
                </div>
                <div class="box">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'pride_form',                     
                    'htmlOptions' => array(
                                          'enctype' => 'multipart/form-data',
                                          'class'=>'form-horizontal',                                         
                                          ),
                        ));
                ?>                   
                <div class="cnt-box">     
					<div class="control-group">
                        <label class="control-label">アイコン&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	<?php echo $form->error($model, 'icon'); ?>
                        	<div id="show_error">
                            <?php for($i=1;$i<=4;$i++){?>
	                        	<label class="radio inline"><?php echo $form->radioButton($model,'icon',array('class'=>'icon_'.$i,'value'=>$i,'uncheckValue' => null)); ?><span class="pride-icon pride-icon-prize0<?php echo $i?>">icon0<?php echo $i?></span></label>
	                        <?php }?>	
                        	</div>
                            <div>
                            <?php for($i=5;$i<=8;$i++){?>
	                        	<label class="radio inline"><?php echo $form->radioButton($model,'icon',array('class'=>'icon_'.$i,'value'=>$i,'uncheckValue' => null)); ?><span class="pride-icon pride-icon-prize0<?php echo $i?>">icon0<?php echo $i?></span></label>
	                        <?php }?>	
                        	</div>
                        </div>
                    </div>               
                    <div class="control-group">
                        <label class="control-label" for="title">タイトル&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	
                        	<?php echo $form->textField($model, 'title', array('placeholder' => 'タイトルを入力してください。[25文字]', 'class' => 'input-xxlarge')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="content">本文&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	
                        	<?php echo $form->textarea($model, 'content', array('placeholder' => '本文を入力してください。', 'class' => 'input-xxlarge', 'rows' => 7,'maxlength' => 3000)); ?>
                        </div>
                    </div>
                    <div class="field attachements">
                       
                        <?php                 
                        $attachements = $this->beginWidget('ext.helpers.Form_new');
						$attachements->regist11($model, $form,$attachment1_error,$attachment2_error,$attachment3_error,'asobipride',$this->assetsBase);
                        $this->endWidget();
                    ?>
                      </div>
                </div><!-- /cnt-box -->
                <?php $this->endWidget(); ?>
                    <div class="form-last-btn">
                        <p class="btn80">
                            <button class="btn btn-important" type="submit">
								<i class="icon-chevron-right icon-white">&#12288;</i> 確認
							</button>
                        </p>
                        
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
<script type="text/javascript"> 
        jQuery(function($){ 
        $('input[type="checkbox"]').click (function (){            
                 if ($(this).is (':checked')){ 
                      $fileInput=$(this).parent().parent().prev().find('input[type="file"]').eq(0);
                      name=$fileInput.attr('name');
                      id=$fileInput.attr('id');
                      classAttr=$fileInput.attr('class'); 
                      if(name==undefined){
                          name="";
                      }
                      if(id==undefined){
                          id="";
                      }
                      if(classAttr==undefined){
                          classAttr="";
                      }
                      $fileInput.replaceWith("<input type='file' name='"+name+"' id='"+id+"' class='"+classAttr+"'/>");
                      //
                      $node1=$(this).parent().parent().prev().prev();
                      $node1.remove();
                      $('<img alt="" src="<?php echo $this->assetsBase; ?>/css/common/img/img_photo01.jpg">').insertBefore($(this).parent().parent().prev());                      
                 }
            });
          $("#pride_form").attr('action','<?php echo Yii::app()->baseUrl;?>/asobipride/registconfirm/');       	   
		  icon=getCookie("pride_regist_icon");
          if(icon!=null&&icon!="null"){
			  for(i=1;i<=8;i++)
			   if(icon==i)
			   {
				    $(".icon_"+i).attr("checked", "checked");  
			   } 				 
			   $("#Pride_icon").val(icon);
          }
		      
           title=getCookie("pride_regist_title");
           if(title!=null&&title!="null"){
               $("#Pride_title").val(title);
           }
		   else{
               jQuery('#err1').remove();
               jQuery('#err2').remove();
               jQuery('#err3').remove();
               //jQuery('#photo_error').remove();
           }
           content=getCookie("pride_regist_content");           
           if(content!=null&&content!="null"){
                content1=content.replace(/<br ?\/?>|_/g, '\n');
               $("#Pride_content").val(content1);
           }
           attachment1_checkbox_for_deleting=getCookie("pride_regist_attachment1_checkbox_for_deleting");
           if(attachment1_checkbox_for_deleting!=null&&attachment1_checkbox_for_deleting!="null"){              
               if(attachment1_checkbox_for_deleting=='1'){
                   $("#Pride_attachment1_checkbox_for_deleting").attr('checked',true);
               }
               else{
                   $("#Pride_attachment1_checkbox_for_deleting").attr('checked',false);
               }
              
           }
           attachment2_checkbox_for_deleting=getCookie("pride_regist_attachment2_checkbox_for_deleting");
           if(attachment2_checkbox_for_deleting!=null&&attachment2_checkbox_for_deleting!="null"){
               if(attachment2_checkbox_for_deleting=='1'){
                   $("#Pride_attachment2_checkbox_for_deleting").attr('checked',true);
               }
               else{
                   $("#Pride_attachment2_checkbox_for_deleting").attr('checked',false);
               }
           
            
           }
           attachment3_checkbox_for_deleting=getCookie("pride_regist_attachment3_checkbox_for_deleting");
           if(attachment3_checkbox_for_deleting!=null&&attachment3_checkbox_for_deleting!="null"){
               if(attachment3_checkbox_for_deleting=='1'){
                   $("#Pride_attachment3_checkbox_for_deleting").attr('checked',true);
               }
               else{
                   $("#Pride_attachment3_checkbox_for_deleting").attr('checked',false);
               }
           }
		   
		   //setCookie("pride_regist_icon",$("#Pride_icon").val(2));
           setCookie("pride_regist_title",$("#Pride_title").val());
           setCookie("pride_regist_content",content); 
            /**
             * 
             */
           $("body").attr('id','asobi');      
        
           $('button[type="submit"]').click(function(){  
    
            deleteCookies("pride_regist_from"); 		   
			$.ajax({    
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/asobipride/regist/",    
				data: jQuery('#pride_form').serialize(),
				success: function(msg){	           
					  jQuery('#Pride_icon').prev().remove();  	             					  		
					  jQuery('#Pride_title').prev().remove();                                       				                  					
					  jQuery('#Pride_content').prev().remove();                                       						                                            					  	
					  	if(msg!='[]'|checkFile()==false){
                                                    data=$.parseJSON(msg);
													
													if(data.Pride_icon){
                                                         div=document.createElement('div');
                                                         $(div).addClass('alert');
                                                         $(div).addClass('error_message');
                                                         $(div).html(data.Pride_icon);
                                                         $(div).insertBefore($('#show_error'));
                                                         
                                                    } 
                                                    if(data.Pride_title){
                                                         div=document.createElement('div');
                                                         $(div).addClass('alert');
                                                         $(div).addClass('error_message');
                                                         $(div).html(data.Pride_title);
                                                         $(div).insertBefore($('#Pride_title'));
                                                         
                                                    } 
                                                    if(data.Pride_content){
                                                         div=document.createElement('div');
                                                         $(div).addClass('alert');
                                                         $(div).addClass('error_message');
                                                         $(div).html(data.Pride_content);
                                                         $(div).insertBefore($('#Pride_content'));                                                         
                                                    }
                                                }							  															
					else{                               
												 
												setCookie("pride_regist_icon",$("#Pride_icon").val());
                                                setCookie("pride_regist_title",$("#Pride_title").val());
                                                
                                                val=$("#Pride_content").val();
                                                val=val.replace(/\n/g, "<br/>");
                                                setCookie("pride_regist_content",val);
                                                if($("#Pride_attachment1_checkbox_for_deleting").attr('checked')==true){
                                                    setCookie("pride_regist_attachment1_checkbox_for_deleting",'1');
                                                }
                                                else{
                                                    setCookie("pride_regist_attachment1_checkbox_for_deleting",'0');
                                                }
                                                if($("#Pride_attachment2_checkbox_for_deleting").attr('checked')==true){
                                                    setCookie("pride_regist_attachment2_checkbox_for_deleting",'1');
                                                }
                                                else{
                                                    setCookie("pride_regist_attachment2_checkbox_for_deleting",'0');
                                                }
                                                if($("#Pride_attachment3_checkbox_for_deleting").attr('checked')==true){
                                                    setCookie("pride_regist_attachment3_checkbox_for_deleting",'1');
                                                }
                                                else{
                                                    setCookie("pride_regist_attachment3_checkbox_for_deleting",'0');
                                                }
                                                jQuery('#pride_form').submit();
                                            
                                            
                                        }							    			    
				}	  
			});			
		});                        
        });
		
function checkFile(){
    var result	 = true;
    $("#error_message1").html("");
    $("#error_message1").removeClass("cerrorMessage alert error_message");
    $("#error_message2").html("");
    $("#error_message2").removeClass("cerrorMessage alert error_message");
    $("#error_message3").html("");
    $("#error_message3").removeClass("cerrorMessage alert error_message");
    $(".error_message").html("");
    $("div").removeClass("cerrorMessage alert error_message");
    var checkBox1  = jQuery('#Pride_attachment1_checkbox_for_deleting').is(":checked");
    var checkBox2  = jQuery('#Pride_attachment2_checkbox_for_deleting').is(":checked");
    var checkBox3  = jQuery('#Pride_attachment3_checkbox_for_deleting').is(":checked");

    //check format file
    var arr_file	   = [".zip", ".doc", ".docx", ".xls" , ".xlsx" , ".ppt" , ".pptx" , ".pdf" , ".rar" , ".jpg" , ".gif", ".png", ".jpeg"];			
    var attachment1 = jQuery('#Pride_attachment1').val();

    checkFile1	   = attachment1.substr(attachment1.lastIndexOf('.'));
    checkFile1	   = checkFile1.toLowerCase();

    var attachment2 = jQuery('#Pride_attachment2').val();
    checkFile2	   = attachment2.substr(attachment2.lastIndexOf('.'));
    checkFile2	   = checkFile2.toLowerCase();

    var attachment3 = jQuery('#Pride_attachment3').val();

    checkFile3	   = attachment3.substr(attachment3.lastIndexOf('.'));
    checkFile3	   = checkFile3.toLowerCase();

    file1			   = jQuery.inArray(checkFile1, arr_file);
    file2			   = jQuery.inArray(checkFile2, arr_file);
    file3			   = jQuery.inArray(checkFile3, arr_file);

    if(checkBox1 == false && file1 == -1 && attachment1 !="")
    {
               jQuery("#error_message1").html("<?php echo Lang::MSG_0036 ?>");	
               jQuery("#error_message1").addClass("cerrorMessage alert error_message");
               result = false;

    }
    if(checkBox2 == false && file2 == -1 && attachment2 !="")
    {
               jQuery("#error_message2").html("<?php echo Lang::MSG_0037 ?>");	
               jQuery("#error_message2").addClass("cerrorMessage alert error_message");
               result = false;

    }
    if(checkBox3 == false && file3 == -1 && attachment3 !="")
    {
               jQuery("#error_message3").html("<?php echo Lang::MSG_0038 ?>");	
               jQuery("#error_message3").addClass("cerrorMessage alert error_message");
               result = false;

    }
    return result;
}
</script>