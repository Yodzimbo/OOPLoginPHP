<?php
    session_start();

   $GLOBALS['config'] = array(
       'mysql' => array(
           'localhost' => 'localhost',
           'username'  => 'root',
           'password'  => '',
           'dbname'    => 'inventory'
       ),
       'remember' => array(
           'cookie_name'   => 'hash',
           'cookie_expiry' => 86800
       ),
       'session'  => array(
           'session_name'  => 'user',
           'token_name'    => 'token'
       )
   );

   spl_autoload_register(function($class){
       require_once 'includes/classes/' . $class . '.php'; //require all classes
   });

   require_once 'includes/function/sanitize.php';

   if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))){
        $hash = Cookie::get(Config::get('remember/cookie_name'));
        $hashCheck = DataBase::getInstance()->get('users_session', array('hash', '=', $hash));

        if($hashCheck->count()){
            $user = new User($hashCheck->first()->user_id);// user_id from session_name

            $user->login();

        }
   }
