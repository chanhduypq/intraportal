<link href="<?php echo $this->assetsBase; ?>/css/common/css/report.css" rel="stylesheet"  media="screen" />




<div class="wrap admin secondary report">
    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>リアルタイム社内報告 - 修正</h2>
                <span>
					<?php if(!empty(Yii::app()->request->cookies['page'])): ?>	
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminreport/index?page=<?php echo Yii::app()->request->cookies['page']?>" class="btn btn-important">
							<i class="icon-chevron-left icon-white"></i> 一覧に戻る
						</a>
					<?php else : ?>
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminreport" class="btn btn-important">
							<i class="icon-chevron-left icon-white"></i> 一覧に戻る
						</a>
					<?php endif; ?>
				</span>
                </div>
                <div class="box">
					 <?php $form = $this->beginWidget('CActiveForm', array(
						'id' => 'report_edit',                     
						'htmlOptions' => array(
											  'enctype' => 'multipart/form-data',
											  'class'=>'form-horizontal',                                          
											  ),));?>

					<?php echo $form->hiddenField($model, 'id'); ?>  
					<div class="cnt-box">
						<div class="control-group">
							<label class="control-label" for="inputEmail">アイコン&nbsp;
								<span class="label label-warning">必須</span>
							</label>
							<div class="controls">
								<div>
									<label class="radio inline">
										<?php echo $form->radioButton($model,'icon',array('value'=>1, 'uncheckValue' => null,"id"=>"rdIcon1")); ?>
										<span class="ico help">HELP</span>
									</label>
									<label class="radio inline">
										<?php echo $form->radioButton($model,'icon',array('value'=>2, 'uncheckValue' => null,"id"=>"rdIcon2")); ?>
										<span class="ico eigyou">営業</span>
									</label>
									<label class="radio inline">
										<?php echo $form->radioButton($model,'icon',array('value'=>3, 'uncheckValue' => null,"id"=>"rdIcon3")); ?>
										<span class="ico uwasa">うわさ</span>
									</label>
									<label class="radio inline">
										<?php echo $form->radioButton($model,'icon',array('value'=>4, 'uncheckValue' => null,"id"=>"rdIcon4")); ?>
										<span class="ico seizou">製造</span>
									</label>
								</div>
								<div>
									<label class="radio inline">
										<?php echo $form->radioButton($model,'icon',array('value'=>5, 'uncheckValue' => null,"id"=>"rdIcon5")); ?>
										<span class="ico gyousei">行政</span>
									</label>
									<label class="radio inline">
										<?php echo $form->radioButton($model,'icon',array('value'=>6, 'uncheckValue' => null,"id"=>"rdIcon6")); ?>
										<span class="ico hall">ホール</span>
									</label>
									<label class="radio inline">
										<?php echo $form->radioButton($model,'icon',array('value'=>7, 'uncheckValue' => null,"id"=>"rdIcon7")); ?>
										<span class="ico kaihatsu">開発</span>
									</label>
									<label class="radio inline">
										<?php echo $form->radioButton($model,'icon',array('value'=>8, 'uncheckValue' => null,"id"=>"rdIcon8")); ?>
										<span class="ico other">他</span>
									</label>
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
							<?php $attachements = $this->beginWidget('ext.helpers.Form_new');?>                   
							<?php $attachements->edit11($model, $form,'adminreport',$attachment1_error,$attachment2_error,$attachment3_error,$this->assetsBase); ?>                      
							<?php $this->endWidget(); ?>
						</div>
						
					</div>
					<!-- /cnt-box -->
					<?php $this->endWidget(); ?>
					<div class="form-last-btn">
						<p class="btn80">
							<button type="submit" class="btn btn-important">
								<i class="icon-chevron-right icon-white">　</i> 確認
							</button>
						</p>
					</div>
            
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
            
  </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
</div>

