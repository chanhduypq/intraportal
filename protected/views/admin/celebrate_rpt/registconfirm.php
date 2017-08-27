<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<div class="wrap admin secondary celebrate_rpt">
    <div class="container">
        <div class="contents regist_confirm">
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>お祝い報告 - 登録 確認</h2>
				</div>
                <div class="box">
				<?php $form = $this->beginWidget('CActiveForm', array(
					  'id' => 'celebrate_rpt_registconfirm',    
					  'htmlOptions' => array('enctype' => 'multipart/form-data'),));?>
				<input type="hidden" name="regist" id="regist" value="1"/>
				<?php echo $form->hiddenField($model, 'id'); ?>  
				<?php echo $form->hiddenField($model, 'type', array('value' => '2')); ?>  	
				<?php echo $form->hiddenField($model, 'category_id'); ?>  
				<?php echo $form->hiddenField($model, 'unit_id'); ?>  
				<?php echo $form->hiddenField($model, 'employee_name'); ?>  
                    <div class="cnt-box">
                    <div class="form-horizontal">
	                    <div class="control-group">
	                        <label class="control-label" for="title">カテゴリー&nbsp;</label>
	                        <div class="controls">
                        		<p>
								<?php $criteria = new CDbCriteria();
									  $criteria->condition = "id=$model->category_id";
									  $category = Category::model()->find($criteria);?>
								<?php echo htmlspecialchars($category->category_name);?>
								</p>
	                        </div>
	                    </div>
	                    
	                    <div class="control-group">
	                        <label class="control-label" for="title">部署名&nbsp;</label>
	                        <div class="controls">
								<p>
								<?php 
								$unit = Yii::app()->db->createCommand()
								->select(array(
									'unit.id',
									'unit.unit_name',
									'unit.branch_id',
									'branch.branch_name',
									'base.company_name'
									
									//'user.base_list'
										)
								)
								->from('unit')
								->join('branch', 'branch.id=unit.branch_id')
								->join('base', 'base.id=branch.base_id')
								->where('unit.active_flag=1 and unit.id="'.$model->unit_id.'"')
								
								->queryRow();
								 echo htmlspecialchars($unit['company_name'])."&nbsp;".htmlspecialchars($unit['branch_name'])."&nbsp;".htmlspecialchars($unit['unit_name']);
								 ?>
								</p>
	                        </div>
	                    </div>
	                    
	                    <div class="control-group">
	                        <label class="control-label" for="content">お名前&nbsp;</label>
	                        <div class="controls">
	                        	<p>
									<?php echo htmlspecialchars($model->employee_name);?>
								</p>
	                        </div>
	                    </div>
                    </div>
                    </div><!-- /cnt-box -->	
                    <?php $this->endWidget(); ?> 
	                <div class="form-last-btn">
	                	<div class="btn170">
		                    <button type="submit" class="btn" id="back">
								<i class="icon-chevron-left"></i> もどる
							</button>
		                    <button type="submit" class="btn btn-important" id="submit">
								<i class="icon-chevron-right icon-white"></i> 登録
							</button>
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
		no=1;
		function getUrl(no)
		{
            return "<?php echo Yii::app()->baseUrl;?>/common/deletecookie/?no="+no;
        }
		
		$(window).on('beforeunload', function()
		{
			setCookie("celebrate_rpt_regist_form","confirm");            
		});

		setCookie("celebrate_rpt_reg_cat",$("#Celebrate_category_id").val());
		setCookie("celebrate_rpt_reg_base",$("#Celebrate_unit_id").val());
		setCookie("celebrate_rpt_reg_employee_name",$("#Celebrate_employee_name").val());

		
		$('button#submit').click(function()
		{  
            
            deleteCookies("celebrate_rpt_regist_form");
            jQuery("input#regist").val('1');            
            jQuery("form#celebrate_rpt_registconfirm").submit();
        });
		
		$('button#back').click(function()
		{  
            setCookie("celebrate_rpt_regist_form","confirm");   
            window.location="<?php echo Yii::app()->baseUrl;?>/admincelebrate_rpt/regist";
        });
	});

</script>
