
<script type="text/javascript">
golf_news = getCookie("golf_news_edit_from");
if(golf_news !="" || golf_news ==null)
{ 
    deleteCookies("golf_news_edit_from" , { path: '/' });
    deleteCookies("golf_news_edit_title" , { path: '/' });
    deleteCookies("golf_news_edit_content" , { path: '/' });
    deleteCookies("golf_news_edit_attachment1_checkbox_for_deleting" , { path: '/' });
    deleteCookies("golf_news_edit_attachment2_checkbox_for_deleting" , { path: '/' });
    deleteCookies("golf_news_edit_attachment3_checkbox_for_deleting" , { path: '/' });
    deleteCookies("golf_news_edit_eye_catch_checkbox_for_deleting" , { path: '/' }); 
  
    golf_news_edit_category = getCookie("golf_news_edit_category_id");
	if(golf_news_edit_category !="" || golf_news_edit_category ==null)
	{ 
        deleteCookies("golf_news_edit_category_id" , { path: '/' });
        deleteCookies("golf_news_edit_category_name" , { path: '/' });
        deleteCookies("golf_news_edit_background_color" , { path: '/' });
        deleteCookies("golf_news_edit_color" , { path: '/' });        
    }   
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
        
        $("body").attr('id','admin');      
    });
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap admin secondary golf_news">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>ゴルフもマジメ！</h2>
					<a class="btn btn-important" href="<?php echo Yii::app()->baseUrl;?>/admincategory/categories/?type=5">
						<i class="icon-pencil icon-white"></i> カテゴリー管理
					</a>
            	</div>
                <div class="box">
                
                <!--p class="descriptionTxt"></p-->
                
                <table width="724" border="0" class="table list font14">
                	<thead>
                	<tr><th>投稿年月日</th><th>更新年月日</th><th>タイトル</th><th>編集</th></tr>
                	</thead>
                	<tbody>
                    
                    <?php 
                    if(isset($golf_news)&&is_array($golf_news)&&count($golf_news)>0){
                        foreach ($golf_news as $golf_new){?>
                            <tr>
                                <td class="td-date alnC txtRed postsDate"><?php echo convertDateFromDbToView($golf_new['created_date']);?></td>
                                <td class="td-date alnC txtRed updateDate"><?php echo convertDateFromDbToView($golf_new['last_updated_date']);?></td>
                                <td class="td-text">
                                <p class="text"><a href="<?php echo Yii::app()->request->baseUrl; ?>/admingolf_news/detail/?id=<?php echo $golf_new['id']; ?>"><?php echo htmlspecialchars($golf_new['title']); ?></a></p>
                                </td>
                                <td class="td-edit">                            
                                    <a class="btn btn-work" href="<?php echo Yii::app()->baseUrl; ?>/admingolf_news/edit/?id=<?php echo $golf_new['id'];?>">修正</a>                                        
                                    <a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/admingolf_news/delete/?golf_new_id=<?php echo $golf_new['id']; ?>';" href="#" class="btn btn-correct">削除</a>
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
