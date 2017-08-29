



<div class="wrap admin secondary bounty">
  <div class="container">
    <div class="contents index">
      <div class="mainBox detail">
        <div class="pageTtl">
          <h2>懸賞金付き募集コンテンツ - 修正 確認</h2>
        </div>
        <div class="box">
          <div class="cnt-box">
		  	<?php $form = $this->beginWidget('CActiveForm', array(
					  'id' => 'bounty_editconfirm',
					  'htmlOptions' => array('enctype' => 'multipart/form-data',
					  'action'=>Yii::app()->baseUrl.'/adminreport/editconfirm/'),));?>
			<input type="hidden" name="file_index"/>
			<input type="hidden" name="edit" id="edit" value="1"/>
			<?php echo $form->hiddenField($model,'id'); ?>  
			<?php echo $form->hiddenField($model,'title'); ?>  
			<?php echo $form->hiddenField($model,'content'); ?>
			<?php echo $form->hiddenField($model,'prize'); ?>  
			<?php echo $form->hiddenField($model,'deadline_day'); ?>  
			<?php echo $form->hiddenField($model,'deadline_month'); ?> 
			<?php echo $form->hiddenField($model,'deadline_year'); ?>  
            <div class="form-horizontal">
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
				 <?php $attachements->editConfirm11($model, $form,'adminbounty',$this->assetsBase);?>
				 <?php $this->endWidget();?>
             </div>
          </div>
          <!-- /cnt-box -->
          <div class="cnt-box">
            <div class="control-group">
              <div class="control-label">懸賞内容</div>
              <div class="controls">
                <p>
					<?php echo nl2br(FunctionCommon::url_henkan($model->prize));?>	
                </p>
              </div>
            </div>
            <div class="control-group">
              <div class="control-label">募集締め切り日:</div>
              <div class="controls">
                <p>
					<?php echo $model->deadline_year.'/'.$model->deadline_month.'/'.$model->deadline_day;?>
				</p>
              </div>
            </div>
          </div>
          <?php $this->endWidget(); ?>  
            <div class="form-last-btn">
              <div class="btn170">
               <button type="submit" class="btn" id="back">
                  <i class="icon-chevron-left"></i>もどる
                </button>
                  <button class="btn btn-important" id="submit" type="submit">
                  <i class="icon-chevron-right icon-white"></i>更新
                </button>
              </div>
            </div>
           
        </div>
        <!-- /box -->
      </div>
      <!-- /mainBox -->
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
      <!-- /sideBox -->
    </div>
    <!-- /contents -->
    <p id="page-top">
      <a href="#wrap">PAGE TOP</a>
    </p>
  </div>
  <!-- /container -->
  <div class="footer">
    <p>COPYRIGHT (C) Newgin ALL RIGHTS RESERVED.</p>
  </div>
</div>
<!-- /wrap -->
<script type="text/javascript">

	 jQuery(function($) 
	 {  
        $("body").attr('id','admin');  
		setCookie("bounty_edit_title",$("#Bounty_title").val());
		setCookie("bounty_edit_content",$("#Bounty_content").val());
		setCookie("bounty_edit_prize",$("#Bounty_prize").val());
		setCookie("bounty_edit_deadline_year",$("#Bounty_deadline_year").val());
		setCookie("bounty_edit_deadline_month",$("#Bounty_deadline_month").val());
		setCookie("bounty_edit_deadline_day",$("#Bounty_deadline_day").val());
        setCookie("bounty_edit_attachment1_checkbox_for_deleting",$("#Bounty_attachment1_checkbox_for_deleting").val());
        setCookie("bounty_edit_attachment2_checkbox_for_deleting",$("#Bounty_attachment2_checkbox_for_deleting").val());
        setCookie("bounty_edit_attachment3_checkbox_for_deleting",$("#Bounty_attachment3_checkbox_for_deleting").val());	

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
            jQuery("form#bounty_editconfirm").submit();
        });
		
        $('button#back').click(function()
		{ 
                    no=2;
            setCookie("report_edit_form","confirm");   
           
            window.location="<?php echo Yii::app()->baseUrl;?>/adminbounty/edit/?id=<?php echo $model->id;?>";
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
            window.location="<?php echo Yii::app()->baseUrl;?>/majimebounty/download/?file_name="+$(this).attr('id');
        });
    });

   
</script>