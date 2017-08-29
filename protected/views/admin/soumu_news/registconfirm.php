




<div class="wrap admin secondary soumu_news" id="admin">

    <div class="container">
        <div class="contents edit_confirm">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
				<h2>総務からのお知らせ - 登録 確認</h2>
				</div>
                
                <div class="box">
                <?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'soumu_news_form',    
    'htmlOptions' => array('enctype' => 'multipart/form-data','action'=>Yii::app()->baseUrl.'/adminsoumu_news/registconfirm','class'=>'form-horizontal',),
        ));
?>

<?php echo $form->hiddenField($model, 'title'); ?>   
<?php echo $form->hiddenField($model, 'content'); ?>   
<?php echo $form->hiddenField($model, 'label'); ?>   
<input type="hidden" name="regist" id="regist" value="1"/>
<input type="hidden" name="file_index"/>

                    <div class="cnt-box">
                    <div class="form-horizontal">
                        <div class="control-group">
                            <div class="control-label">タイトル:</div>
                            <div class="controls">
                                <p>
									
									<?php if($model->label=='1'){ echo '<span class="badge badge-important">重要</span>';} 
									echo htmlspecialchars($model->title);?>
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
                                $attachements->registConfirm11($model, $form,'adminsoumu_news',$this->assetsBase);
                                $this->endWidget();
                            ?>

                  </div>
                    
                    </div><!-- /cnt-box -->	
            		        <?php $this->endWidget();?> 
	                <div class="form-last-btn">
	                	<div class="btn170">
		                    <button id="back" class="btn" type="submit"><i class="icon-chevron-left"></i> もどる</button>
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
            </div>
           <!-- /sideBox -->
            
  </div><!-- /contents -->
        <p id="page-top" style="display: none;"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
</div>

</div>

<script type="text/javascript">
     jQuery(function($) {
         
        no=1;
        function getUrl(no){
            return "<?php echo Yii::app()->baseUrl;?>/common/deletecookie/?no="+no;
        }
        $("body").attr('id','admin');          
        $(window).on('beforeunload', function(){
            setCookie("soumu_news_regist_from","confirm");            
            
            $.ajax({    
                    type: "GET", 
                    async:false,
                    url: getUrl(no)


            });
        });
		<?php if($model->label=='1'){?>
		 setCookie("soumu_news_regist_label",'1');
		<?php }else{?> 
		setCookie("soumu_news_regist_label",'0');
		<?php }?>
        setCookie("soumu_news_regist_title",$("#Soumu_news_title").val());
        setCookie("soumu_news_regist_content",$("#Soumu_news_content").val());
        setCookie("soumu_news_regist_attachment1_checkbox_for_deleting",$("#Soumu_news_attachment1_checkbox_for_deleting").val());
        setCookie("soumu_news_regist_attachment2_checkbox_for_deleting",$("#Soumu_news_attachment2_checkbox_for_deleting").val());
        setCookie("soumu_news_regist_attachment3_checkbox_for_deleting",$("#Soumu_news_attachment3_checkbox_for_deleting").val());
        
        $('button#submit').click(function(){  
            no=2;
            deleteCookies("soumu_news_regist_from");
            jQuery("input#regist").val('1');            
            jQuery("form#soumu_news_form").submit();
        });
        $('button#back').click(function(){
             no=2;      
            setCookie("soumu_news_regist_from","confirm");   
            
            window.location="<?php echo Yii::app()->baseUrl;?>/adminsoumu_news/regist/";
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
            window.location="<?php echo Yii::app()->baseUrl;?>/adminsoumu_news/download/?file_name="+$(this).attr('id');
        });
       
         
    });
	
    
</script>