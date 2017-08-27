<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/admin/css/unit.css" rel="stylesheet" type="text/css"/>
<div class="wrap admin secondary unit">

    <div class="container index">
        <div class="contents company">
        	
            <div class="mainBox">
            	<div class="pageTtl">
            		<h2>部署紹介 - 編集</h2>
            	</div>
       <?php 
       if(isset($division)&&is_array($division)&&count($division)>0){
		  
		  
           foreach ($division as $div) {
			       
               if($div!=FALSE&&  is_array($div)&&count($div)>0){?>
                       <div class="box">
                       		<?php
                            $units = Yii::app()->db->createCommand()
							->select(array(
								'unit.id',
								'unit.unit_name',
								'unit.branch_id',
								'branch.branch_name',
								'base.company_name'
									)
							)
							->from('unit')
							->join('branch', 'branch.id=unit.branch_id')
							->join('base', 'base.id=branch.base_id')
							->where("unit.id='".$div['id']."' and unit.active_flag=1 and branch.active_flag=1")
							->queryRow();
							?>
                            <h3><?php echo $units['company_name']."&#12288;".$units['branch_name']."&#12288;".$units['unit_name']?></h3>
                                <p class="descriptionTxt">部署の紹介タイトル、紹介文を修正できます。部署ごとにひとつづつ修正・登録を行って下さい。</p>
                                
                                    <?php                
                                    $form = $this->beginWidget('CActiveForm', array(                                                   
                                        'htmlOptions' => array(
                                                              'enctype' => 'multipart/form-data',
                                                              'class'=>'form-horizontal', 
                                                              'onsubmit'=>'return false;',
                                                              ),
                                            ));
                                    $model=  Unitedit::model()->findByPk($div['id']);

                                    ?>

                                    <?php echo $form->hiddenField($model, 'id'); ?> 
                                    <?php echo $form->hiddenField($model, 'branch_id'); ?>  
                                    <?php echo $form->hiddenField($model, 'office_id'); ?>   
                                    <?php echo $form->hiddenField($model, 'display_order'); ?>  
                                    <?php echo $form->hiddenField($model, 'unit_name'); ?> 
                                    
                                    <?php echo $form->hiddenField($model, 'mailaddr'); ?>  
                                    <?php echo $form->hiddenField($model, 'attachment1'); ?> 
                                    <?php echo $form->hiddenField($model, 'attachment2'); ?>  
                                    <?php echo $form->hiddenField($model, 'attachment3'); ?> 
                                    <?php echo $form->hiddenField($model, 'created_date'); ?> 
                                    <div class="cnt-box">
                                    <div class="baseDetailBox">
                                        <div class="textBox clearfix">
                                            <div class="control-group">
                                                <label for="introduce_title" class="control-label">紹介タイトル&nbsp;</label>
                                                <div class="controls">
                                                    <?php echo $form->error($model, 'catchphrase'); ?>
                                                    <?php echo $form->textField($model, 'catchphrase', array('class' => 'input-xxlarge')); ?>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label for="introduce_text" class="control-label">紹介文&nbsp;</label>
                                                <div class="controls">                                                    
                                                    <?php echo $form->error($model, 'introduction'); ?>
                        	                    <?php echo $form->textarea($model, 'introduction', array('class' => 'input-xxlarge', 'rows' => 7,'maxlength' => 2000)); ?>                            
                                                    <p class="unit_btn"><button class="btn btn-important" type="submit"><i class="icon-chevron-right icon-white">&#12288;</i> 更新</button></p>
                                                </div>
                                            </div>                            
                                        </div><!-- /taxtBox -->
                                    </div><!-- /baseDetailBox -->

                                </div><!-- /cnt-box -->
                                           <?php $this->endWidget(); ?>
                          </div><!-- /box -->      
       <?php         
               }
             
           }
       }
?>
           
       
                

 

 

 


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
<script type="text/javascript">
    function convertString(content){
        content1=content.replace(/<br ?\/?>|_/g, '\n');
        return content1;        
    }
    jQuery(function($){
        
	$("body").attr('id','admin');
        forms=$("form");
        for(i=0;i<forms.length;i++){
            key="unitedit_catchphrase_"+(i+1);
            value=getCookie(key);
            if(value!=null&&value!="null"){
                $(forms[i]).find('input[type="text"]').eq(0).val(value);
            }
            key="unitedit_introduction_"+(i+1);
            value=getCookie(key);
            if(value!=null&&value!="null"){
                value=convertString(value);
                $(forms[i]).find('textarea').eq(0).val(value);
            }            

        }
        jQuery('form').attr("action","<?php echo Yii::app()->baseUrl;?>/adminunit/indexconfirm/");
       
        $('button[type="submit"]').click(function(){  
            deleteCookies("unitedit_from");
                                            
                        form=$(this);
			$.ajax({                 			
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/adminunit/index/",    
				data: jQuery(form).parents("form").eq(0).serialize(),
				success: function(msg){    
					  $(form).parents("form").eq(0).find('#Unitedit_catchphrase').eq(0).prev().remove(); 
                                          $(form).parents("form").eq(0).find('#Unitedit_introduction').eq(0).prev().remove(); 
                                         
					  	if(msg!='[]'){
                                                    
                                                    data=$.parseJSON(msg);
                                                    if(data.Unitedit_catchphrase){
                                                         div=document.createElement('div');
                                                         $(div).addClass('alert');
                                                         $(div).addClass('error_message');
                                                         $(div).html(data.Unitedit_catchphrase);
                                                         $(div).insertBefore($(form).parents("form").eq(0).find('#Unitedit_catchphrase').eq(0));
                                                         
                                                         
                                                    }     
                                                    if(data.Unitedit_introduction){
                                                         div=document.createElement('div');
                                                         $(div).addClass('alert');
                                                         $(div).addClass('error_message');
                                                         $(div).html(data.Unitedit_introduction);
                                                         $(div).insertBefore($(form).parents("form").eq(0).find('#Unitedit_introduction').eq(0));
                                                         
                                                         
                                                    }     
                                                    
                                                    
						  
					  	}							  															
					else{
                                            forms=$("form");
                                            for(i=0;i<forms.length;i++){
                                                key="unitedit_catchphrase_"+(i+1);
                                                setCookie(key,$(forms[i]).find('input[type="text"]').eq(0).val());
                                                key="unitedit_introduction_"+(i+1);
                                                val=$(forms[i]).find('textarea').eq(0).val();
                                                val=val.replace(/\n/g, "<br/>");
                                                setCookie(key,val);
                                            }
                                            
                                            $(form).parents("form").eq(0).attr("onsubmit","return true;");                                             
                                            $(form).parents("form").eq(0).submit();
                                           
                                        }
					  	
											    			    
				}	  
			});
			
		});
    });
</script>