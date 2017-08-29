
<script type="text/javascript">
bounty = getCookie("bounty_regist_form");
if(bounty !="" || bounty ==null){    
	
	deleteCookies("bounty_regist_form", { path: '/' });
	deleteCookies("bounty_reg_title", { path: '/' });
	deleteCookies("bounty_reg_content", { path: '/' });
	deleteCookies("bounty_reg_prize", { path: '/' });
	deleteCookies("bounty_reg_deadline_year", { path: '/' });
	deleteCookies("bounty_reg_deadline_month", { path: '/' });
	deleteCookies("bounty_reg_deadline_day", { path: '/' });
	deleteCookies("bounty_reg_attachment1_checkbox_for_deleting", { path: '/' });
	deleteCookies("bounty_reg_attachment2_checkbox_for_deleting", { path: '/' });
	deleteCookies("bounty_reg_attachment3_checkbox_for_deleting", { path: '/' });
}	
	jQuery(function($)
	{
 	  $("body").attr('id','majime');        
});
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap majime secondary bounty">
  <div class="container">
    <div class="contents index">
      <div class="mainBox detail">
        <div class="pageTtl">
          <h2>懸賞金付き募集コンテンツ</h2>
         <a href="<?php echo Yii::app()->baseUrl;?>/majime/index" class="btn btn-important">
            <i class="icon-home icon-white"></i>マジメのTopへ戻る
          </a>
		  <?php if(FunctionCommon::isPostFunction("bounty")==true):?>
			 <a href="<?php echo Yii::app()->baseUrl;?>/majimebounty/regist" class="btn btn-edit">
				<i class="icon-pencil icon-white"></i>登録
			  </a>
		  <?php endif; ?>	  
        </div>
        <div class="box">
          <!--p class="descriptionTxt"></p-->
          <table width="724" border="0" class="table topics font14">
            <thead>
              <tr>
                <th>登録日付</th>
                <th>タイトル</th>
                <th>締め切り日</th>
                <th>応募数</th>
              </tr>
            </thead>
			<?php if(!is_null($model)): ?>
				<?php foreach($model as $bounty): ?>
				<tr>
				  <td class="td-date alnC txtRed">
					<?php echo FunctionCommon::formatDate($bounty->created_date); ?>
				  </td>
				  <td class="td-title">
					<span class="txtB">
						<?php if(!is_null($bounty->adopted_flag) && $bounty->adopted_flag== 1): ?>
							<?php echo CHtml::link(htmlspecialchars($bounty->title),array('majimebounty/detailado','id'=>$bounty->id)); ?>
						<?php else :?>
							<?php echo CHtml::link(htmlspecialchars($bounty->title),array('majimebounty/detail','id'=>$bounty->id)); ?>
						<?php endif ;?>
					</span>
				  </td>
				  <td class="td-deadline">
						<?php echo FunctionCommon::formatDate($bounty->deadline); ?>
				  </td>
				  <td class="td-posts">
						<?php echo Yii::app()->db->createCommand('SELECT COUNT(*) FROM bounty_apply WHERE bounty_id='.$bounty->id)->queryScalar(); ?>
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