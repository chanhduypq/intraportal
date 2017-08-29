
<div class="wrap majime secondary soumu_qa">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl">
                    <h2>教えて総務さん！FAQ</h2>
                    <a href="<?php echo Yii::app()->baseUrl;?>/majime/index" class="btn btn-important">
					   <i class="icon-home icon-white"></i> マジメのTopへ戻る
                    </a>
                </div>
                <div class="box">
                
                
                
                <!--p class="descriptionTxt"></p-->
                <?php //var_dump($model); ?>
                    <?php foreach($category as $category): ?>
                    <div class="cnt-box">
                     <div class="cateTtl">
						<h3>
							<?php echo htmlspecialchars($category['category_name'])?>
						</h3>
					</div>
                
                	<table width="724" border="0" class="table topics font14">
                        <?php //var_dump($model); exit;?>
                        <?php $i=0;foreach($soumu_qa as $model):?>
                        <?php if($category['id']==$model->category_id): ?>
                        <?php $i++; ?>
                        <tr><td class="td-text">
                            <p class="text">
                                <?php echo CHtml::link(htmlspecialchars($model->title),array('majimesoumu_qa/detail','id'=>$model->id)); ?>
                            </p>
                            </td>
                        </tr>
                        <?php if($i==3) break;?>
                        <?php endif; ?>
                        <?php endforeach; ?>
                        
                    </table>
                	
	                	<div class="btn80 alnR">
		                    <a href="<?php echo Yii::app()->request->baseUrl; ?>/majimesoumu_qa/listindex/?id=<?php echo $category['id']; ?>">
                                <p class="btn btn-important"><i class="icon-chevron-right icon-white"></i>一覧を見る</p>
                            </a>
	                    </div>
                     </div>
                     <?php endforeach;?>
                  
                </div><!-- /box -->
            </div><!-- /mainBox -->
            
        </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div><!-- /wrap -->