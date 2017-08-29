
<link href="<?php echo $this->assetsBase; ?>/css/admin/css/post.css" rel="stylesheet" type="text/css"/>
<style>
    a.disable_change{
        opacity:0.3;filter: alpha(opacity = 30);
    }
</style>
<script language="javascript">
jQuery(function($) {        
			$("body").attr('id','admin');      
			
			});
//        function actionChange(actionSelect)
//	{
//            jQuery(actionSelect).parent().parent().parent().parent().parent().find("td").css("border-top","1px #CCC dotted");
//            jQuery(actionSelect).parent().parent().find("a").eq(0).removeClass("disable_change");
//            jQuery(actionSelect).parent().parent().find("a").eq(0).bind("click", function() {
//                var ok = confirm('更新します。よろしいですか？');
//                if(ok == true) {
//                    id=jQuery(this).attr("id");                    
//                    id=id.substr(16);                    
//                    jQuery('form#upmodifiable_'+id).attr('action','<?php echo Yii::app()->baseUrl; ?>/adminbase/upmodifiable/');
//                    jQuery('form#upmodifiable_'+id).submit();					
//                }  
//            });
//		trNode=jQuery(actionSelect).parent().parent().parent().parent().parent().prev();
//                if(jQuery(trNode).attr("class")==undefined||jQuery(trNode).attr("class")!="newgin"){
//                    jQuery(trNode).remove();
//                }
//        if(jQuery(actionSelect).val()=='1'){
//            return;
//        }
//        jQuery.ajax
//		({
//				type: "GET", 
//				async:true,
//				url: "<?php echo Yii::app()->baseUrl;?>/adminbase/unit/?unit_id="+jQuery(actionSelect).parent().find("input#Unit_id").eq(0).val(),    
//				success: function(data)
//				{
//					
//					 
//                                         
//					 if(data!="0")
//					 {
//						 
//						 
//                                                 jQuery(actionSelect).parent().parent().find("a").eq(0).addClass("disable_change");
//                                                 jQuery(actionSelect).parent().parent().find("a").eq(0).unbind("click");
//                                                 div=document.createElement('div');
//                                                         jQuery(div).addClass('alert');
//                                                         jQuery(div).addClass('error_message');
//                                                         jQuery(div).html('部署に所属する'+data+'人のユーザーがいます。ユーザー管理にて所属部署を変更してください');
//                                                         tr=document.createElement('tr');
//                                                         td=document.createElement('td');
//                                                         jQuery(td).attr("colspan","3");                                                         
//                                                         jQuery(td).append(div);
//                                                         jQuery(tr).append(td); 
//                                                         jQuery(actionSelect).parent().parent().parent().parent().parent().find("td").css("border","none");;
//                                                         jQuery(tr).insertBefore(jQuery(actionSelect).parent().parent().parent().parent().parent());
//					 }
//				 }
//		});
//    }                
</script>
<div class="wrap admin secondary base">

    <div class="container index">
        <div class="contents detail">
        	
            <div class="mainBox">
            	<div class="pageTtl">
            		<h2>部署管理 > 部署一覧</h2>
            		<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminbase/" class="btn btn-important"><i class="icon-chevron-left icon-white"></i> 会社一覧に戻る</a>
            		<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminbase/branch/?base_id=<?php echo $_GET['base_id'];?>" class="btn btn-important"><i class="icon-wrench icon-white"></i> 部門管理</a>
            		<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminbase/regist/?base_id=<?php echo $_GET['base_id'];?>" class="btn btn-important"><i class="icon-pencil icon-white"></i> 登録</a>
            	</div>
            	
                <div class="box">
                	<h3 class="company-name"><?php echo $base_company['company_name']?></h3>
					<table class="table list font14">
	                	<thead>
	                		<tr>
		                		<th class="name">部門・部署名</th>
		                		<th class="updown">並び替え</th>
		                		<th class="actions">編集</th>
	                		</tr>
	                	</thead>
	                	<tbody>
                        	<?php
							if(isset($units)&&is_array($units)&&count($units)>0){
									foreach ($units as $unit){     
							?>        
	                		<tr class="newgin" id="<?php echo $unit['id'];?>">
								<td class="name">
                                <?php if($unit['modifiable_flag']=='1'){?> 
                                   <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminbase/detail/?base_id=<?php echo $_GET['base_id']; ?>&id=<?php echo $unit['id']; ?>"><?php echo $unit['branch_name']?>&nbsp;<?php echo $unit['unit_name']?></a>
                                 <?php }else{?> 
                                   <a href="#"><?php echo $unit['branch_name']?>&nbsp;<?php echo $unit['unit_name']?></a>
                                 <?php }?>
                                </td>
								<td class="updown">
                                	<?php if($unit['modifiable_flag']=='1'){?> 
										<a id="down-btn" href="#" class="btn down-btn">↓</a>
										<a id="up-btn" href="#" class="btn up-btn">↑</a>
                                     <?php }else{?>   
                                   	    <a style="opacity:0.3;filter: alpha(opacity = 30);"  href="#" class="btn down-btn">↓</a>
										<a style="opacity:0.3;filter: alpha(opacity = 30);"  href="#" class="btn up-btn">↑</a>
                                     <?php }?>
								</td>
								<td class="actions">
                                                                    
									<ul class="inline">
										<li class="edit">
                                         <?php if($unit['modifiable_flag']=='1'){?> 
                                       <a href="<?php echo Yii::app()->request->baseUrl; ?>/adminbase/edit/?base_id=<?php echo $_GET['base_id']; ?>&id=<?php echo $unit['id']; ?>" class="btn btn-work inline">修正</a>
                                        <?php }else{?> 
                                        <a style="opacity:0.3;filter: alpha(opacity = 30);" class="btn btn-work inline">修正</a>
                                        <?php }?> 
                                        </li>
										<li class="state inline">
                                       		
                                        	<?php
												$form = $this->beginWidget('CActiveForm', array(
													'id' => 'upmodifiable_'.$unit['id'],                     
													'htmlOptions' => array(                                         
																		  'style'=>'display:inline-block',
																		  ),
														));
												?>	  	
                                                <input type="hidden" name="table_name" value="unit"/>
                                            	<?php 
                                                if($unit['user_count']>0){
                                                    $typemodifiable_flag_array=array('1'	=> '有効');
                                                }
                                                else{
                                                    $typemodifiable_flag_array=  Constants::$typemodifiable_flag;
                                                }
												 echo $form->hiddenField($model, 'id',array('value'=>$unit['id']));
												 echo $form->hiddenField($model, 'base_id',array('value'=>$_GET['base_id']));
												 echo $form->dropDownList($model,'modifiable_flag',
																		 $typemodifiable_flag_array,
																		 array('class'=>'input-small',
																		 	  'options' => array($unit['modifiable_flag']=>array('selected'=>true))));
												?>
                                               <?php $this->endWidget(); ?>
                                                <?php
                                                                                            if($unit['user_count']>0){?>
                                                                                            <a id="modifiable_flag_<?php echo $unit['id']?>" class="btn btn-correct disable_change">更新</a>
                                                                                            <?php
                                                                                            }
                                                                                            else{
                                                                                            ?>
                                                                                            
                                              <script type="text/javascript">
												jQuery(function($) 
												{
													//up modifiable_flag
													$("td.actions a#modifiable_flag_<?php echo $unit['id']?>").click(function(){          
															var ok = confirm('更新します。よろしいですか？');
															if(ok == true) {
																jQuery('form#upmodifiable_<?php echo $unit['id']?>').attr('action','<?php echo Yii::app()->baseUrl; ?>/adminbase/upmodifiable/');
																jQuery('form#upmodifiable_<?php echo $unit['id']?>').submit();					
																}  
														});    
												});
											  </script>
                                               <a id="modifiable_flag_<?php echo $unit['id']?>" class="btn btn-correct">更新</a>
                                                 <?php
                                                                                            }
                                                 ?>
                                              
										</li>
									</ul>
								</td>
							</tr>
                            <?php 
								}
							}
							?>
						</tbody>
                     </table>   
				
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

<form id="up-down" action="<?php echo Yii::app()->baseUrl."/adminpost/updown/";?>">
    <input type="hidden" name="id1" id="id1"/>
    <input type="hidden" name="id2" id="id2"/>
    <input type="hidden" name="table_name" value="unit"/>
</form>
