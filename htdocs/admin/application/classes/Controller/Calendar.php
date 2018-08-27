<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Calendar extends Controller {

    public function action_index() {

        // the iCal date format. Note the Z on the end indicates a UTC timestamp.
        $this->response->headers('Content-Type', 'text/calendar');
        $this->response->headers('Content-Disposition: attachment; filename="ical.ics"');
        define('DATE_ICAL', 'Ymd\THis');


        // max line length is 75 chars. New line is \\n

        $output = "BEGIN:VCALENDAR\r\n"
            . "VERSION:2.0\r\n"
            . "PRODID:-//Enigmata Escape Room//Reservaciones//ES\r\n"
            . "X-WR-CALNAME:Reservaciones\r\n"
            . "METHOD:PUBLISH\r\n"
            . "CALSCALE:GREGORIAN\r\n"
            . "BEGIN:VTIMEZONE\r\n"
            . "TZID:America/Guatemala\r\n"
            . "TZURL:http://tzurl.org/zoneinfo-outlook/America/Guatemala\r\n"
            . "X-LIC-LOCATION:America/Guatemala\r\n"
            . "BEGIN:STANDARD\r\n"
            . "TZOFFSETFROM:-0600\r\n"
            . "TZOFFSETTO:-0600\r\n"
            . "TZNAME:CST\r\n"
            . "DTSTART:19700101T000000\r\n"
            . "END:STANDARD\r\n"
            . "END:VTIMEZONE\r\n";

        $reservaciones = ORM::factory('Reservation')->where('date', ">" , time()-14400)->and_where('email', 'IS NOT', NULL)->order_by('date', 'ASC')->find_all();

        // loop over events
        foreach ($reservaciones as $reserva):
        $output .=
            "BEGIN:VEVENT\r\n"
            ."SUMMARY:".$reserva->name." (".$reserva->people.")\r\n"
            ."UID:".$reserva->unicode."\r\n"
            ."STATUS:" . strtoupper($reserva->confirmed?"CONFIRMED":"TENTATIVE") ."\r\n"
            ."DTSTAMP:" . date(DATE_ICAL, $reserva->date) ."\r\n"
            ."DTSTART;TZID=\"America/Guatemala\":" . date(DATE_ICAL, $reserva->date) ."\r\n"
            ."DTEND;TZID=\"America/Guatemala\":" . date(DATE_ICAL, $reserva->date+5400) ."\r\n"
            ."LAST-MODIFIED:" . date(DATE_ICAL, $reserva->reservationdate) ."\r\n"
            ."LOCATION: ".($reserva->unicode[0]==1?"Cronos":"Olivia") ."\r\n"
            ."URL:http%3A%2F%2Fenigmata.co.cr%2Fadmin%2Freservas%2Feditar%2F".$reserva->id."\r\n"
            ."END:VEVENT\r\n";
        endforeach;

        // close calendar
        $output .= "END:VCALENDAR";

        $this->response->body($output);
    }

}

