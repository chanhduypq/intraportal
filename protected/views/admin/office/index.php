
<script language="javascript">

jQuery(function($) 
{        
	$("body").attr('id','admin');
   
        $('ul.yiiPager li.selected').removeClass('selected');
        $('ul.yiiPager li').removeClass('page');
        $('ul.yiiPager li').removeClass('previous');
        $('ul.yiiPager li').removeClass('next');
        $('ul.yiiPager li').removeClass('last');
        $('ul.yiiPager li').removeClass('first');
        $('ul.yiiPager li').removeClass('hidden');
        $('ul.yiiPager').removeClass('yiiPager');
      
});
</script>
<?php if(isset($pages) && $pages !=null){?>
<input type="hidden" id="page_count" value="<?php  echo $pages->getPageCount();?>"/>
<?php }?>
<div class="wrap admin secondary office">

    <div class="container index">
        <div class="contents index">
        	
            <div class="mainBox">
            	<div class="pageTtl">
            		<h2>事業所管理</h2>
                        <?php 
                        if(FunctionCommon::isAdmin()==true){
                        ?>
            		<a class="btn btn-important" href="<?php echo Yii::app()->baseUrl; ?>/adminoffice/regist/"><i class="icon-pencil icon-white"></i> 登録</a>
                        <?php 
                        }
                        ?>
                        <?php 
                        if(FunctionCommon::isAdmin()==true){
                        ?>
            		<a class="btn btn-important" href="<?php echo Yii::app()->baseUrl; ?>/adminbase/index"><i class="icon-pencil icon-white"></i> 部署管理</a>
                        <?php 
                        }
                        ?>
            		
            	</div>
            	
                <div class="box">
					<h3 class="title">事業所一覧</h3>
					
	                <table class="table list font14">
	                	<thead>
	                		<tr>
		                		<th class="name">名前</th>
		                		<th class="address">住所</th>
		                		<th class="actions">編集</th>
	                		</tr>
	                	</thead>
	                	<tbody>
                                    <?php 
                                    if(isset($offices)&&  is_array($offices)&&count($offices)>0){
                                        foreach ($offices as $office){?>
                                            <tr class="office">
                                                    <td class="name"><a href="<?php echo Yii::app()->baseUrl.'/adminoffice/detail/?id='.$office['id'];?>"><?php echo $office['division_name'];?></a></td>
                                                    <td class="address"><?php echo $office['address'];?></td>
                                                    <td class="actions">
                                                            <a class="btn btn-work" href="<?php echo Yii::app()->baseUrl.'/adminoffice/edit/?id='.$office['id'];?>">修正</a>
                                                            <a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/adminoffice/delete/?id=<?php echo $office['id']; ?>';" class="btn btn-correct">削除</a>
                                                    </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
	                		

	                		

						</tbody>
					</table>
                                        <div class="pagination">
                        <?php
                            $this->widget('CLinkPager', array(
                                'currentPage' => $pages->getCurrentPage(),
                                'itemCount' => $item_count,
                                'pageSize' => $page_size,
                                'maxButtonCount' => 5,
                                'nextPageLabel' => 'Next',
                                'prevPageLabel' => 'Prev',
                                'lastPageLabel' => 'Last',
                                'firstPageLabel' => 'First',
                                'header' => '',
                                'htmlOptions' => array('class' => 'yiiPager'),
                            ));
                            ?>
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
        <p id="page-top" style="display: none;"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
</div>

</div>