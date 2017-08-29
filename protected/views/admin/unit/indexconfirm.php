
<div class="wrap admin secondary unit">

    <div class="container">
        <div class="contents detail">
        	
            <div class="mainBox">
            	<div class="pageTtl"><h2>部署紹介 - 編集</h2></div>
                <div class="box">
                
                <?php
				$units = Yii::app()->db->createCommand()
				->select(array(
					'unit.id',
					'unit.unit_name',
					'unit.branch_id',
					'branch.branch_name',
					'base.company_name'
						)
				)
				->from('unit')
				->join('branch', 'branch.id=unit.branch_id')
				->join('base', 'base.id=branch.base_id')
				->where("unit.id='".$model->id."' and unit.active_flag=1 and branch.active_flag=1")
				->queryRow();
				?>
                <h3><?php echo $units['company_name']."&#12288;".$units['branch_name']."&#12288;".$units['unit_name']?></h3>   
                <?php                
                                    $form = $this->beginWidget('CActiveForm', array());
                                    

                                    echo $form->hiddenField($model, 'id'); 
                                    echo $form->hiddenField($model, 'catchphrase'); 
                                    echo $form->hiddenField($model, 'introduction'); 
									echo $form->hiddenField($model, 'branch_id',array('value'=>$_POST['Unitedit']['branch_id'])); 
                                    echo $form->hiddenField($model, 'office_id',array('value'=>$_POST['Unitedit']['office_id']));
									echo $form->hiddenField($model, 'display_order',array('value'=>$_POST['Unitedit']['display_order']));
									echo $form->hiddenField($model, 'unit_name',array('value'=>$_POST['Unitedit']['unit_name']));
								
									echo $form->hiddenField($model, 'mailaddr',array('value'=>$_POST['Unitedit']['mailaddr']));
									echo $form->hiddenField($model, 'attachment1',array('value'=>$_POST['Unitedit']['attachment1']));
									echo $form->hiddenField($model, 'attachment2',array('value'=>$_POST['Unitedit']['attachment2']));
									echo $form->hiddenField($model, 'attachment1',array('value'=>$_POST['Unitedit']['attachment1']));
									echo $form->hiddenField($model, 'attachment3',array('value'=>$_POST['Unitedit']['attachment3']));
									echo $form->hiddenField($model, 'created_date',array('value'=>$_POST['Unitedit']['created_date']));
                                    ?> 
                                   
                    <div class="cnt-box">
                    <p class="descriptionTxt">部署の紹介タイトル、紹介文を修正します。</p>
                
                        <div class="baseDetailBox">
                            <div class="textBox clearfix">
                                <div class="field introduceTtl">
                                    <div class="title">紹介タイトル&nbsp;</div>
                                    <div class="data">
                                        <p><?php echo htmlspecialchars($model->catchphrase);?></p>
                                    </div>
                                </div>
                                
                                <div class="field introduceTxt">
                                    <div class="title">紹介文&nbsp;</div>
                                    <div class="data"><?php echo nl2br(FunctionCommon::url_henkan($model->introduction));?></div>
                                </div>
                            </div><!-- /taxtBox -->
                        </div><!-- /baseDetailBox -->
                    </div><!-- /cnt_box -->
                    <input type="hidden" name="edit" id="edit"/>
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
<script type="text/javascript">    
    
  
    jQuery(function($) {  
        $("body").attr('id','admin'); 
  

        
        
        jQuery('form').attr("action","<?php echo Yii::app()->baseUrl;?>/adminunit/indexconfirm/");
        
        $(window).on('beforeunload', function(){
            setCookie("unitedit_from","confirm");        
        }); 
        
        $('button#submit').click(function(){             
            jQuery("input#edit").val('1');            
            jQuery("form").eq(0).submit();
        });
        $('button#back').click(function(){ 
            setCookie("unitedit_from","confirm");         
            window.location="<?php echo Yii::app()->baseUrl;?>/adminunit/index/";
        });
        
        
        
        
    });
    
                                        



</script>
