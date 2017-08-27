<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<script language="javascript">
jQuery(function($) 
{        
	$("body").attr('id','admin');  
}) 
</script>
<input type="hidden" id="page_count" value="<?php  echo $pages->getPageCount();?>"/>
<div class="wrap admin secondary link">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
					<h2>リンク集</h2>
					<a href="<?php echo Yii::app()->baseUrl;?>/adminlink/regist" class="btn btn-important">
						<i class="icon-pencil icon-white"></i> 登録
					</a>
					<a href="<?php echo Yii::app()->baseUrl;?>/admincategory/categories/?type=7" class="btn btn-important">
						<i class="icon-pencil icon-white"></i> カテゴリー管理
					</a>
				</div>
				
                <div class="box">
                
                <!--p class="descriptionTxt"></p-->
                
                <table width="724" border="0" class="table list font14">
                	<thead>
	                	<tr>
	                		<th class="td-date">
	                			<span class="postsDate">登録年月日</span>
	                			<span class="updateDate">更新年月日</span>
	                		</th>
	                		<th class="td-category">カテゴリー</th>
	                		<th class="td-link_info">内容</th>
	                		<th class="td-edit">編集</th>
						</tr>
					</thead>
					<tbody>
					<?php if(!is_null($model)): ?>
						<?php foreach($model as $link): ?>
	                    <tr>
	                        <td class="td-date alnC txtRed">
	                        	<span class="postsDate">
									<?php echo FunctionCommon::formatDate($link->created_date); ?>
								</span>
	                        	<span class="updateDate">
									<?php echo FunctionCommon::formatDate($link->last_updated_date); ?>
								</span>
							</td>
	                        <td class="td-category td-contents">
								<span>
									<?php $criteria = new CDbCriteria;
										  $criteria->select = "category_name";
										  $criteria->condition="id=$link->category_id";
									      $category = Category::model()->find($criteria);
										  echo htmlspecialchars($category['category_name'])?>
								</span>
								</td>
	                        <td class="td-link_info">
	                        	<p class="title">
										<?php echo htmlspecialchars($link->title); ?>
								</p>
	                        	<p class="link_url">
									<span class="icon icon-share-alt"></span>
									<a href="<?php echo $link->url?>" target="_blank">
										<?php echo $link->url; ?>
									</a>
								</p>
	                        	<p class="comment">
	                        		<?php echo nl2br(FunctionCommon::url_henkan($link->comment));?>
	                        	</p>
	                        </td>
	                        <td class="td-edit">
								<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminlink/edit/?id=<?php echo $link->id; ?>" class="btn btn-work">修正</a>
								<a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/adminlink/delete/?id=<?php echo $link->id; ?>';" href="#" class="btn btn-correct">削除</a>
							</td>
	                    </tr>
						<?php endforeach; ?>	
					<?php endif; ?>			
					</tbody>
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