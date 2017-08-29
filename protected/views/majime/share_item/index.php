
<script language="javascript">
jQuery(function($) {        
			$("body").attr('id','majime');      
		});
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap majime secondary share_item">
    <div class="container">
        <div class="contents index">
            <div class="mainBox detail">
                <div class="pageTtl"><h2>共有事項</h2><a class="btn btn-important" href="<?php echo Yii::app()->baseUrl?>/majime/"><i class="icon-home icon-white"></i> マジメのTopへ戻る</a>
                
               </div>
                <div class="box">
                    <div class="cnt-box">
                        <?php echo CHtml::beginForm('', 'post', array('id' => 'index_frm')); ?>
                        <table width="724" border="0" class="table topics font14">
                            <tbody>
                                <?php
                                if ($share_items != null && is_array($share_items) && count($share_items) > 0) {
                                    foreach ($share_items as $share_item) {
                                        ?>        

                                        <tr>
                                            <td class="td-date alnC txtRed">
												<?php echo FunctionCommon::formatDate($share_item['created_date']); ?>
											</td>
                                            <td class="td-text">
                                                <p class="text">   
                                                <?php
													if($share_item['attachment1'] !=""){								   
													    $temp = explode(".", $share_item['attachment1']);
														$attachment1_ext = $temp[count($temp) - 1];
														$data[1] = strtolower($attachment1_ext);
													   switch ($data[1]) 
													   {
															case "zip":
																$ico = "ico_zip";
																break;
															case "rar":
																$ico = "ico_zip";
																break;
															case "doc":
																$ico = "ico_word";
																break;
															case "docx":
																$ico = "ico_word";
																break;	
															case "xls":
																$ico = "ico_excel";
																break;	
															case "xlsx":
																$ico = "ico_excel";
																break;	
															case "ppt":
																$ico = "ico_ppt";
																break;	
															case "pptx":
																$ico = "ico_ppt";
																break;	
															case "pdf":
																$ico = "ico_pdf";
																break;	
															default:
																$ico = "";		
															}
													}
													else if(isset($share_item['attachment2'])){
													    $temp = explode(".", $share_item['attachment2']);
														$attachment2_ext = $temp[count($temp) - 1];
														$data[1] = strtolower($attachment2_ext);
													   switch ($data[1]) 
													   {
															case "zip":
																$ico = "ico_zip";
																break;
															case "rar":
																$ico = "ico_zip";
																break;
															case "doc":
																$ico = "ico_word";
																break;
															case "docx":
																$ico = "ico_word";
																break;	
															case "xls":
																$ico = "ico_excel";
																break;	
															case "xlsx":
																$ico = "ico_excel";
																break;	
															case "ppt":
																$ico = "ico_ppt";
																break;	
															case "pptx":
																$ico = "ico_ppt";
																break;	
															case "pdf":
																$ico = "ico_pdf";
																break;	
															default:
																$ico = "";		
															}
													}
													else if(isset($share_item['attachment3'])){
													    $temp = explode(".", $share_item['attachment3']);
														$attachment3_ext = $temp[count($temp) - 1];
														$data[1] = strtolower($attachment3_ext);	
													   switch ($data[1]) 
													   {
															case "zip":
																$ico = "ico_zip";
																break;
															case "rar":
																$ico = "ico_zip";
																break;
															case "doc":
																$ico = "ico_word";
																break;
															case "docx":
																$ico = "ico_word";
																break;	
															case "xls":
																$ico = "ico_excel";
																break;	
															case "xlsx":
																$ico = "ico_excel";
																break;	
															case "ppt":
																$ico = "ico_ppt";
																break;	
															case "pptx":
																$ico = "ico_ppt";
																break;	
															case "pdf":
																$ico = "ico_pdf";
																break;	
															default:
																$ico = "";		
															}
													}
													else { $ico ="";}
													
													if($ico!=""){
														echo "<span class='".$ico."'>&nbsp;</span>";
														}
													else{}	
												?>                                  
                                                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/majimeshare_item/detail/?id=<?php echo $share_item['id']; ?>">
														<?php echo htmlspecialchars($share_item['title']);?>
													</a>
                                                </p>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                         <?php $this->widget('ext.Pagination.Base', array('CPaginationObject' => $pages)); ?>
                         <?php echo CHtml::endForm(); ?>

                    </div>
                </div>

            </div>
        </div>
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>
    </div>
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>
</div>

