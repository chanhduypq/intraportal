



<script type="text/javascript">
    jQuery(function($) {
        $("body").attr('id','majime');      
    });
</script>

<div class="wrap majime secondary to_officer">
    <div class="container">
        <div class="contents detail">
            <div class="mainBox detail">
                <div class="pageTtl">
				<h2>役員宛目安箱 - 詳細</h2>
					<span>
						<?php if(!empty(Yii::app()->request->cookies['page'])): ?>	
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/majimeto_officer/index?page=<?php echo Yii::app()->request->cookies['page']?>" class="btn btn-important">
								<i class="icon-chevron-left icon-white"></i> 一覧に戻る
							</a>
						<?php else : ?>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/majimeto_officer/index" class="btn btn-important">
								<i class="icon-chevron-left icon-white"></i> 一覧に戻る
							</a>
						<?php endif; ?>
					</span>
                </div>
                <div class="box">
                    <div class="postsDate">
						<i class="icon-pencil"></i> 投稿日時：
						<span class="date">
							<?php echo FunctionCommon::formatDate($model->created_date); ?>
						</span>
						<span class="time">
							<?php echo FunctionCommon::formatTime($model->created_date); ?>
						</span>
					</div>
                    <div class="detailTtl">
                        <h3 class="ttl">
							<?php echo htmlspecialchars($model->title);?>
						</h3>

                        <p class="area">
                            <?php 
								$arrUser = FunctionCommon::getInforUser($model->contributor_id);
								if(isset($arrUser)){ echo $arrUser; }
							?>
                        </p>
                    </div>
                    <p class="cnt-box">
						<?php echo nl2br(FunctionCommon::url_henkan($model->content));?>
					</p>
                    <?php                    
                    $attachements = $this->beginWidget('ext.helpers.Form');
                    $attachements->detail($model, 'adminto_officer',$this->assetsBase,$edit=true);                        
                    $this->endWidget();
                    ?>                 

                </div>
            </div>
        </div>
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>
    </div>
    <div class="footer">
        <p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>
</div>
<?php

function echoOldFile($host_file_attachment_ext,$order_index,$model,$img_extention_array,$zip_extention_array,$excel_extention_array,$word_extention_array,$powerpoint_extention_array){    
    $attachment="";
    if($order_index==1){
        $attachment=$model->attachment1;
    }
    else if($order_index==2){
        $attachment=$model->attachment2;
    }
    elseif ($order_index==3) {
        $attachment=$model->attachment3;
    }
?>
    <a <?php if (in_array($host_file_attachment_ext, $img_extention_array)) echo ' rel="prettyPhoto" '; ?> 
        href="<?php echo Yii::app()->request->baseUrl; ?>/adminto_officer/download/?id=<?php echo $model->id."&".$order_index; ?>">

        <?php
        if (in_array($host_file_attachment_ext, $img_extention_array))
            echo '<img style="width:228px; height:171px;" src="'.Yii::app()->request->baseUrl.$attachment.'"/>';
        else if ($host_file_attachment_ext == 'pdf')
            echo '<img src="'.Yii::app()->request->baseUrl.'/css/common/img/img_pdf.gif'.'"/>';
        else if (in_array($host_file_attachment_ext, $zip_extention_array))
            echo '<img src="'.Yii::app()->request->baseUrl.'/css/common/img/img_zip.gif'.'"/>';
        else if (in_array($host_file_attachment_ext, $excel_extention_array))
            echo '<img src="'.Yii::app()->request->baseUrl.'/css/common/img/img_excel.gif'.'"/>';
        else if (in_array($host_file_attachment_ext, $word_extention_array))
            echo '<img src="'.Yii::app()->request->baseUrl.'/css/common/img/img_word.gif'.'"/>';
        else if (in_array($host_file_attachment_ext, $powerpoint_extention_array))
            echo '<img src="'.Yii::app()->request->baseUrl.'/css/common/img/img_ppt.gif'.'"/>';
       
        ?>
        </a>
        <br/>
        <span style="float: left;width: 228px;"><?php echo getFileNameFromValueInDatabase($attachment); ?></span>
<?php
}
function getFileNameFromValueInDatabase($full_file_name){
    if($full_file_name==null||!is_string($full_file_name)||  trim($full_file_name)==""){
        return null;
    }
    $string_array=  explode("/", $full_file_name);
    if(count($string_array)==1){
        return NULL;
    }
    $file_name=$string_array[count($string_array)-1];
    $string_array=  explode(".", $file_name);
    $file_name='';
    for($i=0,$n=count($string_array)-2;$i<$n;$i++){
        $file_name.=$string_array[$i];
    }
    $file_name.='.'.$string_array[count($string_array)-1];
    return $file_name;
}
function getFileNameExtension($file_name){
    if($file_name==null||!is_string($file_name)||  trim($file_name)==""){
        return null;
    }
    $string_array=  explode(".", $file_name);
    if(count($string_array)==1){
        return null;
    }
    return $string_array[count($string_array)-1];
}
function echoEmpty(){
    echo '';
}
?>
