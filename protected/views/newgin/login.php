<script src="<?php echo $this->assetsBase; ?>/js/lib/jquery.numeric.js"></script>
<?php
if(Yii::app()->request->cookies['id'] !=""){
		$index_majime="majime";
		echo ("<SCRIPT LANGUAGE='JavaScript'>window.location.href='".$index_majime."';</SCRIPT>");
}
else {
?>

<div class="wrap login">

    <div class="container">
        <div class="contents detail">
        	
          <div class="mainBox detail">
         
            <div class="pageTtl"><h2>ログイン</h2></div>
            <div class="box">
            <p class="descriptionTxt">社員IDとパスワードを入力してください。</p>
             <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'login-form',  
					//'enableClientValidation'=>true,
					'clientOptions'=>array(
							'validateOnSubmit'=>true,
						),                   
                    'htmlOptions' => array(
                                       	 
                                          'class'=>'form-horizontal',
                                         
                                          ),
                     ));
			?>		
            
                <div class="cnt-box">
                
                  <div class="control-group">
                    <label class="control-label" for="staff_id">社員ID&nbsp;</label>
                    <div class="controls">
                     <?php echo $form->error($model, 'employee_number'); ?>
                     <?php echo $form->textField($model, 'employee_number', array('placeholder' => '社員IDを入力してください。', 'class' => 'input-xxlarge')); ?>

                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="staff_pw">パスワード&nbsp;</label>
                    <div class="controls">
                    <?php echo $form->error($model, 'passwd'); ?>
                     <?php echo $form->passwordField($model, 'passwd', array('placeholder' => 'パスワードを入力してください。', 'class' => 'input-xxlarge')); ?>
                   </div>
                  </div>
                  
                </div><!-- /cnt-box -->
                
                <div class="form-last-btn">
                  <p class="btn90">
                    <button type="submit" class="btn btn-important"><i class="icon-chevron-right icon-white"></i> ログイン</button>
                  </p>
                </div>
                <p class="mt20 alnC"><a href="<?php echo Yii::app()->baseUrl;?>/newgin/pw"><i class=" icon-question-sign"></i> パスワードをお忘れの方はこちら</a></p>
              <?php $this->endWidget(); ?>
            </div><!-- /box -->
            </div><!-- /mainBox -->
            
            
        </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div><!-- /wrap -->
<script type="text/javascript"> 
		
		jQuery(function($) {        
     	   $("body").attr('id','login');     
   		 $('#LoginForm_employee_number').numeric(false, function() { this.value = ""; this.focus(); });//           	
           $('button[type="submit"]').click(function(){ 
		 
			$("#LoginForm_employee_number").html("");		
			$("#LoginForm_passwd").html("");	
			$("#LoginForm_employee_number").removeClass("cerrorMessage alert error_message");		
			$("#LoginForm_passwd").removeClass("cerrorMessage alert error_message");
											
			$.ajax({    
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/",    
				data: jQuery('#login_form').serialize(),
				success: function(msg){	                        
					    jQuery('#login_form input').prev().remove();
					  	if(msg!='[]'){
									
									data=$.parseJSON(msg);
									if(data.LoginForm_employee_number){
										 div=document.createElement('div');
										 $(div).addClass('alert');
										 $(div).addClass('error_message');
										 $(div).insertBefore($('#LoginForm_employee_number')); 
									} 
									if(data.LoginForm_passwd){
										 div=document.createElement('div');
										 $(div).addClass('alert');
										 $(div).addClass('error_message');
										 $(div).insertBefore($('#LoginForm_passwd')); 
									} 	
					  	}	
						
				}	  
			});
			
		});    
           errorDivs=jQuery('div.errorMessage');
            for(i=0,n=errorDivs.length;i<n;i++){
                if(jQuery(errorDivs[i]).html()!=""){                     
                    jQuery(errorDivs[i]).addClass('alert');
                    jQuery(errorDivs[i]).addClass('error_message');
                }
            }
            
        });
</script>
<?php }?>