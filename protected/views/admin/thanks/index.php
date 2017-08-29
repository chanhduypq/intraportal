
<script type="text/javascript">
    thanks= getCookie("thanks_edit_comment");
if(thanks !="" || thanks ==null){ 
    
    deleteCookies("thanks_edit_user_id", { path: '/' });
    deleteCookies("thanks_edit_comment", { path: '/' });
    deleteCookies("thanks_edit_sender", { path: '/' }); 
    deleteCookies("thanks_edit_base_id", { path: '/' });   
 }
 thanks1= getCookie("thanks_regist_comment");
if(thanks1 !="" || thanks1 ==null){ 
    
    deleteCookies("thanks_regist_user_id", { path: '/' });
    deleteCookies("thanks_regist_comment", { path: '/' });
    deleteCookies("thanks_regist_sender", { path: '/' });   
    deleteCookies("thanks_regist_base_id", { path: '/' });   
 }
 
    jQuery(function($) {
        $('ul.yiiPager li.selected').removeClass('selected');
        $('ul.yiiPager li').removeClass('page');
        $('ul.yiiPager li').removeClass('previous');
        $('ul.yiiPager li').removeClass('next');
        $('ul.yiiPager li').removeClass('last');
        $('ul.yiiPager li').removeClass('first');
        $('ul.yiiPager li').removeClass('hidden');
        $('ul.yiiPager').removeClass('yiiPager');
        
        $("body").attr('id','admin');     
         $('img#not_download').contextmenu( function() {
            return false;
        });
    });
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap admin secondary thanks">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>今日のありがとう</h2>                    
                    <a class="btn btn-important" href="<?php echo Yii::app()->baseUrl;?>/adminthanks/regist"><i class="icon-pencil icon-white"></i> 登録</a>
                    <a onclick="if(confirm('すべての登録を削除します。よろしいですか？')) window.location='<?php echo Yii::app()->baseUrl;?>/adminthanks/deleteall';" class="btn btn-work" href="#"><i class="icon-trash icon-white"></i> すべて破棄</a>
            	</div>
                <div class="box">
                
                <!--p class="descriptionTxt"></p-->
                
                <table width="724" border="0" class="table list font14">
                	<thead>
                            <tr>
                            <th class="td-target">対象者</th>
                            <th class="td-comment">コメント</th>
                            <th class="td-edit">編集</th>
                                    </tr>
                        </thead>
                	<tbody>
                    
                    <?php 
                    if(isset($thanks)&&is_array($thanks)&&count($thanks)>0){
                        foreach ($thanks as $thank){
							
							?>
                            <tr>
	                        <td class="td-target">
                                        <?php
                                        
                                        if($thank['photo']!=""&&file_exists(Yii::getPathOfAlias('webroot') . $thank['photo'])){ 
                                            $thumnail_file_path=  FunctionCommon::getFilenameInThumnail($thank['photo']);  
                                            if(file_exists(Yii::getPathOfAlias('webroot') . $thumnail_file_path)){ 
                                                $thumnail_file_path=ltrim($thumnail_file_path, '/');  
                                                $imgbinary = fread(fopen($thumnail_file_path, "r"), filesize($thumnail_file_path));
                                                $img_str = base64_encode($imgbinary);
                                                $img="data:image/jpg;base64,".$img_str; 
                                                if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {                                    
                                                    echo '<img ondragstart="return false;" ondrop="return false;" id="not_download" style="height:52px;" src="'.Yii::app()->request->baseUrl.'/'.$thumnail_file_path.'"/>';                                                
                                                    if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.') == false) { 
                                                        echo '<img src="data:image/jpg;base64,'.$img_str.'" style="display:none;"/>';
                                                    }
                                                    

                                                }
                                                else{
                                                    echo '<img ondragstart="return false;" ondrop="return false;" id="not_download" style="height:52px;" src="'.$img.'"/>';
                                                }
                                            }
                                            else{
                                                $thumnail_file_path=ltrim($thank['photo'], '/');  
                                                $imgbinary = fread(fopen($thumnail_file_path, "r"), filesize($thumnail_file_path));
                                                $img_str = base64_encode($imgbinary);
                                                $img="data:image/jpg;base64,".$img_str; 
                                                if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {                                    
                                                    echo '<img ondragstart="return false;" ondrop="return false;" id="not_download" style="height:52px;" src="'.Yii::app()->request->baseUrl.'/'.$thumnail_file_path.'"/>';                                                
                                                    if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.') == false) { 
                                                        echo '<img src="data:image/jpg;base64,'.$img_str.'" style="display:none;"/>';
                                                    }
                                                    

                                                }
                                                else{
                                                    echo '<img ondragstart="return false;" ondrop="return false;" id="not_download" style="height:52px;" src="'.$img.'"/>';
                                                }
                                            }
                                            ?>
                                                <?php 
                                                
                                        } 
                                              else{                                                  
                                                  echo '<img style="width: 70px;height: 52px;" alt="" src="' .$this->assetsBase . '/css/common/img/img_photo01.gif">';
                                              }
                                        ?>
                        		<p class="base_name">
                                 <?php 
									$unit = Yii::app()->db->createCommand()
									->select(array(
										'unit.id',
										'unit.unit_name',
										'unit.branch_id',
										'branch.branch_name',
										'base.company_name'
											)
									)
									->from('unit')
									->join('branch', 'branch.id=unit.branch_id')
									->join('base', 'base.id=branch.base_id')
									->where("unit.active_flag=1 and unit.id ='".$thank['division1']."'")
									->orwhere("unit.id ='".$thank['division2']."'")
								    ->orwhere("unit.id ='".$thank['division3']."'")
								    ->orwhere("unit.id ='".$thank['division4']."'")
									->queryRow();
									 echo htmlspecialchars($unit['company_name'])."&nbsp;".htmlspecialchars($unit['branch_name'])."&nbsp;".htmlspecialchars($unit['unit_name']);
							    ?>
								
                                </p>
                        		<p class="name"><?php echo htmlspecialchars($thank['lastname']).' '.htmlspecialchars($thank['firstname']);?></p>
	                        </td>
	                        <td class="td-comment">
	                        	<?php echo nl2br(FunctionCommon::url_henkan($thank['comment']));?>
	                        </td>
	                        <td class="td-edit"><a class="btn btn-work" href="<?php echo Yii::app()->baseUrl; ?>/adminthanks/edit/?id=<?php echo $thank['id'];?>">修正</a><a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/adminthanks/delete/?id=<?php echo $thank['id']; ?>'" href="#" class="btn btn-correct">削除</a></td>
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

