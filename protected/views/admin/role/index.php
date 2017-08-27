<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<script>
    $(window).load(function(){
           $("body").attr('id','admin');
		   if(getCookie("rolename")!=null && getCookie("rolename")!=undefined){ 
           deleteCookies('rolename');
           deleteCookies('checkdata'); 
		   }
    });
    
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap admin secondary role">
    <div class="container index">
        <div class="contents detail">
        	
            <div class="mainBox">
            	<div class="pageTtl">
					<h2>役割管理</h2>
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminrole/regist" class="btn btn-important">
						<i class="icon-pencil icon-white"></i> 登録
					</a>
				</div>
                <div class="box">
                <p class="descriptionTxt">役割の権限など管理情報をご確認いただけます。</p>
                <?php if(Yii::app()->user->hasFlash('deny')){?>
                    <div class="info">
                         <p class="descriptionTxt">
							<?php echo Yii::app()->user->getFlash('deny'); ?>
						</p>
                    </div>
                <?php    
                } ?>
                
                
                <table width="724" border="0" class="table list font14">
                	<thead>
						<tr>
							<th>投稿年月日</th>
							<th>更新年月日</th>
							<th>役割名</th>
							<th>編集</th>
						</tr>
					</thead>
                    <?php
                    if(!empty($roles)){
                        foreach($roles as $role){?>
                        <tr>
                            <td class="td-date alnC txtRed postsDate"><?php echo FunctionCommon::formatDate($role->created_date) ?></td>
                            <td class="td-date alnC txtRed updateDate"><?php echo FunctionCommon::formatDate($role->last_updated_date) ?></td>
                            <td class="td-text">
								<p class="text alnC">
									<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminrole/detail/?id=<?php echo $role->id; ?>">
										<?php echo htmlspecialchars($role->role_name) ?>
									</a>
								</p>
                            </td>
                            <td class="td-edit">
								<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminrole/edit/?id=<?php echo $role->id; ?>" class="btn btn-work">修正</a>
								<a class="btn btn-correct" href="<?php echo Yii::app()->request->baseUrl; ?>/adminrole/delete/?id=<?php echo $role->id; ?>" onclick="return confirm('<?php echo Lang::MSG_0067 ?>');">削除</a>
							</td>
                        </tr>
                    <?php
                            
                        }
                    }
                    ?>
                   
                    
                </table>
                <?php $this->widget('ext.Pagination.Base', array('CPaginationObject' => $pages)); ?>
                
                
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

