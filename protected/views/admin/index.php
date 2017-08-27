<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
    jQuery(function($) {
        $('ul.yiiPager li.selected').removeClass('selected');
        $('ul.yiiPager li').removeClass('page');
        $('ul.yiiPager li').removeClass('previous');
        $('ul.yiiPager li').removeClass('next');
        $('ul.yiiPager li').removeClass('last');
        $('ul.yiiPager li').removeClass('first');
        $('ul.yiiPager li').removeClass('hidden');
        $('ul.yiiPager').removeClass('yiiPager');
        
        $("body").attr('id','admin');        
    });
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div id="admin" class="wrap admin secondary posts">

    <div class="container index">
        <div class="contents detail">
        	
            <div class="mainBox">
            	<div class="pageTtl"><h2>あなたの投稿履歴</h2></div>
                <div class="box">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASCAYAAABWzo5XAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAAadEVYdFNvZnR3YXJlAFBhaW50Lk5FVCB2My41LjEwMPRyoQAAAMdJREFUOE+tkgsNwzAMRMugEAahEAahEAZhEAqlEAZhEAohEAYh81X2dIm8fKpEspLGvudPOsUYpxE2BIJCroJmEW9qJ+MKaBFhEMNabSy9oIcIPwrB+afvAUFoK4H0tMaQ3XtlrggDhOVVMuT4E5MMG0FBbCEYzjYT7OxLEvIHQLY2zWwQ3D+9luyOQTfKDiFD3iUIfPk8VqrKjgAiSfGFPecrg6HN6m/iBcwiDAo7WiBeawa+Kwh7tZoSCGLMqwlSAzVDhoK+6vH4G0P5wdkAAAAASUVORK5CYII="/>
                    abc
                <p class="descriptionTxt">投稿履歴をご確認いただけます。</p>
                <?php if(Yii::app()->user->hasFlash('deny')){?>
                    <div class="info">
                         <p class="descriptionTxt"><?php echo Yii::app()->user->getFlash('deny'); ?></p>
                    </div>
                <?php    
                } ?>
                
                <table width="724" border="0" class="table list font14">
                	<tr><th>投稿年月日</th><th>更新年月日</th><th>コンテンツ名</th><th>タイトル</th><th>編集</th></tr>
                    
                    <?php 
                    $module_tile_array=  Constants::$module_tile_array;
                    if(is_array($items)&&count($items)>0){
                        foreach ($items as $item){?>                            
                            <tr>
                                <td class="td-date alnC txtRed postsDate">
									<?php echo  FunctionCommon::formatDate($item['created_date']);?>
								</td>
                                <td class="td-date alnC txtRed updateDate">
									<?php echo  FunctionCommon::formatDate($item['last_updated_date']);?>
								</td>
                                <td class="td-contents"><span>
                                        <?php 
                                        if(is_array($module_tile_array)&&count($module_tile_array)){                                            
                                            foreach ($module_tile_array as $key=>$value){
                                                if($key==$item['table_name']){
                                                    echo $value;
                                                }
                                            }
                                        }
                                        ?>
                                    </span></td>
                                <td class="td-text">
                                    <p class="text">
                                        <a href="<?php echo Yii::app()->request->baseUrl; ?>/admin<?php echo $item['table_name'].'/detail/?id='.$item['id'];?>"><?php echo htmlspecialchars($item['title']);?></a>
                                    </p>
                                </td>
                                <td class="td-edit">
                                    <a class="btn btn-work" href="<?php echo Yii::app()->request->baseUrl; ?>/admin<?php echo $item['table_name'];?>/edit/?id=<?php echo $item['id']; ?>">修正</a>
                                    <a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->request->baseUrl; ?>/admin/delete/?id=<?php echo $item['id']; ?>&table_name=<?php echo $item['table_name'];?>';" href="#" class="btn btn-correct">削除</a>
                                </td>
                            </tr> 
                    <?php
                        }
                    }
                    ?>
                </table>
             
                <div class="pagination">
                    <?php                    
                    $this->widget('CLinkPager', array(
                        'currentPage' => $pages->getCurrentPage(),
                        'itemCount' => $item_count,
                        'pageSize' => $page_size,
                        'maxButtonCount' => 5,
                        'nextPageLabel' => 'Next',
                        'prevPageLabel' => 'Prev',
                        'lastPageLabel' => 'Last',
                        'firstPageLabel' => 'First',
                        'header' => '',
                        'htmlOptions' => array('class' => 'yiiPager'),
                    ));
                    ?>
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
	jQuery(function($) 
	{       
	   $(window).load(function () 
	   {
		  setCookie("temple","1");        
	   });  

		jQuery(function($) 
		{        
			$("body").attr('id','admin');      
		});    
	});


