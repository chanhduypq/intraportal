<script src="<?php echo $this->assetsBase; ?>/js/lib/json.js"></script>




<div class="wrap majime secondary enquete">
    <div class="container">
        <div class="contents regist">
            <div class="mainBox detail">
                <div class="pageTtl"><h2>みんなのアンケートBOX - 登録</h2>
                    <span>
                      <?php
						 if(FunctionCommon::isViewFunction("enquete")==true)
						 {
					  ?>
						<a class="btn btn-important" href="<?php echo Yii::app()->request->baseUrl; ?>/majimeenquete/index">
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
				<?php
				$form = $this->beginWidget('CActiveForm', array(
					'id' => 'enquete_form',
					'htmlOptions' => array(
						'enctype' => 'multipart/form-data',
						'class' => 'form-horizontal',
					   
					),
       			 )); 
?> 
					<input type="hidden" id="Enquete_answer_content_array" name="Enquete[answer_content_array]" value='<?php echo $model->answer_content_array;?>'/>                    
                    <div class="cnt-box">
                        <div class="control-group">
                            <label for="title" class="control-label">タイトル&nbsp;
                                <span class="label label-warning">必須</span>
                            </label>
                            <div class="controls">
                                <?php echo $form->error($model, 'title'); ?>
                                <?php echo $form->textField($model, 'title', array('placeholder' => 'タイトルを入力してください。[25文字]', 'class' => 'input-xxlarge')); ?>
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="content" class="control-label">本文&nbsp;
                                <span class="label label-warning">必須</span>
                            </label>
                            <div class="controls">
                                <?php echo $form->error($model, 'content'); ?>
                                <?php echo $form->textArea($model, 'content', array('placeholder' => 'タイトルを入力してください。[25文字]', 'class' => 'input-xxlarge', 'rows' => 7,'maxlength'=>3000,)); ?>
                            </div>
                        </div>

                        <div class="control-group">
                            <label for="title" class="control-label">締め切り日&nbsp;
                                <span class="label label-warning">必須</span>
                            </label>
                            <div class="controls">
                                <?php
								$current= date("Y");
								$array_year = array();
                                for ($i = $current; $i <= $current+5; $i++) 
								{
                                    $array_year[$i] = $i;
                                }
                                echo $form->dropDownList($model, 'deadline_year', $array_year, array('class' => 'input-small')); ?>
                                <?php
								$array_month = array();
                                for ($i = 1; $i <= 12; $i++) 
								{
                                    $array_month[$i] = $i;
                                }
                                echo $form->dropDownList($model, 'deadline_month', $array_month, array('class' => 'input-mini'));?>
                                <?php
                                $array_day = array();
                                for ($i = 1; $i <= 31; $i++) {
                                    $array_day[$i] = $i;
                                }
                                echo $form->dropDownList($model, 'deadline_day', $array_day, array('class' => 'input-mini'));?>                                                              
                            </div>
                        </div>
                      <div class="field attachements">
                       
                          <?php                    
                                
                                $attachements = $this->beginWidget('ext.helpers.Form_new');
                            $attachements->regist11($model, $form,$attachment1_error,$attachment2_error,$attachment3_error,'majimeenquete',$this->assetsBase);
                            $this->endWidget();
                            ?>
                      </div>
                        <div class="attachements">
                            <div class="title">回答作成</div>
                            <div class="control-group">
                                <label class="control-label">回答選択方法&nbsp;
                                    <span class="label label-warning">必須</span>
                                </label>
                                <div class="controls">
									<?php $typeEnquete = Constants::$typeEnquete; ?>
									<?php echo $form->radioButtonList($model, 'answer_type', array('1' => $typeEnquete['1'], '2' => $typeEnquete['2']), 
																							 array('labelOptions' => array('style' => 'display:inline'),
																			     'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',))?>
                                </div>
                            </div>

                            <div class="control-group">
                                <label for="title" class="control-label">回答&nbsp;
                                    <span class="label label-warning">必須</span>
                                </label>
                                <div class="controls">
                                   
                                    <ol class="anser-boxs" id="anser-boxs">
									
										<li class="anser01">
											 <input id="answer_content1" type="text" placeholder="回答を入力してください。" class="input-xxlarge text-anser" name="anser[]" maxlength="256">
										 </li>
										 <li class="anser02">
											<input id="answer_content2" type="text" placeholder="回答を入力してください。" class="input-xxlarge text-anser" name="anser[]" maxlength="256">
										 </li>
										 <li class="anser03">
											<input id="answer_content3" type="text" placeholder="回答を入力してください。" class="input-xxlarge text-anser" name="anser[]" maxlength="256">
										 </li>
										 <li class="anser04">
											<input id="answer_content4" type="text" placeholder="回答を入力してください。" class="input-xxlarge text-anser" name="anser[]" maxlength="256">
										 </li>
										 <li class="anser05">
											<input id="answer_content5" type="text" placeholder="回答を入力してください。" class="input-xxlarge text-anser" name="anser[]" maxlength="256">
										 </li>
                                    </ol>
                                    <a class="btn btn-link" style="cursor:pointer;" id="add-anser">回答枠を追加</a>
                                </div>
                            </div>
                        </div>

                    </div><!-- /cnt-box -->
						<?php $this->endWidget();?>
                    <div class="form-last-btn">
                        <p class="btn80">
                            <button class="btn btn-important" type="submit" >
								<i class="icon-chevron-right icon-white">&#12288;</i> 
									確認
							</button>
                        </p>
                    </div>
					
                </div><!-- /box -->
            </div><!-- /mainBox -->


        </div><!-- /contents -->
        <p id="page-top" style="display: block;"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->

    <div class="footer">
        <p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div>

<script type="text/javascript">
    
    //check browm chrome
	
    
	function checkAnser()
	{
		ansers=jQuery("input[name='anser[]']"); 
		hasInput=false;
		larger=false;
		for(i=0,n=ansers.length;i<n;i++)
		{
			
			if(jQuery.trim(jQuery(ansers[i]).val())!="")
			{
				if(jQuery(ansers[i]).val().toString().length>256)
				{
					larger=true;
				}        
				hasInput=true;
			}
		}
		if(hasInput==false)
		{
			return 1;
		}
		if(larger==true)
		{
			return 2;
		}    
		return 3;
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
	   $("#enquete_form").attr('action','<?php echo Yii::app()->baseUrl;?>/majimeenquete/confirm/');  
       $("body").attr('id','majime'); 
       
       
        $("#add-anser").click(function() {
            lis = $("ol#anser-boxs li");
            last_index = lis.length - 1;
            last_li = $("ol#anser-boxs").find('li').eq(last_index);
            new_li = $(last_li).clone();
            $(new_li).attr('class', 'anser0' + (lis.length + 1));
            $(new_li).find('input').eq(0).val('');
			$(new_li).find('input').eq(0).attr('id', 'answer_content' + (lis.length + 1));
            $(new_li).insertAfter(last_li);
        });

        $("#Enquete_deadline_month").change(function() {
            var month = $("#Enquete_deadline_month").val();
            var year = $("#Enquete_deadline_year").val();
            if (month == 4 || month == 6 || month == 9 || month == 11) {
                day(30);
            }
            else
            if (month == 2) {
                if ((year % 400 == 0) || (year % 4 == 0 && year % 100 != 0)) {
                    day(29);
                }
                else {
                    day(28);
                }
            }
            else {
                day(31);
            }
        });
        $("#Enquete_deadline_year").change(function() {
            var month = $("#Enquete_deadline_month").val();
            var year = $("#Enquete_deadline_year").val();
            if (month == 4 || month == 6 || month == 9 || month == 11) {
                day(30);
            }
            else
            if (month == 2) {
                if ((year % 400 == 0) || (year % 4 == 0 && year % 100 != 0)) {
                    day(29);
                }
                else {
                    day(28);
                }
            }
            else {
                day(31);
            }
        });

        function day(day_number) {
            $('#Enquete_deadline_day').html("");
            for (i = 1; i <= day_number; i++) {
                $('#Enquete_deadline_day').append("<option value=" + i + ">" + i + "</option>");
            }
        }
        
      
	   title=getCookie("enquete_regist_title");
	   if(title!=null&&title!="null")
	   {
		   $("#Enquete_title").val(title);
	   }
		else{
               jQuery('#err1').remove();
               jQuery('#err2').remove();
               jQuery('#err3').remove();
               //jQuery('#photo_error').remove();
           }   	
       content=getCookie("enquete_regist_content");
       if(content!=null&&content!="null")
	   {
		   content1=content.replace(/<br ?\/?>|_/g, '\n');	
           $("#Enquete_content").val(content1);
        }
		
       deadline_year=getCookie("enquete_regist_deadline_year");
	   if(deadline_year!=null&&deadline_year!="null")
	   {
		   $("#Enquete_deadline_year").val(deadline_year);
	   }
	   
	   deadline_month=getCookie("enquete_regist_deadline_month");
	   if(deadline_month!=null&&deadline_month!="null")
	   {
		   $("#Enquete_deadline_month").val(deadline_month);
	   }
	   
	   deadline_day=getCookie("enquete_regist_deadline_day");
	   if(deadline_day!=null&&deadline_day!="null")
	   {
		   $("#Enquete_deadline_day").val(deadline_day);
	   }
	   
       answer_type=getCookie("enquete_regist_answer_type");
       if(answer_type!=null&&answer_type!="null")
	   {
		   if(answer_type==1)
		   {
				$("#Enquete_answer_type_1").attr("checked", "checked");
		   }
        }
        
       attachment1_checkbox_for_deleting=getCookie("enquete_regist_attachment1_checkbox_for_deleting");
	   if(attachment1_checkbox_for_deleting!=null&&attachment1_checkbox_for_deleting!="null")
	   {              
		   if(attachment1_checkbox_for_deleting=='1')
		   {
			   $("#Enquete_attachment1_checkbox_for_deleting").attr('checked',true);
		   }
		   else
		   {
			   $("#Enquete_attachment1_checkbox_for_deleting").attr('checked',false);
		   }
	   }
		   
	   attachment2_checkbox_for_deleting=getCookie("enquete_regist_attachment2_checkbox_for_deleting");
	   if(attachment2_checkbox_for_deleting!=null&&attachment2_checkbox_for_deleting!="null")
	   {
		   if(attachment2_checkbox_for_deleting=='1')
		   {
			   $("#Enquete_attachment2_checkbox_for_deleting").attr('checked',true);
		   }
		   else{
			   $("#Enquete_attachment2_checkbox_for_deleting").attr('checked',false);
		   }
	   }
	   
	   attachment3_checkbox_for_deleting=getCookie("enquete_regist_attachment3_checkbox_for_deleting");
	   if(attachment3_checkbox_for_deleting!=null&&attachment3_checkbox_for_deleting!="null")
	   {
		   if(attachment3_checkbox_for_deleting=='1')
		   {
			   $("#Enquete_attachment3_checkbox_for_deleting").attr('checked',true);
		   }
		   else{
			   $("#Enquete_attachment3_checkbox_for_deleting").attr('checked',false);
		   }
	   }
		// setCookie("enquete_regist_title",$("#Enquete_title").val());   
		// setCookie("enquete_regist_content",content); 
        // setCookie("enquete_regist_deadline_year",$("#Enquete_deadline_year").val());
        // setCookie("enquete_regist_deadline_month",$("#Enquete_deadline_month").val()); 
	    // setCookie("enquete_regist_deadline_day",$("#Enquete_deadline_day").val());
        
       
        $('button[type="submit"]').click(function() 
		{
            no=2; 
              
			deleteCookies("enquete_regist_from"); 
            $.ajax({
                type: "POST",
                async: true,
                url: "<?php echo Yii::app()->baseUrl; ?>/majimeenquete/regist/",
                data: jQuery('#enquete_form').serialize(),
                success: function(msg)
                {
                    $('#Enquete_title').prev().remove();
                    $('#Enquete_content').prev().remove();
                    $('#anser-boxs').prev().remove();
                    
                    rs=checkAnser();
					
                  if(msg!='[]'| checkFile()==false | rs==1)
                    {
                        data = $.parseJSON(msg);
                        if (data.Enquete_title)
                        {
                            div = document.createElement('div');
                            $(div).addClass('alert');
                            $(div).addClass('error_message');
                            $(div).html(data.Enquete_title);
                            $(div).insertBefore($('#Enquete_title'));
                        }
                        if (data.Enquete_content)
                        {
                            div = document.createElement('div');
                            $(div).addClass('alert');
                            $(div).addClass('error_message');
                            $(div).html(data.Enquete_content);
                            $(div).insertBefore($('#Enquete_content'));
                        }
                        
						if(rs==1)
						{
							div = document.createElement('div');
							$(div).addClass('alert');
							$(div).addClass('error_message');
							$(div).html("<?php echo Lang::MSG_0031 ; ?>");
							$(div).insertBefore($('ol#anser-boxs'));
						}
                    } 
                    else if(rs==3)
                    {
                          		if($("#Enquete_answer_type_1").is(':checked')==true)
								{
									 setCookie("enquete_regist_answer_type",1);
								}
                                setCookie("enquete_regist_title",$("#Enquete_title").val());   
								setCookie("enquete_regist_deadline_year",$("#Enquete_deadline_year").val());
								setCookie("enquete_regist_deadline_month",$("#Enquete_deadline_month").val()); 
								setCookie("enquete_regist_deadline_day",$("#Enquete_deadline_day").val());
								               
								content=$("#Enquete_content").val();
								val=content.replace(/\n/g, "<br/>");
								setCookie("enquete_regist_content",val);
								
								if($("#Enquete_attachment1_checkbox_for_deleting").attr('checked')==true)
								{
									setCookie("enquete_regist_attachment1_checkbox_for_deleting",'1');
								}
								else
								{
									setCookie("enquete_regist_attachment1_checkbox_for_deleting",'0');
								}
								if($("#Enquete_attachment2_checkbox_for_deleting").attr('checked')==true)
								{
									setCookie("enquete_regist_attachment2_checkbox_for_deleting",'1');
								}
								else
								{
									setCookie("enquete_regist_attachment2_checkbox_for_deleting",'0');
								}
								if($("#Enquete_attachment3_checkbox_for_deleting").attr('checked')==true)
								{
									setCookie("enquete_regist_attachment3_checkbox_for_deleting",'1');
								}
								else
								{
									setCookie("enquete_regist_attachment3_checkbox_for_deleting",'0');
								}
								setCookie("loaddata",getData(),1);
                           	    jQuery('#enquete_form').submit();
                       
                        
                    }
                }
            });

        });

    });
	
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
		var checkBox1  = jQuery('#Enquete_attachment1_checkbox_for_deleting').is(":checked");
		var checkBox2  = jQuery('#Enquete_attachment2_checkbox_for_deleting').is(":checked");
		var checkBox3  = jQuery('#Enquete_attachment3_checkbox_for_deleting').is(":checked");

		//check format file
		var arr_file	   = [".zip", ".doc", ".docx", ".xls" , ".xlsx" , ".ppt" , ".pptx" , ".pdf" , ".rar" , ".jpg" , ".gif", ".png", ".jpeg"];			
		var attachment1 = jQuery('#Enquete_attachment1').val();

		checkFile1	   = attachment1.substr(attachment1.lastIndexOf('.'));
		checkFile1	   = checkFile1.toLowerCase();

		var attachment2 = jQuery('#Enquete_attachment2').val();
		checkFile2	   = attachment2.substr(attachment2.lastIndexOf('.'));
		checkFile2	   = checkFile2.toLowerCase();

		var attachment3 = jQuery('#Enquete_attachment3').val();

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

function getData()
{
	var arrdatime={};	 
	jQuery("ol#anser-boxs li").each(function(index){
		index++;
		
		var arr={};
		var answer = $('#answer_content'+index).val();
		arr["answer"]	  =answer;
		arrdatime[index]=arr;
	});	
	var str=JSON.stringify(arrdatime);
	return str;
}
function loadDate()
	{
			var item=getCookie("loaddata");
		    if(item && item != "null"){
			item=$.parseJSON(item);
			
			
			$.each(item, function(index) {
				index++;
				count=index-1
				t = 'answer_content'+count;
				$("#"+t).val(item[count].answer);
				if(count>5){
						$('ol#anser-boxs').append('<li class="anser0'+count+'"><input id="answer_content'+count+'" type="text" placeholder="回答を入力してください。" class="input-xxlarge text-anser" name="anser[]" value="'+item[count].answer+'"></li>');
				}
			});
		   }
	}	
	//reload anser cookie ajax
	 jQuery(function($) 
	{
            loadDate();
            $(window).on('beforeunload', function(){
        });	
	 });		
</script>
