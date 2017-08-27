<?php

class basenewsCommand extends CConsoleCommand {

    private function hasMainDivision($employee_number_array) {
        if (is_array($employee_number_array) && count($employee_number_array) > 0) {
            foreach ($employee_number_array as $employee_number) {
                $unit_id = $this->getRanBaseByEmployeeNumber($employee_number);
                if ($unit_id != NULL) {
                    return true;
                }
            }
        }
        return FALSE;
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

    private function initBasenew($employee_number_array, $start_date, $end_date) {
        if (is_array($employee_number_array) && count($employee_number_array) > 0) {
            $unit_id_array = array();
            foreach ($employee_number_array as $employee_number) {
                $unit_id = $this->getRanBaseByEmployeeNumber($employee_number);
                if ($unit_id != NULL) {
                    $unit_id_array[] = $unit_id;
                }
            }
            if (count($unit_id_array) > 0) {
                $base_id = Yii::app()->db->createCommand()
                        ->select("base_news.last_choice")
                        ->from("base_news")
                        ->where("base_news.last_choice IN (" . implode(",", $unit_id_array) . ")")
                        ->andWhere("pickup_date BETWEEN '$start_date' AND '$end_date'")
                        ->order("base_news.id desc")
                        ->limit(1)
                        ->queryScalar()
                ;
                if ($base_id == FALSE) {
                    return NULL;
                }
                return $base_id;
            }
        }
        return NULL;
    }

    private function formatDateFromString($str, $format = "Y年m月d日") {
        if ($str == "" || trim($str) == "0000-00-00 00:00:00") {
            return " ";
        }
        $date = new DateTime($str);
        $return = $date->format($format);

        return $return;
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
        return Yii::app()->db->createCommand()
                        ->select("*")
                        ->from("user")
                        ->where("employee_number=:employee_number", array("employee_number" => $employee_number))
                        ->andWhere("active_flag=1")
                        ->queryRow()
        ;
    }

    private function IsExist($pickup_date) {
        $sql = 'select count(*) from base_news where DATE_FORMAT(pickup_date, "%Y-%m-%d")=' . "'" . $pickup_date . "'";
        $rowcount = Yii::app()->db->createCommand($sql)->queryScalar();
        return $rowcount;
    }

    private function SendEmail($emailto, $unitname, $pickupday) {

        $body = $unitname . "御中

ニューギンスクエアにてあなたがた部署が「今週の部署紹介」として
" . $this->formatDateFromString($pickupday) . "の週に掲載される事となりました。
に掲載される事となりました。

掲載内容はログイン後部署詳細ページにて事前に確認する事ができます。
掲載日迄に内容を見直しては如何でしょうか？

もし掲載をご希望されない場合は、総務までご連絡ください。
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

    private function SaveBaseNew($pickup_date, $unit_id,$basenews_index=NULL) {
        $now = FunctionCommon::getDateTimeSys();
        $sql = "insert into base_news (pickup_date, base_id, last_choice,contributor_id,created_date,last_updated_date,last_updated_person) values (:pickup_date,:base_id,:last_choice,:contributor_id,:created_date,:last_updated_date,:last_updated_person)";
        $parameters = array(':pickup_date' => $pickup_date,
            ':base_id' => $unit_id,
            ':last_choice' => $unit_id,
            ':contributor_id' => 0,
            ':created_date' => $now,
            ':last_updated_date' => $now,
            ':last_updated_person' => 'batch',
        );

        Yii::app()->db->createCommand($sql)->execute($parameters);
        if($basenews_index!=NULL){
            $sql = "update unit set basenews_index=$basenews_index where id=$unit_id";
            Yii::app()->db->createCommand($sql)->execute();
        }
    }

    private function getBasenewsIndexMax() {
        $index_max = Yii::app()->db->createCommand()
                ->select("max(basenews_index) as max")
                ->from("unit")
                ->where("cancel_random = 0 or cancel_random is null")
                ->queryScalar()
        ;
        if ($index_max == FALSE) {
            $index_max = 0;
        }
        return $index_max;
    }

    private function getAllUnitId() {
        $unit_id_array = array();
        $rows = Yii::app()->db->createCommand()
                ->select("id")
                ->from("unit")
                ->where("cancel_random = 0 or cancel_random is null")
                ->queryAll();
        ;
        if (is_array($rows) && count($rows) > 0) {
            foreach ($rows as $row) {
                $unit_id_array[] = $row['id'];
            }
        }
        return $unit_id_array;
    }

    private function getRanBase() {


        $sql_base_news = "SELECT id, last_choice,created_date FROM base_news WHERE contributor_id=0 ORDER BY id desc LIMIT 1";
        $connection = Yii::app()->db;
        $command_sql_base_news = $connection->createCommand($sql_base_news);
        $base_news_id_desc = $command_sql_base_news->queryRow();

        //user_id_desc
        $unit_id_desc = Yii::app()->db->createCommand("select id from unit where active_flag=1 order by id desc limit 1")->queryRow();

        if (!empty($base_news_id_desc)) {

            if ($base_news_id_desc['last_choice'] == $unit_id_desc['id']) {

                $unit = Yii::app()->db->createCommand("select id from unit where active_flag=1 order by id asc limit 1")->queryRow();
            } else if ($base_news_id_desc['last_choice'] < $unit_id_desc['id']) {

                $unit = Yii::app()->db->createCommand("select id from unit where id > " . $base_news_id_desc['last_choice'] . " and active_flag=1 order by id asc limit 1")->queryRow();
            }
        } else {

            $unit = Yii::app()->db->createCommand("select id from unit where active_flag=1 order by id asc limit 1")->queryRow();
        }
        return $unit['id'];
    }

    private function getRanBaseByEmployeeNumber($employee_number) {
        $user = $this->getUserByEmployeeNumber($employee_number);
        if ($user['position1'] == Config::POSITION_ID && $user['division1'] != "") {
            return $user['division1'];
        }
        if ($user['position2'] == Config::POSITION_ID && $user['division2'] != "") {
            return $user['division2'];
        }
        if ($user['position3'] == Config::POSITION_ID && $user['division3'] != "") {
            return $user['division3'];
        }
        if ($user['position4'] == Config::POSITION_ID && $user['division4'] != "") {
            return $user['division4'];
        }
        return NULL;
    }

    private function createBaseNewViaCSVFile($employee_number_array, $start_date, $end_date) {
        $unit_id = $this->initBasenew($employee_number_array, $start_date, $end_date);
        if ($unit_id == NULL) {
            for ($i = 0, $n = count($employee_number_array); $i < $n; $i++) {
                $unit_id_temp = $this->getRanBaseByEmployeeNumber($employee_number_array[$i]);
                if ($unit_id_temp != NULL) {
                    $unit_id = $unit_id_temp;
                    break;
                }
            }
        } else {
            for ($i = 0, $n = count($employee_number_array); $i < $n; $i++) {
                $unit_id_temp = $this->getRanBaseByEmployeeNumber($employee_number_array[$i]);
                if ($unit_id_temp == $unit_id) {
                    for ($j = $i + 1, $n1 = count($employee_number_array); $j < $n1; $j++) {
                        $unit_id_temp1 = $this->getRanBaseByEmployeeNumber($employee_number_array[$j]);
                        if ($unit_id_temp1 != NULL) {
                            $unit_id = $unit_id_temp1;
                            break;
                        }
                    }
                    if (!isset($unit_id_temp1) || $unit_id_temp1 == NULL) {
                        for ($k = 0, $n2 = $i; $k < $n2; $k++) {
                            $unit_id_temp2 = $this->getRanBaseByEmployeeNumber($employee_number_array[$k]);
                            if ($unit_id_temp2 != NULL) {
                                $unit_id = $unit_id_temp2;
                                break;
                            }
                        }
                        if (!isset($unit_id_temp2) || $unit_id_temp2 == NULL) {
                            $unit_id = $unit_id_temp;
                        }
                    }
                    break;
                }
            }
        }



        $current_day = date("N");
        $days_from_monday = $current_day - 1;
        $this_week_monday = date("Y-m-d", strtotime("- {$days_from_monday} Days"));
        $four_week_before = date('Y-m-d', strtotime($this_week_monday . ' + 28 day'));
        if ($this->IsExist($four_week_before) == 0) {
//            $ran_base = $this->getRanBase();
            if ($this->SaveBaseNew($four_week_before, $unit_id)) {
                $unit_info = Yii::app()->db->createCommand("select mailaddr,unit_name from unit where active_flag=1 and id=" . $unit_id)->queryRow();
                if (!empty($unit_info) && $unit_info['mailaddr']) {
                    $this->SendEmail($unit_info['mailaddr'], $unit_info['unit_name'], $four_week_before);
                }
            }
        }
    }

    private function createBaseNew() {
        $current_day = date("N");
        $days_from_monday = $current_day - 1;
        $this_week_monday = date("Y-m-d", strtotime("- {$days_from_monday} Days"));
        $four_week_before = date('Y-m-d', strtotime($this_week_monday . ' + 28 day'));
        if ($this->IsExist($four_week_before) == 0) {
//            $ran_base = $this->getRanBase();
            $ran_base=null;
            $index_max = $this->getBasenewsIndexMax();
            $basenews_index = $index_max;
            $unit_id_array = array();
            if ($index_max == '0') {
                $unit_id_array = $this->getAllUnitId();
                $basenews_index++;
            } else {
                $rows = Yii::app()->db->createCommand()
                        ->select("id")
                        ->from("unit")
                        ->where("basenews_index < " . $index_max)
                        ->andWhere("cancel_random = 0 or cancel_random is null")
                        ->queryAll();
                if (is_array($rows) && count($rows) > 0) {
                    foreach ($rows as $row) {
                        $unit_id_array[] = $row['id'];
                    }
                } else {
                    $unit_id_array = $this->getAllUnitId();
                    $basenews_index++;
                }
            }
            if (count($unit_id_array) > 0) {
                $key = array_rand($unit_id_array);
                $ran_base = $unit_id_array[$key];
            } 
            if($ran_base==NULL){
                return;
            }
            if ($this->SaveBaseNew($four_week_before, $ran_base,$basenews_index)) {
                $unit_info = Yii::app()->db->createCommand("select mailaddr,unit_name from unit where active_flag=1 and id=" . $ran_base)->queryRow();
                if (!empty($unit_info) && $unit_info['mailaddr']) {
                    $this->SendEmail($unit_info['mailaddr'], $unit_info['unit_name'], $four_week_before);
                }
            }
        }
    }

    public function run($args) {
        $today = new DateTime(date("Y-m-d"));
        $file_name = $this->getCSVFile($today);
        if (is_string($file_name) && trim($file_name) != "") {
            $employee_number_array = $this->getCSVFileData($file_name);
            if (is_array($employee_number_array) && count($employee_number_array) > 0) {
                if ($this->checkValidation($employee_number_array) == TRUE) {
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
                    if ($this->hasMainDivision($employee_number_array) == true) {
                        $this->createBaseNewViaCSVFile($employee_number_array, $start_date, $end_date);
                    }
                } else {
                    $this->createBaseNew();
                }
            } else {
                $this->createBaseNew();
            }
        } else {
            $this->createBaseNew();
        }
    }

}
