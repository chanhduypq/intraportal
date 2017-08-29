
<div class="wrap admin secondary celebrate_rpt">

    <div class="container">
        <div class="contents edit">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>お祝い報告 - 修正</h2>
                                        <?php 
                                        if(FunctionCommon::isAdmin()==true){
                                        ?>
                <span>
					<?php if(!empty(Yii::app()->request->cookies['page'])): ?>	
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/admincelebrate_rpt/index?page=<?php echo Yii::app()->request->cookies['page']?>" class="btn btn-important">
							<i class="icon-chevron-left icon-white"></i> 一覧に戻る
						</a>
					<?php else : ?>
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/admincelebrate_rpt" class="btn btn-important">
							<i class="icon-chevron-left icon-white"></i> 一覧に戻る
						</a>
					<?php endif; ?>
				</span>
                                        <?php 
                                        }
                                        ?>
                </div>
                <div class="box">
				 <?php $form = $this->beginWidget('CActiveForm', array(
					'id' => 'celebrate_edit',                     
					'htmlOptions' => array('enctype' => 'multipart/form-data',
										    'class'=>'form-horizontal',),));?>	
				<?php echo $form->hiddenField($model, 'id'); ?>  							
                <div class="cnt-box">
                    <div class="control-group">
                        <label class="control-label" for="title">カテゴリー&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	<?php echo $form->dropDownList($model,'category_id', CHtml::listData(Category::model()->findAll(array("condition"=>"type =8",'order' => 'category_name ASC')), 'id', 'category_name'), array('empty'=>'選んで下さい'));?>		
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label" for="title">部署名&nbsp;</label>
                        <div class="controls">
							<?php // echo $form->dropDownList($model,'base_id', CHtml::listData(Base::model()->findAll(array('order' => 'branch_name ASC')), 'id', 'branch_name'), array('empty'=>'選んで下さい'));?>	
                            <?php
                            $array_unit = array();
                            foreach ($unit as $unit_name){
                                   $array_unit[$unit_name['id']] = $unit_name['company_name'].' '.$unit_name['branch_name'].' '.$unit_name['unit_name'];       
                            }
                            echo $form->dropDownList($model,'unit_id',$array_unit,  array('prompt'=>'選んで下さい')); 			
                            ?> 
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label" for="content">お名前&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
							<?php echo $form->textField($model, 'employee_name', array('placeholder' => 'お名前を入力してください。', 'class' => 'input-xlarge')); ?>
                        </div>
                    </div>
                  <?php $this->endWidget(); ?>                       
                </div><!-- /cnt-box -->
                <div class="form-last-btn">
                	<p class="btn80">
	                    <button type="submit" class="btn btn-important">
							<i class="icon-chevron-right icon-white">　</i> 確認
						</button>
                    </p>
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
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
</div>

</div><!-- /wrap -->
<script type="text/javascript">   

	//Method using check id bounty 
	function checkId(id)
	{
		$.ajax({   
			type: "POST", 
			async:true,
			url: "<?php echo Yii::app()->baseUrl;?>/admincelebrate_rpt/checkId/",    
			data:{id:id},
			success: function(msg)
			{	        
				if(msg=='0')
				{ 
					window.location.href="<?php echo Yii::app()->baseUrl;?>/admincelebrate_rpt/index";
				}
			}
		});
	}

	jQuery(function($)
	{            
	    $("body").attr('id','admin');
 
	    $("#celebrate_edit").attr('action', '<?php echo Yii::app()->baseUrl; ?>/admincelebrate_rpt/editconfirm/');  
		 
		cat=getCookie("celebrate_rpt_edit_cat");
		if(cat!=null && cat !="null")
		{
			$("#Celebrate_category_id").val(cat);
		}
		
		base=getCookie("celebrate_rpt_edit_base");
		if(base!=null && base!="null")
		{
			$("#Celebrate_unit_id").val(base);
		}
		
		employee_name=getCookie("celebrate_rpt_edit_employee_name");
		if(employee_name!=null && employee_name!="null")
		{
			$("#Celebrate_employee_name").val(employee_name);
		}


	   $('button[type="submit"]').click(function()
	   {    
		   deleteCookies("celebrate_rpt_edit_form"); 		   
		   var id = $('#Celebrate_id').val();	
		   checkId(id);
			$.ajax
			({    
					type: "POST", 
					async:true,
					url: "<?php echo Yii::app()->baseUrl;?>/admincelebrate_rpt/edit/?id=<?php echo $model->id;?>",    
					data: jQuery('#celebrate_edit').serialize(),
					success: function(msg)
					{	            
					    jQuery('#Celebrate_category_id').prev().remove();                                       						                                            					  	
					    jQuery('#Celebrate_employee_name').prev().remove(); 	
						if(msg!='[]')
						{
							data=$.parseJSON(msg);
							if(data.Celebrate_category_id)
							{	
								div=document.createElement('div');
								$(div).addClass('alert');
								$(div).addClass('error_message');
								$(div).html(data.Celebrate_category_id);
								$(div).insertBefore($('#Celebrate_category_id')); 
							} 
							if(data.Celebrate_employee_name)
						    {
								div=document.createElement('div');
								$(div).addClass('alert');
								$(div).addClass('error_message');
								$(div).html(data.Celebrate_employee_name);
								$(div).insertBefore($('#Celebrate_employee_name')); 
							} 	 
					}		
					else
					{
						  setCookie("celebrate_rpt_edit_cat",$("#Celebrate_category_id").val());
						  setCookie("celebrate_rpt_edit_base",$("#Celebrate_unit_id").val());
						  setCookie("celebrate_rpt_edit_employee_name",$("#Celebrate_employee_name").val());
						  jQuery('#celebrate_edit').submit();
					}
				}	  
			});
		
		});
 
    });	
       	
</script>

