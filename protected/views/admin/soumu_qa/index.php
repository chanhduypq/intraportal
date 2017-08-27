<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<script language="javascript">
soumu_qa= getCookie("soumu_qa_edit_from");
 if(soumu_qa !="" || soumu_qa ==null)
 { 
	deleteCookies("soumu_qa_edit_from", { path: '/' });
	deleteCookies("soumu_qa_edit_category_id", { path: '/' });
	deleteCookies("soumu_qa_edit_title", { path: '/' });
	deleteCookies("soumu_qa_edit_content", { path: '/' });
	deleteCookies("soumu_qa_edit_attachment1_checkbox_for_deleting", { path: '/' });
	deleteCookies("soumu_qa_edit_attachment2_checkbox_for_deleting", { path: '/' });
	deleteCookies("soumu_qa_edit_attachment3_checkbox_for_deleting", { path: '/' });
 }
 soumu_qa1= getCookie("soumu_qa_regist_from");
 if(soumu_qa1 !="" || soumu_qa1 ==null)
 {  
	deleteCookies("soumu_qa_regist_from", { path: '/' });
	deleteCookies("soumu_qa_regist_category_id", { path: '/' });
	deleteCookies("soumu_qa_regist_title", { path: '/' });
	deleteCookies("soumu_qa_regist_content", { path: '/' });
	deleteCookies("soumu_qa_regist_attachment1_checkbox_for_deleting", { path: '/' });
	deleteCookies("soumu_qa_regist_attachment2_checkbox_for_deleting", { path: '/' });
	deleteCookies("soumu_qa_regist_attachment3_checkbox_for_deleting", { path: '/' });
 }
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap admin secondary soumu_qa" id="admin">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>教えて総務さん！FAQ</h2>
                    <a href="<?php echo Yii::app()->baseUrl;?>/adminsoumu_qa/regist" class="btn btn-important">
					   <i class="icon-pencil icon-white"></i> 登録
                    </a>
                    <a href="<?php echo Yii::app()->baseUrl;?>/adminsoumu_qa/categories/" class="btn btn-important">
					   <i class="icon-pencil icon-white"></i>  カテゴリー管理
                    </a>
             	</div>
                <div class="box">
                
                <!--p class="descriptionTxt"></p-->
                
                <table width="724" border="0" class="table list font14">
                	<thead>
	                	<tr>
	                		<th>投稿年月日</th>
	                		<th>更新年月日</th>
	                		<th>カテゴリー</th>
	                		<th>タイトル</th>
	                		<th>編集</th>
	                	</tr>
                	</thead>
                	<?php if($model != null): ?>
					<?php foreach($model as $soumu_qa): ?>
	                    <tr>
	                        <td class="td-date alnC txtRed postsDate">
                                <?php echo FunctionCommon::formatDate($soumu_qa->created_date); ?>
                            </td>
	                        <td class="td-date alnC txtRed updateDate">
                                <?php echo FunctionCommon::formatDate($soumu_qa->last_updated_date); ?>
                            </td>
	                        <td class="td-contents">
                                <span>
                                   <?php 
								    foreach ($category as $category_type){
										if($soumu_qa->category_id == $category_type['id']){
											echo htmlspecialchars($category_type['category_name']);
											}                                     
                                }
						        ?>
                                </span>
                            </td>
	                        <td class="td-text">
                                <?php echo CHtml::link(htmlspecialchars($soumu_qa->title),array('adminsoumu_qa/detail','id'=>$soumu_qa->id)); ?>
                            </td>
	                        <td class="td-edit">
                                <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminsoumu_qa/edit/?id=<?php echo $soumu_qa->id; ?>" class="btn btn-work">修正</a>
								<a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/adminsoumu_qa/delete/?id=<?php echo $soumu_qa->id; ?>';" href="#" class="btn btn-correct">削除</a>
                            </td>
	                    </tr>
                     <?php endforeach; ?>
				    <?php endif; ?>

	                    
                </table>

                <div class="pagination">
                    <?php $this->widget('ext.Pagination.Base', array('CPaginationObject' => $pages)); ?>
                </div>
                
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