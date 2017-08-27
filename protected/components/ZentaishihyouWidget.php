<?php
class ZentaishihyouWidget extends CWidget
{
	public function init()
	{
	}

	public function run()
	{
		define('PATH', 'upload/zentaishihyou2/');	
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
		
		echo ' <div class="box shihyou"> <div class="ttl"><h2>全社指標</h2></div>';						
		if(!empty($files) && isset($files['1'])){
?>
		
            <span style="text-align:center;">
            <?php		
								$url = "upload/zentaishihyou2/".$files['1'];
								$file_name = $files['1'];	 
							
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
										
                                                                                

                                                                                if ($width > 364) {
                                                                                    $width = '364';
                                                                                }
                                                                                if ($height > 273) {
                                                                                    $height = '273';
                                                                                } 
                            
										
                                                                                printf(' <a rel="prettyPhoto" href="'.Yii::app()->request->baseUrl.'/'.$filename.'"><img style="width:'.$width.'px;height:'.$height.'px;" src="'.Yii::app()->request->baseUrl.'/'.$thumnail_file_path.'"/></a>');            
                                                                                }
										} 	 
								  }
								}
			?>
            </span>
       
<?php	
			
		}
		echo '</div>';
	}
}