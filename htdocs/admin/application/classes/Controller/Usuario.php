<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Usuario extends Controller_Website {

    public $auth_required = 'admin';

    public function action_index()
    {

        $users = ORM::factory('user')->find_all();

        $this->template->title = 'Home';
        $this->template->content = View::factory('usuarios/index')->bind('users',$users);
    }


    public function action_crear() {
        if (HTTP_Request::POST == $this->request->method())
        {

                $model = ORM::factory('user');
                $model->values(array(
                    'username' => $this->request->post('username'),
                    'email' => $this->request->post('email'),
                    'password' => $this->request->post('rawpassword'),
                    'password_confirm' => $this->request->post('rawpassword'),
                ));
                $model->save();
                // remember to add the login role AND the admin role
                // add a role; add() executes the query immediately
                $model->add('roles', ORM::factory('role')->where('name', '=', 'login')->find());
        }
        header('Location: /admin/usuario/index');
        die();

    }

    public function action_sendemail()
    {
        $id = $this->request->param('id');
        $user = ORM::factory('user', $id);
        $user->sendemail = 1;
        $user->save();
        echo 1;
        die();
    }

    public function action_nosendemail()
    {
        $id = $this->request->param('id');
        $user = ORM::factory('user', $id);
        $user->sendemail = 0;
        $user->save();
        echo 0;
        die();
    }


} // End
