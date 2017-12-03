<?php
/**
 * Created by PhpStorm.
 * User: Narbe
 * Date: 01.12.2017
 * Time: 22:21
 */
    class Cookie{
        public static function exists($name){
            return (isset($_COOKIE[$name])) ? true : false;
        }

        public static function get($name){
            return $_COOKIE[$name];
        }

        public static function put($name, $value, $expiry){
            if(setcookie($name, $value, time() + $expiry, '/')){

                return true;
            }

            return false;
        }

        public static function delete($name){
            //delete
            self::put($name, '', time() - 1);
        }
    }