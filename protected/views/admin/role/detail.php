<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<script>
    $(window).load(function(){
           $("body").attr('id','admin');
     });
</script>
<div class="wrap admin secondary role">

    <div class="container index">
        <div class="contents detail">
        	
            <div class="mainBox">
            	<div class="pageTtl"><h2>役割管理 - 詳細</h2>
                <span><a href="<?php echo Yii::app()->request->baseUrl; ?>/adminrole/" class="btn btn-important"><i class="icon-chevron-left icon-white"></i> 一覧に戻る</a></span>
                <span><a href="<?php echo Yii::app()->request->baseUrl; ?>/adminrole/edit/?id=<?php echo $roles[0]->id; ?>" class="btn btn-work"><i class="icon-pencil icon-white"></i> 修正</a></span></div>
                <div class="box">
                <p class="descriptionTxt">役割の権限など管理情報をご確認いただけます。</p>
                <div class="field attachements"><div class="title">
                  <?php echo $roles[0]->role_name ?>
                </div></div>
                <table width="724" border="0" class="table list font14">
                	<tr><th>コンテンツ名</th><th>編集</th></tr>
                    <?php
                      foreach($functions as $val){
                     ?>
                       <tr>
                            <td class="td-text">
                            <p class="text alnC"><?php echo htmlspecialchars($val->function_name) ?></p>
                            </td>
                            <td class="td-icon">
                                <div class="btn-group" data-toggle="buttons-checkbox">
                                <?php if(isset($role_relative[$val->id]))
                                 {

                                 ?>
                                 <?php if($role_relative[$val->id]['view']==1){
                                    echo '<span class="ico view">閲覧</span>';
                     
                                 }
                                 if($role_relative[$val->id]['post']==1){
                                    echo '<span class="ico posts">投稿</span>';
                     
                                 }
                                 if($role_relative[$val->id]['admin']==1){
                                    echo '<span class="ico control">管理</span>';
                     
                                 }
                                 }
                                 ?>
                                 </div>
           					</td>
                        </tr>
                        <?php
                       
                        }
                        ?>
                   
                </table>
                
              </div><!-- /box -->
            </div><!-- /mainBox -->
            
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
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
</div>

</div><!-- /wrap -->

