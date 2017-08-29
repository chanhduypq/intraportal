
<script language="javascript">
jQuery(function($) 
{        
	$("body").attr('id','admin');  
})
</script>
<div class="wrap admin secondary link">

    <div class="container">
        <div class="contents categories">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>リンク集 - カテゴリー一覧</h2>
            		<a href="<?php echo Yii::app()->request->baseUrl; ?>/admincategory/categoryregist/?type=7" class="btn btn-important">
						<i class="icon-pencil icon-white"></i> 登録
					</a>
					<?php if(Yii::app()->request->cookies['page'] >'1'): ?>	
						  <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminlink/index?page=<?php echo Yii::app()->request->cookies['page']?>" class="btn btn-important">
							<i class="icon-chevron-left icon-white"></i>もどる
						  </a>
					<?php else : ?>
						  <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminlink" class="btn btn-important">
							<i class="icon-chevron-left icon-white"></i>もどる
						  </a>
					<?php endif; ?>
            	</div>
                <div class="box">
                
                <!--p class="descriptionTxt"></p-->
                
                <table width="724" border="0" class="table list font14">
                	<thead>
	                	<tr>
	                		<th>カテゴリー</th>
							<th>登録数</th>
							<th>編集</th>
						</tr>
					</thead>
					<tbody>
						<?php if(!is_null($category)): ?>
							 <?php foreach($category as $item): ?>
								  <tr>
									<td class="td-category">
										<?php echo htmlspecialchars($item["category_name"])?>
									</td>
									<td class="td-counter">
										<?php echo Yii::app()->db->createCommand('SELECT COUNT(*) FROM slink WHERE category_id='.$item->id)->queryScalar();?>
									</td>
									<td class="td-edit">
										<a href="<?php echo Yii::app()->request->baseUrl; ?>/admincategory/categoryedit/?id=<?php echo $item->id;?>&type=7" class="btn btn-work">修正</a>
										<a onclick="if(confirm('削除します。よろしいですか？')==true)  window.location='<?php echo Yii::app()->request->baseUrl; ?>/admincategory/categorydelete/?id=<?php echo $item->id;?>&type=7';" href="#" class="btn btn-correct">削除</a>
									</td>
								 </tr>
							 <?php endforeach; ?>
						<?php endif; ?>	 
					</tbody>
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
		  </div>
          <!-- /sideBox -->
            
  </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
</div>

</div><!-- /wrap -->
