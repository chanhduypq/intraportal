<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>

<div class="wrap admin secondary golf_news">

    <div class="container">
        <div class="contents edit_confirm">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>ゴルフもマジメ！ - 修正 確認</h2></div>
                
                <div class="box">
                    <?php                    
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'golf_news_form',
                        'htmlOptions' => array('enctype' => 'multipart/form-data', 'action' => Yii::app()->baseUrl . '/admingolf_news/editconfirm'),
                            ));
                    ?>
                    <input type="hidden" name="file_index"/>
                    <input type="hidden" name="edit" id="edit" value="1"/>
                    <?php echo $form->hiddenField($model, 'id'); ?> 
                    <?php echo $form->hiddenField($model, 'title'); ?>  
                    <?php echo $form->hiddenField($model, 'content'); ?> 
                    <?php echo $form->hiddenField($model, 'category_id'); ?> 
                    <div class="cnt-box">
                    <div class="form-horizontal">

                        <div class="control-group">
                            <div class="control-label">カテゴリー:</div>
                            <div class="controls">
<!--                                <p><span style="background-color: #8AC936; color:#ffffff;" class="label">ゴルフ参加者募集中！</span></p>-->
                                <p><span class="label" id="category"></span></p>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <div class="control-label">アイキャッチ画像:</div>
                            <div class="controls">
                                <div class="imgbox">                                        
                                                      
                                                              
                                        <?php
                                        $attachement4 = $this->beginWidget('ext.helpers.Form_new');									
                                        $attachement4->editConfirm14($model, $form,'admingolf_news',$this->assetsBase);
                                        $this->endWidget();   
                                        ?>

                                   </div>
                                                
                                               
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <div class="control-label">タイトル:</div>
                            <div class="controls">
                                <p><?php echo htmlspecialchars($model->title);?></p>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <div class="control-label">本文</div>
                            <div class="controls">
                                <p><?php echo nl2br(FunctionCommon::url_henkan($model->content));?>	</p>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="field attachements">

                           <?php                    
                            $attachements = $this->beginWidget('ext.helpers.Form_new');
                            $attachements->editConfirm11($model, $form,'admingolf_news',$this->assetsBase);
                            $this->endWidget();
                            ?>
            		</div>
                    
                    </div><!-- /cnt-box -->	
            	    <?php $this->endWidget(); ?>                  	
                	
                    
	                <div class="form-last-btn">
	                	<div class="btn170">
		                    <button id="back" class="btn" type="submit"><i class="icon-chevron-left"></i> もどる</button>
		                    <button class="btn btn-important" type="submit" id="submit"><i class="icon-chevron-right icon-white"></i> 更新</button>
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
        if ($('#Golfnews_eye_catch_checkbox_for_deleting').parent().find('a').length == 0) {

            ck = $('#Golfnews_eye_catch_checkbox_for_deleting').clone();
            eye=$('#Golfnews_eye_catch').clone();
            $("#golf_news_form").append($(ck));
            $("#golf_news_form").append($(eye));           
            $('#Golfnews_eye_catch_checkbox_for_deleting').parent().parent().parent().remove();
        }
        
        $(window).on('beforeunload', function(){
            setCookie("golf_news_edit_from","confirm");                       
        }); 
        $('button#submit').click(function(){  
            
            setCookie("golf_news_edit_from","confirm");                     
            jQuery("input#edit").val('1');            
            jQuery("form#golf_news_form").submit();
        });
        $('button#back').click(function(){              
            setCookie("golf_news_edit_from","confirm");               
            window.location="<?php echo Yii::app()->baseUrl;?>/admingolf_news/edit/?id=<?php echo $model->id;?>";
        });
        $('a').click(function(){  
            
            
            if($(this).attr('id')==undefined){
                return;
            }
            window.location="<?php echo Yii::app()->baseUrl;?>/asobigolf_news/download/?file_name="+$(this).attr('id');
        });
        setCookie("golf_news_edit_title", $("#Golfnews_title").val());
        setCookie("golf_news_edit_content", $("#Golfnews_content").val());
        setCookie("golf_news_edit_category_id", $("#Golfnews_category_id").val());
        setCookie("golf_news_edit_attachment1_checkbox_for_deleting", $("#Golfnews_attachment1_checkbox_for_deleting").val());
        setCookie("golf_news_edit_attachment2_checkbox_for_deleting", $("#Golfnews_attachment2_checkbox_for_deleting").val());
        setCookie("golf_news_edit_attachment3_checkbox_for_deleting", $("#Golfnews_attachment3_checkbox_for_deleting").val());
        setCookie("golf_news_edit_eye_catch_checkbox_for_deleting", $("#Golfnews_eye_catch_checkbox_for_deleting").val());

//        if($("#Golfnews_eye_catch_checkbox_for_deleting")!=null&&$("#Golfnews_eye_catch_checkbox_for_deleting")!=undefined&&$("#Golfnews_eye_catch_checkbox_for_deleting").val()!=undefined){
//            setCookie("golf_news_edit_eye_catch_checkbox_for_deleting",$("#Base_photo_checkbox_for_deleting").val());
//        }
//        else{
//            setCookie("golf_news_edit_eye_catch_checkbox_for_deleting",'1');
//        } 
        category_name = getCookie("golf_news_edit_category_name");
        if(category_name!=null&&category_name!="null"){
            background_color = getCookie("golf_news_edit_background_color");
            color = getCookie("golf_news_edit_color");
            $("span#category").html(category_name);
            $("span#category").css('background-color', background_color);
            $("span#category").css('color', color);
        }
        else{
            $("span#category").parent().parent().parent().remove();
        }
        
        
    });
</script>