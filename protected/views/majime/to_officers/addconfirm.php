




  

  

<div class="wrap majime secondary to_officers">

    <div class="container">
        <div class="contents confirm">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>役員宛目安箱 - 登録 確認</h2></div>
                
                <div class="box">
                  <?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'toofficer_form',    
    'htmlOptions' => array('enctype' => 'multipart/form-data','action'=>Yii::app()->baseUrl.'/majimetoofficers/addconfirm'),
        ));
?>
<input type="hidden" name="file_index"/>   
                    <div class="cnt-box">
                    <div class="form-horizontal">

                        <div class="control-group">
                            <div class="control-label">タイトル:</div>
                            <div class="controls">
                                <p>
									<?php echo htmlspecialchars($model->title);?>
								</p>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="control-label">本文</div>
                            <div class="controls">
                                <p>
									<?php echo nl2br(FunctionCommon::url_henkan($model->content));?>	
								</p>
                            </div>
                        </div>
                        
                    </div>                   
                        <div class="field attachements">
                            <?php                    
                                $attachements = $this->beginWidget('ext.helpers.Form_new');                                
                                $attachements->registConfirm11($model, $form,'majimeto_officer',$this->assetsBase);
                                $this->endWidget();
                            ?>

                  </div>
                    
                    </div><!-- /cnt-box -->	
            		
        
    <?php echo $form->hiddenField($model, 'title'); ?>  
    <?php echo $form->hiddenField($model, 'content'); ?>  
                    <input type="hidden" name="add" id="add" value="1"/>
       	   <?php $this->endWidget(); ?>  
	                <div class="form-last-btn">
	                	<div class="btn170">
                                    <button type="submit" class="btn" id="back"><i class="icon-chevron-left"></i> もどる</button>                                    
                                    <button class="btn btn-important" type="submit" id="submit"><i class="icon-chevron-right icon-white"></i> 登録</button>
	                    </div>
	                </div>

                </div><!-- /box -->
            </div><!-- /mainBox -->
            
            
        </div><!-- /contents -->
        <p id="page-top" style="display: none;"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div>
<script type="text/javascript">
    jQuery(function($) { 
        
        no=1;
        function getUrl(no){
            return "<?php echo Yii::app()->baseUrl;?>/common/deletecookie/?no="+no;
        }
        
        $("body").attr('id', 'majime');
         $(window).on('beforeunload', function(){
        setCookie("to_officer_add_from","confirm");
         $.ajax({    
                    type: "GET", 
                    async:false,
                    url: getUrl(no)


            });
        });  
        setCookie("to_officer_add_title",$("#Toofficer_title").val());
        setCookie("to_officer_add_content",$("#Toofficer_content").val());
        setCookie("to_officer_add_attachment1_checkbox_for_deleting",$("#Toofficer_attachment1_checkbox_for_deleting").val());
       setCookie("to_officer_add_attachment2_checkbox_for_deleting",$("#Toofficer_attachment2_checkbox_for_deleting").val());
       setCookie("to_officer_add_attachment3_checkbox_for_deleting",$("#Toofficer_attachment3_checkbox_for_deleting").val());
       $('button#submit').click(function(){  
            no=2;
            deleteCookies("to_officer_add_from");
            jQuery("input#add").val('1');            
            jQuery("form#toofficer_form").submit();
        });
        $('button#back').click(function(){ 
             no=2;      
            setCookie("to_officer_add_from","confirm");   
          
            window.location="<?php echo Yii::app()->baseUrl;?>/majimeto_officer/add/";
        });
        $('a').click(function(){  
           img=$(this).find('img');
           
            if(img.length==1){
                no=2;
            }
            else{ 
                no=1;

            }
            if($(this).attr('id')==undefined){
                return;
            }
            window.location="<?php echo Yii::app()->baseUrl;?>/majimeto_officer/download/?file_name="+$(this).attr('id');
        });
    });
    
    
</script>
