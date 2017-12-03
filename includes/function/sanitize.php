<?php
/**
 * Created by PhpStorm.
 * User: Narbe
 * Date: 01.12.2017
 * Time: 22:43
 */

    function escape($string){
        return htmlentities($string, ENT_QUOTES, 'UTF-8');
    }