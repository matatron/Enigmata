<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Schedule extends Controller_Website {

    public $auth_required = 'login';

    public function action_index()
    {
        $data["today"] = time();
        $data["weekstart"] = time() - (date('w') - 1)*86400;

        $data["weekNumber"] = date('W');

        $this->template->title = 'Cronograma';
        $this->template->content = View::factory('schedule/schedule')->bind('data', $data);

    }
    public function action_slots()
    {
        $dbdata = ORM::factory('Cuarto')->find_all();
        $cuartos = [];
        foreach($dbdata as $cuarto) {
            $cuartos[$cuarto->id] = $cuarto->as_array();
        }


        $this->template->title = 'Horarios';
        $this->template->content = View::factory('schedule/slots')->bind('cuartos', $cuartos);
    }
    public function action_edit() {
        $id = $this->request->param('id');
        $unicode = "_:".$id.":%";

        $this->template->title = 'Horario del '.$id;
        $this->template->content = View::factory('schedule/edit')->bind('id', $id);

    }

} // End
