<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<script language="javascript">
hobby_new = getCookie("hobby_new_edit_form");
if(hobby_new !="" || hobby_new ==null)
{ 
	deleteCookies("hobby_new_edit_form" , { path: '/' });
	deleteCookies("hobby_new_edit_category_id" , { path: '/' });
	deleteCookies("hobby_new_edit_title" , { path: '/' });
	deleteCookies("hobby_new_edit_content" , { path: '/' });
	deleteCookies("hobby_new_edit_attachment1_checkbox_for_deleting" , { path: '/' });
	deleteCookies("hobby_new_edit_attachment2_checkbox_for_deleting" , { path: '/' });
	deleteCookies("hobby_new_edit_attachment3_checkbox_for_deleting" , { path: '/' });
}

jQuery(function($) 
{        
	$("body").attr('id','admin');  
})
</script>
<input type="hidden" id="page_count" value="<?php  echo $pages->getPageCount();?>"/>
<div class="wrap admin secondary hobby_new">
  <div class="container">
    <div class="contents index">
      <div class="mainBox detail">
        <div class="pageTtl">
          <h2>趣味・サークルの広場What'sNew</h2>
          <a href="<?php echo Yii::app()->request->baseUrl; ?>/admincategory/categories/?type=6" class="btn btn-important">
            <i class="icon-pencil icon-white"></i>カテゴリー管理
          </a>
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
            <tbody>
				<?php if(!is_null($model)): ?>
					 <?php foreach($model as $hobby_new): ?>
						<tr>
							<td class="td-date alnC txtRed postsDate">
								<?php echo FunctionCommon::formatDate($hobby_new->created_date); ?>
							</td>
							<td class="td-date alnC txtRed updateDate">
								<?php echo FunctionCommon::formatDate($hobby_new->created_date); ?>
							</td>
							<td class="td-text">
							  <p class="text">
								 <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminhobby_new/detail/?id=<?php echo $hobby_new->id; ?>" >
									<?php echo htmlspecialchars($hobby_new->title)?>
								</a>
							  </p>
							</td>
							<td class="td-edit">
							  <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminhobby_new/edit/?id=<?php echo $hobby_new->id; ?>" class="btn btn-work">修正</a>
							  <a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/adminhobby_new/delete/?id=<?php echo $hobby_new->id; ?>';" href="#" class="btn btn-correct">削除</a>	
							</td>
					  </tr>
					 <?php endforeach; ?>
				<?php endif; ?>
             </tbody>
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