




<div class="wrap admin secondary rival">
    <div class="container">
        <div class="contents regist">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>競合情報 - 修正</h2>
                <?php 
					if(Yii::app()->request->cookies['page']!= "") 
					{
						   $page = "index?page=".Yii::app()->request->cookies['page'];
							
					}else {$page ="";}
					?>
                <span><a class="btn btn-important" href="<?php echo Yii::app()->request->baseUrl; ?>/adminrival/<?php echo $page;?>"><i class="icon-chevron-left icon-white"></i> 一覧に戻る</a></span>
                </div>
                <div class="box">
                <?php
                
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'rival_form',                     
                    'htmlOptions' => array(
                                          'enctype' => 'multipart/form-data',
                                          'class'=>'form-horizontal',                                          
                                          ),
                        ));
                    
                ?> 
                <?php echo $form->hiddenField($model, 'id'); ?>                    
                <div class="cnt-box">
                    
                    <div class="control-group">
                        <label for="title" class="control-label">タイトル&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	<?php echo $form->error($model, 'title'); ?>
                        	<?php echo $form->textField($model, 'title', array('placeholder' => 'タイトルを入力してください。[25文字]', 'class' => 'input-xxlarge')); ?>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="content" class="control-label">本文&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	<?php echo $form->error($model, 'content'); ?>
                        	<?php echo $form->textarea($model, 'content', array('placeholder' => '本文を入力してください。', 'class' => 'input-xxlarge', 'rows' => 7,'maxlength' => 3000)); ?>                            
                        </div>
                    </div>
                    
                  <div class="field attachements">
                        <?php                    
                        $attachements = $this->beginWidget('ext.helpers.Form_new');
                        $attachements->edit11($model, $form,'adminrival',$attachment1_error,$attachment2_error,$attachment3_error,$this->assetsBase);                        
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

            <div class="sideBox">
            	<ul>
                	<li>
                    	 <?php $this->widget('MenuManager');?>
                         <?php $this->widget('AffairsManage');?>
                         <?php $this->widget('SystemManage');?>
                         <?php $this->widget('PostedByContentManage');?>
                    </li>
                </ul>
            </div>
            
        </div><!-- /contents -->
        <p id="page-top" style="display: none;"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div>

<script type="text/javascript">       
    

