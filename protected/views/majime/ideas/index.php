<link href="<?php echo $this->assetsBase; ?>/css/majime/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase;?>/css/common/css/ideas.css" rel="stylesheet" type="text/css">
<script language="javascript">
ideas = getCookie("ideas_regist_from");
if(ideas !="" || ideas ==null)
{
	deleteCookies("ideas_regist_from", { path: '/' });
	deleteCookies("ideas_regist_title", { path: '/' });
	deleteCookies("ideas_regist_content", { path: '/' });
	deleteCookies("ideas_regist_attachment1_checkbox_for_deleting", { path: '/' });
	deleteCookies("ideas_regist_attachment2_checkbox_for_deleting", { path: '/' });
	deleteCookies("ideas_regist_attachment3_checkbox_for_deleting", { path: '/' });
}
jQuery(function($) {        
			$("body").attr('id','majime');      
		});
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap majime secondary ideas">
    <div class="container">
        <div class="contents index">
            <div class="mainBox detail">
                <div class="pageTtl"><h2>製品アイデア投稿広場</h2><a class="btn btn-important" href="<?php echo Yii::app()->baseUrl?>/majime/"><i class="icon-home icon-white"></i> マジメのTopへ戻る</a>
					<?php if(FunctionCommon::isPostFunction("ideas")==true):?>
					  <a class="btn btn-edit" href="<?php echo Yii::app()->baseUrl?>/majimeideas/regist">
						<i class="icon-pencil icon-white"></i> 登録
					</a>
					<?php endif; ?>
                </div>
                <div class="box">
                	 <p class="descriptionTxt">
						機種開発や業務の改善、創意工夫など。
						<br/>自由に意見を投稿して相互評価しましょう！
					</p>
                     <table width="724" border="0" class="table topics font14">
                   		  <?php
                                if ($ide != null && is_array($ide) && count($ide) > 0) 
								{
                                    foreach ($ide as $ideas) 
									{
                         ?>      
                        <tr>
                            <td class="td-date alnC txtRed">
								<?php echo FunctionCommon::formatDate($ideas['created_date']); ?>
							</td>
                            <td class="td-text">
	                            <p class="text">
									<a href="<?php echo Yii::app()->request->baseUrl; ?>/majimeideas/detail/?id=<?php echo $ideas['id']; ?>">
										<?php echo htmlspecialchars($ideas['title']);?>
									</a>
								</p>
	                            <div class="evaluate">
	                                <p class="comment">コメント数（
                                    <?php
											     $i = 0; 
                                                                                             $count=0;
												 $rating = 0;
												 foreach ($ideas_comments as $comment) {
													 if($ideas['id']==$comment['ideas_id']){ 
                                                                                                             if($comment['valuation']>0){
                                                                                                                 $count++;
                                                                                                             }
													 
													 $i = $i+1;
													 $rating = $comment['valuation']+ $rating;
													 
													 } 
												 }
												 echo $i;
									?>
                                    ）</p>
	                                <p class="rating"> 現在の評価：
                                     <?php 
									 	if($i!=0){
                                                                                    if($count>0){
                                                                                        $average = $rating/$count;
                                                                                    }
                                                                                    else{
                                                                                        $average='0';
                                                                                    }
											
											$average = substr($average, 0, 3);
											if($average==0){$star = "star0"; $average=0;}
											else if($average > 0 && $average <= '1.5'){ $star = "star1";}
											else if($average > '1.5' && $average <= '2.5'){ $star = "star2";}
											else if($average > '2.5' && $average <= '3.5'){ $star = "star3";}
											else if($average > '3.5' && $average <= '4.5'){ $star = "star4";}
											else if($average > '4.5' ){ $star = "star5";}
										}
										else {$star = "star0"; $average=0;}
										//echo '<span class="star '.$star.'"></span>';
									?>
                                            <?php
                            if($star!='star0'){                                             
										?>
                                        <span class="star <?php echo $star?>"></span>(<?php echo $average?>)
                                        <?php
                                                   }
                                                   else{?>
                                        <span>未評価</span>
                                                       <?php
                                                       
                                                   }
                                                   ?>
                                    
                                        </p>
	                                
	                            </div>
                            </td>
                        </tr>
                      <?php 
					  			}
					 		 }
					  ?> 
                    </table>    
                        <?php $this->widget('ext.Pagination.Base', array('CPaginationObject' => $pages)); ?>
                </div>

            </div>
        </div>
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>
    </div>
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>
</div>

