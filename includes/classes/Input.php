<?php
/**
 * Created by PhpStorm.
 * User: Narbe
 * Date: 02.12.2017
 * Time: 13:29
 */

    class Input{
        public static function exists($type = 'post'){
            switch($type){
                case 'post':
                    return(!empty($_POST)) ? true : false;
                break;

                case 'get':
                    return(!empty($_GET)) ? true : false;
                break;

                default:
                    return false;
                break;
            }
        }

        public static function get($item){
            if(isset($_POST[$item])){
                return $_POST[$item];
            } else if(isset($_GET[$item])){
                return $_GET[$item];
            }
            return ''; // /remeber, this return string must be empty!!
        }
    }