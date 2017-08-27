<link href="<?php echo $this->assetsBase; ?>/css/majime/css/secondary.css" rel="stylesheet" type="text/css"/>
<script language="javascript">
newitem = getCookie("newitem_reg_title");
if(newitem !="" || newitem ==null)
{
	deleteCookies("newitem_regist_form", { path: '/' });
	deleteCookies("newitem_reg_type", { path: '/' });
	deleteCookies("newitem_reg_title", { path: '/' });
	deleteCookies("newitem_reg_content", { path: '/' });
	deleteCookies("newitem_attachment1_checkbox_for_deleting", { path: '/' });
	deleteCookies("newitem_attachment2_checkbox_for_deleting", { path: '/' });
	deleteCookies("newitem_attachment3_checkbox_for_deleting", { path: '/' });
}
jQuery(function($)
{  
	$("body").attr('id','majime');  
});	
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap majime secondary newitems">
    <div class="container">
        <div class="contents index">
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>新商品情報</h2>
					<a href="<?php echo Yii::app()->baseUrl;?>/majime/index" class="btn btn-important">
					<i class="icon-home icon-white"></i> マジメのTopへ戻る</a>
					<?php if(FunctionCommon::isPostFunction("newitem")==true):?>
						<a href="<?php echo Yii::app()->baseUrl;?>/majimenewitem/regist" class="btn btn-edit">
							<i class="icon-pencil icon-white"></i> 登録
						</a>
					<?php endif; ?>
				</div>
                <div class="box">
                
                <!--p class="descriptionTxt"></p-->
                
                	<table width="724" border="0" class="table topics font14">
						<?php if($model != null): ?>
							<?php foreach($model as $newitem): ?>
								<tr>
									 <td class="td-date alnC txtRed">
										<?php echo FunctionCommon::formatDate($newitem->created_date); ?>
									 </td>
									<?php if($newitem->type == "1"): ?>
										<td class="td-text">
											<p class="text">
												<?php echo CHtml::link(htmlspecialchars($newitem->title),array('majimenewitem/detail','id'=>$newitem->id)); ?>
											</p>
										</td>
									<?php else : ?>
										<td class="td-text">
											<p class="text">
												<i class="icon icon-share-alt"></i>
												<?php echo CHtml::link(htmlspecialchars($newitem->title),$newitem->content, array('target'=>'_blank')); ?>		
											</p>
										</td>
									<?php endif; ?>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
                    </table>
                	<?php $this->widget('ext.Pagination.Base', array('CPaginationObject' => $pages)); ?>
                </div><!-- /box -->
            </div><!-- /mainBox -->
            
        </div><!-- /contents -->
        <p id="page-top">
			<a href="#wrap">PAGE TOP</a>
		</p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div><!-- /wrap -->