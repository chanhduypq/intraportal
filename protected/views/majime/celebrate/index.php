
<script type="text/javascript">
    jQuery(function($) {
        $('ul.yiiPager li.selected').removeClass('selected');
        $('ul.yiiPager li').removeClass('page');
        $('ul.yiiPager li').removeClass('previous');
        $('ul.yiiPager li').removeClass('next');
        $('ul.yiiPager li').removeClass('last');
        $('ul.yiiPager li').removeClass('first');
        $('ul.yiiPager li').removeClass('hidden');
        $('ul.yiiPager').removeClass('yiiPager');    
        
        $("body").attr('id', 'majime');
    });
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap majime secondary celebrate">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
                <div class="pageTtl">
					<h2>お祝い</h2>
					<a class="btn btn-important" href="<?php echo Yii::app()->baseUrl;?>/majime/">
						<i class="icon-home icon-white"></i> マジメのTopへ戻る
					</a>
				</div>
                <div class="box">
                <!--p class="descriptionTxt"></p-->

                <?php echo CHtml::beginForm('', 'post', array('id' => 'index_frm')); ?>
                	<table width="724" border="0" class="table topics font14">
                            <tbody>
                                <?php  if ($celebrates != null && is_array($celebrates) && count($celebrates) > 0) {
								foreach ($celebrates as $celebrate) { ?>   
                                <tr>
                                    <td class="td-date alnC txtRed">
										<?php echo FunctionCommon::formatDate($celebrate['record_date']); ?>
									</td>
                                    <td class="td-type">
										<span class="txtB">
										    <?php echo htmlspecialchars($celebrate['category_name']);?>	
										</span>
								    </td>
                                    <td class="td-name1">
										<?php echo htmlspecialchars($celebrate['branch_name']);?>	
										
									</td>
                                    <td class="td-name2">
										<?php echo htmlspecialchars($celebrate['employee_name']);?>	
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
            
        </div><!-- /contents -->
        <p id="page-top" style="display: none;"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>
</div>
