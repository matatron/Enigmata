<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendario extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */


	public function __construct()
	{
		header("Access-Control-Allow-Origin: *");
		parent::__construct();
		$this->load->database();
		$this->load->model('reservas');
	}

	public function index()
	{
		setlocale(LC_TIME,"es_ES");
        $data = array(
			"slots" => ["1330", "1500","1630","1800","1930"],
			"activeslots" => ["1500","1630","1800","1930"],
			"reservas" => $this->reservas->futurasResumen()
		);
        $this->template->set('title', 'Slots');
        $this->template->load('default_layout', 'content' , 'reservas/slots', $data);
	}

	public function abrirslot($code) {
		$this->reservas->abrirslot($code);
		redirect('/calendario/index/');
	}

	public function borrarslot($code) {
		$this->reservas->borrarslot($code);
		redirect('/calendario/index/');
	}

	public function resetslot($id) {
		$this->reservas->resetear($id);
		redirect('/calendario/index/');
	}

	public function abrirdia($codes) {
		$codes = explode("-",$codes);
		foreach($codes as $code) {
			$this->reservas->abrirslot($code);
		}
		redirect('/calendario/index/');
	}
	public function cerrardia($codes) {
		$codes = explode("-",$codes);
		foreach($codes as $code) {
			$this->reservas->borrarslot($code);
		}
		redirect('/calendario/index/');
	}

	public function verreserva($id) {
		$reserva = $this->reservas->porId($id);
        $data = array(
			"reserva" => $reserva
		);
        $this->template->set('title', 'Reserva '.$reserva->dayslot);
        $this->template->load('default_layout', 'content' , 'reservas/ver', $data);
	}

	public function json() {
		echo json_encode($this->reservas->futurasCalendar());
	}
	public function reservasdia($dia)  {
		$data = ["message"=>"", "slots"=>[]];
	    if (intval($dia)<intval(date("Ymd"))) {
	        echo json_encode($data);
	        return;
	    }
	    if (intval($dia)==intval(date("Ymd"))) {
			$data["message"] = "Para reservas de última hora consultar disponibilidad al 88420134.";
	        echo json_encode($data);
	        return;
	    }
		$reservas = $this->reservas->porDia($dia);
		for($i=0; $i< count($reservas); $i++) {
			$inicio = substr($reservas[$i]->dayslot,-4,4);
			$final = strval(($inicio[2] == "3") ? intval($inicio)+170 : intval($inicio) + 130);
			$reservas[$i]->inicio = $inicio[0].$inicio[1].":".$inicio[2].$inicio[3];
			$reservas[$i]->final = $final[0].$final[1].":".$final[2].$final[3];
			$reservas[$i]->people = max(intval($reservas[$i]->people),2);
		}
		$data["slots"] = $reservas;
		echo json_encode($data);
	}

	public function actualizarReserva() {
		header('Content-Type: application/json');
		$this->load->library('email');
		$data = json_decode(file_get_contents("php://input"));
		if(isset($data->inicio)) unset($data->inicio);
		if(isset($data->final)) unset($data->final);
		if(!$data->reservedAt) {
			$this->reservas->actualizar($data);
			$this->ics($data);
			if(isset($data->email)) {
				$this->clientConfirm($data);
			}
			$this->serverConfirm($data);
			
			echo json_encode(
				array(
					'status'=>"success",
					'message'=>"Su reservación ha sido confirmada. No olvide avisar en caso de cancelación de la misma. ¡Muchas gracias!"
				)
			);
	
		}
	}

	public function guardarReserva() {
		
	}

	private function clientConfirm($data) {
		$name = $data->name." [".$data->phone."]";

		$this->email->from('no-reply@enigmata.co.cr', 'Enigmata Escape Room');
		$this->email->to($data->email);
		
		$this->email->subject('Confirmación de Reserva en Enigmata Escape Room');
		$this->email->message('Saludos '.$name.'! Este correo es para confirmar la reservación en Enigmata Escape Room.  Puede ver los detalles de la misma en la siguiente dirección: <a href="https://enigmata.co.cr/reserva.html?id='.$data->id.'">Reserva</a>');
		$this->email->attach('escaperoom.ics');
		$this->email->send();
	}

	private function serverConfirm($data) {
		$this->email->from('no-reply@enigmata.co.cr', 'Enigmata Escape Room');
		$this->email->to("matatron@gmail.com");
		
		$this->email->subject('Nueva reserva: '.$data->people."p en ".$data->dayslot);
		$this->email->message('Hay una nueva reservación.  <a href="https://enigmata.co.cr/admin/calendario/verreserva/'.$data->id.'">Ver Reserva</a>');
		$this->email->attach('escaperoom.ics');
		$this->email->send();
	}

	private function ics($reserva) {
		$fecha = substr($reserva->dayslot,0,8);
		$inicio = substr($reserva->dayslot,-4,4);
		$final = strval(($inicio[2] == "3") ? intval($inicio)+170 : intval($inicio) + 130);
        $data = array(
			"inicio" => $inicio,
			"final" => $final,
			"fecha" => $fecha,
			"name" => $reserva->name,
			"people" => $reserva->people,
			"id" => $reserva->id
		);
        $ics = $this->load->view('reservas/ics', $data, TRUE);
		if($fp = fopen('escaperoom.ics', 'w')) {
			fwrite($fp, $ics);
			fclose($fp);
		}
	}
	
}
