

<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto_not_download_img.js"></script>

<script type="text/javascript">

function checkFile(){
    
    var result	 = true;
    $("#error_message1").html("");
    $("#error_message1").removeClass("alert error_message");    
    $("#error_message1").html("");
    $("div#error_message1").removeClass("alert error_message");
    var checkBox1  = jQuery('#User_photo_checkbox_for_deleting').is(":checked");
    if(checkBox1==true){
        return true;
    }

    //check format file
    var arr_file	   = [".jpg" , ".gif", ".png", ".jpeg"];			
    var attachment1 = jQuery('#User_photo').val();

    checkFile1	   = attachment1.substr(attachment1.lastIndexOf('.'));
    checkFile1	   = checkFile1.toLowerCase();
    file1			   = jQuery.inArray(checkFile1, arr_file);
    if(checkBox1 == false && file1 == -1 && attachment1 !="")
    {
               jQuery("#error_message1").html("<?php echo Lang::MSG_0033; ?>");	
               jQuery("#error_message1").addClass("alert error_message");
               result = false;
    }
    return result;
}  
    function day(day_number) {
        jQuery('#User_birthday_day').html("");
        for (i = 1; i <= day_number; i++) {
            jQuery('#User_birthday_day').append("<option value=" + i + ">" + i + "</option>");
        }
    }

    jQuery(function($) {
        $('img#not_download').contextmenu( function() {
            return false;
        });
        $("body").delegate("img#fullResImage","contextmenu",function(){
          return false;
        });
$('input#User_photo_checkbox_for_deleting').click (function (){ 
    if($(this).attr("id")!=undefined && $(this).attr("id")=="User_cancel_random"){
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
                      $('<img alt="" src="<?php echo $this->assetsBase; ?>/css/common/img/img_dummyman.jpg">').insertBefore($(this).parent().parent().prev());                      
                 }
            });
        $("#user_form").attr('action','<?php echo Yii::app()->baseUrl;?>/adminuser/registconfirm/');          
        employee_number=getCookie("user_regist_employee_number");
        role_id=getCookie("user_regist_role_id");
        mailaddr=getCookie("user_regist_mailaddr");
        lastname=getCookie("user_regist_lastname");
        firstname=getCookie("user_regist_firstname");
        lastname_kana=getCookie("user_regist_lastname_kana");
        firstname_kana=getCookie("user_regist_firstname_kana");
        birthday_year=getCookie("user_regist_birthday_year");
        birthday_month=getCookie("user_regist_birthday_month");
        birthday_day=getCookie("user_regist_birthday_day");
        joindate=getCookie("user_regist_joindate");
        user_edit_cancel_random=getCookie("user_regist_cancel_random");

        catchphrase=getCookie("user_regist_catchphrase");
        comment=getCookie("user_regist_comment");
		
		//begin 01/11/2013
		division1=getCookie("user_regist_division1");
		division2=getCookie("user_regist_division2");
		division3=getCookie("user_regist_division3");
		division4=getCookie("user_regist_division4");
		 
		div_intro_modifiable_flag1=getCookie("user_regist_div_intro_modifiable_flag1");
		div_intro_modifiable_flag2=getCookie("user_regist_div_intro_modifiable_flag2");
		div_intro_modifiable_flag3=getCookie("user_regist_div_intro_modifiable_flag3");
		div_intro_modifiable_flag4=getCookie("user_regist_div_intro_modifiable_flag4");
		
		position1=getCookie("user_regist_position1");
		position2=getCookie("user_regist_position2");
		position3=getCookie("user_regist_position3");
		position4=getCookie("user_regist_position4");
       	//end
        
       if(employee_number!=null&&employee_number!="null"){
           $("#User_employee_number").val(employee_number);
       }
       else{
           jQuery('#photo_error').remove();
       }
       if(role_id!=null&&role_id!="null"){
           $("#User_role_id").val(role_id);
       }
       if(mailaddr!=null&&mailaddr!="null"){
           $("#User_mailaddr").val(mailaddr);
       }
       if(lastname!=null&&lastname!="null"){
           $("#User_lastname").val(lastname);
       }
       if(firstname!=null&&firstname!="null"){
           $("#User_firstname").val(firstname);
       }
       if(lastname_kana!=null&&lastname_kana!="null"){
           $("#User_lastname_kana").val(lastname_kana);
       }
       if(firstname_kana!=null&&firstname_kana!="null"){
           $("#User_firstname_kana").val(firstname_kana);
       }
       if(birthday_year!=null&&birthday_year!="null"){
           $("#User_birthday_year").val(birthday_year);
       }
       if(birthday_month!=null&&birthday_month!="null"){
           $("#User_birthday_month").val(birthday_month);
       }
       if(birthday_day!=null&&birthday_day!="null"){
           $("#User_birthday_day").val(birthday_day);
       }
       if(joindate!=null&&joindate!="null"){
           $("#User_joindate").val(joindate);
       }
       
       if(catchphrase!=null&&catchphrase!="null"){
           $("#User_catchphrase").val(catchphrase);
       }
       if(comment!=null&&comment!="null"){        
	
		   comment1=comment.replace(/<br ?\/?>|_/g, '\n');		
           $("#User_comment").val(comment1);
       }
	   //begin 01/11/2013
	   if(division1!=null&&division1!="null"){
           $("#User_division1").val(division1);
       }
	    if(position1!=null&&position1!="null"){
           $("#User_position1").val(position1);
       }
       if(user_edit_cancel_random!=null&&user_edit_cancel_random!="null"){
		   if(user_edit_cancel_random=='1'){
                   $("#User_cancel_random").attr('checked',true);
            }
            else{
                $("#User_cancel_random").attr('checked',false);
            }
       }
	    if(div_intro_modifiable_flag1!=null&&div_intro_modifiable_flag1!="null"){
           //$("#User_div_intro_modifiable_flag1").val(div_intro_modifiable_flag1);
		    if(div_intro_modifiable_flag1=='1'){
                   $("#User_div_intro_modifiable_flag1").attr('checked',true);
            }
       }
	   
	   if(division2!=null&&division2!="null"){
           $("#User_division2").val(division2);
       }
	    if(position2!=null&&position2!="null"){
           $("#User_position2").val(position2);
       }
	    if(div_intro_modifiable_flag2!=null&&div_intro_modifiable_flag2!="null"){
           //$("#User_div_intro_modifiable_flag2").val(div_intro_modifiable_flag2);
		   if(div_intro_modifiable_flag2=='1'){
                   $("#User_div_intro_modifiable_flag2").attr('checked',true);
            }
       }
	   
	   if(division3!=null&&division3!="null"){
           $("#User_division3").val(division3);
       }
	    if(position3!=null&&position3!="null"){
           $("#User_position3").val(position3);
       }
	   if(div_intro_modifiable_flag3!=null&&div_intro_modifiable_flag3!="null"){
           //$("#User_div_intro_modifiable_flag2").val(div_intro_modifiable_flag2);
		   if(div_intro_modifiable_flag3=='1'){
                   $("#User_div_intro_modifiable_flag3").attr('checked',true);
            }
       }
	   
	   if(division4!=null&&division1!="null"){
           $("#User_division4").val(division4);
       }
	    if(position4!=null&&position4!="null"){
           $("#User_position4").val(position4);
       }
	    if(div_intro_modifiable_flag4!=null&&div_intro_modifiable_flag4!="null"){
           //$("#User_div_intro_modifiable_flag4").val(div_intro_modifiable_flag4);
		   if(div_intro_modifiable_flag4=='1'){
                   $("#User_div_intro_modifiable_flag4").attr('checked',true);
            }
       }
	   //end 

       photo_checkbox_for_deleting=getCookie("user_regist_photo_checkbox_for_deleting");
           if(photo_checkbox_for_deleting!=null&&photo_checkbox_for_deleting!="null"){
               if(photo_checkbox_for_deleting=='1'){
                   $("#User_photo_checkbox_for_deleting").attr('checked',true);
               }
               else{
                   $("#User_photo_checkbox_for_deleting").attr('checked',false);
               }
           }
       
        
        /**
         * 
         */
        var year = $("#User_birthday_year").val();
        var month = $("#User_birthday_month").val();
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
        if(birthday_day!=null&&birthday_day!="null"){
               daySelected=birthday_day;
        }
        else{
            daySelected='<?php echo $model->birthday_day;?>';
        }
        
        
        options=$('#User_birthday_day option');
        for(i=1,n=options.length;i<=n;i++){
             if($(options[i]).attr('value')==daySelected){                
                 $(options[i]).attr('selected','selected');
                 break;
             }           
        }
        $("body").attr('id', 'admin');
        /**
         * 
         */
        
        $("#User_birthday_month").change(function() {
            var year = $("#User_birthday_year").val();
            var month = $("#User_birthday_month").val();
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
        });
        $("#User_birthday_year").change(function() {
            var year = $("#User_birthday_year").val();
            var month = $("#User_birthday_month").val();
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


        });
        /**
         * 
         */
        $('button#next').click(function() {
          
        	
		    deleteCookies("user_regist_from");    
            $.ajax({
                type: "POST",
                async: true,
                url: "<?php echo Yii::app()->baseUrl; ?>/adminuser/regist/",
                data: jQuery('#user_form').serialize(),
                success: function(msg) {
                    jQuery('#User_role_id').prev().remove();
                    jQuery('#User_employee_number').prev().remove();
                    jQuery('#User_mailaddr').prev().remove();
                    jQuery('#User_lastname').prev().remove();
                    jQuery('#User_lastname').prev().remove();
                    jQuery('#User_lastname_kana').prev().remove();
                    jQuery('#User_lastname_kana').prev().remove();
                    jQuery('#User_joindate').prev().remove();
                  
                    jQuery('#User_catchphrase').prev().remove();
                    jQuery('#User_comment').prev().remove();                    
                    jQuery("#error_message1").html("").removeClass("alert error_message");                    
                    jQuery('#photo_error').remove();

                    date=jQuery("#User_joindate").val();          
					
                    if (msg != '[]'|(date!=""&&(date.length<4||date[0]=='0'))|checkFile()==false|checkDivision()==false) {
                        data = $.parseJSON(msg);
                        if (data.User_role_id) {
                            div = document.createElement('div');
                            $(div).addClass('alert');
                            $(div).addClass('error_message');
                            $(div).html(data.User_role_id);
                            $(div).insertBefore($('#User_role_id'));

                        }
                        if (data.User_employee_number) {
                            div = document.createElement('div');
                            $(div).addClass('alert');
                            $(div).addClass('error_message');
                            $(div).html(data.User_employee_number);
                            $(div).insertBefore($('#User_employee_number'));
                        }
                        if (data.User_mailaddr) {
                            div = document.createElement('div');
                            $(div).addClass('alert');
                            $(div).addClass('error_message');
                            $(div).html(data.User_mailaddr);
                            $(div).insertBefore($('#User_mailaddr'));
                        }
                        if (data.User_lastname) {
                            div = document.createElement('div');
                            $(div).addClass('alert');
                            $(div).addClass('error_message');
                            $(div).html(data.User_lastname);
                            $(div).insertBefore($('#User_lastname'));
                        }
                        if (data.User_firstname) {
                            div = document.createElement('div');
                            $(div).addClass('alert');
                            $(div).addClass('error_message');
                            $(div).html(data.User_firstname);
                            $(div).insertBefore($('#User_lastname'));
                        }
                        if(data.User_lastname&&data.User_firstname){
                            $('#User_lastname').prev().remove();
                            $('#User_lastname').prev().remove();
                            div = document.createElement('div');
                            $(div).addClass('alert');
                            $(div).addClass('error_message');
                            $(div).html("<?php echo Lang::MSG_0103;?>");
                            $(div).insertBefore($('#User_lastname'));
                        }
                        if (data.User_lastname_kana) {
                            div = document.createElement('div');
                            $(div).addClass('alert');
                            $(div).addClass('error_message');
                            $(div).html(data.User_lastname_kana);
                            $(div).insertBefore($('#User_lastname_kana'));
                        }

                        if (data.User_firstname_kana) {
                            div = document.createElement('div');
                            $(div).addClass('alert');
                            $(div).addClass('error_message');
                            $(div).html(data.User_firstname_kana);
                            $(div).insertBefore($('#User_lastname_kana'));
                        }
                        if(data.User_lastname_kana&&data.User_firstname_kana){
                            $('#User_lastname_kana').prev().remove();
                            $('#User_lastname_kana').prev().remove();
                            div = document.createElement('div');
                            $(div).addClass('alert');
                            $(div).addClass('error_message');
                            $(div).html("<?php echo Lang::MSG_0104;?>");
                            $(div).insertBefore($('#User_lastname_kana'));
                        }
                        if (data.User_joindate) {
                            div = document.createElement('div');
                            $(div).addClass('alert');
                            $(div).addClass('error_message');
                            $(div).html(data.User_joindate);
                            $(div).insertBefore($('#User_joindate'));
                        }
                        else{                            
                            if(date.length<4||date[0]=='0'){
                                div = document.createElement('div');
                                $(div).addClass('alert');
                                $(div).addClass('error_message');
                                $(div).html('<?php echo Lang::MSG_0023;?>');
                                $(div).insertBefore($('#User_joindate'));

                            }
                        }
                       
					
                        if (data.User_catchphrase) {
                            div = document.createElement('div');
                            $(div).addClass('alert');
                            $(div).addClass('error_message');
                            $(div).html(data.User_catchphrase);
                            $(div).insertBefore($('#User_catchphrase'));
                        }
                        if (data.User_comment) {
                            div = document.createElement('div');
                            $(div).addClass('alert');
                            $(div).addClass('error_message');
                            $(div).html(data.User_comment);
                            $(div).insertBefore($('#User_comment'));
                        }
                         $('body,html').animate({
                            scrollTop: 0
                        }, 500);

                    }
                    else {                                        
                        /**
                         * 
                         */
						 
                        roleId = $("#User_role_id").val();
                        roleName = $("#User_role_id option[value='" + roleId + "']").html();
                        $("#User_role_name").val(roleName);
                        $("#User_birthday").val($("#User_birthday_year").val() + '/' + $("#User_birthday_month").val() + '/' + $("#User_birthday_day").val())
                        /**
                         * 
                         */
                         jQuery('#user_form').attr('onsubmit','return true;')
                           setCookie("user_regist_employee_number",$("#User_employee_number").val());
                           setCookie("user_regist_role_id",$("#User_role_id").val());
                           setCookie("user_regist_mailaddr",$("#User_mailaddr").val());
                           setCookie("user_regist_lastname",$("#User_lastname").val());
                           setCookie("user_regist_firstname",$("#User_firstname").val());
                           setCookie("user_regist_lastname_kana",$("#User_lastname_kana").val());
                           setCookie("user_regist_firstname_kana",$("#User_firstname_kana").val());
                           setCookie("user_regist_birthday_year",$("#User_birthday_year").val());
                           setCookie("user_regist_birthday_month",$("#User_birthday_month").val());
                           setCookie("user_regist_birthday_day",$("#User_birthday_day").val());
                           setCookie("user_regist_joindate",$("#User_joindate").val());
                          
                           setCookie("user_regist_catchphrase",$("#User_catchphrase").val());
                           //begin 01/11/2013
						   setCookie("user_regist_division1",$("#User_division1").val());
						   setCookie("user_regist_position1",$("#User_position1").val());
																		     
						  
						   
						   setCookie("user_regist_division2",$("#User_division2").val());
						   setCookie("user_regist_position2",$("#User_position2").val());
						   
						   
						   setCookie("user_regist_division3",$("#User_division3").val());
						   setCookie("user_regist_position3",$("#User_position3").val());
						   
						   
						   setCookie("user_regist_division4",$("#User_division4").val());
						   setCookie("user_regist_position4",$("#User_position4").val());
						   
						   //end
                           
                           if($("#User_photo_checkbox_for_deleting").is(':checked')){
                                    setCookie("user_regist_photo_checkbox_for_deleting",'1');
                            }
                            else{
                                    setCookie("user_regist_photo_checkbox_for_deleting",'0');
                            }
                            if($("#User_div_intro_modifiable_flag4").is(':checked')){
                                    setCookie("user_regist_div_intro_modifiable_flag4",'1');
                            }
                            else{
                                    setCookie("user_regist_div_intro_modifiable_flag4",'0');
                            }
                            if($("#User_div_intro_modifiable_flag3").is(':checked')){
                                    setCookie("user_regist_div_intro_modifiable_flag3",'1');
                            }
                            else{
                                    setCookie("user_regist_div_intro_modifiable_flag3",'0');
                            }
                            if($("#User_div_intro_modifiable_flag2").is(':checked')){
                                    setCookie("user_regist_div_intro_modifiable_flag2",'1');
                            }
                            else{
                                    setCookie("user_regist_div_intro_modifiable_flag2",'0');
                            }
                            if($("#User_div_intro_modifiable_flag1").is(':checked')){
                                    setCookie("user_regist_div_intro_modifiable_flag1",'1');
                            }
                            else{
                                    setCookie("user_regist_div_intro_modifiable_flag1",'0');
                            }
                            if($("#User_cancel_random").is(':checked')){
                                    setCookie("user_regist_cancel_random",'1');
                            }
                            else{
                                    setCookie("user_regist_cancel_random",'0');
                            }
                           
                           val=$("#User_comment").val();
                            val=val.replace(/\n/g, "<br/>"); 
                            setCookie("user_regist_comment",val);
                        jQuery('#user_form').submit();
                    }
                }
            });
        });

    });
	//begin 01/11/2013
	function checkDivision() {
		 resuft=true;
		 jQuery("#error_message_division1").html("").removeClass("alert error_message_division1");
         User_division_1=$("#User_division1").val();
		/* User_division_2=$("#User_division2").val();
		 User_division_3=$("#User_division3").val();
		 User_division_4=$("#User_division4").val();*/

         if(User_division_1=="")
        	{
					$("#error_message_division1").append('<?php echo Lang::MSG_0119?>');	
					$("#error_message_division1").addClass("alert error_message_division1");	
					resuft=false;	
			}
		/* else if (
		 (User_division_1!="" && (User_division_1==User_division_2)|(User_division_1==User_division_3)|(User_division_1==User_division_4))
		 |(User_division_2!="" && (User_division_2==User_division_3)|(User_division_2==User_division_4))
		 |(User_division_3 !="" && User_division_3==User_division_4)
		 ){
			 		$("#error_message_division1").append('<?php echo Lang::MSG_0128?>');	
					$("#error_message_division1").addClass("alert error_message_division1");	
					resuft=false;
			 }*/
		return resuft;	
    }
	//end