var bbs = getCookie("bbs_edit_title");
if(bbs !="" && bbs !=null && bbs !='null'){ 
	deleteCookies("bbs_edit_from");
	deleteCookies("bbs_edit_title");
	deleteCookies("bbs_edit_content");
	deleteCookies("bbs_edit_attachment1_checkbox_for_deleting");
	deleteCookies("bbs_edit_attachment2_checkbox_for_deleting");
	deleteCookies("bbs_edit_attachment3_checkbox_for_deleting");
 } 
 
//cookies bounty
var bounty = getCookie("bounty_edit_title");
if(bounty !="" && bounty !=null && bounty !='null'){     
	deleteCookies("bounty_edit_form");
	deleteCookies("bounty_edit_title");
	deleteCookies("bounty_edit_content");
	deleteCookies("bounty_edit_prize");
	deleteCookies("bounty_edit_deadline_year");
	deleteCookies("bounty_edit_deadline_month");
	deleteCookies("bounty_edit_deadline_day");
	deleteCookies("bounty_edit_attachment1_checkbox_for_deleting");
	deleteCookies("bounty_edit_attachment2_checkbox_for_deleting");
	deleteCookies("bounty_edit_attachment3_checkbox_for_deleting");
}

//cookies celebrate
var celebrate_edit = getCookie("celebrate_edit_category_id");
if(celebrate_edit !="" && celebrate_edit !=null && celebrate_edit !='null'){  
	deleteCookies("celebrate_edit_from");
	deleteCookies("celebrate_edit_category_id");
	deleteCookies("celebrate_edit_record_year");
	deleteCookies("celebrate_edit_record_month");
	deleteCookies("celebrate_edit_record_day");
	deleteCookies("celebrate_edit_base_id");
	deleteCookies("celebrate_edit_employee_name");
}
var celebrate_regist = getCookie("celebrate_regist_category_id");
if(celebrate_regist !="" && celebrate_regist !=null && celebrate_regist !='null'){      
	deleteCookies("celebrate_regist_from");
	deleteCookies("celebrate_regist_category_id");
	deleteCookies("celebrate_regist_record_year");
	deleteCookies("celebrate_regist_record_month");
	deleteCookies("celebrate_regist_record_day");
	deleteCookies("celebrate_regist_base_id");
	deleteCookies("celebrate_regist_employee_name");
}

//celebrate_rpt
var celebrate_rpt_regist = getCookie("celebrate_rpt_reg_cat");
if(celebrate_rpt_regist !="" && celebrate_rpt_regist !=null && celebrate_rpt_regist !='null'){         
	deleteCookies("celebrate_rpt_regist_form");
	deleteCookies("celebrate_rpt_reg_cat");
	deleteCookies("celebrate_rpt_reg_base");
	deleteCookies("celebrate_rpt_reg_employee_name");
}
//celebrate_rpt
var celebrate_rpt_edit = getCookie("celebrate_rpt_edit_cat");
if(celebrate_rpt_edit !="" && celebrate_rpt_edit !=null && celebrate_rpt_edit !='null'){        
	deleteCookies("celebrate_rpt_edit_form");
	deleteCookies("celebrate_rpt_edit_cat");
	deleteCookies("celebrate_rpt_edit_base");
	deleteCookies("celebrate_rpt_edit_employee_name");
}
var claim = getCookie("claim_edit_title");
if(claim !="" && claim !=null && claim !='null'){          
	deleteCookies("claim_edit_from");
	deleteCookies("claim_edit_title");
	deleteCookies("claim_edit_content");
	deleteCookies("claim_edit_attachment1_checkbox_for_deleting");
	deleteCookies("claim_edit_attachment2_checkbox_for_deleting");
	deleteCookies("claim_edit_attachment3_checkbox_for_deleting");
}

