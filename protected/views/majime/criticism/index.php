<link href="<?php echo $this->assetsBase; ?>/css/majime/css/secondary.css" rel="stylesheet" type="text/css"/>
<script language="javascript">
criticism = getCookie("criticism_regist_from");
if(criticism !="" || criticism ==null)
{
	deleteCookies("criticism_regist_from", { path: '/' });
	deleteCookies("criticism_regist_title", { path: '/' });
	deleteCookies("criticism_regist_content", { path: '/' });
	deleteCookies("criticism_regist_attachment1_checkbox_for_deleting", { path: '/' });
	deleteCookies("criticism_regist_attachment2_checkbox_for_deleting", { path: '/' });
	deleteCookies("criticism_regist_attachment3_checkbox_for_deleting", { path: '/' });
}
jQuery(function($) {        
			$("body").attr('id','majime');      
		});
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap majime secondary criticism">
    <div class="container">
        <div class="contents index">
            <div class="mainBox detail">
                <div class="pageTtl"><h2>機種総評＆検証</h2><a class="btn btn-important" href="<?php echo Yii::app()->baseUrl?>/majime/"><i class="icon-home icon-white"></i> マジメのTopへ戻る</a>
                <?php  if(FunctionCommon::isPostFunction("criticism")==true):?>
				 <a class="btn btn-edit" href="<?php echo Yii::app()->baseUrl?>/majimecriticism/regist">
					<i class="icon-pencil icon-white"></i> 登録
				</a>
				<?php endif ;?>
               </div>
                <div class="box">
                    <div class="cnt-box">
                        <?php echo CHtml::beginForm('', 'post', array('id' => 'index_frm')); ?>
                        <table width="724" border="0" class="table topics font14">
                            <tbody>
                                <?php
                                if ($criticisms != null && is_array($criticisms) && count($criticisms) > 0) {
                                    foreach ($criticisms as $criticism) {
                                        ?>        

                                        <tr>
                                            <td class="td-date alnC txtRed">
												<?php echo FunctionCommon::formatDate($criticism['created_date']); ?>
											</td>
                                            <td class="td-text">
                                                <p class="text">   
                                                <?php
													if($criticism['attachment1'] !=""){								   
													    $temp = explode(".", $criticism['attachment1']);
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
													else if(isset($criticism['attachment2'])){
													    $temp = explode(".", $criticism['attachment2']);
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
													else if(isset($criticism['attachment3'])){
													    $temp = explode(".", $criticism['attachment3']);
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
                                                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/majimecriticism/detail/?id=<?php echo $criticism['id']; ?>">
														<?php echo htmlspecialchars($criticism['title']);?>
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

