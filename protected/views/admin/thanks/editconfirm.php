



<div class="wrap admin secondary thanks">
    <div class="container">
        <div class="contents confirm">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>今日のありがとう - 修正 確認</h2></div>
                <div class="box">
                      <?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'thanks_form',    
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
?>

                
                    <div class="cnt-box">
                    <div class="form-horizontal">

                        <div class="control-group">
                            <label for="title" class="control-label">部署名&nbsp;</label>
                            <div class="controls">
                                    <p>
                                    <?php 
									$unit = Yii::app()->db->createCommand()
									->select(array(
										'unit.id',
										'unit.unit_name',
										'unit.branch_id',
										'branch.branch_name',
										'base.company_name'
										
										//'user.base_list'
											)
									)
									->from('unit')
									->join('branch', 'branch.id=unit.branch_id')
									->join('base', 'base.id=branch.base_id')
									->where('unit.active_flag=1 and unit.id="'.$model->unit_id.'"')
									->order('unit.created_date desc')
									->queryRow();
									
									 echo htmlspecialchars($unit['company_name'])."&nbsp;".htmlspecialchars($unit['branch_name'])."&nbsp;".htmlspecialchars($unit['unit_name']);
									 ?>
									<?php //echo htmlspecialchars($unit_name);?>
                                    </p>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="title" class="control-label">お名前&nbsp;</label>
                            <div class="controls">
                                    <p><?php echo htmlspecialchars($lastname).' '.htmlspecialchars($firstname);?></p>
                            </div>
                        </div>
                        <?php if($photo!=""){
                            $img_src = ltrim($photo, '/');
                            $imgbinary = fread(fopen($img_src, "r"), filesize($img_src));
                            $img_str = base64_encode($imgbinary);
                            $img="data:image/jpg;base64,".$img_str;    
                            ?>
                        <div class="control-group">
                            <label for="title" class="control-label">対象者写真&nbsp;</label>
                            <div class="controls">
                                    <div class="picture" ondragstart="return false;" ondrop="return false;">
                                        <?php
                                        if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {                                    
                                                echo '<img id="not_download" style="height:52px;" src="'.Yii::app()->request->baseUrl.$photo.'"/>';                                                
                                                if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.') == false) { 
                                                    echo '<img src="data:image/jpg;base64,'.$img_str.'" style="display:none;"/>';
                                                }
                                                

                                            }
                                            else{
                                                echo '<img id="not_download" style="height:52px;" src="'.$img.'"/>';
                                            }
                                        ?>
                                        
                                    </div>
                            </div>
                        </div>
                        <?php }?>
                        <div class="control-group">
                            <label for="content" class="control-label">コメント&nbsp;</label>
                            <div class="controls">
                                    <p><?php echo nl2br(FunctionCommon::url_henkan($model->comment));?>	
                                    </p>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="content" class="control-label">差出人&nbsp;</label>
                            <div class="controls">
                                    <p><?php echo htmlspecialchars($model->sender);?></p>
                            </div>
                        </div>
                        
                        
                        
                        
                    </div>                   
                        
                    
                    </div><!-- /cnt-box -->	
            		
    <?php echo $form->hiddenField($model, 'id'); ?>      
    <?php echo $form->hiddenField($model, 'user_id'); ?>  
    <?php echo $form->hiddenField($model, 'comment'); ?>  
    <?php echo $form->hiddenField($model, 'sender'); ?>  
    <?php echo $form->hiddenField($model, 'unit_id'); ?>                  
                    <input type="hidden" name="edit" id="edit" value="1"/>
       	  <?php $this->endWidget(); ?> 
	                <div class="form-last-btn">
	                	<div class="btn170">
                                    <button type="submit" class="btn" id="back"><i class="icon-chevron-left"></i>  もどる</button>                                    
                                    <button class="btn btn-important" id="submit" type="submit"><i class="icon-chevron-right icon-white"></i>   更新</button>
	                    </div>
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
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/jquery.cookies.js"></script>
<script type="text/javascript">
    
    
    jQuery(function($) { 
        $('img#not_download').contextmenu( function() {
            return false;
        });
        
    
        
        $("body").attr('id','admin');          
        
        setCookie("thanks_edit_sender",$("#Thanks_sender").val());
        setCookie("thanks_edit_comment",$("#Thanks_comment").val());
        setCookie("thanks_edit_unit_id",$("#Thanks_unit_id").val());
        setCookie("thanks_edit_user_id",$("#Thanks_user_id").val());
        
        
        
        
        
       
        $('button#submit').click(function(){  
           
           
            jQuery("input#edit").val('1');            
            jQuery("form#thanks_form").submit();
        });
        $('button#back').click(function(){
           
                          
            window.location="<?php echo Yii::app()->baseUrl;?>/adminthanks/edit/?id=<?php echo $model->id;?>";
        });
        
     
        
        
    });
     
    
</script>
