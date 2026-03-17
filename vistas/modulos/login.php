<div id="back"> </div>
<div class="login-box">
    <div class="login-logo">
        <img src="vistas/img/plantilla/logo-blanco-bloque.png" style="width: 50%;">
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Ingresar al sistema</p>

            <form method="post">
                <div class="input-group mb-3">
                    <input type="text" name="txtUsuario" class="form-control" placeholder="Usuario">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="txtContrasena" class="form-control" placeholder="Contraseña">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4"> </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                    </div>
                    <!-- /.col -->
                    <div class="col-4"> </div>   
                </div>
                
            <?php
                $login = new ControladorUsuarios();
                $login -> ctrIngresoUsuario(); 
            ?>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->