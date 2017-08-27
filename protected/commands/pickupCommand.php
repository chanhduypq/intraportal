<?php

class pickupCommand extends CConsoleCommand {

    private function formatDateFromString($str, $format = "Y年m月d日") {
        if ($str == "" || trim($str) == "0000-00-00 00:00:00") {
            return " ";
        }
        $date = new DateTime($str);
        $return = $date->format($format);

        return $return;
    }

    private function IsExist($pickup_date) {
        $sql = 'select count(*) from pickup where DATE_FORMAT(pickup_date, "%Y-%m-%d")=' . "'" . $pickup_date . "'";
        $rowcount = Yii::app()->db->createCommand($sql)->queryScalar();
        return $rowcount;
    }

    private function SendEmail($emailto, $firstname, $lastname, $pickupday) {

        $body = $lastname . " " . $firstname . "様

ニューギンスクエアの「今日の社員ピックアップ」にて、
あなたのプロフィールが紹介されることとなりました。
	
" . $this->formatDateFromString($pickupday) . "に掲載されますので、
事前に掲載内容（管理メニュー／プロフィールから閲覧修正可）をご確認願います。

よろしくお願い申し上げます。
";

        mb_language('Japanese');
        mb_internal_encoding('UTF-8');
        Yii::import('ext.yii-mail.YiiMailMessage');
        $message = new YiiMailMessage;
        $message->CharSet = 'iso-2022-jp';
        $message->from = Config::EMAIL_USERNAME;
        $message->addTo($emailto);
        $message->subject = mb_convert_encoding(Config::PICKUP_MAILSUB, 'iso-2022-jp');
        $message->setBody(mb_convert_encoding($body, 'iso-2022-jp'));
        Yii::app()->mail->send($message);
    }

    function cut($str, $len) {
        $str = trim($str);
        if (strlen($str) <= $len)
            return $str;
        $str = substr($str, 0, $len);
        if (!empty($str)) {
            if (!substr_count($str, " "))
                return $str;
            while (strlen($str) && ($str[strlen($str) - 1] != " "))
                $str = substr($str, 0, -1);
            $str = substr($str, 0, -1);
        }
        return $str;
    }

    /* private function getUser()
      {
      $sql="SELECT * FROM user WHERE active_flag=1 ORDER BY RAND() LIMIT 0,1";
      $connection=Yii::app()->db;
      $command=$connection->createCommand($sql);
      $user=$command->queryRow();
      var_dump($user);
      exit;
      } */
    /* -------------------------- */

