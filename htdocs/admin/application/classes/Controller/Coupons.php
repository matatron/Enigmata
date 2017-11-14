<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Coupons extends Controller_Website {

    public $auth_required = 'login';

    public function action_index()
    {
        $coupons = ORM::factory('Coupon')->find_all();

        if (HTTP_Request::POST == $this->request->method())
        {
            $coupon = ORM::factory('Coupon');
            $coupon->date = time();
            $coupon->user_id = Auth::instance()->get_user()->id;
            $coupon->code = $this->request->post("code");
            $coupon->discount = $this->request->post("discount");
            $coupon->limitdate = strtotime($this->request->post("limitdate"));
            $coupon->limituses = intval($this->request->post("limituses"));
            if ($coupon->limituses == 0) $coupon->limituses = -1;
            $coupon->save();
            $log = ORM::factory("Log");
            $log->log(Auth::instance()->get_user()->username." creó el cupón ".$coupon->code);
            header('Location: /admin/coupons/index');
            die();
        }

        $this->template->title = 'Cupones';
        $this->template->content = View::factory('coupons/index')->bind('coupons', $coupons);

    }

} // End
