





<?php $attachment1=$model->attachment1;?>
<?php $attachment2=$model->attachment2;?>
<?php $attachment3=$model->attachment3;?>
<?php $attachment1_ext=FunctionCommon::getExtensionFile($model->attachment1);?>
<?php $attachment2_ext=FunctionCommon::getExtensionFile($model->attachment2);?>
<?php $attachment3_ext=FunctionCommon::getExtensionFile($model->attachment3);?>
<div class="wrap admin secondary enquete">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>みんなのアンケートBOX - 詳細</h2>
                 <?php 
					if(Yii::app()->request->cookies['page']!= "") 
					{
						   $page = "index?page=".Yii::app()->request->cookies['page'];
							
					}else {$page ="";}
					?>
                 <span><a href="<?php echo Yii::app()->request->baseUrl; ?>/adminenquete/<?php echo $page?>" class="btn btn-important"><i class="icon-chevron-left icon-white"></i> 一覧に戻る</a></span>
                  <span><a href="<?php echo Yii::app()->request->baseUrl; ?>/adminenquete/edit/?id=<?php echo $model->id; ?>" class="btn btn-work"><i class="icon-pencil icon-white"></i> 修正</a></span>

                </div>
                <div class="box">
                	<div class="postsDate">
                   			 <i class="icon-pencil"></i> 投稿日時：
                              <span class="date">
									<?php echo FunctionCommon::formatDate($model->created_date); ; ?>
							   </span>
                              <span class="time">
									<?php echo FunctionCommon::formatTime($model->created_date); ?>
							  </span>
                    </div>
                	<div class="detailTtl">
                    	<h3 class="ttl">
							<?php echo $model->title; ?>
						</h3>
                        <p class="area">
							<?php 
								$arrUser = FunctionCommon::getInforUser($model->contributor_id);
								if(isset($arrUser)){ echo $arrUser; }
							?>
						</p>
                    </div>
                    <p class="cnt-box"><?php echo nl2br(FunctionCommon::url_henkan($model->content)); ?></p>

                    <p class="deadline cnt-box">締め切り日：<?php echo FunctionCommon::formatDate($model->deadline); ?></p>
                    
					<?php                    
                    $attachements = $this->beginWidget('ext.helpers.Form');
                    $attachements->detail($model, 'adminenquete',$this->assetsBase,$edit=true);                        
                    $this->endWidget();
                    ?>                                
                
                </div><!-- /box -->
                
                <div class="box">
            		<h3>アンケート内容</h3>

					<form class="form-horizontal">
	                    
	                    <div class="control-group">
	                        <label class="control-label" for="title">選択方法&nbsp;</label>
	                        <div class="controls">
	                        	<p><?php echo Constants::$typeEnquete[$model->answer_type]; ?></p>
	                        </div>
	                    </div>

	                    <div class="control-group">
	                        <label class="control-label" for="title">選択枝&nbsp;</label>
	                        <div class="controls">
	                        	<ol>
	                        		<?php if(is_array($enquete_choice) && count($enquete_choice)>0):?>
										<?php foreach($enquete_choice as $item): ?>
											<li class="anser">
												<?php echo $item['answer_content']?>
											</li>
										<?php endforeach; ?>
									<?php endif; ?>		
	                        	</ol>
	                        </div>
	                    </div>
                        <?php if(!is_null($enquete_choice)): ?>	
						<h3>回答結果</h3>
						<div class="form-horizontal">
							<div class="control-group">
								<label for="title" class="control-label">
									回答結果&nbsp;
								</label>
								<div class="controls">
									<table class="table">
										<tbody>
										</tbody><thead>
											<tr>
												<th class="anser">回答</th>
												<th class="count">回答数</th>
											</tr>
										</thead>
										<tbody>
											 <?php foreach($enquete_choice as $item): ?>
											   <tr>
													<th class="anser">
														<?php  echo nl2br($item['answer_content']); ?>
													</th>
													<td class="count">
														<?php if(!empty($item['id'])): ?>	
															<?php $count=Yii::app()->db->createCommand('select count(*) from enquete_result where choice_id='.$item['id'])->queryScalar();?>
															<?php echo $count ?>
														<?php endif; ?>	
													</td>
												</tr>
											<?php endforeach; ?>	
										</tbody>
									</table>
								</div>
							</div>
                          </div>  
					  <?php endif; ?>	
	                </form>
	                
				</div>

				<div class="box">
            		<h3>回答コメント</h3>

                    <div class="control-group">
                        <label class="control-label" for="content">コメント&nbsp;</label>
                        <div class="controls">
                            <p><?php echo nl2br(FunctionCommon::url_henkan($model->comment));?>
                        	</p>
                        </div>
                    </div>

                </div>
				
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