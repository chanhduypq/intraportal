
<script type="text/javascript">   
jQuery(function($)
{    
	 $("body").attr('id','admin');      	
});
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap admin secondary slink">
    <div class="container">
        <div class="contents index">
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>オススメのリンク</h2>
					<a href="<?php echo Yii::app()->baseUrl;?>/adminslink/regist" class="btn btn-important">
						<i class="icon-pencil icon-white"></i> 登録
					</a>
				</div>
                <div class="box">
                <!--p class="descriptionTxt"></p-->
                <table width="724" border="0" class="table list font14">
                	<thead><tr>
						<th>投稿年月日</th>
						<th>更新年月日</th>
						<th>タイトル / URL</th>
						<th>編集</th>
					</tr></thead>
					<?php if(!is_null($model)): ?>
						<?php foreach($model as $slink): ?>
							<tr>
								<td class="td-date alnC txtRed postsDate">
									<?php echo FunctionCommon::formatDate($slink->created_date); ?>
								</td>
								<td class="td-date alnC txtRed updateDate">
									<?php echo FunctionCommon::formatDate($slink->last_updated_date); ?>
								</td>
								<td class="td-text">
								<p class="text">
									<?php echo htmlspecialchars($slink->title); ?>
								</p>
								<p class="text">
									<a href="<?php echo $slink->url?>" target="_blank">
										<?php echo $slink->url; ?>
									</a>
								</p>
								</td>
								<td class="td-edit">
									<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminslink/edit/?id=<?php echo $slink->id; ?>" class="btn btn-work">修正</a>
									<a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/adminslink/delete/?id=<?php echo $slink->id; ?>';" href="#" class="btn btn-correct">削除</a>
								</td>
							</tr>
					<?php endforeach; ?>
		          <?php endif; ?>
                </table>
				<?php $this->widget('ext.Pagination.Base', array('CPaginationObject' => $pages)); ?> 
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
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
</div>

</div><!-- /wrap -->