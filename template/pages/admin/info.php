<?php $this->layout('templates/base', ['title' => 'Startseite']) ?>

<div class="wrapper">

    <?php require_once(TEMPLATE_DIR . '/parts/navigation.php'); ?>

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Startseite</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/admin/dashboard">Admin</a></li>
                            <li class="breadcrumb-item active">Info</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                <h4>System Info</h4>
                                <hr>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        PHP-Version
                                        <span class="badge badge-primary badge-pill"><?= PHP_VERSION ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Webserver
                                        <span class="badge badge-primary badge-pill"><?= $_SERVER['SERVER_SOFTWARE'] ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Max Execution Time
                                        <span class="badge badge-primary badge-pill"><?= ini_get('max_execution_time') ?>ms</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Memory Limit
                                        <span class="badge badge-primary badge-pill"><?= ini_get('memory_limit') ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Protocol
                                        <span class="badge badge-primary badge-pill"><?= $_SERVER['SERVER_PROTOCOL'] ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                <h4>Software Info</h4>
                                <hr>

                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Software Version
                                        <span class="badge badge-primary badge-pill"><?= \App\Software::VERSION ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Software Type
                                        <span class="badge badge-primary badge-pill"><?= \App\Software::VERSION_TYPE ?></span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center"
                                        data-toggle="tooltip" data-placement="bottom" title="Enabled Dev Mode adds some more Developer Options. Please use with Caution">
                                        Development Mode
                                        <span class="badge badge-primary badge-pill">
                                            <?= \App\Software::DEV_ENVIRONMENT ? 'Enabled' : 'Disabled' ?>
                                        </span>
                                    </li>
                                </ul>

                                <hr>

                                <a href="<?= \App\Software::CHANGELOG_URI ?>" class="card-link text-right">Software Changelog</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                <h4>Error Logs</h4>

                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <aside class="control-sidebar control-sidebar-dark">
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>

    <?= require_once TEMPLATE_DIR.'/parts/footer.php' ?>

</div>
