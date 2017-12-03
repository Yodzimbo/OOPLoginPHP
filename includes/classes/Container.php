<?php
/**
 * Created by PhpStorm.
 * User: Narbe
 * Date: 03.12.2017
 * Time: 21:57
 */

class Container{

    private $_db;

    public function __construct($user = null){
        $this->_db = DataBase::getInstance();
    }

    public function create($fields = array()){
        if(!$this->_db->insert('containers', $fields)){
            throw new Exception('Wystąpił nieoczekiwany problem podczas dodawania kontenera.');
        }
    }

}