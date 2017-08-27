<?php
class Golf_scorewidget extends CWidget
{
	public function init()
	{

	}

	public function run()
	{
		//07/01/2014 baodt
		$sql		= "select contributor_id,contributor_id as contributorid, Min(score) as minscore,Min(score) as score, score_name, score_date from golf_score GROUP BY contributor_id,score_name,score_date HAVING minscore <= (SELECT Min(score) as minscore FROM golf_score where contributor_id=contributorid LIMIT 1) ORDER BY score  limit 5";
		$command	= Yii::app()->db->createCommand($sql); 
		$ide		= $command->queryAll();
		
		$urlIndex	= Yii::app()->baseUrl.'/asobigolf_score/index';
		$urlRegist  = Yii::app()->baseUrl.'/asobigolf_score/regist';
		
		echo '<div class="scoreBox">';
		echo '<div class="box score">';
		echo '<h3>年間スコアランキング</h3>';
        echo '<div class="cntBox">';
		echo '<div class="ttl">';	
		echo '<h4>詳細スコア</h4>';
        echo '<span class="best">ベストスコア</span>';
        echo '</div>'; 	
		echo '<ul>';
		
		$i=1;	
                if(FunctionCommon::isViewFunction("golf_score")==FALSE){
                    $ide=array();
                }
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
					$count=0;
					for($i=0,$n=count($score_array);$i<$n;$i++){            
						if($i==0){
							$count_view=1;
						}
						else{
							
							$count_view=$count+1;
						}
						foreach ($ide as $score) {
							if($score_array[$i]==$score['score']){
								$count++;
								$arrUser = FunctionCommon::getInforUser_golf_score($score['contributor_id']);
											
								if($i==0){
									echo '<li class="ranking rank1">';
								}
								else{
									echo '<li class="ranking rank'.$count_view.'">';
								}
								echo '<ul>';
								echo '<li class="text">';
								echo '<span class="date">'.FunctionCommon::formatDate($score['score_date']).'</span>';
								echo '<p class="name">'.$arrUser['lastname'].'&nbsp;'.$arrUser['firstname'].'</p>';
								echo '</li>';
								echo '<li class="best">'.$score['score'].'</li>';
								echo '</ul>';
								echo '<p class="corse">'.$score['score_name'].'</p>';
								echo '</li>';
							}
						}
					}
		}
		echo '</ul>';	
		echo '</div><!-- /cntBox -->';
		echo '<p class="listBtn">';
		if(FunctionCommon::isViewFunction("golf_score")==true)
		{
			echo  '<a href='.$urlIndex.' class="middleBtn listview mr10 floatL">一覧を見る</a>';
		}
		if(FunctionCommon::isPostFunction("golf_score")==true)
		{
			echo '<a href='.$urlRegist.' class="miniBtn regist02 floatL">登録</a>';
        }
		echo '</p>';
        echo '</div><!-- /box - score -->';
        echo '</div><!-- /scoreBox -->';
	}
}