var criticism = getCookie("criticism_edit_title");
if(criticism !="" && criticism !=null && criticism !='null'){         
	deleteCookies("criticism_edit_from");
	deleteCookies("criticism_edit_title");
	deleteCookies("criticism_edit_content");
	deleteCookies("criticism_edit_attachment1_checkbox_for_deleting");
	deleteCookies("criticism_edit_attachment2_checkbox_for_deleting");
	deleteCookies("criticism_edit_attachment3_checkbox_for_deleting");
 } 
var enquete = getCookie("enquete_edit_title");
if(enquete !="" && enquete !=null && enquete !='null'){       
	deleteCookies("enquete_edit_from");  
	deleteCookies("enquete_edit_title");   
	deleteCookies("enquete_edit_content");
	deleteCookies("enquete_edit_comment");
	deleteCookies("enquete_edit_deadline_year");
	deleteCookies("enquete_edit_deadline_month"); 
	deleteCookies("enquete_edit_deadline_day");
	deleteCookies("enquete_edit_answer_type");
	deleteCookies("enquete_edit_attachment1_checkbox_for_deleting");
	deleteCookies("enquete_edit_attachment2_checkbox_for_deleting");
	deleteCookies("enquete_edit_attachment3_checkbox_for_deleting");
	deleteCookies("loaddata_edit");
}

var golf_news = getCookie("golf_news_edit_title");
if(golf_news !="" && golf_news !=null && golf_news !='null'){     
    deleteCookies("golf_news_edit_from");
    deleteCookies("golf_news_edit_title");
    deleteCookies("golf_news_edit_content");
    deleteCookies("golf_news_edit_attachment1_checkbox_for_deleting");
    deleteCookies("golf_news_edit_attachment2_checkbox_for_deleting");
    deleteCookies("golf_news_edit_attachment3_checkbox_for_deleting");
    deleteCookies("golf_news_edit_eye_catch_checkbox_for_deleting");
    } 
var golf_news_edit_category = getCookie("golf_news_edit_category_id");
if(golf_news_edit_category !="" && golf_news_edit_category !=null && golf_news_edit_category !='null'){   
        deleteCookies("golf_news_edit_category_id");
        deleteCookies("golf_news_edit_category_name");
        deleteCookies("golf_news_edit_background_color");
        deleteCookies("golf_news_edit_color");        
    }   

var golf_score = getCookie("golf_score_edit_score");
if(golf_score !="" && golf_score !=null && golf_score !='null'){      
	deleteCookies("golf_score_edit_from");
	deleteCookies("golf_score_edit_score");
	deleteCookies("golf_score_edit_score_name");
	deleteCookies("golf_score_edit_deadline_year");
	deleteCookies("golf_score_edit_deadline_month");
	deleteCookies("golf_score_edit_deadline_day");
} 
var hobby_itd = getCookie("hobby_itd_edit_title");
if(hobby_itd !="" && hobby_itd !=null && hobby_itd !='null'){    
	deleteCookies("hobby_itd_edit_from");
	deleteCookies("hobby_itd_edit_title");
	deleteCookies("hobby_itd_edit_content");
	deleteCookies("hobby_itd_edit_attachment1_checkbox_for_deleting");
	deleteCookies("hobby_itd_edit_attachment2_checkbox_for_deleting");
	deleteCookies("hobby_itd_edit_attachment3_checkbox_for_deleting");
	deleteCookies("hobby_itd_regist_eye_catch_checkbox_for_deleting");
 } 
