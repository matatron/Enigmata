<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Website extends Controller_Template {

    public $template = 'site';

    public $auth_required = FALSE;
    public $secure_actions = FALSE;

    protected $session;

    /**
     * Called from before() when the user does not have the correct rights to access a controller/action.
     *
     * Override this in your own Controller / Controller_App if you need to handle
     * responses differently.
     *
     * For example:
     * - handle JSON requests by returning a HTTP error code and a JSON object
     * - redirect to a different failure page from one part of the application
     */
    public function access_required()
    {
        $this->request->redirect('main/noaccess');
    }

    /**
     * Called from before() when the user is not logged in but they should.
     *
     * Override this in your own Controller / Controller_App.
     */
    public function login_required()
    {
        Request::current()->redirect('/');
    }

    public function before()
    {

        try
        {
            $this->session = Session::instance();
        }
        catch (ErrorException $e)
        {
            session_destroy();
        }
        parent::before();
        $this->session = Session::instance();

        //if we're not logged in, but auth type is orm. gives us chance to auto login
        $supports_auto_login = new ReflectionClass(get_class(Auth::instance()));
        $supports_auto_login = $supports_auto_login->hasMethod('auto_login');
        if(!Auth::instance()->logged_in() && $supports_auto_login){
            Auth::instance()->auto_login();
        }

        // Check user auth and role
        $action_name = Request::current()->action();
        if
            (
                // auth is required AND user role given in auth_required is NOT logged in
                ( $this->auth_required !== FALSE && Auth::instance()->logged_in($this->auth_required) === FALSE ) ||
                // OR secure_actions is set AND the user role given in secure_actions is NOT logged in
                ( is_array($this->secure_actions) && array_key_exists($action_name, $this->secure_actions) && Auth::instance()->logged_in($this->secure_actions[$action_name]) === FALSE )
            )
        {
            if (Auth::instance()->logged_in())
            {
                // user is logged in but not on the secure_actions list
                $this->access_required();
            }
            else
            {
                $this->login_required();
            }
        }


        $this->template->controller = $this->request->controller();
        $this->template->action = $this->request->action();
        $this->template->title = '';
        $this->template->content = '';
        return;
    }

}
