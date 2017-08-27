<link href="<?php echo $this->assetsBase; ?>/css/admin/css/secondary.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->assetsBase; ?>/css/admin/css/holiday.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript">

jQuery(function($) 
{
	$('ul.yiiPager li.selected').removeClass('selected');
	$('ul.yiiPager li').removeClass('page');
	$('ul.yiiPager li').removeClass('previous');
	$('ul.yiiPager li').removeClass('next');
	$('ul.yiiPager li').removeClass('last');
	$('ul.yiiPager li').removeClass('first');
	$('ul.yiiPager li').removeClass('hidden');
	$('ul.yiiPager').removeClass('yiiPager');
	lock_empty_text=false;
	$("body").attr('id','admin');              
        jQuery('#tagcrowd_form').attr("action","<?php echo Yii::app()->baseUrl;?>/admintagcrowd/registedit/");
        $("td.actions a.btn-work").click(function(){             
            text=$(this).parents("tr").eq(0).find("td.keyword").eq(0).html();
            fontsize=$(this).parents("tr").eq(0).find("td.disp_size").eq(0).html();
            $("input#Tagcrowd_keyword").val(text);
            $("input#Tagcrowd_id").val($(this).parents("tr").eq(0).attr("id"));
            $("select#Tagcrowd_fontsize").val(fontsize);            
            $('button#submit').html('<i class="icon-chevron-right icon-white">&#12288;</i> 更新');            
        });
        $('button#reset').click(function(){            
            $("input#Tagcrowd_id").val(''); 
            $("input#Tagcrowd_keyword").val('');
            $("select#Tagcrowd_fontsize").val('');       
            $('button#submit').html('<i class="icon-chevron-right icon-white">&#12288;</i> 登録');                        
        });
        
        $('button#submit').click(function(){             
			$.ajax({                 			
				type: "POST", 
				async:true,
				url: "<?php echo Yii::app()->baseUrl;?>/admintagcrowd/registedit/",    
				data: jQuery('#tagcrowd_form').serialize(),
				success: function(msg){       					  		
					  jQuery('#Tagcrowd_keyword').prev().remove(); 
                                          jQuery('#Tagcrowd_fontsize').prev().remove(); 
					  	if(msg!='[]'){
                                                    data=$.parseJSON(msg);
                                                    if(data.Tagcrowd_keyword){
                                                         div=document.createElement('div');
                                                         $(div).addClass('alert');
                                                         $(div).addClass('error_message');
                                                         $(div).html(data.Tagcrowd_keyword);
                                                         $(div).insertBefore($('#Tagcrowd_keyword'));
                                                         
                                                    }      
                                                    if(data.Tagcrowd_fontsize){
                                                         div=document.createElement('div');
                                                         $(div).addClass('alert');
                                                         $(div).addClass('error_message');
                                                         $(div).html(data.Tagcrowd_fontsize);
                                                         $(div).insertBefore($('#Tagcrowd_fontsize'));
                                                         
                                                    }      
                                                    
						  
					  	}							  															
					else{                                            
                                                 
                                            if($("#Tagcrowd_id").val()!=''){
                                                if(confirm('更新します。よろしいですか？')==true){                                                    
                                                    jQuery('#tagcrowd_form').submit();
                                                }
                                            }
                                            else{
                                                if(confirm('登録します。よろしいですか？')==true){                                                    
                                                    jQuery('#tagcrowd_form').submit();
                                                }
                                            }     
                                            
                                        }
					  	
											    			    
				}	  
			});
			
		});
        
});
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount();?>"/>
<div class="wrap admin secondary tagcrowd">

    <div class="container index">
        <div class="contents detail">
        	
            <div class="mainBox">
            	<div class="pageTtl">
            		<h2>タグクラウド設定</h2>
            	</div>
                <div class="box">

                <p class="descriptionTxt">検索するキーワードを入力してください</p>
                
                <?php
                
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'tagcrowd_form',                     
                    'htmlOptions' => array(                                         
                                          'class'=>'form-horizontal',                                          
                                          'action'=>Yii::app()->baseUrl."/admintagcrowd/registedit/"
                                          ),
                        ));
                    
                ?>    
                <?php echo $form->hiddenField($model, 'id'); ?> 
                    <div class="cnt-box">
                        <div class="baseDetailBox">

                            <div class="control-group">
                                <label for="keyword" class="control-label">キーワード
                                <span class="label label-warning">必須</span>
                                </label>
                                <div class="controls">                                    
                                    <?php echo $form->error($model, 'keyword'); ?>
                        	    <?php echo $form->textField($model, 'keyword', array('class' => 'input-xlarge')); ?>
                                </div>
                            </div><!--// .control-group -->

							<div class="control-group">
                                <label for="disp_size" class="control-label">表示サイズ
                                	<span class="label label-warning">必須</span></label>
                                <div class="controls">
                                    <?php echo $form->error($model, 'fontsize'); ?>
                                        <?php echo $form->dropDownList($model, 'fontsize', $model->allFontsizes, array('options' => array($model->fontsize => array('selected' => true)))); ?> 
									
                                </div>
                            </div><!--// .control-group -->
                                                        
                        </div><!-- /baseDetailBox -->
					</div><!-- /cnt-box -->
                <?php $this->endWidget(); ?>
                    <div class="form-last-btn">
                        <p class="btn200">
                            <button id="submit" class="btn btn-important" type="submit"><i class="icon-chevron-right icon-white">&#12288;</i> 登録</button>
                            <button id="reset" class="btn" type="button"><i class="icon-remove">&#12288;</i> リセット</button>
                        </p>
                    </div>
					

					<hr>

					<div class="company_1">	
                                            <?php echo CHtml::beginForm('', 'tagcrowd', array('id' => 'index_frm')); ?>
						<table class="table list font14">
	                		<thead>
	                			<tr>
			                		<th class="keyword">キーワード</th>
	                                <th class="disp_size">表示サイズ</th>
	                                <th class="click_count">クリック回数</th>
			                		<th class="updown">並び替え</th>
			                		<th class="actions">編集</th>
		                		</tr>
		                	</thead>
		                	
		                	<tbody>
	                			

                                            <?php 
                                            
                                            if(isset($tagcrowds)&&is_array($tagcrowds)&&count($tagcrowds)>0){
                                                foreach ($tagcrowds as $tagcrowd){?>
                                                    <tr class="item" id="<?php echo $tagcrowd['id'];?>">
                                                            <td class="keyword"><?php echo $tagcrowd['keyword'];?></td>
                                                            <td class="disp_size"><?php echo $tagcrowd['fontsize'];?></td>
                                                            <td class="click_count"><?php echo $tagcrowd['click_no'];?></td>
                                                            <td class="updown">
                                                                    <a class="btn down-btn" id="down-btn" href="#">↓</a>
                                                                    <a class="btn up-btn" id="up-btn" href="#">↑</a>
                                                            </td>
                                                            <td class="actions">
                                                                    <a class="btn btn-work">編集</a>
                                                                    <a onclick="if(confirm('削除します。よろしいですか？')==true) window.location='<?php echo Yii::app()->baseUrl;?>/admintagcrowd/delete/?id=<?php echo $tagcrowd['id'];?>';" class="btn btn-correct">削除</a>
                                                            </td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
	                			

		                	</tbody>
		                </table>
	             	</div>
                
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
                                        <?php echo CHtml::endForm(); ?>

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


<form id="up-down" action="<?php echo Yii::app()->baseUrl."/adminpost/updown/";?>">
    <input type="hidden" name="id1" id="id1"/>
    <input type="hidden" name="id2" id="id2"/>
    <input type="hidden" name="table_name" value="tagcrowd"/>
</form>