var hobby_new = getCookie("hobby_new_edit_title");
if(hobby_new !="" && hobby_new !=null && hobby_new !='null'){     
	deleteCookies("hobby_new_edit_form");
	deleteCookies("hobby_new_edit_category_id");
	deleteCookies("hobby_new_edit_title");
	deleteCookies("hobby_new_edit_content");
	deleteCookies("hobby_new_edit_attachment1_checkbox_for_deleting");
	deleteCookies("hobby_new_edit_attachment2_checkbox_for_deleting");
	deleteCookies("hobby_new_edit_attachment3_checkbox_for_deleting");
}
var ideas = getCookie("ideas_edit_title");
if(ideas !="" && ideas !=null && ideas !='null'){ 
	deleteCookies("ideas_edit_from");
	deleteCookies("ideas_edit_title");
	deleteCookies("ideas_edit_content");
	deleteCookies("ideas_edit_attachment1_checkbox_for_deleting");
	deleteCookies("ideas_edit_attachment2_checkbox_for_deleting");
	deleteCookies("ideas_edit_attachment3_checkbox_for_deleting");
}
//cookies newitem
var newitem = getCookie("newitem_edit_title");
if(newitem !="" && newitem !=null && newitem !='null'){ 
    deleteCookies("newitem_edit_form");
    deleteCookies("newitem_edit_type");
    deleteCookies("newitem_edit_title");
    deleteCookies("newitem_edit_content");
    deleteCookies("newitem_edit_attachment1_checkbox_for_deleting");
    deleteCookies("newitem_edit_attachment2_checkbox_for_deleting");
    deleteCookies("newitem_edit_attachment3_checkbox_for_deleting");
 } 
//president_msg
var president_msg_edit = getCookie("president_msg_edit_title");
if(president_msg_edit !="" && president_msg_edit !=null && president_msg_edit !='null'){ 
	 deleteCookies("president_msg_edit_from");
	 deleteCookies("president_msg_edit_title");
     deleteCookies("president_msg_edit_content");
	 deleteCookies("president_msg_edit_attachment1_checkbox_for_deleting");
	 deleteCookies("president_msg_edit_attachment2_checkbox_for_deleting");
	 deleteCookies("president_msg_edit_attachment3_checkbox_for_deleting");
 }
//president_msg regist_
var president_msg_regist = getCookie("president_msg_regist_title");
if(president_msg_regist !="" && president_msg_regist !=null && president_msg_regist !='null'){  
	 deleteCookies("president_msg_regist_from");
	 deleteCookies("president_msg_regist_title");
	 deleteCookies("president_msg_regist_content");
	 deleteCookies("president_msg_regist_attachment1_checkbox_for_deleting");
	 deleteCookies("president_msg_regist_attachment2_checkbox_for_deleting");
	 deleteCookies("president_msg_regist_attachment3_checkbox_for_deleting");
 }
var pride = getCookie("pride_edit_title");
if(pride !="" && pride !=null && pride !='null'){ 
	deleteCookies("pride_edit_icon");
	deleteCookies("pride_edit_from");
	deleteCookies("pride_edit_title");
	deleteCookies("pride_edit_content");
	deleteCookies("pride_edit_attachment1_checkbox_for_deleting");
	deleteCookies("pride_edit_attachment2_checkbox_for_deleting");
	deleteCookies("pride_edit_attachment3_checkbox_for_deleting");
 } 
  
//cookies report
report = getCookie("report_edit_title");
if(report !="" && report !=null && report !='null'){      
	deleteCookies("report_edit_form");
	deleteCookies("report_edit_icon");
	deleteCookies("report_edit_title");
	deleteCookies("report_edit_content");
	deleteCookies("report_edit_attachment1_checkbox_for_deleting");
	deleteCookies("report_edit_attachment2_checkbox_for_deleting");
    deleteCookies("report_edit_attachment3_checkbox_for_deleting");
 }

var rival = getCookie("rival_edit_title");
if(rival !="" && rival !=null && rival !='null'){ 
	deleteCookies("rival_edit_from");
	deleteCookies("rival_edit_title");
	deleteCookies("rival_edit_content");
	deleteCookies("rival_edit_attachment1_checkbox_for_deleting");
	deleteCookies("rival_edit_attachment2_checkbox_for_deleting");
	deleteCookies("rival_edit_attachment3_checkbox_for_deleting");
 } 

