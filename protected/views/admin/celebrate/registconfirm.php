
<script type="text/javascript">
    jQuery(function($) {
        $("body").attr('id', 'admin');
        $(window).on('beforeunload', function(){
        setCookie("celebrate_regist_from","confirm");
        }); 
         setCookie("celebrate_regist_category_id",$("#Celebrate_category_id").val());
       setCookie("celebrate_regist_record_year",$("#Celebrate_record_year").val());
       setCookie("celebrate_regist_record_month",$("#Celebrate_record_month").val());
       setCookie("celebrate_regist_record_day",$("#Celebrate_record_day").val());
       setCookie("celebrate_regist_base_id",$("#Celebrate_base_id").val());
       setCookie("celebrate_regist_employee_name",$("#Celebrate_employee_name").val());
       
       $('button#submit').click(function(){  
           
            deleteCookies("celebrate_regist_from");
            jQuery("input#regist").val('1');            
            jQuery("form#celebrate_form").submit();
        });
        $('button#back').click(function(){  
            setCookie("celebrate_regist_from","confirm");   
           
            window.location="<?php echo Yii::app()->baseUrl;?>/admincelebrate/regist/";
        });
    });

    
    

</script>
<div class="wrap admin secondary celebrate">

    <div class="container">
        <div class="contents regist_confirm">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>お祝い - 登録 確認</h2></div>
                
                <div class="box">
                
                    <div class="cnt-box">
                    <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'celebrate_form',
                            'htmlOptions' => array(
                                'enctype' => 'multipart/form-data',
                                'class' => 'form-horizontal',
                            ),
                        ));
                        ?>                
                        <?php echo $form->hiddenField($model, 'category_id'); ?>   
                        <?php echo $form->hiddenField($model, 'employee_name'); ?>   
                        <?php echo $form->hiddenField($model, 'base_id'); ?>   
                        <?php echo $form->hiddenField($model, 'record_year'); ?>   
                        <?php echo $form->hiddenField($model, 'record_month'); ?>   
                        <?php echo $form->hiddenField($model, 'record_day'); ?>   
                         
                        

                        <input type="hidden" name="regist" id="regist" value="1"/>
                        <input type="hidden" name="base_name" id="base_name" value="<?php if(isset($base_name)) echo $base_name;?>"/>
                        <input type="hidden" name="category_name" id="category_name" value="<?php if(isset($category_name)) echo $category_name;?>"/>
                        <input type="hidden" name="record_date" id="record_date" value="<?php if(isset($record_date)) echo $record_date;?>"/> 
                    <div class="form-horizontal">

                	
	                    <div class="control-group">
	                        <label for="title" class="control-label">カテゴリー&nbsp;</label>
	                        <div class="controls">
	                        	<p><?php if(isset($category_name)) echo htmlspecialchars($category_name);?></p>
	                        </div>
	                    </div>
	                    
	                    <div class="control-group">
	                        <label for="title" class="control-label">日付&nbsp;</label>
	                        <div class="controls">
	                        	<p><?php if(isset($record_date)) echo $record_date;?></p>
	                        </div>
	                    </div>
	                    
	                    <div class="control-group">
	                        <label for="title" class="control-label">拠点名&nbsp;</label>
	                        <div class="controls">
	                        	<p><?php if(isset($base_name)&&$base_name!="選んで下さい") echo htmlspecialchars($base_name);?></p>
	                        </div>
	                    </div>
	                    
	                    <div class="control-group">
	                        <label for="content" class="control-label">名前&nbsp;</label>
	                        <div class="controls">
	                        	<p><?php echo htmlspecialchars($model->employee_name);?></p>
	                        </div>
	                    </div>
	                    
                    </div>
                    <?php $this->endWidget(); ?>     
                    </div><!-- /cnt-box -->	
            		
                	
                    
	                <div class="form-last-btn">
	                	<div class="btn170">		                    
                                    <button id="back" class="btn" type="submit"><i class="icon-chevron-left"></i> もどる</button>
                                    <button id="submit" class="btn btn-important" type="submit"><i class="icon-chevron-right icon-white"></i> 登録</button>
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
        <p id="page-top" style="display: none;"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
</div>

</div>