</div><!-- /wrap -->
<script type="text/javascript"> 
  
	
	//Method using check id report 
	function checkId(id)
	{
		
		$.ajax({   
			type: "POST", 
			async:true,
			url: "<?php echo Yii::app()->baseUrl;?>/index.php/adminreport/checkId/",    
			data:{id:id},
			success: function(msg)
			{	        
				if(msg=='0')
				{ 
					window.location.href="<?php echo Yii::app()->baseUrl;?>/adminreport/index";
				}
			}
		});
	}
	
	function checkFile()
	{
    
		var result	 = true;
		$("#error_message1").html("");
		$("#error_message1").removeClass("cerrorMessage alert error_message");
		$("#error_message2").html("");
		$("#error_message2").removeClass("cerrorMessage alert error_message");
		$("#error_message3").html("");
		$("#error_message3").removeClass("cerrorMessage alert error_message");
		$(".error_message").html("");
		$("div").removeClass("cerrorMessage alert error_message");
		var checkBox1  = jQuery('#Report_attachment1_checkbox_for_deleting').is(":checked");
		var checkBox2  = jQuery('#Report_attachment2_checkbox_for_deleting').is(":checked");
		var checkBox3  = jQuery('#Report_attachment3_checkbox_for_deleting').is(":checked");

		//check format file
		var arr_file	   = [".zip", ".doc", ".docx", ".xls" , ".xlsx" , ".ppt" , ".pptx" , ".pdf" , ".rar" , ".jpg" , ".gif", ".png", ".jpeg"];			
		var attachment1 = jQuery('#Report_attachment1').val();

		checkFile1	   = attachment1.substr(attachment1.lastIndexOf('.'));
		checkFile1	   = checkFile1.toLowerCase();

		var attachment2 = jQuery('#Report_attachment2').val();
		checkFile2	   = attachment2.substr(attachment2.lastIndexOf('.'));
		checkFile2	   = checkFile2.toLowerCase();

		var attachment3 = jQuery('#Report_attachment3').val();

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

	jQuery(function($)
	{  
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
	    $("body").attr('id','admin');
	    $("#report_edit").attr('action', '<?php echo Yii::app()->baseUrl; ?>/adminreport/editconfirm/');  
		 
		type=getCookie("report_edit_icon");
		if(type!=null && type !="null")
		{
			type=parseInt(type);
			switch(type)
			{
				case 1:
				  $("#rdIcon1").attr('checked',true);
				  break;
				case 2:
				  $("#rdIcon2").attr('checked',true);
				  break;
				case 3:
				  $("#rdIcon3").attr('checked',true);
				  break;
				case 4:
				  $("#rdIcon4").attr('checked',true);
				  break; 
				case 5:
				  $("#rdIcon5").attr('checked',true);
				  break; 
				case 6:
				  $("#rdIcon6").attr('checked',true);
				  break; 
				case 7:
				  $("#rdIcon7").attr('checked',true);
				  break;
				case 8:
				  $("#rdIcon8").attr('checked',true);
				  break; 	
			}
			//$("#Report_icon").val(type);
		}
		
		
		
		title=getCookie("report_edit_title");
		if(title!=null && title!="null")
		{
			$("#Report_title").val(title);
		}
		else{
                   jQuery('#err1').remove();
                   jQuery('#err2').remove();
                   jQuery('#err3').remove();
                
               }
		content=getCookie("report_edit_content");
		if(content!=null && content!="null")
		{
			content1=content.replace(/<br ?\/?>|_/g, '\n');
			$("#Report_content").val(content1);
		}
		
		attachment1_checkbox_for_deleting=getCookie("report_edit_attachment1_checkbox_for_deleting");
	    if(attachment1_checkbox_for_deleting!=null&&attachment1_checkbox_for_deleting!="null")
	    {              
		   if(attachment1_checkbox_for_deleting=='1')
		   {
			   $("#Report_attachment1_checkbox_for_deleting").attr('checked',true);
                           $fileInput=$("#Report_attachment1_checkbox_for_deleting").parent().parent().prev().find('input[type="file"]').eq(0);
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
                  $node1=$("#Report_attachment1_checkbox_for_deleting").parent().parent().prev().prev();
                  $node1.remove();
                  $('<img alt="" src="<?php echo $this->assetsBase; ?>/css/common/img/img_photo01.jpg">').insertBefore($("#Report_attachment1_checkbox_for_deleting").parent().parent().prev());
		   }
		   else
		   {
			   $("#Report_attachment1_checkbox_for_deleting").attr('checked',false);
		   }
	    }
		
        attachment2_checkbox_for_deleting=getCookie("report_edit_attachment2_checkbox_for_deleting");
        if(attachment2_checkbox_for_deleting!=null&&attachment2_checkbox_for_deleting!="null")
		{
               if(attachment2_checkbox_for_deleting=='1')
			   {
                   $("#Report_attachment2_checkbox_for_deleting").attr('checked',true);
                   $fileInput=$("#Report_attachment2_checkbox_for_deleting").parent().parent().prev().find('input[type="file"]').eq(0);
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
                  $node1=$("#Report_attachment2_checkbox_for_deleting").parent().parent().prev().prev();
                  $node1.remove();
                  $('<img alt="" src="<?php echo $this->assetsBase; ?>/css/common/img/img_photo01.jpg">').insertBefore($("#Report_attachment2_checkbox_for_deleting").parent().parent().prev());
               }
               else
			   {
                   $("#Report_attachment2_checkbox_for_deleting").attr('checked',false);
               }
        }
	   
	   attachment3_checkbox_for_deleting=getCookie("report_edit_attachment3_checkbox_for_deleting");
	   if(attachment3_checkbox_for_deleting!=null&&attachment3_checkbox_for_deleting!="null")
	   {
		   if(attachment3_checkbox_for_deleting=='1')
		   {
			   $("#Report_attachment3_checkbox_for_deleting").attr('checked',true);
                           $fileInput=$("#Report_attachment3_checkbox_for_deleting").parent().parent().prev().find('input[type="file"]').eq(0);
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
                  $node1=$("#Report_attachment3_checkbox_for_deleting").parent().parent().prev().prev();
                  $node1.remove();
                  $('<img alt="" src="<?php echo $this->assetsBase; ?>/css/common/img/img_photo01.jpg">').insertBefore($("#Report_attachment3_checkbox_for_deleting").parent().parent().prev());
		   }
		   else
		   {
			   $("#Report_attachment3_checkbox_for_deleting").attr('checked',false);
		   }
	   }
		
		
		
	   $('button[type="submit"]').click(function()
	   {   
           no=2;            
           
		   if ($("#rdIcon1").is(":checked"))
			{
				setCookie("report_reg_icon",'1');
			}
			if ($("#rdIcon2").is(":checked"))
			{
				setCookie("report_reg_icon",'2');
			}
			if ($("#rdIcon3").is(":checked"))
			{
				setCookie("report_reg_icon",'3');
			}
			if ($("#rdIcon4").is(":checked"))
			{
				setCookie("report_reg_icon",'4');
			}
			if ($("#rdIcon5").is(":checked"))
			{
				setCookie("report_reg_icon",'5');
			}
			if ($("#rdIcon6").is(":checked"))
			{
				setCookie("report_reg_icon",'6');
			}
			if ($("#rdIcon7").is(":checked"))
			{
				setCookie("report_reg_icon",'7');
			}
			if ($("#rdIcon8").is(":checked"))
			{
				setCookie("report_reg_icon",'8');
			}
		   
		   deleteCookies("report_edit_form");  
		   var id = $('#Report_id').val();	
		   if(!checkId(id)){ }
	   
			$.ajax
			({    
					type: "POST", 
					async:true,
					url: "<?php echo Yii::app()->baseUrl;?>/adminreport/edit/?id=<?php echo $model->id;?>",    
					data: jQuery('#report_edit').serialize(),
					success: function(msg)
					{	            
					    jQuery('#Report_title').prev().remove();                                       						                                            					  	
					    jQuery('#Report_content').prev().remove(); 	
						if(msg!='[]' | !checkFile())
						{
							data=$.parseJSON(msg);
							if(data.Report_title)
							{	
								div=document.createElement('div');
								$(div).addClass('alert');
								$(div).addClass('error_message');
								$(div).html(data.Report_title);
								$(div).insertBefore($('#Report_title')); 
							} 
							if(data.Report_content)
						    {
								div=document.createElement('div');
								$(div).addClass('alert');
								$(div).addClass('error_message');
								$(div).html(data.Report_content);
								$(div).insertBefore($('#Report_content')); 
							} 	 
					}		
					else
					{
						//setCookie("report_edit_icon",$("#Report_icon").val());
						setCookie("report_edit_title",$("#Report_title").val());
                        val=$("#Report_content").val();
						val=val.replace(/\n/g, "<br/>");
                        setCookie("report_edit_content",val);
						
						if($("#Report_attachment1_checkbox_for_deleting").attr('checked')==true)
						{
                           setCookie("report_edit_attachment1_checkbox_for_deleting",'1');
                        }
						else
						{
							setCookie("report_edit_attachment1_checkbox_for_deleting",'0');
						}
						if($("#Report_attachment2_checkbox_for_deleting").attr('checked')==true)
						{
							setCookie("report_edit_attachment2_checkbox_for_deleting",'1');
						}
						else
						{
							setCookie("report_edit_attachment2_checkbox_for_deleting",'0');
						}
						if($("#Report_attachment3_checkbox_for_deleting").attr('checked')==true)
						{
							setCookie("report_edit_attachment3_checkbox_for_deleting",'1');
						}
						else
						{
							setCookie("report_edit_attachment3_checkbox_for_deleting",'0');
						}
						jQuery('#report_edit').submit();
					}
				}	  
			});
		
		});
 
    });
</script>
    