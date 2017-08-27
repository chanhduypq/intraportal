<link href="<?php echo $this->assetsBase; ?>/css/majime/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>

<div class="wrap majime secondary enquete">
    <div class="container">
        <div class="contents regist">
            <div class="mainBox detail">
                <div class="pageTtl"><h2>みんなのアンケートBOX - 登録</h2>
                    <span>
                        <?php echo CHtml::link('<i class="icon-chevron-left icon-white"></i> 一覧に戻る', Yii::app()->request->baseUrl . '/majimeenquete/index', array('class' => 'btn-important btn', 'id' => 'btn-important')); ?>
                    </span>
                </div>
                <div class="box">
                	<?php
					$form = $this->beginWidget('CActiveForm', array(
						'id' => 'enquete_form',    
						'htmlOptions' => array('enctype' => 'multipart/form-data','action'=>Yii::app()->baseUrl.'/majimeenquete/confirm','class'=>'form-horizontal',),
							));
					?>
					<?php echo $form->hiddenField($model, 'id'); ?> 
					<?php echo $form->hiddenField($model, 'title'); ?>   
					<?php echo $form->hiddenField($model, 'content'); ?>   
					<?php echo $form->hiddenField($model, 'deadline_day'); ?>   
					<?php echo $form->hiddenField($model, 'deadline_month'); ?>   
					<?php echo $form->hiddenField($model, 'deadline_year'); ?>   
					<?php echo $form->hiddenField($model, 'answer_type'); ?>   
					<?php echo $form->hiddenField($model, 'answer_content_array'); ?>  
					<input type="hidden" name="regist" id="regist" value="1"/>
					<input type="hidden" name="file_index"/>
                    <div class="cnt-box">
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

                        <div class="control-group">
                             <div class="control-label">締め切り日:</div>
                             <div class="controls">
                            <p><?php echo $model->deadline_year.'/'.$model->deadline_month.'/'.$model->deadline_day;?></p>
                             </div>
                        </div>

                       <div class="field attachements">
                           <?php                    
                                $attachements = $this->beginWidget('ext.helpers.Form_new');
                                $attachements->registConfirm11($model, $form,'majimeenquete',$this->assetsBase);
                                $this->endWidget();
                            
                            ?>
                            
                	   </div>
                        <div class="attachements">
                            <div class="title">回答</div>
                            <div class="control-group">
                                <label for="inputEmail" class="control-label">回答選択方法&nbsp;</label>
                                <div class="controls"> 
									<p>
										<?php $typeEnquete = Constants::$typeEnquete; ?>
										<?php 
										if($model->answer_type==1){
											echo $typeEnquete['1'];
										}
										else{
											echo $typeEnquete['2'];
										}
										?>
                                    </p> 
								</div>
                            </div>
                        </div>
                        <div class="control-group">
                             <label for="title" class="control-label">回答&nbsp;</label>
                            <div class="controls">
                               
                                <ol>
                                    <?php 
									
                                    $answer_content_array=  CJSON::decode($model->answer_content_array);
                                    if(is_array($answer_content_array)&&count($answer_content_array)>0){
                                        foreach ($answer_content_array as $answer_content){ if ($answer_content){?>
                                        
                                            <li class="text-anser">
                                                <?php  echo htmlspecialchars($answer_content); ?>
                                            </li>
                                        <?php   
                                            }
                                        }
                                    }
                                    ?>
                                </ol>
                              
                            </div>
                        </div>
                    </div><!-- /cnt-box -->
					<?php $this->endWidget();?>
                    <div class="form-last-btn">
	                	<div class="btn170">
                                <button type="submit" class="btn" id="back"><i class="icon-chevron-left"></i> もどる</button>  
                                <button class="btn btn-important" type="submit" id="submit"><i class="icon-chevron-right icon-white"></i> 登録</button>
	                    </div>
	                </div>

                </div><!-- /box -->
            </div><!-- /mainBox -->


        </div><!-- /contents -->
        <p id="page-top" style="display: block;"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->

    <div class="footer">
        <p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div>
<script type="text/javascript">
    jQuery(function($) 
	{ 
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
                      $node1=$(this).parent().parent().prev().prev();
                      $node1.remove();
                      $('<img alt="" src="<?php echo $this->assetsBase; ?>/css/common/img/img_photo01.jpg">').insertBefore($(this).parent().parent().prev());                      
                 }
            });
      
		<?php if($model->answer_type!=1){?>
        setCookie("enquete_regist_answer_type",1);
		<?php }?> 
		setCookie("enquete_regist_title",$("#Enquete_title").val());   
		setCookie("enquete_regist_content",$("#Enquete_content").val());
        setCookie("enquete_regist_deadline_year",$("#Enquete_deadline_year").val());
        setCookie("enquete_regist_deadline_month",$("#Enquete_deadline_month").val()); 
	    setCookie("enquete_regist_deadline_day",$("#Enquete_deadline_day").val());
      

        setCookie("enquete_regist_attachment1_checkbox_for_deleting",$("#Enquete_attachment1_checkbox_for_deleting").val());
        setCookie("enquete_regist_attachment2_checkbox_for_deleting",$("#Enquete_attachment2_checkbox_for_deleting").val());
        setCookie("enquete_regist_attachment3_checkbox_for_deleting",$("#Enquete_attachment3_checkbox_for_deleting").val());
        no=1;
        function getUrl(no)
		{
            return "<?php echo Yii::app()->baseUrl;?>/majimeenquete/deleteattechments/?no="+no+"&attachment1=<?php echo $model->attachment1;?>&attachment2=<?php echo $model->attachment2;?>&attachment3=<?php echo $model->attachment3;?>";
        }
        $("body").attr('id','majime');          
        $(window).on('beforeunload', function(){
            setCookie("enquete_regist_from","confirm");            
            
//            $.ajax({    
//                    type: "GET", 
//                    async:false,
//                    url: getUrl(no)
//            });
        }); 

       
        $('button#submit').click(function(){  
            no=2;
            deleteCookies("enquete_regist_from");
            jQuery("input#regist").val('1');            
            jQuery("form#enquete_form").submit();
        });
        $('button#back').click(function(){  
            no=2;
        
            setCookie("enquete_regist_from","confirm");   
            window.location="<?php echo Yii::app()->baseUrl;?>/majimeenquete/regist/";
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
            window.location="<?php echo Yii::app()->baseUrl;?>/majimeenquete/download/?file_name="+$(this).attr('id');
        });        
    });
</script>