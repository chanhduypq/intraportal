<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<script language="javascript">

 report = getCookie("report_edit_form");
if(report !="" || report ==null)
{
	deleteCookies("report_edit_form", { path: '/' });
	deleteCookies("report_edit_icon", { path: '/' });
	deleteCookies("report_edit_title", { path: '/' });
	deleteCookies("report_edit_content", { path: '/' });
	deleteCookies("report_edit_attachment1_checkbox_for_deleting", { path: '/' });
	deleteCookies("report_edit_attachment2_checkbox_for_deleting", { path: '/' });
	deleteCookies("report_edit_attachment3_checkbox_for_deleting", { path: '/' });
}
jQuery(function($) 
{        
	$("body").attr('id','admin');  
}) 

</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap admin secondary report">
    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>リアルタイム社内報告</h2>
				</div>
                <div class="box">
                
                <!--p class="descriptionTxt"></p-->
                
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
					<?php if(!is_null($model)): ?>
						<?php foreach($model as $report): ?>
						<tr>
							<td class="td-date alnC txtRed postsDate">
								<?php echo FunctionCommon::formatDate($report->created_date); ?>
							</td>
							<td class="td-date alnC txtRed updateDate">
								<?php echo FunctionCommon::formatDate($report->last_updated_date); ?>
							</td>
							<td class="td-text">
								<p class="text">
                                     <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminreport/detail/?id=<?php echo $report->id; ?>" >
										<?php echo htmlspecialchars($report->title);?>
									</a>
								</p>
							</td>
							<td class="td-edit">
								<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminreport/edit/?id=<?php echo $report->id; ?>" class="btn btn-work">修正</a>
								<a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/adminreport/delete/?id=<?php echo $report->id; ?>';" href="#" class="btn btn-correct">削除</a>
							</td>
						</tr>
						<?php endforeach; ?>
					<?php endif; ?>		
                    </tbody>
                </table>
				<?php $this->widget('ext.Pagination.Base', array('CPaginationObject' => $pages)); ?> 
                
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
    