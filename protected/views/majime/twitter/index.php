
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
        
        $("body").attr('id','majime');        
    });
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap majime secondary twitter">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>Twitterキャッチ！</h2>
					<a class="btn btn-important" href="<?php echo Yii::app()->baseUrl;?>/majime/index">
						<i class="icon-home icon-white"></i> マジメのTopへ戻る
					</a>
					</div>
                <div class="box">
                
                <!--p class="descriptionTxt"></p-->
                
                <?php echo CHtml::beginForm('', 'post', array('id' => 'index_frm')); ?>
                	<table width="724" border="0" class="table topics font14">
                        <tbody>
                            <?php if(isset($blogc_twitter_contents)&&is_array($blogc_twitter_contents)&&count($blogc_twitter_contents)>0){ 
                                foreach($blogc_twitter_contents as $blogc_twitter_content)  {
                                    $temp=  explode("status", $blogc_twitter_content['screen_name']);
                                    $list=$temp[0];
                                    $list1=  substr($list,0,  strlen($list)-1);
                                    ?>
                                    <tr>
                                        <td class="td-date alnC txtRed">
											<?php echo  getDateTimeFromDB($blogc_twitter_content["contributed_date"]);?>
										</td>
                                        <td class="td-text">
                                            
                                        <p class="text">
                                            
                                                                                        <a class="twitter-timeline" target="_blank" href="https://twitter.com/<?php echo $blogc_twitter_content['screen_name'];?>" data-screen-name="<?php echo $blogc_twitter_content['screen_name'];?>">
													<?php echo $blogc_twitter_content['content'];?>
												</a>
                                        </p>
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
                
                </div><!-- /box -->
            </div><!-- /mainBox -->
            
        </div><!-- /contents -->
        <p id="page-top" style="display: none;"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<?php
function getDateTimeFromDB($time){
    if($time==NULL||!is_string($time)||  trim($time)==""){
        return $time;
    }
    $date_time_array=  explode(" ", $time);
    if(count($date_time_array)!=2){
        return $time;
    }
    $date=$date_time_array[0];
    $date_array=  explode("-", $date);
    if(count($date_array)!=3){
        return $time;
    }
    $date_string=$date_array[0].'/'.$date_array[1].'/'.$date_array[2] ;
    $time_array=  explode(":",$date_time_array[1]);
    if(count($time_array)!=3){
        return $time;
    }
    $time_string=$time_array[0].':'.$time_array[1];
    return $date_string.' '.$time_string;
}
?>