<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Reservas extends Controller_Website {

    public $auth_required = 'login';

    public function action_index()
    {
        setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');

        $reservaciones = ORM::factory('Reservation')->where('date', ">" , time()-14400)->and_where('email', 'IS NOT', NULL)->order_by('date', 'ASC')->find_all();

        $this->template->title = 'Reservaciones';
        $this->template->content = View::factory('reservas/index')->bind("reservaciones", $reservaciones);

    }

    public function action_archive()
    {
        setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');

        $reservaciones = ORM::factory('Reservation')->where('date', "<=" , time()-14400)->and_where('email', 'IS NOT', NULL)->order_by('date', 'DESC')->find_all();

        $this->template->title = 'Reservaciones anteriores';
        $this->template->content = View::factory('reservas/archive')->bind("reservaciones", $reservaciones);

    }


    public function action_editar()
    {
        $id = $this->request->param('id');

        $reservacion = ORM::factory('Reservation', $id);

        if (HTTP_Request::POST == $this->request->method())
        {
            $reservacion->values($this->request->post());
            $reservacion->save();

            if ($reservacion->changed('comments')) {
                $log = ORM::factory("Log");
                $log->log(Auth::instance()->get_user()->username." comentó en la reservación ".$reservacion->unicode);
            }
            if ($reservacion->changed('confirmed')) {
                $log = ORM::factory("Log");
                $log->log(Auth::instance()->get_user()->username." confirmó la reservación ".$reservacion->unicode);
            }
            header('Location: /admin/reservas/index');
            die();
        }
        $this->template->title = 'Reservacion '.$id;
        $this->template->content = View::factory('reservas/detalle')->bind("reservacion", $reservacion);

    }

} // End
