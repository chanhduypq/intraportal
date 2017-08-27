<link href="<?php echo $this->assetsBase; ?>/css/majime/css/secondary.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
	claim = getCookie("claim_regist_from");
	if(claim !="" || claim ==null)
	{   
		deleteCookies("claim_regist_from", { path: '/' });
		deleteCookies("claim_regist_title", { path: '/' });
		deleteCookies("claim_regist_content", { path: '/' });
		deleteCookies("claim_regist_attachment1_checkbox_for_deleting", { path: '/' });
		deleteCookies("claim_regist_attachment2_checkbox_for_deleting", { path: '/' });
		deleteCookies("claim_regist_attachment3_checkbox_for_deleting", { path: '/' });
	}

    jQuery(function($) 
	{
        $('ul.yiiPager li.selected').removeClass('selected');
        $('ul.yiiPager li').removeClass('page');
        $('ul.yiiPager li').removeClass('previous');
        $('ul.yiiPager li').removeClass('next');
        $('ul.yiiPager li').removeClass('last');
        $('ul.yiiPager li').removeClass('first');
        $('ul.yiiPager li').removeClass('hidden');
        $('ul.yiiPager').removeClass('yiiPager');
        
        $("body").attr('id','majime');      
	});
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap majime secondary claim">
    <div class="container">
        <div class="contents index">
            <div class="mainBox detail">
                <div class="pageTtl">
					<h2>お客様クレーム</h2>
					<a class="btn btn-important" href="<?php echo Yii::app()->baseUrl?>/majime">
						<i class="icon-home icon-white"></i> マジメのTopへ戻る
					</a>
                    <?php if(FunctionCommon::isPostFunction("claim")) :?>
						<a class="btn btn-edit" href="<?php echo Yii::app()->baseUrl?>/majimeclaim/regist">
							<i class="icon-pencil icon-white"></i> 登録
						</a>
                    <?php  endif;?>
                </div>
                <div class="box">
                    
                    <div class="cnt-box">
                        <?php echo CHtml::beginForm('', 'post', array('id' => 'index_frm')); ?>
                        <table width="724" border="0" class="table topics font14">
                            <tbody>
                                <?php
                                if ($claims != null && is_array($claims) && count($claims) > 0) {
                                    foreach ($claims as $claim) {
                                        ?>        

                                        <tr>
                                            <td class="td-date alnC txtRed">
												<?php echo convertDateFromDbToView($claim['created_date']); ?>
											</td>
                                            <td class="td-text">
                                                <p class="text">                                        
                                                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/majimeclaim/detail/?id=<?php echo $claim['id']; ?>">
														<?php echo htmlspecialchars($claim['title']);?>
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
                        <div class="pagination">
                            <?php
                            $this->widget('CLinkPager', array(
                                'currentPage' => $pages->getCurrentPage(),
                                'itemCount' => $item_count,
                                'pageSize' => $page_size,
                                'maxButtonCount' => 5,
                                'nextPageLabel' => 'Next',
                                'prevPageLabel' => 'Prev',
                                'lastPageLabel' => 'Last',
                                'firstPageLabel' => 'First',
                                'header' => '',
                                'htmlOptions' => array('class' => 'yiiPager'),
                            ));
                            ?>

                        </div>
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
<?php

function convertDateFromDbToView($datetime) {
    if ($datetime == NULL || !is_string($datetime) || trim($datetime) == "") {
        return $datetime;
    }
    $date_time_array = explode(" ", $datetime);
    $date = $date_time_array[0];
    $y_m_d_array = explode("-", $date);
    return implode("/", $y_m_d_array);
}


?>
