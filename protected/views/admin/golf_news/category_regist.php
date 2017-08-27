<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/default.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/spectrum.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initSpectrum.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/spectrum.js"></script>
<div class="wrap admin secondary golf_news">
    <div class="container">
        <div class="contents regist">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
				<h2>ゴルフもマジメ！ - カテゴリー - 登録</h2>
                <span>
				    <a href="<?php echo Yii::app()->request->baseUrl; ?>/admincategory/categories/?type=5" class="btn btn-important">
						<i class="icon-chevron-left icon-white"></i> 一覧に戻る
					</a>
				</span>
                </div>
                <div class="box">
				 <?php $form = $this->beginWidget('CActiveForm', array(
						'id' => 'golf_news_cat_regist', 
						'htmlOptions' => array(
						'enctype' => 'multipart/form-data',
						'class'=>'form-horizontal',
						),));
                ?>
				
                <div class="cnt-box">
                    
                    <div class="control-group">
                        <label class="control-label" for="content">カテゴリー名&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
							 <?php echo $form->textField($model, 'category_name', array('placeholder' => 'カテゴリー名を入力してください。', 'class' => 'input-xlarge')); ?>
                        </div>
                    </div>
                                        
                    <div class="control-group">
                        <label class="control-label" for="content">背景色&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div id="divbackground-color" class="controls" >
							<?php echo $form->textField($model, 'background_color', array('class' => 'colorpicker')); ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="content">文字色&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div id="divtext_color" class="controls">
						    <?php echo $form->textField($model, 'text_color', array('class' => 'colorpicker')); ?>
                        </div>
                    </div>
				
                </div><!-- /cnt-box -->
                <?php $this->endWidget(); ?>	
                <div class="form-last-btn">
                	<p class="btn80">
	                    <button id="submit" type="submit" class="btn btn-important">
						<i class="icon-chevron-right icon-white">　</i> 登録
						</button>
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
            </div>
            
  </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
</div>

</div><!-- /wrap -->
<script type="text/javascript">
/*convert background-color rgb to color code*/
function hexc(colorval)
{
    var parts = colorval.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    delete(parts[0]);
    for (var i = 1; i <= 3; ++i) 
	{
        parts[i] = parseInt(parts[i]).toString(16);
        if (parts[i].length == 1) parts[i] = '0' + parts[i];
    }
    return '#' + parts.join('');
}		

jQuery(function($)
{         
	$("body").attr('id','admin');
	
	$('button#submit').click(function()
	{   
		var backGround=$("#divbackground-color").children().children().children().css("background-color");
		$("#Category_background_color").val(hexc(backGround));
		var textColor=$("#divtext_color").children().children().children().css("background-color");
		$("#Category_text_color").val(hexc(textColor));

		$.ajax({    
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/admincategory/categoryregist/?type=5",    
				data: jQuery('#golf_news_cat_regist').serialize(),
				success: function(msg)
				{	     
	  			      jQuery('#Category_category_name').prev().remove();
					  if(msg!='[]')
					  {
							data=$.parseJSON(msg);
							if(data.Category_category_name)
							{
                                 div=document.createElement('div');
                                 $(div).addClass('alert');
                                 $(div).addClass('error_message');
                                 $(div).html(data.Category_category_name);
                                 $(div).insertBefore($('#Category_category_name'));
                            } 
					  }							  															
					  else
					  {   
							var r = confirm("'この内容で登録します。よろしいですか？");
							if(r==true)
							{
								//$("#hobby_new_cat_regist").attr('action','<?php echo Yii::app()->baseUrl;?>/admincategory/categoryregist/?type=6');
//								jQuery('#golf_news_cat_regist').attr('onsubmit','return true;');
								jQuery('#golf_news_cat_regist').submit();
							}
					  }					    			    
				 }	  
			});
		
	});	

});
</script> 