
<script type="text/javascript">
claim = getCookie("claim_edit_from");
if(claim !="" || claim ==null)
{ 
	deleteCookies("claim_edit_from" , { path: '/' });
	deleteCookies("claim_edit_title" , { path: '/' });
	deleteCookies("claim_edit_content" , { path: '/' });
	deleteCookies("claim_edit_attachment1_checkbox_for_deleting" , { path: '/' });
	deleteCookies("claim_edit_attachment2_checkbox_for_deleting" , { path: '/' });
	deleteCookies("claim_edit_attachment3_checkbox_for_deleting" , { path: '/' });
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
	
	$("body").attr('id','admin');        
});
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap admin secondary claim">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>お客様クレーム</h2></div>
                <div class="box">
                
                
                <?php echo CHtml::beginForm('', 'post', array('id' => 'index_frm')); ?>
                <table width="724" border="0" class="table list font14">
                     <thead>
						<tr class="header_rs">
							<th>投稿年月日</th>
							<th>更新年月日</th>
							<th>タイトル</th>
							<th>編集</th>
						</tr>
					 </thead>
                      <tbody>
                        <?php
                        if ($claims != null && is_array($claims) && count($claims) > 0) {
                            foreach ($claims as $claim) {
                                ?>        

                                <tr>
                                    <td class="td-date alnC txtRed postsDate">
										<?php echo FunctionCommon::formatDate($claim['created_date']); ?>
									</td>
                                    <td class="td-date alnC txtRed updateDate">
										<?php echo FunctionCommon::formatDate($claim['last_updated_date']); ?>
									</td>
                                    <td class="td-text">
                                        <p class="text">                                        
                                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminclaim/detail/?id=<?php echo $claim['id']; ?>">
												<?php echo htmlspecialchars($claim['title']); ?>
											</a>
                                        </p>
                                    </td>
                                    <td class="td-edit">
                                        <a class="btn btn-work" href="<?php echo Yii::app()->request->baseUrl; ?>/adminclaim/edit/?id=<?php echo $claim['id']; ?>">修正</a>
                                        <a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/adminclaim/delete/?id=<?php echo $claim['id']; ?>';" href="#" class="btn btn-correct">削除</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    
                </tbody></table>

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

