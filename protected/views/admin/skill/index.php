<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<script language="javascript">

  bbs = getCookie("skill_edit_from");
 if(bbs !="" || bbs ==null)
 {      
	 deleteCookies("skill_edit_from", { path: '/' });
	 deleteCookies("skill_edit_title", { path: '/' });
	 deleteCookies("skill_edit_category_id", { path: '/' });
	 deleteCookies("skill_edit_url", { path: '/' });
	 deleteCookies("skill_edit_comment", { path: '/' });
	 deleteCookies("skill_edit_attachment1_checkbox_for_deleting", { path: '/' });
	 deleteCookies("skill_edit_attachment2_checkbox_for_deleting", { path: '/' });
	 deleteCookies("skill_edit_attachment3_checkbox_for_deleting", { path: '/' });
 }
 
bbs1 = getCookie("skill_regist_from"); 
if(bbs1 !="" || bbs1 ==null){     

	 deleteCookies("skill_regist_from", { path: '/' });
	 deleteCookies("skill_regist_title", { path: '/' });
	 deleteCookies("skill_regist_category_id", { path: '/' });
	 deleteCookies("skill_regist_url", { path: '/' });
	 deleteCookies("skill_regist_comment", { path: '/' });   
	 deleteCookies("skill_regist_attachment1_checkbox_for_deleting", { path: '/' });
	 deleteCookies("skill_regist_attachment2_checkbox_for_deleting", { path: '/' });
	 deleteCookies("skill_regist_attachment3_checkbox_for_deleting", { path: '/' });
  }
  
jQuery(function($) {        
			$("body").attr('id','admin');      
		});
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap admin secondary skill">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
				<h2>資格取得・スキルアップ！</h2>
                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminskill/regist" class="btn btn-important">
						<i class="icon-pencil icon-white"></i> 登録
					</a>
            		<a href="<?php echo Yii::app()->request->baseUrl; ?>/admincategory/categories/?type=4" class="btn btn-important">
						<i class="icon-pencil icon-white"></i> カテゴリー管理
					</a>
                </div>    
                <div class="box">
                
                <!--p class="descriptionTxt"></p-->
                 <?php echo CHtml::beginForm('', 'post', array('id' => 'index_frm')); ?>
                <table width="724" border="0" class="table list font14">
                	 <thead>
	                	<tr>
	                		<th>登録年月日</th>
	                		<th>更新年月日</th>
	                		<th class="td-category">カテゴリー</th>
	                		<th class="td-title">タイトル</th>
	                		<th class="td-edit">編集</th>
						</tr>
					</thead>
                    <?php
                    	if ($skills != null && is_array($skills) && count($skills) > 0) 
						{
							foreach ($skills as $skill) 
							{
                    ?>      
                    <tr>
                        <td class="td-date alnC txtRed postsDate"><?php echo FunctionCommon::formatDate($skill['created_date']); ?></td>
                        <td class="td-date alnC txtRed updateDate"><?php echo FunctionCommon::formatDate($skill['last_updated_date']); ?></td>
                        <td class="td-category td-contents">
						<?php if(!is_null($skill['category_id']) && !empty($skill['category_id'])): ?>
							<?php $category = Yii::app()->db->createCommand()
												->select('*')
												->from('category')
												->where('id=:id', array(':id'=>$skill['category_id']))
												->queryRow(); ?>
						<span>
							<?php echo $category["category_name"];?>
                        </span>
						<?php endif; ?>
						</td>
                        <td class="td-title">
                       
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminskill/detail/?id=<?php echo $skill['id']; ?>">
							<?php echo htmlspecialchars($skill['title']); ?>
							</a>
						
                        </td>
                        <td class="td-edit">
                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminskill/edit/?id=<?php echo $skill['id']; ?>" class="btn btn-work">修正</a>
                        
                        <a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/adminskill/delete/?id=<?php echo $skill['id']; ?>';" href="#" class="btn btn-correct">削除</a></td>
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