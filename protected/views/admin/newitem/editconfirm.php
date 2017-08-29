



<div class="wrap admin secondary newitems">
  <div class="container">
    <div class="contents index">
      <div class="mainBox detail">
        <div class="pageTtl">
          <h2>新商品情報 - 修正 確認</h2>
        </div>
        <div class="box">
		<?php $form = $this->beginWidget('CActiveForm', array(
			  'id' => 'newitem_editconfirm',
			  'htmlOptions' => array('enctype' => 'multipart/form-data',
			  'action'=>Yii::app()->baseUrl.'/adminreport/editconfirm/'),));?>
			<input type="hidden" name="file_index"/>
			<input type="hidden" name="edit" id="edit" value="1"/>
			<?php echo $form->hiddenField($model, 'id'); ?> 
			<?php echo $form->hiddenField($model, 'type'); ?>	
			<?php echo $form->hiddenField($model, 'title'); ?>  
			<?php echo $form->hiddenField($model, 'content'); ?> 
			<?php echo $form->hiddenField($model, 'created_date'); ?>  
          <div class="cnt-box">
            <div class="form-horizontal">
              <div class="control-group">
                <div class="control-label">種別:</div>
                <div class="controls">
                  <p>
					<?php echo Constants::$typeNewItem[$model->type];?>
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
			 <?php $attachements->editConfirm11($model, $form,'adminnewitem',$this->assetsBase);?>
			 <?php $this->endWidget();?>
			</div>
          </div>
          <!-- /cnt-box -->
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
		setCookie("newitem_edit_type",$("#NewItem_type").val());
        setCookie("newitem_edit_title",$("#NewItem_title").val());
        setCookie("newitem_edit_content",$("#NewItem_content").val());
        setCookie("newitem_edit_attachment1_checkbox_for_deleting",$("#NewItem_attachment1_checkbox_for_deleting").val());
        setCookie("newitem_edit_attachment2_checkbox_for_deleting",$("#NewItem_attachment2_checkbox_for_deleting").val());
        setCookie("newitem_edit_attachment3_checkbox_for_deleting",$("#NewItem_attachment3_checkbox_for_deleting").val());        
		
        no=1;
        function getUrl(no)
		{
            return "<?php echo Yii::app()->baseUrl;?>/common/deletecookie/?no="+no;
        }
        
        $(window).on('beforeunload', function()
		{
            setCookie("newitem_edit_form","confirm");            
            
            $.ajax({    
                    type: "GET", 
                    async:false,
                    url: getUrl(no)


            });
        }); 
        
        $('button#submit').click(function()
		{  
            no=2;
			if(getCookie("newitem_edit_form")!=null && getCookie("newitem_edit_form")!=undefined)
			{
				deleteCookies("newitem_edit_form");
			}
            jQuery("input#edit").val('1');            
            jQuery("form#newitem_editconfirm").submit();
        });
		
        $('button#back').click(function()
		{  
                    no=2;
            setCookie("newitem_edit_form","confirm");   
           
            window.location="<?php echo Yii::app()->baseUrl;?>/adminnewitem/edit/?id=<?php echo $model->id;?>"+"&type="+getCookie("newitem_edit_type");
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
			//Use down load form controller majimenewitem
            window.location="<?php echo Yii::app()->baseUrl;?>/majimenewitem/download/?file_name="+$(this).attr('id');
        });
    });
</script>