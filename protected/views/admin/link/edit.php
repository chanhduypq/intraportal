
<div class="wrap admin secondary link">

    <div class="container">
        <div class="contents edit">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>リンク集 - 修正</h2>
					<span>
						<?php if(Yii::app()->request->cookies['page']>'1'): ?>	
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/adminlink/index?page=<?php echo Yii::app()->request->cookies['page']?>" class="btn btn-important">
								<i class="icon-chevron-left icon-white"></i> 一覧に戻る
							</a>
						<?php else : ?>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/adminlink" class="btn btn-important">
								<i class="icon-chevron-left icon-white"></i> 一覧に戻る
							</a>
						<?php endif; ?>
					</span>
                </div>
                <div class="box">
				<?php $form = $this->beginWidget('CActiveForm', array(
						'id' => 'link_edit', 
						'focus'=>array($model,'title'),	
						'htmlOptions' => array(
						'enctype' => 'multipart/form-data',
						'class'=>'form-horizontal',
					'onsubmit'=>'return false;',),));?>
				<?php echo $form->hiddenField($model, 'id'); ?>  	
				<?php echo $form->hiddenField($model, 'type'); ?>  	
				<?php echo $form->hiddenField($model, 'created_date');?>  	
                <div class="cnt-box">
                	
                    <div class="control-group">
                        <label class="control-label" for="title">カテゴリー&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	<div id="divCategoryError" class="alert error_message"><?php echo Lang::MSG_0010;?></div>
							<?php echo $form->dropDownList($model,'category_id', CHtml::listData(Category::model()->findAll(array("condition"=>"type =7",'order' => 'category_name ASC')), 'id', 'category_name'), array('empty'=>'選んで下さい'));?>		
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label" for="content">タイトル&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
						    <?php echo $form->error($model, 'title'); ?>
                        	<?php echo $form->textField($model, 'title', array('placeholder' => 'タイトルを入力してください。', 'class' => 'input-xxlarge')); ?>
                        </div>
                    </div>
                                        
                    <div class="control-group">
                        <label class="control-label" for="content">URL&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	<?php echo $form->error($model, 'url'); ?>
							<?php echo $form->textField($model, 'url', array('placeholder' => 'URLを入力してください。', 'class' => 'input-xxlarge')); ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="content">コメント</label>
                        <div class="controls">
							<?php echo $form->textarea($model,'comment', array('placeholder' => 'コメントを入力してください。', 'class' => 'input-xxlarge', 'rows' => 7,'maxlength' => 1000)); ?>
                        </div>
					</div>

                                        
                </div><!-- /cnt-box -->
                
                <div class="form-last-btn">
                	<p class="btn80">
	                    <button type="submit" class="btn btn-important"><i class="icon-chevron-right icon-white">　</i> 更新</button>
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
            </div>
            <!-- /sideBox -->
            
  </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
</div>

</div><!-- /wrap -->
<script type="text/javascript"> 
 	//Method using check id newitem 
	var ischeck=true;
	function checkId(id)
	{
		
		$.ajax({   
			type: "POST", 
			async:true,
			url: "<?php echo Yii::app()->baseUrl;?>/adminlink/checkId/",    
			data:{id:id},
			success: function(msg)
			{	 
				if(msg=='0')
				{ 
					window.location.href="<?php echo Yii::app()->baseUrl;?>/adminlink/index";
				}
			}
		});
	}
	
	function checkCategory()
	{
		var ischeck=true;
		var category_id=$('#Slink_category_id').val();
		if(!category_id)
		{
			$('#divCategoryError').show();
			ischeck=false;
		}
		return ischeck;
		
	}
	jQuery(function($)
	{            
		   $("body").attr('id','admin');
		   $('#divCategoryError').hide();
		   $('button[type="submit"]').click(function()
		   {       
					var id = $('#Slink_id').val();	
					checkId(id);			
					$.ajax({    
						type: "POST", 
						async:true,
						url: "<?php echo Yii::app()->baseUrl;?>/adminlink/edit/",  
						data: jQuery('#link_edit').serialize(),
						success: function(msg)
						{	     
							  jQuery('#Slink_title').prev().remove();                                       						                                            					  	
							  jQuery('#Slink_url').prev().remove();		
							  if(msg!='[]' | !checkCategory())
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
								 var result=confirm("更新します。よろしいですか？")	
								 if(result==true)
								 {
									jQuery('#link_edit').attr('onsubmit','return true;');
									jQuery('#link_edit').submit();
								 }
							  }					    			    
						 }
				  });
		
		});    

	 });
</script>

