<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/common/css/prettyPhoto.css" rel="stylesheet"  media="screen" />
<script src="<?php echo $this->assetsBase; ?>/css/common/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo $this->assetsBase; ?>/css/common/js/initPrettyPhoto.js"></script>
<script type="text/javascript">
    jQuery(function($) {

        $("#Soumu_jinji_deadline_month").change(function() {
            var month = $("#Soumu_jinji_deadline_month").val();
            var year = $("#Soumu_jinji_deadline_year").val();
            if (month == 4 || month == 6 || month == 9 || month == 11) {
                day(30);
            }
            else
            if (month == 2) {
                if ((year % 400 == 0) || (year % 4 == 0 && year % 100 != 0)) {
                    day(29);
                }
                else {
                    day(28);
                }
            }
            else {
                day(31);
            }
        });
        $("#Soumu_jinji_deadline_year").change(function() {
            var month = $("#Soumu_jinji_deadline_month").val();
            var year = $("#Soumu_jinji_deadline_year").val();
            if (month == 4 || month == 6 || month == 9 || month == 11) {
                day(30);
            }
            else
            if (month == 2) {
                if ((year % 400 == 0) || (year % 4 == 0 && year % 100 != 0)) {
                    day(29);
                }
                else {
                    day(28);
                }
            }
            else {
                day(31);
            }
        });

        function day(day_number) {
            $('#Soumu_jinji_deadline_day').html("");
            for (i = 1; i <= day_number; i++) {
                $('#Soumu_jinji_deadline_day').append("<option value=" + i + ">" + i + "</option>");
            }
        }
        ;
    });

