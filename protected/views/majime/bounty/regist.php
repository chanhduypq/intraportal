



<div class="wrap majime secondary bounty">
  <div class="container">
    <div class="contents regist">
      <div class="mainBox detail">
        <div class="pageTtl">
          <h2>懸賞金付き募集コンテンツ - 投稿</h2>
          <span>
              <?php
				 if(FunctionCommon::isViewFunction("bounty")==true)
				 {
			 ?>
				<a class="btn btn-important" href="<?php echo Yii::app()->request->baseUrl; ?>/majimebounty/">
                  <i class="icon-chevron-left icon-white"></i>一覧に戻る
                </a>
			  <?php }else {?>
				<a class="btn btn-important" href="<?php echo Yii::app()->baseUrl?>/majime/">
					<i class="icon-home icon-white"></i> マジメのTopへ戻る
				</a>	
			  <?php }?>  
          </span>
        </div>
        <div class="box">
		<?php $form = $this->beginWidget('CActiveForm', array(
						'id' => 'bounty_regist', 
						'htmlOptions' => array(
						'enctype' => 'multipart/form-data',
						'class'=>'form-horizontal'),));?>
		<?php echo $form->hiddenField($model, 'id'); ?>     				
            <div class="cnt-box">
              <div class="control-group">
                <label class="control-label" for="title">タイトル&nbsp; 
                  <span class="label label-warning">必須</span>
                </label>
                <div class="controls">
					<?php echo $form->textField($model, 'title', array('placeholder' => 'タイトルを入力してください。[25文字]', 'class' => 'input-xxlarge')); ?>		
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="content">本文&nbsp; 
                  <span class="label label-warning">必須</span>
                </label>
                <div class="controls">
					<?php echo $form->textarea($model, 'content', array('placeholder' => '本文を入力してください。', 'class' => 'input-xxlarge', 'rows' => 7, 'maxlength' => 3000)); ?>               
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="content">懸賞内容&nbsp; 
                  <span class="label label-warning">必須</span>
                </label>
                <div class="controls">
					<?php echo $form->textarea($model, 'prize', array('placeholder' => '本文を入力してください。', 'class' => 'input-xxlarge', 'rows' => 3, 'maxlength' => 1000)); ?>  	
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="title">締め切り日&nbsp; 
                  <span class="label label-warning">必須</span>
                </label>
				 <div class="controls" id="divDeadline">
					<?php $current= date("Y");
						  $array_year = array();
						  for ($i = $current; $i <= $current+5; $i++) 
						 {
							$array_year[$i] = $i;
						 }
						 echo $form->dropDownList($model, 'deadline_year', $array_year, array('class' => 'input-small')); ?>
					<?php $array_month = array();
						  for ($i = 1; $i <= 12; $i++) 
						 {
							$array_month[$i] = $i;
						 }
						 echo $form->dropDownList($model, 'deadline_month', $array_month, array('class' => 'input-mini'));?>
					<?php $array_day = array();
						  for ($i = 1; $i <= 31; $i++)
						  {
							 $array_day[$i] = $i;
						  }
						  echo $form->dropDownList($model, 'deadline_day', $array_day, array('class' => 'input-mini'));?>                                                              
				</div>
			  </div>
			  <div class="field attachements">
					<?php
                                        $attachements = $this->beginWidget('ext.helpers.Form_new');
                                        $attachements->regist11($model, $form,$attachment1_error,$attachment2_error,$attachment3_error,'majimebounty',$this->assetsBase);
                                        $this->endWidget();
                                        ?>
			 </div>
            </div>
            <!-- /cnt-box -->
			<?php $this->endWidget(); ?>
            <div class="form-last-btn">
              <p class="btn80">
                <button type="submit" class="btn btn-important">
                  <i class="icon-chevron-right icon-white"></i>確認
                </button>
              </p>
            </div>
        </div>
        <!-- /box -->
      </div>
      <!-- /mainBox -->
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
        
	function day(day_number) 
		{
            $('#Bounty_deadline_day').html("");
            for (i = 1; i <= day_number; i++) 
			{
                $('#Bounty_deadline_day').append("<option value=" + i + ">" + i + "</option>");
            }
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
		var checkBox1  = jQuery('#Bounty_attachment1_checkbox_for_deleting').is(":checked");
		var checkBox2  = jQuery('#Bounty_attachment2_checkbox_for_deleting').is(":checked");
		var checkBox3  = jQuery('#Bounty_attachment3_checkbox_for_deleting').is(":checked");

		//check format file
		var arr_file	   = [".zip", ".doc", ".docx", ".xls" , ".xlsx" , ".ppt" , ".pptx" , ".pdf" , ".rar" , ".jpg" , ".gif", ".png", ".jpeg"];			
		var attachment1 = jQuery('#Bounty_attachment1').val();

		checkFile1	   = attachment1.substr(attachment1.lastIndexOf('.'));
		checkFile1	   = checkFile1.toLowerCase();

		var attachment2 = jQuery('#Bounty_attachment2').val();
		checkFile2	   = attachment2.substr(attachment2.lastIndexOf('.'));
		checkFile2	   = checkFile2.toLowerCase();

		var attachment3 = jQuery('#Bounty_attachment3').val();

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
	
	
		 
        

        
	
	/*Check day deadline*/
	function dateCompare()
	{
		var iscompare=true;
		var today = new Date();
		var curr_date = today.getDate();
		var curr_month = today.getMonth()+1;
		var curr_year = today.getFullYear();
		
		var deadline_day=$("#Bounty_deadline_day").val();
		var deadline_month=$("#Bounty_deadline_month").val();
		var deadline_year=$("#Bounty_deadline_year").val();
		
		var current_date =curr_year+'/'+curr_month+'/'+curr_date;
		var deadline =deadline_year+'/'+deadline_month+'/'+deadline_day;

		if(Date.parse(current_date) > Date.parse(deadline))
		{
			 iscompare=false;
		}
		return iscompare;
	}
	
  
	jQuery(function($)
	{
            $('a').click(function(){ 


            
            
             
            if($(this).attr('id')==undefined){
                return;
            }
            window.location="<?php echo Yii::app()->baseUrl;?>/majimebounty/download/?file_name="+$(this).attr('id');
        });
            $("#Bounty_deadline_year").change(function()
		{
            var month = $("#Bounty_deadline_month").val();
            var year = $("#Bounty_deadline_year").val();
            if (month == 4 || month == 6 || month == 9 || month == 11) 
			{
                day(30);
            }
            else
            if (month == 2) 
			{
                if ((year % 400 == 0) || (year % 4 == 0 && year % 100 != 0)) 
				{
                    day(29);
                }
                else 
				{
                    day(28);
                }
            }
            else 
			{
                day(31);
            }
        });
            $("#Bounty_deadline_month").change(function() 
		 {
            var month = $("#Bounty_deadline_month").val();
            var year = $("#Bounty_deadline_year").val();
            if (month == 4 || month == 6 || month == 9 || month == 11)
			{
                day(30);
            }
            else
            if (month == 2) 
			{
                if ((year % 400 == 0) || (year % 4 == 0 && year % 100 != 0)) 
				{
                    day(29);
                }
                else 
				{
                    day(28);
                }
            }
            else 
			{
                day(31);
            }
        });
            
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
		
		$("body").attr('id','majime');  

		$("#bounty_regist").attr('action','<?php echo Yii::app()->baseUrl;?>/majimebounty/registconfirm/');          
		
		type=getCookie("bounty_reg_title");
		if(type!=null && type !="null")
		{
			$("#Bounty_title").val(type);
		}else{
               jQuery('#err1').remove();
               jQuery('#err2').remove();
               jQuery('#err3').remove();
               //jQuery('#photo_error').remove();
           }
		
		content=getCookie("bounty_reg_content");
		if(content!=null && content!="null")
		{
			content1=content.replace(/<br ?\/?>|_/g, '\n');
			$("#Bounty_content").val(content1);
		}
		
		prize=getCookie("bounty_reg_prize");
		if(prize!=null && prize!="null")
		{
			prize1=prize.replace(/<br ?\/?>|_/g, '\n');
			$("#Bounty_prize").val(prize1);
		}
		
		deadline_year=getCookie("bounty_reg_deadline_year");
		if(deadline_year!=null&&deadline_year!="null")
		{
		   $("#Bounty_deadline_year").val(deadline_year);
		 }
		
		deadline_month=getCookie("bounty_reg_deadline_month");
		if(deadline_month!=null&&deadline_month!="null")
		{
		  $("#Bounty_deadline_month").val(deadline_month);
		}
		
		deadline_day=getCookie("bounty_reg_deadline_day");
		if(deadline_day!=null&&deadline_day!="null")
		{
			$("#Bounty_deadline_day").val(deadline_day);
		}
                Bounty_deadline_day=$("#Bounty_deadline_day").val();
            Bounty_deadline_month=$("#Bounty_deadline_month").val();
            Bounty_deadline_year=$("#Bounty_deadline_year").val();
            if (Bounty_deadline_month == 4 || Bounty_deadline_month == 6 || Bounty_deadline_month == 9 || Bounty_deadline_month == 11)
			{ 
                day(30);
            }
            else if (Bounty_deadline_month == 2) 
			{
                if ((Bounty_deadline_year % 400 == 0) || (Bounty_deadline_year % 4 == 0 && Bounty_deadline_year % 100 != 0)) 
				{
                    day(29);
                }
                else 
				{
                    day(28);
                }
            }
            else 
			{
                day(31);
            }
            $("#Bounty_deadline_day").val(Bounty_deadline_day);
		
		attachment1_checkbox_for_deleting=getCookie("bounty_reg_attachment1_checkbox_for_deleting");
		if(attachment1_checkbox_for_deleting!=null&&attachment1_checkbox_for_deleting!="null")
		{              
		   if(attachment1_checkbox_for_deleting=='1')
		   {
			   $("#Bounty_attachment1_checkbox_for_deleting").attr('checked',true);
		   }
		   else
		   {
			   $("#Bounty_attachment1_checkbox_for_deleting").attr('checked',false);
		   }
		}
		
		attachment2_checkbox_for_deleting=getCookie("bounty_reg_attachment2_checkbox_for_deleting");
		if(attachment2_checkbox_for_deleting!=null&&attachment2_checkbox_for_deleting!="null")
		{
		   if(attachment2_checkbox_for_deleting=='1')
		   {
			   $("#Bounty_attachment2_checkbox_for_deleting").attr('checked',true);
		   }
		   else
		   {
			   $("#Bounty_attachment2_checkbox_for_deleting").attr('checked',false);
		   }
		}
		
		attachment3_checkbox_for_deleting=getCookie("bounty_reg_attachment3_checkbox_for_deleting");
		if(attachment3_checkbox_for_deleting!=null&&attachment3_checkbox_for_deleting!="null")
		{
		   if(attachment3_checkbox_for_deleting=='1')
		   {
			   $("#Bounty_attachment3_checkbox_for_deleting").attr('checked',true);
		   }
		   else
		   {
			   $("#Bounty_attachment3_checkbox_for_deleting").attr('checked',false);
		   }
	   }
		
		// setCookie("bounty_reg_title",$("#Bounty_title").val());
		// setCookie("bounty_reg_content",content);
		// setCookie("bounty_reg_prize",prize);
		// setCookie("bounty_reg_deadline_year",$("#Bounty_deadline_year").val());
		// setCookie("bounty_reg_deadline_month",$("#Bounty_deadline_month").val()); 
		// setCookie("bounty_reg_deadline_day",$("#Bounty_deadline_day").val());

		 $('button[type="submit"]').click(function()
		 {     
                     no=2;          
                 
			 deleteCookies("bounty_regist_form");      
				$.ajax({    
					type: "POST", 
					async:true,
					url: "<?php echo Yii::app()->baseUrl;?>/majimebounty/regist/",    
					data: jQuery('#bounty_regist').serialize(),
					success: function(msg)
					{	     
						  jQuery('#Bounty_title').prev().remove();                                       						                                            					  	
						  jQuery('#Bounty_content').prev().remove();	
					      jQuery('#Bounty_prize').prev().remove();	
						  if(msg!='[]' | !checkFile() |!dateCompare())
						  {
								data=$.parseJSON(msg);
								if(data.Bounty_title)
								{
									div=document.createElement('div');
									$(div).addClass('alert');
									$(div).addClass('error_message');
									$(div).html(data.Bounty_title);
									$(div).insertBefore($('#Bounty_title'));
								} 
								if(data.Bounty_content)
								{	
									 div=document.createElement('div');
									 $(div).addClass('alert');
									 $(div).addClass('error_message');
									 $(div).html(data.Bounty_content);
									 $(div).insertBefore($('#Bounty_content')); 
								} 
								if(data.Bounty_prize)
								{
									 div=document.createElement('div');
									 $(div).addClass('alert');
									 $(div).addClass('error_message');
									 $(div).html(data.Bounty_prize);
									 $(div).insertBefore($('#Bounty_prize')); 
								}
								if(!dateCompare())
								{
									$("#divDeadline").prepend("<div class='alert error_message'><?php echo Lang::MSG_0091?></div>" );
								}		
						  }							  															
						  else
						  {   
							  setCookie("bounty_reg_title",$("#Bounty_title").val());
							  val=$("#Bounty_content").val();
							  val=val.replace(/\n/g, "<br/>");
							  setCookie("bounty_reg_content",val);
							
							  valprize=$("#Bounty_prize").val();
							  valprize=valprize.replace(/\n/g, "<br/>");
							  
							  setCookie("bounty_reg_prize",valprize);
							  setCookie("bounty_reg_deadline_year",$("#Bounty_deadline_year").val());
							  setCookie("bounty_reg_deadline_month",$("#Bounty_deadline_month").val()); 
							  setCookie("bounty_reg_deadline_day",$("#Bounty_deadline_day").val());
		
							  if($("#Bounty_attachment1_checkbox_for_deleting").attr('checked')==true)
							  {
								  setCookie("bounty_reg_attachment1_checkbox_for_deleting",'1');
							  }
							  else
							  {
								  setCookie("bounty_reg_attachment1_checkbox_for_deleting",'0');
							  }
							  
							  if($("#Bounty_attachment2_checkbox_for_deleting").attr('checked')==true)
							  {
									setCookie("bounty_reg_attachment2_checkbox_for_deleting",'1');
							  }
							  else
							  {
									setCookie("bounty_reg_attachment2_checkbox_for_deleting",'0');
							  }
							  
							  if($("#Bounty_attachment3_checkbox_for_deleting").attr('checked')==true)
							  {
									setCookie("bounty_reg_attachment3_checkbox_for_deleting",'1');
							  }
							  else
							  {
									setCookie("bounty_reg_attachment3_checkbox_for_deleting",'0');
							  }
							  jQuery('#bounty_regist').submit();	
						  }					    			    
					 }	  
				});
			});    
	});
	
</script>