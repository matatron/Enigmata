<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Records extends Controller_Website {

    public $auth_required = 'login';

    public function action_index()
    {
        $records = [];
        $template = [
            "2" => ["name"=>"", "time"=>""],
            "3" => ["name"=>"", "time"=>""],
            "4" => ["name"=>"", "time"=>""],
            "5" => ["name"=>"", "time"=>""],
            "6" => ["name"=>"", "time"=>""],
            "7" => ["name"=>"", "time"=>""],
            "8" => ["name"=>"", "time"=>""]
        ];

        if (HTTP_Request::POST == $this->request->method())
        {
            foreach($this->request->post("record") as $cuarto=>$data) {
                $dbcuarto = ORM::factory('Cuarto', $cuarto);
                $dbcuarto->records = json_encode($data);
                $dbcuarto->save();
            }
            HTTP::redirect('/records/index');
        } else {
            $cuartos = ORM::factory('Cuarto')->find_all();
            foreach($cuartos as $cuarto) {
                $records[$cuarto->id] = json_decode($cuarto->records, true);
                if (is_null($records[$cuarto->id])) $records[$cuarto->id] = $template;
            }
            $this->template->title = 'Records'; 
            $this->template->content = View::factory('records/index')->bind('records', $records);

        }

    }

} // End
