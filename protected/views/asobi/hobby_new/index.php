<link href="<?php echo $this->assetsBase; ?>/css/asobi/css/secondary.css" rel="stylesheet" type="text/css"/>
<script language="javascript">
hobby_new_regist_form = getCookie("hobby_new_reg_title");
if(hobby_new_regist_form !="" || hobby_new_regist_form ==null)
{
	deleteCookies("hobby_new_regist_form", { path: '/' });
	deleteCookies("hobby_new_reg_type", { path: '/' });
	deleteCookies("hobby_new_reg_title", { path: '/' });
	deleteCookies("hobby_new_reg_content", { path: '/' });
	deleteCookies("hobby_new_reg_attachment1_checkbox_for_deleting", { path: '/' });
	deleteCookies("hobby_new_reg_attachment2_checkbox_for_deleting", { path: '/' });
	deleteCookies("hobby_new_reg_attachment3_checkbox_for_deleting", { path: '/' });
}
jQuery(function($)
{  
	$("body").attr('id','asobi');  
});	
</script>
<div class="wrap majime secondary hobby_new">
    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox">
            	<div class="pageTtl">
					<h2>趣味・サークルの広場 What'sNew</h2>
					<a href="<?php echo Yii::app()->baseUrl;?>/asobi" class="btn btn-important">
         				<i class="icon-home icon-white"></i> あそびのTopへ戻る
					</a>
                                        <?php
                                        if(FunctionCommon::isPostFunction("hobby_new")==true){?>
            		<a href="<?php echo Yii::app()->baseUrl;?>/asobihobby_new/regist" class="btn btn-edit">
						<i class="icon-pencil icon-white"></i> 登録
					</a>
                                        <?php
                                        }
                                        ?>
				</div>
                <div class="box">
          
                	<table width="724" border="0" class="table list font14">
                		<thead>
                			<tr>
                				<th class="td-date">日付</th>
                				<th class="td-category">カテゴリー</th>
                				<th class="td-text">タイトル</th>
                			</tr>
                		</thead>
                		<tbody>
						<?php if(!is_null($model)): ?>
							<?php foreach($model as $item): ?>
							<tr>
	                            <td class="td-date alnC txtRed">
									<?php echo FunctionCommon::formatDate($item->created_date); ?>
								</td>
	                        	<td class="td-category">
								<?php if(!is_null($item->category_id) &&!empty($item->category_id)): ?>	  	
									<?php $categories = Yii::app()->db->createCommand()
										  ->select('*')
										  ->from('category')
										  ->where('id=:id', array(':id'=>$item->category_id))
										  ->queryRow(); ?>
									<?php if(!is_null($categories) && !empty($categories['background_color']) &&!empty($categories['text_color'])): ?>	  
										<span class="label" style="background-color:<?php echo !empty($categories['background_color']) ? $categories['background_color'] :'' ?>; color:<?php echo !empty($categories['text_color']) ? $categories['text_color'] :''?>;">
											<?php echo htmlspecialchars($categories['category_name']); ?>
										</span>
									<?php endif; ?>
								<?php endif; ?>	
								</td>
	                            <td class="td-text">
		                            <p class="text">
										<?php echo CHtml::link(htmlspecialchars($item->title),array('asobihobby_new/detail','id'=>$item->id)); ?>
									</p>
	                            </td>
	                        </tr>
							<?php endforeach; ?>
						<?php endif; ?>
                        </tbody>
                    </table>
                	<?php $this->widget('ext.Pagination.Base', array('CPaginationObject' => $pages)); ?>
				</div>
				<!-- /box -->
            </div>
			<!-- /mainBox -->
        </div>
		<!-- /contents -->
        <p id="page-top">
			<a href="#wrap">PAGE TOP</a>
		</p>
    </div>
	<!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div>
<!-- /wrap -->