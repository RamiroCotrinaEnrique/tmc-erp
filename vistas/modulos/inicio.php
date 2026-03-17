<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Inicio</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item active">Tablero</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title m-0">Tablero</h5>
                        </div>
                        <div class="card-body">

                            <?php
                              if($_SESSION["usu_perfil"] =="Administrador"){                          
                                include "inicio/cajas-superiores.php";
                                } else{
                                    echo '<section class="col-lg-12 connectedSortable">
                                    <div class="box box-success">                       
                                    <div class="box-header">                       
                                    <h1>Bienvenid@ ' .$_SESSION["usu_nombre"].'</h1>                       
                                    </div>                       
                                    </div> 
                                    </section>';
                                }
                            ?>

                        </div>
                    </div>

                </div>

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>


