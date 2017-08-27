<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<script language="javascript">
if(getCookie("golf_news_edit_from")!=null && getCookie("golf_news_edit_from")!=undefined)
{
    deleteCookies("golf_news_edit_from");
    deleteCookies("golf_news_edit_title");
    deleteCookies("golf_news_edit_content");
    deleteCookies("golf_news_edit_attachment1_checkbox_for_deleting");
    deleteCookies("golf_news_edit_attachment2_checkbox_for_deleting");
    deleteCookies("golf_news_edit_attachment3_checkbox_for_deleting");
    deleteCookies("golf_news_edit_eye_catch_checkbox_for_deleting"); 
 }
jQuery(function($) 
{        
	$("body").attr('id','admin');  
})
</script>
<div class="wrap admin secondary golf_news">

    <div class="container">
        <div class="contents categories">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>ゴルフもマジメ！ - カテゴリー一覧</h2>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/admincategory/categoryregist/?type=5" class="btn btn-important">
						<i class="icon-pencil icon-white"></i> 登録
					</a>
					<?php if(Yii::app()->request->cookies['page'] >'1'): ?>	
						  <a href="<?php echo Yii::app()->request->baseUrl; ?>/admingolf_news/index?page=<?php echo Yii::app()->request->cookies['page']?>" class="btn btn-important">
							<i class="icon-chevron-left icon-white"></i>もどる
						  </a>
					<?php else : ?>
						  <a href="<?php echo Yii::app()->request->baseUrl; ?>/admingolf_news" class="btn btn-important">
							<i class="icon-chevron-left icon-white"></i>もどる
						  </a>
					<?php endif; ?>
            	</div>
                <div class="box">
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
										<span class="label" style="background-color: <?php echo $item["background_color"]?>; color:<?php echo $item["text_color"]?>;">
											<?php echo htmlspecialchars($item["category_name"])?>
										</span>
									</td>
									<td class="td-counter">
										<?php echo Yii::app()->db->createCommand('SELECT COUNT(*) FROM golf_news WHERE category_id='.$item->id)->queryScalar();?>
									</td>
									<td class="td-edit">
										<a href="<?php echo Yii::app()->request->baseUrl; ?>/admincategory/categoryedit/?id=<?php echo $item->id;?>&type=5" class="btn btn-work">修正</a>
										 <a onclick="if(confirm('削除します。よろしいですか？')==true)  window.location='<?php echo Yii::app()->request->baseUrl; ?>/admincategory/categorydelete/?id=<?php echo $item->id;?>&type=5';" href="#" class="btn btn-correct">削除</a>
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