<?php
    require_once 'php_action/core.php';
//    display message
//    if(Session::exists('home')){
//        echo '<p>' . Session::flash('home') . '</p>';
//    }

    if(Input::exists()){
        if(Token::check(Input::get('token')));

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true
            ),
           'password' => array(
               'required' => true
           ),
        ));

        if($validation->passed()){
            //log user in
            $user = new User();

            $remember = (Input::get('remember') === 'on') ? true : false;
            $login = $user->login(Input::get('username'), Input::get('password'), $remember);

            if($login){
                Redirect::to('dashboard.php');
            } else {
                echo '<p>Coś poszło nie tak podczas logowania</p>';
            }
        } else {
            foreach ($validation->errors() as $error){
                echo $error, '<br>';
            }
        }
    }
?>
<head>
    <meta charset="utf-8">
    <title>Zarządzanie kontenerami</title>
    <!-- bootstrap  -->
    <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
    <!-- custom css -->
    <link rel="stylesheet" type="text/css" href="custom/css/custom.css">
    <script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
</head>

  <div class="container">
      <div class="row vertical">
          <div class="col-md-5 col-md-offset-4">
              <div class="panel panel-info">
                  <div class="panel-heading">
                      <h3 class="panel-title">Proszę się zalogować</h3>
                  </div>
                  <div class="panel-body">

                      <div class="messages"></div>

                      <form class="form-horizontal" action="" method="POST" id="loginForm">
                          <div class="form-group">
                              <label for="username" class="col-sm-3 control-label"> Użytkownik</label>
                              <div class="col-sm-9">
                                  <input type="text" class="form-control" id="username" name="username" placeholder="Użytkownik" autocomplete="off">
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="password" class="col-sm-3 control-label">Hasło </label>
                              <div class="col-sm-9">
                                  <input type="password" class="form-control" id="password" name="password" placeholder="Hasło">
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="col-sm-offset-2 col-sm-10">
                                  <div class="checkbox">
                                      <label for="remember">
                                          <input type="checkbox" name="remember" id="remember"> Pamiętaj mnie
                                      </label>
                                  </div>
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-9">
                                  <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                                  <button type="submit" class="btn btn-default"> <i class="glyphicon glyphicon-log-in"></i>  Logowanie</button>
                              </div>
                          </div>

                          <div class="form-group">
                              <div class="panel-heading">
                                <h3 class="panel-title">Nie posiadasz konta? Zarejestruj się </h3>
                              </div>
                              <div class="col-sm-offset-3 col-sm-9">
                                  <a href="registration.php" class="btn btn-default"> <i class="glyphicon glyphicon-log-in"></i>  Rejestracja</a>
                              </div>
                          </div>
                      </form>

                  </div>
              </div>
          </div><!-- col-md-5 -->
      </div><!-- /row -->
  </div><!-- /container -->

