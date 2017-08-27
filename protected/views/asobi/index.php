<link href="<?php echo $this->assetsBase;?>/css/common/css/pride.css" rel="stylesheet" type="text/css">
<link href="<?php echo $this->assetsBase;?>/css/asobi/css/tagcrowd.css" rel="stylesheet" type="text/css">
<link href="<?php echo $this->assetsBase;?>/css/asobi/css/jquery-ui.css" rel="stylesheet" type="text/css">
<link href="<?php echo $this->assetsBase;?>/css/asobi/css/zebra_dialog.css" rel="stylesheet" type="text/css">
<script src="<?php echo $this->assetsBase; ?>/js/lib/jquery-ui.js"></script>
<script src="<?php echo $this->assetsBase; ?>/js/lib/zebra_dialog.js"></script>

<div class="wrap asobi">
    
    <div class="container">
        <a href="#" class="mvp">MVP発表！おめでとうございます！</a>
        <div class="contents">
        
            <div class="sideL" >
                <div class="box news">
                    <?php $this->widget('Topicsasobiwidget');?>
                </div><!-- /box - news -->
                <?php $this->widget('Celebrate_rptWidget',array('assets_base'=>$this->assetsBase));?>
               <!-- /box - celebration -->
                
                <div class="box thanks orange">
                 <h2 class="ttl">今月のありがとう</h2>
                    <?php  $this->widget('Thankswidget',array('assets_base'=>$this->assetsBase));?>
                </div><!-- /box - celebration -->
                
                <div class="box banner">
                	<ul>
						<?php $this->widget('MeigenWidget');?>
						<?php $this->widget('NannohiWidget');?>
                            <?php
                            if(FunctionCommon::isViewFunction("skill")==true){?>		 
                            <li style="margin-bottom: 28px;width: 286px;height: 55px;color: black;font-size: 11px;text-indent: -9999px;">                                
                                <a class="skill" href="<?php echo Yii::app()->baseUrl?>/asobiskill">資格取得・スキルアップ</a>
                                <p style="margin-top: 2px;text-indent: 10px;background: none repeat scroll 0% 0% #F7CFCF;border-radius: 5px;font-size: 11px;width: 185px;">－経営管理本部にて投稿－</p>                               
                            </li>
                            <?php 
                            }
                            ?>
						<?php $this->widget('LinkWidget');?>
                    </ul>
                </div><!-- /box - banner -->
                
            </div><!-- /sideL -->
			<div class="sideR" >	
            
				<?php $this->widget('RankingWidget');?>	
				<!-- /box - newranking top -->
                
                 
				<?php $this->widget('FortuneWidget');?>
				<!-- /box - fortune top -->
                
                <div class="box pride top">
                <?php $this->widget('PrideWidget',array('assets_base'=>$this->assetsBase));?>
                </div><!-- /box - pride top -->
                
                <div class="box golf top">
                    <h2>ゴルフもマジメ</h2>
                    <div class="box golf bottom">
                    	
                    	<div class="cntBox">
                        	<?php $this->widget('Golf_newswidget',array('assets_base'=>$this->assetsBase));?>
                            <div class="boxR">
                             <?php $this->widget('Golf_scorewidget');?>
                            
                            <div class="searchBox">
                                <div class="ttl"><h4>都道府県別ゴルフ場検索</h4></div>
                                
                                	<div class="mapBox">
                                    <table border="0">
                                        <tbody>
                                        <tr>
                                            <td class="key hokkaido_tohoku">北海道・東北</td>
                                            <td class="value">
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=1&widthday=7&tp=e_top_map01">北海道</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=2&widthday=7&tp=e_top_map02">青森</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=3&widthday=7&tp=e_top_map03">岩手</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=4&widthday=7&tp=e_top_map04">宮城</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=5&widthday=7&tp=e_top_map05">秋田</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=6&widthday=7&tp=e_top_map06">山形</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=7&widthday=7&tp=e_top_map07">福島</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="key kanto">関東</td>
                                            <td class="value">
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=8&widthday=7&tp=e_top_map08">茨城</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=9&widthday=7&tp=e_top_map09">栃木</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=10&widthday=7&tp=e_top_map10">群馬</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=11&widthday=7&tp=e_top_map11">埼玉</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=12&widthday=7&tp=e_top_map12">千葉</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=13&widthday=7&tp=e_top_map13">東京</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=14&widthday=7&tp=e_top_map14">神奈川</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=19&widthday=7&tp=e_top_map19">山梨</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=20&widthday=7&tp=e_top_map20">長野</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=22&widthday=7&tp=e_top_map22">静岡</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="key hokuriku">北陸</td>
                                            <td class="value">
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=15&widthday=7&tp=e_top_map15">新潟</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=16&widthday=7&tp=e_top_map16">富山</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=17&widthday=7&tp=e_top_map17">石川</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=18&widthday=7&tp=e_top_map18">福井</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="key chubu">中部</td>
                                            <td class="value">
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=21&widthday=7&tp=e_top_map21">岐阜</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=23&widthday=7&tp=e_top_map23">愛知</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=24&widthday=7&tp=e_top_map24">三重</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="key kinki">近畿</td>
                                            <td class="value">
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=25&widthday=7&tp=e_top_map25">滋賀</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=26&widthday=7&tp=e_top_map26">京都</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=27&widthday=7&tp=e_top_map27">大阪</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=28&widthday=7&tp=e_top_map28">兵庫</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=29&widthday=7&tp=e_top_map29">奈良</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=30&widthday=7&tp=e_top_map30">和歌山</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="key chugoku">中国</td>
                                            <td class="value">
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=31&widthday=7&tp=e_top_map31">鳥取</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=32&widthday=7&tp=e_top_map32">島根</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=33&widthday=7&tp=e_top_map33">岡山</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=34&widthday=7&tp=e_top_map34">広島</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=35&widthday=7&tp=e_top_map35">山口</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="key shikoku">四国</td>
                                            <td class="value">
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=36&widthday=7&tp=e_top_map36">徳島</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=37&widthday=7&tp=e_top_map37">香川</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=38&widthday=7&tp=e_top_map38">愛媛</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=39&widthday=7&tp=e_top_map39">高知</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="key kyushu_okinawa">九州・沖縄</td>
                                            <td class="value">
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=40&widthday=7&tp=e_top_map40">福岡</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=41&widthday=7&tp=e_top_map41">佐賀</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=42&widthday=7&tp=e_top_map42">長崎</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=43&widthday=7&tp=e_top_map43">熊本</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=44&widthday=7&tp=e_top_map44">大分</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=45&widthday=7&tp=e_top_map45">宮崎</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&area=46&widthday=7&tp=e_top_map46">鹿児島</a>
                                            |
                                            <a target="_blank" href="http://search.gora.golf.rakuten.co.jp/?menu=srch&act=disp&map_flg=1&widthday=7&area=47&tp=e_top_map47">沖縄</a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    
                            		</div><!-- /mapBox-->
                            </div><!-- /box - searchBox -->
                            
                            
                            </div><!-- /boxR -->
                        
                        </div><!-- /cntBox -->
                                
                    </div><!-- /box - golf bottom -->
                </div><!-- /box - golf top -->
                        
                <div class="box hobby top">
                	<h2>趣味・サークル広場</h2>
                    <div class="box hobby bottom">
                    
                    	<div class="cntBox">
							<?php $this->widget('Hobby_newWidget');?>
                            
                            <?php $this->widget('Hobby_itdwidget',array('assets_base'=>$this->assetsBase));?>
                           
                        </div><!-- /cntBox -->
                        
                	</div><!-- /box - hobby bottom -->
                </div><!-- /box - hobby top -->
                            
            </div><!-- /sideR -->
            
        </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>
