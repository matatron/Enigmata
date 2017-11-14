<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main extends Controller_Website {

    public function action_index()
    {
        setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
        $error = false;

        if(Auth::instance()->logged_in()) {

            $user = Auth::instance()->get_user();


            DB::delete('reservations')->where('date', '<', time())->where('reservationdate','=',0)->execute();

            $reservaciones = ORM::factory('Reservation')->where('date', ">" , time()-5400)->and_where('email', 'IS NOT', NULL)->order_by('date', 'ASC')->limit(10)->find_all();
            $resTotal = ORM::factory('Reservation')->where('date', ">" , time()-5400)->and_where('email', 'IS NOT', NULL)->order_by('date', 'ASC')->count_all();
            $logs = ORM::factory('Log')->limit(5)->order_by('date', 'DESC')->find_all();


            $this->template->title = 'Inicio';
            $this->template->content = View::factory('main/index')->bind("reservaciones", $reservaciones)->bind("logs", $logs)->bind("resTotal", $resTotal);
        } else {
            if (HTTP_Request::POST == $this->request->method())
            {
                $username = $this->request->post('username');
                $password = $this->request->post('password');
                $remember = $this->request->post('remember');
                if (Auth::instance()->login($username, $password, (bool) $remember))
                {
                    HTTP::redirect('/');
                }
                else
                {
                    $error = "Usuario o contraseña incorrectos";
                }
            }

            $this->template->title = 'Login';
            $this->template->content = View::factory('main/login')->bind("error", $error);
        }
    }

    public function action_fulllog() {
        $logs = ORM::factory('Log')->order_by('date', 'DESC')->find_all();

        $this->template->title = 'Registro de actividad';
        $this->template->content = View::factory('main/logs')->bind('logs', $logs);
    }

    public function action_noaccess()
    {
        $this->template->title = 'Acceso no autorizado';
        $this->template->content = View::factory('main/noaccess');
    }

    public function action_logout()
    {
        Auth::instance()->logout(false, true);
        Session::instance()->destroy();
        HTTP::redirect('/');
    }

} // End
