<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>
<script type='text/javascript' src='https://maps-api-ssl.google.com/maps/api/js?sensor=false&language=ja'></script>
<div class="wrap admin secondary office">

    <div class="container index">
        <div class="contents detail">
        	
            <div class="mainBox">
            	<div class="pageTtl">
            		<h2>事業所管理 - 詳細</h2>
	                <span>
                            <?php 
                            if(Yii::app()->request->cookies['page']!= "") 
                            {
                                       $page = "index?page=".Yii::app()->request->cookies['page'];

                            }else {$page ="";}
                            ?>
                            <a class="btn btn-important" href="<?php echo Yii::app()->request->baseUrl; ?>/adminoffice/<?php echo $page;?>"><i class="icon-chevron-left icon-white"></i> 一覧に戻る</a>
                        </span>
	                <span>
                            <?php 
                            if(FunctionCommon::isAdmin()==true){
                            ?>
                            <a class="btn btn-work" href="<?php echo Yii::app()->request->baseUrl; ?>/adminoffice/edit?id=<?php echo $model->id;?>"><i class="icon-pencil icon-white"></i> 修正</a>
                            <?php 
                            }
                            ?>
                        </span>
            	</div>
            	
                <div class="box">
                	<div class="cnt-box form-horizontal">

                        <div class="control-group">
                            <div class="control-label">事業所名</div>
                            <div class="controls">
                                <p><?php echo $model->division_name;?></p>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <div class="control-label">郵便番号</div>
                            <div class="controls">
                                <p><?php echo $model->zipcode;?></p>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <div class="control-label">住所</div>
                            <div class="controls">
                                <p><?php echo $model->address;?></p>
                            </div>
                        </div>
                        <?php 
                        if($model->photo!=""){?>
                            <div class="control-group">
                            <div class="control-label">家屋写真</div>
                            <div class="controls">
	                            <?php                                     
                                    Upload_file_common::echoOfficePhoto( $model->photo,'');
                                    ?>
                            </div>
                        </div>
                        <?php    
                        }
                        ?>
                        

						<div class="googlemap">
	                        <div class="control-label">GoogleMap</div>
	                        <div class="data">
                                    <?php echo $model->googlemap;?>
	                        </div>
                        </div>
                        
					</div><!--// .cnt-box -->				

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