    private function getPickupIndexMax(){
        $index_max=Yii::app()->db->createCommand()
                ->select("max(pickup_index) as max")
                ->from("user")
                ->where("cancel_random = 0 or cancel_random is null")
                ->andWhere("(division1 IS NOT NULL AND division1 in (SELECT id from unit))
                                OR (division2 IS NOT NULL AND division2 in (SELECT id from unit))
                                OR (division3 IS NOT NULL AND division3 in (SELECT id from unit))
                                OR (division4 IS NOT NULL AND division4 in (SELECT id from unit))")
                ->queryScalar()
                ;
        if($index_max==FALSE){
            $index_max=0;
        }
        return $index_max;
    }
    private function getAllUserId(){
        $user_id_array=array();
        $rows=Yii::app()->db->createCommand()
                ->select("id")
                ->from("user")
                ->where("cancel_random = 0 or cancel_random is null")
                ->andWhere("(division1 IS NOT NULL AND division1 in (SELECT id from unit))
                                OR (division2 IS NOT NULL AND division2 in (SELECT id from unit))
                                OR (division3 IS NOT NULL AND division3 in (SELECT id from unit))
                                OR (division4 IS NOT NULL AND division4 in (SELECT id from unit))")
                ->queryAll();
                ;
        if(is_array($rows)&&count($rows)>0){
            foreach ($rows as $row){
                $user_id_array[]=$row['id'];
            }
        }
        return $user_id_array;
    }


    private function createPickup() {                  
        //pickup_id_desc
        //$sql_pickup = "SELECT id, last_choice,created_date FROM pickup WHERE contributor_id=0 ORDER BY id desc LIMIT 1";
        //$connection = Yii::app()->db;
        //$command_sql_pickup = $connection->createCommand($sql_pickup);
        //$pickup_id_desc = $command_sql_pickup->queryRow();

        //user_id_desc
        $user_id_desc = Yii::app()->db->createCommand("select id from user where active_flag=1 order by id desc limit 1")->queryRow();

        $index_max=  $this->getPickupIndexMax();
        $pickup_index=$index_max;
        $user_id_array=array();
        if($index_max=='0'){
            $user_id_array=  $this->getAllUserId();
            $pickup_index++;
        }
        else{            
            $rows=Yii::app()->db->createCommand()
                    ->select("id")
                    ->from("user")
                    ->where("pickup_index < ".$index_max)
                    ->andWhere("cancel_random = 0 or cancel_random is null")
                    ->andWhere("(division1 IS NOT NULL AND division1 in (SELECT id from unit))
                                OR (division2 IS NOT NULL AND division2 in (SELECT id from unit))
                                OR (division3 IS NOT NULL AND division3 in (SELECT id from unit))
                                OR (division4 IS NOT NULL AND division4 in (SELECT id from unit))")
                    ->queryAll();
            if(is_array($rows)&&count($rows)>0){
                foreach ($rows as $row){
                    $user_id_array[]=$row['id'];
                }
            }
            else{
                $user_id_array=  $this->getAllUserId();
                $pickup_index++;
            }
        }
        if(count($user_id_array)>0){   
            $key=  array_rand($user_id_array);            
            $random_user_id_string=" id=".$user_id_array[$key];
            
        }
        else{
            $random_user_id_string=" TRUE ";
        }
//        if (!empty($pickup_id_desc)) {
//            if (empty($pickup_id_desc['last_choice']) || ($pickup_id_desc['last_choice'] == $user_id_desc['id'])) {
//
////                $user = Yii::app()->db->createCommand("select id, mailaddr,firstname,lastname,division1,division2,division3,division4 from user where active_flag=1 order by id asc limit 1")->queryRow();
//                $user = Yii::app()->db->createCommand("select id, mailaddr,firstname,lastname,division1,division2,division3,division4 from user where active_flag=1 and $random_user_id_string")->queryRow();
//            } else if ($pickup_id_desc['last_choice'] < $user_id_desc['id']) {
//
////                $user = Yii::app()->db->createCommand("select id, mailaddr,firstname,lastname,division1,division2,division3,division4 from user where id > " . $pickup_id_desc['last_choice'] . " and active_flag=1 order by id asc limit 1")->queryRow();
//                $user = Yii::app()->db->createCommand("select id, mailaddr,firstname,lastname,division1,division2,division3,division4 from user where active_flag=1 and $random_user_id_string")->queryRow();
//            }
//        } else {
////            $user = Yii::app()->db->createCommand("select id, mailaddr,firstname,lastname,division1,division2,division3,division4 from user where active_flag=1 order by id asc limit 1")->queryRow();
//            $user = Yii::app()->db->createCommand("select id, mailaddr,firstname,lastname,division1,division2,division3,division4 from user where active_flag=1 and $random_user_id_string")->queryRow();
//        }
        $user = Yii::app()->db->createCommand("select id, mailaddr,firstname,lastname,division1,division2,division3,division4 from user where active_flag=1 and $random_user_id_string")->queryRow();
        $current = time() + (14 * 24 * 60 * 60);
        $ts = date('Y-m-d', $current);
        $division = "";
        if ($user['division1'] != "") {
            $division = $user['division1'];
        } else if ($user['division2'] != "") {
            $division = $user['division2'];
        } else if ($user['division3'] != "") {
            $division = $user['division3'];
        } else if ($user['division4'] != "") {
            $division = $user['division4'];
        }

        if ($this->IsExist($ts) == 0) {
            $this->SavePickup($ts, $division, $user['id'], $ts,$pickup_index);
            $ts_last = date('Y-m-d', time() + 7 * 24 * 60 * 60);
            $user_id = Yii::app()->db->createCommand("select user_id from pickup where DATE_FORMAT(pickup_date, '%Y-%m-%d')='" . $ts_last . "'")->queryRow();
            if (!empty($user_id)) {
                $user_sendmail = Yii::app()->db->createCommand("select id, mailaddr,firstname,lastname from user where id=" . $user_id['user_id'])->queryRow();
                $this->SendEmail($user_sendmail['mailaddr'], $user_sendmail['firstname'], $user_sendmail['lastname'], $ts_last);
            }
        }
    }

    private function readAllFiles($path) {
        if (!is_string($path)) {
            return array();
        }
        if (!file_exists($path)) {
            return array();
        }
        if (!is_dir($path)) {
            return array();
        }

        $file_name_array = array();
        if ($handle = opendir($path)) {
            while (($file = readdir($handle)) !== false) {
                if ($file != "." && $file != "..") {
                    $file_name_array[] = $file;
                }
            }
            closedir($handle);
        } else {
            return array();
        }

        return $file_name_array;
    }

    private function getCSVFile($date) {
        if (!file_exists(Yii::getPathOfAlias('webroot') . '/upload/pickup/')) {
            return NULL;
        }
        $file_name_array = $this->readAllFiles(Yii::getPathOfAlias('webroot') . '/upload/pickup/');
        if (!is_array($file_name_array) || count($file_name_array) == 0) {
            return NULL;
        }
        foreach ($file_name_array as $file_name) {
            $temp = explode(".", $file_name);
            if (count($temp) == 2 && strtolower($temp[1]) == 'csv') {
                $temp = explode("_", $temp[0]);
                if (count($temp) == 2) {
                    $temp = explode("-", $temp[1]);
                    $start_date = $this->convertToDate($temp[0]);
                    $end_date = $this->convertToDate($temp[1]);
                    if ($start_date != NULL && $end_date != NULL) {
                        if ($date >= $start_date && $date <= $end_date) {
                            return $file_name;
                        }
                    }
                }
            }
        }
        return NULL;
    }

    private function convertToDate($string) {
        if (!is_string($string) || trim($string) == "" || strlen($string) != 8) {
            return NULL;
        }
        $year = substr($string, 0, 4);
        $month = substr($string, 4, 2);
        $day = substr($string, 6, 2);
        if (checkdate($month, $day, $year) == FALSE) {
            return NULL;
        }
        $date = new DateTime("$year-$month-$day");
        return $date;
    }

    private function getCSVFileData($file_name) {
        $employee_number_array = array();
        if (($handle = fopen(Yii::getPathOfAlias('webroot') . '/upload/pickup/' . $file_name, 'r')) !== FALSE) {
            $size = filesize(Yii::getPathOfAlias('webroot') . '/upload/pickup/' . $file_name);
            $row = 0;
            while (($data = fgetcsv($handle, $size, ',')) !== FALSE) {
                $row++;
                if ($row != 1) {
                    $employee_number_array[] = $data[0];
                }
            }
            fclose($handle);
        }
        return $employee_number_array;
    }

    private function getUserByEmployeeNumber($employee_number) {
        $user=Yii::app()->db->createCommand()
                        ->select("*")
                        ->from("user")
                        ->where("employee_number=:employee_number", array("employee_number" => $employee_number))
                        ->andWhere("active_flag=1")
                        ->queryRow()
        ;
        if($user==FALSE){
            return NULL;
        }
        return $user;
    }

    private function initPickup($employee_number_array, $start_date, $end_date) {
        $employee_number = Yii::app()->db->createCommand()
                ->select("user.employee_number")
                ->from("pickup")
                ->join("user", "pickup.last_choice=`user`.id")
                ->where("user.employee_number IN (" . implode(",", $employee_number_array) . ")")
                ->andWhere("pickup_date BETWEEN '$start_date' AND '$end_date'")
                ->andWhere("user.active_flag=1")
                ->order("pickup.id desc")
                ->limit(1)
                ->queryScalar()
        ;
        if ($employee_number == FALSE) {
            return NULL;
        }
        return $employee_number;
    }

    private function createPickupViaCSVFile($employee_number_array, $start_date, $end_date) {
        $user = array();
        $employee_number = $this->initPickup($employee_number_array, $start_date, $end_date);
        if ($employee_number == NULL) {
            for ($i = 0, $n = count($employee_number_array); $i < $n; $i++) {
                $user_temp=  $this->getUserByEmployeeNumber($employee_number_array[$i]);
                if($user_temp!=NULL){
                    $user=$user_temp;
                    break;
                }
            }            
        } else {
            for ($i = 0, $n = count($employee_number_array); $i < $n; $i++) {
                $user_temp=  $this->getUserByEmployeeNumber($employee_number_array[$i]);
                if($user_temp!=NULL && $user_temp['employee_number']==$employee_number){
                    for ($j = $i+1, $n1 = count($employee_number_array); $j < $n1; $j++) {
                        $user_temp1=  $this->getUserByEmployeeNumber($employee_number_array[$j]);
                        if($user_temp1!=NULL){
                            $user=$user_temp1;
                            break;
                        }
                    }
                    if(!isset($user_temp1)||$user_temp1==NULL){
                        for ($k = 0, $n2=$i; $k < $n2; $k++) {
                            $user_temp2=  $this->getUserByEmployeeNumber($employee_number_array[$k]);
                            if($user_temp2!=NULL){
                                $user=$user_temp2;
                                break;
                            }
                        }
                        if(!isset($user_temp2)||$user_temp2==NULL){
                            $user=$user_temp;
                        }
                    }
                    break;
                }
                
            }
        }
        if(!is_array($user)||count($user)==0){
            return;
        }


        //pickup_id_desc
//        $sql_pickup = "SELECT id, last_choice,created_date FROM pickup WHERE contributor_id=0 ORDER BY id desc LIMIT 1";
//        $connection = Yii::app()->db;
//        $command_sql_pickup = $connection->createCommand($sql_pickup);
//        $pickup_id_desc = $command_sql_pickup->queryRow();
//
//        //user_id_desc
//        $user_id_desc = Yii::app()->db->createCommand("select id from user where active_flag=1 order by id desc limit 1")->queryRow();
//
//        if (!empty($pickup_id_desc)) {
//            if (empty($pickup_id_desc['last_choice']) || ($pickup_id_desc['last_choice'] == $user_id_desc['id'])) {
//
//                $user = Yii::app()->db->createCommand("select id, mailaddr,firstname,lastname,division1,division2,division3,division4 from user where active_flag=1 order by id asc limit 1")->queryRow();
//            } else if ($pickup_id_desc['last_choice'] < $user_id_desc['id']) {
//
//                $user = Yii::app()->db->createCommand("select id, mailaddr,firstname,lastname,division1,division2,division3,division4 from user where id > " . $pickup_id_desc['last_choice'] . " and active_flag=1 order by id asc limit 1")->queryRow();
//            }
//        } else {
//
//            $user = Yii::app()->db->createCommand("select id, mailaddr,firstname,lastname,division1,division2,division3,division4 from user where active_flag=1 order by id asc limit 1")->queryRow();
//        }
        $current = time() + (14 * 24 * 60 * 60);
        $ts = date('Y-m-d', $current);
        $division = "";
        if ($user['division1'] != "") {
            $division = $user['division1'];
        } else if ($user['division2'] != "") {
            $division = $user['division2'];
        } else if ($user['division3'] != "") {
            $division = $user['division3'];
        } else if ($user['division4'] != "") {
            $division = $user['division4'];
        }

        if ($this->IsExist($ts) == 0) {
            $this->SavePickup($ts, $division, $user['id'], $ts);
            $ts_last = date('Y-m-d', time() + 7 * 24 * 60 * 60);
            $user_id = Yii::app()->db->createCommand("select user_id from pickup where DATE_FORMAT(pickup_date, '%Y-%m-%d')='" . $ts_last . "'")->queryRow();
            if (!empty($user_id)) {
                $user_sendmail = Yii::app()->db->createCommand("select id, mailaddr,firstname,lastname from user where id='" . $user_id['user_id'] . "'")->queryRow();
                $this->SendEmail($user_sendmail['mailaddr'], $user_sendmail['firstname'], $user_sendmail['lastname'], $ts_last);
            }
        }
    }

    private function SavePickup($pickup_date, $unit_id, $user_id, $created_date,$pickup_index=NULL) {

        //check pickup_date = achive_date
        $holiday_status0 = Yii::app()->db->createCommand("select title from holiday where DATE_FORMAT(achive_date, '%Y-%m-%d')='" . $pickup_date . "' and status=0")->queryRow();

        $holiday_status1 = Yii::app()->db->createCommand("select title from holiday where DATE_FORMAT(achive_date, '%Y-%m-%d')='" . $pickup_date . "' and status=1")->queryRow();

        //get thu 
        $explode_pickup_date = explode('-', $pickup_date);

        $day = date($explode_pickup_date['2']);
        $mon = date($explode_pickup_date['1']);
        $year = date($explode_pickup_date['0']);

        $jd = cal_to_jd(CAL_GREGORIAN, $mon, $day, $year);
        $thu = jddayofweek($jd, 0);


        $last_choice = null;

        //last_choice achive_date desc, pickup_date = Fr or  pickup_date = Sa
        $last_choice_achive_date_desc = Yii::app()->db->createCommand("select last_choice from pickup where contributor_id=0 ORDER BY pickup_date desc LIMIT 1")->queryRow();
        if (!empty($last_choice_achive_date_desc)) {
            $last_choice = $last_choice_achive_date_desc['last_choice'];
        }
        // pickup_date = Fr
        if ($thu == '6' && empty($holiday_status1)) {
            $unit_id = null;
            $user_id = null;
            $title = "本日は土曜日です";
        }
        // pickup_date = Sa ...
        else if ($thu == '0' && empty($holiday_status1)) {
            $unit_id = null;
            $user_id = null;
            $title = "本日は日曜日です";
        }
        // not empty($holiday)
        else if (!empty($holiday_status0)) {
            $unit_id = null;
            $user_id = null;
            $title = "本日は" . $holiday_status0['title'] . "です";
        } else {
            $last_choice = $user_id;
            $unit_id = $unit_id;
            $user_id = $user_id;
            $title = null;
        }

        if($pickup_index!=NULL){
            $sql = "update user set pickup_index=$pickup_index where id=$user_id";
            Yii::app()->db->createCommand($sql)->execute();
        }
        
        $now=date('Y-m-d H:i:s');
        $sql = "insert into pickup (pickup_date, unit_id,user_id,last_choice,title,contributor_id,created_date,last_updated_date,last_updated_person) values (:pickup_date,:unit_id,:user_id,:last_choice,:title,:contributor_id,:created_date,:last_updated_date,:last_updated_person)";
        $parameters = array(':pickup_date' => $pickup_date,
            ':unit_id' => $unit_id,
            ':user_id' => $user_id,
            ':last_choice' => $last_choice,
            ':title' => $title,
            ':contributor_id' => 0,
            ':created_date' => $now,
            ':last_updated_date' => $now,
            ':last_updated_person' => 'batch',
        );

        
        return Yii::app()->db->createCommand($sql)->execute($parameters);
    }

    private function checkValidation($employee_number_array) {
        if (!is_array($employee_number_array) || count($employee_number_array) == 0) {
            return FALSE;
        }
        foreach ($employee_number_array as $employee_number) {
            $user = $this->getUserByEmployeeNumber($employee_number);
            if ($user == FALSE) {
                return FALSE;
            }
        }
        return TRUE;
    }

    public function run($args) {
        $today = new DateTime(date("Y-m-d"));
        $file_name = $this->getCSVFile($today);
        if (is_string($file_name) && trim($file_name) != "") {
            $employee_number_array = $this->getCSVFileData($file_name);
            if (is_array($employee_number_array) && count($employee_number_array) > 0) {
                $temp = explode(".", $file_name);
                $temp = explode("_", $temp[0]);
                $temp = explode("-", $temp[1]);
                $start_date = $temp[0];
                $year = substr($start_date, 0, 4);
                $month = substr($start_date, 4, 2);
                $day = substr($start_date, 6, 2);
                $start_date = $year . "-" . $month . "-" . $day;
                $end_date = $temp[1];
                $year = substr($end_date, 0, 4);
                $month = substr($end_date, 4, 2);
                $day = substr($end_date, 6, 2);
                $end_date = $year . "-" . $month . "-" . $day;
                $this->createPickupViaCSVFile($employee_number_array, $start_date, $end_date);
            } else {
                $this->createPickup();
            }
        } else {
            $this->createPickup();
        }
    }

}
