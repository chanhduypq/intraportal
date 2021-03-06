



                 
<div class="wrap admin secondary soumu_jinji" id="admin">

    <div class="container">
        <div class="contents regist_confirm">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>総務からのお知らせ：人事 - 登録 確認</h2></div>
                
                <div class="box">
                	<?php
					$form = $this->beginWidget('CActiveForm', array(
						'id' => 'soumu_jinji_form',    
						'htmlOptions' => array('enctype' => 'multipart/form-data','action'=>Yii::app()->baseUrl.'/adminsoumu_jinji/registconfirm'),
							));
					?>
						   
							<?php echo $form->hiddenField($model, 'category_id'); ?>  
							<?php echo $form->hiddenField($model, 'employee_name'); ?>  
						
							<?php echo $form->hiddenField($model, 'deadline_day'); ?>   
							<?php echo $form->hiddenField($model, 'deadline_month'); ?>   
							<?php echo $form->hiddenField($model, 'deadline_year'); ?> 
							<input type="hidden" name="regist" id="regist" value="1"/>
							<input type="hidden" name="file_index"/>
                    <div class="cnt-box">
                    <div class="form-horizontal">

                    <div class="control-group">
                        <label class="control-label" for="title">カテゴリー&nbsp;
                        <span class="label label-warning">必須</span></label>
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
                        <label class="control-label" for="pubdate">日付&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	 <p><?php echo $model->deadline_year.'/'.$model->deadline_month.'/'.$model->deadline_day;?></p>
                        
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="name">内容&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	<p>
								<?php echo FunctionCommon::url_henkan($model->employee_name);?>
							</p>
                        </div>
                    </div>
                    
                    </div>
                    </div><!-- /cnt-box -->	
                   
                    <?php $this->endWidget(); ?>    
	                <div class="form-last-btn">
	                	<div class="btn170">
                        	 <button type="submit" class="btn" onclick="back();"><i class="icon-chevron-left"></i> もどる</button> 
                       	     <button class="btn btn-important" type="submit" onclick="submit();"><i class="icon-chevron-right icon-white"></i> 登録</button>
		                   
	                    </div>
	                </div>
                    </form>

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
			setCookie("category_id",$("#Soumu_jinji_category_id").val());
		   setCookie("employee_name",$("#Soumu_jinji_employee_name").val());  
		   setCookie("deadline_year",$("#Soumu_jinji_deadline_year").val());
		   setCookie("deadline_month",$("#Soumu_jinji_deadline_month").val()); 
		   setCookie("deadline_day",$("#Soumu_jinji_deadline_day").val());    
			$("body").attr('id','admin');  
			$(window).on('beforeunload', function(){
				setCookie("from_jini","confirmedit");
			});    
		});
	function back(){
		jQuery("input#regist").val('0');
        jQuery("form#soumu_jinji_form").attr('action','<?php echo Yii::app()->baseUrl;?>/adminsoumu_jinji/regist/');
        jQuery("form#soumu_jinji_form").submit();
		deleteCookies("from_jini");
    }
    function submit(){        
        jQuery("input#regist").val('1');        
        jQuery("form#soumu_jinji_form").attr('action','<?php echo Yii::app()->baseUrl;?>/adminsoumu_jinji/registconfirm/');
        jQuery("form#soumu_jinji_form").submit();
		deleteCookies("from_jini");
    }
</script>
