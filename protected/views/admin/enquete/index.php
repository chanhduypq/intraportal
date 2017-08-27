<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
enquete = getCookie("enquete_edit_from");
if(enquete !="" || enquete ==null)
{ 	
	deleteCookies("enquete_edit_from" , { path: '/' });  
	deleteCookies("enquete_edit_title" , { path: '/' });   
	deleteCookies("enquete_edit_content" , { path: '/' });
	deleteCookies("enquete_edit_comment" , { path: '/' });
	deleteCookies("enquete_edit_deadline_year" , { path: '/' });
	deleteCookies("enquete_edit_deadline_month" , { path: '/' }); 
	deleteCookies("enquete_edit_deadline_day" , { path: '/' });
	deleteCookies("enquete_edit_answer_type" , { path: '/' });
	deleteCookies("enquete_edit_attachment1_checkbox_for_deleting" , { path: '/' });
	deleteCookies("enquete_edit_attachment2_checkbox_for_deleting" , { path: '/' });
	deleteCookies("enquete_edit_attachment3_checkbox_for_deleting" , { path: '/' });
	deleteCookies("loaddata_edit" , { path: '/' });
}
	 jQuery(function($) {
        $("body").attr('id','admin');        
  });
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div id="admin" class="wrap admin secondary enquete">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>みんなのアンケートBOX</h2></div>
                <div class="box">
                
                <!--p class="descriptionTxt"></p-->
                
                <table border="0" width="724" class="table list font14">
                	 <thead>
                            <tr class="header_rs">
                                <th>投稿年月日</th>
                                <th>更新年月日</th>
                                <th>状態</th>
                                <th>タイトル</th>
                                <th>編集</th>
                            </tr>
                    </thead>     
                    <tbody>      
                     <?php 
                        $now = strtotime(date('Y/m/d'));
                        foreach ($enquetes as $enquete) { 
                            $dealine = strtotime(date('Y/m/d', strtotime($enquete['deadline'])));
                            if ($now < $dealine) {
                                
                                    $label = '開催中'; 
                                }
                                if ($now == $dealine) {
                                  
                                    $label = '最終日';
                                }
                                if ($now > $dealine) {
                                
                                   
                                    $label = '終了';
                                }
                      ?>
                    <tr>
                        <td class="td-date alnC txtRed postsDate"><?php echo FunctionCommon::formatDate($enquete['created_date']); ?></td>
                        <td class="td-date alnC txtRed updateDate"><?php echo FunctionCommon::formatDate($enquete['last_updated_date']); ?></td>
                        <td class="td-contents"><span><?php echo $label ?></span></td>
                        <td class="td-text">
                        <p class="text">
                            
                             <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminenquete/detail/?id=<?php echo $enquete['id']; ?>">
								<?php echo htmlspecialchars($enquete['title']); ?>
							</a>
                        </p>
                        </td>
                        <td class="td-edit">
                           
                             <a class="btn btn-work" href="<?php echo Yii::app()->request->baseUrl; ?>/adminenquete/edit/?id=<?php echo $enquete['id']; ?>">修正</a>
                            
                             <a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/adminenquete/delete/?id=<?php echo $enquete['id']; ?>';" href="#" class="btn btn-correct">削除</a>
                        </td>
                    </tr>
                    <?php } ?>
                   
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
            </div><!-- /sideBox -->
            
  </div><!-- /contents -->
        <p id="page-top" style="display: none;"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
</div>

</div>
