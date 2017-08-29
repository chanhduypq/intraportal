




               
<div class="wrap admin secondary soumu_qa" id="admin">

    <div class="container">
        <div class="contents edit_confirm">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>教えて総務さん！FAQ - 登録 確認</h2></div>
                
                <div class="box">
                    <?php
					$form = $this->beginWidget('CActiveForm', array(
						'id' => 'soumu_qa_form',    
						'htmlOptions' => array('enctype' => 'multipart/form-data','action'=>Yii::app()->baseUrl.'/adminsoumu_qa/registconfirm'),
							));
					?>
							<input type="hidden" name="file_index"/>
                    <div class="cnt-box">
                    <div class="form-horizontal">

                        <div class="control-group">
                            <div class="control-label">カテゴリー:</div>
                            <div class="controls">
                                <p>
    							
    							<?php 
								foreach ($category as $category_type){
										if($model->category_id == $category_type['id']){
											echo htmlspecialchars($category_type['category_name']);
											}                                     
                                }
						        ?>	
    							</p>
                            </div>
                        </div>
                        
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
                               <p> <?php echo nl2br(FunctionCommon::url_henkan($model->content));?></p>
                            </div>
                        </div>
                        
                    </div>
                    
                     <div class="field attachements">
                             <?php                    
                                $attachements = $this->beginWidget('ext.helpers.Form_new');
                                $attachements->registConfirm11($model, $form,'adminsoumu_qa',$this->assetsBase);
                                $this->endWidget();
                             ?>	                        
                 		 </div>
                    
                    </div><!-- /cnt-box -->	
            		<?php echo $form->hiddenField($model, 'id'); ?>  
					<?php echo $form->hiddenField($model, 'category_id'); ?>  
                    <?php echo $form->hiddenField($model, 'title'); ?>  
                    <?php echo $form->hiddenField($model, 'content'); ?> 
                	<input type="hidden" name="regist" id="regist" value="1"/>
                                            <?php $this->endWidget(); ?>    
	                <div class="form-last-btn">
	                	<div class="btn170">
		                    <button type="submit" class="btn" id="back"><i class="icon-chevron-left"></i> もどる</button>
		                    <button type="submit" class="btn btn-important" id="submit"><i class="icon-chevron-right icon-white"></i> 登録</button>
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
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
</div>

</div><!-- /wrap -->
<script type="text/javascript">
    jQuery(function($) { 
        no=1;
        function getUrl(no){
            return "<?php echo Yii::app()->baseUrl;?>/common/deletecookie/?no="+no;
        }
        $("body").attr('id','admin');          
        $(window).on('beforeunload', function(){
            setCookie("soumu_qa_regist_from","confirm");            
            
            $.ajax({    
                    type: "GET", 
                    async:false,
                    url: getUrl(no)
            });
        }); 
		setCookie("soumu_qa_regist_category_id",$("#Soumu_qa_category_id").val());
        setCookie("soumu_qa_regist_title",$("#Soumu_qa_title").val());
        setCookie("soumu_qa_regist_content",$("#Soumu_qa_content").val());
        setCookie("soumu_qa_regist_attachment1_checkbox_for_deleting",$("#Soumu_qa_attachment1_checkbox_for_deleting").val());
        setCookie("soumu_qa_regist_attachment2_checkbox_for_deleting",$("#Soumu_qa_attachment2_checkbox_for_deleting").val());
        setCookie("soumu_qa_regist_attachment3_checkbox_for_deleting",$("#Soumu_qa_attachment3_checkbox_for_deleting").val());
       
        $('button#submit').click(function(){  
            no=2;
            deleteCookies("soumu_qa_regist_from");
            jQuery("input#regist").val('1');            
            jQuery("form#soumu_qa_form").submit();
        });
        $('button#back').click(function(){  
             no=2;      
            setCookie("soumu_qa_regist_from","confirm");   
            
            window.location="<?php echo Yii::app()->baseUrl;?>/adminsoumu_qa/regist/";
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
            window.location="<?php echo Yii::app()->baseUrl;?>/adminsoumu_qa/download/?file_name="+$(this).attr('id');
        });        
    });
</script>