<?php
/**
 * Created by PhpStorm.
 * User: Narbe
 * Date: 01.12.2017
 * Time: 22:21
 */
    class Config{
        public static function get($path = null){
            if($path){
                $config = $GLOBALS['config'];
                $path = explode('/', $path);

                foreach ($path as $bit){
                   if(isset($config[$bit])){
                       $config = $config[$bit];
                   }
                }

                return $config;
            }

            return false;
        }
    }