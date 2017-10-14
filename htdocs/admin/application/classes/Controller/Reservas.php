<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Reservas extends Controller_Website {

    public $auth_required = 'login';

    public function action_index()
    {

        $reservaciones = ORM::factory('Reservation')->where('date', ">" , time()-86400)->and_where('email', 'IS NOT', NULL)->order_by('date', 'ASC')->find_all();

        $this->template->title = 'Reservaciones';
        $this->template->content = View::factory('reservas/index')->bind("reservaciones", $reservaciones);

    }

    public function action_editar()
    {
        $id = $this->request->param('id');

        $reservacion = ORM::factory('Reservation', $id);
        $this->template->title = 'Reservacion '.$id;
        $this->template->content = View::factory('reservas/detalle')->bind("reservacion", $reservacion);

    }

} // End
