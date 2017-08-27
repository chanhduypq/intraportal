<link href="<?php echo $this->assetsBase; ?>/css/asobi/css/secondary.css" rel="stylesheet" type="text/css"/>
<script language="javascript">
jQuery(function($) {        
			$("body").attr('id','asobi');      
		});
</script>
<div class="wrap asobi secondary skill">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox">
            	<div class="pageTtl"><h2>資格取得・スキルアップ！</h2>
                 <?php
               // if(FunctionCommon::isPostFunction("pride")==true){
				?>
                  <a href="<?php echo Yii::app()->baseUrl?>/asobi" class="btn btn-important"><i class="icon-home icon-white"></i> あそびのTopへ戻る</a>
				<?php
				//}
				?>
                </div>
                <div class="box">
                
<!--                <p class="descriptionTxt"> －経営管理本部にて投稿－</p>-->
                
                <ul class="inline category-navi">
                		<?php 
							$i=1;
							foreach ($category as $category_id) {
								
								if($category_id['type']==4){
										
									echo '<li><a href="#category0'.$i.'">'.$category_id['category_name'].'</a></li>';
									$i++;	
								}
							
							}
						?>
                </ul>
                
				<?php 
				    $j=1;
					foreach ($category as $category_id) {
						if($category_id['type']==4){
				?>
                			  <h3 id="category0<?php echo $j;?>" class="category_name"><?php echo $category_id['category_name'];?></h3>
                              <table width="724" border="0" class="table list font14">
            						<tbody>
                <?php
						if ($skills != null && is_array($skills) && count($skills) > 0) 
						{
							foreach ($skills as $skill) 
							{
								if($skill['category_id']==$category_id['id'])
								{
				?>						
                                 <tr class="skill-item">
                                    <td>
                                        <p class="title"><a href="<?php echo $skill['url'];?>" target="_blank"><?php echo htmlspecialchars($skill['title']); ?></a></p>
                                        <p class="comment">
                                            <?php echo nl2br(FunctionCommon::url_henkan($skill->comment));?>
                                        </p>
                                        <ul class="attachements inline">
                                        	<?php if($skill['attachment1']!="") {echo file_skill($skill['attachment1']);}?>
                                            <?php if($skill['attachment2']!="") {echo file_skill($skill['attachment2']);}?>
                                            <?php if($skill['attachment3']!="") {echo file_skill($skill['attachment3']);}?>
                                        </ul>
                                    </td>
                                </tr>	
                <?php       
								}
							}
						}
				?>		
                			</tbody>
                      </table>  
                <?php		
							$j++;	
						}
						
					}
				?>
				
				
                </div><!-- /box -->
            </div><!-- /mainBox -->
            
        </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div><!-- /wrap -->
<?php
	 function file_skill($file1)
	 {
		  $host_file_attachment_ext1 = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase($file1));
		  if (in_array($host_file_attachment_ext1, Constants::$imgExtention)) {  
?>
				<li class="attached-file file1"><span class="icon icon-file"></span><a href="<?php echo Yii::app()->request->baseUrl.$file1;?>" class="btn btn-link" target="_blank">添付ファイル1</a></li>
<?php
 		  }
		  else{
?>
				<li class="attached-file file1"><span class="icon icon-file"></span><a href="<?php echo Yii::app()->request->baseUrl.$file1;?>" class="btn btn-link" target="_blank">添付ファイル1</a></li>
<?php
		  }
	  }
?>