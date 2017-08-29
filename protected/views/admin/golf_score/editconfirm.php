

<div class="wrap admin secondary golf_score">

     <div class="container">
        <div class="contents confirm">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>ゴルフもマジメ！年間スコアランキング - 修正 確認</h2></div>
                <div class="box">
                <?php
				$form = $this->beginWidget('CActiveForm', array(
					'id' => 'golf_score_form',    
					'htmlOptions' => array('enctype' => 'multipart/form-data','action'=>Yii::app()->baseUrl.'/admingolf_score/editconfirm'),
						));
				?> 
                
					<input type="hidden" name="file_index"/>
                    <div class="cnt-box">
                        <div class="form-horizontal">
                        	
                            <div class="control-group">
                                <div class="control-label">スコア：</div>
                                <div class="controls">
                                    <p><?php echo $model->score;?></p>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="control-label">コース名：</div>
                                <div class="controls">
                                    <p><?php echo nl2br(htmlspecialchars($model->score_name));?>	</p>
                                </div>
                            </div>
                             <div class="control-group">
                                <label class="control-label" for="title">日付：</label>
                                <div class="controls">
                                    <p><?php echo $model->deadline_year.'/'.$model->deadline_month.'/'.$model->deadline_day;?></p>
                                </div>
                            </div>
                        </div>                   
                       
                </div><!-- /cnt-box -->	
                		<?php echo $form->hiddenField($model, 'id'); ?>
						<?php echo $form->hiddenField($model, 'score'); ?>  
                        <?php echo $form->hiddenField($model, 'score_name'); ?>  
                        <?php echo $form->hiddenField($model, 'deadline_day'); ?>   
						<?php echo $form->hiddenField($model, 'deadline_month'); ?>   
                        <?php echo $form->hiddenField($model, 'deadline_year'); ?> 
                        <input type="hidden" name="edit" id="edit" value="1"/>
                        <?php $this->endWidget(); ?>         	
                <div class="form-last-btn">
                    <div class="btn170">
                        <button type="submit" class="btn" id="back"><i class="icon-chevron-left"></i> もどる</button> 
                        <button class="btn btn-important" type="submit"  id="submit"><i class="icon-chevron-right icon-white"></i> 登録</button>
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
        </div>
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
            setCookie("golf_score_edit_from","confirm");            
        }); 
      
	   setCookie("golf_score_edit_score",$("#Golf_score_score").val()); 
	   setCookie("golf_score_edit_score_name",$("#Golf_score_score_name").val());  
	   setCookie("golf_score_edit_deadline_year",$("#Golf_score_deadline_year").val());
	   setCookie("golf_score_edit_deadline_month",$("#Golf_score_deadline_month").val()); 
	   setCookie("golf_score_edit_deadline_day",$("#Golf_score_deadline_day").val());
										   
        $('button#submit').click(function(){  
            deleteCookies("golf_score_edit_from");
            jQuery("input#edit").val('1');            
            jQuery("form#golf_score_form").submit();
        });
        $('button#back').click(function(){  
		  	
            setCookie("golf_score_edit_from","confirm");   
            window.location="<?php echo Yii::app()->baseUrl;?>/admingolf_score/edit/?id=<?php echo $model->id;?>";
        });
          
    });
</script>