
<link href="<?php echo $this->assetsBase; ?>/css/common/css/golf_news.css" rel="stylesheet" type="text/css"/>



<script type="text/javascript">
    jQuery(function($) {
        $("body").attr('id','admin');
        if($.trim($("div.picture").eq(0).html())!=""){
            $("div.picture").find('a').eq(0).css('cursor','default');
            $("div.picture").find('img').eq(0).css('cursor','pointer');
        }
    });
</script>
<div class="wrap admin secondary golf_news">
    <div class="container">
        <div class="contents detail">
            <div class="mainBox detail">
                <div class="pageTtl"><h2>ゴルフもマジメ！ - 詳細</h2>
                    <span><a class="btn btn-important" href="<?php echo Yii::app()->request->baseUrl; ?>/admingolf_news/index?page=<?php echo Yii::app()->request->cookies['page']; ?>"><i class="icon-chevron-left icon-white"></i>  一覧に戻る</a></span>
                    <span><a class="btn btn-work" href="<?php echo Yii::app()->baseUrl; ?>/admingolf_news/edit/?id=<?php echo $model->id;?>"><i class="icon-pencil icon-white"></i> 修正</a></span>
                </div>
                <div class="box">
                    <div class="postsDate"><i class="icon-pencil"></i> 投稿日時：<span class="date"><?php echo convertDateFromDbToView($model->created_date); ?></span><span class="time"><?php echo convertTimeFromDbToView($model->created_date); ?></span></div>
                    <div class="detailTtl">
                        <h3 class="ttl"><?php echo $model->title; ?></h3>

                        <p class="area">
                            <?php 
								$arrUser = FunctionCommon::getInforUser($model->contributor_id);
								if(isset($arrUser)){ echo $arrUser; }
							?>
                        </p>
                    </div>
                     <?php if($category_name!=""){?>
                    <div class="category">
                            <span style="background-color: <?php echo $background_color;?>; color:<?php echo $text_color;?>;" class="label"><?php echo $category_name;?></span>
                    </div>
                    
                        <?php 
                     }
                        if($model->eye_catch!=""){
                            echo '<div class="picture">';
                            list($width, $height) = getimagesize(Yii::getPathOfAlias('webroot') . $model->eye_catch);
							if ($width > 600) {$width = '600';}
							if ($height > 400) {$height = '400';}                        
                            
                            printf(' <a class="a_base" style="width:'.$width.'px; height:'.$height.'px;" rel="prettyPhoto" href="' . Yii::app()->request->baseUrl . $model->eye_catch . '"><img style="width:' . $width . 'px;height:' . $height . 'px;" class="img_base" src="' . Yii::app()->request->baseUrl . $model->eye_catch . '"/></a>');
                            
                            echo '</div>';
                            
                        }
                        
                        ?>
                    
                    <p class="cnt-box">
                       <?php echo nl2br(FunctionCommon::url_henkan($model->content));?>	
                        </p>
                    <?php                    
                    $attachements = $this->beginWidget('ext.helpers.Form');                    
                    $attachements->detail($model, 'admingolf_news',$this->assetsBase,$edit=true);          
                    $this->endWidget();
                    ?>                  

                </div>
                <div class="box">
					<h4 class="ttl">レスポンス履歴</h4>
					
					<ul class="comments">
                    	 <?php
							$i=1;	
							 foreach ($golf_news_list_comments as $comment) {
								 if($model->id ==$comment['golf_news_id'])
								 { 
						?>
						<li style="border-bottom: 1px #CCC dashed;padding-bottom: 10px;">
                                                    <span class="badge badge-inverse">
								<?php echo $i;?>
							</span>
							<p class="comment">
							<?php echo nl2br(FunctionCommon::url_henkan($comment['comment']));?>
			
							</p>
                                                        <br/>
                             <div class="commenter">
                                    <div class="name">
									 <?php
									 foreach ($user as $user_name) {
										 if($user_name['id']== $comment['contributor_id'])
										 {
											echo $user_name['lastname']." ".$user_name['firstname'];
										 }
									 }
									 ?>
                                    </div>
                                 <div class="unit">
                                         <?php echo FunctionCommon::getUnitBranchBaseUser($comment['contributor_id']);?>
                                     </div>
                                    <div class="post-date">投稿日時：<?php echo FunctionCommon::formatDate($comment['created_date']); ?> <?php echo FunctionCommon::formatTime($comment['created_date']); ?></div>
                                    </div>
							<?php
										if((Yii::app()->request->cookies['id'] == $comment['contributor_id']) || FunctionCommon::isAdmin()==TRUE){	 
							?>
							<div class="btn-comment-remove row"> 
									<div class="offset7 span1">
                                         <a class="btn btn-warning span2" onclick="if(confirm('コメントを削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/admingolf_news/deleteidgolf_newscomment/?id=<?php echo $model->id; ?>&id2=<?php echo $comment['id']; ?>';" style="width:111px; color:#ffffff; font-family:Helvetica Neue,Helvetica,Arial,sans-serif; text-decoration:none; cursor:pointer;">削除</a>
									</div>
							</div>
                            <?php  }?>
						</li>
						<?php
                                                $i++;	
									}
								 }
						?>
					</ul>
				</div>  
            </div>
            <div class="sideBox">
            	<ul>
                	<li>
                    	 <?php $this->widget('MenuManager');?>
                         <?php $this->widget('AffairsManage');?>
                         <?php $this->widget('SystemManage');?>
                         <?php $this->widget('PostedByContentManage');?>
                    </li>
                </ul>
            </div>
        </div>
        
        
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>
    </div>
    
    <div class="footer">
        <p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>
</div>
<?php

function convertDateFromDbToView($datetime) {
    if ($datetime == NULL || !is_string($datetime) || trim($datetime) == "") {
        return $datetime;
    }
    $date_time_array = explode(" ", $datetime);
    $date = $date_time_array[0];
    $y_m_d_array = explode("-", $date);
    return implode("/", $y_m_d_array);
}

function convertTimeFromDbToView($datetime) {
    if ($datetime == NULL || !is_string($datetime) || trim($datetime) == "") {
        return $datetime;
    }
    $date_time_array = explode(" ", $datetime);
    $time = $date_time_array[1];
    $h_m_s_array = explode(":", $time);
    return $h_m_s_array[0] . ":" . $h_m_s_array[1];
}

?>
