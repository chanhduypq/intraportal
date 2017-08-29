



 
<div class="wrap admin secondary enquete">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>みんなのアンケートBOX - 修正 確認</h2>
				</div>
                <div class="box">
				<?php
					$form = $this->beginWidget('CActiveForm', array(
						'id' => 'enquete_form',
						'htmlOptions' => array('enctype' => 'multipart/form-data', 'action' => Yii::app()->baseUrl . '/adminenquete/editconfirm'),
							));
					?>
				<input type="hidden" name="file_index"/>
				<input type="hidden" name="edit" id="edit" value="1"/>
				<?php echo $form->hiddenField($model, 'id'); ?>  
				<?php echo $form->hiddenField($model, 'title'); ?>   
				<?php echo $form->hiddenField($model, 'content'); ?> 
				<?php echo $form->hiddenField($model, 'num_anser');  ?> 
				<?php echo $form->hiddenField($model, 'id_anser_array'); ?> 
				<?php echo $form->hiddenField($model, 'deadline_day'); ?>   
				<?php echo $form->hiddenField($model, 'deadline_month'); ?>   
				<?php echo $form->hiddenField($model, 'deadline_year'); ?>   
				<?php echo $form->hiddenField($model, 'answer_type'); ?>   
				<?php echo $form->hiddenField($model, 'answer_content_array'); ?>
				<?php echo $form->hiddenField($model, 'comment'); ?>   
                <div class="cnt-box">
                  	  <div class="form-horizontal">
                                <div class="control-group">
                                    <div class="control-label">タイトル:</div>
                                    <div class="controls">
                                         <p><?php echo htmlspecialchars($model->title);?></p>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <div class="control-label">本文</div>
                                    <div class="controls">
                                        <p>
                                            <?php  echo nl2br(FunctionCommon::url_henkan($model->content));?>	
                                        </p>
                                    </div>
                                </div>
                        
                                <div class="control-group">
                                    <div class="control-label">締め切り日:</div>
                                    <div class="controls">
                                        <p>
                                            <?php echo $model->deadline_year.'/'.$model->deadline_month.'/'.$model->deadline_day;?>
                                        </p>
                                    </div>
                                </div>
                        
                  	    </div>
                    
                    	 <div class="field attachements">
                            <?php                    
                            $attachements = $this->beginWidget('ext.helpers.Form_new');
                            $attachements->editConfirm11($model, $form,'adminenquete',$this->assetsBase);
                            $this->endWidget();
                            ?>
                         </div>
                    
                    </div><!-- /cnt-box -->	

	                <div class="box">
	            		<h3>アンケート内容</h3>
		                    <div class="control-group">
		                        <label for="title" class="control-label">選択方法&nbsp;</label>
		                        <div class="controls">
		                        	 <?php $typeEnquete = Constants::$typeEnquete; ?>
                                    <?php 
                                    if($model->answer_type==1){
                                        echo $typeEnquete['1'];
                                    }
                                    else{
                                        echo $typeEnquete['2'];
                                    }
                                    ?>
		                        </div>
		                    </div>
		                    <div class="control-group">
		                        <label for="title" class="control-label">選択枝&nbsp;</label>
		                        <div class="controls">
		                        	<ol>
		                        		<?php 
                                        $answer_content_array=  CJSON::decode($model->answer_content_array);
                                        if(is_array($answer_content_array)&&count($answer_content_array)>0){
                                            foreach ($answer_content_array as $answer_content)
											{ 
												if ($answer_content){?>
                                            
                                                <li class="text-anser">
													<?php echo htmlspecialchars($answer_content);?>
                                                </li>
                                            <?php   
												}
                                            }
                                        }
                                        ?>
		                        	</ol>
		                        </div>
		                    </div>
					</div>
					<div class="box">
	            		<h3>回答コメント</h3>
	
	                    <div class="control-group">
	                        <label for="content" class="control-label">コメント&nbsp;</label>
	                        <div class="controls">
	                        	<p>
									<?php echo nl2br(FunctionCommon::url_henkan($model->comment)); ?>	
	                        	</p>
	                        </div>
	                    </div>
	
	                </div>
<?php $this->endWidget(); ?>
                   
	                <div class="form-last-btn">
	                	<div class="btn170">
		                    <button id="back" class="btn" type="submit"><i class="icon-chevron-left"></i> もどる</button>
		                    <button class="btn btn-important" type="submit"  id="submit"><i class="icon-chevron-right icon-white"></i> 更新</button>
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
<script type="text/javascript">
    jQuery(function($)
	{  
	
		$("body").attr('id','admin');  
        setCookie("enquete_edit_title",$("#Enquete_title").val());   
		setCookie("enquete_edit_deadline_year",$("#Enquete_deadline_year").val());
		setCookie("enquete_edit_deadline_month",$("#Enquete_deadline_month").val()); 
		setCookie("enquete_edit_deadline_day",$("#Enquete_deadline_day").val());
        setCookie("enquete_edit_content",$("#Enquete_content").val());
		setCookie("enquete_edit_comment",$("#Enquete_comment").val());
        setCookie("enquete_edit_attachment1_checkbox_for_deleting",$("#Enquete_attachment1_checkbox_for_deleting").val());
        setCookie("enquete_edit_attachment2_checkbox_for_deleting",$("#Enquete_attachment2_checkbox_for_deleting").val());
        setCookie("enquete_edit_attachment3_checkbox_for_deleting",$("#Enquete_attachment3_checkbox_for_deleting").val());        
               
		
        no=1;
        function getUrl(no)
		{
            return "<?php echo Yii::app()->baseUrl;?>/adminenquete/deleteattechments/?id=<?php echo $model->id;?>&no="+no+"&attachment1=<?php echo $model->attachment1;?>&attachment2=<?php echo $model->attachment2;?>&attachment3=<?php echo $model->attachment3;?>";
        }
        $(window).on('beforeunload', function()
		{
            setCookie("enquete_edit_from","confirm");            
            
//            $.ajax({    
//                    type: "GET", 
//                    async:false,
//                    url: getUrl(no)
//            });
        }); 
		
        $('button#submit').click(function(){  
            no=2;
            deleteCookies("enquete_edit_from");
			deleteCookies("loaddata_edit");
            jQuery("input#edit").val('1');            
            jQuery("form#enquete_form").submit();
        });
		
        $('button#back').click(function()
		{  
            no=2; 
            setCookie("enquete_edit_from","confirm");   
            window.location="<?php echo Yii::app()->baseUrl;?>/adminenquete/edit/?id=<?php echo $model->id?>";
        });
		
        $('a').click(function()
		{  
			
            img=$(this).find('img');
           
            if(img.length==1)
			{
                no=2;
            }
            else
			{ 
                no=1;

            }
            if($(this).attr('id')==undefined)
			{
                return;
            }
			 window.location="<?php echo Yii::app()->baseUrl;?>/majimeenquete/download/?file_name="+$(this).attr('id');
        });


    });
	
</script>