<link href="<?php echo $this->assetsBase; ?>/css/asobi/css/secondary.css" rel="stylesheet" type="text/css"/>
<script language="javascript">
jQuery(function($)
{  
	$("body").attr('id','asobi');  
});	
</script>
<?php 
	function rank_compare($a, $b)
	{
		return $a->rank - $b->rank;
	}
	usort($data, 'rank_compare');

?>

<div class="wrap majime secondary fortune">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox">
            	<div class="pageTtl">
				<h2>今日の星座別運勢</h2>
            		<a href="<?php echo Yii::app()->baseUrl?>/asobi" class="btn btn-important">
						<i class="icon-home icon-white"></i> あそびのTopへ戻る
					</a>
				</div>
                <div class="box">
                
                    <!--p class="descriptionTxt"></p-->
                
                	<table width="724" border="0" class="table list font14">
                		<thead>
                			<tr>
                				<th class="td-rank">順位</th>
                				<th class="td-date">星座</th>
                				<th class="td-text">星座別運勢</th>
                			</tr>
                		</thead>
                		<tbody>
						
						<?php foreach($data as $object):?>
							    <tr>
	                        	<td class="td-rank alnC font16 txtB">
									<?php echo $object->rank ?>
								</td>
								<?php
									switch($object->rank)
									{
										  case 1:
											  foreach($horoscope as $key => $value)
											  {
													if($key==$object->sign)
													{
														echo '<td class="td-star alnC">';
														echo '<div class="star" id="'.$value['id'].'">';
														echo '<p><span>'.$value['start'].'</span></p>';
														echo '</div>';
														echo  '</td>';
													}
											  }	
											break;
										  case 2:
											  foreach($horoscope as $key => $value)
											  {
													if($key==$object->sign)
													{
														echo '<td class="td-star alnC">';
														echo '<div class="star" id="'.$value['id'].'">';
														echo '<p><span>'.$value['start'].'</span></p>';
														echo '</div>';
														echo  '</td>';
													}
											  }	
											break;	 
										  case 3:
											  foreach($horoscope as $key => $value)
											  {
													if($key==$object->sign)
													{
														echo '<td class="td-star alnC">';
														echo '<div class="star" id="'.$value['id'].'">';
														echo '<p><span>'.$value['start'].'</span></p>';
														echo '</div>';
														echo  '</td>';
													}
											  }		
											break;
										  case 4:
											  foreach($horoscope as $key => $value)
											  {
													if($key==$object->sign)
													{
														echo '<td class="td-star alnC">';
														echo '<div class="star" id="'.$value['id'].'">';
														echo '<p><span>'.$value['start'].'</span></p>';
														echo '</div>';
														echo  '</td>';
													}
											  }		
											break;
										  case 5:
											 foreach($horoscope as $key => $value)
											 {
												if($key==$object->sign)
												{
													echo '<td class="td-star alnC">';
													echo '<div class="star" id="'.$value['id'].'">';
													echo '<p><span>'.$value['start'].'</span></p>';
													echo '</div>';
													echo  '</td>';
												}
											 }		
											 break;
										  case 6:
											  foreach($horoscope as $key => $value)
											  {
												if($key==$object->sign)
												{
													echo '<td class="td-star alnC">';
													echo '<div class="star" id="'.$value['id'].'">';
													echo '<p><span>'.$value['start'].'</span></p>';
													echo '</div>';
													echo  '</td>';
												}
											  }	
											break;
										  case 7:
											  foreach($horoscope as $key => $value)
											  {
												if($key==$object->sign)
												{
													echo '<td class="td-star alnC">';
													echo '<div class="star" id="'.$value['id'].'">';
													echo '<p><span>'.$value['start'].'</span></p>';
													echo '</div>';
													echo  '</td>';
												}
											  }		
											break;
										  case 8:
											  foreach($horoscope as $key => $value)
											  {
													if($key==$object->sign)
													{
														echo '<td class="td-star alnC">';
														echo '<div class="star" id="'.$value['id'].'">';
														echo '<p><span>'.$value['start'].'</span></p>';
														echo '</div>';
														echo  '</td>';
													}
											  }		
											break;
										  case 9:
											  foreach($horoscope as $key => $value)
											  {
													if($key==$object->sign)
													{
														echo '<td class="td-star alnC">';
														echo '<div class="star" id="'.$value['id'].'">';
														echo '<p><span>'.$value['start'].'</span></p>';
														echo '</div>';
														echo  '</td>';
													}
											  }	
											break;
										  case 10:
											   foreach($horoscope as $key => $value)
											  {
													if($key==$object->sign)
													{
														echo '<td class="td-star alnC">';
														echo '<div class="star" id="'.$value['id'].'">';
														echo '<p><span>'.$value['start'].'</span></p>';
														echo '</div>';
														echo  '</td>';
													}
											  }		
											break;
										  case 11:
											  foreach($horoscope as $key => $value)
											  {
													if($key==$object->sign)
													{
														echo '<td class="td-star alnC">';
														echo '<div class="star" id="'.$value['id'].'">';
														echo '<p><span>'.$value['start'].'</span></p>';
														echo '</div>';
														echo  '</td>';
													}
											  }		
											break;
										  case 12:
											  foreach($horoscope as $key => $value)
											  {
													if($key==$object->sign)
													{
														echo '<td class="td-star alnC">';
														echo '<div class="star" id="'.$value['id'].'">';
														echo '<p><span>'.$value['start'].'</span></p>';
														echo '</div>';
														echo  '</td>';
													}
											  }		
											break;
									}?>
	                              <td class="td-text">
                                	<p class="descriptionTxt">
										<?php echo $object->content?>
									</p>
		                            <dl class="pointList">
                                        <dt>総合運</dt>
										
                                        <dd class="<?php echo 'tortal point'.$object->total?>"></dd>
                                        <dt>恋愛運</dt>
                                        <dd class="<?php echo 'love point'.$object->love?>"></dd>
                                        <dt>仕事運</dt>
                                        <dd class="<?php echo 'work point'.$object->job?>"></dd>
                                        <dt>金　運</dt>
                                        <dd class="<?php echo 'economic point'.$object->money?>"></dd>
                                    </dl>
                                    <dl class="luckyList">
                                        <dt>ラッキーカラー</dt>
                                        <dd><?php echo $object->color?></dd>
                                        <dt>ラッキーアイテム</dt>
                                        <dd><?php echo $object->item?></dd>
                                    </dl>
	                            </td>
	                        </tr>
						<?php endforeach; ?>
                        </tbody>
                    </table>
                
                </div><!-- /box -->
            </div><!-- /mainBox -->
            
        </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div><!-- /wrap -->
    
<script src="../../common/js/bootstrap.min.js"></script>
</body>
</html>
