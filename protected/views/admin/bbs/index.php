<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css">
<script language="javascript">
bbs = getCookie("bbs_edit_from");
if(bbs !="" || bbs ==null)
{  
	deleteCookies("bbs_edit_from" , { path: '/' });
	deleteCookies("bbs_edit_title" , { path: '/' });
	deleteCookies("bbs_edit_content" , { path: '/' });
	deleteCookies("bbs_edit_attachment1_checkbox_for_deleting" , { path: '/' });
	deleteCookies("bbs_edit_attachment2_checkbox_for_deleting" , { path: '/' });
	deleteCookies("bbs_edit_attachment3_checkbox_for_deleting" , { path: '/' });
 }
jQuery(function($) {        
			$("body").attr('id','admin');      
		});
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap admin secondary bbs">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>ニューギン掲示板</h2></div>
                <div class="box">
                
                <!--p class="descriptionTxt"></p-->
                 <?php echo CHtml::beginForm('', 'post', array('id' => 'index_frm')); ?>
                <table width="724" border="0" class="table list font14">
                	<thead><tr><th>投稿年月日</th><th>更新年月日</th><th>タイトル</th><th>編集</th></tr></thead>
                    <?php
                    	if ($bbss != null && is_array($bbss) && count($bbss) > 0) 
						{
							foreach ($bbss as $bbs) 
							{
                    ?>      
                    <tr>
                        <td class="td-date alnC txtRed postsDate"><?php echo FunctionCommon::formatDate($bbs['created_date']); ?></td>
                        <td class="td-date alnC txtRed updateDate"><?php echo FunctionCommon::formatDate($bbs['last_updated_date']); ?></td>
                        <td class="td-text">
                        <p class="text">
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminbbs/detail/?id=<?php echo $bbs['id']; ?>">
								<?php echo htmlspecialchars($bbs['title']);?>
							</a>
						</p>
                        </td>
                        <td class="td-edit">
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminbbs/edit/?id=<?php echo $bbs['id']; ?>" class="btn btn-work">修正</a>
                        
                        <a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/adminbbs/delete/?id=<?php echo $bbs['id']; ?>';" href="#" class="btn btn-correct">削除</a></td>
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