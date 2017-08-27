<link href="<?php echo $this->assetsBase; ?>/css/asobi/css/secondary.css" rel="stylesheet" type="text/css"/>
<script language="javascript">
jQuery(function($)
{  
	$("body").attr('id','asobi');  
});	
</script>
<div class="wrap asobi secondary link">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox">
            	<div class="pageTtl">
					<h2>リンク集</h2>
					<a href="<?php echo Yii::app()->baseUrl;?>/asobi" class="btn btn-important">
						<i class="icon-home icon-white"></i> あそびのTopへ戻る
					</a>
				</div>
                <div class="box">
<!--				   <p class="descriptionTxt">いろんな情報を共有しましょう！登録希望は総務課まで！</p>-->
				   <?php if(!is_null($model)): ?>
					<ul class="inline category-navi">
						<?php foreach($model as $item): ?>
							<li>
								<a href="#<?php echo htmlspecialchars($item->category_name);?>">
									<?php echo htmlspecialchars($item->category_name); ?>
								</a>
							</li>
						<?php endforeach; ?>
					 </ul>
					 <?php foreach($model as $item1): ?>
						<h3 id="<?php echo htmlspecialchars($item1->category_name); ?>" class="category_name">
							<?php echo htmlspecialchars($item1->category_name); ?>
						</h3>
						<table width="724" border="0" class="table list font14">
							<tbody>
								<?php $criteria = new CDbCriteria();
									  $criteria->select = '*';
									  $criteria->condition=(FunctionCommon::isViewFunction("slink"))?"contributor_id=".Yii::app()->request->cookies['id']:"true";
									  $criteria->condition="category_id=$item1->id";
									  $criteria->order ='created_date DESC';
									  $links = Slink::model()->findAll($criteria);?>					
								<?php if(!is_null($links)): ?>	
									<?php foreach($links as $link): ?>
										<tr class="item">
											<td>
												<p class="title">
													<a href="<?php echo $link->url ?>" target="_blank">
														<?php echo htmlspecialchars($link->title); ?>
													</a>
												</p>
												<p class="comment">
													<?php echo nl2br(htmlspecialchars($link->comment));?>
												</p>
											</td>
										</tr>
									<?php endforeach; ?>	
								<?php endif; ?>	
							</tbody>
						</table>	
					 <?php endforeach; ?>
				  <?php endif; ?>
                </div><!-- /box -->
            </div><!-- /mainBox -->
            
        </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div><!-- /wrap -->

