<?php
class Golf_newswidget extends CWidget
{
    public $assets_base;
    public function init()
	{
	}

	public function run()
	{
//		$sql		=	"select * from golf_news order by created_date desc limit 13";
//		$connection =	Yii::app()->db; 
//		$command	=	$connection->createCommand($sql); 
//		$bbs 		=	$command->queryAll();
//		
//		$sql2		=	"select * from category where type = 5 order by created_date desc";
//		$connection_category =	Yii::app()->db; 
//		$command_category	=	$connection_category->createCommand($sql2); 
//		$category 		=	$command_category->queryAll();
                $golf_news = Yii::app()->db->createCommand()
                        ->select(array(
                            'golf_news.id',
                            'golf_news.title',
                            'golf_news.content',
                            'golf_news.created_date',
                            'category.category_name',
                            'background_color',
                            'text_color',
                            'eye_catch'
                                )
                        )
                        ->from('golf_news')
                        ->leftJoin("category", "category.id=golf_news.category_id")                        
                        ->limit(13)
                        ->order('golf_news.created_date desc')
                        ->queryAll();
	 $golf_news_comment = Yii::app()->db->createCommand()
                        ->select(array(
                            'golf_news_id'
                                )
                        )
                        ->from('golf_news_comment')
                        ->queryAll();		

                                            
		$urlIndex	=	Yii::app()->baseUrl.'/asobigolf_news/';
		$urlRegist	=	Yii::app()->baseUrl.'/asobigolf_news/regist';
?>	
		<div class="boxL">
            <div class="ttl">
            	<h3>お知らせ・結果報告・参加募集</h3>
                <?php 
                if(FunctionCommon::isViewFunction("golf_news")==true){?>
                    <a href="<?php echo $urlIndex;?>" class="middleBtn listview">一覧を見る</a>
                <?php
                }
                else{
                    $golf_news=array();
                }
                ?>                
                <?php 
                if(FunctionCommon::isPostFunction("golf_news")==true){?>
                    <a href="<?php echo $urlRegist;?>" class="miniBtn regist02">登録</a>		
                <?php
                }
                ?>
                
           </div>   
           <?php
         
					foreach($golf_news as $object)
					{			
		   ?> 
           <ul>
           		<?php
                        if($object['eye_catch']!=""){
                            $thumnail_file_path=  FunctionCommon::getFilenameInThumnail($object['eye_catch']);
                            $temp= explode(".", $thumnail_file_path);
                            $new_thumnail_file_path=$temp[0];
                            for($i=1,$n=count($temp)-1;$i<$n;$i++){
                                $new_thumnail_file_path.='.'.$temp[$i];
                            }
                            $new_thumnail_file_path.='_widget'.'.'.$temp[count($temp)-1];
                            $thumnail_file_path=$new_thumnail_file_path;
                        }
                        
                	if($object['eye_catch']&&file_exists(Yii::getPathOfAlias('webroot').$thumnail_file_path)){
							
							  //$host_file_attachment_ext1 = Upload_file_common::getFileNameExtension(Upload_file_common::getFileNameFromValueInDatabase($object['eye_catch']));
			 				  echo '<li class="photo">';					  
                                                          
                                                          list($width, $height)=getimagesize(Yii::getPathOfAlias('webroot').$thumnail_file_path);
                                                          
                                                          if($width>70){
                                                              $width='70px';
                                                          }    
                                                          else{
                                                              $width.='px';
                                                          }
                                                          if($height>52){
                                                              $height='52px';
                                                          }                                                          
                                                          else{
                                                              $height.='px';
                                                          }
                                                          echo '<img style="width:'.$width.';height:'.$height.';" src="'.Yii::app()->request->baseUrl.$thumnail_file_path.'"/>';
							  echo '</li>';
					}
					else{
				?>
               <li class="photo"><img src="<?php echo $this->assets_base; ?>/css/common/img/img_photo01.gif" /></li>
                <?php }?>            
                <li class="text">
                    <p class="dateBox">
                        <span class="date"><?php echo FunctionCommon::formatDate($object['created_date']); ?></span>
                        <?php 
                        if($object['category_name']!=""){
                             echo '<span class="label" style="margin-left:10px; padding:1px 4px;'.($object['background_color']!=""?"background:".$object['background_color'].';':"").($object['text_color']!=""?"color:".$object['text_color'].';':'').'">';  
                             echo $object['category_name'];
                             echo '</span>';
                        }
                        ?>                        
                    </p>
                    <p><a href="<?php echo Yii::app()->request->baseUrl; ?>/asobigolf_news/detail/?id=<?php echo $object['id']; ?>"><?php echo FunctionCommon::crop(htmlspecialchars($object['title']),25); ?></a></p>
                    <p class="count">
                    <?php
                     $i = 0; 
					 foreach ($golf_news_comment as $comment) {
						 if($object['id']==$comment['golf_news_id']){ 
						 $i = $i+1;
						 } 
					 }
					?>
                    レスポンス数：（<?php echo $i;?>）</p>
                </li>
            </ul> 
           <?php 
					}
		   		
		   ?> 	
        </div>    
<?php		
		
	}
}        