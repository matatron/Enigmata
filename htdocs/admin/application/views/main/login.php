<div class="row">
    <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
<?php echo $error; ?>
        <form class="form-signin" method="post">
            <label for="inputEmail" class="sr-only">Usuario</label>
            <input type="text" id="username" class="form-control" placeholder="Usuario" name="username" required autofocus>
            <label for="inputPassword" class="sr-only">Contraseña</label>
            <input type="password" id="password" class="form-control" placeholder="Contraseña" name="password" required>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="remember-me" name="remember"> Mantener sesión abierta
                </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        </form>
    </div>
</div>