function checkId()
{
        jQuery.ajax({   
        type: "POST", 
                async:true,
                url: "<?php echo Yii::app()->baseUrl;?>/adminrival/checkId/",    
                data:{id:"<?php echo $model->id;?>",table:"rival"},
                success: function(msg){	
            
                        
                        if(msg=='0'){ 
                                window.location='<?php echo Yii::app()->baseUrl;?>/adminrival';
                        }
                }
        });
}
    
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
           $("#rival_form").attr('action', '<?php echo Yii::app()->baseUrl; ?>/adminrival/editconfirm/');                    
           title=getCookie("rival_edit_title");
           if(title!=null&&title!="null"){
               $("#Rival_title").val(title);
           }
           else{
               jQuery('#err1').remove();
               jQuery('#err2').remove();
               jQuery('#err3').remove();
           
           }
           content=getCookie("rival_edit_content");
           if(content!=null&&content!="null")
		   {
   
			   content1=content.replace(/<br ?\/?>|_/g, '\n');	
               $("#Rival_content").val(content1);
           }   
           attachment1_checkbox_for_deleting=getCookie("rival_edit_attachment1_checkbox_for_deleting");
           if(attachment1_checkbox_for_deleting!=null&&attachment1_checkbox_for_deleting!="null"){              
               if(attachment1_checkbox_for_deleting=='1'){
                   $("#Rival_attachment1_checkbox_for_deleting").attr('checked',true);
                   $fileInput=$("#Rival_attachment1_checkbox_for_deleting").parent().parent().prev().find('input[type="file"]').eq(0);
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
                  $node1=$("#Rival_attachment1_checkbox_for_deleting").parent().parent().prev().prev();
                  $node1.remove();
                  $('<img alt="" src="<?php echo $this->assetsBase; ?>/css/common/img/img_photo01.jpg">').insertBefore($("#Rival_attachment1_checkbox_for_deleting").parent().parent().prev());
               }
               else{
                   $("#Rival_attachment1_checkbox_for_deleting").attr('checked',false);
               }
               
           }
           attachment2_checkbox_for_deleting=getCookie("rival_edit_attachment2_checkbox_for_deleting");
           if(attachment2_checkbox_for_deleting!=null&&attachment2_checkbox_for_deleting!="null"){
               if(attachment2_checkbox_for_deleting=='1'){
                   $("#Rival_attachment2_checkbox_for_deleting").attr('checked',true);
                   $fileInput=$("#Rival_attachment2_checkbox_for_deleting").parent().parent().prev().find('input[type="file"]').eq(0);
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
                  $node1=$("#Rival_attachment2_checkbox_for_deleting").parent().parent().prev().prev();
                  $node1.remove();
                  $('<img alt="" src="<?php echo $this->assetsBase; ?>/css/common/img/img_photo01.jpg">').insertBefore($("#Rival_attachment2_checkbox_for_deleting").parent().parent().prev());
               }
               else{
                   $("#Rival_attachment2_checkbox_for_deleting").attr('checked',false);
               }
           
              
           }
           attachment3_checkbox_for_deleting=getCookie("rival_edit_attachment3_checkbox_for_deleting");
           if(attachment3_checkbox_for_deleting!=null&&attachment3_checkbox_for_deleting!="null"){
               if(attachment3_checkbox_for_deleting=='1'){
                   $("#Rival_attachment3_checkbox_for_deleting").attr('checked',true);
                   $fileInput=$("#Rival_attachment3_checkbox_for_deleting").parent().parent().prev().find('input[type="file"]').eq(0);
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
                  $node1=$("#Rival_attachment3_checkbox_for_deleting").parent().parent().prev().prev();
                  $node1.remove();
                  $('<img alt="" src="<?php echo $this->assetsBase; ?>/css/common/img/img_photo01.jpg">').insertBefore($("#Rival_attachment3_checkbox_for_deleting").parent().parent().prev());
               }
               else{
                   $("#Rival_attachment3_checkbox_for_deleting").attr('checked',false);
               }
           
              
           }

           setCookie("rival_edit_title",$("#Rival_title").val());
           setCookie("rival_edit_content",content);
           
           /**
            * 
            */ 
           $("body").attr('id','admin');     
           /**
            * 
            */
           $('button[type="submit"]').click(function(){
                no=2;            
           
            deleteCookies("rival_edit_from");  
            checkId();
			$.ajax({ 
                			
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/adminrival/edit/?id=<?php echo $model->id;?>",    
				data: jQuery('#rival_form').serialize(),

				success: function(msg){	                        
					  jQuery('#Rival_title').prev().remove();                                       					                					
					  jQuery('#Rival_content').prev().remove();                                       					
					  	if(msg!='[]'|checkFile()==false){
                                                    data=$.parseJSON(msg);
                                                    if(data.Rival_title){
                                                         div=document.createElement('div');
                                                         $(div).addClass('alert');
                                                         $(div).addClass('error_message');
                                                         $(div).html(data.Rival_title);
                                                         $(div).insertBefore($('#Rival_title'));
                                                         
                                                    } 
                                                    if(data.Rival_content){
                                                         div=document.createElement('div');
                                                         $(div).addClass('alert');
                                                         $(div).addClass('error_message');
                                                         $(div).html(data.Rival_content);
                                                         $(div).insertBefore($('#Rival_content'));
                                                         
                                                    } 
					  	}							  															
					else{   
                                            setCookie("rival_edit_title",$("#Rival_title").val());
                                            val=$("#Rival_content").val();
                                            val=val.replace(/\n/g, "<br/>");
                                            setCookie("rival_edit_content",val);
                                            if($("#Rival_attachment1_checkbox_for_deleting").attr('checked')==true){
                                                    setCookie("rival_edit_attachment1_checkbox_for_deleting",'1');
                                                }
                                                else{
                                                    setCookie("rival_edit_attachment1_checkbox_for_deleting",'0');
                                                }
                                                if($("#Rival_attachment2_checkbox_for_deleting").attr('checked')==true){
                                                    setCookie("rival_edit_attachment2_checkbox_for_deleting",'1');
                                                }
                                                else{
                                                    setCookie("rival_edit_attachment2_checkbox_for_deleting",'0');
                                                }
                                                if($("#Rival_attachment3_checkbox_for_deleting").attr('checked')==true){
                                                    setCookie("rival_edit_attachment3_checkbox_for_deleting",'1');
                                                }
                                                else{
                                                    setCookie("rival_edit_attachment3_checkbox_for_deleting",'0');
                                                }
                                            jQuery('#rival_form').submit();
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
    var checkBox1  = jQuery('#Rival_attachment1_checkbox_for_deleting').is(":checked");
    var checkBox2  = jQuery('#Rival_attachment2_checkbox_for_deleting').is(":checked");
    var checkBox3  = jQuery('#Rival_attachment3_checkbox_for_deleting').is(":checked");

    //check format file
    var arr_file	   = [".zip", ".doc", ".docx", ".xls" , ".xlsx" , ".ppt" , ".pptx" , ".pdf" , ".rar" , ".jpg" , ".gif", ".png", ".jpeg"];			
    var attachment1 = jQuery('#Rival_attachment1').val();

    checkFile1	   = attachment1.substr(attachment1.lastIndexOf('.'));
    checkFile1	   = checkFile1.toLowerCase();

    var attachment2 = jQuery('#Rival_attachment2').val();
    checkFile2	   = attachment2.substr(attachment2.lastIndexOf('.'));
    checkFile2	   = checkFile2.toLowerCase();

    var attachment3 = jQuery('#Rival_attachment3').val();

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
