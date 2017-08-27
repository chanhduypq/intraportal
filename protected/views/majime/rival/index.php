<link href="<?php echo $this->assetsBase; ?>/css/majime/css/secondary.css" rel="stylesheet" type="text/css"/>
<script language="javascript">
rival = getCookie("rival_regist_from");
if(rival !="" || rival ==null)
{ 
	deleteCookies("rival_regist_from", { path: '/' });
	deleteCookies("rival_regist_title", { path: '/' });
	deleteCookies("rival_regist_content", { path: '/' });
	deleteCookies("rival_regist_attachment1_checkbox_for_deleting", { path: '/' });
	deleteCookies("rival_regist_attachment2_checkbox_for_deleting", { path: '/' });
	deleteCookies("rival_regist_attachment3_checkbox_for_deleting", { path: '/' });
}
jQuery(function($)
{	
	$("body").attr('id','majime');     
});
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap majime secondary rival bbs">
    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>競合情報</h2>
					<a href="<?php echo Yii::app()->baseUrl;?>/majime/index" class="btn btn-important">
					<i class="icon-home icon-white"></i> マジメのTopへ戻る</a>
                    <?php if(FunctionCommon::isPostFunction("rival")==true):?>
					   <a href="<?php echo Yii::app()->baseUrl;?>/majimerival/regist" class="btn btn-edit"><i class="icon-pencil icon-white"></i> 登録</a>
                     <?php endif; ?>
				</div>
                <div class="box">
                
                	<table width="724" border="0" class="table topics font14">
                    
                            <thead>
                			<tr>
                				<th>日付</th>
                				<th>タイトル</th>
                				<th>回答数</th>
                			</tr>
                		</thead>
                	<?php if($model != null): ?>
					<?php foreach($model as $rival): ?>
						<tr>
							 <td class="td-date alnC txtRed">
								<?php echo FunctionCommon::formatDate($rival->created_date); ?>
							 </td>
							<td class="td-text">
								<p class="text">
									<?php echo CHtml::link(htmlspecialchars($rival->title),array('majimerival/detail','id'=>$rival->id)); ?>
								</p>
							</td>
                                                        <td class="td-posts">
                                            <?php $i = 0; 
												 foreach ($rival_comments as $comment) 
												 {
													 if($rival['id']==$comment['rival_id'])
													 { 
														$i = $i+1;
													 } 
												 }
												 echo $i;
											?>
                                            </td>
						</tr>
					<?php endforeach; ?>
				    <?php endif; ?>
                    </table>
                	
                    <div class="pagination">
                        <?php $this->widget('ext.Pagination.Base', array('CPaginationObject' => $pages)); ?>
                    </div>
                
                </div><!-- /box -->
            </div><!-- /mainBox -->
            
        </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div><!-- /wrap -->