<div id="twitter_dialog" style="display: none;position: absolute;z-index: 2000;padding-bottom: 200px;margin-bottom: 500px;margin-left: 350px;">    
        <img alt="" src="<?php echo $this->assetsBase;?>/css/common/img/loading.gif" style="width: 150px;height: 150px;"/>    
    </div>
    </div><!-- /container -->
    
    <div class="tagcrowd">
        
        <p>
             <?php 
             $tagcrowds = Yii::app()->db->createCommand()
                ->select(array(
                    'keyword','fontsize','id'
                        )
                )
                ->from('tagcrowd')            
                ->order('display_order ASC')
                ->queryAll();
             
             if(is_array($tagcrowds)&&count($tagcrowds)>0){
                 foreach ($tagcrowds as $tagcrowd) {
                     $class='';
                     if($tagcrowd['fontsize']=='S'){
                         $class='txt1';
                     }
                     else if($tagcrowd['fontsize']=='M'){
                         $class='txt2';
                     }
                     else{
                         $class='txt3';
                     }
                     echo '<a id='.$tagcrowd['id'].' class="'.$class.'">'.$tagcrowd['keyword'].'</a>';
                 }
                 
             }
             ?>
        </p>
    </div><!-- /tagcrowd -->

    <div class="footer"> <p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p></div>

