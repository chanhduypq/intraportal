<link href="<?php echo $this->assetsBase; ?>/css/asobi/css/secondary.css" rel="stylesheet" type="text/css"/>



<script type="text/javascript">
    jQuery(function($) {
        $("body").attr('id', 'asobi');
        if($.trim($("div.picture").eq(0).html())!=""){
            $("div.picture").find('a').eq(0).css('cursor','default');
            $("div.picture").find('img').eq(0).css('cursor','pointer');
        }
        
        
        
    });
</script>
<div class="wrap majime secondary hobby_itd">

    <div class="container">
        <div class="contents detail">

            <div class="mainBox detail">
                <div class="pageTtl"><h2>趣味・サークル広場　サークル紹介- 詳細</h2>
                    <?php
                    if (Yii::app()->request->cookies['page'] != "") {
                        $page = "index?page=" . Yii::app()->request->cookies['page'];
                    } else {
                        $page = "";
                    }
                    ?>
                    <span><a class="btn btn-important" href="<?php echo Yii::app()->request->baseUrl; ?>/asobihobby_itd/<?php echo $page; ?>"><i class="icon-chevron-left icon-white"></i> 一覧に戻る</a></span>
                </div>
                <div class="box">
                    <div class="postsDate"><i class="icon-pencil"></i> 投稿日時：<span class="date"><?php echo FunctionCommon::formatDate($model->created_date); ?></span><span class="time"><?php echo FunctionCommon::formatTime($model->created_date); ?></span></div>
                    <div class="detailTtl">
                        <h3 class="ttl"><?php echo htmlspecialchars($model->title); ?></h3>

                        <p class="area">
							<?php 
								$arrUser = FunctionCommon::getInforUser($model->contributor_id);
								if(isset($arrUser)){ echo $arrUser; }
							?>
                        </p>
                    </div>
<?php
//                        if($model['eye_catch']!=""){
//                            echo '<div class="picture" style="paddong:10px;">';
//                            $file_name=Upload_file_common::getFileNameFromValueInDatabase($model['eye_catch']);
//                            $ext = strtolower(Upload_file_common::getFileNameExtension($file_name));
//                            Upload_file_common::echoEyeCatch($ext, $model['eye_catch'],'detail');
//                            echo '</div>';
//                            
//                        }
if ($model->eye_catch != "") {
    echo '<div class="picture">';
//                            $file_name=Upload_file_common::getFileNameFromValueInDatabase($model->eye_catch);
//                            $ext = strtolower(Upload_file_common::getFileNameExtension($file_name));
    if ($model->eye_catch != ""&&file_exists(Yii::getPathOfAlias('webroot').FunctionCommon::getFilenameInThumnail($model->eye_catch))) {
        
        
        
        list($width_orig, $height_orig)=getimagesize(Yii::getPathOfAlias('webroot').$model->eye_catch);
        if($width_orig>600){
            $width=600;
        }
        else{
            $width=$width_orig;
        }
        $height= ceil($height_orig*$width/$width_orig);
        if($height>400){
            $height=400;
            $ratio=$width_orig/$height_orig;
            $width= ceil($height*$ratio);
        }
                                                          
//          if($width>600){
//              $width='600';
//          }    
//
//          if($height>400){
//              $height='400';
//          }                                                          
                                                          
                                                          
        printf(' <a class="a_base" style="width:'.$width.'px; height:'.$height.'px;" rel="prettyPhoto" href="' . Yii::app()->request->baseUrl . $model->eye_catch . '"><img style="width:' . $width . 'px;height:' . $height . 'px;" class="img_base" src="' . Yii::app()->request->baseUrl . $model->eye_catch . '"/></a>');
    }   
    echo '</div>';
}
?> 
                    <p class="cnt-box"><?php echo nl2br(FunctionCommon::url_henkan($model->content)); ?></p>
                    <?php
                    $attachements = $this->beginWidget('ext.helpers.Form');
                    $attachements->detail($model, 'adminhobby_itd', $this->assetsBase, $edit = true);
                    $this->endWidget();
                    ?>                 

                </div><!-- /box -->

            </div><!-- /mainBox -->


        </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->

    <div class="footer">
        <p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div><!-- /wrap -->