</script>
<div class="wrap admin secondary user">

    <div class="container">
        <div class="contents detail">

            <div class="mainBox">
                <div class="pageTtl"><h2>ユーザー管理 - 登録</h2>
               	    <?php 
					if(Yii::app()->request->cookies['page']!= "") 
					{
						   $page = "index?page=".Yii::app()->request->cookies['page'];
							
					}else {$page ="";}
					?>
                    <span><a class="btn btn-important" href="<?php echo Yii::app()->baseUrl; ?>/adminuser/<?php echo $page;?>"><i class="icon-chevron-left icon-white"></i> 一覧に戻る</a></span></div>
                <div class="box">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'user_form',
                        'htmlOptions' => array(
                            'enctype' => 'multipart/form-data',
                            'class' => 'form-horizontal',  
                            'onsubmit'=>'return false;'
                        ),
                    ));
                    ?>                
                    <?php echo $form->hiddenField($model, 'photo_file_type'); ?>  
                    <?php echo $form->hiddenField($model, 'role_name'); ?>    
                    <?php echo $form->hiddenField($model, 'birthday'); ?>  

                    <div class="cnt-box">

                        <div class="baseDetailBox">
                            <div class="field attachements">
                                <div class="title">個人Data</div>
                            </div>
                            <div class="textBox boxL mt15 clearfix">

                                <div class="control-group">
                                    <label class="control-label" for="staff_nmb">社員番号&nbsp;
                                        <span class="label label-warning">必須</span></label>
                                    <div class="controls">
                                        <?php echo $form->error($model, 'employee_number'); ?>
                                        <?php echo $form->textField($model, 'employee_number', array('class' => 'input-xlarge', 'placeholder' => '社員番号を入力してください。')); ?>                                                                        
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="affili_role">役割名&nbsp;
                                        <span class="label label-warning">必須</span></label>
                                    <div class="controls">
                                        <?php echo $form->error($model, 'role_id'); ?>
                                        <?php echo $form->dropDownList($model, 'role_id', $model->allRoles, array('options' => array($model->role_id => array('selected' => true)), 'class' => 'input-xxlarge')); ?> 
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="mail">メールアドレス&nbsp;
                                        <span class="label label-warning">必須</span></label>
                                    <div class="controls">
                                        <?php echo $form->error($model, 'mailaddr'); ?>
                                        <?php echo $form->textField($model, 'mailaddr', array('class' => 'input-xlarge', 'placeholder' => 'メールアドレスを入力してください。')); ?>                                    
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="user_name">名前&nbsp;
                                        <span class="label label-warning">必須</span></label>
                                    <div class="controls">
                                        <?php echo $form->error($model, 'lastname'); ?>
                                        <?php echo $form->error($model, 'firstname'); ?>
                                        <?php echo $form->textField($model, 'lastname', array('class' => 'input-small', 'placeholder' => '姓を入力してください。')); ?>                                    
                                        <?php echo $form->textField($model, 'firstname', array('class' => 'input-small', 'placeholder' => '名を入力してください。')); ?>                                                                        
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="ruby">ふりがな&nbsp;
                                        <span class="label label-warning">必須</span></label>
                                    <div class="controls">
                                        <?php echo $form->error($model, 'lastname_kana'); ?>
                                        <?php echo $form->error($model, 'firstname_kana'); ?>
                                        <?php echo $form->textField($model, 'lastname_kana', array('class' => 'input-small', 'placeholder' => '姓を入力してください。')); ?>                                    
                                        <?php echo $form->textField($model, 'firstname_kana', array('class' => 'input-small', 'placeholder' => '名を入力してください。')); ?>                                                                                                            
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="title">生年月日&nbsp;
                                        <span class="label label-warning">必須</span></label>
                                    <div class="controls">                                             
                                        <?php echo $form->dropDownList($model, 'birthday_year', $model->allBirthdayYear, array('options' => array($model->birthday_year => array('selected' => true)), 'class' => 'input-small', 'style'=>'width:76px;')); ?> 
                                        -
                                        <?php echo $form->dropDownList($model, 'birthday_month', $model->allBirthdayMonth, array('options' => array($model->birthday_month => array('selected' => true)), 'class' => 'input-mini', 'style'=>'width:76px;')); ?> 
                                        -
                                        <?php echo $form->dropDownList($model, 'birthday_day', $model->allBirthdayDay, array('options' => array($model->birthday_day => array('selected' => true)), 'class' => 'input-mini', 'style'=>'width:76px;')); ?>                                     	                        	
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="joined_year">入社年&nbsp;
                                        <span class="label label-warning">必須</span></label>
                                    <div class="controls">
                                        <?php echo $form->error($model, 'joindate'); ?>
                                        <?php echo $form->textField($model, 'joindate', array('class' => 'input-xlarge', 'placeholder' => '入社年を入力してください。')); ?>                                                                        
                                    </div>
                                </div>                                
                            </div><!-- /boxL -->

                            <div class="textBox boxR clearfix">
                                <div class="building_photo">
                                    <div id="error_message1"></div>  
                                       <style>
                                            div.building_photo a{float:none !important;} 	
                                            a.a_base{float:none !important;}	
                                            img.img_base{ position:relative !important; float:none !important;}
                                        </style>
										<?php 
                                        $attachement4 = $this->beginWidget('ext.helpers.Form_new');
                                        $attachement4->regist14($model, $form,$attachment4_error,'adminuser',$this->assetsBase);
                                        $this->endWidget();
                                        ?>
                                </div>
                            </div><!-- /boxR -->
                       
                            <div class="clearfix" style="clear: both;">
                                
							<?php
							//begin 01/11/2013
                            for($i=1;$i<=4;$i++){
                            ?>
                            	<div class="units">    
                                    <h4>所属先<?php echo $i;?></h4>
                                    
                                    <div class="control-group">
                                        <label class="control-label" for="department1">所属部署&nbsp;
                                        <?php
                                          if($i=='1'){
                                            echo "<span class=\"label label-warning\">必須</span>";
                                          }
                                        ?>
                                        </label>
                                        <div class="controls">
                                              <?php 
											  	if($i=='1'){
													echo "<div id='error_message_division1'></div>";	
												}
												
												$array_unit = array();
												foreach ($unit as $unit_name){
													   $array_unit[$unit_name['id']] = $unit_name['company_name']." ".$unit_name['branch_name']." ".$unit_name['unit_name'];
													   
												}
												echo $form->dropDownList($model,'division'.$i,$array_unit,  array('prompt'=>'選んで下さい' , 'class' => 'input-xxlarge')); 											                                
												?> 											 
                                             <label class="checkbox">
                                             <?php echo $form->checkBox($model,'div_intro_modifiable_flag'.$i); ?>
                                             この部署の紹介文の修正を許可する
                                            </label>                            	
                                        </div>
                                    </div>
        
                                    <div class="control-group">
                                        <label class="control-label" for="post1">役職名&nbsp;</label>
                                        <div class="controls">
                                              <?php 

												$array_post = array();
												
												foreach ($post as $post_name){
													   $array_post[$post_name['id']] = $post_name['post_name'];
												}
												echo $form->dropDownList($model,'position'.$i,$array_post,  array('prompt'=>'選んで下さい' , 'class' => 'input-large')); 					
												?> 
                                        </div>
                                    </div>
                                </div>
                            <?php	
                            }
							//end
                            ?>
                            </div>
                        </div><!-- /baseDetailBox -->
						
                        <div class="baseDetailBox">
                            <div class="field attachements">
                                <div class="title">紹介内容</div>
                            </div>
                            <div class="textBox mt15 clearfix">
                                <div class="control-group">
                                    <label class="control-label" for="field_copy">自動選出除外&nbsp;</label>
                                    <div class="controls">
                                        <label class="checkbox">
                                        <?php echo $form->checkBox($model,'cancel_random'); ?>&nbsp;今週のピックアップによる自動選出から除外する
                                        </label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="field_copy">キャッチコピー&nbsp;</label>
                                    <div class="controls">
                                        <?php echo $form->error($model, 'catchphrase'); ?>
                                        <?php echo $form->textField($model, 'catchphrase', array('class' => 'input-xlarge', 'placeholder' => 'キャッシュコピーを入力してください。')); ?>                                                                                                                                                                                                                        
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="field_comment">コメント&nbsp;</label>
                                    <div class="controls">
                                        <?php echo $form->error($model, 'comment'); ?>
                                        <?php echo $form->textarea($model, 'comment', array('placeholder' => 'コメントを入力してください。', 'class' => 'input-xxlarge', 'rows' => 7,'maxlength' => 2000)); ?>                            
                                    </div>
                                </div>
                            </div><!-- /textBox -->

                        </div><!-- /baseDetailBox -->



                    </div><!-- /cnt-box -->
                    <?php $this->endWidget(); ?>
                    <div class="form-last-btn">
                        <p class="btn80">
                            <button class="btn btn-important" type="submit" id="next"><i class="icon-chevron-right icon-white">&#12288;</i> 確認</button>
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
        <p id="page-top" style="display: none;"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->

    <div class="footer">
        <p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div>