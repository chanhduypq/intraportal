<link href="<?php echo $this->assetsBase; ?>/css/majime/css/secondary.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
to_officer = getCookie("to_officer_add_from");
if(to_officer !="" || to_officer ==null)
{
    deleteCookies("to_officer_add_from", { path: '/' });
	deleteCookies("to_officer_add_title", { path: '/' });
	deleteCookies("to_officer_add_content", { path: '/' });
	deleteCookies("to_officer_add_attachment1_checkbox_for_deleting", { path: '/' });
	deleteCookies("to_officer_add_attachment2_checkbox_for_deleting", { path: '/' });
	deleteCookies("to_officer_add_attachment3_checkbox_for_deleting", { path: '/' });
}
    jQuery(function($) {
			$("body").attr('id','majime');      
    });
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap majime secondary to_officer">
    <div class="container">
        <div class="contents index">
            <div class="mainBox detail">
                <div class="pageTtl"><h2>役員宛目安箱</h2>
				<a class="btn btn-important" href="<?php echo Yii::app()->baseUrl?>/majime">
					<i class="icon-home icon-white"></i> マジメのTopへ戻る
				</a>
                <?php if(FunctionCommon::isPostFunction("to_officer")) { ?>
					<a class="btn btn-edit" href="<?php echo Yii::app()->baseUrl?>/majimeto_officer/add">
						<i class="icon-pencil icon-white"></i> 登録</a>
					
                <?php }?>
                </div>
                <div class="box">

                    <div class="cnt-box">
                        <?php echo CHtml::beginForm('', 'post', array('id' => 'index_frm')); ?>
                        <table width="724" border="0" class="table topics font14">
                            <tbody>
                                <?php
                                if ($to_officers != null && is_array($to_officers) && count($to_officers) > 0) {
                                    foreach ($to_officers as $to_officer) {
                                        ?>        

                                        <tr>
                                            <td class="td-date alnC txtRed">
												<?php echo FunctionCommon::formatDate($to_officer['created_date']); ?>
											</td>
                                            <td class="td-text">
                                                <p class="text">                                        
                                                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/majimeto_officer/detail/?id=<?php echo $to_officer['id']; ?>">
														<?php echo htmlspecialchars($to_officer['title']);?>
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