</script>
<div class="wrap admin secondary soumu_jinji" >

    <div class="container">
        <div class="contents edit">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>総務からのお知らせ：人事 - 修正</h2>
                <?php 
					if(Yii::app()->request->cookies['page']!= "") 
					{
						   $page = "index?page=".Yii::app()->request->cookies['page'];
							
					}else {$page ="";}
					?>
                <span><a href="<?php echo Yii::app()->request->baseUrl; ?>/adminsoumu_jinji/<?php echo $page;?>" class="btn btn-important"><i class="icon-chevron-left icon-white"></i> 一覧に戻る</a></span>
                </div>
                <div class="box">
                <div class="cnt-box">
                	<?php
					$form = $this->beginWidget('CActiveForm', array(
						'id' => 'soumu_jinji_form',                     
						'htmlOptions' => array( 
											  'class'=>'form-horizontal',
											  'onsubmit'=>'return false;',
											  ),
						 ));
						 echo $form->hiddenField($model, 'id');
						 echo $form->hiddenField($model, 'created_date');
					?>	 
                    
                    <div class="control-group">
                        <label class="control-label" for="title">カテゴリー&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	<?php 
								$array_category = array();
                                foreach ($category as $category_type){
										if($category_type['type']==3){	
                                      		 $array_category[$category_type['id']]=$category_type['category_name'];
										}
                                      
                                }
								echo $form->dropDownList($model,'category_id',$array_category, array('prompt'=>'選んで下さい','style'=>'width:440px;')); ?>
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label" for="pubdate">日付&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	<?php								
							  	 $now 	     = getdate();
  							     $year 	     = $now["year"];
								 $lastyear   = $year +5;
                                 $array_year = array();
                                for($year;$year<=$lastyear;$year++){
                                    $array_year[$year]=$year;
                                }
                                echo $form->dropDownList($model,
                                        'deadline_year',
                                        $array_year,
                                        array('class'=>'input-small')
									);
                                ?>
                                <?php 
                                $array_month=array();
                                for($i=1;$i<=12;$i++){
									if($i<10){
                                    $array_month['0'.$i]='0'.$i;
									}
									else{ 
									$array_month[$i]=$i;
									}
                                }
                                echo $form->dropDownList($model,
                                        'deadline_month',
                                        $array_month,
                                        array('class'=>'input-mini'));
                                ?>
                                <?php 
                                $array_day=array();
                                for($i=1;$i<=31;$i++){
                                   if($i<10){
                                    $array_day['0'.$i]='0'.$i;
									}
									else{ 
									$array_day[$i]=$i;
									}
                                }
                                echo $form->dropDownList($model,
                                        'deadline_day',
                                        $array_day,
                                        array('class'=>'input-mini'));
                                ?>                    
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="name">内容&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	 <?php echo $form->error($model, 'employee_name'); ?>
                        	 <?php echo $form->textField($model, 'employee_name', array('placeholder' => '必ず入力してください。', 'class' => 'input-large','style'=>'width:426px;')); ?>
                        </div>
                    </div>
                    
                </div><!-- /cnt-box -->
                
                <div class="form-last-btn">
                	<p class="btn80">
	                    <button type="submit" class="btn btn-important"><i class="icon-chevron-right icon-white">　</i> 確認</button>
                    </p>
                </div>
                
                <?php $this->endWidget(); ?>
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
<script type="text/javascript">  
		//check browm chrome
		if (navigator.userAgent.indexOf('Chrome') != -1){        
			from=getCookie("from_jini");        
			if(from=="confirmedit"){
				deleteCookies("from_jini");              
				window.location="<?php echo Yii::app()->baseUrl.'/adminsoumu_jinji/edit?id='.$model->id;?>"; 
			}
    	} 
		
		jQuery(function($) {        
			$("body").attr('id','admin');  
			   
		   //check back browser 	    
		   category_id=getCookie("category_id");
		   if(category_id!=null&&category_id!="null"){
			   $("#Soumu_jinji_category_id").val(category_id);
		   }
		   employee_name=getCookie("employee_name");
		   if(employee_name!=null&&employee_name!="null"){
			   $("#Soumu_jinji_employee_name").val(employee_name);
		   }
		   
		   deadline_year=getCookie("deadline_year");
		   if(deadline_year!=null&&deadline_year!="null"){
			   $("#Soumu_jinji_deadline_year").val(deadline_year);
		   }
		    deadline_month=getCookie("deadline_month");
		   if(deadline_month!=null&&deadline_month!="null"){
			   $("#Soumu_jinji_deadline_month").val(deadline_month);
		   }
		    deadline_day=getCookie("deadline_day");
		   if(deadline_day!=null&&deadline_day!="null"){
			   $("#Soumu_jinji_deadline_day").val(deadline_day);
		   }
           setCookie("category_id",$("#Soumu_jinji_category_id").val());
           setCookie("employee_name",$("#Soumu_jinji_employee_name").val());  
		   setCookie("deadline_year",$("#Soumu_jinji_deadline_year").val());
           setCookie("deadline_month",$("#Soumu_jinji_deadline_month").val()); 
		   setCookie("deadline_day",$("#Soumu_jinji_deadline_day").val());
		   	         
           $('button[type="submit"]').click(function(){  
		    deleteCookies("from_jini"); 	     
			var id = $('#Soumu_jinji_id').val();
			
			if(checkId(id)){} 
				   
			$.ajax({    
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/adminsoumu_jinji/edit/",    
				data: jQuery('#soumu_jinji_form').serialize(),
				success: function(msg){	                        
					    jQuery('#soumu_jinji_form input[type="text"],#soumu_jinji_form select[id="Soumu_jinji_category_id"]').prev().remove();
					  	if(msg!='[]'){

                                                    data=$.parseJSON(msg);
                                                    if(data.Soumu_jinji_category_id){
														
                                                         div=document.createElement('div');
                                                         $(div).addClass('alert');
                                                         $(div).addClass('error_message');
                                                         $(div).html(data.Soumu_jinji_category_id);
                                                         $(div).insertBefore($('#Soumu_jinji_category_id'));
                                                         
                                                    } 
													
                                                    if(data.Soumu_jinji_employee_name){
                                                         div=document.createElement('div');
                                                         $(div).addClass('alert');
                                                         $(div).addClass('error_message');
                                                         $(div).html(data.Soumu_jinji_employee_name);
                                                         $(div).insertBefore($('#Soumu_jinji_employee_name')); 
                                                    } 
					  	}							  															
					else{     
										setCookie("category_id",$("#Soumu_jinji_category_id").val());
										   setCookie("employee_name",$("#Soumu_jinji_employee_name").val());  
										   setCookie("deadline_year",$("#Soumu_jinji_deadline_year").val());
										   setCookie("deadline_month",$("#Soumu_jinji_deadline_month").val()); 
										   setCookie("deadline_day",$("#Soumu_jinji_deadline_day").val());
                                            jQuery('#soumu_jinji_form').attr('onsubmit','return true;');
                                            jQuery('#soumu_jinji_form').submit();
                                        }					    			    
				}	  
			});
			
		});  
           <?php if(isset($valid)&&$valid==true){?>
		    $(window).load(function()
             {
				from=getCookie("from_jini");
			 	 if(from==null||from!="confirmedit"){ 
					$("#soumu_jinji_form").attr('action','<?php echo Yii::app()->baseUrl;?>/adminsoumu_jinji/editconfirm/');
						jQuery('#soumu_jinji_form').attr('onsubmit','return true;');
						$("#soumu_jinji_form").submit();
				}
				 deleteCookies("from_jini"); 
			});	 			
           <?php }?>
           errorDivs=jQuery('div.errorMessage');
            for(i=0,n=errorDivs.length;i<n;i++){
                if(jQuery(errorDivs[i]).html()!=""){                     
                    jQuery(errorDivs[i]).addClass('alert');
                    jQuery(errorDivs[i]).addClass('error_message');
                }
            }
            
        });
		//check id
		function checkId(id)
		{
			$.ajax({   
			type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/adminsoumu_jinji/checkId/",    
				data:{id:id},
				success: function(msg){	                  
					if(msg>0){ 
						window.location.href='<?php echo Yii::app()->baseUrl;?>/adminsoumu_jinji/';
					}
				}
			});
		}
</script>