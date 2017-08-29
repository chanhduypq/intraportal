




<div class="wrap admin secondary base">

    <div class="container">
        <div class="contents detail">
        	
            <div class="mainBox">
            	<div class="pageTtl"><h2>部署管理 > 部署登録</h2></h2>
                <span><a 
                href="<?php echo Yii::app()->request->baseUrl; ?>/adminbase/unit/?base_id=<?php echo $_GET['base_id'];?>"
                 class="btn btn-important"><i class="icon-chevron-left icon-white"></i> 部署一覧に戻る</a></span></div>
                <div class="box">
                
                <p class="descriptionTxt">部署&amp;メンバー紹介ページに反映されます。</p>
					 <?php
                     $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'unit_form',                     
                    'htmlOptions' => array(
                                          'enctype' => 'multipart/form-data',
                                          'class'=>'form-horizontal',

                                          ),
                     ));
					?>	 
                    <div class="cnt-box">
                        <div class="baseDetailBox">
                            <div class="field attachements">
                                <div class="title"><?php echo $base_company['company_name']?>　部署Data</div>
							</div>
                           
                                 
                            <div class="control-group">
                                <label class="control-label" for="title">部門&nbsp;
                                <span class="label label-warning">必須</span></label>
                                <div class="controls">
                                    <?php 
									echo $form->error($model, 'branch_id'); 
									$array_branch = array();
									foreach ($branch as $branch_name){
										   $array_branch[$branch_name['id']] = $branch_name['branch_name'];
									}
									echo $form->dropDownList($model,'branch_id',$array_branch,  array('prompt'=>'選んでください')); 					
									?> 
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="name">部署名</label>
                                <div class="controls">
                                     <?php echo $form->error($model, 'unit_name'); ?>
                    	             <?php echo $form->textField($model, 'unit_name', array('class' => 'input-xlarge')); ?>
                                </div>
                            </div>
                                
                            <div class="control-group">
                                <label class="control-label" for="mail">連絡先Mail</label>
                                <div class="controls">
                                    
                                     <?php echo $form->error($model, 'mailaddr'); ?>
                    	             <?php echo $form->textField($model, 'mailaddr', array('class' => 'input-xxlarge')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="title">事業所&nbsp;
                                <span class="label label-warning">必須</span></label>
                                <div class="controls">
                                  	<?php 
										echo $form->error($model, 'office_id'); 
										$array_office = array();
										foreach ($office as $office_name){
											   $array_office[$office_name['id']] = $office_name['division_name'].' '.$office_name['address'];
										}
										echo $form->dropDownList($model,'office_id',$array_office,  array('prompt'=>'選んでください')); 					
									?> 
                                </div>

                            </div>
                            <div class="control-group">
                                <label class="control-label" for="title">電話番号&nbsp;</label>
                                    
                                <div class="controls">
                                    <?php
                                    echo $form->error($model, 'tel_number');
                                    echo $form->textField($model, 'tel_number', array('class' => 'input-xlarge'));                                    
                                    ?> 
                                </div>

                            </div>
                        </div><!-- /baseDetailBox -->
					</div><!-- /cnt-box -->
                
                    <div class="cnt-box">
                    <p class="descriptionTxt">部署&amp;メンバー紹介ページと、マジメのポータルトップページの今週の部署紹介に反映されます。</p>
                
                        <div class="baseDetailBox">
                            <div class="textBox clearfix">
                                
                                <div class="control-group">
                                    <label class="control-label" for="field_copy">自動選出除外&nbsp;</label>
                                    <div class="controls">
                                        <label class="checkbox">
                                        <?php echo $form->checkBox($model,'cancel_random'); ?>&nbsp;今週の部署紹介による自動選出から除外する
                                        </label>
                                    </div>
                                </div>
                                <div class="control-group">
	                                <label class="control-label" for="introduceTtl">紹介タイトル&nbsp;</label>
	                                <div class="controls">
                                         <?php echo $form->error($model, 'catchphrase'); ?>
                    	                 <?php echo $form->textField($model, 'catchphrase', array('class' => 'input-xxlarge')); ?>
	                                </div>
	                            </div>
                                <div class="control-group">
                                   <label class="control-label" for="introduceTxt">紹介文&nbsp;</label>
                                    <div class="controls">
                                        <?php echo $form->error($model, 'introduction'); ?>
                        	            <?php echo $form->textarea($model, 'introduction', array('class' => 'input-xxlarge', 'rows' => 7, 'maxlength' => 2000)); ?> 
                                    </div>
                                </div>
                               
                            <?php 
                            $attachements = $this->beginWidget('ext.helpers.Form_new');
                            $attachements->regist11($model, $form,$attachment1_error,$attachment2_error,$attachment3_error,'adminbase',$this->assetsBase);
                            $this->endWidget();
                            ?>
                            </div><!-- /taxtBox -->
                        </div><!-- /baseDetailBox -->
                        
                    </div><!-- /cnt-box -->
 					<?php $this->endWidget(); ?>
                    <div class="form-last-btn">
                        <p class="btn80">
                            <button type="submit" class="btn btn-important"><i class="icon-chevron-right icon-white">　</i> 確認</button>
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
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>
	  </div><!-- /container -->
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
	</div>
</div><!-- /wrap -->
<script type="text/javascript"> 
       
        jQuery(function($){
         $('input[type="checkbox"]').click (function (){    
             if($(this).attr("id")!=undefined && $(this).attr("id")=="Unit_cancel_random"){
                 return;
             }
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
            
         $("#unit_form").attr('action','<?php echo Yii::app()->baseUrl;?>/adminbase/registconfirm/?base_id=<?php echo $_GET['base_id']?>');        
            
			//check back browser 
		   unit_branch_id=getCookie("unit_regist_branch_id");
		   if(unit_branch_id!=null&&unit_branch_id!="null"){
			   $("#Unit_branch_id").val(unit_branch_id);
		   }
		   else{
               jQuery('#err1').remove();
               jQuery('#err2').remove();
               jQuery('#err3').remove();
               jQuery('#photo_error').remove();
           }	    
		   unit_office_id=getCookie("unit_regist_office_id");
		   if(unit_office_id!=null&&unit_office_id!="null"){
			   $("#Unit_office_id").val(unit_office_id);
		   }
		   unit_name=getCookie("unit_regist_unit_name");
		   if(unit_name!=null&&unit_name!="null"){
			   $("#Unit_unit_name").val(unit_name);
		   }
           
           unit_mailaddr=getCookie("unit_regist_mailaddr");
           if(unit_mailaddr!=null&&unit_mailaddr!="null")
		   {
               $("#Unit_mailaddr").val(unit_mailaddr);
           }
           unit_tel=getCookie("unit_regist_tel_number");
           if(unit_tel!=null&&unit_tel!="null")
		   {
               $("#Unit_tel_number").val(unit_tel);
           }
           unit_regist_cancel_random=getCookie("unit_regist_cancel_random");
           if(unit_regist_cancel_random!=null&&unit_regist_cancel_random!="null"){
		   if(unit_regist_cancel_random=='1'){
                   $("#Unit_cancel_random").attr('checked',true);
            }
            else{
                $("#Unit_cancel_random").attr('checked',false);
            }
       }
           unit_catchphrase=getCookie("unit_regist_catchphrase");
           if(unit_catchphrase!=null&&unit_catchphrase!="null"){
               $("#Unit_catchphrase").val(unit_catchphrase);
           }
		    unit_introduction=getCookie("unit_regist_introduction");           
           if(unit_introduction!=null&&unit_introduction!="null"){
				
			   introduction1=unit_introduction.replace(/<br ?\/?>|_/g, '\n');	
               $("#Unit_introduction").val(introduction1);
           }
			
		    attachment1_checkbox_for_deleting=getCookie("unit_regist_attachment1_checkbox_for_deleting");
           if(attachment1_checkbox_for_deleting!=null&&attachment1_checkbox_for_deleting!="null"){              
               if(attachment1_checkbox_for_deleting=='1'){
                   $("#Unit_attachment1_checkbox_for_deleting").attr('checked',true);
               }
               else{
                   $("#Unit_attachment1_checkbox_for_deleting").attr('checked',false);
               }
              
           }
           attachment2_checkbox_for_deleting=getCookie("unit_regist_attachment2_checkbox_for_deleting");
           if(attachment2_checkbox_for_deleting!=null&&attachment2_checkbox_for_deleting!="null"){
               if(attachment2_checkbox_for_deleting=='1'){
                   $("#Unit_attachment2_checkbox_for_deleting").attr('checked',true);
               }
               else{
                   $("#Unit_attachment2_checkbox_for_deleting").attr('checked',false);
               }
           }
           attachment3_checkbox_for_deleting=getCookie("unit_regist_attachment3_checkbox_for_deleting");
           if(attachment3_checkbox_for_deleting!=null&&attachment3_checkbox_for_deleting!="null"){
               if(attachment3_checkbox_for_deleting=='1'){
                   $("#Unit_attachment3_checkbox_for_deleting").attr('checked',true);
               }
               else{
                   $("#Unit_attachment3_checkbox_for_deleting").attr('checked',false);
               }
           
             
           }
           
		   
           $("body").attr('id','admin');    
           
           $('button[type="submit"]').click(function(){ 
               no=2;            
           
            deleteCookies("unit_regist_from");
			
			$.ajax({    
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/adminbase/regist/?base_id=<?php echo $_GET['base_id']?>",    
				data: jQuery('#unit_form').serialize(),
				success: function(msg)
				{	     
					 
					  jQuery('#Unit_branch_id').prev().remove(); 
					  jQuery('#Unit_office_id').prev().remove(); 
                      jQuery('#Unit_unit_name').prev().remove();    
                      jQuery('#Unit_mailaddr').prev().remove();  
					  jQuery("#error_message1").html("").removeClass("alert error_message");                    
					  jQuery('#photo_error').remove();
					 
					  	if(msg!='[]'|checkFile()==false)
					    {
							data=$.parseJSON(msg);
							
							if(data.Unit_branch_id){
                                 div=document.createElement('div');
                                 $(div).addClass('alert');
                                 $(div).addClass('error_message');
                                 $(div).html(data.Unit_branch_id);
                                 $(div).insertBefore($('#Unit_branch_id'));
                                                         
                            } 
							if(data.Unit_office_id){
                                 div=document.createElement('div');
                                 $(div).addClass('alert');
                                 $(div).addClass('error_message');
                                 $(div).html(data.Unit_office_id);
                                 $(div).insertBefore($('#Unit_office_id'));
                                                         
                            } 
                            if (data.Unit_mailaddr) {
                                div = document.createElement('div');
                                $(div).addClass('alert');
                                $(div).addClass('error_message');
                                $(div).html(data.Unit_mailaddr);
                                $(div).insertBefore($('#Unit_mailaddr'));
                            }
                            $('html, body').animate({scrollTop:0}, 'slow');   
					  }							  															
					  else
					  {   
					   	   setCookie("unit_regist_branch_id",$("#Unit_branch_id").val());
						   setCookie("unit_regist_office_id",$("#Unit_office_id").val());	
                           setCookie("unit_regist_unit_name",$("#Unit_unit_name").val());
                           setCookie("unit_regist_mailaddr",$("#Unit_mailaddr").val());
                           setCookie("unit_regist_tel_number",$("#Unit_tel_number").val());
						   setCookie("unit_regist_catchphrase",$("#Unit_catchphrase").val());
						   val=$("#Unit_introduction").val();
						   val=val.replace(/\n/g, "<br/>");
						   setCookie("unit_regist_introduction",val);
                       
							if($("#Unit_attachment1_checkbox_for_deleting").attr('checked')==true){
								setCookie("unit_regist_attachment1_checkbox_for_deleting",'1');
							}
							else{
								setCookie("unit_regist_attachment1_checkbox_for_deleting",'0');
							}
							if($("#Unit_attachment2_checkbox_for_deleting").attr('checked')==true){
								setCookie("unit_regist_attachment2_checkbox_for_deleting",'1');
							}
							else{
								setCookie("unit_regist_attachment2_checkbox_for_deleting",'0');
							}
							if($("#Unit_attachment3_checkbox_for_deleting").attr('checked')==true){
								setCookie("unit_regist_attachment3_checkbox_for_deleting",'1');
							}
							else{
								setCookie("unit_regist_attachment3_checkbox_for_deleting",'0');
							}
                                                        if($("#Unit_cancel_random").is(':checked')){
                                    setCookie("unit_regist_cancel_random",'1');
                            }
                            else{
                                    setCookie("unit_regist_cancel_random",'0');
                            }
							
						jQuery('#unit_form').submit();					  
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
    var checkBox1  = jQuery('#Unit_attachment1_checkbox_for_deleting').is(":checked");
    var checkBox2  = jQuery('#Unit_attachment2_checkbox_for_deleting').is(":checked");
    var checkBox3  = jQuery('#Unit_attachment3_checkbox_for_deleting').is(":checked");


    //check format file
    var arr_file	   = [".zip", ".doc", ".docx", ".xls" , ".xlsx" , ".ppt" , ".pptx" , ".pdf" , ".rar" , ".jpg" , ".gif", ".png", ".jpeg"];			
    var arr_file1	   = [".jpg" , ".gif", ".png", ".jpeg"];			
    var attachment1 = jQuery('#Unit_attachment1').val();

    checkFile1	   = attachment1.substr(attachment1.lastIndexOf('.'));
    checkFile1	   = checkFile1.toLowerCase();

    var attachment2 = jQuery('#Unit_attachment2').val();
    checkFile2	   = attachment2.substr(attachment2.lastIndexOf('.'));
    checkFile2	   = checkFile2.toLowerCase();

    var attachment3 = jQuery('#Unit_attachment3').val();

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
