<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Rsvp extends Controller_Json {

    private $currentYear=0;

    private $currentMonth=0;

    private $currentDay=0;

    private $today=0;

    private $daysInMonth=0;

    private $slotsPerDay = [];

    private $reservations = [];

    public function action_confirm() {
        $id = $this->request->param('id');
        $code = $this->request->query('code');

        $reserv = ORM::factory('Reservation', $id);
        if ($code == $reserv->randomcode) {
            $reserv->confirmed = 1;
            $reserv->save();

            header('Location: /#!/right');

        } else header('Location: /#!/wrong');

        die();
    }

    public function action_submit() {
        $data = json_decode($this->request->body(), true);


        $reserv = ORM::factory('Reservation', $data["id"]);
        if ($reserv->people != NULL) die();
        $reserv->values($data);
        $reserv->reservationdate = time();
        $reserv->ip = Request::$client_ip;
        $reserv->confirmed = 0;
        $reserv->prepaid = 0;
        $reserv->randomcode = substr(md5(microtime()),rand(0,26),10);

        /*
        if (isset($data["coupon"]) && $data["coupon"] != "") {
            $code = ORM::factory("Coupon")->where("code", "=", strtolower($data["coupon"]))->find();
            if ($code->loaded() && isset($code->id)) {
                $reserv->coupon_id = $code->id;
            }
        }
        */

        $readable["room"] = $data["room_humana"];
        $readable["date"] = $data["fecha_humana"];
        $readable["hour"] = $data["hora_humana"];

        try
        {
            $reserv->save();

            $message = array(
                'subject' => 'Su reservación en Enigmata Escape Room',
                'body'    =>  View::factory('rsvpemail')->bind('res', $reserv)->bind('readable',$readable),
                'from'    => array('no-reply@enigmata.co.cr' => 'Enigmata Escape Room'),
                'to'      => $reserv->email
            );

            $code = Email::send('default', $message['subject'], $message['body'], $message['from'], $message['to'], 'text/html');

            $noti1 = Email::send('default', "Nueva reservación", "Hola Yuki.  Hay una nueva reservación para el ".$data["fecha_humana"], $message['from'], "snuffparty@gmail.com", 'text/html');
            $noti1 = Email::send('default', "Nueva reservación", "Hola Mata.  Hay una nueva reservación para el ".$data["fecha_humana"], $message['from'], "matatron@gmail.com", 'text/html');


            $log = ORM::factory("Log");
            $log->date = time();
            $log->text = "Reservación para ".$reserv->people." personas creada para el ".$readable["date"]." por ".$reserv->email;
            $log->user = 0;
            $log->save();

            $this->data = $reserv->as_array();
        }
        catch(Database_Exception $e)
        {
            $this->data = ["id"=>0];
        }

    }


    public function action_test() {
        $this->data = Email::send('default', "Prueba de correo", "Prueba de correo a Mata", array('no-reply@enigmata.co.cr' => 'Enigmata Escape Room'), "matatron@gmail.com", 'text/html');

    }


    public function action_day()
    {
        $cuarto = ORM::factory('Cuarto', $this->request->param('room'));
        $date = $this->request->param('date');
        $unicode = $cuarto."_".$date."%";
        $reservations = ORM::factory('Reservation')->where('unicode', 'LIKE', $unicode)->and_where("date",">",time()+3600)->find_all();
        $data = [];
        foreach($reservations as $res) {
            $hora = explode("_", $res->unicode)[2];
            $horaHumana = substr($hora, 0, -2).":".substr($hora, -2, 2);
            $data[] = [
                "id" => $res->id,
                "order" => intval($hora),
                "available" => $cuarto->maximum - $res->people,
                "start"=> $horaHumana,
                "people"=> $cuarto->maximum - $res->people,
                "owner" => $this->_maskEmail($res->email)
            ];
        }

        $this->data = $data;

    }

    public function action_month()
    {
        $this->currentYear = intval($this->request->param('year'));
        $this->currentMonth = intval($this->request->param('month'));
        $cuarto = ORM::factory('Cuarto', $this->request->param('room'));

        $this->yesterday = time() - 60 * 60 * 24;

        //obtenemos info de cuantos ya estan ocupados
        $unicode = $cuarto."_".$this->currentYear."-".$this->currentMonth."%";
        $reservations = ORM::factory('Reservation')->where('unicode', 'LIKE', $unicode)->and_where('people', 'IS', NULL)->and_where("date",">",time()+3600)->find_all();

        $resdays=[];
        foreach($reservations as $res) {
            $parts = explode("_", $res->unicode);
            if (isset($resdays[$parts[1]])) {
                $resdays[$parts[1]]++;
            } else {
                $resdays[$parts[1]] = 1;
            }
        }
        $this->reservations = $resdays;

        $array = array();

        $this->daysInMonth = $this->_daysInMonth($this->currentMonth,$this->currentYear);
        $weeksInMonth = $this->_weeksInMonth($this->currentMonth,$this->currentYear);
        // Create weeks in a month
        for( $i=0; $i<$weeksInMonth; $i++ ){
            $week = array();
            //Create days in a week
            for($j=1;$j<=7;$j++){
                $week[] = $this->_showDay($i*7+$j);
            }
            $array[] = $week;
        }

        $this->data = $array;
    }

    private function _showDay($cellNumber){

        $valid = false;
        $slotsAvailable = 0;
        if($this->currentDay==0){
            $firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));
            if(intval($cellNumber) == intval($firstDayOfTheWeek)){
                $this->currentDay=1;
            }
        }
        if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ){
            $currentDate = strtotime($this->currentYear.'-'.$this->currentMonth.'-'.$this->currentDay);
            $valid = $currentDate >= $this->yesterday;
            $cellContent = $this->currentDay;
            if (isset($this->reservations[$this->currentYear.'-'.$this->currentMonth.'-'.$this->currentDay])) {
                $slotsAvailable = $this->reservations[$this->currentYear.'-'.$this->currentMonth.'-'.$this->currentDay];
            }
            $this->currentDay++;
        }else{
            $cellContent=null;
        }

        if ($slotsAvailable==0) $valid = false;

        return array("date" => $cellContent, "slots"=> $slotsAvailable, "valid" => $valid, "fullDate"=> $this->currentYear.'-'.$this->currentMonth.'-'.$cellContent);
    }

    /**
    * calculate number of weeks in a particular month
    */
    private function _weeksInMonth($month=null,$year=null){

        if( null==($year) ) {
            $year =  date("Y",time());
        }

        if(null==($month)) {
            $month = date("m",time());
        }

        // find number of days in this month
        $daysInMonths = $this->_daysInMonth($month,$year);
        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
        $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
        $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));
        if($monthEndingDay<$monthStartDay){
            $numOfweeks++;
        }
        return $numOfweeks;
    }

    /**
    * calculate number of days in a particular month
    */
    private function _daysInMonth($month=null,$year=null){

        if(null==($year))
            $year =  date("Y",time());

        if(null==($month))
            $month = date("m",time());

        return date('t',strtotime($year.'-'.$month.'-01'));
    }

    private function _maskEmail($email){
        $parts = explode("@", $email);
        for($i=1; $i<strlen($parts[0])-1; $i++) {
            $parts[0][$i] = "*";
        }
        return join("@", $parts);
    }

    public function action_futureinfo() {
        $firstday = strtotime($this->request->param("id"));
        $data = [];
        for($i=0; $i<84; $i++) {
            $day = $firstday + $i*86400;
            $unicode = "1_".date("Y-n-j", $day)."_%";
            $reservations = ORM::factory('Reservation')->where('unicode', 'LIKE', $unicode)->count_all();
            $unicode = "2_".date("Y-n-j", $day)."_%";
            $reservations += ORM::factory('Reservation')->where('unicode', 'LIKE', $unicode)->count_all();
            $data[date("Y-m-d", $day)] = $reservations;

        }
        $this->data = $data;
    }

    public function action_abrirdia() {
        $dia = $this->request->param("id");
        if (strtotime($dia) ==  false) die();
        if ($dia[4] != "-") die();
        $cuartos = ORM::factory('Cuarto')->find_all();
        $count = 0;
        foreach($cuartos as $c) {
            $slots = json_decode($c->slots);
            if ($c->enabled) foreach($slots as $slot) {
                try {
                    $reserv = ORM::factory('Reservation');
                    $reserv->unicode = $c->id."_".$dia."_".$slot;
                    $reserv->date = strtotime($dia." ".$slot);
                    $reserv->save();
                    $count++;
                } catch(Exception $error) {

                }
            }
        }
        $this->data = $count;
    }
}
