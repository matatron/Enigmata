<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
    Kohana::DEVELOPMENT => array
    (
    'default' => array(
    'driver'     => 'smtp',
    'hostname'   => 'mail.enigmata.co.cr',
    'username'   => 'no-reply@enigmata.co.cr',
    'port'       => 465,
    'encryption' => 'ssl',
    'password'   => '2.718281'
)
),
    Kohana::PRODUCTION  => array
    (
    'default' => array(
    'driver'     => 'smtp',
    'hostname'   => 'mail.enigmata.co.cr',
    'username'   => 'no-reply@enigmata.co.cr',
    'port'       => 465,
    'encryption' => 'ssl',
    'password'   => '2.718281'
)
),
//    Kohana::DEVELOPMENT => array
//    (
//    'default' => array(
//    'driver'     => 'smtp',
//    'hostname'   => 'smtp.zoho.com',
//    'username'   => 'no-reply@enigmata.co.cr',
//    'port'       => 587,
//    'encryption' => 'tls',
//    'password'   => 'epoxy888'
//)
//),
//    Kohana::PRODUCTION  => array
//    (
//    'default' => array(
//    'driver'     => 'smtp',
//    'hostname'   => 'smtp.zoho.com',
//    'username'   => 'no-reply@enigmata.co.cr',
//    'port'       => 587,
//    'encryption' => 'tls',
//    'password'   => 'epoxy888'
//)
//),
);
