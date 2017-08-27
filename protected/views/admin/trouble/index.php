<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
    trouble= getCookie("trouble_edit_from");
 if(trouble !="" || trouble ==null){ 

   deleteCookies("trouble_edit_from", { path: '/' });
   deleteCookies("trouble_edit_title", { path: '/' });
   deleteCookies("trouble_edit_content", { path: '/' });
   deleteCookies("trouble_edit_attachment1_checkbox_for_deleting", { path: '/' });
   deleteCookies("trouble_edit_attachment2_checkbox_for_deleting", { path: '/' });
   deleteCookies("trouble_edit_attachment3_checkbox_for_deleting", { path: '/' });
}
    jQuery(function($) {
       
        $("body").attr('id','admin');        
    });
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap admin secondary trouble">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>トラブル＆不正情報 - 詳細</h2>
				</div>
                <div class="box">
                
                
                <?php echo CHtml::beginForm('', 'post', array('id' => 'index_frm')); ?>
                <table width="724" border="0" class="table list font14">
                    <thead>
                        <tr class="header_rs"><th>投稿年月日</th><th>更新年月日</th><th>タイトル</th><th>編集</th></tr>
                    </thead>
                    <tbody>    
                        <?php
                        if ($troubles != null && is_array($troubles) && count($troubles) > 0) {
                            foreach ($troubles as $trouble) {
                                ?>        

                                <tr>
                                    <td class="td-date alnC txtRed postsDate"><?php echo convertDateFromDbToView($trouble['created_date']); ?></td>
                                    <td class="td-date alnC txtRed updateDate"><?php echo convertDateFromDbToView($trouble['last_updated_date']); ?></td>
                                    <td class="td-text">
                                        <p class="text">                                        
                                            <a href="<?php echo Yii::app()->request->baseUrl; ?>/admintrouble/detail/?id=<?php echo $trouble['id']; ?>"><?php echo htmlspecialchars($trouble['title']); ?></a>
                                        </p>
                                    </td>
                                    <td class="td-edit">
                                        <a class="btn btn-work" href="<?php echo Yii::app()->request->baseUrl; ?>/admintrouble/edit/?id=<?php echo $trouble['id']; ?>">修正</a>
                                        <a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/admintrouble/delete/?id=<?php echo $trouble['id']; ?>';" href="#" class="btn btn-correct">削除</a>
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
            
            <div class="sideBox">
            	<ul>
                	<li>
                    	 <?php $this->widget('MenuManager');?>
                         <?php $this->widget('AffairsManage');?>
                         <?php $this->widget('SystemManage');?>
                         <?php $this->widget('PostedByContentManage');?>
                    </li>
                </ul>
            </div><!-- /sideBox -->
            
  </div><!-- /contents -->
        <p id="page-top" style="display: none;"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    
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
?>
