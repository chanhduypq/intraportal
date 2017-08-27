<link href="<?php echo $this->assetsBase; ?>/css/asobi/css/secondary.css" rel="stylesheet" type="text/css"/>
<script language="javascript">
jQuery(function($)
{  
	$("body").attr('id','asobi');  
});	
</script>
<?php
	function formatDate($date)
	{
		if (preg_match("/[0-9]{4}\/[0-9]{2}\/[0-9]{2}/", $date))
		{
			return $date;
		}
		else
		{

			$year=substr($date, 0, 4);	
			$month=substr($date, 4, 2);	
			$day=substr($date, 6, 2);	
			$date="";
			if(!empty($year))
			{
				$date=$year;
			}
			if(!empty($month))
			{
				$date.='/'.$month;
			}
			if(!empty($day))
			{
				$date.='/'.$day;
			}
			return $date;
		}
	}
?>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap asobi secondary ranking">

    <div class="container">
        <div class="contents animation index">
        	
            <div class="mainBox">
            	<div class="pageTtl">
					<h2>アニメBlu-rayジャンル　<?php echo substr($yearmonth, 0, 4);?>年<?php echo substr($yearmonth, 4, 2);?>月最新ランキング</h2>
						<a href="<?php echo Yii::app()->baseUrl?>/asobi" class="btn btn-important">
							<i class="icon-home icon-white"></i> あそびのTopへ戻る
						</a>
				</div>
                <div class="box">
                
                	<ul class="nav nav-pills genre-navi">
                		<li class="active">
							<a href="<?php echo Yii::app()->baseUrl;?>/asobiranking/animation">アニメBlu-rayランキング</a>
						</li>
                		<li>
							<a href="<?php echo Yii::app()->baseUrl;?>/asobiranking/comic">コミックランキング</a>
						</li>
                		<li>
							<a href="<?php echo Yii::app()->baseUrl;?>/asobiranking/lightnovel">ライトノベルランキング</a>
						</li>
                	</ul>
                
                	<p class="descriptionTxt">オリコン集計によるBlu-rayジャンル　<?php echo substr($yearmonth, 0, 4);?>年<?php echo substr($yearmonth, 4, 2);?>月最新ランキングです。</p>
                
                	<table width="724" border="0" class="table list font14">
                		<thead>
                			<tr>
	                			<th class="td-rank">ランキング</th>
	                			<th class="td-sales td-multirow">
	                				<span class="current">売上数</span>
	                				<span class="accum">(累計売上数)</span>
	                			</th>
	                			<th class="td-iteminfo">商品情報</th>
	                		</tr>
                		</thead>
                		<tbody>
							<?php if(count($data)>0):?>
                			<?php foreach($data as $item):?>
							<?php $item=(explode("	",$item));?>
							<?php if(isset($item[0]) && !empty($item[0]) && is_numeric($item[0])):?>
	               			<tr>
	                			<td class="td-rank">
									<?php echo  $item[0];?>
								</td>
	                			<td class="td-sales td-multirow">
									<?php if(isset($item[1]) && !empty($item[1]) && is_numeric($item[1])):?>
									<span class="current">
										<?php echo number_format($item[1])?>
									</span>
									<span class="accum">(<?php echo number_format($item[2]);?>)</span>
									<?php endif;?>
								</td>
	                			<td class="td-iteminfo">
                					<p class="title">
										<a href="http://www.amazon.co.jp/s/ref=nb_sb_noss?__mk_ja_JP=カタカナ&url=search-alias%3Daps&field-keywords=<?php echo $item[5]?>" target="_blank" >
											<?php echo isset($item[5]) ? $item[5] :null;?>
										</a>
									</p>
	                				<ul class="info">
	                					<li class="mgenre">
											<?php echo isset($item[10]) ? $item[10] :null;?>
										</li>
	                					<li class="sale_date">発売日：<?php echo isset($item[6]) ? formatDate($item[6]) :null;?></li>
	                					<li class="price">税込価格：<?php echo isset($item[7]) ? number_format($item[7]) :null;?>円</li>
	                					<li class="sale_agen">発売元：<?php echo isset($item[8]) ? $item[8] :null;?></li>
	                				</ul>
	                			</td>
                			</tr>
							<?php endif;?>
                			<?php endforeach; ?>
							<?php endif;?>
                		</tbody>
                    </table>
					<div class="pagination">
                        <?php $this->widget('CLinkPager', array(
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
                
                <div class="box">
                	<p>オリコン調べ（<a href="http://www.oricon.co.jp/" target="_blank">oricon.co.jp</a>）</p>
                    <p>データをご使用の際は、クレジット「オリコン調べ(oricon.co.jp)」の表記をお願い致します。
売上枚数をご使用の際は(単位：万部）の数字をご使用下さい。<br />
他媒体（HP、携帯サイトなどインターネットを含む）への転載・流用は原則的に許諾しておりません。<br />
転載、再使用をご要望の際は、別途オリコンまでご連絡をお願い致します。</p>
                </div><!-- /box -->
            </div><!-- /mainBox -->
            
        </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div><!-- /wrap -->
