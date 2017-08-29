
<script type="text/javascript">
	celebrate_rpt_regist = getCookie("celebrate_rpt_regist_form");
	if(celebrate_rpt_regist !="" && celebrate_rpt_regist !=null && celebrate_rpt_regist !="null")
	{ 
		deleteCookies("celebrate_rpt_regist_form" , { path: '/' });
		deleteCookies("celebrate_rpt_reg_cat" , { path: '/' });
		deleteCookies("celebrate_rpt_reg_base" , { path: '/' });
		deleteCookies("celebrate_rpt_reg_employee_name" , { path: '/' });
	}
	//celebrate_rpt
	celebrate_rpt_edit = getCookie("celebrate_rpt_edit_form");
	if(celebrate_rpt_edit !="" && celebrate_rpt_edit !=null && celebrate_rpt_edit !="null")
	{
		deleteCookies("celebrate_rpt_edit_form" , { path: '/' });
		deleteCookies("celebrate_rpt_edit_cat" , { path: '/' });
		deleteCookies("celebrate_rpt_edit_base" , { path: '/' });
		deleteCookies("celebrate_rpt_edit_employee_name" , { path: '/' });
	}

    jQuery(function($)
	{
        $("body").attr('id', 'admin');
    });
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap admin secondary celebrate_rpt">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>お祝い報告</h2>
                                        <?php 
                                        if(FunctionCommon::isAdmin()==true){
                                        ?>
					<a href="<?php echo Yii::app()->baseUrl;?>/admincelebrate_rpt/regist" class="btn btn-important">
						<i class="icon-pencil icon-white"></i> 登録
					</a>
					<a onclick="if(confirm('すべての登録を削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/admincelebrate_rpt/deleteall';" href="#" class="btn btn-work">
						<i class="icon-trash icon-white"></i> すべて破棄
					</a>
                                        <a href="<?php echo Yii::app()->baseUrl.'/admincelebrate_rpt/categories/';?>" class="btn btn-important"><i class="icon-pencil icon-white"></i> カテゴリー管理</a>
                                        <?php 
                                        }
                                        ?>
				</div>
				
                <div class="box">
                
                <!--p class="descriptionTxt"></p-->
                
                <table width="724" border="0" class="table list font14">
                	<thead>
	                	<tr>
	                		<th class="td-category">カテゴリー</th>
	                		<th class="td-name">名前</th>
	                		<th class="td-edit">編集</th>
						</tr>
					</thead>
					<tbody>
					<?php if(!is_null($model)): ?>
						<?php foreach($model as $celebrate): ?>	
						<tr>
	                        <td class="td-category">
								<?php $criteria = new CDbCriteria();
									  $criteria->condition = "id=$celebrate->category_id";
									  $category = Category::model()->find($criteria);?>
								<?php echo htmlspecialchars($category->category_name);?>
							</td>
	                        <td class="td-name">
                        		<p class="base_name">
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
								->where('unit.active_flag=1 and unit.id="'.$celebrate->unit_id.'"')
								->order('unit.created_date desc')
								->queryRow();
								
								 echo htmlspecialchars($unit['company_name'])."&nbsp;".htmlspecialchars($unit['branch_name'])."&nbsp;".htmlspecialchars($unit['unit_name']);
								 ?>
									<?php 
									  /*$criteria = new CDbCriteria();
									  $criteria->condition = "id=$celebrate->unit_id";
									  $base = Base::model()->find($criteria);
									  if(!is_null($base))
									  {
										 echo htmlspecialchars($base->branch_name);
									  }*/
									?>
								</p>
                        		<p class="name">
									<?php echo htmlspecialchars($celebrate->employee_name);?>
								</p>
	                        </td>
	                        <td class="td-edit">
								<a href="<?php echo Yii::app()->request->baseUrl; ?>/admincelebrate_rpt/edit/?id=<?php echo $celebrate->id; ?>" class="btn btn-work">修正</a>
								<a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/admincelebrate_rpt/delete/?id=<?php echo $celebrate->id; ?>';" href="#" class="btn btn-correct">削除</a>
							</td>
	                    </tr>
						<?php endforeach; ?>	
					<?php endif; ?>	
					</tbody>
                </table>
				<?php if($item_count>$page_size):?>
					<div class="pagination">
					<?php
						$this->widget('CLinkPager', array(
							'currentPage' => $pages->getCurrentPage(),
							'itemCount' => $item_count,
							'pageSize' => $page_size,
							'maxButtonCount' => 5,
							'nextPageLabel' => 'Next',
							'prevPageLabel' => 'Prev',
							'lastPageLabel' => 'Last',
							'firstPageLabel' => 'First',
							'header' => '',
							'htmlOptions' => array('class' => 'yiiPager'),
						));?>
					</div>
				<?php endif;?>	
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
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    <div class="footer">
		<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
	</div>

</div><!-- /wrap -->


