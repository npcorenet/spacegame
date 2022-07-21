<?php $this->layout('templates/authentication', ['title' => 'Registrieren', 'type' => 'register']) ?>

<div class="register-box">

    <?php
    foreach ($messages as $message) {

        require TEMPLATE_DIR.'/parts/alert.php';

    } ?>

    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="/" class="h1"><?= $_ENV['SOFTWARE_TITLE'] ?></a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Registriere dich, um noch heute dein virtuelles Raumfahrtunternehmen zu gründen</p>

            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Unternehmensname" name="companyNameRegister">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-building"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" placeholder="E-Mail" name="emailRegister">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Passwort" name="passwordRegister">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="agreeTerms" name="termsRegisterAccept" value="agree">
                            <label for="agreeTerms">
                                Ich akzeptiere die <a href="#">Nutzungsbedingungen</a>
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Registrieren</button>
                    </div>
                </div>
            </form>

            <a href="/login" class="text-center">Anmelden</a>
        </div>
    </div>
</div>