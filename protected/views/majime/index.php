<link href="<?php echo $this->assetsBase;?>/css/asobi/css/zebra_dialog.css" rel="stylesheet" type="text/css">
<link href="<?php echo $this->assetsBase; ?>/css/majime/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/js/lib/zebra_dialog.js"></script>
<link href="<?php echo $this->assetsBase; ?>/css/majime/css/profile.css" rel="stylesheet"  media="screen" />
<div class="wrap majime">
    <div class="container">
        <a href="#" class="mvp">MVP発表！おめでとうございます！</a>
        <div class="contents">
            <div class="sideL" >
				<?php $this->widget('Topicswidget');?>
				<!-- /box - topics -->
                <?php 
					if(FunctionCommon::isViewFunction("newitem")==true || FunctionCommon::isPostFunction("newitem")==true)
					{
						$this->widget('NewitemWidget');
					}
				?>
				<!-- /box - NewitemWidget -->
                <?php 
					if(FunctionCommon::isViewFunction("criticism")==true || FunctionCommon::isPostFunction("criticism")==true)
					{
						$this->widget('CriticismWidget');
					}
				?>
                <!-- /box - CriticismWidget -->
                <?php 
					if(FunctionCommon::isViewFunction("claim")==true || FunctionCommon::isPostFunction("claim")==true)
					{
				?>		
						<div class="box claim">
							<div class="ttl">
								<h2>お客様クレーム</h2>
									<?php 
									if(FunctionCommon::isPostFunction("claim")){
									?>
									<a href="<?php echo Yii::app()->baseUrl;?>/majimeclaim/regist" class="miniBtn regist01">登録</a>
									<?php 
									}
									?>
							</div>
							<?php $this->widget('Claimwidget');?>
							<p class="listBtn">                        
								<?php if(FunctionCommon::isViewFunction("claim")){?>
									<a href="<?php echo Yii::app()->baseUrl;?>/majimeclaim/" class="middleBtn listview">一覧を見る</a>
								<?php } ?>
							</p>
						</div>
                <?php        
					}
				?>
                <!-- /box - claim -->
                 <?php 
					if(FunctionCommon::isViewFunction("trouble")==true || FunctionCommon::isPostFunction("trouble")==true)
					{
				?>		
						 <div class="box trouble">
                            <div class="ttl">
                            <h2>トラブル&amp;不正情報</h2>						
                                <?php 
                                if(FunctionCommon::isPostFunction("trouble")){
                                ?>
                                    <a href="<?php echo Yii::app()->baseUrl;?>/majimetrouble/regist" class="miniBtn regist01">登録</a>
                                <?php 
                                }
                                ?>
                            </div>
                            <?php $this->widget('Troublewidget');?>
                            <p class="listBtn">                        
                                <?php  if(FunctionCommon::isViewFunction("trouble")){ ?>
                                    <a href="<?php echo Yii::app()->baseUrl;?>/majimetrouble/" class="middleBtn listview">一覧を見る</a>
                                <?php  } ?>
                                
                            </p>
                        </div>
                <?php
					}
				?>
				<!-- /box - trouble -->
				<!-- box - rival -->
                <?php 
					if(FunctionCommon::isViewFunction("rival")==true || FunctionCommon::isPostFunction("rival")==true)
					{
						$this->widget('RivalWidget');
					}
				?>
				<!-- box - rival -->
                <?php
                if(FunctionCommon::isViewFunction("soumu_jinji")==true || FunctionCommon::isViewFunction("soumu_news")==true ){
				?>
                <div class="box column2 soumu orange">
                    <div class="ttl"><h2>総務からのお知らせ</h2></div>
                    <div class="box">
                    <?php 
						if(FunctionCommon::isViewFunction("soumu_jinji")==true)
						{
							$this->widget('Soumu_jinjiWidget');
						}
					?>
                    <?php 
						if(FunctionCommon::isViewFunction("soumu_news")==true)
						{
					?>
                    		<dl class="info">
                    			<dt>その他</dt>
									<?php $this->widget('Soumu_newsWidget')?>
                           		</dl>	
                            <p class="listBtn">                        
                                <?php if(FunctionCommon::isViewFunction("soumu_news")){ ?>
                                    <a href="<?php echo Yii::app()->baseUrl;?>/majimesoumu_news/" class="middleBtn listview">一覧を見る</a>
                                <?php }?>
        
                            </p>
                    <?php			
						}
					?>
                    </div>
                </div>
                <?php }?>
                 <?php if(FunctionCommon::isViewFunction("twitter")==true){?>
                    <div class="box twitter">
                    <h2>Twitterキャッチ！</h2>
                        <?php $this->widget('Twitterwidget');?>
                    <p class="listBtn">                    
                        <?php if(FunctionCommon::isViewFunction("twitter")){?>
                            <a href="<?php echo Yii::app()->baseUrl;?>/majimetwitter/" class="middleBtn listview">一覧を見る</a>
                        <?php }?>
                      
                    </p>
                    </div><!-- /box - twitter -->
                <?php }?>
                <?php if(FunctionCommon::isViewFunction("blogc")==true){ ?>
                    <div class="box blog">
                    <h2>ブログキャッチ！</h2>
                        <?php $this->widget('Blogcwidget');?>
                        <p class="listBtn">                        
                            <?php if(FunctionCommon::isViewFunction("blogc")){ ?>
                                <a href="<?php echo Yii::app()->baseUrl;?>/majimeblogc/" class="middleBtn listview">一覧を見る</a>
                            <?php }?>
                          
                        </p>
                    </div><!-- /box - blog -->
                <?php }?>
                <?php if(FunctionCommon::isViewFunction("inquiry")==true){
				?>	
                <div class="box portalMenu">
                	<h2>Newgin square 管理メニュー</h2>
                        <p class="descriptionTxt">ポータルサイトに関する問い合わせ窓口です。</p>
                	<ul class="adminMenu">
                        <?php if(FunctionCommon::isViewFunction("inquiry")==true){
						if(isset($_SESSION['inquiry_name']) || isset($_SESSION['inquiry_content'])) 
						{
							unset($_SESSION['inquiry_name']); 
							unset($_SESSION['inquiry_content']); 
						}
						?>
                        
                        <li>
                            <a href="<?php echo Yii::app()->baseUrl;?>/majimeinquiry/add">ニューギンスクエア管理者へのお問い合わせ</a>
                        </li>
                        <?php 
						}
                        ?>
                    </ul>
                </div><!-- /box - portalMenu -->
                <?php }?>
				<?php 
				if(FunctionCommon::isViewFunction("slink")==true)
				{
				$this->widget('SlinkWidget');
				}
				?>
				<!-- /box - portalMenu -->
            </div><!-- /sideL -->
            <div class="cntC">
            	 <?php 
					if(FunctionCommon::isViewFunction("report")==true || FunctionCommon::isPostFunction("report")==true)
					{
						$this->widget('ReportWidget');
					}
				?>
            	 <?php 
					if(FunctionCommon::isViewFunction("zentaishihyou")==true)
					{
						$this->widget('ZentaishihyouWidget');	
					}
				?>
                <?php 
					if(FunctionCommon::isViewFunction("president_msg")==true)
					{
						$this->widget('President_msgWidget');
					}
				?>
            	<?php 
				if(FunctionCommon::isViewFunction("to_officer")==true || FunctionCommon::isPostFunction("to_officer")==true){
					$this->widget('To_officerWidget');
			    }?>
				<!-- /box - management -->
                <?php
                if((FunctionCommon::isViewFunction("base_news")==true) || (FunctionCommon::isViewFunction("member")==true))
				{
				?>
                 <div class="box base-news">
                    <div class="ttl"><h2>拠点&amp;メンバー紹介</h2></div>
                    	<div class="box">
                            <?php $this->widget('Base_newsWidget')?>
                            <?php $this->widget('MemberWidget',array('assets_base'=>$this->assetsBase));?>
                        </div>
                </div><!-- /box - base-news -->
                <?php }?>
				<!-- /box - realtime -->
				<!-- box - question -->
                <?php 
					if(FunctionCommon::isViewFunction("enquete")==true || FunctionCommon::isPostFunction("enquete")==true)
					{
						$this->widget('EnqueteWidget');
					}
				?>
				<!-- /box - question -->
                 <?php 
					if(FunctionCommon::isViewFunction("ideas")==true || FunctionCommon::isPostFunction("ideas")==true)
					{
						$this->widget('IdeasWidget');
					}
				?>
                <!-- /box - idea -->
                <?php 
					if(FunctionCommon::isViewFunction("bbs")==true || FunctionCommon::isPostFunction("bbs")==true)
					{
						$this->widget('BbsWidget');
					}
				?>
				<!-- /box - suggestion -->
   				 <?php 
					if(FunctionCommon::isViewFunction("bounty")==true || FunctionCommon::isPostFunction("bounty")==true)
					{
						$this->widget('BountyWidget');
					}
				?>
				<!-- /box - prize -->
            </div><!-- /center -->
            <div class="sideR" >
            	<?php 
					
					if(FunctionCommon::isViewFunction("share_item")==true)
					{
						$this->widget('Share_itemWidget');
					}
				?>
                <!-- /box - share_item -->
				<?php
				if(FunctionCommon::isViewFunction("pickup")==true){
				   $this->widget('PickupWidget',array('assetsBase'=>$this->assetsBase));
				}
				?>
				<!-- /box - pickup -->
               <?php
			   if(FunctionCommon::isViewFunction("sales_ranking")==true){
			    $this->widget('Sales_rankingWidget');
			   }?>
               <!-- /box - sales_ranking -->
            </div><!-- /sideR -->
        </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>
    </div><!-- /container -->
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>
</div><!-- /wrap -->
<script language="javascript">
    jQuery(function($) 
	{ 
            $('img#not_download').contextmenu( function() {
            return false;
        });
        $("body").delegate("img#not_download","contextmenu",function(){
          return false;
        });
	$("div#div_pickup").click(function (){                        
            html=$("div#div_pickup_content").html();
            msg='<div class="popup_user" style="height:500px;">'+html+'</div>';
            $.Zebra_Dialog(msg, {                                
                                         'buttons':[' とじる'],
                                         width: 1000
                                       
                                     });  
           
            
            
           
        });

	});
