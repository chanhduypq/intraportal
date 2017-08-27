<link href="<?php echo $this->assetsBase; ?>/css/asobi/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase;?>/css/common/css/pride.css" rel="stylesheet" type="text/css">
<script language="javascript">
pride_regist_from = getCookie("pride_regist_title");
if(pride_regist_from !="" || pride_regist_from ==null)
{ 
	deleteCookies("pride_regist_icon", { path: '/' });
	deleteCookies("pride_regist_from", { path: '/' });
	deleteCookies("pride_regist_title", { path: '/' });
	deleteCookies("pride_regist_content", { path: '/' });
	deleteCookies("pride_regist_attachment1_checkbox_for_deleting", { path: '/' });
	deleteCookies("pride_regist_attachment2_checkbox_for_deleting", { path: '/' });
	deleteCookies("pride_regist_attachment3_checkbox_for_deleting", { path: '/' });
}
jQuery(function($) {        
			$("body").attr('id','asobi');      
		});
</script>
<div class="wrap majime secondary pride">
    <div class="container">
        <div class="contents index">
            <div class="mainBox">
                <div class="pageTtl"><h2>あそびにマジメ！？あそび自慢＆対決！</h2><a class="btn btn-important" href="<?php echo Yii::app()->baseUrl?>/asobi/"><i class="icon-home icon-white"></i> あそびのTopへ戻る</a>
                <?php
                if(FunctionCommon::isPostFunction("pride")==true){
				?>
				  <a class="btn btn-important" href="<?php echo Yii::app()->baseUrl?>/asobipride/regist"><i class="icon-pencil icon-white"></i> 登録</a>
				<?php
				}
				?>
               
                </div>
                <div class="box">
                	
                    <table width="724" border="0" class="table list font14">
                		<thead>
                			<tr>
                				<th class="td-date">日付</th>
                				<th class="td-icon"></th>
                				<th class="td-text">タイトル</th>
                			</tr>
                		</thead>
                   		  <?php
                                if ($ide != null && is_array($ide) && count($ide) > 0) 
								{
                                    foreach ($ide as $pride) 
									{
                         ?>      
                        <tr>
                            <td class="td-date alnC txtRed"><?php echo FunctionCommon::formatDate($pride['created_date']); ?></td>
                            <td class="td-icon"><span class="pride-icon pride-icon-prize0<?php echo $pride['icon']?>">icon0<?php echo $pride['icon']?></span></td>
                            <td class="td-text">
	                            <p class="text"><a href="<?php echo Yii::app()->request->baseUrl; ?>/asobipride/detail/?id=<?php echo $pride['id']; ?>"><?php echo htmlspecialchars($pride['title'])?></a></p>
	                            <div class="evaluate">
	                                <p class="comment">コメント数（
                                    <?php
											     $i = 0; 
                                                                                             $count=0;
												 $rating = 0;
												 foreach ($pride_comments as $comment) {
													 if($pride['id']==$comment['pride_id']){ 
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

