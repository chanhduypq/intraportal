




<div class="wrap admin secondary soumu_qa" id="admin">

    <div class="container">
        <div class="contents regist">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>教えて総務さん！FAQ - カテゴリー - 修正</h2>
                <span>
                    <a href="<?php echo Yii::app()->baseUrl;?>/adminsoumu_qa/categories" class="btn btn-important">
					   <i class="icon-pencil icon-white"></i>  一覧に戻る
                    </a>
                </span>
                </div>
                <div class="box">
                	<?php
					$form = $this->beginWidget('CActiveForm', array(
						'id' => 'categoryedit_form',                     
						'htmlOptions' => array( 
                                                'enctype' => 'multipart/form-data',
											  'class'=>'form-horizontal',											  
											  ),
						 ));
						 echo $form->hiddenField($model, 'id');
						 echo $form->hiddenField($model, 'created_date');
					?>	 
                <div class="cnt-box">
                    <?php //var_dump($model);exit;?>
                    <div class="control-group">
                        <label class="control-label" for="content">カテゴリー名&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	<?php echo $form->error($model, 'category_name'); ?>
                            <?php echo $form->textField($model, 'category_name', array('placeholder' => 'タイトルを入力してください。[25文字]', 'class' => 'input-xxlarge')); ?>	
                        </div>
                    </div>
                                        
                </div><!-- /cnt-box -->
                <?php $this->endWidget(); ?>
                <div class="form-last-btn">
                	<p class="btn80">
	                    <button id="submit" type="submit" class="btn btn-important"><i class="icon-chevron-right icon-white">　</i> 更新</button>
                    </p>
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
        jQuery(function($){            
           $('button#submit').click(function(){
			$.ajax({    
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/adminsoumu_qa/categoryedit/<?php echo $model->id; ?>",    
				data: jQuery('#categoryedit_form').serialize(),
				success: function(msg)
				{	     
                      jQuery('#Category_category_name').prev().remove();
					  if(msg!='[]')
					  {
						
							data=$.parseJSON(msg);
							if(data.Category_category_name){
                                 div=document.createElement('div');
                                 $(div).addClass('alert');
                                 $(div).addClass('error_message');
                                 $(div).html(data.Category_category_name);
                                 $(div).insertBefore($('#Category_category_name'));
                            }  
					  }							  															
					  else
					  {   
                         var r = confirm("この内容で更新します。よろしいですか？");
                         if(r==true){
//						  jQuery('#categoryedit_form').attr('onsubmit','return true;');
						  jQuery('#categoryedit_form').submit();
                         }
					  }					    			    
				 }	  
			});
			
		});    
           <?php if(isset($valid)&&$valid==true){?>
           /*$(window).load(function ()
		   {
				$("#categoryedit_form").attr('action','<?php echo Yii::app()->baseUrl;?>/adminsoumu_qa/editconfirm/');
                jQuery('#categoryedit_form').attr('onsubmit','return true;');
                $("#categoryedit_form").submit();
			}); */
           <?php }?>
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
</script>