newitem=getCookie('newitem_reg_title');
if(newitem !="" && newitem !=null && newitem !='null')
{ 
	deleteCookies("newitem_regist_form");
	deleteCookies("newitem_reg_type");
	deleteCookies("newitem_reg_title");
	deleteCookies("newitem_reg_content");
	deleteCookies("newitem_attachment1_checkbox_for_deleting");
	deleteCookies("newitem_attachment2_checkbox_for_deleting");
	deleteCookies("newitem_attachment3_checkbox_for_deleting");
}
//
bbs = getCookie("bbs_regist_title");
if(bbs !="" && bbs !=null && bbs !='null')
{ 
	deleteCookies("bbs_regist_from");
	deleteCookies("bbs_regist_title");
	deleteCookies("bbs_regist_content");
	deleteCookies("bbs_regist_attachment1_checkbox_for_deleting");
	deleteCookies("bbs_regist_attachment2_checkbox_for_deleting");
	deleteCookies("bbs_regist_attachment3_checkbox_for_deleting");
}

claim = getCookie("claim_regist_title");
if(claim !="" && claim !=null && claim !='null')
{   
	deleteCookies("claim_regist_from");
	deleteCookies("claim_regist_title");
	deleteCookies("claim_regist_content");
	deleteCookies("claim_regist_attachment1_checkbox_for_deleting");
	deleteCookies("claim_regist_attachment2_checkbox_for_deleting");
	deleteCookies("claim_regist_attachment3_checkbox_for_deleting");
}
bounty = getCookie("bounty_reg_title");
if(bounty !="" && bounty !=null && bounty !='null')
{     
	deleteCookies("bounty_regist_form");
	deleteCookies("bounty_reg_title");
	deleteCookies("bounty_reg_content");
	deleteCookies("bounty_reg_prize");
	deleteCookies("bounty_reg_deadline_year");
	deleteCookies("bounty_reg_deadline_month");
	deleteCookies("bounty_reg_deadline_day");
	deleteCookies("bounty_reg_attachment1_checkbox_for_deleting");
	deleteCookies("bounty_reg_attachment2_checkbox_for_deleting");
	deleteCookies("bounty_reg_attachment3_checkbox_for_deleting");
}

