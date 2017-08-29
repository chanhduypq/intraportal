
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
soumu_news= getCookie("soumu_news_regist_from");
if(soumu_news !="" || soumu_news ==null)
{ 
    deleteCookies("soumu_news_regist_from", { path: '/' });
    deleteCookies("soumu_news_regist_title", { path: '/' });
    deleteCookies("soumu_news_regist_content", { path: '/' });    
    deleteCookies("soumu_news_regist_label", { path: '/' });
    deleteCookies("soumu_news_regist_attachment1_checkbox_for_deleting", { path: '/' });
    deleteCookies("soumu_news_regist_attachment2_checkbox_for_deleting", { path: '/' });
    deleteCookies("soumu_news_regist_attachment3_checkbox_for_deleting", { path: '/' });
    
}
soumu_news1= getCookie("soumu_news_edit_from");
if(soumu_news1 !="" || soumu_news1 ==null)
{ 
    deleteCookies("soumu_news_edit_from", { path: '/' });
    deleteCookies("soumu_news_edit_title", { path: '/' });
    deleteCookies("soumu_news_edit_content", { path: '/' });
	deleteCookies("soumu_news_edit_label", { path: '/' });
    deleteCookies("soumu_news_edit_attachment1_checkbox_for_deleting", { path: '/' });
	deleteCookies("soumu_news_edit_attachment2_checkbox_for_deleting", { path: '/' });
    deleteCookies("soumu_news_edit_attachment3_checkbox_for_deleting", { path: '/' }); 
}
jQuery(function($) 
{
   
	$("body").attr('id','admin');        
});
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap admin secondary soumu_news">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>総務からのお知らせ</h2>
            		<a class="btn btn-important" href="<?php echo Yii::app()->request->baseUrl; ?>/adminsoumu_news/regist/">
						<i class="icon-pencil icon-white"></i> 登録
					</a>
            	</div>
                <div class="box">
                
                <!--p class="descriptionTxt"></p-->
                <?php echo CHtml::beginForm('', 'post', array('id' => 'index_frm')); ?>
                <table width="724" border="0" class="table list font14">
                	<thead>
	                	<tr>
	                		<th>投稿年月日</th>
	                		<th>更新年月日</th>
	                		<th>タイトル</th>
	                		<th>編集</th>
	                	</tr>
                	</thead>
                	<tbody>
                		<?php if(is_array($model) && count($model)>0) { foreach ($model as $model) {?>
	                    <tr>
	                        <td class="td-date alnC txtRed postsDate">
								<?php echo FunctionCommon::formatDate($model->created_date); ?>
							</td>
	                        <td class="td-date alnC txtRed updateDate">
								<?php echo FunctionCommon::formatDate($model->last_updated_date); ?>
							</td>
	                        <td class="td-text">
								<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminsoumu_news/detail/?id=<?php echo $model->id; ?>">
									<?php echo htmlspecialchars($model->title);?>
								</a>
							</td>
	                        <td class="td-edit">
							<a class="btn btn-work" href="<?php echo Yii::app()->request->baseUrl; ?>/adminsoumu_news/edit/?id=<?php echo $model->id; ?>">修正</a>
							<a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/adminsoumu_news/delete/?id=<?php echo $model->id; ?>';" style="cursor:pointer;" class="btn btn-correct">削除</a>
							</td>
	                    </tr>
							<?php }?>
						<?php } ?>
					
                    </tbody>
                </table>
				 <?php $this->widget('ext.Pagination.Base', array('CPaginationObject' => $pages)); ?>      
                 <?php echo CHtml::endForm(); ?>
                    
                
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