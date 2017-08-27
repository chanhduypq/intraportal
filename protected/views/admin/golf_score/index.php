<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css">
<script language="javascript">
golf_score = getCookie("golf_score_edit_from");
if(golf_score !="" || golf_score ==null)
{ 
	deleteCookies("golf_score_edit_from" , { path: '/' });
	deleteCookies("golf_score_edit_score" , { path: '/' });
	deleteCookies("golf_score_edit_score_name" , { path: '/' });
	deleteCookies("golf_score_edit_deadline_year" , { path: '/' });
	deleteCookies("golf_score_edit_deadline_month" , { path: '/' });
	deleteCookies("golf_score_edit_deadline_day" , { path: '/' });
} 
jQuery(function($)
 {        
			$("body").attr('id','admin');      
});
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap admin secondary golf_score">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>ゴルフもマジメ！年間スコアランキング</h2>
            		<a href="/admingolf_score/deleteall" style="cursor:pointer" class="btn btn-work" id="delete_all" onclick="return confirm('全てのスコアを削除してもよろしいでしょうか。');"><i class="icon-trash icon-white"></i> すべて破棄</a>
            	</div>
                <div class="box">
                
                <!--p class="descriptionTxt"></p-->
                  <?php echo CHtml::beginForm('', 'post', array('id' => 'index_frm')); ?>
                <table width="724" border="0" class="table list font14">
                	<thead>
	                	<tr>
	                		<th>投稿年月日</th>
	                		<th>更新年月日</th>
	                		<th>スコア</th>
                            <th>お名前</th>
	                		<th>コース名・日付</th>
	                		<th>編集</th>
	                	</tr>
                	</thead>
                    
                	<tbody>
                		<?php
							
							
							 foreach ($golf_scores as $soumu2) 
							 {
								 foreach ($golf_scores2 as $soumu) 
							 		{
										if($soumu2['score']==$soumu['score']){
										$arrUser = FunctionCommon::getInforUser_golf_score($soumu['contributor_id']);
						?>
	                    <tr>
	                        <td class="td-date alnC txtRed postsDate">
								<?php echo FunctionCommon::formatDate($soumu['created_date']); ?>
							</td>
	                        <td class="td-date alnC txtRed updateDate">
								<?php echo FunctionCommon::formatDate($soumu['last_updated_date']); ?>
							</td>
                            <td class="td-score"><?php echo ($soumu['score']); ?></td>
                            <td class="td-score">
                            	<?php echo (!empty($arrUser['lastname']) ? $arrUser['lastname'] : null) ?>
                                                &nbsp;
                                <?php echo (!empty($arrUser['firstname']) ? $arrUser['firstname'] : null) ?>
                            </td>
                            <td class="td-couse">
	                        	<ul class="inline">
	                        		<li class="name"><?php echo ($soumu['score_name']); ?></li>
	                        		<li class="date">
										<?php echo FunctionCommon::formatDate($soumu['score_date']); ?>
									</li>
	                        	</ul>
	                        </td>
	                        <td class="td-edit">
                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/admingolf_score/edit/?id=<?php echo $soumu['id']; ?>" class="btn btn-work">修正</a>
                            <a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/admingolf_score/delete/?id=<?php echo $soumu['id']; ?>';" style="cursor:pointer;" class="btn btn-correct">削除</a>
							</td>
                           
	                    </tr>
						<?php }}} ?>
	                    
                    </tbody>
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
