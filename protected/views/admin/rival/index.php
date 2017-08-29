
<script language="javascript">
 rival = getCookie("rival_edit_from");
if(rival !="" || rival ==null)
{ 
	deleteCookies("rival_edit_from", { path: '/' });
	deleteCookies("rival_edit_title", { path: '/' });
	deleteCookies("rival_edit_content", { path: '/' });
	deleteCookies("rival_edit_attachment1_checkbox_for_deleting", { path: '/' });
	deleteCookies("rival_edit_attachment2_checkbox_for_deleting", { path: '/' });
	deleteCookies("rival_edit_attachment3_checkbox_for_deleting", { path: '/' });
}
jQuery(function($) 
{        
	$("body").attr('id','admin');      
});
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap admin secondary rival">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>競合情報</h2></div>
                <div class="box">
                
                <!--p class="descriptionTxt"></p-->
                
                <table width="724" border="0" class="table list font14">
                	<thead>
                	<tr><th>投稿年月日</th><th>更新年月日</th><th>タイトル</th><th>編集</th></tr>
                	</thead>
            
					<?php if($model != null): ?>
						<?php foreach($model as $rival): ?>
						<tr>
							<td class="td-date txtRed postsDate">
								<?php echo FunctionCommon::formatDate($rival->created_date); ?>
							</td>
							<td class="td-date txtRed updateDate">
								<?php echo FunctionCommon::formatDate($rival->last_updated_date); ?>
							</td>
							<td class="td-text">
                                   <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminrival/detail/?id=<?php echo $rival->id; ?>" >
									<?php echo htmlspecialchars($rival->title)?>
									</a>
							</td>
							<td class="td-edit">
								<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminrival/edit/?id=<?php echo $rival->id; ?>" class="btn btn-work">修正</a>
								<a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/adminrival/delete/?id=<?php echo $rival->id; ?>';" href="#" class="btn btn-correct">削除</a>
							</td>
						</tr>
						<?php endforeach; ?>
		          	<?php endif; ?>
                </table>
				<?php $this->widget('ext.Pagination.Base', array('CPaginationObject' => $pages)); ?> 
                
                </div><!-- /box -->
            </div><!-- /mainBox -->
            
            <div class="sideBox" style="float:left;">
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