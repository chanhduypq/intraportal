
<link href="<?php echo $this->assetsBase; ?>/css/majime/css/bbs.css" rel="stylesheet" type="text/css"/>




<?php $attachment1=$model->attachment1;?>
<?php $attachment2=$model->attachment2;?>
<?php $attachment3=$model->attachment3;?>
<?php $attachment1_ext=FunctionCommon::getExtensionFile($model->attachment1);?>
<?php $attachment2_ext=FunctionCommon::getExtensionFile($model->attachment2);?>
<?php $attachment3_ext=FunctionCommon::getExtensionFile($model->attachment3);?>

<div class="wrap majime secondary bounty">
  <div class="container">
    <div class="contents detail">
      <div class="mainBox detail">
        <div class="pageTtl">
          <h2>懸賞金付き募集コンテンツ - 詳細</h2>
			<span>
				<?php if(!empty(Yii::app()->request->cookies['page'])): ?>	
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/majimebounty/index?page=<?php echo Yii::app()->request->cookies['page']?>" class="btn btn-important">
						<i class="icon-chevron-left icon-white"></i> 一覧に戻る
					</a>
				<?php else : ?>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/majimebounty" class="btn btn-important">
						<i class="icon-chevron-left icon-white"></i> 一覧に戻る
					</a>
				<?php endif; ?>
			</span>
        </div>
        <div class="box">
		 <?php if(!is_null($model)): ?>				
           <div class="postsDate">
			 <i class="icon-pencil"></i>投稿日時：
				<span class="date">
					<?php echo FunctionCommon::formatDate($model->created_date); ?>
				</span>
	   	        <span class="time">
				   <?php echo FunctionCommon::formatTime($model->created_date); ?>
				</span>
		   </div>
          <div class="detailTtl">
            <h3 class="ttl">
				<?php echo htmlspecialchars($model->title);?>
			</h3>
            <p class="area">
			  <?php 
					$arrUser = FunctionCommon::getInforUser($model->contributor_id);
					if(isset($arrUser)){ echo $arrUser; }
				?>
			</p>
          </div>
          <p class="cnt-box">
			<?php echo nl2br(FunctionCommon::url_henkan($model->content));?>	
		  </p>
			<div class="photo">	
				<div class="imgbox">                            
					<?php if(!empty($attachment1)): ?>
					<?php echo FunctionCommon::echoOldFile($attachment1_ext, 1, $model,"majimebounty",$this->assetsBase);?>
					<?php endif; ?>
				</div>
				<div class="imgbox">
					<?php if(!empty($attachment2)): ?>
					<?php echo FunctionCommon::echoOldFile($attachment2_ext, 2, $model,"majimebounty",$this->assetsBase);?>
					<?php endif; ?>
				</div>
				<div class="imgbox">
					<?php if(!empty($attachment3)): ?>
					<?php echo FunctionCommon::echoOldFile($attachment3_ext, 3, $model,"majimebounty",$this->assetsBase);?>
					<?php endif; ?>
				</div>
			</div> 	
          <div class="cnt-box">
            <table class="table topics">
              <tr>
                <td class="td-mon">
					懸賞内容：<?php echo nl2br(FunctionCommon::url_henkan($model->prize));?>	
				</td>
                <td class="td-ded">
					募集締め切り：<?php echo FunctionCommon::formatDate($model->deadline); ?>
				</td>
                <td class="td-pos">
					応募数：<?php echo Yii::app()->db->createCommand('SELECT COUNT(*) FROM bounty_apply WHERE bounty_id='.$model->id)->queryScalar();?>
				</td>
              </tr>
            </table>
          </div>
          <div>
		  <?php endif; ?> 
		   <?php $now = strtotime(date('Y/m/d')); ?> 
		   <?php $dealine = strtotime(date('Y/m/d', strtotime($model->deadline)));?>
		   <?php if ($dealine >= $now): ?>
		   <?php $form = $this->beginWidget('CActiveForm', array(
				  'id' => 'bounty_detail_form', 
				  'focus'=>array($bounty_apply,'applied_content'),	
				  'htmlOptions' => array(
				  'enctype' => 'multipart/form-data',
				  'class'=>'form-horizontal',
				  'onsubmit'=>'return false;',),));?>	
			  <?php echo $form->hiddenField($bounty_apply, 'id'); ?>  	  
			  <?php echo $form->hiddenField($bounty_apply, 'bounty_id'); ?>  	  
			  <?php echo $form->hiddenField($bounty_apply, 'attachment_file_name'); ?>         
			  <?php echo $form->hiddenField($bounty_apply, 'attachment_file_bytes'); ?>             
			  <?php echo $form->hiddenField($bounty_apply, 'attachment_file_type'); ?>   		
              <div class="cnt-box">
                <div class="control-group">
                  <label class="control-label" for="content">応募テキスト&nbsp; 
                    <span class="label label-warning">必須</span>
                  </label>
                  <div class="controls">
					  <?php echo $form->error($bounty_apply, 'applied_content'); ?>
					  <?php echo $form->textarea($bounty_apply, 'applied_content', array('placeholder' => '内容を入力してください。', 'class' => 'input-xxlarge', 'rows' => 7)); ?>  
					</div>
                </div>
              </div>
              <div class="field attachements">
                <div class="title">添付資料 (PDF,Office,Zipファイルを添付可。ファイルサイズ5MB迄可)</div>
				<?php echo $form->error($bounty_apply, 'attachment1'); ?>
                <div class="photo" id="attachment_error">
           			<div class="imgbox">
						<img alt="" src="<?php echo $this->assetsBase; ?>/css/common/img/img_photo01.jpg">
						<p>
							<?php echo $form->fileField($bounty_apply,'attachment1');?>
						</p>
					</div>
                </div>
              </div>
              <div class="form-last-btn">
                <p class="btn80">
                    <button type="submit" class="btn btn-important">
                        <i class="icon-chevron-right icon-white">　</i>応募
                    </button>
                </p>
              </div>
			 <?php $this->endWidget(); ?> 
			<?php endif; ?> 
            <br />
            <div class="detailTtl">
              <h3 class="ttl">応募済みテキスト</h3>
            </div>
			  <?php if(!is_null($bounty_applies)): ?>
				  <?php foreach($bounty_applies as $item): ?>
					<p class="cnt-box">
						<?php echo nl2br(FunctionCommon::url_henkan($item->applied_content));?>		
					</p>
					<div class="photo">
						<div class="imgbox">
							<?php $attachbounty=$item->attachment1;?>
							<?php $attachabountyapp_ext=FunctionCommon::getExtensionFile($item->attachment1);?>
							<?php if(!empty($attachabountyapp_ext)): ?>
								<?php  FunctionCommon::echoOldFile($attachabountyapp_ext, 5, $item,"majimebounty",$this->assetsBase);?>
							<?php endif; ?>
						</div>
						
					</div>
					<?php if(FunctionCommon::getEmplNum() == $item->applicant_id && $dealine >= $now): ?>
						<div class="alnR">
							  <a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/index.php/majimebounty/delete/?id=<?php echo $model->id; ?>&idapp=<?php echo $item->id; ?>';" href="#" class="btn btn-important">  
							  <i class="icon-remove icon-white"></i>
							  この応募を取り消す
							  </a>
						</div>
					<?php endif; ?>	
				  <?php endforeach; ?>
			  <?php endif; ?>	
          </div>
        </div>
        <!-- /box -->
      </div>
      <!-- /mainBox -->
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
	   $("body").attr('id','majime');        	
	   $('button[type="submit"]').click(function()
	   {          
	
		 var id ="<?php echo $model->id;?>";
		 if(!checkId(id)){ }	
		$.ajax({    
			type: "POST", 
			async:true,
			url: "<?php echo Yii::app()->baseUrl;?>/majimebounty/detail/?id=<?php echo $model->id;?>",    
			data: jQuery('#bounty_detail_form').serialize(),
			success: function(msg)
			{	                        
					jQuery('#bounty_detail_form textarea').prev().remove();
					jQuery('#attachment_error_msg').prev().remove();
					if(msg!='[]')
					{
						data=$.parseJSON(msg);
						if(data.Bounty_apply_applied_content)
						{
							 div=document.createElement('div');
							 $(div).addClass('alert');
							 $(div).addClass('error_message');
							 $(div).html(data.Bounty_apply_applied_content);
							 $(div).insertBefore($('#Bounty_apply_applied_content')); 
						}
						if(data.Bounty_apply_attachment1)
						{
							 div=document.createElement('div');
							 $(div).addClass('alert');
							 $(div).addClass('error_message');
							 $(div).html(data.Bounty_apply_attachment1);
							 $(div).insertBefore($('#attachment_error')); 
						}
					}							  															
				else
				{
						
							jQuery('#attachment_error_msg').hide();
							jQuery("#bounty_detail_form").attr('action','<?php echo Yii::app()->baseUrl;?>/majimebounty/detail/?id=<?php echo $model->id;?>');
                                                        if(confirm('応募します。よろしいですか？')==true){
                                                            jQuery('#bounty_detail_form').attr('onsubmit','return true;');
							    jQuery('#bounty_detail_form').submit();				
                                                        }
							
					
				}					    			    
			}	  
		});
	});    
	
   errorDivs=jQuery('div.errorMessage');
   for(i=0,n=errorDivs.length;i<n;i++)
   {
		if(jQuery(errorDivs[i]).html()!="")
		{                     
			jQuery(errorDivs[i]).addClass('alert');
			jQuery(errorDivs[i]).addClass('error_message');
		}
	}
            
});

	//Method using check id bounty 
	function checkId(id)
	{
		$.ajax({   
			type: "POST", 
			async:true,
			url: "<?php echo Yii::app()->baseUrl;?>/majimebounty/checkId/",    
			data:{id:id},
			success: function(msg)
			{	        
				if(msg=='0')
				{ 
					window.location.href="<?php echo Yii::app()->baseUrl;?>/majimebounty/index";
				}
			}
		});
	}
</script>		