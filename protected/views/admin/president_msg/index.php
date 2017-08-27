<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<script language="javascript">
    
bbs = getCookie("president_msg_edit_from");
if(bbs !="" || bbs ==null)
{ 
	 deleteCookies("president_msg_edit_from", { path: '/' });
	 deleteCookies("president_msg_edit_title", { path: '/' });
	 deleteCookies("president_msg_edit_content", { path: '/' });
	 deleteCookies("president_msg_edit_attachment1_checkbox_for_deleting", { path: '/' });
	 deleteCookies("president_msg_edit_attachment2_checkbox_for_deleting", { path: '/' });
	 deleteCookies("president_msg_edit_attachment3_checkbox_for_deleting", { path: '/' });
}
bbs1 = getCookie("president_msg_regist_from"); 
if(bbs1 !="" || bbs1 ==null)
{ 
	 deleteCookies("president_msg_regist_from", { path: '/' });
	 deleteCookies("president_msg_regist_title", { path: '/' });
	 deleteCookies("president_msg_regist_content", { path: '/' });
	 deleteCookies("president_msg_regist_attachment1_checkbox_for_deleting", { path: '/' });
	 deleteCookies("president_msg_regist_attachment2_checkbox_for_deleting", { path: '/' });
	 deleteCookies("president_msg_regist_attachment3_checkbox_for_deleting", { path: '/' });
  }
jQuery(function($) {        
			$("body").attr('id','admin');      
		});
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap admin secondary president_msg">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>新井社長メッセージ</h2><a href="<?php echo Yii::app()->request->baseUrl; ?>/adminpresident_msg/regist" class="btn btn-edit"><i class="icon-pencil icon-white"></i> 登録</a></div>
                <div class="box">
                
                <!--p class="descriptionTxt"></p-->
                 <?php echo CHtml::beginForm('', 'post', array('id' => 'index_frm')); ?>
                <table width="724" border="0" class="table list font14">
                	 <thead><tr><th>投稿年月日</th><th>更新年月日</th><th>タイトル</th><th>編集</th></tr></thead>
                    <?php
                    	if ($president_msgs != null && is_array($president_msgs) && count($president_msgs) > 0) 
						{
							foreach ($president_msgs as $president_msg) 
							{
                    ?>      
                    <tr>
                        <td class="td-date alnC txtRed postsDate"><?php echo FunctionCommon::formatDate($president_msg['created_date']); ?></td>
                        <td class="td-date alnC txtRed updateDate"><?php echo FunctionCommon::formatDate($president_msg['last_updated_date']); ?></td>
                        <td class="td-text">
                        <p class="text">
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminpresident_msg/detail/?id=<?php echo $president_msg['id']; ?>">
							<?php echo htmlspecialchars($president_msg['title']); ?>
							</a>
						</p>
                        </td>
                        <td class="td-edit">
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminpresident_msg/edit/?id=<?php echo $president_msg['id']; ?>" class="btn btn-work">修正</a>
                        
                        <a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/adminpresident_msg/delete/?id=<?php echo $president_msg['id']; ?>';" href="#" class="btn btn-correct">削除</a></td>
                    </tr>
                   <?php
							}
						}
					?> 
                </table>
                    <?php $this->widget('ext.Pagination.Base', array('CPaginationObject' => $pages)); ?>
                	<?php echo CHtml::endForm(); ?>
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