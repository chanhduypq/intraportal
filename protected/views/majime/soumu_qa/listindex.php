<link href="<?php echo $this->assetsBase; ?>/css/majime/css/secondary.css" rel="stylesheet" type="text/css"/>
<div class="wrap majime secondary soumu_qa">

    <div class="container">
        <div class="contents index">
        	<?php //var_dump($soumu_qa);?>
            <div class="mainBox detail">
            	<div class="pageTtl">
                <h2>教えて総務さん！FAQ</h2>
                <a href="<?php echo Yii::app()->baseUrl;?>/majimesoumu_qa/index" class="btn btn-edit">
					<i class="icon-chevron-left icon-white"></i> 一覧へ戻る
				</a>
                </div>
                <div class="box">
                <!--p class="descriptionTxt"></p-->
                   <div class="cateTtl">
						<h3>
							<?php echo htmlspecialchars($category_name[0]['category_name']); ?>
						</h3>
					</div>
                	<table width="724" border="0" class="table topics font14">
                        <?php foreach($soumu_qa as $model):?>
                        <tr><td class="td-text">
                            <p class="text">
                                <?php echo CHtml::link(htmlspecialchars($model->title),array('Majimesoumu_qa/detail','id'=>$model->id)); ?>
                            </p>
                            </td>
                        </tr>
                        <tr>
                        <?php endforeach; ?>
                    </table>
                	
                    <div class="pagination">
                        <?php $this->widget('ext.Pagination.Base', array('CPaginationObject' => $pages)); ?>
                    </div>
                
                </div><!-- /box -->
            </div><!-- /mainBox -->
            
        </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div><!-- /wrap -->