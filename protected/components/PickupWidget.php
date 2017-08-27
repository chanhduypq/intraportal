<?php
class PickupWidget extends CWidget 
{

    public function init() 
	{
        
    }
    public $assetsBase;

    public function run()
	{
        $sql_pickup = "select * from pickup where DATE(pickup_date)=DATE(NOW()) ORDER BY created_date DESC limit 0,1";
        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql_pickup);
        $pickup = $command->queryRow();

		echo '<div class="box pickup">';
		echo '<h2 class="ttl">今日の社員ピックアップ</h2>';
		if(FunctionCommon::isViewFunction("pickup")==true)
		{ 
			if (!is_null($pickup) && !empty($pickup['user_id'])) 
			{
				$sql_user = "select * from user where id=" .$pickup['user_id'];
				$user = Yii::app()->db->createCommand($sql_user)->queryRow();
				if(!is_null($user))
				{
					
					$unit = Yii::app()->db->createCommand()
						->select(array(
							'unit.id',
							'unit.unit_name',
							'branch.branch_name',
							'base.company_name'
								)
						)
						->from('unit') 
						->join('branch', 'branch.id=unit.branch_id')
						->join('base', 'base.id=branch.base_id')
						->where("unit.active_flag=1 and unit.id=".$pickup['unit_id']."")
						->queryRow();
					
					$a=new Controller(1);
					if(!is_null($user['photo']) && !empty($user['photo'])&&file_exists(Yii::getPathOfAlias('webroot') . $user['photo'])&&$user['photo_public_flag']=='1')
					{
						$img =  Yii::app()->baseUrl . $user['photo'];
					}
					else
					{
                                            
						$img =  $a->assetsBase .'/css/common/img/img_dummyman.jpg';
					}
					
					$now_year = date('Y');
					if ($now_year > $user['joindate']) 
					{
						$joindate = $now_year -  $user['joindate'];
					} 
					else
					{
						$joindate = '-';
					}
				
					echo '<ul>';
					echo '<li>';
					echo '<span class="name">'.$user['lastname'].' '.$user['firstname'].'&#12288;さん</span>';
					
					echo '</li>';
					echo '<li>';
                                        echo '<div ondragstart="return false;" ondrop="return false;" class="face" style="cursor:pointer;" id="div_pickup">';
                                        if($img!=$a->assetsBase .'/css/common/img/img_dummyman.jpg'){
                                            $img_src = ltrim($user["photo"], '/');
                                            $imgbinary = fread(fopen($img_src, "r"), filesize($img_src));
                                            $img_str = base64_encode($imgbinary);
                                            $img="data:image/jpg;base64,".$img_str;   
                                            if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {                                    
                                                echo '<img id="not_download" src="'.Yii::app()->request->baseUrl.$user["photo"].'"/>';
                                                if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.') == false) { 
                                                    echo '<img src="data:image/jpg;base64,'.$img_str.'" style="display:none;"/>';                                                            
                                                }
                                                //echo '<img src="data:image/jpg;base64,'.$img_str.'" style="display:none;"/>';

                                            }
                                            else{
                                                echo '<img id="not_download" src="data:image/jpg;base64,'.$img_str.'"/>';
                                            }
                                        }
                                        else{
                                            echo '<img id="not_download" src="'.$img.'"/>';
                                        }
					

                                        
                                        echo '</div>';
					echo '<span class="department">'.$unit['company_name'].'&nbsp;'.$unit['branch_name'].'&nbsp;'.$unit['unit_name'].'</span>';
					echo '<p class="joined">入社'.$joindate .'年目</p>';
					echo '</li>';
					echo '<li>';
					echo '<h3 class="subttl">'.FunctionCommon::crop($user['catchphrase'], 100).'</h3>';
                                        $comment=$user['comment'];//                                       
                                        $comment=preg_replace('/(\s|　)/','',$comment);
					echo '<p>'.htmlspecialchars(FunctionCommon::crop($comment, 200)). '</p>';
					echo '</li>';
					echo '</ul>';
				}
			}
		}		
		echo '</div>';
                if(isset($user)&&$user!=FALSE&&  is_array($user)){
                ?>
<div class="popup_user" style="display:none;" id="div_pickup_content"> 

<div class="wrap single department">

    <div class="container">
        <div class="contents detail">
            <div class="mainBox">
                    <div class="pageTtl"><h1>社員プロフィール</h1>
                        <span style="display: none;"><a href="#" class="btn btn-important"><i class="icon-remove icon-white"></i> とじる</a></span></div>
        
                    <div class="box">
    
                    <div class="baseDetailBox">
                    
                    <div class="prf_all">
                    <div class="prf_left">
                    
<!--                     <a  href="#popup_user_<?php echo $user['id']?>">-->
                     <?php 
                     if(!is_null($user['photo']) && !empty($user['photo']) && $user['photo_public_flag']=='1'&&file_exists(Yii::getPathOfAlias('webroot') . $user['photo'])){
                        $file_name=Upload_file_common::getFileNameFromValueInDatabase($user['photo']);
                        $ext = strtolower(Upload_file_common::getFileNameExtension($file_name));
                        Upload_file_common::echoEyeCatch_popMemberdetail($ext, $user['photo'],'');	
                        
                     } else{ ?>
                        <img style="width:300px;" src="<?php echo  $this->assetsBase; ?>/css/common/img/img_dummyman.jpg">
                     <?php } ?>  
<!--                    </a>-->
                    <br /><?php echo htmlspecialchars($user['lastname'].$user['firstname'])?>（<?php echo htmlspecialchars($user['lastname_kana'].$user['firstname_kana'])?>） 
                    </div>
                    <div class="prf_right">
                    <table>
                    <tr><th colspan="2"><?php echo htmlspecialchars($user['catchphrase'])?></th></tr>
                    <tr><th>入社年</th><td><?php echo $user['joindate'];?>年</td></tr>
                    <tr><th>部署</th><td>
                    	
                   		 <?php echo htmlspecialchars($unit['company_name']);?>
                    <br />
                    <span class="prf01">
						<?php echo htmlspecialchars($unit['branch_name']);?>
                    </span>　
                    <span class="prf02">
						<?php echo htmlspecialchars($unit['unit_name']);?>
                    </span>　
                    <span class="prf03">
						<?php 
                                if($unit['id']==$user['division1']){
                                      $position = $user['position1'];
                                }
                                else if($unit['id']==$user['division2']){
                                      $position = $user['position2'];
                                }
                                else if($unit['id']==$user['division3']){
                                      $position = $user['position3'];
                                }
                                else if($unit['id']==$user['division4']){
                                      $position = $user['position4']; }
                            
                                $post  = Yii::app()->db->createCommand("select post_name from post where id ='".$position."'")->queryRow();	
                                echo htmlspecialchars($post['post_name']);	
                         ?>
                    </span>
                    </td></tr>
                    <tr><th>コメント</th><td><p style="overflow-y: scroll;height: 260px;"><?php echo nl2br(htmlspecialchars($user['comment']));?></p></td></tr>
                    </table>
                    </div>
                    <br class="prf_clear" />
                    </div>
                                        
                    </div><!-- /baseDetailBox -->      
                </div><!-- /box -->
            </div><!-- /mainBox -->     
                    
  </div><!-- /contents -->

</div><!-- /container -->
    
</div><!-- /wrap -->                                               
</div>
<?php
                }
	}

}
?>

