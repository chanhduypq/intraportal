<link href="<?php echo $this->assetsBase; ?>/css/majime/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>
<div class="wrap majime secondary inquiry">

    <div class="container">
        <div class="contents add_confirm">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>管理者へのお問い合わせ - 確認</h2>
				</div>
                
                <div class="box">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'inquiry_form',
                        'htmlOptions' => array(                            
                            'class' => 'form-horizontal',
                            
                        ),
                    ));
                    ?>
                    <input type="hidden" name="regist" id="regist" value="1"/>
                    <div class="form-horizontal">
	                    <div class="control-group">
	                        <div class="control-label">件名:</div>
	                        <div class="controls">
	                            <p>
									<?php echo htmlspecialchars($_POST['inquiry_name']);?>
								</p>
                            	<input type="hidden" name="inquiry_name" id="inquiry_name" value="<?php echo $_POST['inquiry_name'] ?>"/>
	                        </div>
	                    </div>
	
	                    <div class="control-group">
	                        <div class="control-label">内容</div>
	                        <div class="controls">
	                            <p>
									<?php echo nl2br(htmlspecialchars($_POST['inquiry_content']));?>	
								</p>
                            	<input type="hidden" name="inquiry_content" id="inquiry_content" value="<?php echo $_POST['inquiry_content'] ?>"/>
	                        </div>
	                    </div>
					</div>
				<?php $this->endWidget(); ?>	
	                <div class="form-last-btn">
	                	<div class="btn170">
		                    <button type="submit" class="btn" onclick="back();">
								<i class="icon-chevron-left"></i> もどる
							</button>
		                    <button type="submit" class="btn btn-important" onclick="submit()" >
								<i class="icon-chevron-right icon-white"></i> 送信
							</button>
	                    </div>
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
	function back()
	{        
         window.location="<?php echo Yii::app()->baseUrl.'/majimeinquiry/add/'?>"; 
    }
	
	function submit()
	{
        //jQuery("input#regist").val('1');
        //jQuery("input#regist").val('1');
        jQuery("input#regist").val('1');
        jQuery("form#inquiry_form").attr('action','<?php echo Yii::app()->baseUrl;?>/majimeinquiry/addconfirm/');
        jQuery("form#inquiry_form").submit();
    }
</script>
