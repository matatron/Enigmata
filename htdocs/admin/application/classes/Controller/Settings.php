<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Settings extends Controller_Json {

    public function action_read()
    {
        $cuartos = ORM::factory('Cuarto')->find_all();
        $data = [];
        foreach($cuartos as $c) {
            $data["r".$c->id] = $c->as_array();
            $data["r".$c->id]["slots"] = json_decode($data["r".$c->id]["slots"]);
        }
        $this->data = $data;
    }
    public function action_write()
    {
        foreach($this->request->post() as $room => $data) {
            if (!isset($data["slots"])) $data["slots"] = [];
            $data["slots"] = json_encode($data["slots"]);
            $id = $room[1];
            $cuarto = ORM::factory('Cuarto', $id);
            $cuarto->values($data);
            $cuarto->save();
        }
        $this->data = $this->request->post();
    }

}
