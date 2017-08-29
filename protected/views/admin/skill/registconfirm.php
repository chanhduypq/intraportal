



<div class="wrap admin secondary skill">

    <div class="container">
        <div class="contents confirm">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>資格取得・スキルアップ！ - 登録 確認</h2></div>
                <div class="box">
                <?php
						$form = $this->beginWidget('CActiveForm', array(
							'id' => 'skill_form',    
							'htmlOptions' => array('enctype' => 'multipart/form-data','action'=>Yii::app()->baseUrl.'/adminskill/registconfirm'),
								));
				?>
						<input type="hidden" name="file_index"/>          
                    <div class="cnt-box">
                    	
                        <div class="form-horizontal">
                        	<div class="control-group">
                                <label class="control-label" for="title">カテゴリー</label>
                                <div class="controls">
                                    <p>
                                    <?php 
										foreach ($category as $category_type){
												if($model->category_id == $category_type['id']){
													echo $category_type['category_name'];
													}                                     
										}
									?>	
                                    </p>
                                </div>
                            </div>
                        
                            <div class="control-group">
                                <label class="control-label" for="content">タイトル</label>
                                <div class="controls">
                                    <p>
										<?php echo htmlspecialchars($model->title);?>
									</p>
                                </div>
                            </div>
                            
                             <div class="control-group">
                                <label class="control-label" for="content">URL</label>
                                <div class="controls">
                                    <p><?php echo htmlspecialchars($model->url);?></p>
                                </div>
                            </div>
                        
                            <div class="control-group">
                                <label class="control-label" for="content">コメント</label>
                                <div class="controls">
                                    <p>
										<?php echo nl2br(FunctionCommon::url_henkan($model->comment));?>
									</p>
                                </div>
                            </div>
                        </div>                   
                        <div class="field attachements">
							<?php $attachements = $this->beginWidget('ext.helpers.Form_new');?>
							<?php $attachements->registConfirm11($model, $form,'adminskill',$this->assetsBase);?>
							<?php $this->endWidget();?>	
                 		 </div>
                </div><!-- /cnt-box -->	
						<?php echo $form->hiddenField($model, 'id'); ?>  
                        <?php echo $form->hiddenField($model, 'category_id'); ?>  
                        <?php echo $form->hiddenField($model, 'url'); ?>  
                        <?php echo $form->hiddenField($model, 'title'); ?>  
                        <?php echo $form->hiddenField($model, 'comment'); ?>  
                        <input type="hidden" name="regist" id="regist" value="1"/>
                           	<?php $this->endWidget(); ?>         	
                <div class="form-last-btn">
                    <div class="btn170">
                        <button type="submit" class="btn" id="back"><i class="icon-chevron-left"></i> もどる</button> 
                        <button class="btn btn-important" type="submit" id="submit"><i class="icon-chevron-right icon-white"></i> 登録</button>
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
    jQuery(function($) { 
       
        $("body").attr('id','admin');          
        $(window).on('beforeunload', function(){
            setCookie("skill_regist_from","confirm");            
           
        }); 
		setCookie("Skill_regist_category_id",$("#Skill_category_id").val());
		setCookie("skill_regist_url",$("#Skill_url").val());
		setCookie("skill_regist_title",$("#Skill_title").val());
        setCookie("skill_regist_comment",$("#Skill_comment").val());
		
        setCookie("skill_regist_attachment1_checkbox_for_deleting",$("#Skill_attachment1_checkbox_for_deleting").val());
        setCookie("skill_regist_attachment2_checkbox_for_deleting",$("#Skill_attachment2_checkbox_for_deleting").val());
        setCookie("skill_regist_attachment3_checkbox_for_deleting",$("#Skill_attachment3_checkbox_for_deleting").val());
       
        $('button#submit').click(function(){  
            deleteCookies("skill_regist_from");
            jQuery("input#regist").val('1');            
            jQuery("form#skill_form").submit();
        });
        $('button#back').click(function(){  
            setCookie("skill_regist_from","confirm");   
            window.location="<?php echo Yii::app()->baseUrl;?>/adminskill/regist/";
        });
        $('a').click(function(){  
            if($(this).attr('id')==undefined){
                return;
            }
            window.location="<?php echo Yii::app()->baseUrl;?>/adminskill/download/?file_name="+$(this).attr('id');
        });        
    });
</script>