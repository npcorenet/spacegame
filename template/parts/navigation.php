<?php require_once TEMPLATE_DIR.'/parts/topnav.php'?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/dashboard" class="brand-link">
        <img src="<?=$this->asset('/asset/img/AdminLTELogo.png')?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= \App\Software::TITLE ?></span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?=$this->asset('/asset/img/user2-160x160.jpg') ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Demo Space Agency</a>
                <span class="text-green"><i class="fas fa-money-bill-wave mr-2"></i> Guthaben: 0$</span>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link <?=$this->uri('/dashboard', 'active')?>">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            Startseite
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/finances" class="nav-link <?=$this->uri('/finances', 'active')?>">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>
                            Finanzen
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/contract/list" class="nav-link <?=$this->uri('/finances', 'active')?>">
                        <i class="nav-icon fas fa-file-contract"></i>
                        <p>
                            Aufträge
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/news" class="nav-link <?=$this->uri('/finances', 'active')?>">
                        <i class="fas fa-newspaper nav-icon"></i>
                        <p>
                            Neuigkeiten
                        </p>
                    </a>
                </li>

                <li class="nav-header">MULTIPLAYER</li>
                <li class="nav-item">
                    <a href="/players" class="nav-link <?=$this->uri('/finances', 'active')?>">
                        <i class="fas fa-users nav-icon"></i>
                        <p>
                            Spieler suchen
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/contract/create" class="nav-link <?=$this->uri('/finances', 'active')?>">
                        <i class="fas fa-file-signature nav-icon"></i>
                        <p>
                            Ausschreiben erstellen
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/stocks" class="nav-link <?=$this->uri('/finances', 'active')?>">
                        <i class="fas fa-chart-line nav-icon"></i>
                        <p>
                            Aktien
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/settings" class="nav-link <?=$this->uri('/finances', 'active')?>">
                        <i class="fas fa-user nav-icon"></i>
                        <p>
                            Öffentliches Profil
                        </p>
                    </a>
                </li>
                <li class="nav-header">ADMINISTRATION</li>
                <li class="nav-item">
                    <a href="/admin/dashboard" class="nav-link <?=$this->uri('/finances', 'active')?>">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/players" class="nav-link <?=$this->uri('/finances', 'active')?>">
                        <i class="fas fa-users nav-icon"></i>
                        <p>
                            Spieler
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/status" class="nav-link <?=$this->uri('/finances', 'active')?>">
                        <i class="fas fa-signal nav-icon"></i>
                        <p>
                            Status
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-hammer"></i>
                        <p>
                            Dev Tools
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p></p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="/admin/info" class="nav-link <?=$this->uri('/finances', 'active')?>">
                        <i class="fas fa-info-circle nav-icon"></i>
                        <p>
                            Systeminfo
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>