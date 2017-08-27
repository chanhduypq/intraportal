<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>
<script type='text/javascript' src='https://maps-api-ssl.google.com/maps/api/js?sensor=false&language=ja'></script>
<script type="text/javascript">
    jQuery(function($) {

        $("body").attr('id', 'admin');
        jQuery('form').attr("action","<?php echo Yii::app()->baseUrl;?>/adminoffice/editconfirm/");
        
        $(window).on('beforeunload', function(){
            setCookie("office_edit_from","confirm");        
        }); 
        
        $('button#submit').click(function(){             
            jQuery("input#edit").val('1');            
            jQuery("form").eq(0).submit();
        });
        $('button#back').click(function(){ 
            setCookie("office_edit_from","confirm");         
            window.location="<?php echo Yii::app()->baseUrl;?>/adminoffice/edit/?id=<?php echo $model->id;?>";
        });
        
        
        
        $('a').click(function() {
        
           
        
            if ($(this).attr('id') == undefined) {
                return;
            }
            window.location = "<?php echo Yii::app()->baseUrl; ?>/adminoffice/download/?file_name=" + $(this).attr('id');
        });


    });


</script>
<div class="wrap admin secondary office">

    <div class="container index">
        <div class="contents detail edit_confirm confirm">
        	
            <div class="mainBox">
            	<div class="pageTtl">
            		<h2>事業所管理 - 修正確認</h2>
            	</div>
            	
                <div class="box">
                    <?php
                     $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'office_form',                     
                    'htmlOptions' => array(
                                          'enctype' => 'multipart/form-data',
                                          'class'=>'form-horizontal',

                                          ),
                     ));
					?>	
                    
                    
                    

                    <?php echo $form->hiddenField($model, 'id'); ?>                      
                    <?php echo $form->hiddenField($model, 'division_name'); ?>                      
                    <?php echo $form->hiddenField($model, 'zipcode'); ?>
                    <?php echo $form->hiddenField($model, 'address'); ?>                    
                    <?php echo $form->hiddenField($model, 'googlemap'); ?>    
                    <input type="hidden" name="edit" value="1"/>
                	<div class="cnt-box form-horizontal">

                        <div class="control-group">
                            <div class="control-label">事業所名</div>
                            <div class="controls">
                                <p><?php echo htmlspecialchars($model->division_name);?></p>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <div class="control-label">郵便番号</div>
                            <div class="controls">
                                <p><?php echo htmlspecialchars($model->zipcode);?></p>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <div class="control-label">住所</div>
                            <div class="controls">
                                <p><?php echo htmlspecialchars($model->address);?></p>
                            </div>
                        </div>
                        <?php
                        $cookie_key_name = 'file_office_edit_attachment4';
                        if (Yii::app()->request->cookies[$cookie_key_name] != "" && Yii::app()->request->cookies[$cookie_key_name] != "null"&&file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name]->value)) {
                            $uploaded_file_attachment4_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase(Yii::app()->request->cookies[$cookie_key_name]->value));
                        } else{
                            $uploaded_file_attachment4_ext = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase($model->photo));
                        } 
                       
                            echo $form->hiddenField($model, 'photo_file_type');
                            echo $form->hiddenField($model, 'photo');
                            echo $form->hiddenField($model, 'photo_checkbox_for_deleting');

                            if ($model->photo_checkbox_for_deleting == '1') {//delete checkbox has been checked
                                echoEmpty($this->assetsBase);
                            } else {//delete checkbox has not been checked                                 
                                if (trim($model->photo) != "" || (Yii::app()->request->cookies[$cookie_key_name] != "" && Yii::app()->request->cookies[$cookie_key_name] != "null" && file_exists(Yii::getPathOfAlias('webroot') . Yii::app()->request->cookies[$cookie_key_name]))) {?>
                                    <div class="control-group">
                                        <div class="control-label">家屋写真</div>
                                        <div class="controls">
                                            <style>
											div.building_photo a{float:none !important;} 	
											a.a_base{float:none !important;}	
                                            img.img_base{ position:relative !important; float:none !important;}
                                        </style>
                                                <?php Upload_file_common_new::echoOldFileOffice($uploaded_file_attachment4_ext, 4, $model, "adminoffice", $action_type = 2,$this->assetsBase);?>
                                        </div>
                                    </div>
                            <?php
                                    
                                } else {//keep old status                                              
                                    echoEmpty($this->assetsBase);
                                }
                            }
                       
                        ?>
                        

						<div class="googlemap">
	                        <div class="control-label">GoogleMap</div>
	                        <div class="value">
                            
                                    <?php 
                                        header("X-XSS-Protection: 0");
                                        echo $model->googlemap;
                                    ?>
	                        </div>
                        </div>
                        
					</div><!--// .cnt-box -->				
<?php $this->endWidget(); ?>
                   
                    <div class="form-last-btn">
                        <div class="btn170">
                            <button id="back" class="btn" type="button"><i class="icon-chevron-left"></i> もどる</button>
                            <button id="submit" class="btn btn-important" type="submit"><i class="icon-chevron-right icon-white"></i> 更新</button>
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
<?php 
function echoEmpty($assetsBase,$has_img = FALSE) {
                
    if ($has_img === true) {                   
        echo '<img alt="" src="' . $assetsBase . '/css/common/img/img_building.jpg">';
    } else {
        echo '';
    }
}
?>