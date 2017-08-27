<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<div class="wrap admin secondary role">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>役割管理 - 登録確認</h2>
                </div>
                <div class="box">
                <?php $form = $this->beginWidget('CActiveForm', array(
						'id' => 'confirm_role_form', 
                        'htmlOptions' => array(
						'enctype' => 'multipart/form-data',
						'class'=>'form-horizontal'
						),));?>
                <div class="cnt-box">
                <div class="form-horizontal">
                
                	<div class="control-group">
                        <div class="control-label">役割名&nbsp;</div>
                        <div class="controls">
                        	<p class="mt5">
                                <input  name="role_name" type="hidden" value="<?php echo htmlspecialchars($roles['role_name']) ?>"/>
                                <?php echo htmlspecialchars($roles['role_name']);?>
                            </p>
                        </div>
                    </div>
                    <?php foreach ($role_management as $key=>$val){
                    ?>
                    <input type="hidden" readonly="readonly" name="data[<?php echo $key ?>][function_id]" value="<?php echo $val['function_id']?>"/>
                    <input type="hidden" readonly="readonly" name="data[<?php echo $key ?>][view]" value="<?php echo $val['view']?>"/>
                    <input type="hidden" readonly="readonly" name="data[<?php echo $key ?>][post]" value="<?php echo $val['post']?>"/>
                    <input type="hidden" readonly="readonly" name="data[<?php echo $key ?>][admin]" value="<?php echo $val['admin']?>"/>
                   
                    <div class="control-group">
                        <div class="control-label"><?php echo htmlspecialchars($val['function_name']) ?>&nbsp;</div>
                        <div class="controls">
                        	<div>
                              <?php if($val['view']==1) echo '<span class="ico view">閲覧</span>';
                              ?>
                              
	                          <?php if($val['post']==1) echo '<span class="ico posts">投稿</span>';
                               ?>
	                          <?php if($val['admin']==1) echo '<span class="ico control">管理</span>';
                              ?>
	                        	
                        	</div>
                        </div>
                    </div>
                   
                    <?php
                    }
                    ?>
                    
                    
                  
                    
                </div>
                    
                </div><!-- /cnt-box -->
                 <?php $this->endWidget(); ?>
                <div class="form-last-btn">
                    <div class="btn170">
                        <button type="submit" class="btn" onclick="history.back();"><i class="icon-chevron-left"></i> もどる</button>
                        <button type="submit" id="submit" class="btn btn-important"><i class="icon-chevron-right icon-white"></i> 登録</button>
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
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

</div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
</div>

</div><!-- /wrap -->
<script>
     jQuery(function($) {
        $('button#submit').click(function(){  
            deleteCookies('rolename');
            deleteCookies('checkdata');                    
            jQuery("form#confirm_role_form").submit();
        });
    });
   
</script>

