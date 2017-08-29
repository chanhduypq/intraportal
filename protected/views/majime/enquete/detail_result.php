



<?php $attachment1=$model->attachment1;?>
<?php $attachment2=$model->attachment2;?>
<?php $attachment3=$model->attachment3;?>
<?php $attachment1_ext=FunctionCommon::getExtensionFile($model->attachment1);?>
<?php $attachment2_ext=FunctionCommon::getExtensionFile($model->attachment2);?>
<?php $attachment3_ext=FunctionCommon::getExtensionFile($model->attachment3);?>
<div class="wrap majime secondary enquete">
    <div class="container">
        <div class="contents detail detail_anser">
            <div class="mainBox detail">
                <div class="pageTtl">
					<h2>みんなのアンケートBOX - アンケート</h2>
					<?php if(!empty(Yii::app()->request->cookies['page'])): ?>	
					<a href="<?php echo Yii::app()->request->baseUrl; ?>/majimeenquete/index?page=<?php echo Yii::app()->request->cookies['page']?>" class="btn btn-important">
						<i class="icon-chevron-left icon-white"></i> 一覧に戻る
					</a>
					<?php else : ?>
						<a href="<?php echo Yii::app()->request->baseUrl; ?>/majimeenquete/index" class="btn btn-important">
							<i class="icon-chevron-left icon-white"></i> 一覧に戻る
						</a>
					<?php endif; ?>	
				</div>
				<?php if($model != null): ?>	
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
							<?php echo $model->title; ?>
						</h3>
                         <p class="area">
							  <?php 
									$arrUser = FunctionCommon::getInforUser($model->contributor_id);
									if(isset($arrUser)){ echo $arrUser; }
								?>
						</p>
                    </div>
                    <p class="cnt-box">
						<?php  echo nl2br($model->content); ?>
                    </p>
                    <p class="deadline cnt-box">締め切り日：
						<?php echo FunctionCommon::formatDate($model->deadline); ?>
					</p>
                    <?php                    
                    $attachements = $this->beginWidget('ext.helpers.Form');
                    $attachements->detail($model, 'majimeenquete',$this->assetsBase);                        
                    $this->endWidget();
                    ?>           
                </div>
				<!-- /box -->
				<div class="box">
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
													<?php  echo nl2br(htmlspecialchars($item['answer_content'])); ?>
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

                        <div class="control-group">
                            <label for="title" class="control-label">回答コメント&nbsp;</label>
                            <div class="controls">
								 <p>
									<?php echo nl2br(htmlspecialchars($model->comment)); ?>
								</p>
                            </div>
                        </div>
                    </div>
				  <?php endif; ?>	
                </div>
            </div>
			<?php endif; ?>
			<!-- /mainBox -->


        </div><!-- /contents -->
        <p id="page-top" style="display: none;">
			<a href="#wrap">PAGE TOP</a>
		</p>

    </div><!-- /container -->

    <div class="footer">
        <p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div>