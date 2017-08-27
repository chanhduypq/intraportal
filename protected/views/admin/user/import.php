<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>

<div class="wrap admin secondary user">

    <div class="container">
        <div class="contents detail">
        	
            <div class="mainBox">
            	<div class="pageTtl">
            		<h2>ユーザー管理 - CSVインポート</h2>
                        <span><a href="<?php echo Yii::app()->baseUrl;?>/adminuser" class="btn btn-important"><i class="icon-chevron-left icon-white"></i> 一覧に戻る</a></span>
            	</div>
                <div class="box">
	                <form class="form-horizontal" action="<?php echo Yii::app()->baseUrl.'/adminuser/import'; ?>" enctype="multipart/form-data" id="frmimport" method="post">
        	            <div class="cnt-box">
                            <div class="baseDetailBox">
            	                <div class="field attachements">
                    	            <div class="title">社員CSVファイル</div>
                        	    </div>
                                
            	            	<div class="control-group">
                                	<label class="control-label" for="inport_file">CSVファイル&nbsp;
    	                        	<span class="label label-warning">必須</span></label>
                                	<div class="controls">
                                    	<input name="inport_file" class="input-xlarge" type="file">
                             	   </div>
    							</div>
    							                            
    						</div>
                   		</div><!-- /cnt-box -->
                
	                <div class="form-last-btn">
	                	<p class="btn170">
		                    <button type="submit" class="btn btn-important" onclick="return $('#frmimport').submit();"><i class="icon-chevron-right icon-white">　</i> インポート</button>
	                    </p>
	                </div>
	                
	                </form>

    	            <div class="cnt-box">
        	            <div class="baseDetailBox">
        	            	
            	            <div class="field attachements">
                	            <div class="title">インポート結果</div>
                    	    </div>

							<div id="result">
							<?php if(!empty($msg)){ ?>
                                <div>
                        	    <?php
                                    if($numRecordSuccess>0){
                                        echo '正常に登録した件数: '.$numRecordSuccess.'<br/>';
                                    }
                                    if((is_array($error_row_array)&&count($error_row_array)>0)||(is_array($exist_employeenumber_row_array)&&count($exist_employeenumber_row_array))){
                                        $count1=is_array($error_row_array)?count($error_row_array):0;
                                        $count2=is_array($exist_employeenumber_row_array)?count($exist_employeenumber_row_array):0;
                                        $count=$count1+$count2;
                                        echo '異常発生した件数: '.$count.'<br/>';
                                    }
                                    if(is_array($exist_employeenumber_row_array)&&count($exist_employeenumber_row_array)>0){
                                        
                                        echo '　　登録済みデータ(行目): ';    
                                        echo $exist_employeenumber_row_array[0];
                                        if(count($exist_employeenumber_row_array)==1){
                                            echo '.';
                                        }
                                        for($i=1,$n=count($exist_employeenumber_row_array);$i<$n;$i++){
                                            echo ",".$exist_employeenumber_row_array[$i];
                                            if($i==$n-1){
                                                echo '.';
                                            }
                                        }
                                        echo '<br/>';                                        
                                    }
                                    if(is_array($error_row_array)&&count($error_row_array)>0){
                                        
                                        echo '　　データ誤り(行目): ';
                                        echo $error_row_array[0];
                                        if(count($error_row_array)==1){
                                            echo '.';
                                        }
                                        for($i=1,$n=count($error_row_array);$i<$n;$i++){
                                            echo ",".$error_row_array[$i];
                                            if($i==$n-1){
                                                echo '.';
                                            }
                                        }
                                        
                                    }
                                    
                                    
                                ?></div>
                                <?php } ?>	
							</div>
							                    	    
						</div>
               		</div><!-- /cnt-box -->

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

