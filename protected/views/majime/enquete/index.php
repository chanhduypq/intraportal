
<script type="text/javascript">
enquete = getCookie("enquete_regist_from");
if(enquete !="" || enquete ==null)
{
	deleteCookies("enquete_regist_from", { path: '/' });  
	deleteCookies("enquete_regist_title", { path: '/' });   
	deleteCookies("enquete_regist_content", { path: '/' });
	deleteCookies("enquete_regist_deadline_year", { path: '/' });
	deleteCookies("enquete_regist_deadline_month", { path: '/' }); 
	deleteCookies("enquete_regist_deadline_day", { path: '/' });
	deleteCookies("enquete_regist_answer_type", { path: '/' });
	deleteCookies("loaddata", { path: '/' });
	deleteCookies("enquete_regist_attachment1_checkbox_for_deleting", { path: '/' });
	deleteCookies("enquete_regist_attachment2_checkbox_for_deleting", { path: '/' });
	deleteCookies("enquete_regist_attachment3_checkbox_for_deleting", { path: '/' });
}
jQuery(function($)
{
	$("body").attr('id','majime');        
});
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap majime secondary enquete">
    <div class="container">
        <div class="contents index">
            <div class="mainBox detail">
                <div class="pageTtl">
                    <h2>みんなのアンケートBOX</h2>
                    
                    <a class="btn btn-important" href="<?php echo Yii::app()->baseUrl?>/majime"><i class="icon-home icon-white"></i> マジメのTopへ戻る</a>
                    <?php
                        if(FunctionCommon::isPostFunction("enquete")==true){ 
                            echo CHtml::link('<i class="icon-pencil icon-white"></i> 登録', Yii::app()->request->baseUrl . '/majimeenquete/regist', array('class' => 'btn-edit btn',)); 
                        }
                    ?>
                </div>
                <div class="box">

                    <!--p class="descriptionTxt"></p-->
					<?php echo CHtml::beginForm('', 'post', array('id' => 'index_frm')); ?>
                    <table width="724" border="0" class="table topics font14">
                        <tbody>
                            <?php
                            $now = strtotime(date('Y/m/d'));  
							if(is_array($model)&&count($model)>0){
                            foreach ($model as $enquete) { 
                                $class = ''; 
                                $link = '/majimeenquete/detail/?id=';
                                $dealine = strtotime(date('Y/m/d', strtotime($enquete['deadline'])));
                                if ($now < $dealine) {
                                    $class = 'badge badge-info';
                                    $label = '開催中';
                                }
                                if ($now == $dealine) {
                                    $class = 'badge badge-warning';
                                    $label = '最終日';
                                }
                                if ($now > $dealine) {
                                    $class = 'badge badge-inverse';
                                    $link = '/majimeenquete/detail_result/?id=';;
                                    $label = '終了';
                                }
                                ?>
                                <tr>
                                    <td class="td-date alnC txtRed"><?php echo FunctionCommon::formatDate($enquete['created_date']); ?></td> 
                                    <td class="td-state">
                                        <span class="<?php echo $class ?>"><?php echo $label ?></span>
                                    </td>
                                    <td class="td-text">
                                         <p class="text">  
											<a href="<?php echo Yii::app()->request->baseUrl; ?><?php echo $link.$enquete['id']; ?>">
												<?php echo htmlspecialchars($enquete['title']); ?>
											</a>
										 </p>
                                    </td>
                                </tr>
								<?php } ?>
							<?php } ?>
                        </tbody>
                    </table>
					
                   <?php $this->widget('ext.Pagination.Base', array('CPaginationObject' => $pages)); ?>
				<?php echo CHtml::endForm(); ?>
                </div><!-- /box -->
            </div><!-- /mainBox -->

        </div><!-- /contents -->
        <p id="page-top" style="display: block;"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->

    <div class="footer">
        <p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div>
