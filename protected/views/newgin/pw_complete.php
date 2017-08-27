<div class="wrap login">

    <div class="container">
        <div class="contents detail">
        	
          <div class="mainBox detail">
            <div class="pageTtl"><h2>ログイン - 送信完了</h2></div>
            <div class="box">
                <div class="cnt-box"><p>パスワードをメールでお送りしました。<br />ご確認ください。</p></div><!-- /cnt-box -->
                
               
                <div class="form-last-btn">
                  <p class="btn170">
                    <button type="submit" class="btn" id="goLogin"><i class="icon-chevron-left"></i> ログインへもどる</button>                  
                  </p>
                </div>
               
              
            </div><!-- /box -->
            </div><!-- /mainBox -->
            
            
        </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div><!-- /wrap -->
<script type="text/javascript">   
		jQuery(function($) {        
			$("body").attr('id','admin');    
			 $('button#goLogin').click(function(){  
				window.location="<?php echo Yii::app()->baseUrl;?>/newgin/";
			}); 
   		 });
</script>		 