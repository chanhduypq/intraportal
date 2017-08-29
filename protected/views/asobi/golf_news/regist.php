<link href="<?php echo $this->assetsBase; ?>/css/asobi/css/secondary.css" rel="stylesheet" type="text/css"/>



       
<div class="wrap majime secondary golf_news">
    <div class="container">
        <div class="contents regist">        	
            <div class="mainBox detail">            	
                <div class="pageTtl"><h2>ゴルフもマジメ - 登録</h2>
                    <span><a class="btn btn-important" href="<?php echo Yii::app()->baseUrl;?>/asobigolf_news/index"><i class="icon-chevron-left icon-white"></i> 一覧に戻る</a></span>
                </div>
                <div class="box">
                <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'golf_news_form',                     
                    'htmlOptions' => array(
                                          'enctype' => 'multipart/form-data',
                                          'class'=>'form-horizontal',                                         
                                          ),
                        ));
                ?>
                
                
                                            
                <div class="cnt-box">  
                    <?php 
                            if(isset($cagories)&&is_array($cagories)&&count($cagories)>0){
                                
                                ?>
                    <div class="control-group">
                        <label class="control-label">カテゴリー</label>
                        <div class="controls">                                                       
                            
                        	<ul class="inline" id="Golfnews_category_id">
                                    <?php 
                                    foreach ($cagories as $key=>$value){
                                        $category_name=$value['category_name'];
                                        $background_color=$value['background_color'];
                                        $text_color=$value['text_color'];                                        
                                        ?>
                        		<li><label class="radio inline"><input type="radio" value="<?php echo $key;?>" name="Golfnews[category_id]"/><span style="background-color: <?php echo $background_color;?>; color:<?php echo $text_color;?>;" class="label"><?php echo $category_name;?></span></label></li>
                                    <?php    
                                    }
                                    ?>
                        	</ul>
                            
                        </div>
                    </div>
                    <?php
                            }
                            ?>
                    <div class="control-group">
                        <label for="title" class="control-label">アイキャッチ画像</label>
                        <div class="controls photo"> 
                            <div id="error_message4"></div>                                    
                                <style>
                                            div.photo a{float:none !important;}                                             
                                            div.photo img{ position:relative !important; float:none !important;}
                                        </style>	                      
                                    <?php 
                        $attachement4 = $this->beginWidget('ext.helpers.Form_new');
                            $attachement4->regist14($model, $form,$attachment4_error,'asobigolf_news',$this->assetsBase);
                            $this->endWidget();
                            ?>
			</div>
                    </div>
                    <div class="control-group">
                        <label for="title" class="control-label">タイトル&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	
                        	<?php echo $form->textField($model, 'title', array('placeholder' => 'タイトルを入力してください。[25文字]', 'class' => 'input-xxlarge')); ?>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="content" class="control-label">本文&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	
                        	<?php echo $form->textarea($model, 'content', array('placeholder' => '本文を入力してください。', 'class' => 'input-xxlarge', 'rows' => 7,'maxlength' => 3000)); ?>
                        </div>
                    </div>
                    
                  <div class="field attachements">
                    
                      <?php                 
                        $attachements = $this->beginWidget('ext.helpers.Form_new');
						$attachements->regist11($model, $form,$attachment1_error,$attachment2_error,$attachment3_error,'asobigolf_news',$this->assetsBase);
                        $this->endWidget();
                    ?>

                  </div>
                    
                </div><!-- /cnt-box -->
                <?php $this->endWidget(); ?>
                <div class="form-last-btn">
                	<p class="btn80">
	                    <button class="btn btn-important" type="submit"><i class="icon-chevron-right icon-white">&#12288;</i> 確認</button>
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
            $('div.imgbox img').css('height','171px');         
            $('div.photo img').css('height','171px');         
        
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
           $("#golf_news_form").attr('action','<?php echo Yii::app()->baseUrl;?>/asobigolf_news/registconfirm/');          
           title=getCookie("golf_news_regist_title");          
           if(title!=null&&title!="null"){
               $("#Golfnews_title").val(title);
           }
		   else{
               jQuery('#err1').remove();
               jQuery('#err2').remove();
               jQuery('#err3').remove();
               jQuery('#photo_error').remove();
           }
           content=getCookie("golf_news_regist_content");           
           if(content!=null&&content!="null"){               
               content1=content.replace(/<br ?\/?>|_/g, '\n');        
               $("#Golfnews_content").val(content1);
           }
           category_id=getCookie("golf_news_regist_category_id");
           if(category_id!=null&&category_id!="null"){
               if($.trim($("ul#Golfnews_category_id").html())!=""){
                   inputs=$("ul#Golfnews_category_id input");
                   for(i=0,n=inputs.length;i<n;i++){
                       if($(inputs[i]).val()==category_id){
                           $(inputs[i]).attr('checked','checked');
                           break;
                       }
                   }
               }
               
              
           }
           attachment1_checkbox_for_deleting=getCookie("golf_news_regist_attachment1_checkbox_for_deleting");
           if(attachment1_checkbox_for_deleting!=null&&attachment1_checkbox_for_deleting!="null"){              
               if(attachment1_checkbox_for_deleting=='1'){
                   $("#Golfnews_attachment1_checkbox_for_deleting").attr('checked',true);
               }
               else{
                   $("#Golfnews_attachment1_checkbox_for_deleting").attr('checked',false);
               }
              
           }
           attachment2_checkbox_for_deleting=getCookie("golf_news_regist_attachment2_checkbox_for_deleting");
           if(attachment2_checkbox_for_deleting!=null&&attachment2_checkbox_for_deleting!="null"){
               if(attachment2_checkbox_for_deleting=='1'){
                   $("#Golfnews_attachment2_checkbox_for_deleting").attr('checked',true);
               }
               else{
                   $("#Golfnews_attachment2_checkbox_for_deleting").attr('checked',false);
               }
           
            
           }
           attachment3_checkbox_for_deleting=getCookie("golf_news_regist_attachment3_checkbox_for_deleting");
           if(attachment3_checkbox_for_deleting!=null&&attachment3_checkbox_for_deleting!="null"){
               if(attachment3_checkbox_for_deleting=='1'){
                   $("#Golfnews_attachment3_checkbox_for_deleting").attr('checked',true);
               }
               else{
                   $("#Golfnews_attachment3_checkbox_for_deleting").attr('checked',false);
               }
           
             
           }
           eye_catch_checkbox_for_deleting=getCookie("golf_news_regist_eye_catch_checkbox_for_deleting");
           if(eye_catch_checkbox_for_deleting!=null&&eye_catch_checkbox_for_deleting!="null"){
   
           
               if(eye_catch_checkbox_for_deleting=='1'){
                   $("#Golfnews_eye_catch_checkbox_for_deleting").attr('checked',true);
               }
               else{
                   $("#Golfnews_eye_catch_checkbox_for_deleting").attr('checked',false);
               }
           
             
           }
           
           
           setCookie("golf_news_regist_title",$("#Golfnews_title").val());
           setCookie("golf_news_regist_content",content); 
           

         
            /**
             * 
             */
           $("body").attr('id','asobi');    
        
           $('button[type="submit"]').click(function(){  
               

    
    
            deleteCookies("golf_news_regist_from"); 		   
			$.ajax({    
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/asobigolf_news/regist/",    
				data: jQuery('#golf_news_form').serialize(),
				success: function(msg){	                        					  		
					  jQuery('#Golfnews_title').prev().remove();                                       						                                            					  	
					  jQuery('#Golfnews_content').prev().remove();      
                                              
					  	if(msg!='[]'|checkFile()==false){
                                                    data=$.parseJSON(msg);
                                                    if(data.Golfnews_title){
                                                         div=document.createElement('div');
                                                         $(div).addClass('alert');
                                                         $(div).addClass('error_message');
                                                         $(div).html(data.Golfnews_title);
                                                         $(div).insertBefore($('#Golfnews_title'));
                                                         
                                                    } 
                                                    if(data.Golfnews_content){
                                                         div=document.createElement('div');
                                                         $(div).addClass('alert');
                                                         $(div).addClass('error_message');
                                                         $(div).html(data.Golfnews_content);
                                                         $(div).insertBefore($('#Golfnews_content'));                                                         
                                                    }
                                                    
                                                }							  															
					else{                  
                                                setCookie("golf_news_regist_title",$("#Golfnews_title").val());
                                                
                                                val=$("#Golfnews_content").val();
                                                val=val.replace(/\n/g, "<br/>");
                                                setCookie("golf_news_regist_content",val);
                                                
                                                inputs=$("ul#Golfnews_category_id input");
                                                radio=$("#golf_news_form input[type='radio']:checked");
                                                
                                                if(radio.length>0){
                                                    category_id=$(radio).val();
                                                setCookie("golf_news_regist_category_id",category_id);
                                                setCookie("golf_news_regist_category_name",$(radio).next().html());
                                               setCookie("golf_news_regist_background_color",$(radio).next().css('background-color'));
                                               setCookie("golf_news_regist_color",$(radio).next().css('color'));
                                                }
                                                
                                                
                                                if($("#Golfnews_attachment1_checkbox_for_deleting").attr('checked')==true){
                                                    setCookie("golf_news_regist_attachment1_checkbox_for_deleting",'1');
                                                }
                                                else{
                                                    setCookie("golf_news_regist_attachment1_checkbox_for_deleting",'0');
                                                }
                                                if($("#Golfnews_attachment2_checkbox_for_deleting").attr('checked')==true){
                                                    setCookie("golf_news_regist_attachment2_checkbox_for_deleting",'1');
                                                }
                                                else{
                                                    setCookie("golf_news_regist_attachment2_checkbox_for_deleting",'0');
                                                }
                                                if($("#Golfnews_attachment3_checkbox_for_deleting").attr('checked')==true){
                                                    setCookie("golf_news_regist_attachment3_checkbox_for_deleting",'1');
                                                }
                                                else{
                                                    setCookie("golf_news_regist_attachment3_checkbox_for_deleting",'0');
                                                }
                                                if($("#Golfnews_eye_catch_checkbox_for_deleting").attr('checked')==true){
                                                    setCookie("golf_news_regist_eye_catch_checkbox_for_deleting",'1');
                                                }
                                                else{
                                                    setCookie("golf_news_regist_eye_catch_checkbox_for_deleting",'0');
                                                }
                                               
                                                
                                                
                                                jQuery('#golf_news_form').submit();
                                            
                                            
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
    $("#error_message4").removeClass("cerrorMessage alert error_message");
    $(".error_message").html("");
    $("div").removeClass("cerrorMessage alert error_message");
    var checkBox1  = jQuery('#Golfnews_attachment1_checkbox_for_deleting').is(":checked");
    var checkBox2  = jQuery('#Golfnews_attachment2_checkbox_for_deleting').is(":checked");
    var checkBox3  = jQuery('#Golfnews_attachment3_checkbox_for_deleting').is(":checked");
    var checkBox4  = jQuery('#Golfnews_eye_catch_checkbox_for_deleting').is(":checked");

    //check format file
    var arr_file	   = [".zip", ".doc", ".docx", ".xls" , ".xlsx" , ".ppt" , ".pptx" , ".pdf" , ".rar" , ".jpg" , ".gif", ".png", ".jpeg"];			
    var arr_file1	   = [".jpg" , ".gif", ".png", ".jpeg"];			
    var attachment1 = jQuery('#Golfnews_attachment1').val();

    checkFile1	   = attachment1.substr(attachment1.lastIndexOf('.'));
    checkFile1	   = checkFile1.toLowerCase();

    var attachment2 = jQuery('#Golfnews_attachment2').val();
    checkFile2	   = attachment2.substr(attachment2.lastIndexOf('.'));
    checkFile2	   = checkFile2.toLowerCase();

    var attachment3 = jQuery('#Golfnews_attachment3').val();

    checkFile3	   = attachment3.substr(attachment3.lastIndexOf('.'));
    checkFile3	   = checkFile3.toLowerCase();
    
    var attachment4 = jQuery('#Golfnews_eye_catch').val();

    checkFile4	   = attachment4.substr(attachment4.lastIndexOf('.'));
    checkFile4	   = checkFile4.toLowerCase();

    file1			   = jQuery.inArray(checkFile1, arr_file);
    file2			   = jQuery.inArray(checkFile2, arr_file);
    file3			   = jQuery.inArray(checkFile3, arr_file);
    file4			   = jQuery.inArray(checkFile4, arr_file1);

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
    if(checkBox4==true){
        return true;
    }
    if(checkBox4 == false && file4 == -1 && attachment4 !="")
    {
               jQuery("#error_message4").html("<?php echo Lang::MSG_0107; ?>");	
               jQuery("#error_message4").addClass("cerrorMessage alert error_message");
               result = false;

    }
    return result;
}



</script>
<?php 
function echoCheckboxForDeletingFile($model, $form) {
        
        ?>
    <p>
        <span class="checkDelete">
    <?php
    echo $form->checkBox($model, 'eye_catch_checkbox_for_deleting'
            , array('value' => 1, 'uncheckValue' => 0)
    );
    ?>  削除する
        </span>
    </p>
    <?php
}
?>