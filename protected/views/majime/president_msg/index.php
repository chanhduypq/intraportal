
<script language="javascript">
jQuery(function($) {        
			$("body").attr('id','majime');      
		});
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap majime secondary president_msg">
    <div class="container">
        <div class="contents index">
            <div class="mainBox">
            	<div class="pageTtl">
					<h2>新井社長メッセージ</h2>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/majime/" class="btn btn-important">
						<i class="icon-home icon-white"></i> マジメのTopへ戻る
					</a>
				</div>
                <div class="box">
                    
                        <?php echo CHtml::beginForm('', 'post', array('id' => 'index_frm')); ?>
                        <table width="724" border="0" class="table topics font14">
                            <tbody>
                                <?php
                                if ($president_msgs != null && is_array($president_msgs) && count($president_msgs) > 0) {
                                    foreach ($president_msgs as $president_msg) {
                                        ?>        

                                        <tr>
                                            <td class="td-date alnC txtRed">
												<?php echo FunctionCommon::formatDate($president_msg['created_date']); ?>
											</td>
                                            <td class="td-text">
                                                <p class="text">   
                                                <?php
													if($president_msg['attachment1'] !=""){								   
													    $temp = explode(".", $president_msg['attachment1']);
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
													else if(isset($president_msg['attachment2'])){
													    $temp = explode(".", $president_msg['attachment2']);
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
													else if(isset($president_msg['attachment3'])){
													    $temp = explode(".", $president_msg['attachment3']);
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
                                                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/majimepresident_msg/detail/?id=<?php echo $president_msg['id']; ?>">
														<?php echo htmlspecialchars($president_msg['title']);?>
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
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>
    </div>
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>
</div>

