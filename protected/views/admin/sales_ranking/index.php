<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js" type="text/javascript"></script>
<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/admin/css/sales_ran.css" rel="stylesheet" type="text/css">
<div class="wrap admin secondary sales_ran">

    <div class="container">
        <div class="contents person">
        	
            <div class="mainBox detail">
		    	
               <!-- <div class="alert info">メッセージを表示します</div>-->
               <?php if(Yii::app()->user->hasFlash('delete_success')){?>
                    <div class="alert info"><?php echo Yii::app()->user->getFlash('delete_success'); ?></div>
                <?php    
                } ?>
            	<div class="pageTtl"><h2>販売ランキング - 設定</h2>
	                <span><a href="<?php echo Yii::app()->request->baseUrl; ?>/majime" class="btn btn-important"><i class="icon-chevron-left icon-white"></i> 一覧に戻る</a></span>
            		<a href="<?php echo Yii::app()->request->baseUrl; ?>/adminsales_ranking/delete" style="cursor:pointer" class="btn btn-work" id="delete_all" onclick="return confirm('<?php echo Lang::MSG_0080; ?>');"><i class="icon-trash icon-white"></i> すべて破棄</a>
                </div>
                <div class="box">
                <form class="form-horizontal" action="../adminsales_ranking/saveData" method="post"  name="formsale" id="sales_ranking_form" enctype ="multipart/form-data">
                <!--parent_box -->
               	<h3>個人ランキング</h3>
				
				<div class="add-btn">
					<button id="button_add_one_1" type="button" class="btn btn-primary" onclick=" return addPersonalRanking()"><span class="icon icon-plus icon-white" ></span> 対象機種の追加</button>
				</div>
		        <div class="cnt-box" id="cnt-box_1">
                <?php
                $i=0;
                foreach($machine as $val){
                    $i++;
                ?>
                    <br/>
                   <div class="target-section" id="target-section_<?php echo $i ?>">
                        <div class="control-group">
                            <label class="control-label" for="title">対象機種&nbsp;
                            <span class="label label-warning">必須</span></label>
                            <div class="controls">
                                <input name="personal_ranking[<?php echo $i ?>][title]" id="title_<?php echo $i ?>" class="input-medium" type="text" placeholder="対象機種名を入力してください。" value="<?php echo $val->machine_name?>" onclick="checkDupPersonalName(this.id)" maxlength="128"/>
                                <input name="personal_ranking[<?php echo $i ?>][id] " value="<?php echo $val->id?>" type="hidden" id="machine_id_<?php echo $i ?>">
                                <input type="hidden" id="old_title_<?php echo $i ?>" name="personal_ranking[<?php echo $i ?>][old_title]" value="<?php echo $val->machine_name ?>"/>
                            </div>
                        </div>
                        <div class="add-btn">
                            <button id="button_ranking_add_<?php echo $i ?>" type="button" class="btn btn-primary" onclick="return addChildBox(<?php echo $i?>)"><span class="icon icon-plus icon-white"></span> ランキングの追加</button>
                        </div>
                        <div id="child_box_<?php echo $i ?>">
                        <?php 
                        $j=0;
                        $k=$val->id;
                        if(isset($personal_rankings[$k]['child']))
                        {
                        foreach($personal_rankings[$k]['child'] as $v1){
                             $j++;
                        ?>
                        
                           
                             <div class="ranking-section" id="ranking-section_<?php echo $i."_".$j ?>">
                                <div class="control-group">
                                    <label class="control-label" for="title">ランキング名&nbsp;
                                    <span class="label label-warning">必須</span></label>
                                    <div class="controls">
                                    	 <div id="error_title_ranking"></div>
                                        <input id="title_ranking_<?php echo $i."_".$j ?>" name="personal_ranking[<?php echo $i ?>][child][<?php echo $j ?>][title_ranking]" class="input-medium" type="text" placeholder="ランキング名を入力してください。" value="<?php echo $v1['ranking_name'] ?>" onclick=" return checkDupRkName(<?php echo  $i.",".$j.",1" ?>) " maxlength="128"/>
                                        <input type="hidden" id="id_ranking_<?php echo $i."_".$j ?>" name="personal_ranking[<?php echo $i ?>][child][<?php echo $j ?>][id]" value="<?php echo $v1['id'] ?>"/> 
                                        <input type="hidden" id="old_title_ranking_<?php echo $i."_".$j ?>" name="personal_ranking[<?php echo $i ?>][child][<?php echo $j ?>][old_title_ranking]" value="<?php echo $v1['ranking_name'] ?>"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="title">ランキング</label>
                                    <div class="controls" >
                                        <ul id="ranking_add_list_<?php echo $i."_".$j ?>">
                                            <?php 
                                            $k=0;
                                            foreach($v1['list'] as $v2){
                                            $k++;?>
                                            <li>
                                                <input id="list_id_<?php echo $i."_".$j."_".$k ?>" name="personal_ranking[<?php echo $i ?>][child][<?php echo $j ?>][list][<?php echo $k ?>][id]" type="hidden" class="input-mini text-center" value="<?php echo $v2['id'] ?>"/>
                                                <input id="list_rank_<?php echo $i."_".$j."_".$k ?>" name="personal_ranking[<?php echo $i ?>][child][<?php echo $j ?>][list][<?php echo $k ?>][list_rank_1]" type="text" class="input-mini text-center" value="<?php echo $v2['rank'] ?>" maxlength="12"/>
                                                <input id="title_rank_<?php echo $i."_".$j."_".$k ?>" name="personal_ranking[<?php echo $i ?>][child][<?php echo $j ?>][list][<?php echo $k ?>][title_rank_1]" type="text" class="input-medium" value="<?php echo $v2['name'] ?>" maxlength="64" />
                                                <input id="units_rank_<?php echo $i."_".$j."_".$k ?>" name="personal_ranking[<?php echo $i ?>][child][<?php echo $j ?>][list][<?php echo $k ?>][units_rank_1]" type="text" class="input-small text-right" value="<?php echo $v2['unit'] ?>" maxlength="48"/>
                                                <div id="error_rank_1"></div>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                        <button id="button_ranking_add_list_1" type="button" class="btn btn-info ranking-add" onclick="addListRanking(<?php echo $i.",".$j ?>)"><span class="icon icon-white icon-plus"></span> ランキング行追加</button>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <a  href="../adminsales_ranking/deletePersonalChild/?id=<?php echo $v1['id']  ?>" style="cursor:pointer" class="btn btn-link" id="RemoveRanking_section_1" onclick="return confirm('<?php echo Lang::MSG_0079 ?>');"><span class="icon icon-remove"></span> このランキングを削除</a>
                                </div>
                            </div>
                            
                       <!--add #ranking-section-->
                       <?php }
                       } ?>
                       </div>  
                       <div class="text-right">
                            <a href="../adminsales_ranking/deletePersonalParent/?id=<?php echo $val->id;  ?>" style="cursor:pointer" class="btn btn-link" id="Removecnt_box" onclick="return confirm('<?php echo Lang::MSG_0079 ?>');"><span class="icon icon-remove"></span> この対象機種を削除</a>
                       </div> 
                  </div>
                 <?php } ?>
             </div>  
                 <!--id cnt-box -->
             <!-- A part raking-->    
            <h3>拠点ランキング</h3>
				
				<div class="text-right">
					<button type="button" class="btn btn-primary" onclick="return addPartRanking()"><span class="icon icon-plus icon-white"></span> 集計日の追加</button>
				</div>
				
                <div class="cnt-box" id="cnt-box_2">
                	<?php 
                    $p=0;
                    foreach($part_rankings as $val){ $p++; ?>
                    <br />
                	<div class="ranking-target" id="ranking-target_<?php echo $p ?>">
                		
	                    <div class="control-group">
	                        <label class="control-label" for="title">集計日付&nbsp;
	                        <span class="label label-warning">必須</span></label>
	                        <div class="controls">
                           <?php $currentYear=date("Y");?>
                           <select id="deadline_year_<?php echo $p ?>" name="part_ranking[<?php echo $p ?>][deadline_year]" class="input-small" onchange="return changeYearDate(<?php echo $p ?>)">
                    		<option value="">選択なし</option>
                            <?php
                              for($i=$currentYear;$i<=$currentYear+6;$i++){
                                $select="";  
                                if((int)date('Y', strtotime($val['contribution_date']))==$i) $select="selected";
                                
                                echo "<option value='$i' $select >$i</option>" ;
                            }
                            ?>
                         	</select> - <select id="deadline_month_<?php echo $p ?>" name="part_ranking[<?php echo $p ?>][deadline_month]" class="input-mini" onchange="return changeYearDate(<?php echo $p ?>)">
                        	<option value="">選択なし</option>
                            <?php 
                              for($i=1;$i<=12;$i++){
                                $select="";  
                                if((int)date('m', strtotime($val['contribution_date']))==$i) $select="selected";
                               
                                if($i<10){
                                    echo "<option value='$i' $select>0$i</option>" ;
                                }
                                else{
                                    echo "<option value='$i' $select>$i</option>" ;
                                }
                                
                            }
                            ?>
                        	</select> - <select id="deadline_date_<?php echo $p ?>" name="part_ranking[<?php echo $p ?>][deadline_date]" class="input-mini" onclick="addDateOption(<?php echo $p ?>)">
                        	<option value="">選択なし</option>
                            <?php 
                              for($i=1;$i<=31;$i++){
                                $select="";  
                                if((int)date('d', strtotime($val['contribution_date']))==$i) $select="selected";
                               
                                if($i<10){
                                    echo "<option value='$i' $select>0$i</option>" ;
                                }
                                else{
                                    echo "<option value='$i' $select>$i</option>" ;
                                }
                                
                            }?>
                        	</select>
	                        </div>
	                    </div>
                        <div class="control-group">
                            <label class="control-label" for="title">ランキング名&nbsp;
                            <span class="label label-warning">必須</span></label>
                            <div class="controls">
                                 <input id="id_ranking_<?php echo $p ?>" name="part_ranking[<?php echo $p ?>][id]" class="input-medium" type="hidden"  value="<?php echo $val['id']?>"/>
                               	 <input id="title_ranking_<?php echo $p ?>" name="part_ranking[<?php echo $p ?>][title_ranking]" class="input-medium" type="text" placeholder="ランキング名を入力してください。" value="<?php echo $val['ranking_name']?>" maxlength="128"/>
                            </div>
                        </div>
	
	                    <div class="control-group">
	                        <label class="control-label" for="title">ランキング</label>
	                        <div class="controls">
	        					<ul id="list_raking_part_<?php echo $p ?>">
                                <?php 
                                $q=0;
                                foreach($val['list'] as $v) {
                                $q++;    
                                ?>
	        						<li>
                                        <input id="list_id_<?php echo $p."_".$q ?>" type="hidden" name="part_ranking[<?php echo $p ?>][list][<?php echo $q ?>][id]" class="input-mini text-center" value="<?php echo $v['id'] ?>"/>
	        							<input id="list_rank_<?php echo $p."_".$q ?>" type="text" name="part_ranking[<?php echo $p ?>][list][<?php echo $q ?>][list_rank_1]" class="input-mini text-center" value="<?php echo $v['rank'] ?>" maxlength="12"/>
	        							<input id="title_rank_<?php echo $p."_".$q ?>" type="text" name="part_ranking[<?php echo $p ?>][list][<?php echo $q ?>][title_rank_1]" class="input-medium" value="<?php echo $v['name'] ?>" maxlength="64"/>
	        							<input id="units_rank_<?php echo $p."_".$q ?>" type="text" name="part_ranking[<?php echo $p ?>][list][<?php echo $q ?>][units_rank_1]" class="input-small text-right" value="<?php echo $v['unit'] ?>" maxlength="48"/>
	        						</li>
                                <?php } ?>    
	        					</ul>
	        					<button type="button" class="btn btn-info ranking-add" onclick="return addListRankingPart(<?php echo $p ?>)"><span class="icon icon-white icon-plus"></span> ランキング行追加</button>
	                        </div>
	                    </div>
	                    
	                    <div class="text-right">
	                    	<a href="../adminsales_ranking/deletePersonalChild/?id=<?php echo $val['id']?>" class="btn btn-link" onclick="return confirm('<?php echo Lang::MSG_0079 ?>');"><span class="icon icon-remove" ></span> この拠点ランキングを削除</a>
	                    </div>
                	</div>
                	<?php } ?>
                </div><!-- /cnt-box -->

            
             <!-- end box -->
                <div class="form-last-btn">
                	<p class="btn80">
	                    <button type="submit" class="btn btn-important" onclick="return validateForm()"><i class="icon-chevron-right icon-white">　</i> 設定</button>
                    </p>
                </div>
                </form>
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
<script language="javascript">
    function addPersonalRanking()
    {
        var num_cnt_box=$(".cnt-box .target-section").length;
        var i=num_cnt_box+1;
        var parent_box=$("#cnt-box_1");
        $(  '<br/>'
            +'<div class="target-section" id="target-section_'+i+'">'
            +'<div class="control-group">'
            +'<label class="control-label" for="title">対象機種&nbsp;'
            +'<span class="label label-warning">必須</span></label>'
            +'<div class="controls">'
            +'<input name="personal_ranking['+i+'][title]" id="title_'+i+'" class="input-medium" type="text" placeholder="対象機種名を入力してください。" maxlength="128"/>'
            +'<input name="personal_ranking['+i+'][id]" id="machine_id_'+i+'" value="" type="hidden">'
            +'<input type="hidden" id="old_title_'+i+'" name="personal_ranking['+i+'][old_title]" value=""/>'
            +'</div></div>'
            +'<div class="add-btn">'
            +'<button id="button_ranking_add_'+i+'" type="button" class="btn btn-primary" onclick="return addChildBox('+i+',1)"><span class="icon icon-plus icon-white"></span> ランキングの追加</button>'
            +'</div>'
            +'<div id="child_box_'+i+'">'
            +'<div class="ranking-section" id="ranking-section_'+i+'_1">'
            +'<div class="control-group">'
            +'<label class="control-label" for="title">ランキング名&nbsp;'
            +'<span class="label label-warning">必須</span></label>'
            +'<div class="controls">'
            +' <input type="hidden" id="id_ranking_'+i+'_1" name="personal_ranking['+i+'][child][1][id]" value=""/>' 
            +'<input id="title_ranking_'+i+'_1" name="personal_ranking['+i+'][child][1][title_ranking]" class="input-medium" type="text" placeholder="ランキング名を入力してください。" maxlength="128"/>'
            +'</div>'
            +'</div>'
            +'<div class="control-group">'
            +'<label class="control-label" for="title">ランキング</label>'
            +'<div class="controls" >'
            +'<ul id="ranking_add_list_'+i+'_1">'
            +'<li>'
            +'<input id="list_id_'+i+'_1_1" name="personal_ranking['+i+'][child][1][list][1][id]" type="hidden" class="input-mini text-center" value=""/>'
            +'<input id="list_rank_'+i+'_1_1" name="personal_ranking['+i+'][child][1][list][1][list_rank_1]" type="text" class="input-mini text-center" maxlength="12"/>&nbsp'
            +'<input id="title_rank_'+i+'_1_1" name="personal_ranking['+i+'][child][1][list][1][title_rank_1]" type="text" class="input-medium" maxlength="64" />&nbsp'
            +'<input id="units_rank_'+i+'_1_1" name="personal_ranking['+i+'][child][1][list][1][units_rank_1]" type="text" class="input-small text-right"  maxlength="48"/>'
            +'<div id="error_rank_1"></div>'
            +'</li>'
            +'</ul>'
            +'<button id="button_ranking_add_list_1" type="button" class="btn btn-info ranking-add" onclick="addListRanking('+i+',1)"><span class="icon icon-white icon-plus"></span> ランキング行追加</button>'
            +'</div>'
            +'</div>'
            +'<div class="text-right">'
            +'<a style="cursor:pointer" class="btn btn-link" id="RemoveRanking_section_1" onclick="return removeChildBox('+i+',1)"><span class="icon icon-remove"></span> このランキングを削除</a>'
            +'</div>'
            +'</div>'
            +'</div>'
            +'<div class="text-right">'
            +'<a style="cursor:pointer" class="btn btn-link" onclick="return removeParentBox('+i+')"><span class="icon icon-remove"></span> この対象機種を削除</a>'
            +'</div>'
           
            
        ).appendTo(parent_box);
    }
	function removeParentBox(id)
    {
        $(".alert").remove();
        $("#target-section_"+id).remove();
        return false;
    }
    function addListRanking(parentId,id){
        var numList=$("#ranking_add_list_"+parentId+'_'+id).length;
        var i=numList+1;
        var numList1 =$("#ranking_add_list_"+parentId+'_'+id+" li").length +1;
        var addToList=$("#ranking_add_list_"+parentId+'_'+id);
        $(
             '<li>'
             +'<input id="list_id_'+parentId+'_'+id+'_'+numList1+'" name="personal_ranking['+parentId+'][child]['+id+'][list]['+numList1+'][id]" type="hidden" class="input-mini text-center" value=""/>'
             +'<input id="list_rank_'+parentId+'_'+id+'_'+numList1+'" name="personal_ranking['+parentId+'][child]['+id+'][list]['+numList1+'][list_rank_1]" type="text" class="input-mini text-center" maxlength="12"/>&nbsp'
             +'<input id="title_rank_'+parentId+'_'+id+'_'+numList1+'" name="personal_ranking['+parentId+'][child]['+id+'][list]['+numList1+'][title_rank_1]" type="text" class="input-medium" maxlength="64"/>&nbsp'
             +'<input id="units_rank_'+parentId+'_'+id+'_'+numList1+'" name="personal_ranking['+parentId+'][child]['+id+'][list]['+numList1+'][units_rank_1]" type="text" class="input-small text-right" maxlength="48" />'
             +'<div id="error_rank_1"></div>'
             +'</li>'
        ).appendTo(addToList);
    }
    function addChildBox(parentId,id){
        var numChild=$('#child_box_'+parentId+' .ranking-section').length;
        var i=numChild+1;
        var childBox=$("#child_box_"+parentId);
        $( +'</br>' 
           +'<div class="ranking-section" id="ranking-section_'+parentId+'_'+i+'">'
           +'<div class="control-group">'
           +'<label class="control-label" for="title">ランキング名&nbsp;'
           +'<span class="label label-warning">必須</span></label>'
           +'<div class="controls">'
           +'<input type="hidden" id="id_ranking_'+parentId+'_'+i+'" name="personal_ranking['+parentId+'][child]['+i+'][id]" value=""/>' 
           +'<input id="title_ranking_'+parentId+'_'+i+'" name="personal_ranking['+parentId+'][child]['+i+'][title_ranking]" class="input-medium" type="text" placeholder="ランキング名を入力してください。" maxlength="128"/>'
           +'</div>'
           +'</div>'
           +'<div class="control-group">'
           +'<label class="control-label" for="title">ランキング</label>'
           +'<div class="controls" >'
           +'<ul id="ranking_add_list_'+parentId+'_'+i+'">'
           +'<li>'
           +'<input id="list_id_'+parentId+'_'+i+'_1" name="personal_ranking['+parentId+'][child]['+i+'][list][1][id]" type="hidden" class="input-mini text-center" value="" />'
           +'<input id="list_rank_'+parentId+'_'+i+'_1" name="personal_ranking['+parentId+'][child]['+i+'][list][1][list_rank_1]" type="text" class="input-mini text-center" maxlength="12"/>&nbsp'
           +'<input id="title_rank_'+parentId+'_'+i+'_1" name="personal_ranking['+parentId+'][child]['+i+'][list][1][title_rank_1]" type="text" class="input-medium" maxlength="64"/>&nbsp'
           +'<input id="units_rank_'+parentId+'_'+i+'_1" name="personal_ranking['+parentId+'][child]['+i+'][list][1][units_rank_1]" type="text" class="input-small text-right" maxlength="48" />'
           +'<div id="error_rank_1"></div>'
           +'</li>'
           +'</ul>'
           +'<button id="button_ranking_add_list_1" type="button" class="btn btn-info ranking-add" onclick="addListRanking('+parentId+','+i+')"><span class="icon icon-white icon-plus"></span> ランキング行追加</button>'
           +'</div>'
           +'</div>'
           +'<div class="text-right">'
           +'<a style="cursor:pointer" class="btn btn-link" id="RemoveRanking_section_1" onclick="return removeChildBox('+parentId+','+i+')"><span class="icon icon-remove"></span> このランキングを削除</a>'
           +'</div>'
           +'</div>'
        ).appendTo(childBox);
    }
    function removeChildBox(parentId,id){
		
        $(".alert").remove();
        $("#ranking-section_"+parentId+"_"+id).remove();
		var listRankingPart= $("#list_raking_part_"+id)
        $('<div style="display:none" class="ranking-section">').appendTo('#child_box_'+parentId);
        return false;
    }
    function deleteChildBox(id,i,j){
      $.ajax({
           type:"POST",
           url:'/adminsales_ranking/deletePersonalChild',
           async:false,
           data:{id:id},
           success:function(data){
            if($.trim(data)=="OK")
            {
                
            }
           }
            
        });
        return false;
    }
    function addPartRanking()
    {
        var currentYear=parseInt(new Date().getFullYear());
        var numBox=$(".cnt-box .ranking-target").length;
        var i=numBox+1;
        var parent_box=$("#cnt-box_2");
        $(  '<br/>' 
            +'<div class="ranking-target" id="ranking-target_'+i+'">'
            +'<div class="control-group">'
	        +'<label class="control-label" for="title">集計日付&nbsp;'
	        +'<span class="label label-warning">必須</span></label>'
	        +'<div class="controls">'
	        +'<select id="deadline_year_'+i+'" name="part_ranking['+i+'][deadline_year]" class="input-small" onchange="return changeYearDate('+i+')">'
            +'<option value="">選択なし</option>'
            +'<option value="'+currentYear+'">'+currentYear+'</option>'
            +'<option value="'+(currentYear+1)+'">'+(currentYear+1)+'</option>'
            +'<option value="'+(currentYear+2)+'">'+(currentYear+2)+'</option>'
            +'<option value="'+(currentYear+3)+'">'+(currentYear+3)+'</option>'
            +'<option value="'+(currentYear+4)+'">'+(currentYear+4)+'</option>'
            +'<option value="'+(currentYear+5)+'">'+(currentYear+5)+'</option>'
            +'<option value="'+(currentYear+6)+'">'+(currentYear+6)+'</option>'
            +'</select> - <select id="deadline_month_'+i+'" name="part_ranking['+i+'][deadline_month]" class="input-mini" onchange="return changeYearDate('+i+')">'
            +'<option value="">選択なし</option>'           
            +'<option value="01">01</option>'
            +'<option value="02">02</option>'
            +'<option value="03">03</option>'
            +'<option value="04">04</option>'
            +'<option value="05">05</option>'
            +'<option value="06">06</option>'
            +'<option value="07">07</option>'
            +'<option value="08">08</option>'
            +'<option value="09">09</option>'
            +'<option value="10">10</option>'
            +'<option value="11">11</option>'
            +'<option value="12">12</option>'
            +'</select> - <select id="deadline_date_'+i+'" name="part_ranking['+i+'][deadline_date]" class="input-mini" onclick="addDateOption('+i+')">'
            +'<option value="">選択なし</option>'
            +'<option value="01">01</option>'
            +'<option value="02">02</option>'
            +'<option value="03">03</option>'
            +'<option value="04">04</option>'
            +'<option value="05">05</option>'
            +'<option value="06">06</option>'
            +'<option value="07">07</option>'
            +'<option value="08">08</option>'
            +'<option value="09">09</option>'
            +'<option value="10">10</option>'
            +'<option value="11">11</option>'
            +'<option value="12">12</option>'
            +'<option value="13">13</option>'
            +'<option value="14">14</option>'
            +'<option value="15">15</option>'
            +'<option value="16">16</option>'
            +'<option value="17">17</option>'
            +'<option value="18">18</option>'
            +'<option value="19">19</option>'
            +'<option value="20">20</option>'
            +'<option value="21">21</option>'
            +'<option value="22">22</option>'
            +'<option value="23">23</option>'
            +'<option value="24">24</option>'
            +'<option value="25">25</option>'
            +'<option value="26">26</option>'
            +'<option value="27">27</option>'
            +'<option value="28">28</option>'
            +'<option value="29">29</option>'
            +'<option value="30">30</option>'
            +'<option value="31">31</option>'
            +'</select>'
	        +'</div>'
	        +'</div>'
            +'<div class="control-group">'
            +'<label class="control-label" for="title">ランキング名&nbsp;'
            +'<span class="label label-warning">必須</span></label>'
            +'<div class="controls">'
            +'<input id="id_ranking_'+i+'" name="part_ranking['+i+'][id]" class="input-medium" type="hidden" placeholder="ランキング名を入力してください。" value=""/>'
            +'<input id="title_ranking_'+i+'" name="part_ranking['+i+'][title_ranking]" class="input-medium" type="text" placeholder="ランキング名を入力してください。" maxlength="128"/>'
            +'</div>'
            +'</div>'
        	+'<div class="control-group">'
	        +'<label class="control-label" for="title">ランキング</label>'
	        +'<div class="controls">'
	        +'<ul id="list_raking_part_'+i+'">'
	        +'<li>'
            +'<input id="list_id_'+i+'_1" type="hidden" name="part_ranking['+i+'][list][1][id]" class="input-mini text-center" value=""/>'
	        +'<input id="list_rank_'+i+'_1" type="text" name="part_ranking['+i+'][list][1][list_rank_1]" class="input-mini text-center" maxlength="12" />&nbsp'
	        +'<input id="title_rank_'+i+'_1" type="text" name="part_ranking['+i+'][list][1][title_rank_1]" class="input-medium" maxlength="64"/>&nbsp'
	        +'<input id="units_rank_'+i+'_1" type="text" name="part_ranking['+i+'][list][1][units_rank_1]" class="input-small text-right" maxlength="48" />'
	        +'</li>'
	        +'</ul>'
	        +'<button type="button" class="btn btn-info ranking-add" onclick="return addListRankingPart('+i+') "><span class="icon icon-white icon-plus"></span> ランキング行追加</button>'
	        +'</div>'
	        +'</div>'
	        +'<div class="text-right">'
	        +'<a href="#" class="btn btn-link" onclick="return removeChildRankingPart('+i+')"><span class="icon icon-remove" ></span> この拠点ランキングを削除</a>'
	        +'</div>'
            +'</div>'
        ).appendTo(parent_box);
    }
    function addListRankingPart(id){
        var i= $("#list_raking_part_"+id+ " li").length +1 ;
        var listRankingPart= $("#list_raking_part_"+id)
        $(
            	'<li>'
                +'<input id="list_id_'+id+'_'+i+'" type="hidden" name="part_ranking['+id+'][list]['+i+'][id]" class="input-mini text-center" value=""/>'
	            +'<input id="list_rank_'+id+'_'+i+'" type="text" name="part_ranking['+id+'][list]['+i+'][list_rank_1]" class="input-mini text-center" maxlength="12"/>&nbsp'
	        	+'<input id="title_rank_'+id+'_'+i+'" type="text" name="part_ranking['+id+'][list]['+i+'][title_rank_1]" class="input-medium" maxlength="64" />&nbsp'
	        	+'<input id="units_rank_'+id+'_'+i+'" type="text" name="part_ranking['+id+'][list]['+i+'][units_rank_1]" class="input-small text-right" maxlength="48" />'
	        	+'</li>'
        ).appendTo(listRankingPart);
    }
    function removeChildRankingPart(id)
    {
        $("#ranking-target_"+id).remove();
        return false;
    }
    function validateForm()
    {
        $(".alert").remove();
        var resultPsParent=true;
        var resultPsChild=true;
        var resultApart=true;
        var numParent=$(".cnt-box .target-section").length;
        for (var i=1;i<=numParent;i++){
            $("#error_title_"+i).remove();
            if($("#title_"+i).val()==""){
                 div=document.createElement('div');
                 $(div).addClass('alert');
                 $(div).addClass('error_message');
                 $(div).attr("id","error_title_"+i);
                 $(div).html("<?php echo Lang::MSG_0077 ?>");
                 $(div).insertBefore($("#title_"+i));
                 resultPsParent=false;
            }
            else {
                if(!checkDupMachinename(i))
                {
                     div=document.createElement('div');
                     $(div).addClass('alert');
                     $(div).addClass('error_message');
                     $(div).attr("id","error_title_"+i);
                     $(div).html("<?php echo Lang::MSG_0110 ?>");
                     $(div).insertBefore($("#title_"+i));
                     resultPsParent=false;
                }
                
            }
            resultPsChild=checkChildbox(i);
            
           
        }
        resultApart=checkApartRanking();
        if(resultPsParent && resultPsChild && resultApart)
        {
            return true;
        }
        else{
             div=document.createElement('div');
             $(div).addClass('alert');
             $(div).addClass('info');
             $(div).html("<?php echo Lang::MSG_0083 ?>");
             $(div).insertBefore($(".pageTtl"));
             $('html, body').animate({ scrollTop: 0 }, 'slow');  
            return false;
        }
    }
    function checkChildbox(id)
    {
        var resultCheckChildbox=true;
        var resultCheckList=true;
        var numbChild=numChild=$('#child_box_'+id+' .ranking-section').length;
		
        for(var i=1;i<=numChild;i++){
			 if($("#title_ranking_"+id+"_"+i).length > 0){
					$("#error_title_"+id+"_"+i).remove();
					if($("#title_ranking_"+id+"_"+i).val()==""){
						 div=document.createElement('div');
						 $(div).addClass('alert');
						 $(div).addClass('error_message');
						 $(div).attr("id","error_title_"+id+"_"+i)
						 $(div).html("<?php echo Lang::MSG_0074 ?>");
						 $(div).insertBefore($("#title_ranking_"+id+"_"+i));
						 resultCheckChildbox=false;
					}
					else if(!checkDupRkName(id,i,1)){
						 div=document.createElement('div');
						 $(div).addClass('alert');
						 $(div).addClass('error_message');
						 $(div).attr("id","error_title_"+id+"_"+i)
						 $(div).html("<?php echo Lang::MSG_0075 ?>");
						 $(div).insertBefore($("#title_ranking_"+id+"_"+i));
						 resultCheckChildbox=false;
					}
					$("#error_list_"+id+"_"+i).remove();
					resultCheckList= checkValidateList(id,i);
			 }
        }
        return (resultCheckChildbox && resultCheckList);
       
    }
    function checkValidateList(parentId,id)
    {
         var numList =$("#ranking_add_list_"+parentId+'_'+id+" li").length
         var result=false;
         var result2=true;
         for(var i=1;i<=numList;i++){
            var list_rank=$("#list_rank_"+parentId+"_"+id+"_"+i).val();
            var title_rank=$("#title_rank_"+parentId+"_"+id+"_"+i).val();
            var units_rank=$("#units_rank_"+parentId+"_"+id+"_"+i).val();
            if(list_rank && title_rank && units_rank)
            {
                result=true;
            }
            else if(list_rank=="" && title_rank=="" && units_rank=="")
            {
                result2=true;
            }
            else{
                result2=false;
            }
         }
         if(!result || !result2){
             div=document.createElement('div');
             $(div).addClass('alert');
             $(div).addClass('error_message');
             $(div).attr("id","error_list_"+parentId+"_"+id)
             $(div).html("<?php echo Lang::MSG_0076 ?>");
             $(div).insertBefore($("#ranking_add_list_"+parentId+'_'+id));
             
         }
         return result && result2;
         
    }
    function checkApartRanking()
    {
        var numParent=$("#cnt-box_2 .ranking-target").length;
        var resultCheck=true;
        var resultCheckList=true;
        for (var i=1;i<=numParent;i++){
            $("#error_title_apartranking_"+i).remove();
            $("#error_list_apart_"+i).remove();  
            $("#error_title_apartname_"+i).remove();            
            if($("#deadline_year_"+i).val()=="" || $("#deadline_month_"+i).val()=="" ||$("#deadline_date_"+i).val()==""){
                 
                 resultCheck=false;
                 div=document.createElement('div');
                 $(div).addClass('alert');
                 $(div).addClass('error_message');
                 $(div).attr("id","error_title_apartranking_"+i)
                 $(div).html("<?php echo Lang::MSG_0078 ?>");
                 $(div).insertBefore($("#deadline_year_"+i));
                
            }
            if($("#title_ranking_"+i).val()=="")
            {
                 resultCheck=false;
                 div=document.createElement('div');
                 $(div).addClass('alert');
                 $(div).addClass('error_message');
                 $(div).attr("id","error_title_apartname_"+i)
                 $(div).html("<?php echo Lang::MSG_0074 ?>");
                 $(div).insertBefore($("#title_ranking_"+i));
            }
            else if(!checkDupRkNamePart(i,2))
            {
                 resultCheck=false;
                 div=document.createElement('div');
                 $(div).addClass('alert');
                 $(div).addClass('error_message');
                 $(div).attr("id","error_title_apartname_"+i)
                 $(div).html("<?php echo Lang::MSG_0075 ?>");
                 $(div).insertBefore($("#title_ranking_"+i));
            }
           resultCheckList=checkListApart(i);
            
           
        }
        return (resultCheck && resultCheckList);
    }
    function checkListApart(id)
    {
         
         var numList =$("#list_raking_part_"+id+" li").length
         var result=false;
         var result2=true;
         for(var i=1;i<=numList;i++){
            var list_rank=$("#list_rank_"+id+"_"+i).val();
            var title_rank=$("#title_rank_"+id+"_"+i).val();
            var units_rank=$("#units_rank_"+id+"_"+i).val();
            if(list_rank && title_rank && units_rank )
            {
                result=true;
            }
            else if(list_rank=="" && title_rank=="" && units_rank=="")
            {
                result2=true;
            }
            else{
                result2=false;
            }
         }
         if(!result || !result2){
             div=document.createElement('div');
             $(div).addClass('alert');
             $(div).addClass('error_message');
             $(div).attr("id","error_list_apart_"+id)
             $(div).html("<?php echo Lang::MSG_0076 ?>");
             $(div).insertBefore($("#list_raking_part_"+id));
             
         }
         return result && result2;
         
    }
    function addDateOption(id)
	{
        var year=$('#deadline_year_'+id).val();
        
		var month=$('#deadline_month_'+id).val();
       	var date;
        var sl= document.getElementById("deadline_date_"+id).options;
		var  len = sl.length-1;
       	if(year && month)
		{
			date=getDateNum(year,month);
    	}
		else
		{
			date=31;
		}
		if(len==1)
		{
			sl.remove(len);
			for(i=1;i<=date;i++)
				{
					$("#deadline_date_"+id).append('<option value='+i+'>'+i+'</option>');
				}
		}
		else
		{
			if(date>=len)
			{
				var i=date-len;
				for(j=1;j<=i;j++)
				{
					$("#deadline_date_"+id).append('<option value='+(len+j)+'>'+(len+j)+'</option>');
				}
			}
			else
			{
				var i=len-date;
				for(j=0;j<i;j++)
				{
					sl.remove(len-j);
				}
			}
		}
		return;
	}
    /* Function return nurber of day when have year anh month */		
		function getDateNum(y,m)
		{
			var numDate=31;
			if( dupYear(y) && (m==2))
			{
				numDate=29;
			}
			else
			{
				if(m==2) 
				{
					numDate=28;
				}
				if( m==4 ||m==6 || m==9 || m==11 )
				{
					numDate=30;
				}
			}
			return numDate;	
		}
/* Check leap year */		
		function dupYear(y)
		{
			if(((y%4==0)&& (y%100!=0))|| (y%400==0))
			{
				return true;
			}	
			else 
			{
				return false;
			}
		}
        function checkDupRkName(id1,id2,type)
        {
           var resultDup=false;
           var ranking_name=$("#title_ranking_"+id1+"_"+id2).val();
           var id=$("#id_ranking_"+id1+"_"+id2).val();
           var machine_name_id=$("#machine_id_"+id1).val();
            $.ajax({
                type:"POST",
                url:"../adminsales_ranking/checkDupRkNamePersonal",
                async:false,
                data:{id:id,type:type,ranking_name:ranking_name,machine_name_id:machine_name_id},
                success:function(data){
                    if($.trim(data)==0)
                    {
                        resultDup=true;
                    }
                }
            });
            return resultDup;
        }
        function checkDupRkNamePart(id,type)
        {
           var resultDup=false;
           var ranking_name=$("#title_ranking_"+id).val();
           var id=$("#id_ranking_"+id).val();
            $.ajax({
                type:"POST",
                url:"../adminsales_ranking/checkDupRkName",
                async:false,
                data:{id:id,type:type,ranking_name:ranking_name},
                success:function(data){
                    if($.trim(data)==0)
                    {
                        resultDup=true;
                    }
                }
            });
            return resultDup;
        }
        function deletePersonalParent(id)
        {
          var machine_name_id=$("#machine_id_"+id).val();
           $.ajax({
           type:"POST",
           url:'/adminsales_ranking/deletePersonalParent',
           async:false,
           data:{machine_name_id:machine_name_id},
           success:function(data){
                if($.trim(data)=="OK")
                {
                     removeChildBox(id);
                     div=document.createElement('div');
                     $(div).addClass('alert');
                     $(div).addClass('info');
                     $(div).html("<?php echo Lang::MSG_0081 ?>");
                     $(div).insertBefore($('.pageTtl'));
                     $('html, body').animate({ scrollTop: 0 }, 'slow');  
                 }
                
           }
            
           });
           return false;
        }
        function checkDupMachinename(id)
        {
            var machine_id=$("#machine_id_"+id).val();
            var machine_name=$("#title_"+id).val();
            var resultDup=false;
            $.ajax({
                type:"POST",
                url:"../adminsales_ranking/checkDupMachinename",
                async:false,
                data:{machine_id:machine_id,machine_name:machine_name},
                success:function(data){
                    if($.trim(data)==0)
                    {
                        resultDup=true;
                    }
                }
            });
            return resultDup;
                     
        }
        function  changeYearDate(id)
        {
            $("#deadline_date_"+id).val("");
        }
        
</script>