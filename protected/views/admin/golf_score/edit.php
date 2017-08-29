
<script type="text/javascript">
    jQuery(function($) {

        $("#Golf_score_deadline_month").change(function() {
            var month = $("#Golf_score_deadline_month").val();
            var year = $("#Golf_score_deadline_year").val();
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
        $("#Golf_score_deadline_year").change(function() {
            var month = $("#Golf_score_deadline_month").val();
            var year = $("#Golf_score_deadline_year").val();
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
            $('#Golf_score_deadline_day').html("");
            for (i = 1; i <= day_number; i++) {
                $('#Golf_score_deadline_day').append("<option value=" + i + ">" + i + "</option>");
            }
        }
        ;
    });

</script>
<div class="wrap admin secondary golf_score">
    <div class="container">
        <div class="contents edit">
        	
            <div class="mainBox detail">
            	<div class="pageTtl"><h2>ゴルフもマジメ！年間スコアランキング - 修正</h2>
                <?php 
					if(Yii::app()->request->cookies['page']!= "") 
					{
						   $page = "index?page=".Yii::app()->request->cookies['page'];
							
					}else {$page ="";}
					?>
                <span><a class="btn btn-important" href="<?php echo Yii::app()->request->baseUrl; ?>/admingolf_score/<?php echo $page;?>"><i class="icon-chevron-left icon-white"></i> 一覧に戻る</a></span>
                </div>
                <div class="box">
                <?php
                
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'golf_score_form',                     
                    'htmlOptions' => array(
                                          'enctype' => 'multipart/form-data',
                                          'class'=>'form-horizontal',                                          
                                          ),
                        ));
                    
                ?> 
                <?php echo $form->hiddenField($model, 'id'); ?>                    
                <div class="cnt-box">
                    
                    <div class="control-group">
                        <label for="score" class="control-label">スコア&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	<?php echo $form->error($model, 'score'); ?>
                        	<?php echo $form->textField($model, 'score', array('placeholder' => 'タイトルを入力してください。[25文字]', 'class' => 'input-small','onkeypress'=>'return keypress(event);')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="name">コース名&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	<?php echo $form->error($model, 'score_name'); ?>
                        	 <?php echo $form->textField($model, 'score_name', array('placeholder' => 'コース名を入力してください。', 'class' => 'input-xxlarge')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="pubdate">日付&nbsp;
                        <span class="label label-warning">必須</span></label>
                        <div class="controls">
                        	<?php								
							  	 $now 	     = getdate();
  							     $year 	     = $now["year"];
								 $lastyear   = $year -5;
                                 $array_year = array();
                                for($lastyear;$lastyear <= $year; $lastyear++){
                                    $array_year[$lastyear]=$lastyear;
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
                    
                </div><!-- /cnt-box -->
                <?php $this->endWidget(); ?>
                <div class="form-last-btn">                    
                	<p class="btn80">
	                    <button type="submit" class="btn btn-important"><i class="icon-chevron-right icon-white">&#12288;</i> 確認</button>
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
            </div>
            
        </div><!-- /contents -->
        <p id="page-top" style="display: none;"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->
    
    <div class="footer">
    	<p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div>

<script type="text/javascript">       

        jQuery(function($){ 
           $("#golf_score_form").attr('action', '<?php echo Yii::app()->baseUrl; ?>/admingolf_score/editconfirm/');   
            
           score=getCookie("golf_score_edit_score");
           if(score!=null&&score!="null"){
               $("#Golf_score_score").val(score);
           }
		   score_name=getCookie("golf_score_edit_score_name");
		   if(score_name!=null&&score_name!="null"){
			   $("#Golf_score_score_name").val(score_name);
		   }
          
		   deadline_year=getCookie("golf_score_edit_deadline_year");
		   if(deadline_year!=null&&deadline_year!="null"){
			   $("#Golf_score_deadline_year").val(deadline_year);
		   }
		    deadline_month=getCookie("golf_score_edit_deadline_month");
		   if(deadline_month!=null&&deadline_month!="null"){
			   $("#Golf_score_deadline_month").val(deadline_month);
		   }
		    deadline_day=getCookie("golf_score_edit_deadline_day");
		   if(deadline_day!=null&&deadline_day!="null"){
			   $("#Golf_score_deadline_day").val(deadline_day);
		   }
          
		   setCookie("golf_score_edit_score",$("#Golf_score_score").val()); 
           setCookie("golf_score_edit_score_name",$("#Golf_score_score_name").val());  
		   setCookie("golf_score_edit_deadline_year",$("#Golf_score_deadline_year").val());
           setCookie("golf_score_edit_deadline_month",$("#Golf_score_deadline_month").val()); 
		   setCookie("golf_score_edit_deadline_day",$("#Golf_score_deadline_day").val());
		   
           $("body").attr('id','admin');     
           $('button[type="submit"]').click(function(){  
                 
            deleteCookies("golf_score_edit_from");  
            checkId();
			$.ajax({ 
                			
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/admingolf_score/edit/?id=<?php echo $model->id;?>",    
				data: jQuery('#golf_score_form').serialize(),


				success: function(msg){	                        
					  jQuery('#Golf_score_score').prev().remove();                                       					                					
					  jQuery('#Golf_score_score_name').prev().remove();  
                      jQuery('#Golf_score_deadline_year').prev().remove();  
                                 					
				  	  if(msg!='[]' || !compareCurrentDate())
                      {
								data=$.parseJSON(msg);
								if(data.Golf_score_score){
									 div=document.createElement('div');
									 $(div).addClass('alert');
									 $(div).addClass('error_message');
									 $(div).html(data.Golf_score_score);
									 $(div).insertBefore($('#Golf_score_score'));
									 
								} 
								if(data.Golf_score_score_name){
									 div=document.createElement('div');
									 $(div).addClass('alert');
									 $(div).addClass('error_message');
									 $(div).html(data.Golf_score_score_name);
									 $(div).insertBefore($('#Golf_score_score_name')); 
								} 
                                if(!compareCurrentDate())
                                {
                            	    div=document.createElement('div');
                                	$(div).addClass('alert');
                                	$(div).addClass('error_message');
                                	$(div).html("<?php echo Lang::MSG_0137?>");
                                	$(div).insertBefore($('#Golf_score_deadline_year'));
                                }
                                                   
					  	}							  															
                        else
                        {   
                                setCookie("golf_score_edit_score",$("#Golf_score_score").val()); 
							    setCookie("golf_score_edit_score_name",$("#Golf_score_score_name").val());  
							    setCookie("golf_score_edit_deadline_year",$("#Golf_score_deadline_year").val());
							    setCookie("golf_score_edit_deadline_month",$("#Golf_score_deadline_month").val()); 
							    setCookie("golf_score_edit_deadline_day",$("#Golf_score_deadline_day").val());
                                jQuery('#golf_score_form').submit();
                       }					    			    
				}	  
			});
			
		});        
  });  
    function checkId()
    {
            jQuery.ajax({   
            type: "POST", 
                    async:true,
                    url: "<?php echo Yii::app()->baseUrl;?>/admingolf_score/checkId/",    
                    data:{id:"<?php echo $model->id;?>",table:"golf_score"},
                    success: function(msg){	
                
                            
                            if(msg=='0'){ 
                                    window.location='<?php echo Yii::app()->baseUrl;?>/admingolf_score';
                            }
                    }
            });
    }
    function keypress(e)
	{
		var keypressed = null;
		if (window.event)
		{
			keypressed = window.event.keyCode;
		}
		else
		{ 
			keypressed = e.which;
		}
		
		if (keypressed < 48 || keypressed > 57)
		{
			if (keypressed == 8 || keypressed == 127)
			{
			return;
			}
			return false;
		}
	}
    
    
    function compareCurrentDate()
    {
        var result=true;
        var myYear = $("#Golf_score_deadline_year").val();
        var myMonth =$("#Golf_score_deadline_month").val();
        var myDay = $("#Golf_score_deadline_day").val();
        var mydate=new Date(myYear,myMonth,myDay);

        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        var dateCurrent = new Date(yyyy,mm,dd);
        if(mydate>dateCurrent)
        {
            result=false; 
        }
        return result;
    }
</script>
