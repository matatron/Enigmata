<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Rsvp extends Controller_Json {

    private $currentYear=0;

    private $currentMonth=0;

    private $currentDay=0;

    private $today=0;

    private $daysInMonth=0;

    private $slotsPerDay = [];

    private $reservations = [];

    private $rsvLimit = 43200; //12 horas

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

    public function action_cancel() {
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

    public function action_checkcode() {
        $code = trim(strtolower($this->request->query('code')));
        $coupon = ORM::factory('Coupon')->where("code", "=", $code)->find();

        if ($coupon->loaded()) {
            if ($coupon->limitdate != null && time() > $coupon->limitdate) {
                $this->data = ["id"=> "0", "description"=>"El código ya venció"];
            } else if ($coupon->limituses==0) {
                $this->data = ["id"=> "0", "description"=>"El código ya agotó su número máximo de usos"];
            } else {
                $this->data = $coupon->as_array();
            }
        } else {
            $this->data = ["id"=> "0", "description"=>"El código no existe"];
        }
    }

    public function action_testdate() {
        $DateTime = "1527474600";
        $IntlDateFormatter = new IntlDateFormatter(
            'es_ES',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE
        );
        echo $IntlDateFormatter->format($DateTime);
        echo "-";
        $DateTime = 1527474600;
        $IntlDateFormatter = new IntlDateFormatter(
            'es_ES',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE
        );
        echo $IntlDateFormatter->format($DateTime);

        die();
    }
    public function action_submit() {
        $IntlDateFormatter = new IntlDateFormatter(
            'es_ES',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE
        );
        $data = json_decode($this->request->body(), true);
        $readable = [];


        $reserv = ORM::factory('Reservation', $data["id"]);
        if ($reserv->people != NULL) die();
        $reserv->values($data);
        $reserv->reservationdate = time();
        $reserv->date = intval($reserv->date);
        $reserv->ip = Request::$client_ip;
        $reserv->hasCoupon = $data["hasCoupon"]?1:0;
        $reserv->language = $data["language"]?'EN':null;
        $reserv->confirmed = 0;
        $reserv->prepaid = 0;
        $reserv->randomcode = substr(md5(microtime()),rand(0,26),10);


        /*        if (isset($data["coupon"]) && $data["coupon"] != "") {
            $reserv->couponraw = $data["coupon"];
            $code = ORM::factory("Coupon")->where("code", "=", strtolower($data["coupon"]))->find();
            if ($code->loaded() && isset($code->id)) {
                $reserv->coupon_id = $code->id;
            }
        }*/


        //        $readable["room"] = $data["room_humana"];
        //        $readable["date"] = $data["fecha_humana"];
        //        $readable["hour"] = $data["hora_humana"];

        $readable["room"] = $reserv->unicode[0];
        $readable["date"] = $IntlDateFormatter->format($reserv->date);
        $readable["hour"] = date("H:i", $reserv->date);


        try
        {
            $reserv->save();

            $message = array(
                'subject' => 'Su reservación en Enigmata Escape Room',
                'body'    =>  View::factory('rsvpemail')->bind('res', $reserv)->bind('readable',$readable),
                'from'    => array('no-reply@enigmata.co.cr' => 'Enigmata Escape Room'),
                'to'      => $reserv->email
            );

            if (true) {
                $code = Email::send('default', $message['subject'], $message['body'], $message['from'], $message['to'], 'text/html');

                if ($reserv->couponraw != "noemail") {

                    $saludos = [
                        "Hola Yuki bonita",
                        "Hola Yuki kawaii",
                        "Holiiii  UwU",
                        "Hola querida Yuki",
                        "Ne ne Yuki-Sempai",
                        "Oye tu",
                        "Estimada Srta Ana Reverté",
                        "Hello Ms Yuki",
                        "Whatzaaaaa Yuki",
                        "Yuki Chan!",
                        "Yukitolia",
                        "Hey Snuff Party",
                        "YUUUUKKIIIIIIII!!!!",
                        "Su majestad, Yuki III, reina de las Nagas y las Shivas",
                        "Mae"
                    ];

                    $noti1 = Email::send('default', "Nueva reservación", "Hola Mata.  Hay una <a href='http://www.enigmata.co.cr/admin/reservas/editar/".$reserv->id."'>nueva reservación</a> en el cuarto ".$readable["room"]." para ".$data["people"]." personas para el ".$readable["date"], $message['from'], "matatron@gmail.com", 'text/html');
                    $noti1 = Email::send('default', "Nueva reservación", $saludos[array_rand($saludos)].".  Hay una <a href='http://www.enigmata.co.cr/admin/reservas/editar/".$reserv->id."'>nueva reservación</a> en el cuarto ".$readable["room"]." para ".$data["people"]." personas para el ".$readable["date"], $message['from'], "snuffparty@gmail.com", 'text/html');

//                    $users = ORM::factory('user')->find_all();


/*                    foreach($users as $user) {
                        if ($user->sendemail == 1) {

                            $noti1 = Email::send('default', "Nueva reservación", "Hola ".ucfirst($user->username).".  Hay una <a href='http://www.enigmata.co.cr/admin/reservas/editar/".$reserv->id."'>nueva reservación</a> en el cuarto ".$readable["room"]." para ".$data["people"]." personas para el ".$readable["date"], $message['from'], $user->email, 'text/html');
                        }
                    }*/
                } else {
                    $reserv->couponraw = '';
                    $reserv->hasCoupon = 0;
                    $reserv->save();
                }
            }


            $log = ORM::factory("Log");
            $log->log("Reservación para ".$reserv->people." personas creada para el ".$readable["date"]." por ".$reserv->email, true);

            $this->data = $reserv->as_array();
        }
        catch(Database_Exception $e)
        {
            $this->data = ["id"=>0];
        }

    }

    public function action_delete() {
        $id = $this->request->post('id');
        $codigo = $this->request->post('codigo');

        if ($codigo == "Enigmata") {
            $reserv = ORM::factory('Reservation', $id);
            $reserv->comments .= "\r\nEste espacio anteriormente fue reservado por ".$reserv->email." para ".$reserv->people." personas pero fue borrado por ".Auth::instance()->get_user()->username;
            $reserv->reservationdate = 0;
            $reserv->people = null;
            //            $reserv->coupon_id = null;
            $reserv->couponraw = "";
            $reserv->hasCoupon = 0;
            $reserv->language = "";
            $reserv->name = null;
            $reserv->email = null;
            $reserv->phone = null;
            $reserv->confirmed = 0;
            $reserv->prepaid = 0;
            $reserv->redeemed = 0;
            $reserv->randomcode = null;
            $reserv->ip = null;
            $reserv->save();
            $log = ORM::factory("Log");
            $log->log(Auth::instance()->get_user()->username." borró la reservación ".$reserv->unicode);
            $this->data = ["result"=>true];
        }else{
            $this->data = ["result"=>false];
        }

    }

    public function action_resend() {
        $IntlDateFormatter = new IntlDateFormatter(
            'es_ES',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE
        );
        setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');

        $id = $this->request->param('id');
        $reserv = ORM::factory('Reservation', $id);

        $readable["room"] = $reserv->unicode[0];
        $readable["date"] = $IntlDateFormatter->format($reserv->date);
        //$readable["date"] = iconv('ISO-8859-2', 'UTF-8', strftime("%A, %d de %B de %Y", $reserv->date));
        $readable["hour"] = date("H:i", $reserv->date);

        $message = array(
            'subject' => 'Su reservación en Enigmata Escape Room',
            'body'    =>  View::factory('rsvpemail')->bind('res', $reserv)->bind('readable',$readable),
            'from'    => array('no-reply@enigmata.co.cr' => 'Enigmata Escape Room'),
            'to'      => $reserv->email
        );
        $code = Email::send('default', $message['subject'], $message['body'], $message['from'], $message['to'], 'text/html');

        $log = ORM::factory("Log");
        $log->log(Auth::instance()->get_user()->username." reenvió el correo de la reservación ".$reserv->unicode);

        $this->data = ["code"=>$code];
    }

    public function action_test() {
        $this->data = Email::send('default', "Prueba de correo", "Prueba de correo a Mata", array('no-reply@enigmata.co.cr' => 'Enigmata Escape Room'), "matatron@gmail.com", 'text/html');

    }


    public function action_day()
    {
        $cuarto = ORM::factory('Cuarto', $this->request->param('room'));
        $date = $this->request->param('date');
        $unicode = $cuarto.":".$date.":%";
        $reservations = ORM::factory('Reservation')->where('unicode', 'LIKE', $unicode)->and_where("date",">",time()+$this->rsvLimit)->find_all();
        $data = [];
        foreach($reservations as $res) {
            $hora = explode(":", $res->unicode)[2];
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

    public function action_alldays() {
        $reservations = ORM::factory('Reservation')->where('reservationdate', '=', 0)->and_where("date",">",time())->find_all();
        $days = [];
        foreach($reservations as $res) {
            $day = explode(":", $res->unicode)[1];
            if (!in_array($day, $days)) $days[] = $day;
        }
        $this->data = $days;

    }

    public function action_move() {
        $source = ORM::factory('Reservation', $this->request->post("sourceID"));
        $target = ORM::factory('Reservation', $this->request->post("targetID"));

        $target->comments = $source->comments;
        $target->reservationdate = $source->reservationdate;
        $target->people = $source->people;
        //        $target->coupon_id = $source->coupon_id;
        $target->hasCoupon = $source->hasCoupon;
        $target->couponraw = $source->couponraw;
        $target->redeemed = $source->redeemed;
        $target->name = $source->name;
        $target->email = $source->email;
        $target->phone = $source->phone;
        $target->confirmed = $source->confirmed;
        $target->prepaid = $source->prepaid;
        $target->randomcode = $source->randomcode;
        $target->ip = $source->ip;
        $target->save();

        $source->comments = null;
        $source->reservationdate = 0;
        $source->people = null;
        //        $source->coupon_id = null;
        $source->couponraw = "";
        $source->name = null;
        $source->email = null;
        $source->phone = null;
        $source->confirmed = 0;
        $source->prepaid = 0;
        $source->hasCoupon = 0;
        $source->redeemed = 0;
        $source->randomcode = null;
        $source->ip = null;
        $source->save();

        header('Location: /admin/reservas/index');

        die();
    }

    public function action_allhours() {
        $date = $this->request->param('id');
        $reservations = ORM::factory('Reservation')->where('unicode', 'LIKE', "%:".$date.":%")->and_where("reservationdate","=", 0)->find_all();
        $data = [];
        foreach($reservations as $res) {
            $data[] = $res->as_array();
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
        $unicode = $cuarto.":".$this->currentYear."-".$this->currentMonth."%";
        $reservations = ORM::factory('Reservation')->where('unicode', 'LIKE', $unicode)->and_where('people', 'IS', NULL)->and_where("date",">",time()+$this->rsvLimit)->find_all();

        $resdays=[];
        foreach($reservations as $res) {
            $parts = explode(":", $res->unicode);
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
            $unicode = "_:".date("Y-n-j", $day).":%";
            $reservations = ORM::factory('Reservation')->where('unicode', 'LIKE', $unicode)->count_all();
            $data[date("Y-n-j", $day)] = $reservations;

        }
        $this->data = $data;
    }

    public function action_fulldayinfo() {
        $id = $this->request->param('id');
        $unicode = "_:".$id.":%";

        $reservations = ORM::factory('Reservation')->where('unicode', 'LIKE', $unicode)->find_all();
        foreach($reservations as $res) {
            $parts = explode(":", $res->unicode);
            $rescodes[$parts[0].$parts[2]] = $res->as_array();
        }

        $dbdata = ORM::factory('Cuarto')->find_all();
        $slots = [];
        foreach($dbdata as $cuarto) {
            foreach(json_decode($cuarto->slots) as $time) {
                $slots[$cuarto->id][$time] = true;
            }
        }

        $data["slots"] = $slots;
        $data["reservations"] = $rescodes;

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
                    $reserv->unicode = $c->id.":".$dia.":".$slot;
                    $reserv->date = intval(strtotime($dia." ".$slot));
                    $reserv->save();
                    $count++;
                } catch(Exception $error) {

                }
            }
        }
        $this->data = $count;
    }
    public function action_cerrardia() {
        $unicode = "%:".$this->request->param("id").":%";
        $reservations = ORM::factory('Reservation')->where('unicode', 'LIKE', $unicode)->and_where("reservationdate", "=", 0)->find_all();
        $total = count($reservations);
        foreach($reservations as $res) {
            $res->delete();
        }
        $reservations = ORM::factory('Reservation')->where('unicode', 'LIKE', $unicode)->find_all();
        $this->data = count($reservations);
    }

    public function action_habilitar() {
        $unicode = $this->request->param("id");
        $parts = explode(":", $unicode);
        $reserv = ORM::factory('Reservation')->where('unicode', '=', $unicode)->find();
        if(!$reserv->loaded()) {
            $reserv = ORM::factory('Reservation');
            $reserv->unicode = $unicode;
            $reserv->date = strtotime($parts[1]." ".$parts[2]);
            $reserv->save();
            echo $reserv->id;
        }else{
            echo $reserv->id;
        }
        die();
    }

    public function action_inhabilitar() {
        $unicode = $this->request->param("id");
        $reserv = ORM::factory('Reservation')->where('unicode', '=', $unicode)->find();
        if($reserv->loaded()) {
            if ($reserv->reservationdate == 0) {
                $reserv->delete();
            }
        }
        die();
    }

    public function action_abrirsala() {
        $parts = explode(":",$this->request->param("id"));
        if (strtotime($parts[1]) ==  false) die();
        if ($parts[1][4] != "-") die();
        $cuarto = ORM::factory('Cuarto', $parts[0]);
        $slots = json_decode($cuarto->slots);
        $count = 0;
        foreach($slots as $slot) {
            try {
                $reserv = ORM::factory('Reservation');
                $reserv->unicode = $parts[0].":".$parts[1].":".$slot;
                $reserv->date = strtotime($parts[1]." ".$slot);
                $reserv->save();
                $count++;
            } catch(Exception $error) {

            }
        }
        $this->data = $count;
    }

    public function action_cerrarsala() {
        $unicode = $this->request->param("id").":%";
        $reservations = ORM::factory('Reservation')->where('unicode', 'LIKE', $unicode)->and_where("reservationdate", "=", 0)->find_all();
        foreach($reservations as $res) {
            $res->delete();
        }
    }

    public function action_stats() {
        $cuarto = ORM::factory('Cuarto', $this->request->param('id'));
        $this->data = json_decode($cuarto->records);
    }
}