var share_item_edit = getCookie("share_item_edit_title");
if(share_item_edit !="" && share_item_edit !=null && share_item_edit !='null'){ 
	 deleteCookies("share_item_edit_from");
	 deleteCookies("share_item_edit_title");
	 deleteCookies("share_item_edit_content");
	 deleteCookies("share_item_edit_attachment1_checkbox_for_deleting");
	 deleteCookies("share_item_edit_attachment2_checkbox_for_deleting");
	 deleteCookies("share_item_edit_attachment3_checkbox_for_deleting");
}

var share_item_regist = getCookie("share_item_regist_title");
if(share_item_regist !="" && share_item_regist !=null && share_item_regist !='null'){ 
	 deleteCookies("share_item_regist_from");
	 deleteCookies("share_item_regist_title");
	 deleteCookies("share_item_regist_content");
	 deleteCookies("share_item_regist_attachment1_checkbox_for_deleting");
	 deleteCookies("share_item_regist_attachment2_checkbox_for_deleting");
	 deleteCookies("share_item_regist_attachment3_checkbox_for_deleting");
 } 

var skill_edit = getCookie("skill_edit_from");
if(skill_edit !="" && skill_edit !=null && skill_edit !='null'){  
	 deleteCookies("skill_edit_from");
	 deleteCookies("skill_edit_title");
	 deleteCookies("skill_edit_category_id");
	 deleteCookies("skill_edit_url");
	 deleteCookies("skill_edit_comment");
	 deleteCookies("skill_edit_attachment1_checkbox_for_deleting");
	 deleteCookies("skill_edit_attachment2_checkbox_for_deleting");
	 deleteCookies("skill_edit_attachment3_checkbox_for_deleting");
 }

var skill_regist = getCookie("skill_regist_title");
if(skill_regist !="" && skill_regist !=null && skill_regist !='null'){ 
	 deleteCookies("skill_regist_from");
	 deleteCookies("skill_regist_title");
	 deleteCookies("skill_regist_category_id");
	 deleteCookies("skill_regist_url");
	 deleteCookies("skill_regist_comment");   
	 deleteCookies("skill_regist_attachment1_checkbox_for_deleting");
	 deleteCookies("skill_regist_attachment2_checkbox_for_deleting");
	 deleteCookies("skill_regist_attachment3_checkbox_for_deleting");
  } 
var from_jini= getCookie("employee_name");
if(from_jini !="" && from_jini !=null && from_jini !='null'){
	deleteCookies("from_jini");
	deleteCookies("category_id");
	deleteCookies("employee_name");
	deleteCookies("deadline_year");
	deleteCookies("deadline_month");
	deleteCookies("deadline_day");
} 
  
 //soumu_news regist
var soumu_news_regist= getCookie("soumu_news_regist_title");
if(soumu_news_regist !="" && soumu_news_regist !=null && soumu_news_regist !='null'){
	deleteCookies("soumu_news_regist_from");
	deleteCookies("soumu_news_regist_title");
	deleteCookies("soumu_news_regist_content");
	deleteCookies("soumu_news_regist_label");    
	deleteCookies("soumu_news_regist_attachment1_checkbox_for_deleting");
	deleteCookies("soumu_news_regist_attachment2_checkbox_for_deleting");
	deleteCookies("soumu_news_regist_attachment3_checkbox_for_deleting");   
}

//soumu_news regist
var soumu_news_edit= getCookie("soumu_news_edit_title");
if(soumu_news_edit !="" && soumu_news_edit !=null && soumu_news_edit !='null'){
	deleteCookies("soumu_news_edit_from");
	deleteCookies("soumu_news_edit_title");
	deleteCookies("soumu_news_edit_content");
	deleteCookies("soumu_news_edit_label");
	deleteCookies("soumu_news_edit_attachment1_checkbox_for_deleting");
	deleteCookies("soumu_news_edit_attachment2_checkbox_for_deleting");
	deleteCookies("soumu_news_edit_attachment3_checkbox_for_deleting"); 
 }
