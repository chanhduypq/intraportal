<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
celebrate_edit = getCookie("celebrate_edit_from");
if(celebrate_edit !="" || celebrate_edit ==null)
{ 
	deleteCookies("celebrate_edit_from");
	deleteCookies("celebrate_edit_category_id");
	deleteCookies("celebrate_edit_record_year");
	deleteCookies("celebrate_edit_record_month");
	deleteCookies("celebrate_edit_record_day");
	deleteCookies("celebrate_edit_base_id");
	deleteCookies("celebrate_edit_employee_name");
}
celebrate_regist = getCookie("celebrate_regist_from");
if(celebrate_regist !="" || celebrate_regist ==null)
{ 
	deleteCookies("celebrate_regist_from" , { path: '/' });
	deleteCookies("celebrate_regist_category_id" , { path: '/' });
	deleteCookies("celebrate_regist_record_year" , { path: '/' });
	deleteCookies("celebrate_regist_record_month" , { path: '/' });
	deleteCookies("celebrate_regist_record_day" , { path: '/' });
	deleteCookies("celebrate_regist_base_id" , { path: '/' });
	deleteCookies("celebrate_regist_employee_name" , { path: '/' });
}
    jQuery(function($) {
        $('ul.yiiPager li.selected').removeClass('selected');
        $('ul.yiiPager li').removeClass('page');
        $('ul.yiiPager li').removeClass('previous');
        $('ul.yiiPager li').removeClass('next');
        $('ul.yiiPager li').removeClass('last');
        $('ul.yiiPager li').removeClass('first');
        $('ul.yiiPager li').removeClass('hidden');
        $('ul.yiiPager').removeClass('yiiPager');    
        
        $("body").attr('id', 'admin');
    });
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap admin secondary celebrate">

    <div class="container">
        <div class="contents index">

            <div class="mainBox detail">
                <div class="pageTtl">
					<h2>お祝い</h2>
                    <a class="btn btn-important" href="<?php echo Yii::app()->baseUrl; ?>/admincelebrate/regist/">
						<i class="icon-pencil icon-white"></i> 登録
					</a>
                    <a class="btn btn-important" href="<?php echo Yii::app()->baseUrl; ?>/admincelebrate/categories/">
						<i class="icon-pencil icon-white"></i> カテゴリー管理
					</a>
                </div>

                <div class="box">

                    <!--p class="descriptionTxt"></p-->
 
                    <?php echo CHtml::beginForm('', 'post', array('id' => 'index_frm')); ?>
                    <table width="724" border="0" class="table list font14">
                        <thead>
                            <tr>
                                <th>日付</th><th>カテゴリー</th><th>名前</th><th>編集</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                             <?php
                        if ($celebrates != null && is_array($celebrates) && count($celebrates) > 0) {
                            foreach ($celebrates as $celebrate) {
                                ?>   
                                <tr>
                                    <td class="td-date alnC txtRed postsDate">
										<?php echo  FunctionCommon::formatDate($celebrate['record_date']); ?>
									</td>
                                    <td class="td-category">
										<?php echo FunctionCommon::crop(htmlspecialchars($celebrate['category_name']),20);?>
									</td>
                                    <td class="td-text">
                                        <p class="base_name">
											<?php echo FunctionCommon::crop(htmlspecialchars($celebrate['branch_name']),20);?>
										</p>
                                        <p class="name">
											<?php echo FunctionCommon::crop(htmlspecialchars($celebrate['employee_name']),20);?>
										</p>
                                    </td>
                                    <td class="td-edit">
                                        <a class="btn btn-work" href="<?php echo Yii::app()->baseUrl; ?>/admincelebrate/edit/?id=<?php echo $celebrate['id'];?>">修正</a>                                        
                                        <a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/admincelebrate/delete/?celebrate_id=<?php echo $celebrate['id']; ?>';" href="#" class="btn btn-correct">削除</a>
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
        <p id="page-top" style="display: none;"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->

    <div class="footer">
        <p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div>
