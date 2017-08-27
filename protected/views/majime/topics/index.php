<link href="<?php echo $this->assetsBase; ?>/css/majime/css/secondary.css" rel="stylesheet" type="text/css"/>
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
        
        $("body").attr('id','admin');        
    });
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap majime secondary topics">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox">
            	<div class="pageTtl">
					<h2>更新情報</h2>
						<a class="btn btn-important" href="<?php echo Yii::app()->request->baseUrl; ?>/majime">
							<i class="icon-home icon-white"></i> マジメのTopへ戻る
						</a>
				</div>
                <div class="box">
                
                <p class="descriptionTxt">マジメにて登録、投稿された情報の新着一覧です。</p>
                
                	<table width="724" border="0" class="table topics font14">
                            <tbody>
                                <?php if(is_array($items)&&count($items)>0)
								{
                                    foreach ($items as $item){
										if(FunctionCommon::isViewFunction($item['table_name'])==true)
										{	?> 
                                        <tr>
                                            <td class="td-date alnC txtRed">
												<?php	echo  FunctionCommon::formatDate($item['created_date']);?>
											</td>
                                            <td class="td-text">
                                                <p class="text">
													        <?php 
                                                    if($item['table_name']!='enquete'){?>
                                                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/majime<?php echo $item['table_name'].'/detail/?id='.$item['id'];?>">
															<?php echo htmlspecialchars($item['title']);?>
													</a>
                                                    <?php 
                                                    }
                                                    else{
                                                    ?>
                                                    <?php 
                                                    $enquete = Enquete::model()->findByPk($item['id']);
                                                     if(FunctionCommon::checkDeadline($enquete->deadline)){?>
                                                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/majime<?php echo $item['table_name'].'/detail/?id='.$item['id'];?>">
                      												<?php echo htmlspecialchars($enquete->title);?>
                                                            </a>
                                                     <?php                                                     
                                                     } 
                                                     else{ 
                                                     ?>
                                                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/majime<?php echo $item['table_name'].'/detail_result/?id='.$item['id'];?>">
                      												<?php echo htmlspecialchars($item['title']);?>
                                                            </a>
                                                    <?php
                                                         }
                                                    }
                                                    ?>
                                                </p>
                                            </td>
                                        </tr> 
                                <?php } 
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
                
                </div><!-- /box -->
            </div><!-- /mainBox -->
            
        </div><!-- /contents -->
        <p id="page-top" style="display: none;"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div>
