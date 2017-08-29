
<script language="javascript">
report = getCookie("report_reg_title");
if(report !="" || report ==null)
{
	deleteCookies("report_regist_form", { path: '/' });
	deleteCookies("report_reg_icon", { path: '/' });
	deleteCookies("report_reg_title", { path: '/' });
	deleteCookies("report_reg_content", { path: '/' });
	deleteCookies("report_reg_attachment1_checkbox_for_deleting", { path: '/' });
	deleteCookies("report_reg_attachment2_checkbox_for_deleting", { path: '/' });
	deleteCookies("report_reg_attachment3_checkbox_for_deleting", { path: '/' });
}
jQuery(function($)
{  
	$("body").attr('id','majime');  
});	
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap majime secondary report bbs">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>リアルタイム社内報告</h2>
						<a href="<?php echo Yii::app()->baseUrl;?>/majime/index" class="btn btn-important">
							<i class="icon-home icon-white"></i> マジメのTopへ戻る
						</a>
						<?php if(FunctionCommon::isPostFunction("report")==true):?>
							<a href="<?php echo Yii::app()->baseUrl;?>/majimereport/regist" class="btn btn-edit">
								<i class="icon-pencil icon-white"></i> 登録
							</a>
						<?php endif; ?>
				</div>
                <div class="box">
               	<table width="724" border="0" class="table topics font14">
                    <thead>
                			<tr>
                				<th></th>
                				<th>日付</th>
                				<th>タイトル</th>
                                                <th>回答数</th>
                			</tr>
                		</thead>
					<?php if($model != null): ?>
						<?php foreach($model as $report): ?>
                            <tr>
							<?php switch($report->icon){
								    case 1:
									   echo '<td>';
									   echo '<span class="ico help">HELP</span>';
									   echo '</td>';
									   break;
									case 2:
									   echo '<td>';
									   echo '<span class="ico eigyou">営業</span>';
									   echo '</td>';
									   break;
									case 3:
									   echo '<td>';
									   echo '<span class="ico uwasa">うわさ</span>';
									   echo '</td>';
									   break;
									 case 4:
									   echo '<td>';
									   echo '<span class="ico seizou">製造</span>';
									   echo '</td>';
									   break;
									 case 5:
									   echo '<td>';
									   echo '<span class="ico gyousei">行政</span>';
									   echo '</td>';
									   break;
									 case 6:
									   echo '<td>';
									   echo '<span class="ico hall">ホール</span>';
									   echo '</td>';
									   break;
									 case 7:
									   echo '<td>';
									   echo '<span class="ico kaihatsu">開発</span>';
									   echo '</td>';
									   break;
									 case 8:
									   echo '<td>';
									   echo '<span class="ico other">他</span>';
									   echo '</td>';
									   break;
							} ?>
							<td class="td-date alnC txtRed">
								<?php echo FunctionCommon::formatDate($report->created_date); ?>
							</td>
                            <td class="td-text">
                            	<p class="text">
									<?php echo CHtml::link(htmlspecialchars($report->title),array('majimereport/detail','id'=>$report->id)); ?>
								</p>
                                <p><?php echo FunctionCommon::crop(htmlspecialchars($report->content),35); ?>
								</p>
								</p>
                               	<p class="counter">
									閲覧数：<?php echo $report->view_number; ?>
								</p>
                            </td>
                            <td class="td-posts">
                                            <?php $i = 0; 
												 foreach ($report_comments as $comment) 
												 {
													 if($report['id']==$comment['report_id'])
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