
<script type="text/javascript">
      
        from=getCookie("celebrate_edit_from");        
        if(from=="confirm"){
            deleteCookies("celebrate_edit_from");              
            window.location="<?php echo Yii::app()->baseUrl.'/admincelebrate/edit/?id='.$model->id;?>"; 
        }

    function checkId()
{
        jQuery.ajax({   
        type: "POST", 
                async:true,
                url: "<?php echo Yii::app()->baseUrl;?>/adminclaim/checkId/",    
                data:{id:"<?php echo $model->id;?>",table:"celebrate"},
                success: function(msg){	
            
                        
                        if(msg=='0'){ 
                                window.location='<?php echo Yii::app()->baseUrl;?>/admincelebrate';
                        }
                }
        });
}
    function day(day_number) {
        jQuery('#Celebrate_record_day').html("");
        for (i = 1; i <= day_number; i++) {
            jQuery('#Celebrate_record_day').append("<option value=" + i + ">" + i + "</option>");
        }
    }

    jQuery(function($) {
        $("#celebrate_form").attr('action', '<?php echo Yii::app()->baseUrl; ?>/admincelebrate/editconfirm/');
        category_id=getCookie("celebrate_edit_category_id");
        record_year=getCookie("celebrate_edit_record_year");
        record_month=getCookie("celebrate_edit_record_month");
        record_day=getCookie("celebrate_edit_record_day");
        base_id=getCookie("celebrate_edit_base_id");
        employee_name=getCookie("celebrate_edit_employee_name");
       
           if(category_id!=null&&category_id!="null"){
               $("#Celebrate_category_id").val(category_id);
           }
           if(record_year!=null&&record_year!="null"){
               $("#Celebrate_record_year").val(record_year);
           }
           if(record_month!=null&&record_month!="null"){
               $("#Celebrate_record_month").val(record_month);
           }
           if(record_day!=null&&record_day!="null"){
               $("#Celebrate_record_day").val(record_day);
           }
           if(base_id!=null&&base_id!="null"){
               $("#Celebrate_base_id").val(base_id);
           }           
           if(employee_name!=null&&employee_name!="null"){
               $("#Celebrate_employee_name").val(employee_name);
           }
           setCookie("celebrate_edit_category_id",category_id);
           setCookie("celebrate_edit_record_year",record_year);
           setCookie("celebrate_edit_record_month",record_month);
           setCookie("celebrate_edit_record_day",record_day);
           setCookie("celebrate_edit_base_id",base_id);
           setCookie("celebrate_edit_employee_name",employee_name);
        
        /**
         * 
         */        
        var year = $("#Celebrate_record_year").val();
        var month = $("#Celebrate_record_month").val();
        if (
                month == 1
                || month == 3
                || month == 5
                || month == 7
                || month == 8
                || month == 10
                || month == 12
                ) {
            day(31);
        }
        else if (
                month == 4
                || month == 6
                || month == 9
                || month == 11
                ) {
            day(30);
        }
        else if (month == 2) {
            if (year % 4 == 0) {
                day(29);
            }
            else if (year % 4 != 0) {
                day(28);
            }
        }
        if(record_day!=null&&record_day!="null"){
               daySelected=record_day;
        }
        else{
            daySelected='<?php echo $model->record_day;?>';
        }
        
        
        options=$('#Celebrate_record_day option');
        for(i=1,n=options.length;i<=n;i++){
             if($(options[i]).attr('value')==daySelected){                
                 $(options[i]).attr('selected','selected');
                 break;
             }           
        }
        $("body").attr('id', 'admin');
        
        /**
         * 
         */
        $("#Celebrate_record_month").change(function() {
            var year = $("#Celebrate_record_year").val();
            var month = $("#Celebrate_record_month").val();
            if (
                    month == 1
                    || month == 3
                    || month == 5
                    || month == 7
                    || month == 8
                    || month == 10
                    || month == 12
                    ) {
                day(31);
            }
            else if (
                    month == 4
                    || month == 6
                    || month == 9
                    || month == 11
                    ) {
                day(30);
            }
            else if (month == 2) {
                if (year % 4 == 0) {
                    day(29);
                }
                else if (year % 4 != 0) {
                    day(28);
                }
            }
        });
        $("#Celebrate_record_year").change(function() {
            var year = $("#Celebrate_record_year").val();
            var month = $("#Celebrate_record_month").val();
            if (
                    month == 1
                    || month == 3
                    || month == 5
                    || month == 7
                    || month == 8
                    || month == 10
                    || month == 12
                    ) {
                day(31);
            }
            else if (
                    month == 4
                    || month == 6
                    || month == 9
                    || month == 11
                    ) {
                day(30);
            }
            else if (month == 2) {
                if (year % 4 == 0) {
                    day(29);
                }
                else if (year % 4 != 0) {
                    day(28);
                }
            }


        });


        /**
         * 
         */
        $('button#next').click(function() {
		    deleteCookies("celebrate_edit_from");    
                    checkId();
            $.ajax({
                type: "POST",
                async: true,
                url: "<?php echo Yii::app()->baseUrl; ?>/admincelebrate/edit/?id=<?php echo $model->id;?>",
                data: jQuery('#celebrate_form').serialize(),
                success: function(msg) {
                    jQuery('#Celebrate_category_id').prev().remove();
                    jQuery('#Celebrate_employee_name').prev().remove();     
                    
                    
                    if (msg != '[]') {
                        data = $.parseJSON(msg);
                        if (data.Celebrate_category_id) {
                            div = document.createElement('div');
                            $(div).addClass('alert');
                            $(div).addClass('error_message');
                            $(div).html(data.Celebrate_category_id);
                            $(div).insertBefore($('#Celebrate_category_id'));

                        }
                        if (data.Celebrate_employee_name) {
                            div = document.createElement('div');
                            $(div).addClass('alert');
                            $(div).addClass('error_message');
                            $(div).html(data.Celebrate_employee_name);
                            $(div).insertBefore($('#Celebrate_employee_name'));
                        }
                        


                    }
                    else {                        
                        /**
                         * 
                         */
                        baseId = $("#Celebrate_base_id").val();
                        baseName = $("#Celebrate_base_id option[value='" + baseId + "']").html();
                        $("#base_name").val(baseName);
                        /**
                         * 
                         */
                        categoryId = $("#Celebrate_category_id").val();
                        categoryName = $("#Celebrate_category_id option[value='" + categoryId + "']").html();
                        $("#category_name").val(categoryName);
                        /**
                         * 
                         */
                        $("#record_date").val($("#Celebrate_record_year").val() + '/' + $("#Celebrate_record_month").val() + '/' + $("#Celebrate_record_day").val())                        
                        /**
                         * 
                         */  
                        setCookie("celebrate_edit_category_id",$("#Celebrate_category_id").val());
                       setCookie("celebrate_edit_record_year",$("#Celebrate_record_year").val());
                       setCookie("celebrate_edit_record_month",$("#Celebrate_record_month").val());
                       setCookie("celebrate_edit_record_day",$("#Celebrate_record_day").val());
                       setCookie("celebrate_edit_base_id",$("#Celebrate_base_id").val());
                       setCookie("celebrate_edit_employee_name",$("#Celebrate_employee_name").val());
                        jQuery('#celebrate_form').submit();
                    }
                }
            });
        });


     
    });
