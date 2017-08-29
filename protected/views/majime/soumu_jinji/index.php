
<script language="javascript">
jQuery(function($) {        
			$("body").attr('id','majime');      
		});
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap majime secondary soumu_jinji">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>総務からのお知らせ：人事情報</h2><a href="<?php echo Yii::app()->request->baseUrl; ?>/majime/" class="btn btn-important"><i class="icon-home icon-white"></i> マジメのTopへ戻る</a></div>
                <div class="box">
                 <?php echo CHtml::beginForm('', 'post', array('id' => 'index_frm')); ?>
                    <table width="724" border="0" class="table font14">
                    <?php
							 foreach ($soumu_jinji as $soumu) {
					?>
                    	<tr>
							<td class="td-date alnC txtRed">
							<?php echo FunctionCommon::formatDate($soumu['achive_date']); ?>
                            </td>
                            <td class="td-type">
                           
							<?php 
								foreach ($category as $category_id) {
									if($soumu['category_id']==$category_id['id']){
										
										if($category_id['category_name']=='入社'){
							?>				
                            			 <span class="ico joined">
											<?php echo htmlspecialchars($category_id['category_name']);?>
										</span>
                            <?php				
										}
										else if($category_id['category_name']=='異動'){
											
							?>
                           				 <span class="ico transfer">
											<?php echo htmlspecialchars($category_id['category_name']);?>
										</span>
                            <?php				
										}
										else{
							?>
                            			<span class="ico resignation">
											<?php echo htmlspecialchars($category_id['category_name']);?>
										</span>
                            <?php				
											}
											
											
									}
								}
							?>
                            </td>
                            <td class="td-name">
								<?php echo FunctionCommon::url_henkan($soumu['employee_name'])?>
							</td>
                           
                        </tr>    
					<?php	
					}
					?> 
                    </table>
                    <?php $this->widget('ext.Pagination.Base', array('CPaginationObject' => $pages,)); ?>      
                 	<?php echo CHtml::endForm(); ?>   
                </div><!-- /box -->
            </div><!-- /mainBox -->
            
        </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div><!-- /wrap -->