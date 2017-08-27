<link href="<?php echo $this->assetsBase; ?>/css/asobi/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>
<div class="wrap asobi secondary hobby_new">

    <div class="container">
        <div class="contents confirm">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>趣味・サークルの広場 What'sNew - 登録 確認</h2>
				</div>
                <div class="box">
				<?php $form = $this->beginWidget('CActiveForm', array(
					  'id' => 'newitem_registconfirm',    
					  'htmlOptions' => array('enctype' => 'multipart/form-data'),));?>
				<input type="hidden" name="file_index"/>
				<input type="hidden" name="regist" id="regist" value="1"/>
				<?php echo $form->hiddenField($model, 'id'); ?>  
				<?php echo $form->hiddenField($model, 'category_id'); ?>  
				<?php echo $form->hiddenField($model, 'title'); ?>  
				<?php echo $form->hiddenField($model, 'content'); ?>  
                <div class="cnt-box">
                    <div class="form-horizontal">
                        <div class="control-group">
                            <div class="control-label">カテゴリー:</div>
								<div class="controls">
								 <?php if(!is_null($model->category_id) && !empty($model->category_id)):?>
									<?php $categories=Yii::app()->db->createCommand()
									   ->select('*')
									   ->from('category')
									   ->where("id=$model->category_id")
									   ->queryRow();?>
									<p>
										<span class="label" style="background-color:<?php echo !empty($categories['background_color']) ? $categories['background_color'] : '' ?>; color:<?php echo !empty($categories['text_color']) ? $categories['text_color'] :''?>;">
											<?php echo htmlspecialchars($categories['category_name']);?>
										</span>
									</p>
								 <?php endif; ?>	
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
                            <div class="control-label">本文</div>
                            <div class="controls">
                                <p>
									<?php echo nl2br(FunctionCommon::url_henkan($model->content));?>
								</p>
                            </div>
                        </div>
                        
                    </div>
					<div class="field attachements">
                      <?php $attachements = $this->beginWidget('ext.helpers.Form_new');?>
                      <?php $attachements->registConfirm11($model, $form,'asobihobby_new',$this->assetsBase);?>
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
        <p id="page-top">
			<a href="#wrap">PAGE TOP</a>
	</p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div>
<!-- /wrap -->
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
			setCookie("hobby_new_regist_form","confirm");            
			// $.ajax
			// ({    
				// type: "GET", 
				// async:false,
				// url: getUrl(no)
			// });
		});

		setCookie("hobby_new_reg_type",$("#Hobby_new_category_id").val());
		setCookie("hobby_new_reg_title",$("#Hobby_new_title").val());
		setCookie("hobby_new_reg_content",$("#Hobby_new_content").val());
        setCookie("hobby_new_reg_attachment1_checkbox_for_deleting",$("#Hobby_new_attachment1_checkbox_for_deleting").val());
        setCookie("hobby_new_reg_attachment2_checkbox_for_deleting",$("#Hobby_new_attachment2_checkbox_for_deleting").val());
        setCookie("hobby_new_reg_attachment3_checkbox_for_deleting",$("#Hobby_new_attachment3_checkbox_for_deleting").val());	
		
		$('button#submit').click(function()
		{  
            no=2;
            deleteCookies("hobby_new_regist_form");
            jQuery("input#regist").val('1');            
            jQuery("form#newitem_registconfirm").submit();
        });
		
		$('button#back').click(function()
		{  
            setCookie("hobby_new_regist_form","confirm");   
            // $.ajax({    
                    // type: "GET", 
                    // async:false,
                    // url: getUrl(1)
            // });
            window.location="<?php echo Yii::app()->baseUrl;?>/asobihobby_new/regist";
        });
		
		$('a').click(function()
		{  
            no=2;
            if($(this).attr('id')==undefined)
			{
                return;
            }
            window.location="<?php echo Yii::app()->baseUrl;?>/asobihobby_new/download/?file_name="+$(this).attr('id');
        });
        
	});

</script>