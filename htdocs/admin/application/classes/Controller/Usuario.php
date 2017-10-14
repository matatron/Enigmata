<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Usuario extends Controller_Website {

    public $auth_required = TRUE;

    public function action_index()
    {
        $this->template->title = 'Home';
        $this->template->content = View::factory('main/index');
    }


    public function action_crear() {
                $model = ORM::factory('user');
                $model->values(array(
                    'username' => 'mata',
                    'email' => 'gerencia@example.com',
                    'password' => 'mata',
                    'password_confirm' => 'mata',
                ));
                $model->save();
                // remember to add the login role AND the admin role
                // add a role; add() executes the query immediately
                $model->add('roles', ORM::factory('role')->where('name', '=', 'login')->find());

    }

} // End
