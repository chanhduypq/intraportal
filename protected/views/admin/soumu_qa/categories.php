
<div class="wrap admin secondary soumu_qa" id="admin">

    <div class="container">
        <div class="contents categories">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>教えて総務さん！FAQ - カテゴリー一覧</h2>
            		
<!--                    <a href="<?php echo Yii::app()->baseUrl;?>/adminsoumu_qa/categoryregist" class="btn btn-important">-->
                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/admincategory/categoryregist/?type=2" class="btn btn-important">
					   <i class="icon-pencil icon-white"></i> 登録
                    </a>
                    <a href="<?php echo Yii::app()->baseUrl;?>/adminsoumu_qa/index" class="btn btn-important">
                      <i class="icon-chevron-left icon-white"></i>もどる
                    </a>
            	</div>
                <div class="box">
                <?php //var_dump($td);exit;;?>
                
                <!--p class="descriptionTxt"></p-->
                
                <table width="724" border="0" class="table list font14">
                	<thead>
	                	<tr>
	                		<th>カテゴリー</th><th>登録数</th><th>編集</th>
						</tr>
					</thead>
                    <?php //var_dump($categories);exit;?>
                    <?php if(isset($categories)&&  is_array($categories)&&count($categories)>0):?>
                    <?php foreach($categories as $category): ?>
                        <tr>
	                        <td class="td-category"><?php echo htmlspecialchars($category['category_name'])?></td>
	                        <td class="td-counter">
                                <?php echo $category['count(category.id)'];?>
                            </td>
	                        <td class="td-edit">
                                <a href="<?php echo Yii::app()->request->baseUrl; ?>/admincategory/categoryedit/?id=<?php echo $category['id']; ?>&type=2" class="btn btn-work">修正</a>
                                <a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/adminsoumu_qa/categorydelete/?id=<?php echo $category['id']; ?>';" href="#" class="btn btn-correct">削除</a>
                            </td>
	                    </tr>
                    <?php endforeach; ?>
				    <?php endif; ?>
                </table>

                    <div class="pagination">
                        <?php $this->widget('ext.Pagination.Base', array('CPaginationObject' => $pages)); ?>
                    </div>
                
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