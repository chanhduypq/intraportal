
<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/js/lib/json.js"></script>
<script type="text/javascript">
    jQuery(function($) {
        var year = $("#Enquete_deadline_year").val();
        var month = $("#Enquete_deadline_month").val();
        if (
                month == 1
                || month == 3
                || month == 5
                || month == 7
                || month == 8
                || month == 10
                || month == 12
                ) {
            day(31);
        }
        else if (
                month == 4
                || month == 6
                || month == 9
                || month == 11
                ) {
            day(30);
        }
        else if (month == 2) {
            if (year % 4 == 0) {
                day(29);
            }
            else if (year % 4 != 0) {
                day(28);
            }
        }
        daySelected = '<?php echo $model->deadline_day; ?>';
        options = $('#Enquete_deadline_day option');
        for (i = 1, n = options.length; i <= n; i++) {
            if ($(options[i]).attr('value') == daySelected) {
                $(options[i]).attr('selected', 'selected');
                break;
            }
        }

        $("#add-anser").click(function() {
            lis = $("ol#anser-boxs li");
            last_index = lis.length - 1;
            last_li = $("ol#anser-boxs").find('li').eq(last_index);
            new_li = $(last_li).clone();
            $(new_li).attr('class', 'anser0' + (lis.length + 1));
			$(new_li).attr('id', 'anser');
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
        ;
    });

</script>
<div class="wrap admin secondary enquete">
    <div class="container">
        <div class="contents edit">
        	
            <div class="mainBox detail">
            	  <div class="pageTtl"><h2>みんなのアンケートBOX - 修正</h2>
                <?php 
					if(Yii::app()->request->cookies['page']!= "") 
					{
						   $page = "index?page=".Yii::app()->request->cookies['page'];
							
					}else {$page ="";}
					?>
                <span><a class="btn btn-important" href="<?php echo Yii::app()->request->baseUrl; ?>/adminenquete/<?php echo $page;?>"><i class="icon-chevron-left icon-white"></i> 一覧に戻る</a></span>
                </div>
                <div class="box">
                <?php
                
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'enquete_form',                     
                    'htmlOptions' => array(
                                          'enctype' => 'multipart/form-data',
                                          'class'=>'form-horizontal',                                          
                                          ),
                        ));
                    
                ?> 
                <?php echo $form->hiddenField($model, 'id'); ?> 
                <?php echo $form->hiddenField($model, 'num_anser');?> 
                <?php echo $form->hiddenField($model, 'id_anser_array');?>                  
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
							<?php echo $form->textarea($model,'content', array('placeholder' => '本文を入力してください。', 'class' => 'input-xxlarge', 'rows' => 7,'maxlength' => 3000)); ?>	
                        </div>
                    </div>
                    <div class="control-group">
                            <label for="title" class="control-label">締め切り日&nbsp;
                                <span class="label label-warning">必須</span>
                            </label>
                            <div class="controls">
                                <?php
                                $current = date("Y");
                                $array_year = array();
                                for ($i = $current; $i <= $current + 5; $i++) {
                                    $array_year[$i] = $i;
                                }
                                echo $form->dropDownList($model, 'deadline_year', $array_year, array('class' => 'input-small'));
                                ?>
                                <?php
                                $array_month = array();
                                for ($i = 1; $i <= 12; $i++) {
                                    $array_month[$i] = $i;
                                }
                                echo $form->dropDownList($model, 'deadline_month', $array_month, array('class' => 'input-mini'));
                                ?>
                                <?php
                                $array_day = array();
                                for ($i = 1; $i <= 31; $i++) {
                                    $array_day[$i] = $i;
                                }
                                echo $form->dropDownList($model, 'deadline_day', $array_day, array('class' => 'input-mini'));
                                ?>                                                              
                            </div>
                        </div>
                      <div class="field attachements">
                            <?php                    
                            $attachements = $this->beginWidget('ext.helpers.Form_new');
                            $attachements->edit11($model, $form,'adminenquete',$attachment1_error,$attachment2_error,$attachment3_error,$this->assetsBase);
                            $this->endWidget();
                            ?>
    
                      </div>
                       <div class="attachements">
                            <div class="title">回答作成</div>
                            <p class="descriptionTxt">アンケートの回答選択枝を作成します。</p>

                            <div class="control-group">
                                <label class="control-label">回答選択方法&nbsp;
                                    <span class="label label-warning">必須</span></label>
                                <div class="controls">
                                        <?php $typeEnquete = Constants::$typeEnquete; ?>
                                        <?php
                                        echo $form->radioButtonList(
                                                $model, 'answer_type', array('1' => $typeEnquete['1'], '2' => $typeEnquete['2']), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',)
                                        )
                                        ?>

                                </div>
                            </div>
                    		 <div class="control-group">
                                <label class="control-label" for="title">回答&nbsp;
                                    <span class="label label-warning">必須</span></label>
                                <div class="controls">
                                    <ol class="anser-boxs" id="anser-boxs">
									<?php $i = 1;
										  $answers1=CJSON::decode($model->content_anser_array);
										  if (count($answers1) > 0)
									      {
										     foreach ($answers1 as $answer) { ?>
												<li id="li_anser" class="anser0<?php echo $i; ?>">
													<input id="answer_content<?php echo $i; ?>" name="anser[]" placeholder="回答を入力してください。" class="input-xxlarge text-anser" type="text" maxlength="256" value= "<?php echo htmlspecialchars($answer); ?>" />
												</li>
                                                <?php $i++;
                                            }
                                        }
                                    ?>
                                    </ol>

                                    <a class="btn btn-link" style="cursor:pointer;" id="add-anser">回答枠を追加</a>
                                </div>
                            </div>
                     </div> <!-- /attachements -->   
                     <div class="attachements">
                            <div class="title">回答コメント</div>

                            <p class="descriptionTxt">回答コメントは、アンケート締め切り終了後表示されます。</p>

                            <div class="control-group">
                                <label for="content" class="control-label">コメント&nbsp;</label>
                                <div class="controls">
								<?php echo $form->error($model, 'comment'); ?>
                                <?php
                                $now = strtotime(date('Y/m/d'));
                                $dealine = strtotime(date('Y/m/d', strtotime($model->deadline)));
                                if ($now <= $dealine) 
								{
                                    echo $form->textArea($model, 'comment', array('placeholder' => '内容(もしくは種別が「リンク」の時はURL)を入力してください。', 'class' => 'input-xxlarge', 'rows' => 7, 'readonly' => 'readonly'));
                                } 
								else 
								{
                                    echo $form->textArea($model, 'comment', array('placeholder' => '内容(もしくは種別が「リンク」の時はURL)を入力してください。', 'class' => 'input-xxlarge', 'rows' => 7,));
                                }
                                ?>
                                </div>
                            </div>

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
					url: "<?php echo Yii::app()->baseUrl;?>/adminenquete/checkId/",    
					data:{id:"<?php echo $model->id;?>",table:"enquete"},
					success: function(msg){	
				
							
							if(msg=='0'){ 
									window.location='<?php echo Yii::app()->baseUrl;?>/adminenquete';
							}
					}
			});
		}
		
    	function checkAnser() 
		{
			ansers = jQuery("input[name='anser[]']");
			hasInput = false;
			larger = false;
			for (i = 0, n = ansers.length; i < n; i++) 
			{
				if (jQuery.trim(jQuery(ansers[i]).val()) != "") 
				{
					if (jQuery(ansers[i]).val().toString().length > 256) 
					{
						larger = true;
					}
					hasInput = true;
				}
			}
			if (hasInput == false) 
			{
				return 1;
			}
			if (larger == true) 
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
       $("body").attr('id','admin');           
	   $("#enquete_form").attr('action', '<?php echo Yii::app()->baseUrl; ?>/adminenquete/editconfirm/');
						   
	   title=getCookie("enquete_edit_title");
	   if(title!=null&&title!="null")
	   {
		   $("#Enquete_title").val(title);
	   }
           else{
               jQuery('#err1').remove();
               jQuery('#err2').remove();
               jQuery('#err3').remove();
               
           }
		   	
       content=getCookie("enquete_edit_content");
       if(content!=null&&content!="null")
	   {
		   content1=content.replace(/<br ?\/?>|_/g, '\n');
           $("#Enquete_content").val(content1);
        }
		
	   comment=getCookie("enquete_edit_comment");
       if(comment!=null&&comment!="null")
	   {
		  comment1=comment.replace(/<br ?\/?>|_/g, '\n');    
          $("#Enquete_comment").val(comment1);
       }
			
        deadline_year=getCookie("enquete_edit_deadline_year");
	   if(deadline_year!=null&&deadline_year!="null")
	   {
		   $("#Enquete_deadline_year").val(deadline_year);
	   }
	    deadline_month=getCookie("enquete_edit_deadline_month");
	   if(deadline_month!=null&&deadline_month!="null")
	   {
		   $("#Enquete_deadline_month").val(deadline_month);
	   }
	    deadline_day=getCookie("enquete_edit_deadline_day");
	   if(deadline_day!=null&&deadline_day!="null")
	   {
		   $("#Enquete_deadline_day").val(deadline_day);
	   }
       answer_type=getCookie("enquete_edit_answer_type");
       if(answer_type!=null&&answer_type!="null")
	   {
		   if(answer_type==1)
		   {
				$("#Enquete_answer_type_1").attr("checked", "checked");
		   }
        }
        
       attachment1_checkbox_for_deleting=getCookie("enquete_edit_attachment1_checkbox_for_deleting");
	   if(attachment1_checkbox_for_deleting!=null&&attachment1_checkbox_for_deleting!="null")
	   {              
		   if(attachment1_checkbox_for_deleting=='1')
		   {
			   $("#Enquete_attachment1_checkbox_for_deleting").attr('checked',true);
                           $fileInput=$("#Enquete_attachment1_checkbox_for_deleting").parent().parent().prev().find('input[type="file"]').eq(0);
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
                  $node1=$("#Enquete_attachment1_checkbox_for_deleting").parent().parent().prev().prev();
                  $node1.remove();
                  $('<img alt="" src="<?php echo $this->assetsBase; ?>/css/common/img/img_photo01.jpg">').insertBefore($("#Enquete_attachment1_checkbox_for_deleting").parent().parent().prev());
		   }
		   else
		   {
			   $("#Enquete_attachment1_checkbox_for_deleting").attr('checked',false);
		   }
	   }
	   
	   attachment2_checkbox_for_deleting=getCookie("enquete_edit_attachment2_checkbox_for_deleting");
	   if(attachment2_checkbox_for_deleting!=null&&attachment2_checkbox_for_deleting!="null")
	   {
		   if(attachment2_checkbox_for_deleting=='1')
		   {
			   $("#Enquete_attachment2_checkbox_for_deleting").attr('checked',true);
                           $fileInput=$("#Enquete_attachment2_checkbox_for_deleting").parent().parent().prev().find('input[type="file"]').eq(0);
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
                  $node1=$("#Enquete_attachment2_checkbox_for_deleting").parent().parent().prev().prev();
                  $node1.remove();
                  $('<img alt="" src="<?php echo $this->assetsBase; ?>/css/common/img/img_photo01.jpg">').insertBefore($("#Enquete_attachment2_checkbox_for_deleting").parent().parent().prev());
		   }
		   else
		   {
			   $("#Enquete_attachment2_checkbox_for_deleting").attr('checked',false);
		   }
	   }
	   
	   attachment3_checkbox_for_deleting=getCookie("enquete_edit_attachment3_checkbox_for_deleting");
	   if(attachment3_checkbox_for_deleting!=null&&attachment3_checkbox_for_deleting!="null")
	   {
		   if(attachment3_checkbox_for_deleting=='1')
		   {
			   $("#Enquete_attachment3_checkbox_for_deleting").attr('checked',true);
                           $fileInput=$("#Enquete_attachment3_checkbox_for_deleting").parent().parent().prev().find('input[type="file"]').eq(0);
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
                  $node1=$("#Enquete_attachment3_checkbox_for_deleting").parent().parent().prev().prev();
                  $node1.remove();
                  $('<img alt="" src="<?php echo $this->assetsBase; ?>/css/common/img/img_photo01.jpg">').insertBefore($("#Enquete_attachment3_checkbox_for_deleting").parent().parent().prev());
		   }
		   else{
			   $("#Enquete_attachment3_checkbox_for_deleting").attr('checked',false);
		   }
	   }
	
     
           
      $('button[type="submit"]').click(function()
	  {  
			no=2; 
            deleteCookies("enquete_edit_from");  
			rs = checkAnser();
            //checkId();
			$.ajax({ 		
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/adminenquete/edit/?id=<?php echo $model->id;?>",    
				data: jQuery('#enquete_form').serialize(),

				success: function(msg){	
				
					                     
					  jQuery('#Enquete_title').prev().remove();                                       					                					
					  jQuery('#Enquete_content').prev().remove(); 
					  jQuery('#anser-boxs').prev().remove();                                      					
					  if(msg!='[]'|checkFile()==false)
					  {
							data=$.parseJSON(msg);
							if(data.Enquete_title)
							{
								 div=document.createElement('div');
								 $(div).addClass('alert');
								 $(div).addClass('error_message');
								 $(div).html(data.Enquete_title);
								 $(div).insertBefore($('#Enquete_title'));
								 
							} 
							if(data.Enquete_content)
							{
								 div=document.createElement('div');
								 $(div).addClass('alert');
								 $(div).addClass('error_message');
								 $(div).html(data.Enquete_content);
								 $(div).insertBefore($('#Enquete_content'));
								 
							} 
							if (rs == 1)
							{
								div = document.createElement('div');
								$(div).addClass('alert');
								$(div).addClass('error_message');
								$(div).html("<?php echo Lang::MSG_0031; ?>");
								$(div).insertBefore($('ol#anser-boxs'));
							}
					  	}							  															
					   else if(rs==3)
					   {
											
							if($("#Enquete_answer_type_1").is(':checked')==true)
							{
								 setCookie("enquete_edit_answer_type",1);
							}
							setCookie("enquete_edit_title",$("#Enquete_title").val());
							setCookie("enquete_edit_deadline_year",$("#Enquete_deadline_year").val());
							setCookie("enquete_edit_deadline_month",$("#Enquete_deadline_month").val()); 
							setCookie("enquete_edit_deadline_day",$("#Enquete_deadline_day").val());
							
							valcontent=$("#Enquete_content").val();
							val=valcontent.replace(/\n/g, "<br/>");
							setCookie("enquete_edit_content",val);
							
							comment=$("#Enquete_comment").val();
							val2=comment.replace(/\n/g, "<br/>");
							setCookie("enquete_edit_comment",val2);
							
							if($("#Enquete_attachment1_checkbox_for_deleting").attr('checked')==true)
							{
									setCookie("enquete_edit_attachment1_checkbox_for_deleting",'1');
							}
							else
							{
								setCookie("enquete_edit_attachment1_checkbox_for_deleting",'0');
							}
							if($("#Enquete_attachment2_checkbox_for_deleting").attr('checked')==true)
							{
								setCookie("enquete_edit_attachment2_checkbox_for_deleting",'1');
							}
							else
							{
								setCookie("enquete_edit_attachment2_checkbox_for_deleting",'0');
							}
							if($("#Enquete_attachment3_checkbox_for_deleting").attr('checked')==true)
							{
								setCookie("enquete_edit_attachment3_checkbox_for_deleting",'1');
							}
							else
							{
								setCookie("enquete_edit_attachment3_checkbox_for_deleting",'0');
							}
							setCookie("loaddata_edit",getData_edit(),1);
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
	
	function getData_edit()
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
			var item=getCookie("loaddata_edit");
		    if(item && item != "null"){
			item=$.parseJSON(item);
			
			var sum_li=0
			jQuery("ol#anser-boxs li#li_anser").each(function(index){
				sum_li = sum_li + 1;
			});	
			
			$.each(item, function(index) {
				index++;
				count=index-1
				t = 'answer_content'+count;
				$("#"+t).val(item[count].answer);
				
				if(count > sum_li){
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
