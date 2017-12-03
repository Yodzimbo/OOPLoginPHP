<?php
/**
 * Created by PhpStorm.
 * User: Narbe
 * Date: 02.12.2017
 * Time: 21:19
 */

class Redirect{

     public static function to($location = null){
         if($location){
             if(is_numeric($location)){
                 switch ($location){
                     case 404:
                        header('HTTP/1.0 404 Not Found');
                        include '404.php';
                        exit();
                     break;
                 }
             }
             header('Location: ' . $location);
             exit();
         }
     }

}