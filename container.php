<?php require_once 'php_action/db_connect.php' ?>
<?php require_once 'includes/header.php'; ?>

<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="dashboard.php">Home</a></li>
            <li class="active">Kontenery</li>
        </ol>
        <div class="panel panel-default">
            <div class="panel-heading"><i class="glyphicon glyphicon-edit"></i> Zarządzanie kontenerami</div>
            <div class="panel-body">
                <div class="remove-messages"></div>

                <div class="div-action pull pull-right" style="padding-bottom:20px;">
                    <button class="btn btn-default" data-toggle="modal" data-target="#addContainerModal" id="addContainerModalBtn"><i class="glyphicon glyphicon-plus-sign"></i> Dodaj kontener</button>
                </div>

                <table class="table" id="manageContainerTable">
                    <thead>
                    <tr>
                        <th style="width:15%">Opcje</th>
                        <th>Prefix</th>
                        <th>Nr kontenera</th>
                        <th>Cena</th>
                        <th>Ilość</th>
                        <th>Rozmiar</th>
                        <th>Kategoria</th>
                        <th>Status</th>
                    </tr>
                    
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div><!--/row-->
    <?php
        if(Input::exists()) {
            // add container
            $container = new Container();
            try{
                $container->create(array(
                    'container_pref'        => Input::get('containerPref'),
                    'container_nr'          => Input::get('containerNr'),
                    'container_quantity'    => Input::get('containerQuantity'),
                    'container_rate'        => Input::get('containerRate'),
                    'container_category'    => Input::get('categoryName'),
                    'status'                => Input::get('containerStatus'),
                ));

            } catch(Exception $e){
                die($e->getMessage());
            }
        }
    ?>
