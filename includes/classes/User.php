<?php
/**
 * Created by PhpStorm.
 * User: Narbe
 * Date: 02.12.2017
 * Time: 19:59
 */

class User{

    private $_db,
            $_data,
            $_sessionName,
            $_cookieName,
            $_isLoggedIn;

    public function __construct($user = null){
        $this->_db = DataBase::getInstance();

        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');

        if(!$user){
            if(Session::exists($this->_sessionName)){
                $user = Session::get($this->_sessionName);

                if($this->find($user)){
                    $this->_isLoggedIn = true;
                } else {
                    //process logout
                }
            }
        } else {
            $this->find($user);
        }
    }

    public function update($fields = array(), $id = null){

        if(!$id && $this->isLoggedIn()){
            $id = $this->data()->user_id;
        }

        if(!$this->_db->update('users', $id, $fields)){
            throw new Exception('Pojawił się problem przy aktualizacji');
        }
    }

    public function create($fields = array()){
        if(!$this->_db->insert('users', $fields)){
            throw new Exception('Wystąpił nieoczekiwany problem podczas tworzenia Twojego konta.');
        }
    }

    public function find($user = null){
        if($user){
            $field = (is_numeric($user)) ? 'user_id' : 'username';//user_id from users table
            $data = $this->_db->get('users', array($field, '=', $user));

            if($data->count()){
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    public function login($username = null, $password = null, $remember = false){

        if(!$username && !$password && $this->exists()){
            //log user in
            Session::put($this->_sessionName, $this->data()->user_id);//user_id from users table
        } else {

            $user = $this->find($username);

            if ($user) {
                if ($this->data()->password === Hash::make($password, $this->data()->salt)) {
                    Session::put($this->_sessionName, $this->data()->user_id);//user_id from users table

                    if ($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->user_id));//second user_id from users table

                        if (!$hashCheck->count()) {
                            $this->_db->insert('users_session', array(
                                'user_id' => $this->data()->user_id,//second user_id from users table
                                'hash' => $hash
                            ));
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }

                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                    }
                    return true;
                }
            }
        }

        return false;
    }

//    public function hasPermission($key){
//        $role = $this->_db->get('roles', array('role_id', '=', $this->data()->role));
//
//        if($role->count()){
//            $permissions = json_decode($role->first()->permissions, true);
//
//            if($permissions[$key] == true){
//                return true;
//            }
//        }
//        return false;
//    }

    public function exists(){
        return(!empty($this->_data)) ? true : false;
    }

    public function logout(){

        $this->_db->delete('users_session', array('user_id', '=', $this->data()->id));
        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }

    public function data(){
        return $this->_data;
    }

    public function isLoggedIn(){
        return $this->_isLoggedIn;
    }
}