</script>
<div class="wrap admin secondary celebrate">

    <div class="container">
        <div class="contents edit">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>お祝い - 修正</h2>
                    <span><a class="btn btn-important" href="<?php echo Yii::app()->baseUrl;?>/admincelebrate/index?page=<?php echo Yii::app()->request->cookies['page']; ?>"><i class="icon-chevron-left icon-white"></i> 一覧に戻る</a></span>
                </div>
                <div class="box">
                <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'celebrate_form',
                        'htmlOptions' => array(                            
                            'class' => 'form-horizontal',                           
                        ),
                    ));
                    ?>    
                    <?php echo $form->hiddenField($model, 'id'); ?>  
                    <input type="hidden" name="base_name" id="base_name" value="<?php if(isset($base_name)) echo $base_name;?>"/>
                    <input type="hidden" name="category_name" id="category_name" value="<?php if(isset($category_name)) echo $category_name;?>"/>
                    <input type="hidden" name="record_date" id="record_date" value="<?php if(isset($record_date)) echo $record_date;?>"/>
                <div class="cnt-box">
                	
                    <div class="control-group">
                        <label for="title" class="control-label">カテゴリー&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	<?php echo $form->error($model, 'category_id'); ?>
                        	<?php echo $form->dropDownList($model, 'category_id', $model->allCategorys, array('options' => array($model->category_id => array('selected' => true)))); ?> 
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="title" class="control-label">日付&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">                        	
                        	        <?php echo $form->dropDownList($model, 'record_year', $model->allRecordYear, array('options' => array($model->record_year => array('selected' => true)), 'class' => 'input-small')); ?> 
                                        -
                                        <?php echo $form->dropDownList($model, 'record_month', $model->allRecordMonth, array('options' => array($model->record_month => array('selected' => true)), 'class' => 'input-mini')); ?> 
                                        -
                                        <?php echo $form->dropDownList($model, 'record_day', $model->allRecordDay, array('options' => array($model->record_day => array('selected' => true)), 'class' => 'input-mini')); ?>                                     	                        	
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="title" class="control-label">拠点名&nbsp;</label>
                        <div class="controls">
                        	<?php echo $form->dropDownList($model, 'base_id', $model->allBases, array('options' => array($model->base_id => array('selected' => true)))); ?> 
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label for="content" class="control-label">名前&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	<?php echo $form->error($model, 'employee_name'); ?>
                                <?php echo $form->textField($model, 'employee_name', array('class' => 'input-xlarge', 'placeholder' => '名前を入力してください。')); ?>                                                            	
                        </div>
                    </div>
                                        
                </div><!-- /cnt-box -->
                <?php $this->endWidget(); ?> 
                <div class="form-last-btn">
                	<p class="btn80">
	                    <button id="next" class="btn btn-important" type="submit"><i class="icon-chevron-right icon-white">&#12288;</i> 確認</button>
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
        <p id="page-top" style="display: block;"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
</div>

</div>