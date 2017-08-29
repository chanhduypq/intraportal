
<link href="<?php echo $this->assetsBase; ?>/css/majime/css/department.css" rel="stylesheet" type="text/css" />
<body id="majime">
<div class="wrap single member">
    <div class="container">
        <div class="contents detail">
			<div class="mainBox">
            	<div class="pageTtl">
						<h1>部署選択</h1>
                        <span><a href="<?php echo Yii::app()->request->baseUrl; ?>/majime/" class="btn btn-important"><i class="icon-home icon-white"></i> マジメTOPに戻る</a></span>
				</div>
                <div class="box area">
                     <div class="baseDetailBox mt10 department">
                    	<?php 
							if($base != null){ 
								 foreach($base as $item){ 
                     			   echo "<h2>".$item['company_name']."</h2>";
						 ?>
						 
                         	<?php
								 $branch  = Yii::app()->db->createCommand("select branch_name,id from branch where active_flag=1 and base_id ='".$item['id']."' and modifiable_flag=1 order by display_order ASC")->queryAll();
								 foreach($branch as $branch_item){ 
							?>
                         <ul class="dep01">
                         <ul class="dep2">	
                            				<!--<li><a ><?php //echo $branch_item['branch_name']?></a></li>-->
                            <?php	 		
								 		$unit   = Yii::app()->db->createCommand("select unit_name,id ,branch_id from unit where active_flag=1 and branch_id = '".$branch_item['id']."' and modifiable_flag=1 order by display_order ASC")->queryAll();	
								 			foreach($unit as $unit_item){ 	
                            ?>
                                                         <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/majimemember/detail/?id_unit=<?php echo $unit_item['id']; ?>&id_branch=<?php echo $branch_item['id']; ?>"><?php echo $branch_item['branch_name'];if(trim($unit_item['unit_name'])!=""){ echo "&nbsp;".$unit_item['unit_name'];}?></a></li>
							<?php
											}
							?>
                         </ul>   
						 </ul>	
                            <?php				
								}
						}
					} 
					?>
						
                    </div><!-- /baseDetailBox -->
                            
                </div><!-- /box -->
            </div><!-- /mainBox -->
            
            
  </div><!-- /contents -->

</div><!-- /container -->
    
</div><!-- /wrap -->
    
<script src="../../common/js/bootstrap.min.js"></script>
</body>