</div><!-- /wrap -->
<script language="javascript">
golf_news = getCookie("golf_news_regist_title");
if(golf_news !="" && golf_news !=null && golf_news !='null')
{
    deleteCookies("golf_news_regist_from");
    deleteCookies("golf_news_regist_title");
    deleteCookies("golf_news_regist_content");
    deleteCookies("golf_news_regist_attachment1_checkbox_for_deleting");
    deleteCookies("golf_news_regist_attachment2_checkbox_for_deleting");
    deleteCookies("golf_news_regist_attachment3_checkbox_for_deleting");
    deleteCookies("golf_news_regist_eye_catch_checkbox_for_deleting");
    golf_news_regist_category = getCookie("golf_news_regist_category_id");
	if(golf_news_regist_category !="" || golf_news_regist_category ==null)
	{
       deleteCookies("golf_news_regist_category_id"); 
       deleteCookies("golf_news_regist_category_name"); 
       deleteCookies("golf_news_regist_background_color"); 
       deleteCookies("golf_news_regist_color"); 
       
    }
}
golf_score_regist_from = getCookie("golf_score_regist_score_name");
if(golf_score_regist_from !="" && golf_score_regist_from !=null && golf_score_regist_from !='null')
{
	deleteCookies("golf_score_regist_from");
	deleteCookies("golf_score_regist_score");
	deleteCookies("golf_score_regist_score_name");
	deleteCookies("golf_score_regist_deadline_year");
	deleteCookies("golf_score_regist_deadline_month");
	deleteCookies("golf_score_regist_deadline_day");
} 
hobby_itd_regist_from = getCookie("hobby_itd_regist_title");
if(hobby_itd_regist_from !="" && hobby_itd_regist_from !=null && hobby_itd_regist_from !='null')
{ 
	deleteCookies("hobby_itd_regist_from");
	deleteCookies("hobby_itd_regist_title");
	deleteCookies("hobby_itd_regist_content");
	deleteCookies("hobby_itd_regist_attachment1_checkbox_for_deleting");
	deleteCookies("hobby_itd_regist_attachment2_checkbox_for_deleting");
	deleteCookies("hobby_itd_regist_attachment3_checkbox_for_deleting");
	deleteCookies("hobby_itd_regist_eye_catch_checkbox_for_deleting");
}
//hobby_new
hobby_new_regist_form = getCookie("hobby_new_reg_title");
if(hobby_new_regist_form !="" && hobby_new_regist_form !=null && hobby_new_regist_form !='null')
{
	deleteCookies("hobby_new_regist_form");
	deleteCookies("hobby_new_reg_type");
	deleteCookies("hobby_new_reg_title");
	deleteCookies("hobby_new_reg_content");
	deleteCookies("hobby_new_reg_attachment1_checkbox_for_deleting");
	deleteCookies("hobby_new_reg_attachment2_checkbox_for_deleting");
	deleteCookies("hobby_new_reg_attachment3_checkbox_for_deleting");
}
pride_regist_from = getCookie("pride_regist_title");
if(pride_regist_from !="" && pride_regist_from !=null && pride_regist_from !='null')
{ 
	deleteCookies("pride_regist_icon");
	deleteCookies("pride_regist_from");
	deleteCookies("pride_regist_title");
	deleteCookies("pride_regist_content");
	deleteCookies("pride_regist_attachment1_checkbox_for_deleting");
	deleteCookies("pride_regist_attachment2_checkbox_for_deleting");
	deleteCookies("pride_regist_attachment3_checkbox_for_deleting");
}
jQuery(function($) 
{    
    $('img#not_download').contextmenu( function() {
            return false;
        });
        
	$("body").attr('id','asobi');    
        $("div.tagcrowd a").removeAttr('href').css('cursor','pointer');

          $("div.tagcrowd a").click(function (){                    
              
              
              $('div#twitter_dialog').show();
              
            var keyword=$(this).html();
            $("#twiiter_form_keyword").val(keyword);
            $("#keyword_id").val($(this).attr('id'));
            $.ajax({    
				type: "POST", 
				async:true,
                                data: jQuery('#twiiter_form').serialize(),
				url: "<?php echo Yii::app()->baseUrl; ?>/asobi/twiitergetajax",
                                success: function(msg){                                                  
                                    $('div#twitter_dialog').hide();
                                     msg=unescape(msg);
                                     $.Zebra_Dialog(msg, {                                
                                         'buttons':['Close'],
                                         width: 800,
                                         height:500        
                                     });                          
                                     
                                }
            });

          });
});


</script>

<form id="twiiter_form">
    <input type="hidden" name="keyword" id="twiiter_form_keyword" />
    <input type="hidden" name="id" id="keyword_id"/>
</form>
