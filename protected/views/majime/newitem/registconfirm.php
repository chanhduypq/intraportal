<link href="<?php echo $this->assetsBase; ?>/css/majime/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>

<div class="wrap majime secondary newitems">
    <div class="container">
        <div class="contents confirm">
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>新商品情報 - 登録 確認</h2>
				</div>
                <div class="box">
				<?php $form = $this->beginWidget('CActiveForm', array(
					  'id' => 'newitem_registconfirm',    
					  'htmlOptions' => array('enctype' => 'multipart/form-data'),));?>
				<input type="hidden" name="file_index"/>
				<input type="hidden" name="regist" id="regist" value="1"/>
				<?php echo $form->hiddenField($model, 'id'); ?>  
				<?php echo $form->hiddenField($model, 'type'); ?>  
				<?php echo $form->hiddenField($model, 'title'); ?>  
				<?php echo $form->hiddenField($model, 'content'); ?>  
					<div class="cnt-box">
                    <div class="form-horizontal">
                        <div class="control-group">
                            <div class="control-label">種別:</div>
                            <div class="controls">
                                <p>
									<?php echo Constants::$typeNewItem[isset($model->type) ? $model->type : ''];?>
								</p>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="control-label">タイトル:</div>
                            <div class="controls">
                                <p>
									<?php echo htmlspecialchars($model->title);?>
								</p>
                            </div>
                        </div>
                        <div class="control-group">
							<div class="control-label">本文(or URL)</div>
                            <div class="controls">
							<p>
								 <?php echo nl2br(FunctionCommon::url_henkan($model->content));?>
							</p>
                            </div>
                        </div>
                        
                    </div>
					<div class="field attachements">
                      <?php $attachements = $this->beginWidget('ext.helpers.Form_new');?>
                      <?php $attachements->registConfirm11($model, $form,'majimenewitem',$this->assetsBase);?>
                      <?php $this->endWidget();?>
                    </div>	
				    </div><!-- /cnt-box -->	
				<?php $this->endWidget(); ?> 	
	                <div class="form-last-btn">
	                	<div class="btn170">
		                   <button type="submit" class="btn" id="back">
								<i class="icon-chevron-left"></i> もどる
							</button>
		                    <button class="btn btn-important" id="submit" type="submit">
								<i class="icon-chevron-right icon-white"></i> 登録
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
	jQuery(function($) 
	{
		$("body").attr('id','majime'); 
		no=1;
		function getUrl(no)
		{
            return "<?php echo Yii::app()->baseUrl;?>/common/deletecookie/?no="+no;
        }
		
		$(window).on('beforeunload', function()
		{
			setCookie("newitem_regist_form","confirm");            
			$.ajax
			({    
				type: "GET", 
				async:false,
				url: getUrl(no)
			});
		});
		setCookie("newitem_reg_type",$("#NewItem_type").val());
		setCookie("newitem_reg_title",$("#NewItem_title").val());
		setCookie("newitem_reg_content",$("#NewItem_content").val());
        setCookie("newitem_attachment1_checkbox_for_deleting",$("#NewItem_attachment1_checkbox_for_deleting").val());
        setCookie("newitem_attachment2_checkbox_for_deleting",$("#NewItem_attachment2_checkbox_for_deleting").val());
        setCookie("newitem_attachment3_checkbox_for_deleting",$("#NewItem_attachment3_checkbox_for_deleting").val());	
		
		$('button#submit').click(function()
		{  
            no=2;
			if(getCookie("newitem_regist_form")!=null && getCookie("newitem_regist_form")!=undefined)
			{ 
				deleteCookies("newitem_regist_form");
			}
            jQuery("input#regist").val('1');            
            jQuery("form#newitem_registconfirm").submit();
			
        });
		
		$('button#back').click(function()
		{  
            no=2;      
            setCookie("newitem_regist_form","confirm");   
			window.location="<?php echo Yii::app()->baseUrl;?>/majimenewitem/regist/";
        });
		
		$('a').click(function()
		{  
          img=$(this).find('img');
           
            if(img.length==1){
                no=2;
            }
            else{ 
                no=1;

            }
            if($(this).attr('id')==undefined)
			{
                return;
            }
            window.location="<?php echo Yii::app()->baseUrl;?>/majimenewitem/download/?file_name="+$(this).attr('id');
        });
        
	});
	
</script>