<?php $this->layout('templates/authentication', ['title' => 'Anmelden', 'type' => 'login']) ?>

<div class="login-box">

    <?php
    foreach ($messages as $message) {

        require TEMPLATE_DIR.'/parts/alert.php';

    } ?>

    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="/" class="h1"><?= \App\Software::TITLE ?></a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Melde dich an, um zu deinem Raumfahrtunternehmen zurückzukehren</p>

            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="E-Mail" name="emailLogin">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Passwort" name="passwordLogin">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="rememberLogin">
                            <label for="remember">
                                Angemeldet bleiben
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Anmelden</button>
                    </div>
                </div>
            </form>

            <!--<p class="mb-1">
                <a href="forgot-password.html">I forgot my password</a>
            </p>-->
            <p class="mb-0 text-center">
                <a href="/register" class="text-center">Registrieren</a>
            </p>
        </div>
    </div>
</div>