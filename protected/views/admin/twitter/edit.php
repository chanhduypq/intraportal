
<script src="<?php echo $this->assetsBase; ?>/js/lib/jquery.watermark.min.js"></script>
<script type="text/javascript">
    jQuery(function($) {
        $('textarea').watermark('Twitterで検索するキーワードを入力してください。<br/> 現在のキーワードと入れ替えになりますので、継続して検索対象とするキーワードも含めて入力してください。', {fallback: false});
    
        
       errorDivs=jQuery('div.errorMessage');
            for(i=0,n=errorDivs.length;i<n;i++){
                if(jQuery(errorDivs[i]).html()!=""){                     
                    jQuery(errorDivs[i]).addClass('alert');
                    jQuery(errorDivs[i]).addClass('info');
                }
            }
            
       $("body").attr('id', 'admin');
       /**
        * 
        */
       $('button#next').click(function() {
           
            
            $.ajax({
                type: "POST",
                async: true,
                url: "<?php echo Yii::app()->baseUrl; ?>/admintwitter/edit/",
                data: jQuery('#twitter_form').serialize(),
                success: function(msg) {
                    jQuery('div.alert').remove();               
                    
                    
                    if (msg != '[]') {                       
                        data = $.parseJSON(msg);
                        if (data.Twitter_blogc_keyword) {
                            div = document.createElement('div');
                            $(div).addClass('alert');
                            $(div).addClass('info');
                            $(div).html(data.Twitter_blogc_keyword);
                            controlGroupDiv=$('#Twitter_blogc_keyword').parent();
                            $(div).insertBefore($(controlGroupDiv));
                        }                     
                    }
                    else {
                        if(checkKeyword()==true){
                            div = document.createElement('div');
                            $(div).addClass('alert');
                            $(div).addClass('info');
                            $(div).html("<?php echo Lang::MSG_0052;?>");
                            controlGroupDiv=$('#Twitter_blogc_keyword').parent();
                            $(div).insertBefore($(controlGroupDiv));
                        }
                        else{
                            if(confirm('このキーワードをTwitterキャッチ！に設定します。')){
                                jQuery('#twitter_form').submit();
                            }
                        }
                                                 
                    }
                }
            });
        });
    });
    
function checkKeyword(){    
    var val = $("#Twitter_blogc_keyword").val();
    arr=val.split("\n",100);   
    for(i=0,n=arr.length;i<n;i++){
        if(arr[i].length>128){
            return true;
        }
    }    
    return false;            
}
</script>
<div class="wrap admin secondary twitter">

    <div class="container">
        <div class="contents index">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>Twitterキャッチ！ - 設定</h2></div>
                
                <div class="box">
                <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'twitter_form',
                        'htmlOptions' => array(                            
                            'class' => 'form-horizontal',
                            
                        ),
                    ));
                    ?> 
                <div class="cnt-box">
                    <?php                     
                    if($success!=""){
                        echo '<div class="alert-success" style="text-align: center;">'.$success.'</div>';
                    }
                    ?>
                    
                    <div class="control-group">
                        <label for="content" class="control-label">現在のキーワード&nbsp;
                        </label>
                        <div class="controls">                             
                        	<p>
                                    <?php
                                    if(isset($keywords)&&  is_array($keywords)&&  count($keywords)){
                                        foreach ($keywords as $keyword) {
                                            echo htmlspecialchars($keyword)." ";
                                        }
                                    }
                                    
                                    ?>
                                </p>
                        </div>
                    </div>
                    
                    <?php echo $form->error($model, 'keyword'); ?>
                    <div class="control-group">
                        <label for="content" class="control-label">キーワード&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">                                
                        	<?php echo $form->textarea($model, 'keyword', array('placeholder' => 'Twitterで検索するキーワードを入力してください。<br/> 現在のキーワードと入れ替えになりますので、継続して検索対象とするキーワードも含めて入力してください。', 'class' => 'input-xxlarge', 'rows' => 7)); ?>                                                    	
                        	<p>※改行による仕切りで複数指定できます。</p>
                        </div>
                    </div>
                    
                </div><!-- /cnt-box -->
                <?php $this->endWidget(); ?>  
                <div class="form-last-btn">
                	<p class="btn80">
	                    <button class="btn btn-important" type="submit" id="next"><i class="icon-chevron-right icon-white">&#12288;</i> 設定</button>
                    </p>
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