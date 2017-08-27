<link href="<?php echo$this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<script language="javascript">
bounty = getCookie("bounty_edit_title");
if(bounty !="" || bounty ==null)
{  
	deleteCookies("bounty_edit_form" , { path: '/' });
	deleteCookies("bounty_edit_title" , { path: '/' });
	deleteCookies("bounty_edit_content" , { path: '/' });
	deleteCookies("bounty_edit_prize" , { path: '/' });
	deleteCookies("bounty_edit_deadline_year" , { path: '/' });
	deleteCookies("bounty_edit_deadline_month" , { path: '/' });
	deleteCookies("bounty_edit_deadline_day" , { path: '/' });
	deleteCookies("bounty_edit_attachment1_checkbox_for_deleting" , { path: '/' });
	deleteCookies("bounty_edit_attachment2_checkbox_for_deleting" , { path: '/' });
	deleteCookies("bounty_edit_attachment3_checkbox_for_deleting" , { path: '/' });
}
jQuery(function($)
{
	$("body").attr('id','admin');        
})
</script>
<input type="hidden" id="page_count" value="<?php  echo $pages->getPageCount();?>"/>
<div class="wrap admin secondary bounty">
  <div class="container">
    <div class="contents index">
      <div class="mainBox detail">
        <div class="pageTtl">
          <h2>懸賞金付き募集コンテンツ</h2>
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
					<?php foreach($model as $bounty): ?>	
					  <tr>
						<td class="td-date alnC txtRed postsDate">
							<?php echo FunctionCommon::formatDate($bounty->created_date); ?>
						</td>
						<td class="td-date alnC txtRed updateDate">
							<?php echo FunctionCommon::formatDate($bounty->last_updated_date); ?>
						</td>
						<td class="td-text">
						  <p class="text">
							<?php echo CHtml::link(htmlspecialchars($bounty->title),array('adminbounty/detail','id'=>$bounty->id)); ?>
						  </p>
						  <div class="bounty-state">
							<p class="date deadline">
								募集締め切り:<?php echo FunctionCommon::formatDate($bounty->deadline); ?>
							</p>
							<p class="subscription">応募数：
							  <?php $count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM bounty_apply WHERE bounty_id='.$bounty->id)->queryScalar(); ?>
							  <?php if ($count >0 ) : ?>	
								<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminbountyapply/subscription/?id=<?php echo $bounty->id; ?>">
									<?php echo'('.$count.')'?>
								</a>
							    <?php else : ?>
									<?php echo'('.$count.')'?>
								<?php endif ?>
							</p>
						  </div>
						</td>
						<td class="td-edit">
						  <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminbounty/edit/?id=<?php echo $bounty->id; ?>" class="btn btn-work">修正</a>
						  <a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/adminbounty/delete/?id=<?php echo $bounty->id; ?>';" href="#" class="btn btn-correct">削除</a>
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