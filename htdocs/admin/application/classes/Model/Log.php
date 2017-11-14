<?php defined('SYSPATH') or die('No direct script access.');

class Model_Log extends ORM
{

    protected $_belongs_to = array('user' => array());

    public function log($message, $isSystem = false) {
        $this->date = time();
        $this->text = $message;
        $this->user_id = ($isSystem) ? 0 : Auth::instance()->get_user()->id;
        $this->save();

    }
}