var soumu_qa_edit= getCookie("soumu_qa_edit_title");
if(soumu_qa_edit !="" && soumu_qa_edit !=null && soumu_qa_edit !='null'){
	deleteCookies("soumu_qa_edit_from");
	deleteCookies("soumu_qa_edit_category_id");
	deleteCookies("soumu_qa_edit_title");
	deleteCookies("soumu_qa_edit_content");
	deleteCookies("soumu_qa_edit_attachment1_checkbox_for_deleting");
	deleteCookies("soumu_qa_edit_attachment2_checkbox_for_deleting");
	deleteCookies("soumu_qa_edit_attachment3_checkbox_for_deleting");
 }

var soumu_qa_regist= getCookie("soumu_qa_regist_title");
if(soumu_qa_regist !="" && soumu_qa_regist !=null && soumu_qa_regist !='null'){
	deleteCookies("soumu_qa_regist_from");
	deleteCookies("soumu_qa_regist_category_id");
	deleteCookies("soumu_qa_regist_title");
	deleteCookies("soumu_qa_regist_content");
	deleteCookies("soumu_qa_regist_attachment1_checkbox_for_deleting");
	deleteCookies("soumu_qa_regist_attachment2_checkbox_for_deleting");
	deleteCookies("soumu_qa_regist_attachment3_checkbox_for_deleting");
 } 

var thanks_edit_comment= getCookie("thanks_edit_comment");
if(thanks_edit_comment !="" && thanks_edit_comment !=null && thanks_edit_comment !='null'){
    deleteCookies("thanks_edit_user_id");
    deleteCookies("thanks_edit_comment");
    deleteCookies("thanks_edit_sender"); 
    deleteCookies("thanks_edit_base_id");   
 }

 //-----------------------------------
var thanks_regist_comment= getCookie("thanks_regist_comment");
if(thanks_regist_comment !="" && thanks_regist_comment !=null && thanks_regist_comment !='null'){
    deleteCookies("thanks_regist_user_id");
    deleteCookies("thanks_regist_comment");
    deleteCookies("thanks_regist_sender");   
    deleteCookies("thanks_regist_base_id");   
 } 
var to_officer_edit_from= getCookie("to_officer_edit_title");
if(to_officer_edit_from !="" && to_officer_edit_from !=null && to_officer_edit_from !='null'){
	deleteCookies("to_officer_edit_from");
	deleteCookies("to_officer_edit_title");
	deleteCookies("to_officer_edit_content");
	deleteCookies("to_officer_edit_attachment1_checkbox_for_deleting");
	deleteCookies("to_officer_edit_attachment2_checkbox_for_deleting");
	deleteCookies("to_officer_edit_attachment3_checkbox_for_deleting");
} 

var trouble_edit_from= getCookie("trouble_edit_title");
if(trouble_edit_from !="" && trouble_edit_from !=null && trouble_edit_from !="null"){
	deleteCookies("trouble_edit_from");
	deleteCookies("trouble_edit_title");
	deleteCookies("trouble_edit_content");
	deleteCookies("trouble_edit_attachment1_checkbox_for_deleting");
	deleteCookies("trouble_edit_attachment2_checkbox_for_deleting");
	deleteCookies("trouble_edit_attachment3_checkbox_for_deleting");
}

var adoption_reg_form= getCookie("adopted_reg_open_type");
if(adoption_reg_form !="" && adoption_reg_form !=null && adoption_reg_form !='null'){
    deleteCookies("adoption_reg_form");
	deleteCookies("adopted_reg_comment");
	deleteCookies("adopted_reg_open_type");
}
var adoption_edit_form= getCookie("adopted_edit_comment");
if(adoption_edit_form !="" && adoption_edit_form !=null && adoption_edit_form !='null'){
	deleteCookies("adoption_edit_form");
	deleteCookies("adopted_edit_comment");
	deleteCookies("adopted_edit_open_type");
} 

</script>
