<link href="<?php echo $this->assetsBase; ?>/css/majime/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>

<?php $attachment1=$model->attachment1;?>
<?php $attachment2=$model->attachment2;?>
<?php $attachment3=$model->attachment3;?>

<?php $attachment1_ext=FunctionCommon::getExtensionFile($model->attachment1);?>
<?php $attachment2_ext=FunctionCommon::getExtensionFile($model->attachment2);?>
<?php $attachment3_ext=FunctionCommon::getExtensionFile($model->attachment3);?>
<div class="wrap majime secondary enquete">
<?php 
	$array_answer_rels = array();
	foreach ($answers as $answer)
	{
		
		$array_answer_rels[] = $answer['id'];
	}
                
	$flag = false;
	$flag_multi_choice = false;
                
    $user_id = Yii::app()->request->cookies['id'];
                
    $array_multi_choi = array();
	foreach($array_answer_rels as $array_answer_rel)
	{
		$answer_results = Yii::app()->db->createCommand()
		->select('*')
		->from('enquete_result')
		->where('choice_id=:choice_id', array(':choice_id' => $array_answer_rel))
		->andWhere('respondent_id=:respondent_id', array(':respondent_id' => $user_id))
		 ->queryAll();
		 
		 if($model->answer_type == 1)
		 {
			if(!empty($answer_results))
			{
				if($answer_results[0]['choice_id'] != null)
				{
					$choice_id = $answer_results[0]['choice_id'];
					$flag = true;
				}
			}
		 }
		 else
		 {
			if(!empty($answer_results))
			{
			   if($answer_results[0]['choice_id'] != null)
			   {
					$flag_multi_choice = true;
					$array_multi_choi[] = $answer_results[0]['choice_id'];
			   }
		   }
		 }
	}
?>
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
						<?php  echo nl2br(FunctionCommon::url_henkan($model->content)); ?>
				</p>
				<p class="deadline cnt-box">
					締め切り日：<?php echo FunctionCommon::formatDate($model->deadline); ?>
				</p>
				<?php                    
                                $attachements = $this->beginWidget('ext.helpers.Form');
                                $attachements->detail($model, 'majimeenquete',$this->assetsBase);                        
                                $this->endWidget();
                                ?>                  

			</div><!-- /box -->

			<div class="box">
				<h3>アンケート</h3>
				<form class="form-horizontal" method="post">
					<div class="control-group">
						<label for="title" class="control-label">内容&nbsp;</label>
						<div class="controls">
							<ol>                         
								<?php if ($model->answer_type == 1):?>
									<?php foreach($answers as $answer): ?>
											<?php if($flag == true):?>
												<?php if($answer['id'] == $choice_id):?>
												  <li class="anser">
													<label class="radio inline">
													<input value="<?php echo $answer['id'] ?>" type="radio" checked="checked" class="" name="anser" disabled>
														<?php echo htmlspecialchars($answer['answer_content']) ?>
														
													</label>
												 </li>  
												<?php else:?>
												<li class="anser">
													<label class="radio inline">
														<input value="<?php echo $answer['id'] ?>" type="radio"  class="" name="anser" disabled>
															<?php echo htmlspecialchars($answer['answer_content'])?>
													</label>
												</li>
												<?php endif; ?>
											<?php else:?>
											<li class="anser">
												<label class="radio inline">
													<input value="<?php echo $answer['id'] ?>" type="radio"  class="" name="anser">
													<?php echo $answer['answer_content'] ?>
												</label>
											</li>
											<?php endif; ?>
									<?php endforeach; ?>	
								<?php else:?>
								<?php $i = 1 ?>
									  <?php if($flag_multi_choice == true):?>
										 <?php	foreach ($answers as $answer) :?>
											    <?php if(in_array($answer['id'], $array_multi_choi)):  ?>
												<li class="anser">
													<label class="radio inline">
													<input value="<?php echo $answer['id'] ?>" type="checkbox" name="anser<?php echo $i ?>" checked="checked" disabled>
														<?php echo $answer['answer_content'] ?>
													</label>
												</li>
												<?php else:?>
												<li class="anser">
													<label class="radio inline">
													<input value="<?php echo $answer['id'] ?>" type="checkbox" name="anser<?php echo $i ?>" disabled>
														<?php echo $answer['answer_content'] ?>
													</label>
												</li>
												<?php endif; ?>
											<? $i++;?>	
											<?php endforeach; ?>	
											
									  <?php else:?>
											<?php foreach ($answers as $answer):?>
											<li class="anser">
												<label class="radio inline">
													<input value="<?php echo $answer['id'] ?>" type="checkbox" name="anser<?php echo $i ?>">
														<?php echo $answer['answer_content'] ?>
												</label>
											</li>
											<?php $i++; ?>	
											<?php endforeach; ?>
											
									 <?php endif; ?>
								<?php endif; ?>
							</ol>
						</div>
					</div>
				</form>
	
				<div class="form-last-btn">
					<p class="btn80">
						<?php if($flag == false && $flag_multi_choice == false && FunctionCommon::isPostFunction("enquete")==true):?>
						<button onclick="show_comfirm();" class="btn btn-important" type="submit">
							<i class="icon-chevron-right icon-white">&#12288;</i> 回答
						</button>
						<?php else:?>
						<button class="btn btn-important" type="submit" disabled>
							<i class="icon-chevron-right icon-white">&#12288;</i> 回答
						</button>
						<?php endif; ?>
					</p>
				</div>
			</div>

		</div><!-- /mainBox -->


	</div><!-- /contents -->
	<p id="page-top" style="display: block;"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
	<div class="footer">
		<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>

	</div>
</div>
<script type="text/javascript">
function show_comfirm()
{
	var comfirmBox;
	var form = document.getElementsByTagName("form");
	comfirmBox = confirm('回答します。よろしいですか？');
	if (comfirmBox == true) 
	{
		form[0].submit();
	}
	else 
	{
		$("li.anser").find("input[type=radio]").attr("checked",false);
	}
}
</script>