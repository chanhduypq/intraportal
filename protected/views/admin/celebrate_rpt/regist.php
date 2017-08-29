
<div class="wrap admin secondary celebrate_rpt">

    <div class="container">
        <div class="contents regist">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
				<h2>お祝い報告 - 登録</h2>
                                <?php 
                                if(FunctionCommon::isAdmin()==true){
                                ?>
                <span>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admincelebrate_rpt" class="btn btn-important">
						<i class="icon-chevron-left icon-white"></i> 一覧に戻る
					</a>
				</span>
                                <?php
                                }
                                ?>
                </div>
                <div class="box">
				<?php $form = $this->beginWidget('CActiveForm', array(
					'id' => 'celebrate_rpt_regist', 
					'focus'=>array($model,'title'),	
					'htmlOptions' => array(
					'enctype' => 'multipart/form-data',
					'class'=>'form-horizontal',
					'onsubmit'=>'return false;',),));?>	
				<?php echo $form->hiddenField($model, 'type', array('value' => '2')); ?>  	
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
							<?php
                            $array_unit = array();
                            foreach ($unit as $unit_name){
                                   $array_unit[$unit_name['id']] = $unit_name['company_name'].' '.$unit_name['branch_name'].' '.$unit_name['unit_name'];
                                   
                            }
                            echo $form->dropDownList($model,'unit_id',$array_unit,  array('prompt'=>'選んで下さい')); 			
                            ?> 
							<?php // echo $form->dropDownList($model,'base_id', CHtml::listData(Base::model()->findAll(array('order' => 'branch_name ASC')), 'id', 'branch_name'), array('empty'=>'選んで下さい'));?>		
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label" for="content">お名前&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
							<?php echo $form->textField($model, 'employee_name', array('placeholder' => 'お名前を入力してください。', 'class' => 'input-xlarge')); ?>
                        </div>
                    </div>
                                        
                </div><!-- /cnt-box -->
                
                <div class="form-last-btn">
                	<p class="btn80">
	                    <button type="submit" class="btn btn-important">
							<i class="icon-chevron-right icon-white">　</i> 確認
						</button>
                    </p>
                </div>
                
                 <?php $this->endWidget(); ?>
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
	jQuery(function($)
	{  
		$("body").attr('id','admin');
		
		$("#celebrate_rpt_regist").attr('action','<?php echo Yii::app()->baseUrl;?>/admincelebrate_rpt/registconfirm/');          
			
		cat=getCookie("celebrate_rpt_reg_cat");
		if(cat!=null && cat !="null")
		{
			$("#Celebrate_category_id").val(cat);
		}
		
		base=getCookie("celebrate_rpt_reg_base");
		if(base!=null && base!="null")
		{
			$("#Celebrate_unit_id").val(base);
		}
		
		employee_name=getCookie("celebrate_rpt_reg_employee_name");
		if(employee_name!=null && employee_name!="null")
		{
			$("#Celebrate_employee_name").val(employee_name);
		}

		$('button[type="submit"]').click(function()
	   {          
			deleteCookies("celebrate_rpt_regist_form"); 		   
			$.ajax({    
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/admincelebrate_rpt/regist/",    
				data: jQuery('#celebrate_rpt_regist').serialize(),
				
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
						  setCookie("celebrate_rpt_reg_cat",$("#Celebrate_category_id").val());
						  setCookie("celebrate_rpt_reg_base",$("#Celebrate_unit_id").val());
						  setCookie("celebrate_rpt_reg_employee_name",$("#Celebrate_employee_name").val());
						  jQuery('#celebrate_rpt_regist').attr('onsubmit','return true;');
						  jQuery('#celebrate_rpt_regist').submit();
					  }					    			    
				  }	  
			  });
	   });    
});	
</script>
