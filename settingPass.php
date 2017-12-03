<?php
require_once 'includes/header.php';

require_once 'php_action/core.php';

$user = new User();

if(!$user->isLoggedIn()){
    Redirect::to('index.php');
}

if(Input::exists()){
    if(Token::check(Input::get('token'))){

        $validate = new Validate();
        $validation = $validate->check($_POST, array(

            'password_current' => array(
                'required' => true
            ),
            'password_new' => array(
                'required' => true,
                'min' => 6
            ),
            'password_new_again' => array(
                'required' => true,
                'min' => 6,
                'matches' => 'password_new'
            )
        ));

        if($validation->passed()){
            //update

            if(Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password){
                echo " niezgodnie";
            } else {
                $salt = Hash::salt(32);
                $user->update(array(
                    'password'  => Hash::make(Input::get('password_new'), $salt),
                    'salt'      => $salt
                ));

                Session::flash('home', 'Twoje hasło zostało zaktualizowane');
                Redirect::to('dashboard.php');
            }

        } else {
            foreach ($validation->errors() as $error){
                echo $error, '<br>';
            }
        }
    }
}
?>



    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li><a href="dashboard.php">Home</a></li>
                <li class="active">Ustawienia</li>
            </ol>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="page-heading"> <i class="glyphicon glyphicon-wrench"></i> Ustawienia - zmiana hasła</div>
                </div> <!-- /panel-heading -->

                <div class="panel-body">

                    <form method="post" class="form-horizontal" id="changePasswordForm">
                        <fieldset>
                            <legend>Zmień hasło</legend>

                            <div class="changePasswordMessages"></div>

                            <div class="form-group">
                                <label for="password_current" class="col-sm-2 control-label">Aktualne hasło</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password_current" name="password_current" placeholder="Aktualne hasło">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password_new" class="col-sm-2 control-label">Nowe hasło</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password_new" name="password_new" placeholder="Nowe hasło">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password_new_again" class="col-sm-2 control-label">Potwierdź nowe hasło</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password_new_again" name="password_new_again" placeholder="Potwierdź nowe hasło">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
                                    <button type="submit" class="btn btn-primary"> <i class="glyphicon glyphicon-ok-sign"></i> Zapisz zmiany </button>

                                </div>
                            </div>


                        </fieldset>
                    </form>

                </div> <!-- /panel-body -->

            </div> <!-- /panel -->
        </div> <!-- /col-md-12 -->
    </div> <!-- /row-->

<?php require_once 'includes/footer.php'; ?>