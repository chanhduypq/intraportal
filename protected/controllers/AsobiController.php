<?php

class AsobiController extends Controller 
{

	public $pageTitle;
	public function init() 
	{
        parent::init();
		$this->pageTitle="ニューギンスクエア｜あそび";
        if (Yii::app()->request->cookies['id'] == "" || Yii::app()->request->cookies['id']=="null" ) 
		{
         	$this->redirect(array('newgin/'));
        }
          
    }
	
    public function actionIndex() 
	{
		
		
        //$cookie = new CHttpCookie('beforelink', "Asobi");
        //$cookie->expire =Config::TIME_OUT;
        //Yii::app()->request->cookies['beforelink'] = $cookie;           
        $this->render('index');
    }

    public function actionTwiitergetajax() 
	{
        if (Yii::app()->request->isAjaxRequest)
		{
            $keyword_id=Yii::app()->request->getParam('id');
            Yii::app()->db->createCommand("update tagcrowd set click_no=click_no+1 where id=$keyword_id")->execute();
            $row=Yii::app()->db->createCommand("select click_no,fontsize from tagcrowd where id=$keyword_id")->queryRow();
            $click_no=$row['click_no'];
            $fontsize=$row['fontsize'];
            $size='';
            if($click_no<=50){
                if($fontsize!='S'){
                    $size=$fontsize;
                }
                else{
                    $size='S';
                }                
            }
            else if($click_no<=200){
                if($fontsize=='L'){
                    $size=$fontsize;
                }
                else{
                    $size='M';
                }                
            }
            else{
                $size='L';
            }
            Yii::app()->db->createCommand("update tagcrowd set fontsize='$size' where id=$keyword_id")->execute();
            $keyword = Yii::app()->request->getParam('keyword');
            echo $this->getTwiiter($keyword);
            
            Yii::app()->end();
        }
    }
    

    private function getTwiiter($keyword) 
	{
        $twitter_result = array();

        require_once 'twitteroauth/twitteroauth.php';
        $twitter_config = new Twitter_config(FALSE);
        $consumer_key = $twitter_config->getTwitterUserConsumerKey();
        $consumer_secret = $twitter_config->getTwitterUserConsumerSecret();
        $access_token = $twitter_config->getTwitterUserAccessToken();
        $access_token_secret = $twitter_config->getTwitterUserAccessTokenSecret();
        $twitter = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
        $now = date("Y-m-d");
        $content_in_twitter_object = $twitter->get('https://api.twitter.com/1.1/search/tweets.json?q=' . $keyword . ' -rt -via&until=' . $now . '&result_type=recent&count=20');
        if (isset($content_in_twitter_object->errors))
		{
            $twitter_result = array();
        }
        $content_in_twitter_array = $content_in_twitter_object->statuses;
        if (count($content_in_twitter_array) == 0) {
            $twitter_result = array();
        } else {
            foreach ($content_in_twitter_array as $content_in_twitter) {
                $created_at = $this->convertToDBTimeFromTwitterTime($content_in_twitter->created_at);
                $newtime = strtotime($created_at) + (9 * 60 * 60);
                $created_at = date('Y/m/d H:i:s', $newtime);
                $twitter_result[] = array(
                    'created_at' => $created_at,
                    'content' => $content_in_twitter->text,
                    'screen_name'=>$content_in_twitter->user->screen_name.'/status/'.$content_in_twitter->id_str,                    
                    'name'=>$content_in_twitter->user->name
                );
            }
        }


        $html_string = $this->returnHtml($twitter_result, $keyword);
        return $html_string;
    }

    private function returnHtml($content_in_twitter_array, $keyword) {
        ?>
<div class="wrap asobi tagcrowd" style="overflow-y: scroll;max-height: 450px;">
            <h3 class="tag_name" id="tagname"><?php echo $keyword; ?></h3>
            <div class="arrow"></div>
            <table border="0" class="table list font14" style="*width:95%">
                <tbody>
                    <?php
                    foreach ($content_in_twitter_array as $content_in_twitter) {
                        $date_time_array = explode(" ", $content_in_twitter['created_at']);
                        $date = $date_time_array[0];
                        $time_array = explode(":", $date_time_array[1]);
                        $time = $time_array[0] . ':' . $time_array[1];
                        $temp=  explode("status", $content_in_twitter['screen_name']);
                        $list=$temp[0];
                        $list1=  substr($list,0,  strlen($list)-1);
                        ?> 
                        <tr class="item">
                            <td>
                                <p class="comment"><a target="_blank" href="https://twitter.com/<?php echo $content_in_twitter['screen_name']; ?>">
                                        <?php echo FunctionCommon::crop($content_in_twitter['content'], 100); ?>
                                    </a></p>
                                <p class="title">
                                    <span><?php echo $date; ?></span><span><?php echo $time; ?></span></p>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>

        </div>        
        <?php
    }

    private function convertToDBTimeFromTwitterTime($twitter_time) {
        if (!is_string($twitter_time) || trim($twitter_time) == "") {
            return $twitter_time;
        }
        $month = substr($twitter_time, 4, 3);
        if ($month == 'Jan') {
            $month = '01';
        } else if ($month == 'Feb') {
            $month = '02';
        } else if ($month == 'Mar') {
            $month = '03';
        } else if ($month == 'Apr') {
            $month = '04';
        } else if ($month == 'May') {
            $month = '05';
        } else if ($month == 'Jun') {
            $month = '06';
        } else if ($month == 'Jul') {
            $month = '07';
        } else if ($month == 'Aug') {
            $month = '08';
        } else if ($month == 'Sep') {
            $month = '09';
        } else if ($month == 'Oct') {
            $month = '10';
        } else if ($month == 'Nov') {
            $month = '11';
        } else if ($month == 'Dec') {
            $month = '12';
        }

        $day = substr($twitter_time, 8, 2);
        $time = substr($twitter_time, 11, 8);
        $temp = explode(" ", $twitter_time);
        $year = $temp[count($temp) - 1];
        return $year . '-' . $month . '-' . $day . ' ' . $time;
    }

}
