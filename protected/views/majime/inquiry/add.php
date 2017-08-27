<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/majime/css/secondary.css" rel="stylesheet" type="text/css"/>
<?php //session_start(); ?>
<div class="wrap majime secondary inquiry">

    <div class="container">
        <div class="contents add">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>管理者へのお問い合わせ</h2>
						<a href="<?php echo Yii::app()->baseUrl?>/majime/" class="btn btn-important">
							<i class="icon-home icon-white"></i> マジメのTopへ戻る
						</a>
				</div>
				<div class="box">
                
                    
                 <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'inquiry_form',
                        'htmlOptions' => array(                            
                            'class' => 'form-horizontal',
                            'onsubmit' => 'return false;',
                        ),
                    ));
                    ?>   
                <div class="cnt-box">

                    <div class="control-group">
                        <label class="control-label" for="title">件名&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	<div id="name_error" class="alert error_message"><?php echo Lang::MSG_0002 ?></div>
                        	<input value="<?php if(isset($_SESSION['inquiry_name'])){echo $_SESSION['inquiry_name'];}?>" name="inquiry_name" id="inquiry_name" maxlength="256"  class="input-xxlarge" type="text" placeholder="件名を入力してください。[25文字]" autofocus>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="content">内容&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	<div id="content_error" class="alert error_message"><?php echo Lang::MSG_0003 ?></div>
                        	<textarea name="inquiry_content" id="inquiry_content" rows="7" maxlength = "3000" class="input-xxlarge" placeholder="お問い合わせ内容を入力してください。"><?php if(isset($_SESSION['inquiry_content'])){echo $_SESSION['inquiry_content'];}?></textarea>
                        </div>
                    </div>
                    
                </div><!-- /cnt-box -->
                
                <div class="form-last-btn">
                	<p class="btn80">
	                    <button id="inquiry" type="submit" class="btn btn-important">
							<i class="icon-chevron-right icon-white">　</i> 確認
						</button>
                    </p>
                </div>
                
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
         $(document).ready(function(){
          $('#name_error').hide();
          $('#name_error_max').hide();
          $('#content_error').hide();
          $('#content_error_max').hide();
          $("#inquiry").click(function(){
            var name, content, name_max, content_max;
            name =  $("#inquiry_name").val();
            content =  $("#inquiry_content").val();
            name_max = name.length;
            content_max = content.length;
            //alert(name_max);
            if(name == ''){
                $('#name_error').show();
            }else{
                 $('#name_error').hide();
            }
            if(name_max > 256){
                $('#name_error_max').show();
            }else{
                 $('#name_error_max').hide();
            }
            if(content == ''){
                $('#content_error').show();
            }else{
                 $('#content_error').hide();
            }
            if(content > 3000){
                $('#content_error_max').show();
            }else{
                 $('#content_error_max').hide();
            }
            if(name != '' && content != '' && name_max <= 256 && content_max <= 3000){
                //$('#inquiry_form').attr('onsubmit','return true;');
                //$('#inquiry_form').submit();
                $("#inquiry_form").attr('action','<?php echo Yii::app()->baseUrl;?>/majimeinquiry/addconfirm/');
                $('#inquiry_form').attr('onsubmit','return true;');
                $("#inquiry_form").submit();
            }
          });
        }); 
</script>