criticism = getCookie("criticism_regist_title");
if(criticism !="" && criticism !=null && criticism !='null')
{
	deleteCookies("criticism_regist_from");
	deleteCookies("criticism_regist_title");
	deleteCookies("criticism_regist_content");
	deleteCookies("criticism_regist_attachment1_checkbox_for_deleting");
	deleteCookies("criticism_regist_attachment2_checkbox_for_deleting");
	deleteCookies("criticism_regist_attachment3_checkbox_for_deleting");
}

ideas = getCookie("ideas_regist_title");
if(ideas !="" && ideas !=null && ideas !='null')
{
	deleteCookies("ideas_regist_from");
	deleteCookies("ideas_regist_title");
	deleteCookies("ideas_regist_content");
	deleteCookies("ideas_regist_attachment1_checkbox_for_deleting");
	deleteCookies("ideas_regist_attachment2_checkbox_for_deleting");
	deleteCookies("ideas_regist_attachment3_checkbox_for_deleting");
}

report = getCookie("report_reg_title");
if(report !="" && report !=null && report !='null')
{
	deleteCookies("report_regist_form");
	deleteCookies("report_reg_icon");
	deleteCookies("report_reg_title");
	deleteCookies("report_reg_content");
	deleteCookies("report_reg_attachment1_checkbox_for_deleting");
	deleteCookies("report_reg_attachment2_checkbox_for_deleting");
	deleteCookies("report_reg_attachment3_checkbox_for_deleting");
}

