<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<script language="javascript">
newitem = getCookie("newitem_edit_form");
if(newitem !="" || newitem ==null){ 
deleteCookies("newitem_edit_form", { path: '/' });
deleteCookies("newitem_edit_type", { path: '/' });
deleteCookies("newitem_edit_title", { path: '/' });
deleteCookies("newitem_edit_content", { path: '/' });
deleteCookies("newitem_edit_attachment1_checkbox_for_deleting", { path: '/' });
deleteCookies("newitem_edit_attachment2_checkbox_for_deleting", { path: '/' });
deleteCookies("newitem_edit_attachment3_checkbox_for_deleting", { path: '/' });
}
jQuery(function($) 
{        
	$("body").attr('id','admin');  
})
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div id="admin" class="wrap admin secondary newitems" >
  <div class="container">
    <div class="contents index">
      <div class="mainBox detail">
        <div class="pageTtl">
          <h2>新商品情報</h2>
        </div>
        <div class="box">
          <!--p class="descriptionTxt"></p-->
          <table width="724" border="0" class="table list font14">
           <thead>
            <tr>
              <th>投稿年月日</th>
              <th>更新年月日</th>
              <th>タイトル</th>
              <th>編集</th>
            </tr>
           </thead> 
			<?php if($model != null): ?>
			    <?php foreach($model as $newitem): ?>
				<tr>
				  <td class="td-date alnC txtRed postsDate">
					<?php echo FunctionCommon::formatDate($newitem->created_date); ?>
				  </td>
				  <td class="td-date alnC txtRed updateDate">
					<?php echo FunctionCommon::formatDate($newitem->last_updated_date); ?>
				  </td>
				  <?php if($newitem->type == "1"): ?>
					  <td class="td-text">
							<p class="text">
                                <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminnewitem/detail/?id=<?php echo $newitem->id; ?>">
									<?php echo htmlspecialchars($newitem->title);?>
								</a>
							</p>
					  </td>
				  <?php else : ?>
						<td class="td-text">
							<p class="text">
								<div class="icon icon-share-alt"></div>
								<?php echo CHtml::link(htmlspecialchars($newitem->title),$newitem->content, array('target'=>'_blank')); ?>		
							</p>
						</td>
				   <?php endif; ?>  
				  <td class="td-edit">
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminnewitem/edit/?id=<?php echo $newitem->id; ?>" class="btn btn-work">修正</a>
					<a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/index.php/adminnewitem/delete/?id=<?php echo $newitem->id; ?>';" href="#" class="btn btn-correct">削除</a>
				  </td>
				</tr>
				<?php endforeach; ?>
			<?php endif; ?>
          </table>
          <?php $this->widget('ext.Pagination.Base', array('CPaginationObject' => $pages)); ?> 
        </div>
        <!-- /box -->
      </div>
      <!-- /mainBox -->
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
    </div>
    <!-- /contents -->
    <p id="page-top">
      <a href="#wrap">PAGE TOP</a>
    </p>
  </div>
  <!-- /container -->
  <div class="footer">
    <p>COPYRIGHT (C) Newgin ALL RIGHTS RESERVED.</p>
  </div>
</div>
<!-- /wrap -->