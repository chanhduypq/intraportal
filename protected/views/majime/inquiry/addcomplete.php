<link href="<?php echo $this->assetsBase; ?>/css/majime/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>
<div class="wrap majime secondary inquiry">

    <div class="container">
        <div class="contents confirm">
        	
            <div class="mainBox">
            	<div class="pageTtl"><h2>管理者へのお問い合わせ - 送信完了</h2></div>
                
                <div class="box">
                	
                	<p>送信完了しました。</p>

                </div><!-- /box -->
            </div><!-- /mainBox -->
            
            
        </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div><!-- /wrap -->
<?php
unset($_SESSION['inquiry_name']); 
unset($_SESSION['inquiry_content']); 
?>