rival = getCookie("rival_regist_title");
if(rival !="" && rival !=null && rival !='null')
{
	deleteCookies("rival_regist_from");
	deleteCookies("rival_regist_title");
	deleteCookies("rival_regist_content");
	deleteCookies("rival_regist_attachment1_checkbox_for_deleting");
	deleteCookies("rival_regist_attachment2_checkbox_for_deleting");
	deleteCookies("rival_regist_attachment3_checkbox_for_deleting");
}

trouble = getCookie("trouble_regist_title");
if(trouble !="" && trouble !=null && trouble !='null')
{
	deleteCookies("trouble_regist_from");
	deleteCookies("trouble_regist_title");
	deleteCookies("trouble_regist_content");
	deleteCookies("trouble_regist_attachment1_checkbox_for_deleting");
	deleteCookies("trouble_regist_attachment2_checkbox_for_deleting");
	deleteCookies("trouble_regist_attachment3_checkbox_for_deleting");
}

to_officer = getCookie("to_officer_add_title");
if(to_officer !="" && to_officer !=null && to_officer !='null')
{
	deleteCookies("to_officer_add_from");
	deleteCookies("to_officer_add_title");
	deleteCookies("to_officer_add_content");
	deleteCookies("to_officer_add_attachment1_checkbox_for_deleting");
	deleteCookies("to_officer_add_attachment2_checkbox_for_deleting");
	deleteCookies("to_officer_add_attachment3_checkbox_for_deleting");
}

enquete = getCookie("enquete_regist_title");
if(enquete !="" && enquete !=null && enquete !='null')
{
	deleteCookies("enquete_regist_from");  
	deleteCookies("enquete_regist_title");   
	deleteCookies("enquete_regist_content");
	deleteCookies("enquete_regist_deadline_year");
	deleteCookies("enquete_regist_deadline_month"); 
	deleteCookies("enquete_regist_deadline_day");
	deleteCookies("enquete_regist_answer_type");
	deleteCookies("enquete_regist_attachment1_checkbox_for_deleting");
	deleteCookies("enquete_regist_attachment2_checkbox_for_deleting");
	deleteCookies("enquete_regist_attachment3_checkbox_for_deleting");
	deleteCookies("loaddata");
}
</script>