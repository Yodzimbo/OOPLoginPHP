<?php

    require_once 'includes/header.php';

    require_once 'php_action/core.php';


    if(Session::exists('home')){
        echo '<p>' . Session::flash('home') . '</p>';
    }


?>


<?php require_once 'includes/footer.php'; ?>
