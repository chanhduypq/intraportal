<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css">
<script language="javascript">
hobby_itd = getCookie("hobby_itd_edit_from");
if(hobby_itd !="" || hobby_itd ==null)
{ 
	deleteCookies("hobby_itd_edit_from" , { path: '/' });
	deleteCookies("hobby_itd_edit_title" , { path: '/' });
	deleteCookies("hobby_itd_edit_content" , { path: '/' });
	deleteCookies("hobby_itd_edit_attachment1_checkbox_for_deleting" , { path: '/' });
	deleteCookies("hobby_itd_edit_attachment2_checkbox_for_deleting" , { path: '/' });
	deleteCookies("hobby_itd_edit_attachment3_checkbox_for_deleting" , { path: '/' });
	deleteCookies("hobby_itd_edit_eye_catch_checkbox_for_deleting" , { path: '/' });
 } 

jQuery(function($) {        
			$("body").attr('id','admin');      
		});
</script>
<input type="hidden" id="page_count" value="<?php  echo $pages->getPageCount();?>"/>
<div class="wrap admin secondary hobby_itd">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>趣味・サークル広場サークル紹介</h2></div>
                <div class="box">
                
                <!--p class="descriptionTxt"></p-->
                 <?php echo CHtml::beginForm('', 'post', array('id' => 'index_frm')); ?>
                <table width="724" border="0" class="table list font14">
                	<thead>
                		<tr><th>投稿年月日</th><th>更新年月日</th><th>タイトル</th><th>編集</th></tr>
                	</thead>
                    <?php
                    	if ($hobby_itds != null && is_array($hobby_itds) && count($hobby_itds) > 0) 
						{
							foreach ($hobby_itds as $hobby_itd) 
							{
                    ?>      
                    <tr>
                        <td class="td-date alnC txtRed postsDate"><?php echo FunctionCommon::formatDate($hobby_itd['created_date']); ?></td>
                        <td class="td-date alnC txtRed updateDate"><?php echo FunctionCommon::formatDate($hobby_itd['last_updated_date']); ?></td>
                        <td class="td-text">
                        <p class="text"><a href="<?php echo Yii::app()->request->baseUrl; ?>/adminhobby_itd/detail/?id=<?php echo $hobby_itd['id']; ?>"><?php echo htmlspecialchars($hobby_itd['title']);?></a></p>
                        </td>
                        <td class="td-edit">
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminhobby_itd/edit/?id=<?php echo $hobby_itd['id']; ?>" class="btn btn-work">修正</a>
                        
                        <a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/adminhobby_itd/delete/?id=<?php echo $hobby_itd['id']; ?>';" href="#" class="btn btn-correct">削除</a></td>
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