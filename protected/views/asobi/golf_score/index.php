<link href="<?php echo $this->assetsBase; ?>/css/asobi/css/secondary.css" rel="stylesheet" type="text/css"/>
<script language="javascript">
    golf_score_regist_from = getCookie("golf_score_regist_score");
    if (golf_score_regist_from != "" && golf_score_regist_from != null && golf_score_regist_from != "null")
    {
        deleteCookies("golf_score_regist_from", {path: '/'});
        deleteCookies("golf_score_regist_score", {path: '/'});
        deleteCookies("golf_score_regist_score_name", {path: '/'});
        deleteCookies("golf_score_regist_deadline_year", {path: '/'});
        deleteCookies("golf_score_regist_deadline_month", {path: '/'});
        deleteCookies("golf_score_regist_deadline_day", {path: '/'});
    }
    jQuery(function($)
    {
        $("body").attr('id', 'asobi');
    });
</script>
<input type="hidden" id="page_count" value="<?php echo $pages->getPageCount(); ?>"/>
<div class="wrap asobi secondary golf_score">

    <div class="container">
        <div class="contents index">

            <div class="mainBox">
                <div class="pageTtl"><h2>ゴルフもマジメ！年間スコアランキング</h2>
                    <a href="<?php echo Yii::app()->baseUrl ?>/asobi/" class="btn btn-important"><i class="icon-home icon-white"></i> あそびのTopへ戻る</a>
                    <?php if (FunctionCommon::isPostFunction("golf_score") == true) {
                        ?>
                        <a href="<?php echo Yii::app()->baseUrl ?>/asobigolf_score/regist" class="btn btn-important"><i class="icon-pencil icon-white"></i> 登録</a>
                    <?php } ?>
                </div>
                <div class="box">

                    <!--p class="descriptionTxt"></p-->
                    <table width="724" border="0" class="table list font14">
                        <thead>
                            <tr>
                                <th class="td-rank">ランク</th>
                                <th class="td-name">お名前</th>
                                <th class="td-couse">コース名・日付</th>
                                <th class="td-score">スコア</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
							//07/01/2014 baodt
                            if ($ide != null && is_array($ide) && count($ide) > 0) {
                                
                                $number_init=FALSE;
                                $index=0;
                                $same=false;
                                $span_string_prev_remeber='';
                                
                                $score_array=array();
                                $score=$ide[0]['score'];
                                $score_array[]=$score;

                                for($i=1,$n=count($ide);$i<$n;$i++){
                                    if($score!=$ide[$i]['score']){
                                        $score=$ide[$i]['score'];
                                        $score_array[]=$score;
                                    }
                                }    
                                $count=$page*Config::LIMIT_ROW;
                                $count1=$count+1;
                                
                                for($i=0,$n=count($score_array);$i<$n;$i++){            
                                    if($i==0){
                                        $count_view=$count1;                                        
                                    }
                                    else{                                        
                                        $count_view=$count+1;
                                    }
                                    foreach ($ide as $score) {
                                        if($score_array[$i]==$score['score']){
                                            $count++;
                                            $arrUser = FunctionCommon::getInforUser_golf_score($score['contributor_id']);?>
                         				 <tr>
                                            <td class="td-rank">
											<?php 
                                            if($i==0){
                                                echo '<span class="ranking rank'.$count1.'">'.$count1.'</span>';                                           
                                            }
                                            else{
                                                echo '<span class="ranking rank'.$count_view.'">'.$count_view.'</span>';
                                            }
                                            ?>
                                            </td>
                                            <td class="td-name">
           									<?php echo (!empty($arrUser['lastname']) ? $arrUser['lastname'] : null) ?>
                                                &nbsp;
                                            <?php echo (!empty($arrUser['firstname']) ? $arrUser['firstname'] : null) ?>

                                            </td>
                                            <td class="td-couse">
                                                <ul class="inline">
                                                    <li class="name">
            <?php echo htmlspecialchars($score['score_name']) ?>
                                                    </li>
                                                    <li class="date"><?php echo FunctionCommon::formatDate($score['score_date']); ?></li>
                                                </ul>
                                            </td>
                                            <td class="td-score"><?php echo $score['score'] ?></td>
                                        </tr>
                                            <?php
                                        } 
                                    }
                                }
							}
							?>   
                        </tbody>
                    </table>

                            <?php $this->widget('ext.Pagination.Base', array('CPaginationObject' => $pages)); ?>

                </div><!-- /box -->
            </div><!-- /mainBox -->

        </div><!-- /contents -->
        <p id="page-top"><a href="#wrap">PAGE TOP</a></p>

    </div><!-- /container -->

    <div class="footer">
        <p>COPYRIGHT (C) Newgin  ALL RIGHTS RESERVED.</p>
    </div>

</div><!-- /wrap -->