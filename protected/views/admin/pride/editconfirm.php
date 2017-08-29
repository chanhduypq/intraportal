




<div class="wrap admin secondary pride"> 

    <div class="container">
        <div class="contents confirm">

            <div class="mainBox detail">
                <div class="pageTtl"><h2>あそびにマジメ！？あそび自慢＆対決！ - 修正 確認</h2></div>

                <div class="box">
                        <?php
						$form = $this->beginWidget('CActiveForm', array(
							'id' => 'pride_form',
							'htmlOptions' => array('enctype' => 'multipart/form-data', 'action' => Yii::app()->baseUrl . '/adminpride/editconfirm'),
								));
						?>
						<input type="hidden" name="file_index"/>
						<?php echo $form->hiddenField($model, 'id'); ?>   
                        <?php echo $form->hiddenField($model, 'created_date'); ?> 
                    <div class="cnt-box">
                        <div class="form-horizontal">
                        	<div class="control-group">
                                <div class="control-label">アイコン:</div>
                                <div class="controls">
                                    <p><span class="pride-icon pride-icon-prize0<?php echo $model->icon;?>">icon0<?php echo $model->icon;?></span></p>
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
                                    <p>
                                         <?php echo nl2br(FunctionCommon::url_henkan($model->content));?>
                                    </p>
                                </div>
                            </div>
                        </div>                   
                        <div class="field attachements">
                            <?php                    
                            $attachements = $this->beginWidget('ext.helpers.Form_new');
                            $attachements->editConfirm11($model, $form,'adminpride',$this->assetsBase);
                            $this->endWidget();
                            ?>
                        </div>
                    </div><!-- /cnt-box -->	
                    <?php echo $form->hiddenField($model, 'icon'); ?> 
					<?php echo $form->hiddenField($model, 'title'); ?>  
                    <?php echo $form->hiddenField($model, 'content'); ?>  
                    <input type="hidden" name="edit" id="edit" value="1"/>    
<?php $this->endWidget(); ?>                                      
                    <div class="form-last-btn">
                        <div class="btn170">
                            <button type="submit" class="btn" id="back"><i class="icon-chevron-left"></i> もどる</button>                                    
                            <button class="btn btn-important" id="submit" type="submit"><i class="icon-chevron-right icon-white"></i> 更新</button>
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
        
        $(window).on('beforeunload', function(){
            setCookie("pride_edit_from","confirm");            
        }); 
        $('button#submit').click(function(){  
            deleteCookies("pride_edit_from");
            jQuery("input#edit").val('1');            
            jQuery("form#pride_form").submit();
        });
        $('button#back').click(function(){ 
            setCookie("pride_edit_from","confirm");   
            window.location="<?php echo Yii::app()->baseUrl;?>/adminpride/edit/?id=<?php echo $model->id;?>";
        });
        $('a').click(function(){  
            if($(this).attr('id')==undefined){
                return;
            }
			 window.location="<?php echo Yii::app()->baseUrl;?>/adminpride/download/?file_name="+$(this).attr('id');
        });
       
	    setCookie("pride_edit_icon",$("#Pride_icon").val());
        setCookie("pride_edit_title",$("#Pride_title").val());
        setCookie("pride_edit_content",$("#Pride_content").val());
        setCookie("pride_edit_attachment1_checkbox_for_deleting",$("#Pride_attachment1_checkbox_for_deleting").val());
        setCookie("pride_edit_attachment2_checkbox_for_deleting",$("#Pride_attachment2_checkbox_for_deleting").val());
        setCookie("pride_edit_attachment3_checkbox_for_deleting",$("#Pride_attachment3_checkbox_for_deleting").val());        
        $("body").attr('id','admin');         
    });
</script>