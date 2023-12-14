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
			"slots" => ["1400","1530","1700","1830","2000"],
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
	
	public function abrirdia($codes) {
		$codes = explode("-",$codes);
		foreach($codes as $code) {
			$this->reservas->abrirslot($code);
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
		$reservas = $this->reservas->porDia($dia);
		for($i=0; $i< count($reservas); $i++) {
			$inicio = substr($reservas[$i]->dayslot,-4,4);
			$final = strval(($inicio[2] == "3") ? intval($inicio)+170 : intval($inicio) + 130);
			$reservas[$i]->inicio = $inicio[0].$inicio[1].":".$inicio[2].$inicio[3];
			$reservas[$i]->final = $final[0].$final[1].":".$final[2].$final[3];
		}
		echo json_encode($reservas);
	}

	public function actualizarReserva() {
		var_dump($_POST);
		
	}
	
}