<div class="modal fade" tabindex="-1" role="dialog" id="addContainerModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-plus"> </i> Dodaj kontener</h4>
            </div>
            <form class="form-horizontal" id="submitContainerForm" method="post" enctype="multipart/form-data">
                <div class="modal-body" style="max-height:450px;overflow: auto;">

                    <div id="add-container-messages"></div>

                    <div class="form-group"><!-- start from-group -->
                        <label for="containerPref" class="col-sm-3 control-label">Prefix: </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="containerPref" name="containerPref" placeholder="Prefix">
                        </div>
                    </div><!--/form-group-->
                    <div class="form-group"><!-- start from-group -->
                        <label for="containerNr" class="col-sm-3 control-label">Numer: </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="containerNr" name="containerNr" placeholder="Numer">
                        </div>
                    </div><!--/form-group-->

                    <div class="form-group"><!-- start from-group -->
                        <label for="containerQuantity" class="col-sm-3 control-label">Ilość: </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="containerQuantity" name="containerQuantity" placeholder="Ilość">
                        </div>
                    </div><!--/form-group-->

                    <div class="form-group"><!-- start from-group -->
                        <label for="containerRate" class="col-sm-3 control-label">Cena: </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="containerRate" name="containerRate" placeholder="Cena">
                        </div>
                    </div><!--/form-group-->

                    <div class="form-group"><!-- start from-group -->
                        <label for="categoryName" class="col-sm-3 control-label">Kategoria: </label>
                        <div class="col-sm-9">
                            <select class="form-control" id="categoryName" name="categoryName">
                                <option value="">~~WYBIERZ~~</option>
                                <option value="DC">DC</option>
                                <option value="DD">DD</option>
                                <option value="HC">HC</option>
                                <option value="HCRF">HCRF</option>
                                <option value="PW">PW</option>
                            </select>
                        </div>
                    </div><!--/form-group-->

                    <div class="form-group"><!-- start from-group -->
                        <label for="containerStatus" class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="containerStatus" name="containerStatus">
                                <option value="">~~SELECT~~</option>
                                <option value="1">Dostępny</option>
                                <option value="2">Sprzedany</option>
                                <option value="3">Wynajęty</option>
                                <option value="4">Uszkodzony</option>
                            </select>
                        </div>
                    </div><!--/form-group-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                    <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="editContainerModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-edit"></i> Edytuj kontener </h4>
            </div>
            <div class="modal-body" style="height:450px;overflow:auto; ">
                <!--        <div class="div-loading">
                            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                            <span class="sr-only">Loading...</span>
                    </div>-->
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#photo" aria-controls="home" role="tab" data-toggle="tab">Zdjęcie</a></li>
                    <li role="presentation"><a href="#containerInfo" aria-controls="profile" role="tab" data-toggle="tab">Kontener Info</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="photo">

                        <form class="form-horizontal" action="php_action/editContainerImage.php" method="POST" id="updateContainerImageForm" enctype="multipart/form-data">
                            <br />

                            <div class="edit-containerImage-message"></div>

                            <div class="form-group">
                                <label for="getContainerImage" class="col-sm-4 control-label">Zdjęcie kontenera :</label>
                                <div class="col-sm-8">
                                    <img src="" id="getContainerImage" class="thumbnail" style="width: 250px; height: 250px;">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="editContainerImage" class="col-sm-4 control-label">Zdjęcie kontenera :</label>
                                <div class="col-sm-8">
                                    <div id="kv-avatar-errors-1" class="center-block" style="display:none"></div>

                                    <div class="kv-avatar center-block">
                                        <input id="editContainerImage" name="editContainerImage" type="file" class="file-loading" style="width:auto;">
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer editContainerImageFooter">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                                <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
                            </div>
                        </form>
                    </div>
                    <!--/photo-->
                    <div role="tabpanel" class="tab-pane" id="containerInfo">
                        <br />

                        <div class="edit-container-message"></div>

                        <form class="form-horizontal" id="editContainerForm" action="php_action/editContainer.php" method="POST">
                            <div class="form-group"><!--Prefix-->
                                <label for="editContainerPref" class="col-sm-3 control-label">Prefix : </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="editContainerPref" name="editContainerPref" placeholder="Prefix">
                                </div>
                            </div><!--/prefix-->

                            <div class="form-group"><!--containerNr-->
                                <label for="editContainerNr" class="col-sm-3 control-label">Nr kontenera : </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="editContainerNr" name="editContainerNr" placeholder="Nr kontenera">
                                </div>
                            </div><!--/containerNr-->

                            <div class="form-group"><!--quantity-->
                                <label for="editQuantity" class="col-sm-3 control-label">Ilość : </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="editQuantity" name="editQuantity" placeholder="Ilość">
                                </div>
                            </div><!--/quantity-->

                            <div class="form-group"><!--quantity-->
                                <label for="editRate" class="col-sm-3 control-label">Cena : </label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="editRate" name="editRate" placeholder="Cena">
                                </div>
                            </div><!--/quantity-->

                            <div class="form-group"><!--specification-->
                                <label for="editSpecificSize" class="col-sm-3 control-label">Rozmiar : </label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="editSpecificSize" name="editSpecificSize">
                                        <option value="">~~SELECT~~</option>
                                        <?php
                                        $sql = "SELECT specification_id, specification_name FROM specifications WHERE specification_status = 1 AND specification_active = 1";
                                        $result = $connect->query($sql);
                                        while ($row = $result->fetch_array()){
                                            echo "<option value='".$row[0]."'>".$row[1]."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!--/specification-->

                            <div class="form-group"><!--categories-->
                                <label for="editCategoryName" class="col-sm-3 control-label">Kategoria : </label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="editCategoryName" name="editCategoryName">
                                        <option value="">~~SELECT~~</option>
                                        <?php
                                        $sql = "SELECT categories_id, categories_name FROM category WHERE categories_status = 1 AND categories_active = 1";
                                        $result = $connect->query($sql);
                                        while ($row = $result->fetch_array()){
                                            echo "<option value='".$row[0]."'>".$row[1]."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div><!--/categories-->

                            <div class="form-group"><!--categories-->
                                <label for="editContainerStatus" class="col-sm-3 control-label">Status : </label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="editContainerStatus" name="editContainerStatus">
                                        <option value="">~~WYBIERZ~~</option>
                                        <option value="1">Dostępny</option>
                                        <option value="2">Sprzedany</option>
                                        <option value="3">Wynajęty</option>
                                        <option value="4">Uszkodzony</option>
                                    </select>
                                </div>
                            </div><!--/categories-->

                            <div class="modal-footer editContainerFooter">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                                <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
                            </div>

                        </form>
                    </div>
                    <!--container info-->
                </div>

            </div>
            <div class="modal-footer">

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="removeContainerModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-trash"> </i>Usuń kontener</h4>
            </div>
            <div class="modal-body">
                <p>Czy jesteś pewien, że chcesz usunąć?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                <button type="button" class="btn btn-primary" id="removeContainerBtn">Zapisz zmiany</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="custom/js/container.js"></script>

<?php require_once 'includes/footer.php'; ?>
