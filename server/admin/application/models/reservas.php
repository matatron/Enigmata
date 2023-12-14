<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reservas extends CI_Model
{
    /**
     * Comanda constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function todas()
    {
        return $this->db->get_where("reservas")->result();
    }

    
    public function porId($id)
    {
        return $this->db->get_where("reservas", ["id"=>$id], 1)->result()[0];
    }

    public function porDia($dia)
    {
        $start = $dia*100000;
        $end = ($dia+1)*100000;
        return $this->db->get_where("reservas", "dayslot > $start AND dayslot < $end")->result();
    }

    public function futuras()
    {
        $Now = new DateTime('now', new DateTimeZone('America/Costa_Rica'));
        $code = $Now->format("Ymd")."10000";
        return $this->db->get_where("reservas", ["dayslot >" => $code])->result();
    }

    public function futurasResumen()
    {
        $data = [];
        $Now = new DateTime('now', new DateTimeZone('America/Costa_Rica'));
        $code = $Now->format("Ymd")."10000";
        $results = $this->db->get_where("reservas", ["dayslot >" => $code])->result();
        if ($results) {
            foreach($results as $result) {
                $data[$result->dayslot] = ["id"=>$result->id, "reservedAt"=>$result->reservedAt, "people"=>$result->people];
            }
        }
        return $data;
    }

    public function futurasCalendar()
    {
        $data = [];
        $Now = new DateTime('now', new DateTimeZone('America/Costa_Rica'));
        $code = $Now->format("Ymd")."10000";
        $results = $this->db->get_where("reservas", ["dayslot >" => $code])->result();
        if ($results) {
            foreach($results as $result) {
                $fecha = substr($result->dayslot, 0, 4)."-".substr($result->dayslot, 4,2)."-".substr($result->dayslot, 6,2);
                $hora = substr($result->dayslot, 9,2).":".substr($result->dayslot, 11,2);
                if ($result->reservedAt == null) {
                    $data[] = ["title"=>$hora, "start"=>$fecha, "color"=>"grey", "id"=>$result->id];
                }
            }
        }
        return $data;
    }

    public function abrirslot($code) {
        $this->db->insert('reservas', ['dayslot' => $code]);
    }

    public function borrarslot($code) {
        $this->db->delete('reservas', array('dayslot' => $code));
    }

}