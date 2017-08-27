<?php

class Thankswidget extends CWidget 
{

    public $assets_base;
    public function run() 
	{
        if(FunctionCommon::isViewFunction("thanks")==true){
            $thanks = Yii::app()->db->createCommand()
                    ->select(array(
                        'thanks.id',
						'thanks.comment',
						'thanks.sender',
						'lastname',
						'firstname',
						'user.photo',
						'user.division1',
						'user.division2',
						'user.division3',
						'user.division4',
                                                'user.photo_public_flag'
                            )
                    )
                    ->from('thanks')
                    ->join('user', 'user.id=thanks.user_id')                
                    //->limit($page_size, ($page - 1) * $page_size)
                    ->order('thanks.created_date desc')
                    ->queryAll();
        }
        else{
            $thanks=array();
        }
        echo '<p class="descriptionTxt"> －経営管理本部にて投稿－<br/>区切りが分かりづらい点を修正</p>';
        if(is_array($thanks)&&count($thanks)>0){?>
            <ul class="thanks_month">
                <?php
                foreach ($thanks as $thank){?>               
                
                <li class="listImg"><?php 
                if($thank['photo']!=""&&  file_exists(Yii::getPathOfAlias('webroot').FunctionCommon::getFilenameInThumnail($thank['photo']))&&$thank['photo_public_flag']=="1"){ 
                    $img_src = ltrim($thank["photo"], '/');
                    $imgbinary = fread(fopen($img_src, "r"), filesize($img_src));
                    $img_str = base64_encode($imgbinary);                    
                    if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {                                    
                        echo '<img ondragstart="return false;" ondrop="return false;" id="not_download" src="'.Yii::app()->request->baseUrl.$thank["photo"].'" style="height: 52px;"/>';
                        if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.') == false) { 
                            echo '<img src="data:image/jpg;base64,'.$img_str.'" style="display:none;"/>';
                        }
                        

                    }
                    else{
                        echo '<img ondragstart="return false;" ondrop="return false;" id="not_download" src="data:image/jpg;base64,'.$img_str.'" style="height: 52px;"/>';
                    }
                }
                    else{?> <img src="<?php echo $this->assets_base; ?>/css/common/img/img_photo01.gif" /><?php } ?></li>
                    <li class="listPerson">
                        <p class="name"><?php echo htmlspecialchars($thank['lastname']).' '.htmlspecialchars($thank['firstname']);?></p>
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
									->orwhere("unit.active_flag=1 and unit.id ='".$thank['division1']."'")
									->orwhere("unit.id ='".$thank['division2']."'")
								    ->orwhere("unit.id ='".$thank['division3']."'")
								    ->orwhere("unit.id ='".$thank['division4']."'")
									->queryRow();
						?>
                        <span class="area"><?php  echo '('.htmlspecialchars($unit['company_name'])."&nbsp;".htmlspecialchars($unit['branch_name'])."&nbsp;".htmlspecialchars($unit['unit_name']).')';?></span>
                    </li>
                    <li class="listTxt"><?php echo $this->crop(nl2br(htmlspecialchars($thank['comment'])),50); ?></li>
                    <li class="listName" style="margin-bottom: 20px;"><?php echo htmlspecialchars($thank['sender']).'より';?></li>
                <?php
                }
                ?>
            </ul>       
<?php
        }
    }
    
    private function getBaseById($id) {
        if(!is_numeric($id)){
            return '';
        }
        $branch_name = Yii::app()->db->createCommand()
                ->select('branch_name')
                ->from('base')
                ->where("id=$id")
                ->queryScalar();
        if ($branch_name == FALSE) {
            return '';
        }
        return $branch_name;
    }
    private function crop($text, $len) {
        $arr_replace = array("<p>", "</p>","<b>", "</b>","");
        $text = str_replace($arr_replace,"",$text);
        if ($len > strlen(utf8_decode($text))) {
            $string = $text;
        } else {
            $string_cop = mb_substr($text, 0,$len,'UTF-8'); 
            $string = $string_cop . "...";
        }
        return $string;
    }



}
?>




