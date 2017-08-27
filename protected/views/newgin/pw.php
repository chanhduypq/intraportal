<div class="wrap login">

    <div class="container">
        <div class="contents detail">
        	
          <div class="mainBox detail">
            <div class="pageTtl"><h2>ログイン - パスワードの再送信</h2></div>
            <div class="box">
            <p class="descriptionTxt">社員IDとメールアドレスを入力してください。</p>
              <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'pw_form',                     
                    'htmlOptions' => array(
                                          'enctype' => 'multipart/form-data',
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
                    <label class="control-label" for="staff_pw">メールアドレス&nbsp;</label>
                    <div class="controls">
                     <?php echo $form->error($model, 'mailaddr'); ?>
                    <?php echo $form->textField($model, 'mailaddr', array('placeholder' => 'メールアドレスを入力してください。', 'class' => 'input-xxlarge')); ?>
                    </div>
                  </div>
                  
                </div><!-- /cnt-box -->
                <?php $this->endWidget(); ?>
                <div class="form-last-btn">
                  <p class="btn200">
                    <button type="button" class="btn" onclick="back();"><i class="icon-chevron-left"></i> もどる</button>                  
                    <button type="submit" class="btn btn-important"><i class="icon-chevron-right icon-white"></i> 問い合わせ</button>
                  </p>
                </div>
             
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
   		 });
        jQuery(function($){            
           $('button[type="submit"]').click(function(){  
		  					
			$.ajax({    
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/newgin/pw",    
				data: jQuery('#pw_form').serialize(),
				success: function(msg){	                        
					    jQuery('#pw_form input').prev().remove();
					  	if(msg!='[]'){
									
									data=$.parseJSON(msg);
									if(data.Pw_employee_number){
										 div=document.createElement('div');
										 $(div).addClass('alert');
										 $(div).addClass('error_message');
										 $(div).html(data.Pw_employee_number);
										 $(div).insertBefore($('#Pw_employee_number')); 
									} 
									if(data.Pw_mailaddr){
										 div=document.createElement('div');
										 $(div).addClass('alert');
										 $(div).addClass('error_message');
										 $(div).html(data.Pw_mailaddr);
										 $(div).insertBefore($('#Pw_mailaddr')); 
									} 	
					  	}							  															
					else{   

											 $("#pw_form").attr('action','<?php echo Yii::app()->baseUrl;?>/newgin/pw_complete');
                                            jQuery('#pw_form').attr('onsubmit','return true;');
                                            jQuery('#pw_form').submit();
											
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
		function back(){
        jQuery("form#pw_form").attr('action','<?php echo Yii::app()->baseUrl;?>/');
        jQuery("form#pw_form").submit();
		
    }
</script>