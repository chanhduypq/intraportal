
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
        
        $("body").attr('id', 'admin');
    });
</script>
<div class="wrap admin secondary celebrate">

    <div class="container">
        <div class="contents categories">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>お祝い - カテゴリー一覧</h2>
            		
            		<a class="btn btn-important" href="<?php echo Yii::app()->baseUrl; ?>/admincelebrate/categoryregist/"><i class="icon-pencil icon-white"></i> 登録</a>
            		<a class="btn btn-important" href="<?php echo Yii::app()->baseUrl; ?>/admincelebrate/"><i class="icon-chevron-left icon-white"></i> もどる</a>
            	</div>
                <div class="box">
                
                <!--p class="descriptionTxt"></p-->
                
                <table width="724" border="0" class="table list font14">
                	<thead>
	                	<tr>
	                		<th>カテゴリー</th><th>登録数</th><th>編集</th>
						</tr>
					</thead>
					<tbody>
	                    

	                    <?php 
                            
                            if(isset($categories)&&  is_array($categories)&&count($categories)>0){
                                foreach ($categories as $categorie) {?>
                                    <tr>
                                        <td class="td-category"><?php echo htmlspecialchars($categorie['category_name']);?></td>
                                        <td class="td-counter"><?php echo $categorie['count(category.id)'];?></td>
                                        <td class="td-edit">                                    
                                            <a class="btn btn-work" href="<?php echo Yii::app()->request->baseUrl; ?>/admincelebrate/categoryedit/?id=<?php echo $categorie['id']; ?>">修正</a>
                                            <a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/admincelebrate/delete/?category_id=<?php echo $categorie['id']; ?>';" href="#" class="btn btn-correct">削除</a>
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