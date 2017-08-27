<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>               
<div class="wrap admin secondary base">

    <div class="container">
        <div class="contents detail">
        	
            <div class="mainBox">
            	<div class="pageTtl"><h2>部署管理 > 部署修正確認</h2></div>
                <div class="box">
                
                	 <p class="descriptionTxt">部署&amp;メンバー紹介ページに反映されます。</p>
                	 <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'unit_form',
                        'htmlOptions' => array('enctype' => 'multipart/form-data', 'action' => Yii::app()->baseUrl . '/adminbase/editconfirm'),
                    ));
                    ?>
                  
                    <?php echo $form->hiddenField($model, 'last_updated_person', array('value' => 'last_updated_person')); ?>
                    <input type="hidden" name="edit" id="edit" value="1"/>
                    <input type="hidden" name="file_index"/>
                    <input type="hidden" name="cancel_random" value="<?php if($model->cancel_random =='1') echo '1'; else echo '0';?>"/>
                    <?php echo $form->hiddenField($model, 'id'); ?>  
                    <?php echo $form->hiddenField($model, 'branch_id'); ?>  
                    <?php echo $form->hiddenField($model, 'unit_name'); ?>  
                    <?php echo $form->hiddenField($model, 'mailaddr'); ?>
                    <?php echo $form->hiddenField($model, 'office_id'); ?>
                    <?php echo $form->hiddenField($model, 'catchphrase'); ?>
                    <?php echo $form->hiddenField($model, 'introduction'); ?>  
                    <?php echo $form->hiddenField($model, 'tel_number'); ?>  
                    <div class="cnt-box">
                    	<div class="baseDetailBox form-horizontal">
                            <div class="field attachements">
                                <div class="title"><?php if(isset($base_company)&&  is_array($base_company)&&count($base_company)>0) echo $base_company['company_name'];?> 部署Data</div>
							</div>

	                        <div class="control-group">
	                            <div class="control-label">部門</div>
	                            <div class="controls">
	                                <p> 
									<?php
                                   foreach ($branch as $branch_name){
										   if($model->branch_id==$branch_name['id']){
											   echo $branch_name['branch_name'];
											   }
									}
									?>
                                	</p>
	                            </div>
	                        </div>

	                        <div class="control-group">
	                            <div class="control-label">部署名</div>
	                            <div class="controls">
                                        <p><?php echo nl2br(FunctionCommon::url_henkan($model->unit_name)); ?></p>
	                            </div>
	                        </div>
                            
	                        <div class="control-group">
	                            <div class="control-label">連絡先Mail</div>
	                            <div class="controls">
	                                <p><?php echo $model->mailaddr; ?></p>
	                            </div>
	                        </div>

	                        <div class="control-group">
	                            <div class="control-label">事業所</div>
	                            <div class="controls">
	                                <p>
                                    <?php
                                    foreach ($office as $office_name){
									   if($model->office_id==$office_name['id']){
									   echo "〒".$office_name['zipcode']."&nbsp;".$office_name['address'];
										}
									}
									?>
                                    </p>
	                            </div>
	                        </div>
                            <div class="control-group">
	                            <div class="control-label">電話番号</div>
	                            <div class="controls">
	                                <p><?php echo $model->tel_number; ?></p>
	                            </div>
	                        </div>

                        </div><!-- /baseDetailBox -->
					</div><!-- /cnt-box -->
                    
                    <div class="cnt-box">
	                      <p class="descriptionTxt">部署&amp;メンバー紹介ページと、マジメのポータルトップページの今週の部署紹介に反映されます。</p>
                
                        <div class="baseDetailBox">
                            <div class="textBox clearfix">
                                <div class="field introduceTtl">
                                    <div class="title">自動選出除外&nbsp;</div>
                                    <div class="data">
										<p>
											<?php echo $form->checkBox($model,'cancel_random'); ?>&nbsp;今週の部署紹介による自動選出から除外する
										</p>
									</div>
                                </div>
                                <div class="field introduceTtl">
                                    <div class="title">紹介タイトル&nbsp;</div>
                                    <div class="data"><p><?php echo nl2br(FunctionCommon::url_henkan($model->catchphrase)); ?></p></div>
                                </div>
                                
                                <div class="field introduceTxt">
                                    <div class="title">紹介文&nbsp;</div>
                                    <div class="data"><?php echo nl2br(FunctionCommon::url_henkan($model->introduction)); ?></div>
                                </div>
                                
                                <div class="attachements">
                                 <?php                    
									$attachements = $this->beginWidget('ext.helpers.Form_new');									
                                    $attachements->editConfirm11($model, $form,'adminbase',$this->assetsBase);
									$this->endWidget();
                           		 ?>
                                 
                                </div><!-- /attachements -->
                                
                            </div><!-- /taxtBox -->
                        </div><!-- /baseDetailBox -->
                    </div><!-- /cnt_box -->
                    
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
                        <?php $this->widget('MenuManager'); ?>
                        <?php $this->widget('AffairsManage'); ?>
                        <?php $this->widget('SystemManage'); ?>
<?php $this->widget('PostedByContentManage'); ?>
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
        $("#Unit_cancel_random").attr("disabled","disabled");
        no = 1;
        function getUrl(no) {
            return "<?php echo Yii::app()->baseUrl; ?>/common/deletecookie/?no=" + no;
        }
        $("body").attr('id', 'admin');
        $(window).on('beforeunload', function() {
            setCookie("unit_edit_from", "confirm");
            
        });
		
		
        $('button#submit').click(function() {
            
            jQuery("input#edit").val('1');
            jQuery("form#unit_form").submit();
        });
        $('button#back').click(function() {
            no = 2;
            setCookie("unit_edit_from", "confirm");

             window.location="<?php echo Yii::app()->baseUrl;?>/adminbase/edit/?base_id=<?php echo $_GET['base_id']?>&id=<?php echo $model->id;?>";
        });
        $('a').click(function() {
            img=$(this).find('img');
           
            if(img.length==1){
                no=2;
            }
            else{ 
                no=1;

            }
            if ($(this).attr('id') == undefined) {
                return;
            }
            window.location = "<?php echo Yii::app()->baseUrl; ?>/adminbase/download/?file_name=" + $(this).attr('id');
        });
    });
</script>
<?php
function echoEmpty($has_img = FALSE) {
    if ($has_img === true) {
        echo '<img alt="" src="' . Yii::app()->baseUrl . '/css/common/img/img_photo01.jpg">';
    } else {
        echo '';
    }
}
?>