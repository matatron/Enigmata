<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="fa fa-users"></i></span><h5>Usuarios</h5></div>
            <div class="widget-content nopadding">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Ultimo Login</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $user) { ?>
                        <tr>
                            <td><?=$user->id;?></td>
                            <td><?=$user->username;?></td>
                            <td><?=$user->email;?></td>
                            <td><?=date("d/M h:i", $user->last_login);?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="fa fa-user"></i></span><h5>Crear Usuario</h5></div>
            <div class="widget-content">
                <form method="post" action="/admin/usuario/crear">
                    <label class="control-label">Nombre de usuario: </label>
                    <input name="username" class="form-control"/>
                    <label class="control-label">Correo: </label>
                    <input name="email" class="form-control"/>
                    <label class="control-label">Contraseña: </label>
                    <input name="rawpassword" class="form-control"/>
                    <button type="submit" class="btn btn-danger">Crear</button>
                </form>
            </div>
        </div>
    </div>
</div>
