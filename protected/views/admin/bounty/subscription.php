<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>

<script language="javascript">
if(getCookie("adoption_reg_form")!=null && getCookie("adoption_reg_form")!=undefined)
{
	deleteCookies("adoption_reg_form");
	deleteCookies("adopted_reg_comment");
	deleteCookies("adopted_reg_open_type");
}

if(getCookie("adoption_edit_form")!=null && getCookie("adoption_edit_form")!=undefined)
{
	deleteCookies("adoption_edit_form");
	deleteCookies("adopted_edit_comment");
	deleteCookies("adopted_edit_open_type");
} 
 
jQuery(function($)
{        
	$("body").attr('id','admin');      
})
</script>
<div class="wrap admin secondary bounty">    
  <div class="container">
    <div class="contents index">
      <div class="mainBox detail">
        <div class="pageTtl">
         <h2>懸賞金付き募集コンテンツ - 応募一覧</h2>
          <span>
			  <?php if(!empty(Yii::app()->request->cookies['page'])): ?>	
				  <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminbounty/index?page=<?php echo Yii::app()->request->cookies['page']?>" class="btn btn-important">
					<i class="icon-chevron-left icon-white"></i> もどる
				  </a>
			  <?php else : ?>
				  <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminbounty" class="btn btn-important">
						<i class="icon-chevron-left icon-white"></i> もどる
				  </a>
			  <?php endif; ?>
          </span>
        </div>
        <div class="box">
          <!--p class="descriptionTxt"></p-->
          <table width="724" border="0" class="table list font14">
            <thead>
              <tr>
                <th>日付</th>
                <th>応募内容</th>
                <th>編集</th>
              </tr>
            </thead>
            <tbody>
			<?php if(!is_null($model)): ?>
			  <?php foreach($model as $bounty_apply): ?>	
				<?php if(!empty($bounty_apply->open_type) && !empty($bounty_apply->adopted_comment)): ?>
						<tr>
							<td class="td-date alnC txtRed postsDate">
								<?php echo FunctionCommon::formatDate($bounty_apply->created_date); ?>
							</td>
							<td class="td-text">
								<?php echo nl2br(FunctionCommon::url_henkan($bounty_apply->applied_content));?>	
								<p class="file">
								<?php if(!empty($bounty_apply->attachment1)): ?>
									<?php $path = Yii::app()->request->baseUrl.$bounty_apply->attachment1;?>
									<?php $filename = basename($path);?>
										<?php if(!empty($filename)):?>
											<?php $attachment1_ext=FunctionCommon::getExtensionFile($bounty_apply->attachment1);?>
											<a href="<?php echo Yii::app()->request->baseUrl.$bounty_apply->attachment1; ?>" target="_blank">
												<span class="icon icon-file"></span>ファイル
											</a>
										<?php endif; ?> 
								<?php endif; ?> 	
								</p>
                                <?php
                                $users = Yii::app()->db->createCommand()
									->select(array(
										'user.id',
										'firstname',
										'lastname',
										'division1',
										'division2',
										'division3',
										'division4'
											)
									)
									->from('user')
									->where("employee_number ='".$bounty_apply->applicant_id."'")
									->queryRow();
                                                                
									if(!empty($users)){
								?>
                                 <p class="applicant">
                                        <span class="unit">
										<?php 
										if($users['division1']!=""){
											$division = $users['division1'];
										}else if($users['division2']!=""){
											$division = $users['division2'];
										}else if($users['division3']!=""){
											$division = $users['division3'];
										}else if($users['division4']!=""){
											$division = $users['division4'];
										}
										$unit = Yii::app()->db->createCommand()
											->select(array(
												'unit.id',
												'unit.branch_id',
												'unit.unit_name',
												'branch.branch_name',
												'base.company_name'
													)
											)
											->from('unit')
											->leftJoin('branch', 'branch.active_flag = 1 and branch.id = unit.branch_id')
											->leftJoin('base', 'base.id = branch.base_id')
											->where("unit.active_flag = 1 and unit.id = '".$division."'")
											->queryRow();
                                                                                
										if(!empty($unit)){
                                                                                    $is_view=FALSE;
                                                                                    if(FunctionCommon::isAdmin(true)){
                                                                                        $is_view=TRUE;
                                                                                    }
                                                                                    else{
                                                                                        $user_id=Yii::app()->request->cookies['id'];
                                                                                        $row=Yii::app()->db->createCommand("select count(*) as count from bounty where contributor_id=$user_id and id=".$_GET['id'])->queryScalar();
                                                                                        
                                                                                        if($row!=FALSE&&$row=='1'){
                                                                                            $row=Yii::app()->db->createCommand("select count(*) as count from bounty_apply where adopted_comment is not null and open_type is not null and bounty_id=".$_GET['id'])->queryScalar();
                                                                                            if($row!=FALSE&&$row!='0'){
                                                                                                $is_view=true;
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                    if($is_view==TRUE){
                                                                                        echo htmlspecialchars($unit['company_name'])."&nbsp;".htmlspecialchars($unit['branch_name'])."&nbsp;".htmlspecialchars($unit['unit_name']);
                                                                                    }
											
										}
										?></span>
                                        <span class="name"><?php if($is_view==true){ echo $users['lastname']."&nbsp;".$users['firstname'];}?></span>
                                </p>	
                                <?php }?>		
							</td>
                           
							<td class="td-edit">
								<a href="<?php echo Yii::app()->baseUrl;?>/adminbountyapply/adoptionedit/?id=<?php echo $bounty_apply->id;?>" class="btn btn-important">採用修正</a>
							</td>
						</tr>
				  <?php else: ?>	
						<tr>
							<td class="td-date alnC txtRed postsDate">
								<?php echo FunctionCommon::formatDate($bounty_apply->created_date); ?>
							</td>
							<td class="td-text">
								<?php echo nl2br(FunctionCommon::url_henkan($bounty_apply->applied_content));?>		
								<p class="file">
								<?php if(!empty($bounty_apply->attachment1)): ?>
									<?php $path = Yii::app()->request->baseUrl.$bounty_apply->attachment1;?>
									<?php $filename = basename($path);?>
										<?php if(!empty($filename)):?>
											<a href="<?php echo Yii::app()->request->baseUrl.$bounty_apply->attachment1; ?>" target="_blank">
												<span class="icon icon-file"></span>ファイル
											</a>
										<?php endif; ?> 
								<?php endif; ?> 	
								</p>
                                <?php
                                $users = Yii::app()->db->createCommand()
									->select(array(
										'user.id',
										'firstname',
										'lastname',
										'division1',
										'division2',
										'division3',
										'division4'
											)
									)
									->from('user')
									->where("employee_number ='".$bounty_apply->applicant_id."'")
									->queryRow();
									if(!empty($users)){
								?>
                                 <p class="applicant">
                                        <span class="unit">
										<?php 
										if($users['division1']!=""){
											$division = $users['division1'];
										}else if($users['division2']!=""){
											$division = $users['division2'];
										}else if($users['division3']!=""){
											$division = $users['division3'];
										}else if($users['division4']!=""){
											$division = $users['division4'];
										}
										$unit = Yii::app()->db->createCommand()
											->select(array(
												'unit.id',
												'unit.branch_id',
												'unit.unit_name',
												'branch.branch_name',
												'base.company_name'
													)
											)
											->from('unit')
											->leftJoin('branch', 'branch.active_flag = 1 and branch.id = unit.branch_id')
											->leftJoin('base', 'base.id = branch.base_id')
											->where("unit.active_flag = 1 and unit.id = '".$division."'")
											->queryRow();
										if(!empty($unit)){						
											//echo htmlspecialchars($unit['unit_name'])."&nbsp;".htmlspecialchars($unit['branch_name'])."&nbsp;".htmlspecialchars($unit['company_name']);
                                                                                    $is_view=FALSE;
                                                                                    if(FunctionCommon::isAdmin(true)){
                                                                                        $is_view=TRUE;
                                                                                    }
                                                                                    else{
                                                                                        $user_id=Yii::app()->request->cookies['id'];
                                                                                        $row=Yii::app()->db->createCommand("select count(*) as count from bounty where contributor_id=$user_id and id=".$_GET['id'])->queryScalar();
                                                                                        
                                                                                        if($row!=FALSE&&$row=='1'){
                                                                                            $row=Yii::app()->db->createCommand("select count(*) as count from bounty_apply where adopted_comment is not null and open_type is not null and bounty_id=".$_GET['id'])->queryScalar();
                                                                                            if($row!=FALSE&&$row!='0'){
                                                                                                $is_view=true;
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                    if($is_view==TRUE){
                                                                                        echo htmlspecialchars($unit['company_name'])."&nbsp;".htmlspecialchars($unit['branch_name'])."&nbsp;".htmlspecialchars($unit['unit_name']);
                                                                                    }
										}
										?></span>
                                        <span class="name"><?php if($is_view==true){ echo $users['lastname']."&nbsp;".$users['firstname'];}?></span>
                                </p>	
                                <?php }?>	
							</td>
							<td class="td-edit">
								<?php $criteria = new CDbCriteria;?>
								<?php $criteria->select = "*";?>
								<?php $criteria->condition="id=$bounty_apply->bounty_id"?>
								<?php $bounty = Bounty::model()->find($criteria);?>
								<?php $now = strtotime(date('Y/m/d')); ?> 
								<?php $dealine = strtotime(date('Y/m/d', strtotime($bounty->deadline)));?>
								<?php if ($now > $dealine): ?>
									<a href="<?php echo Yii::app()->baseUrl;?>/adminbountyapply/adoptionadd/?id=<?php echo $bounty_apply->id;?>" class="btn btn-work">採用</a>
								<?php endif; ?>
							</td>
						</tr>
				  <?php endif; ?>
				<?php endforeach; ?>  
			  <?php endif; ?>
            </tbody>
          </table>
          <?php $this->widget('ext.Pagination.Base', array('CPaginationObject' => $pages)); ?>
        </div>
        <!-- /box -->
      </div>
      <!-- /mainBox -->
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
      <!-- /sideBox -->
    </div>
    <!-- /contents -->
    <p id="page-top">
      <a href="#wrap">PAGE TOP</a>
    </p>
  </div>
  <!-- /container -->
  <div class="footer">
    <p>COPYRIGHT (C) Newgin ALL RIGHTS RESERVED.</p>
  </div>
</div>
<!-- /wrap -->