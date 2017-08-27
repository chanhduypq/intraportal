<link href="<?php echo $this->assetsBase; ?>/css/common/css/report.css" rel="stylesheet"  media="screen" />
<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>
<div class="wrap admin secondary report">
    <div class="container">
        <div class="contents index">
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>リアルタイム社内報告 - 修正 確認</h2>
				</div>
                <div class="box">
				<?php $form = $this->beginWidget('CActiveForm', array(
					  'id' => 'report_editconfirm',
					  'htmlOptions' => array('enctype' => 'multipart/form-data',
					  'action'=>Yii::app()->baseUrl.'/adminreport/editconfirm/'),));?>
					<input type="hidden" name="file_index"/>
					<input type="hidden" name="edit" id="edit" value="1"/>
					<?php echo $form->hiddenField($model, 'id'); ?> 
					<?php echo $form->hiddenField($model, 'icon'); ?>	
					<?php echo $form->hiddenField($model, 'title'); ?>  
					<?php echo $form->hiddenField($model, 'content'); ?> 
					<?php echo $form->hiddenField($model, 'created_date'); ?>  
                    <div class="cnt-box">
                    <div class="form-horizontal">
							
                        <div class="control-group">
                            <div class="control-label">アイコン:</div>
							<div class="controls">
								<?php       
									switch($model->icon)
									{
										case 1:
										echo '<div class="ico help">'.Constants::$typeIconReport[$model->icon].'</div>';
										break;
										case 2:
										echo '<div class="ico eigyou">'.Constants::$typeIconReport[$model->icon].'</div>';
										break;
										case 3:
										echo '<div class="ico uwasa">'.Constants::$typeIconReport[$model->icon].'</div>';
										break;
										case 4:
										echo '<div class="ico seizou">'.Constants::$typeIconReport[$model->icon].'</div>';
										break;
										case 5:
										echo '<div class="ico gyousei">'.Constants::$typeIconReport[$model->icon].'</div>';
										break;
										case 6:
										echo '<div class="ico hall">'.Constants::$typeIconReport[$model->icon].'</div>';
										break;
										case 7:
										echo '<div class="ico kaihatsu">'.Constants::$typeIconReport[$model->icon].'</div>';
										break;
										case 8:
										echo '<div class="ico other">'.Constants::$typeIconReport[$model->icon].'</div>';
										break;
									}
								?>
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
						 <?php $attachements->editConfirm11($model, $form,'adminreport',$this->assetsBase);?>
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
								<i class="icon-chevron-right icon-white"></i> 更新
							</button>
	                    </div>
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
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
</div>

</div><!-- /wrap -->
<script type="text/javascript">

	 jQuery(function($) 
	 {  
        $("body").attr('id','admin');  
		setCookie("report_edit_icon",$("#Report_icon").val());
        setCookie("report_edit_title",$("#Report_title").val());
        setCookie("report_edit_content",$("#Report_content").val());
        setCookie("report_edit_attachment1_checkbox_for_deleting",$("#Report_attachment1_checkbox_for_deleting").val());
        setCookie("report_edit_attachment2_checkbox_for_deleting",$("#Report_attachment2_checkbox_for_deleting").val());
        setCookie("report_edit_attachment3_checkbox_for_deleting",$("#Report_attachment3_checkbox_for_deleting").val());        
		
        no=1;
        function getUrl(no)
		{
            return "<?php echo Yii::app()->baseUrl;?>/common/deletecookie/?no="+no;
        }
        
        $(window).on('beforeunload', function()
		{
            setCookie("report_edit_form","confirm");            
            
            $.ajax({    
                    type: "GET", 
                    async:false,
                    url: getUrl(no)


            });
        }); 
        
        $('button#submit').click(function()
		{  
            no=2;
            deleteCookies("report_edit_form");
            jQuery("input#edit").val('1');            
            jQuery("form#report_editconfirm").submit();
        });
		
        $('button#back').click(function()
		{  
                    no=2;
            setCookie("report_edit_form","confirm");   
           
            window.location="<?php echo Yii::app()->baseUrl;?>/adminreport/edit/?id=<?php echo $model->id;?>";
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
            window.location="<?php echo Yii::app()->baseUrl;?>/majimereport/download/?file_name="+$(this).attr('id');
        });
    });
</script>   