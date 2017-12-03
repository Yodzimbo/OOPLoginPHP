<?php
/**
 * Created by PhpStorm.
 * User: Narbe
 * Date: 02.12.2017
 * Time: 20:10
 */

class Hash{
    public static function make($string, $salt = ''){
        return hash('sha256', $string . $salt);
    }

    public static function salt($length){
        return mcrypt_create_iv($length);
    }

    public static function unique(){
        return self::make(uniqid());
    }
}