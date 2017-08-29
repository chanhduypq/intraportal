
<script type="text/javascript">
    jQuery(function($) {
        
        $("body").attr('id','majime');      
    });
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap majime secondary claim">
    <div class="container">
        <div class="contents index">
            <div class="mainBox detail">                
				<div class="pageTtl">
				<h2>総務からのお知らせ</h2>
				<a class="btn btn-important" href="<?php echo Yii::app()->request->baseUrl .'/majime'?>">
					<i class="icon-home icon-white"></i> マジメのTopへ戻る
				</a>
				</div>
                <div class="box">
                    <div class="cnt-box">
                	<table width="724" border="0" class="table topics font14">
                        <tbody>
						    <?php $now = strtotime(date('Y/m/d'));?>
							<?php if(is_array($model) && count($model)): ?>
								 <?php foreach($model as $item): ?>
								 <?php  $created_date = strtotime(date('Y/m/d', strtotime($item->created_date)));?>
										<tr>
											<td class="td-date alnC txtRed">
												<?php echo FunctionCommon::formatDate($item->created_date); ?>
											</td>
											<td class="td-text">
												<p class="text"> 
												   <?php if($created_date > $now-650000):?>
														<span class="badge badge-warning mr10">NEW</span>
												   <?php endif; ?>
                                                   <?php if($item->label=='1'){ echo '<span class="badge badge-important">重要</span>&nbsp;';}?>
												   <a href="<?php echo Yii::app()->request->baseUrl; ?>/majimesoumu_news/detail/?id=<?php echo $item->id; ?>">
														<?php echo htmlspecialchars($item->title);?>
												   </a>
												</p>
											</td>
										</tr>
								 <?php endforeach; ?>
							<?php endif; ?>
						</tbody>
					</table>
                	 <?php $this->widget('ext.Pagination.Base', array('CPaginationObject' => $pages)); ?>   
                </div>
                </div>

            </div>
        </div>
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>
    </div>
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>
</div>

