<?php require_once 'php_action/core.php'; ?>


    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Zarządzanie kontenerami</title>
        <!-- bootstrap  -->
        <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
        <!-- bootstrap theme -->
        <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap-theme.min.css">
        <!-- font awesome -->
        <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.min.css">
        <!-- custom css -->
        <link rel="stylesheet" type="text/css" href="custom/css/custom.css">
        <!-- dataTables -->
        <link rel="stylesheet" type="text/css" href="assets/plugins/datatables/datatables.min.css">
        <!-- file input -->
        <link rel="stylesheet" type="text/css" href="assets/plugins/fileinput/css/fileinput.min.css">
        <!-- jquery -->
        <script type="text/javascript" src="assets/jquery/jquery.min.js"></script>
        <!-- jqueryui -->
        <link rel="stylesheet" type="text/css" href="assets/jquery-ui/jquery-ui.min.css">
        <script type="text/javascript" src="assets/jquery-ui/jquery-ui.min.js"></script>
        <!-- bootstrap js -->
        <script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
    </head>
<body>

<?php
$user = new User();
if($user->isLoggedIn()) {
    ?>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav navbar-right" id="navSetting">

                    <li id="navDashboard"><a href="dashboard.php"><i class="glyphicon glyphicon-dashboard"></i> Kokpit
                        </a></li>
                    <li id="navContainer"><a href="container.php"><i class="glyphicon glyphicon-ruble"></i> Kontenery
                        </a></li>
                    <li id="navClients"><a href="clients.php"><i class="glyphicon glyphicon-list-alt"></i> Klienci </a>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false"> <i class="glyphicon glyphicon-user"></i>
                            Witaj <?php echo escape($user->data()->username); ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">

                            <li id="topNavSettingUser"><a href="settingUser.php"> <i
                                            class="glyphicon glyphicon-wrench"></i> Ustawienia</a></li>
                            <li id="topNavSettingPass"><a href="settingPass.php"> <i
                                            class="glyphicon glyphicon-warning-sign"></i> Ustawienia - hasła</a></li>
                            <li id="topNavLogout"><a href="logout.php"> <i class="glyphicon glyphicon-log-out"></i>
                                    Wyloguj</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div class="container">
    <?php

} else {
    echo'<div class="container">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <div class="page-heading"> <i class="glyphicon glyphicon-warning-sign"></i> Uwaga</div>
                </div> <!-- /panel-heading -->
                <div class="panel-body">
                    <form method="post" action="index.php" class="form-horizontal" id="">
                        <fieldset>
                            <legend>Jeżeli chcesz zobaczyć co jest na tej stronie musisz się zalogować</legend>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-success" data-loading-text="Ładuję..." > <i class="glyphicon glyphicon-ok-sign"></i> Idź do strony logowania </button>
                                </div>
                            </div>
                        </fieldset>
                    </form>

                </div> <!-- /panel-body -->

            </div> <!-- /panel -->
       </div>';
}
?>