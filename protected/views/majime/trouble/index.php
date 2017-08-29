
<script type="text/javascript">

trouble = getCookie("trouble_regist_from");
if(trouble !="" || trouble ==null)
{ 
    deleteCookies("trouble_regist_from", { path: '/' });
	deleteCookies("trouble_regist_title", { path: '/' });
	deleteCookies("trouble_regist_content", { path: '/' });
	deleteCookies("trouble_regist_attachment1_checkbox_for_deleting", { path: '/' });
	deleteCookies("trouble_regist_attachment2_checkbox_for_deleting", { path: '/' });
	deleteCookies("trouble_regist_attachment3_checkbox_for_deleting", { path: '/' });
}
    jQuery(function($) {
			$("body").attr('id','majime');      
    });
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap majime secondary trouble">
    <div class="container">
        <div class="contents index">
            <div class="mainBox detail">
                <div class="pageTtl"><h2>トラブル＆不正情報</h2>
				<a class="btn btn-important" href="<?php echo Yii::app()->baseUrl?>/majime">
					<i class="icon-home icon-white"></i> マジメのTopへ戻る
				</a>
                <?php if(FunctionCommon::isPostFunction("trouble")) : ?>
					<a class="btn btn-edit" href="<?php echo Yii::app()->baseUrl?>/majimetrouble/regist">
						<i class="icon-pencil icon-white"></i> 登録</a>
				
                <?php endif;?>
                	</div>
                <div class="box">

                    <div class="cnt-box">
                        <?php echo CHtml::beginForm('', 'post', array('id' => 'index_frm')); ?>
                        <table width="724" border="0" class="table topics font14">
                            <tbody>
                                <?php
                                if ($troubles != null && is_array($troubles) && count($troubles) > 0) {
                                    foreach ($troubles as $trouble) {
                                        ?>        

                                        <tr>
                                            <td class="td-date alnC txtRed">
												<?php echo FunctionCommon::formatDate($trouble['created_date']); ?>
											</td>
                                            <td class="td-text">
                                                <p class="text">                                        
                                                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/majimetrouble/detail/?id=<?php echo $trouble['id']; ?>">
														<?php echo htmlspecialchars($trouble['title']);?>
													</a>
                                                </p>
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
        </div>
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>
    </div>
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>
</div>

