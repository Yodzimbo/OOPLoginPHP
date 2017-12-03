<?php
/**
 * Created by PhpStorm.
 * User: Narbe
 * Date: 28.11.2017
 * Time: 23:01
 */

class DbConnect
{
    public $connect;
    private $localhost = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'inventory';

    function __construct(){
        $this->database_connect();
    }

    public function database_connect(){
        $this->connect = mysqli_connect($this->localhost, $this->username, $this->password, $this->dbname);
    }

    public function execute_query($query){
        return mysqli_query($this->connect, $query);
    }

}

