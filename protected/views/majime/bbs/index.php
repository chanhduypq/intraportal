<link href="<?php echo $this->assetsBase; ?>/css/majime/css/secondary.css" rel="stylesheet" type="text/css"/>
<script language="javascript">
bbs = getCookie("bbs_regist_from");
if(bbs !="" || bbs ==null)
{ 
	deleteCookies("bbs_regist_from", { path: '/' });
	deleteCookies("bbs_regist_title", { path: '/' });
	deleteCookies("bbs_regist_content", { path: '/' });
	deleteCookies("bbs_regist_attachment1_checkbox_for_deleting", { path: '/' });
	deleteCookies("bbs_regist_attachment2_checkbox_for_deleting", { path: '/' });
	deleteCookies("bbs_regist_attachment3_checkbox_for_deleting", { path: '/' });
}
	jQuery(function($) {        
	$("body").attr('id','majime');     
 });
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap majime secondary bbs">
    <div class="container">
        <div class="contents index">
            <div class="mainBox detail">
                <div class="pageTtl">
					<h2>ニューギン掲示板</h2>
						<a class="btn btn-important" href="<?php echo Yii::app()->baseUrl?>/majime/">
							<i class="icon-home icon-white"></i> マジメのTopへ戻る
						</a>
					<?php if(FunctionCommon::isPostFunction("bbs")==true):?>
						<a class="btn btn-edit" href="<?php echo Yii::app()->baseUrl?>/majimebbs/regist">
							<i class="icon-pencil icon-white"></i> 登録
						</a>
					<?php endif; ?>
                </div>
                <div class="box">
                        <?php echo CHtml::beginForm('', 'post', array('id' => 'index_frm')); ?>
                        <table width="724" border="0" class="table topics font14">
                        <thead>
                			<tr>
                				<th>日付</th>
                				<th>タイトル</th>
                				<th>回答数</th>
                			</tr>
                		</thead>
                            <tbody>
                                <?php
                                if ($bbss != null && is_array($bbss) && count($bbss) > 0) {
                                    foreach ($bbss as $bbs) {
                                        ?>        

                                        <tr>
                                            <td class="td-date alnC txtRed">
												<?php echo FunctionCommon::formatDate($bbs['created_date']); ?>
											</td>
                                            <td class="td-title">
												<span class="txtB">
													<a href="<?php echo Yii::app()->request->baseUrl; ?>/majimebbs/detail/?id=<?php echo $bbs['id']; ?>">
														<?php echo htmlspecialchars($bbs['title'])?>
													</a>
												</span>
											</td>
                                            <td class="td-posts">
                                            <?php $i = 0; 
												 foreach ($bbs_comments as $comment) 
												 {
													 if($bbs['id']==$comment['bbs_id'])
													 { 
														$i = $i+1;
													 } 
												 }
												 echo $i;
											?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php $this->widget('ext.Pagination.Base', array('CPaginationObject' => $pages)); ?>
                        <?php echo CHtml::endForm(); ?>
                </div>
            </div>
        </div>
        <p id="page-top">
			<a href="#wrap">PAGE TOP</a>
		</p>
    </div>
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>
</div>

