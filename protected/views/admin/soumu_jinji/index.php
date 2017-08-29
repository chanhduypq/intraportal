
<script language="javascript">
from_jini= getCookie("from_jini");
if(from_jini !="" || from_jini ==null)
{
	 deleteCookies("from_jini", { path: '/' });
	 deleteCookies("category_id", { path: '/' });
	 deleteCookies("employee_name", { path: '/' });
	 deleteCookies("deadline_year", { path: '/' });
	 deleteCookies("deadline_month", { path: '/' });
	 deleteCookies("deadline_day", { path: '/' });
}
jQuery(function($) 
{        
	$("body").attr('id','admin');      
});
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap admin secondary soumu_jinji">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>総務からのお知らせ：人事</h2>
            		<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminsoumu_jinji/regist" class="btn btn-edit"><i class="icon-pencil icon-white"></i> 登録</a>
            	</div>
                <div class="box">
                
                <!--p class="descriptionTxt"></p-->
                  <?php echo CHtml::beginForm('', 'post', array('id' => 'index_frm')); ?>
                <table width="724" border="0" class="table list font14">
                	<thead>
	                	<tr>
	                		<th>投稿年月日</th>
	                		<th>更新年月日</th>
	                		<th>カテゴリー</th>
	                		<th>内容</th>
	                		<th>編集</th>
	                	</tr>
                	</thead>
                    
                	<tbody>
                		<?php
							 foreach ($soumu_jinji as $soumu) {
						?>
	                    <tr>
	                        <td class="td-date alnC txtRed postsDate"><?php echo FunctionCommon::formatDate($soumu['created_date']); ?></td>
	                        <td class="td-date alnC txtRed updateDate"><?php echo FunctionCommon::formatDate($soumu['last_updated_date']); ?></td>
	                        <td class="td-contents"><span>
							<?php 
								foreach ($category as $category_id) {
									if($soumu['category_id']==$category_id['id']){
										echo $category_id['category_name'];
									}
								}
							?>
                            </span></td>
	                        <td class="td-text">
								<p class="text">
									<?php echo FunctionCommon::url_henkan($soumu['employee_name'])?>
								</p>
							</td>
	                        <td class="td-edit">
                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminsoumu_jinji/edit/?id=<?php echo $soumu['id']; ?>" class="btn btn-work">修正</a>
                             <a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/adminsoumu_jinji/delete/?id=<?php echo $soumu['id']; ?>';" style="cursor:pointer;" class="btn btn-correct">削除</a></td>
                           
	                    </tr>
						<?php }?>
	                    
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
