
<script type="text/javascript">
    function checkId()
{
        jQuery.ajax({   
        type: "POST", 
                async:true,
                url: "<?php echo Yii::app()->baseUrl;?>/adminclaim/checkId/",    
                data:{id:"<?php echo $model->id;?>",table:"category"},
                success: function(msg){	
            
                        
                        if(msg=='0'){ 
                                window.location='<?php echo Yii::app()->baseUrl;?>/admincelebrate';
                        }
                }
        });
}
    jQuery(function($) {
        $("body").attr('id', 'admin');
        /**
         * 
         */
        $('button#next').click(function() {
	    checkId();    
            $.ajax({
                type: "POST",
                async: true,
                url: "<?php echo Yii::app()->baseUrl; ?>/admincelebrate/categoryedit/?id=<?php echo $model->id;?>",
                data: jQuery('#category_form').serialize(),
                success: function(msg) {
                    jQuery('#Category_category_name').prev().remove();               
                    
                    
                    if (msg != '[]') {
                        data = $.parseJSON(msg);
                        if (data.Category_category_name) {
                            div = document.createElement('div');
                            $(div).addClass('alert');
                            $(div).addClass('error_message');
                            $(div).html(data.Category_category_name);
                            $(div).insertBefore($('#Category_category_name'));

                        }   
                    }
                    else {
                        if(confirm('この内容で更新します。よろしいですか？')){
                            jQuery('#category_form').submit();
                        }
                                                 
                    }
                }
            });
        });
    });
</script>
<div class="wrap admin secondary celebrate">

    <div class="container">
        <div class="contents regist">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>お祝い - カテゴリー - 修正</h2>
                <span><a class="btn btn-important" href="<?php echo Yii::app()->baseUrl;?>/admincelebrate/categories/index?page=<?php echo Yii::app()->request->cookies['page']; ?>"><i class="icon-chevron-left icon-white"></i> 一覧に戻る</a></span>
                </div>
                <div class="box">                
                <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'category_form',
                        'htmlOptions' => array(                            
                            'class' => 'form-horizontal',
                            
                        ),
                    ));
                    ?>    
                    <?php echo $form->hiddenField($model, 'id'); ?>    
                <div class="cnt-box">
                    
                    <div class="control-group">
                        <label for="content" class="control-label">カテゴリー名&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                            <?php echo $form->error($model, 'category_name'); ?>
                            <?php echo $form->textField($model, 'category_name', array('class' => 'input-xlarge', 'placeholder' => 'カテゴリー名を入力してください。')); ?>                                                            	                        	
                        </div>
                    </div>
                                        
                </div><!-- /cnt-box -->
                <?php $this->endWidget(); ?> 
                <div class="form-last-btn">
                	<p class="btn80">
	                    <button id="next" class="btn btn-important" type="submit"><i class="icon-chevron-right icon-white">&#12288;</i> 更新</button>
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
        <p id="page-top" style="display: none;"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
</div>

</div>