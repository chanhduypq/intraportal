
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
                                window.location='<?php echo Yii::app()->baseUrl;?>/admincelebrate_rpt/categories';
                        }
                }
        });
}
    function checkFile(){
    
    var result	 = true;

    $(".errorMessage").remove();
    $("#error_message1").html("");
    $("#error_message1").removeClass("cerrorMessage alert error_message");
    
    $("div").removeClass("cerrorMessage alert error_message");
    var checkBox1  = jQuery('#Category_category_avatar_checkbox_for_deleting').is(":checked");
   

    //check format file
    var arr_file	   = [".jpg" , ".gif", ".png", ".jpeg"];			
    var attachment1 = jQuery('#Category_category_avatar').val();

    checkFile1	   = attachment1.substr(attachment1.lastIndexOf('.'));
    checkFile1	   = checkFile1.toLowerCase();

   

    file1			   = jQuery.inArray(checkFile1, arr_file);
    

    if(checkBox1 == false && file1 == -1 && attachment1 !="")
    {
               jQuery("#error_message1").html("<?php echo Lang::MSG_0132 ?>");	
               jQuery("#error_message1").addClass("cerrorMessage alert error_message");
               result = false;

    }
    
    return result;
}        
    jQuery(function($) {
    
    $('input[type="checkbox"]').click (function (){            
                 if ($(this).is (':checked')){ 
                      $fileInput=$(this).parent().parent().prev().find('input[type="file"]').eq(0);
                      name=$fileInput.attr('name');
                      id=$fileInput.attr('id');
                      classAttr=$fileInput.attr('class'); 
                      if(name==undefined){
                          name="";
                      }
                      if(id==undefined){
                          id="";
                      }
                      if(classAttr==undefined){
                          classAttr="";
                      }
                      $fileInput.replaceWith("<input type='file' name='"+name+"' id='"+id+"' class='"+classAttr+"'/>");
                      //
                      $(this).parent().parent().parent().find('img').eq(0).remove();
                      
                      
                 }
            });
       $("div.errorMessage").addClass("alert").addClass("error_message");
       $("body").attr('id', 'admin');
       $('button#next').click(function() {
           checkId();
            $.ajax({
                type: "POST",
                async: true,
                url: "<?php echo Yii::app()->baseUrl; ?>/admincelebrate_rpt/categoryedit/?id=<?php echo $model->id;?>",
                data: jQuery('#category_form').serialize(),
                success: function(msg) {
                    jQuery('#Category_category_name').prev().remove();               
                    
                    
                    if(msg!='[]'|checkFile()==false){
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
<div class="wrap admin secondary celebrate_rpt">

    <div class="container">
        <div class="contents regist">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>お祝い報告 - カテゴリー - 修正</h2>
                    <?php 
                 
					if(Yii::app()->request->cookies['page']!= "") 
					{
						   $page = "index?page=".Yii::app()->request->cookies['page'];
							
					}else {$page ="";}
					?>
                    <?php 
                    if(FunctionCommon::isAdmin()==true){
                    ?>
                    <span><a class="btn btn-important" href="<?php echo Yii::app()->baseUrl.'/admincelebrate_rpt/categories/'.$page;?>"><i class="icon-chevron-left icon-white"></i> 一覧に戻る</a></span>
                    <?php
                    }
                    ?>
                </div>
                <div class="box">
                <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'category_form',
                        'htmlOptions' => array(                            
                            'class' => 'form-horizontal',
                            'enctype' => 'multipart/form-data',
                            
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
                                        
                    <div class="control-group">
                        <label for="icon_file" class="control-label">画像&nbsp;</label>
                        <div class="controls">   
                            
                                <div class="icon">
                                    <?php 
                            if($model->category_avatar!=""){ 
                                    echo '<img style="height:52px;" src="'.Yii::app()->request->baseUrl.$model->category_avatar.'"/>';            
                            }
                                    ?>
	                        	
								<div id="error_message1"></div>
                            <?php echo $form->error($model, 'category_avatar'); ?>                           
                            <?php echo '<p>'.$form->fileField($model, 'category_avatar', array('size' => 20)).'</p>'; ?>                                                            	
                        	<p>
            <span class="checkDelete">
        <?php
        echo $form->checkBox($model, 'category_avatar_checkbox_for_deleting'
                , array('value' => 1, 'uncheckValue' => 0)
        );
        ?>  削除する
            </span>
        </p>  
	                        </div>
                            
                                 
                        </div>
                    </div>
                                        
                </div><!-- /cnt-box -->
                <?php $this->endWidget(); ?> 
                <div class="form-last-btn">
                	<p class="btn80">
	                    <button id="next" class="btn btn-important" type="submit"><i class="icon-chevron-right icon-white">&#12288;</i>  更新</button>
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