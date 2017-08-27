<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>
<div class="wrap admin secondary hobby_new">

    <div class="container">
        <div class="contents edit">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
				<h2>趣味・サークルの広場What'sNew - 修正</h2>
					<span>
						<?php if(!empty(Yii::app()->request->cookies['page'])): ?>	
						  <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminhobby_new/index?page=<?php echo Yii::app()->request->cookies['page']?>" class="btn btn-important">
								<i class="icon-chevron-left icon-white"></i> 一覧に戻る
						  </a>
						<?php else : ?>
						  <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminhobby_new" class="btn btn-important">
							<i class="icon-chevron-left icon-white"></i> 一覧に戻る
						  </a>
						<?php endif; ?>
					</span>
                </div>
                <div class="box">
                <?php $form = $this->beginWidget('CActiveForm', array(
					'id' => 'hobby_new_edit',                     
					'htmlOptions' => array(
										  'enctype' => 'multipart/form-data',
										  'class'=>'form-horizontal',                                          
										  ),));?>

				<?php echo $form->hiddenField($model, 'id'); ?>  
                <div class="cnt-box">
                    <div class="control-group">
                        <label class="control-label">カテゴリー</label>
                        <div class="controls">
							<ul class="inline">	
									<?php $categories=Yii::app()->db->createCommand()
										   ->select('*')
										   ->from('category')
										   ->where('type=6')
										   ->queryAll();?>
									 <?php if(!is_null($categories)):?>
										<?php foreach($categories as $category): ?>
											<li>
											<label class="radio inline">
												<?php echo $form->radioButton($model,'category_id',array('value'=>$category['id'], 'uncheckValue' => null,"id"=>'cat'.$category['id'])); ?>
												<span class="label" style="background-color:<?php echo $category['background_color']?>; color:<?php echo $category['text_color']?>">
													<?php echo $category['category_name']?>
												</span>
											</label>
											</li>
										<?php endforeach; ?>
								<?php endif; ?>
							</ul>	
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
					<?php $attachements = $this->beginWidget('ext.helpers.Form_new');
							  $attachements->edit11($model, $form,'adminhobby_new',$attachment1_error,$attachment2_error,$attachment3_error,$this->assetsBase);                        
							  $this->endWidget();?>
					</div>
                    
                </div><!-- /cnt-box -->
                <?php $this->endWidget(); ?>
                <div class="form-last-btn">
					<p class="btn80">
						<button type="submit" class="btn btn-important">
						  <i class="icon-chevron-right icon-white">　</i>確認
						</button>
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

	//Method using check id category
	function checkCategory(id)
	{
		$.ajax({   
			type: "POST", 
			async:true,
			url: "<?php echo Yii::app()->baseUrl;?>/adminhobby_new/checkcategory/",    
			data:{id:id},
			success: function(msg)
			{	        
				if(msg=='0')
				{ 
					window.location.href="<?php echo Yii::app()->baseUrl;?>/adminhobby_new/index";
				}
			}
		});
	}
	
	//Method using check id hobby_new
	function checkId(id)
	{
		$.ajax({   
			type: "POST", 
			async:true,
			url: "<?php echo Yii::app()->baseUrl;?>/adminhobby_new/checkId/",    
			data:{id:id},
			success: function(msg)
			{	        
				if(msg=='0')
				{ 
					window.location.href="<?php echo Yii::app()->baseUrl;?>/adminhobby_new/index";
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
		var checkBox1  = jQuery('#Hobby_new_attachment1_checkbox_for_deleting').is(":checked");
		var checkBox2  = jQuery('#Hobby_new_attachment2_checkbox_for_deleting').is(":checked");
		var checkBox3  = jQuery('#Hobby_new_attachment3_checkbox_for_deleting').is(":checked");

		//check format file
		var arr_file	   = [".zip", ".doc", ".docx", ".xls" , ".xlsx" , ".ppt" , ".pptx" , ".pdf" , ".rar" , ".jpg" , ".gif", ".png", ".jpeg"];			
		var attachment1 = jQuery('#Hobby_new_attachment1').val();

		checkFile1	   = attachment1.substr(attachment1.lastIndexOf('.'));
		checkFile1	   = checkFile1.toLowerCase();

		var attachment2 = jQuery('#Hobby_new_attachment2').val();
		checkFile2	   = attachment2.substr(attachment2.lastIndexOf('.'));
		checkFile2	   = checkFile2.toLowerCase();

		var attachment3 = jQuery('#Hobby_new_attachment3').val();

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
 
	    $("#hobby_new_edit").attr('action', '<?php echo Yii::app()->baseUrl; ?>/adminhobby_new/editconfirm/');  
		 
	    type=getCookie("hobby_new_edit_category_id");
		if(type!=null && type !="null")
		{
			$("#cat"+type).attr('checked',true);
		}
		
		title=getCookie("hobby_new_edit_title");
		if(title!=null && title!="null")
		{
			$("#Hobby_new_title").val(title);
		}
                else{
                   jQuery('#err1').remove();
                   jQuery('#err2').remove();
                   jQuery('#err3').remove();
                   
               }
		
		content=getCookie("hobby_new_edit_content");
		if(content!=null && content!="null")
		{
			content1=content.replace(/<br\s*\/?>/mg,"\n");
			$("#Hobby_new_content").val(content1);
		}
		
		attachment1_checkbox_for_deleting=getCookie("hobby_new_edit_attachment1_checkbox_for_deleting");
	    if(attachment1_checkbox_for_deleting!=null&&attachment1_checkbox_for_deleting!="null")
	    {              
		   if(attachment1_checkbox_for_deleting=='1')
		   {
			   $("#Hobby_new_attachment1_checkbox_for_deleting").attr('checked',true);
                           $fileInput=$("#Hobby_new_attachment1_checkbox_for_deleting").parent().parent().prev().find('input[type="file"]').eq(0);
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
                  $node1=$("#Hobby_new_attachment1_checkbox_for_deleting").parent().parent().prev().prev();
                  $node1.remove();
                  $('<img alt="" src="<?php echo $this->assetsBase; ?>/css/common/img/img_photo01.jpg">').insertBefore($("#Hobby_new_attachment1_checkbox_for_deleting").parent().parent().prev());
		   }
		   else
		   {
			   $("#Hobby_new_attachment1_checkbox_for_deleting").attr('checked',false);
		   }
	    }
		
        attachment2_checkbox_for_deleting=getCookie("hobby_new_edit_attachment2_checkbox_for_deleting");
        if(attachment2_checkbox_for_deleting!=null&&attachment2_checkbox_for_deleting!="null")
		{
		   if(attachment2_checkbox_for_deleting=='1')
		   {
			   $("#Hobby_new_attachment2_checkbox_for_deleting").attr('checked',true);
                           $fileInput=$("#Hobby_new_attachment2_checkbox_for_deleting").parent().parent().prev().find('input[type="file"]').eq(0);
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
                  $node1=$("#Hobby_new_attachment2_checkbox_for_deleting").parent().parent().prev().prev();
                  $node1.remove();
                  $('<img alt="" src="<?php echo $this->assetsBase; ?>/css/common/img/img_photo01.jpg">').insertBefore($("#Hobby_new_attachment2_checkbox_for_deleting").parent().parent().prev());
		   }
		   else
		   {
			   $("#Hobby_new_attachment2_checkbox_for_deleting").attr('checked',false);
		   }
       }
	   
	   attachment3_checkbox_for_deleting=getCookie("hobby_new_edit_attachment3_checkbox_for_deleting");
	   if(attachment3_checkbox_for_deleting!=null&&attachment3_checkbox_for_deleting!="null")
	   {
		   if(attachment3_checkbox_for_deleting=='1')
		   {
			   $("#Hobby_new_attachment3_checkbox_for_deleting").attr('checked',true);
                           $fileInput=$("#Hobby_new_attachment3_checkbox_for_deleting").parent().parent().prev().find('input[type="file"]').eq(0);
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
                  $node1=$("#Hobby_new_attachment3_checkbox_for_deleting").parent().parent().prev().prev();
                  $node1.remove();
                  $('<img alt="" src="<?php echo $this->assetsBase; ?>/css/common/img/img_photo01.jpg">').insertBefore($("#Hobby_new_attachment3_checkbox_for_deleting").parent().parent().prev());
		   }
		   else
		   {
			   $("#Hobby_new_attachment3_checkbox_for_deleting").attr('checked',false);
		   }
	   }

		
	   $('button[type="submit"]').click(function()
	   {    

		   deleteCookies("hobby_new_edit_form"); 
		   
		   var idcat = $("#hobby_new_edit input[type='radio']:checked").val();	
		   checkCategory(idcat);	
		   
		   var id = $('#Hobby_new_id').val();	
		   checkId(id);
			
			$.ajax
			({    
					type: "POST", 
					async:true,
					url: "<?php echo Yii::app()->baseUrl;?>/adminhobby_new/edit/?id=<?php echo $model->id;?>",    
					data: jQuery('#hobby_new_edit').serialize(),
					success: function(msg)
					{	            
					    jQuery('#Hobby_new_title').prev().remove();                                       						                                            					  	
					    jQuery('#Hobby_new_content').prev().remove(); 	
						if(msg!='[]' | !checkFile())
						{
							data=$.parseJSON(msg);
							if(data.Hobby_new_title)
							{	
								div=document.createElement('div');
								$(div).addClass('alert');
								$(div).addClass('error_message');
								$(div).html(data.Hobby_new_title);
								$(div).insertBefore($('#Hobby_new_title')); 
							} 
							if(data.Hobby_new_content)
						    {
								div=document.createElement('div');
								$(div).addClass('alert');
								$(div).addClass('error_message');
								$(div).html(data.Hobby_new_content);
								$(div).insertBefore($('#Hobby_new_content')); 
							} 	 
					}		
					else
					{
					    setCookie("hobby_new_edit_category_id",$("#hobby_new_edit input[type='radio']:checked").val());	
						setCookie("hobby_new_edit_title",$("#Hobby_new_title").val());
                        val=$("#Hobby_new_content").val();
						val=val.replace(/\n/g, "<br/>");
                        setCookie("hobby_new_edit_content",val);
					
						if($("#Hobby_new_attachment1_checkbox_for_deleting").attr('checked')==true)
						{
                            setCookie("hobby_new_edit_attachment1_checkbox_for_deleting",'1');
                        }
						else
						{
							setCookie("hobby_new_edit_attachment1_checkbox_for_deleting",'0');
						}

						if($("#Hobby_new_attachment2_checkbox_for_deleting").attr('checked')==true)
						{
							setCookie("hobby_new_edit_attachment2_checkbox_for_deleting",'1');
						}
						else
						{
							setCookie("hobby_new_edit_attachment2_checkbox_for_deleting",'0');
						}
						
						if($("#Hobby_new_attachment3_checkbox_for_deleting").attr('checked')==true)
						{
							setCookie("hobby_new_edit_attachment3_checkbox_for_deleting",'1');
						}
						else
						{
							setCookie("hobby_new_edit_attachment3_checkbox_for_deleting",'0');
						}
						
						jQuery('#hobby_new_edit').submit();
					}
				}	  
			});
		
		});
 
    });	
       	
</script>