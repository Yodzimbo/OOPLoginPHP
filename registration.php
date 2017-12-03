<?php
/**
 * Created by PhpStorm.
 * User: Narbe
 * Date: 02.12.2017
 * Time: 12:56
 */
    require_once 'php_action/core.php';

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
        <div class="col-md-7 col-md-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Proszę się zarejestrować - żeby się zalogować musisz być zarejestrowany</h3>
                    <h3 class="alert-danger">
                        <?php
                        if(Input::exists()) {

                            if (Token::check(Input::get('token'))) {
                                $validate = new Validate;
                                $validation = $validate->check($_POST, array(
                                    'username' => array(
                                        'required' => true,
                                        'min' => 2,
                                        'max' => 20,
                                        'unique' => 'users'
                                    ),
                                    'name' => array(
                                        'required' => true,
                                        'min' => 6,
                                        'max' => 50
                                    ),
                                    'email' => array(),
                                    'password' => array(
                                        'required' => true,
                                    ),
                                    'passwordAgain' => array(
                                        'required' => true,
                                        'min' => 6,
                                        'matches' => 'password'
                                    ),
                                ));

                                if ($validation->passed()) {
                                    // register user
                                    $user = new User();

                                    $salt = Hash::salt(32);

                                    try{
                                        $user->create(array(
                                            'username'  => Input::get('username'),
                                            'password'  => Hash::make(Input::get('password'), $salt),
                                            'salt'      => $salt,
                                            'name'      => Input::get('name'),
                                            'joined'    => date('Y-m-d H:i:s'),
                                            'group'     => 1

                                        ));
//
                                        Session::flash('home', 'Zostałeś zarejestrowany, możesz się teraz zalogować.');
                                        header('Location: index.php');

                                    } catch(Exception $e){
                                        die($e->getMessage());
                                    }
                                } else {
                                    // output errors
                                    foreach ($validation->errors() as $error) {
                                        echo $error, '<br>';
                                    }
                                }
                            }
                        }
                        ?>

                    </h3>
                </div>
                <div class="panel-body">

                    <form class="form-horizontal" method="post">
                    <div>

                    </div>
                        <div class="form-group">
                            <label for="username" class="col-sm-3 control-label">Użytkownik</label>
                            <div class="col-sm-9">
                                <input type="text" value="<?php echo escape(Input::get('username')); ?>" class="form-control" name="username" id="username" placeholder="Użytkownik" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Imię i nazwisko</label>
                            <div class="col-sm-9">
                                <input type="text" value="<?php echo escape(Input::get('name')); ?>" class="form-control" name="name" id="name" placeholder="Imię i nazwisko" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-sm-3 control-label">Wprowadź hasło</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Wprowadź hasło" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="passwordAgain" class="col-sm-3 control-label">Powtórz hasło</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="passwordAgain" name="passwordAgain" placeholder="Powtórz hasło" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                                <button type="submit" class="btn btn-default">Rejestruj</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div><!-- col-md-5 -->
    </div><!-- /row -->
</div><!-- /container -->

<?php require_once 'includes/footer.php'; ?>