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
                'name' => array(
                    'required'  => true,
                    'min'       => 2,
                    'max'       => 50
                )
            ));

            if($validation->passed()){
                //update

                try{
                    $user->update(array(
                       'name' => Input::get('name')
                    ));

                    Session::flash('home', 'Twoje dane zostały zaktualizowane');
                    Redirect::to('dashboard.php');

                } catch (Exception $e){
                    die($e->getMessage());
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
                    <div class="page-heading"> <i class="glyphicon glyphicon-wrench"></i> Ustawienia</div>
                </div> <!-- /panel-heading -->

                <div class="panel-body">



                    <form method="post" class="form-horizontal" id="changeUsernameForm">
                        <fieldset>
                            <legend>Zmień nazwę użytkownika</legend>

                            <div class="changeUsenrameMessages"></div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Użytkownik</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Użytkownik" value="<?php echo escape($user->data()->name); ?>"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
                                    <button type="submit" class="btn btn-success" data-loading-text="Ładuję..." id="changeUsernameBtn"> <i class="glyphicon glyphicon-ok-sign"></i> Zapisz zmiany </button>
                                </div>
                            </div>
                        </fieldset>
                    </form>

                </div> <!-- /panel-body -->

            </div> <!-- /panel -->
        </div> <!-- /col-md-12 -->
    </div> <!-- /row-->

<?php require_once 'includes/footer.php'; ?>