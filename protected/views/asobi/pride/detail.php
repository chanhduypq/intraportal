<link href="<?php echo $this->assetsBase; ?>/css/common/css/pride.css" rel="stylesheet" type="text/css">
<link href="<?php echo $this->assetsBase; ?>/css/asobi/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>
<script language="javascript">
jQuery(function($) {        
			$("body").attr('id','asobi');      
		});
</script>
<?php $attachment1=$model->attachment1;?>
<?php $attachment2=$model->attachment2;?>
<?php $attachment3=$model->attachment3;?>
<?php $attachment1_ext=FunctionCommon::getExtensionFile($model->attachment1);?>
<?php $attachment2_ext=FunctionCommon::getExtensionFile($model->attachment2);?>
<?php $attachment3_ext=FunctionCommon::getExtensionFile($model->attachment3);?>
<div class="wrap asobi secondary pride" >
    <div class="container">
        <div class="contents detail">
            <div class="mainBox detail">
                <div class="pageTtl"><h2>あそびにマジメ！？あそび自慢＆対決！- 詳細</h2>
                	<?php 
					
					if(Yii::app()->request->cookies['page']!= "") 
					{
						   $page = "index?page=".Yii::app()->request->cookies['page'];
							
					}else {$page ="";}
					?>
                    <span><a class="btn btn-important" href="<?php echo Yii::app()->request->baseUrl; ?>/asobipride/<?php echo $page;?>"><i class="icon-chevron-left icon-white"></i> 一覧に戻る</a></span>
                    
                </div>
                <div class="box">
                    <div class="postsDate"><i class="icon-pencil"></i> 投稿日時：<span class="date"><?php echo FunctionCommon::formatDate($model->created_date); ?></span><span class="time"><?php echo FunctionCommon::formatTime($model->created_date); ?></span></div>
                    <div class="detailTtl">
                        <h3 class="ttl"><?php echo htmlspecialchars($model->title);?></h3>
                        <!--
                        <p class="area"><span class="city">名古屋店：</span><span class="name">山田&#12288;太郎</span></p>
                        -->
                        <p class="area">
                       		<?php 
								$arrUser = FunctionCommon::getInforUser($model->contributor_id);
								if(isset($arrUser)){ echo $arrUser; }
							?>
                        </p>
                    </div>
                    <span class="pride-icon pride-icon-prize0<?php echo $model->icon?>">icon0<?php echo $model->icon?></span>
                    <div class="evaluate">
                    	<?php
                        	 $i = 0; 
                                 $count=0;
							 $rating = 0;
							 $id = $model->id;
							 foreach ($pride_list_comments as $comment) {
								 if($id ==$comment['pride_id']){ 
                                                                     if($comment['valuation']>0){
                                                                         $count++;
                                                                     }
								 $i = $i+1;
								 $rating = $comment['valuation']+ $rating;
								 } 
							 }
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
						?>
                        <p class="rating"> 現在の評価： 
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
                        <p class="comment">コメント数:<?php echo $i;?></p>
                        <span class="clearfix"></span>
                    </div>
                    <p class="cnt-box"><?php echo nl2br(FunctionCommon::url_henkan($model->content));?></p>
                    <div class="photo">
                        <div class="imgbox">                            
                                  <?php 
                                   if(trim($attachment1)!="")
                                   {
                                         FunctionCommon::echoOldFile($attachment1_ext, 1, $model,"asobipride",$this->assetsBase);	
                                   }
                                   ?>
                        </div>
                        <div class="imgbox">
                                 <?php 
                                   if(trim($attachment2)!="")
                                   {
                                         FunctionCommon::echoOldFile($attachment2_ext, 2, $model,"asobipride",$this->assetsBase);
                                   }
                                   ?>
                        </div>
                        <div class="imgbox">
                                 <?php 
                                   if(trim($attachment3)!="")
                                   {
                                         FunctionCommon::echoOldFile($attachment3_ext, 3, $model,"asobipride",$this->assetsBase);
                                       
                                   }
                                   ?>
                        </div>
                    </div>   
                </div><!-- /box -->
                <div class="box">
                	<h3>コメント</h3>
					<?php
					
					$form = $this->beginWidget('CActiveForm', array(
										'id' => 'pride_comment_form',                     
										'htmlOptions' => array(
															  'class'=>'form-horizontal',
															  'onsubmit'=>'return false;',
															  ),
										 ));
					echo $form->hiddenField($model, 'id');			
					echo $form->hiddenField($model, 'last_updated_person');			
					?>
                    <input type="hidden" name="contributor_id" value="<?php echo Yii::app()->request->cookies['id'];?>">
                     <div class="control-group">
                                    <label class="control-label" for="title">コメント&nbsp;
                                     <span class="label label-warning">必須</span></label>
                                    <div class="controls">
                                        <?php echo $form->error($pride_comment, 'comment'); ?>
                                        <?php echo $form->textarea($pride_comment, 'comment', array('class' => 'input-xxlarge', 'rows' => 7)); ?>
                                    </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="title">評価&nbsp;</label>
                        <div class="controls">
                        	<?php 
								$array_rating = array(0=>'無し',1=>'★',2=>'★★',3=>'★★★',4=>'★★★★',5=>'★★★★★');
								echo $form->dropDownList($pride_comment,'valuation',$array_rating, array('class' => 'input-small')); ?>
                        </div>
                    </div>
                    <div class="form-last-btn">
                        <p class="btn170">
                        	 <?php
							 //if(FunctionCommon::isPostFunction("pride")==true){
							?>
									<button type="submit" class="btn btn-important"><i class="icon-chevron-right icon-white">　</i> 評価する</button>
							 <?php // }else{ ?>
									<!--<button disabled="disabled" type="submit" class="btn btn-important"><i class="icon-chevron-right icon-white">　</i> 評価する</button>-->
							 <?php //}?>       
		                  
	                    </p>
                    </div>                          
                    <?php $this->endWidget(); ?>                        
                    <h4 class="ttl">コメント履歴</h4>
					<ul class="comments">
                    	<?php
						   $i = 1;	
						   foreach ($pride_list_comments as $comment) {
						?>
								<li style="border-bottom: 1px #CCC dashed;padding-bottom: 10px;">
                                                                    <span class="badge badge-inverse">
								<?php echo $i;?>
							</span>
                                    <p class="comment"><?php echo nl2br(FunctionCommon::url_henkan($comment['comment']));?></p>
                                    <br/>
                                    <div class="rating">評価：
                                        <?php 
										$rating = $comment['valuation'];
										switch ($rating) 
										   {
												case "1":
													$star = "star1";
													break;
												case "2":
													$star = "star2";
													break;
												case "3":
													$star = "star3";
													break;	
												case "4":
													$star = "star4";
													break;	
												case "5":
													$star = "star5";
													break;	
												default:
													$star = "star0";
												}
                                                                                                if($star!='star0'){                                             
										?>
                                        <span class="star <?php echo $star;?>"></span>(<?php echo $rating;?>)</div>
                                        <?php
                                                   }
                                                   else{?>
                                        <span>未評価</span></div>
                                                       <?php
                                                       
                                                   }
                                                   ?>
										
                                        
                                    <div class="commenter">
                                        
                                        <div class="name"><?php
										 foreach ($user as $user_name) {
											 if($user_name['id']== $comment['contributor_id'])
											 {
										 		echo $user_name['lastname']." ".$user_name['firstname'];
											 }
										 }
										 ?></div>
                                        <div class="unit">
                                         <?php echo FunctionCommon::getUnitBranchBaseUser($comment['contributor_id']);?>
                                     </div>
                                        <div class="post-date">投稿日時：<?php echo FunctionCommon::formatDate($comment['created_date']); ?> <?php echo FunctionCommon::formatTime($comment['created_date']); ?></div>
                                    </div> 
                                </li>
						<?php
								$i++;	
							   }
							 
						?>
						
                    </ul>                      
				 </div><!-- Box -->
				 

            </div><!-- /mainBox -->
        </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>
    </div>
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>
</div>
<script type="text/javascript">   
        jQuery(function($){            
           $('button[type="submit"]').click(function(){ 
		   var ok = confirm('コメントを投稿します。よろしいですか？');  
		   if(ok ==true)
		   { 
		   			checkId();
					$.ajax({    
						type: "POST", 
						async:true,
						url: "<?php echo Yii::app()->baseUrl;?>/asobipride/detail/?id=<?php echo $model->id;?>",    
						data: jQuery('#pride_comment_form').serialize(),
						success: function(msg){	                        
								jQuery('#pride_comment_form input, #pride_comment_form textarea').prev().remove();
								if(msg!='[]'){
															data=$.parseJSON(msg);
															if(data.Pride_comment_comment){
																 div=document.createElement('div');
																 $(div).addClass('alert');
																 $(div).addClass('error_message');
																 $(div).html(data.Pride_comment_comment);
																 $(div).insertBefore($('#Pride_comment_comment')); 
															} 
								}							  															
							else{   
							
													$("#pride_comment_form").attr('action','<?php echo Yii::app()->baseUrl;?>/asobipride/detail/?id=<?php echo $model->id;?>');
													jQuery('#pride_comment_form').attr('onsubmit','return true;');
													jQuery('#pride_comment_form').submit();
													
												}					    			    
						}	  
					});
				  }	
			});    
				   errorDivs=jQuery('div.errorMessage');
					for(i=0,n=errorDivs.length;i<n;i++){
						if(jQuery(errorDivs[i]).html()!=""){                     
							jQuery(errorDivs[i]).addClass('alert');
							jQuery(errorDivs[i]).addClass('error_message');
						}
					}
		 
        });
		//check id
		function checkId()
		{
        jQuery.ajax({   
        type: "POST", 
                async:true,
                url: "<?php echo Yii::app()->baseUrl;?>/asobipride/checkId/",    
                data:{id:"<?php echo $model->id;?>",table:"pride"},
                success: function(msg){	  
                        if(msg=='0'){ 
                                window.location='<?php echo Yii::app()->baseUrl;?>/asobipride/index';
                        }
                }
        });
		}
</script>