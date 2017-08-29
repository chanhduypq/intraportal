




<div class="wrap admin secondary newitems">
  <div class="container">
    <div class="contents index">
      <div class="mainBox detail">
        <div class="pageTtl">
          <h2>新商品情報 - 修正</h2>
          <span>
          	<?php 
					if(Yii::app()->request->cookies['page']!= "") 
					{
						   $page = "index?page=".Yii::app()->request->cookies['page'];
							
					}else {$page ="";}
					?>
			  <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminnewitem/<?php echo $page;?>" class="btn btn-important">
					<i class="icon-chevron-left icon-white"></i> 一覧に戻る
			  </a>
			
          </span>
        </div>
        <div class="box">
		 <?php $form = $this->beginWidget('CActiveForm', array(
					'id' => 'newitem_edit',                     
					'htmlOptions' => array(
										  'enctype' => 'multipart/form-data',
										  'class'=>'form-horizontal',                                          
										  ),));?>

		<?php echo $form->hiddenField($model, 'id'); ?>  
            <div class="cnt-box">
              <div class="control-group">
                <label class="control-label" for="inputEmail">種別&nbsp; 
                  <span class="label label-warning">必須</span>
                </label>
                <div class="controls">
					<?php echo $form->radioButtonList($model, 'type',Constants::$typeNewItem,array('labelOptions'=>array('style'=>'display:inline'),'separator'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',));?>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="title">タイトル&nbsp; 
                  <span class="label label-warning">必須</span>
                </label>
                <div class="controls">
                   <?php echo $form->textField($model, 'title', array('placeholder' => 'タイトルを入力してください。[25文字]', 'class' => 'input-xxlarge')); ?>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="content">内容(or URL)&nbsp; 
                  <span class="label label-warning">必須</span>
                </label>
                <div class="controls">
				  <?php echo $form->textarea($model, 'content', array('placeholder' => '本文を入力してください。', 'class' => 'input-xxlarge', 'rows' => 7,'maxlength' => 3000)); ?>               
                </div>
              </div>
			   <div class="field attachements">
				<?php $attachements = $this->beginWidget('ext.helpers.Form_new');?>                   
				<?php $attachements->edit11($model, $form,'adminnewitem',$attachment1_error,$attachment2_error,$attachment3_error,$this->assetsBase); ?>                      
				<?php $this->endWidget(); ?>
			  </div>
            </div>
            <!-- /cnt-box -->
			<?php $this->endWidget(); ?>
            <div class="form-last-btn">
              <p class="btn80">
               	<button type="submit" class="btn btn-important">
                  <i class="icon-chevron-right icon-white">　</i>確認
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
      </div>
      <!-- /sideBox -->
    </div>
    <!-- /contents -->
    <p id="page-top">
      <a href="#wrap">PAGE TOP</a>
    </p>
  </div>
  <!-- /container -->
  <div class="footer">
    <p>COPYRIGHT (C) Newgin ALL RIGHTS RESERVED.</p>
  </div>
</div>
<!-- /wrap -->
<script type="text/javascript">   
	//Method using check id bounty 
	function checkId(id)
	{
		
		$.ajax({   
			type: "POST", 
			async:true,
			url: "<?php echo Yii::app()->baseUrl;?>/adminnewitem/checkId/",    
			data:{id:id},
			success: function(msg)
			{	        
				if(msg=='0')
				{ 
					window.location.href="<?php echo Yii::app()->baseUrl;?>/adminnewitem/index";
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
		var checkBox1  = jQuery('#NewItem_attachment1_checkbox_for_deleting').is(":checked");
		var checkBox2  = jQuery('#NewItem_attachment2_checkbox_for_deleting').is(":checked");
		var checkBox3  = jQuery('#NewItem_attachment3_checkbox_for_deleting').is(":checked");

		//check format file
		var arr_file	   = [".zip", ".doc", ".docx", ".xls" , ".xlsx" , ".ppt" , ".pptx" , ".pdf" , ".rar" , ".jpg" , ".gif", ".png", ".jpeg"];			
		var attachment1 = jQuery('#NewItem_attachment1').val();

		checkFile1	   = attachment1.substr(attachment1.lastIndexOf('.'));
		checkFile1	   = checkFile1.toLowerCase();

		var attachment2 = jQuery('#NewItem_attachment2').val();
		checkFile2	   = attachment2.substr(attachment2.lastIndexOf('.'));
		checkFile2	   = checkFile2.toLowerCase();

		var attachment3 = jQuery('#NewItem_attachment3').val();

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
		 $('input[type="checkbox"]').click (function ()
		 {            
			  if ($(this).is (':checked'))
			  { 
				  $fileInput=$(this).parent().parent().prev().find('input[type="file"]').eq(0);
				  name=$fileInput.attr('name');
				  id=$fileInput.attr('id');
				  classAttr=$fileInput.attr('class'); 
				  if(name==undefined)
				  {
					  name="";
				  }
				  if(id==undefined)
				  {
					  id="";
				  }
				  if(classAttr==undefined)
				  {
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
 
	    $("#newitem_edit").attr('action', '<?php echo Yii::app()->baseUrl; ?>/adminnewitem/editconfirm/');  
		 
	    type=getCookie("newitem_edit_type");
		if(type!=null && type !="null")
		{
			 if(type=='1')
			 {
				 $("#NewItem_type_0").attr('checked',true);
			 }
			 else
			 {
				 $("#NewItem_type_1").attr('checked',true);
			 }
			
		}
		
		title=getCookie("newitem_edit_title");
		if(title!=null && title!="null" && title!= 'undefined')
		{
			$("#NewItem_title").val(title);
		}
        else
		{
		   jQuery('#err1').remove();
		   jQuery('#err2').remove();
		   jQuery('#err3').remove();
        }
		
		content=getCookie("newitem_edit_content");
		if(content!=null && content!="null")
		{
			content1=content.replace(/<br ?\/?>|_/g, '\n');
			$("#NewItem_content").val(content1);
		}
	
		attachment1_checkbox_for_deleting=getCookie("newitem_edit_attachment1_checkbox_for_deleting");
	    if(attachment1_checkbox_for_deleting!=null&&attachment1_checkbox_for_deleting!="null")
	    {              
		   if(attachment1_checkbox_for_deleting=='1')
		   {
				  $("#NewItem_attachment1_checkbox_for_deleting").attr('checked',true);
                  $fileInput=$("#NewItem_attachment1_checkbox_for_deleting").parent().parent().prev().find('input[type="file"]').eq(0);
                  name=$fileInput.attr('name');
                  id=$fileInput.attr('id');
                  classAttr=$fileInput.attr('class');
                  
                  if(name==undefined)
				  {
                      name="";
                  }
                  if(id==undefined)
				  {
                      id="";
                  }
                  if(classAttr==undefined)
				  {
                      classAttr="";
                  }
                  $fileInput.replaceWith("<input type='file' name='"+name+"' id='"+id+"' class='"+classAttr+"'/>");
                  //
                  $node1=$("#NewItem_attachment1_checkbox_for_deleting").parent().parent().prev().prev();
                  $node1.remove();
                  $('<img alt="" src="<?php echo $this->assetsBase; ?>/css/common/img/img_photo01.jpg">').insertBefore($("#NewItem_attachment1_checkbox_for_deleting").parent().parent().prev());
		   }
		   else
		   {
			   $("#NewItem_attachment1_checkbox_for_deleting").attr('checked',false);
		   }
	    }
		
        attachment2_checkbox_for_deleting=getCookie("newitem_edit_attachment2_checkbox_for_deleting");
        if(attachment2_checkbox_for_deleting!=null&&attachment2_checkbox_for_deleting!="null")
		{
               if(attachment2_checkbox_for_deleting=='1')
			   {
                  $("#NewItem_attachment2_checkbox_for_deleting").attr('checked',true);
                  $fileInput=$("#NewItem_attachment2_checkbox_for_deleting").parent().parent().prev().find('input[type="file"]').eq(0);
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
                  $node1=$("#NewItem_attachment2_checkbox_for_deleting").parent().parent().prev().prev();
                  $node1.remove();
                  $('<img alt="" src="<?php echo $this->assetsBase; ?>/css/common/img/img_photo01.jpg">').insertBefore($("#NewItem_attachment2_checkbox_for_deleting").parent().parent().prev());
               }
               else
			   {
                   $("#NewItem_attachment2_checkbox_for_deleting").attr('checked',false);
               }
       }
	   
	   attachment3_checkbox_for_deleting=getCookie("newitem_edit_attachment3_checkbox_for_deleting");
	   if(attachment3_checkbox_for_deleting!=null&&attachment3_checkbox_for_deleting!="null")
	   {
		   if(attachment3_checkbox_for_deleting=='1')
		   {
			   $("#NewItem_attachment3_checkbox_for_deleting").attr('checked',true);
                  $fileInput=$("#NewItem_attachment3_checkbox_for_deleting").parent().parent().prev().find('input[type="file"]').eq(0);
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
                  $node1=$("#NewItem_attachment3_checkbox_for_deleting").parent().parent().prev().prev();
                  $node1.remove();
                  $('<img alt="" src="<?php echo $this->assetsBase; ?>/css/common/img/img_photo01.jpg">').insertBefore($("#NewItem_attachment3_checkbox_for_deleting").parent().parent().prev());
		   }
		   else
		   {
			   $("#NewItem_attachment3_checkbox_for_deleting").attr('checked',false);
		   }
	   }

	   $('button[type="submit"]').click(function()
	   {  
		   no=2;
		   deleteCookies("newitem_edit_form");  

		   var id = $('#NewItem_id').val();	
		   if(!checkId(id)){ }

		   $.ajax
			({    
					type: "POST", 
					async:true,
					url: "<?php echo Yii::app()->baseUrl;?>/adminnewitem/edit/?id=<?php echo $model->id;?>",    
					data: jQuery('#newitem_edit').serialize(),
					success: function(msg)
					{	            
		
					    jQuery('#NewItem_title').prev().remove();                                       						                                            					  	
					    jQuery('#NewItem_content').prev().remove(); 	
						if(msg!='[]' | !checkFile())
						{
							data=$.parseJSON(msg);
							if(data.NewItem_title)
							{	
								div=document.createElement('div');
								$(div).addClass('alert');
								$(div).addClass('error_message');
								$(div).html(data.NewItem_title);
								$(div).insertBefore($('#NewItem_title')); 
							} 
							if(data.NewItem_content)
						    {
								div=document.createElement('div');
								$(div).addClass('alert');
								$(div).addClass('error_message');
								$(div).html(data.NewItem_content);
								$(div).insertBefore($('#NewItem_content')); 
							}
							if(data.NewItem_content!="" && data.NewItem_content=='2' && !checkURL(data.NewItem_content))
							{
								div=document.createElement('div');
								$(div).addClass('alert');
								$(div).addClass('error_message');
								$(div).html("<?php echo Lang::MSG_0007?>");
								$(div).insertBefore($('#NewItem_content'));	
							}
						}		
						else
						{
							var type=$("#newitem_edit input[type='radio']:checked").val();	
							setCookie("newitem_edit_type",type);
							setCookie("newitem_edit_title",$("#NewItem_title").val());
							val=$("#NewItem_content").val();
							val=val.replace(/\n/g, "<br/>");
							setCookie("newitem_edit_content",val);
							
							if($("#NewItem_attachment1_checkbox_for_deleting").attr('checked')==true)
							{
								setCookie("newitem_edit_attachment1_checkbox_for_deleting",'1');
							}
							else
							{
								setCookie("newitem_edit_attachment1_checkbox_for_deleting",'0');
							}
							if($("#NewItem_attachment2_checkbox_for_deleting").attr('checked')==true)
							{
								setCookie("newitem_edit_attachment2_checkbox_for_deleting",'1');
							}
							else
							{
								setCookie("newitem_edit_attachment2_checkbox_for_deleting",'0');
							}
							if($("#NewItem_attachment3_checkbox_for_deleting").attr('checked')==true)
							{
								setCookie("newitem_edit_attachment3_checkbox_for_deleting",'1');
							}
							else
							{
								setCookie("newitem_edit_attachment3_checkbox_for_deleting",'0');
							}
							if(type=='2' && !checkURL($("#NewItem_content").val()))
							{
								div=document.createElement('div');
								$(div).addClass('alert');
								$(div).addClass('error_message');
								$(div).html("<?php echo Lang::MSG_0007?>");
								$(div).insertBefore($('#NewItem_content'));	
							}
							else
							{
								jQuery('#newitem_edit').submit();
							}
						}
				}	  
			});
		
		});
 
    });	
function checkURL(value) 
{
    var urlregex = new RegExp("^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
    if (urlregex.test(value)) 
	{
        return (true);
    }
    return (false);
}	
</script>