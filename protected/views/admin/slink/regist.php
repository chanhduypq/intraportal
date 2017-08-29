
<div class="wrap admin secondary slink">
    <div class="container">
        <div class="contents index">
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>オススメのリンク - 登録</h2>
                <span>
					<a class="btn btn-important" href="<?php echo Yii::app()->request->baseUrl; ?>/adminslink">
						<i class="icon-chevron-left icon-white"></i> 一覧に戻る
					</a>
				</span>
                </div>
                <div class="box">
					<?php $form = $this->beginWidget('CActiveForm', array(
						'id' => 'slink_regist', 
						'focus'=>array($model,'title'),	
						'htmlOptions' => array(
						'enctype' => 'multipart/form-data',
						'class'=>'form-horizontal',
					'onsubmit'=>'return false;',),));?>
					<?php echo $form->hiddenField($model, 'type', array('value' => '1')); ?>  	
			        <div class="cnt-box">
                    
                    <div class="control-group">
                        <label class="control-label" for="title">タイトル&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
							<?php echo $form->error($model, 'title'); ?>
                        	<?php echo $form->textField($model, 'title', array('placeholder' => 'タイトルを入力してください。[25文字]', 'class' => 'input-xxlarge')); ?>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label" for="url">URL&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
							<?php echo $form->error($model, 'url'); ?>
							<?php echo $form->textField($model, 'url', array('placeholder' => 'URLを入力してください。', 'class' => 'input-xxlarge')); ?>
                        </div>
                    </div>

                </div><!-- /cnt-box -->
                
                <div class="form-last-btn">
                	<p class="btn80">
	                    <button type="submit" class="btn btn-important">
							<i class="icon-chevron-right icon-white">　</i> 登録
						</button>
                    </p>
                </div>
                
                 <?php $this->endWidget(); ?>
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
     $('button[type="submit"]').click(function()
	 {          
			$.ajax({    
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/adminslink/regist/",    
				data: jQuery('#slink_regist').serialize(),
				success: function(msg)
				{	     
					  jQuery('#Slink_title').prev().remove();                                       						                                            					  	
					  jQuery('#Slink_url').prev().remove();		
					  if(msg!='[]')
					  {
							data=$.parseJSON(msg);
							if(data.Slink_title)
							{	
								 div=document.createElement('div');
								 $(div).addClass('alert');
								 $(div).addClass('error_message');
								 $(div).html(data.Slink_title);
								 $(div).insertBefore($('#Slink_title')); 
							} 
							if(data.Slink_url)
						    {
								 div=document.createElement('div');
								 $(div).addClass('alert');
								 $(div).addClass('error_message');
								 $(div).html(data.Slink_url);
								 $(div).insertBefore($('#Slink_url')); 
						   } 
					  }							  															
					  else
					  {   
						 var result=confirm("この内容で登録します。よろしいですか？")	
						 if(result==true)
						 {
							jQuery('#slink_regist').attr('onsubmit','return true;');
							jQuery('#slink_regist').submit();
						 }
					  }					    			    
				 }	  
			});
		}); 
 });		
</script>