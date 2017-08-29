



<div class="wrap admin secondary zentaishihyou">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>全体指標 - 設定</h2></div>
                
                <div class="box">
               <?php
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'zentaishihyou_form',                     
                    'htmlOptions' => array(
                                          'enctype' => 'multipart/form-data',
                                          'class'=>'form-horizontal',
										                                     
                                          ),
                        )); 
                ?> 
                <div class="cnt-box">
                    <?php if(isset($error)){
						echo "<div id='error_message1' class='alert info'>".Lang::MSG_0034."</div>";
					}else{ ?>
                    <div id="error_message1"></div>
                    <?php }?>
                    <div class="control-group">
                        <label class="control-label" for="content">掲載ファイル&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	<style>
							div.hide{display:none;}
							</style>
                             
								
							 
		                    <div class="thumb"> 
                            
                            <?php
								
								@mkdir("upload/zentaishihyou2/"); 
								define('PATH', 'upload/zentaishihyou2/');
								$path = "/upload/zentaishihyou2/";
								$files = array();
								if(file_exists(Yii::getPathOfAlias('webroot').'/upload/zentaishihyou2')){
									$dir = opendir(PATH);
									while ($f = readdir($dir)){
											 if ($f != "." && $f != "..") {
													array_push($files,$f);
											 }
									}
									closedir($dir);
								}
				
								if ((isset($error) && $error =="2") || !isset($error)){	

									if(!empty($files) && isset($files['1'])){
										
										$url = "upload/zentaishihyou2/".$files['1'];
										$file_name = $files['1'];	 
										echo '<input  type="hidden" name="file_ola" value="'.$file_name.'" />'; 
									}
								
                            	if(isset($url)){ 
								if(file_exists($url) )
								  { 
								   	 $host_file_attachment_ext=FunctionCommon::getExtensionFile($file_name);
									 if (in_array($host_file_attachment_ext, Constants::$imgExtention)) {
										$filename = $url;
                                                                                $thumnail_file_path=  FunctionCommon::getFilenameInThumnail('/'.$url);
                                                                                if(file_exists(Yii::getPathOfAlias('webroot') .$thumnail_file_path)){
                                                                                    $thumnail_file_path=ltrim($thumnail_file_path, '/');            
                                                                                list($width, $height) = getimagesize($thumnail_file_path);  
										
                                                                                printf(' <a rel="prettyPhoto" href="'.Yii::app()->request->baseUrl.'/'.$filename.'"><img style="width:'.$width.'px;height:'.$height.'px;" src="'.Yii::app()->request->baseUrl.'/'.$thumnail_file_path.'"/></a>');            
                                                                                }
                                                                                
										} 	 
								  }
                                                                  
								}
							}
							?>
                           </div>

                        	<input id="attachment" type="file" name="zentaishihyou"  />
                        	<a style="cursor:pointer" id="delete_file" class="btn btn-link"><span class="icon icon-remove"></span> この画像を削除</a>
                          
                        </div>
                    </div>
                    
                </div><!-- /cnt-box -->
                
                <div class="form-last-btn">
                	<p class="btn80">
	                    <button id="submit" type="submit" class="btn btn-important"><i class="icon-chevron-right icon-white">　</i> 設定</button>
                    </p>
                </div>
                
               <?php $this->endWidget(); ?>
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
<script type="text/javascript">
	jQuery(function($)
	{      
	   $("body").attr('id','admin'); 
	   $('button[type="submit"]').click(function(){
		   
		   var ok = confirm('この画像ファイルを全体指標に設定します。');  
		   
		   if(ok ==true)
		   {  
					if(checkFile()==false){				  															  
						 return false; 
					}else{
						$("#zentaishihyou_form").attr('action','<?php echo Yii::app()->baseUrl;?>/adminzentaishihyou/');      
						return true; 
						
					}
		   }
		   else{
			    return false; 
			   }
		});
		// delete file show
		 $('a#delete_file').click(function(){
			 	 $('a#delete_file').append('<input id="delete_file2" type="hidden" name="delete_file" value="<?php if(isset($file_name)){ echo $file_name;}?>">');
				 jQuery("div.thumb").addClass("hide");
                                 $.ajax({                                        
                                    async:true,
                                    url: "<?php echo Yii::app()->baseUrl;?>/adminzentaishihyou/deleteajax/"
                                });
		});		
	});  	
	function checkFile(){
	
		var result	 = true;
		$("#error_message1").html("");
		$("#error_message1").removeClass("alert info");
	
		var checkBox1  = jQuery('#attachment_checkbox_for_deleting').is(":checked");
		
		var arr_file1	   = [".jpg" , ".gif", ".png", ".jpeg"];			
		var attachment1	   = jQuery('#attachment').val();
		var delete_file	   = jQuery('#delete_file2').val();
		
		checkFile1	   	   = attachment1.substr(attachment1.lastIndexOf('.'));
		checkFile1		   = checkFile1.toLowerCase();
	
		file1			   = jQuery.inArray(checkFile1, arr_file1);
	
		
		if(attachment1 =="" && delete_file==undefined )
		{
				   jQuery("#error_message1").html("<?php echo Lang::MSG_0108 ?>");	
				   jQuery("#error_message1").addClass("alert info");
				   result = false;
		}
		else
		if(file1 == -1 && attachment1 !="")
		{
				   jQuery("#error_message1").html("<?php echo Lang::MSG_0033 ?>");	
				   jQuery("#error_message1").addClass("alert info");
				   result = false;
		}
		
		
		return result;
	}
	
</script>