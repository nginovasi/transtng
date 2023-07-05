<?php
$session = \Config\Services::session();
$user = $session->get('name');
?>
<!-- ############ NAVBAR START-->
<div id="header" class="page-header">
    <div class="navbar navbar-expand-lg">
        <!-- brand -->
        <a href="<?= base_url() ?>/main" class="navbar-brand d-lg-none">
            <img src="<?= base_url(); ?>/assets/img/TNGLogo-TNGIcon.svg">
        </a>
        <!-- / brand -->
        <!-- Navbar collapse -->
        <ul class="nav navbar-menu order-1 order-lg-2">
            <!-- User dropdown menu -->
            <li class="nav-item dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link d-flex align-items-center px-2 text-color">
                    <span class="avatar w-24" style="margin: -2px;" id="d-profile"><img src="<?= base_url() ?>/assets/img/avatar-pri.svg" alt="..."></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right w mt-3 animate fadeIn">
                    <a class="dropdown-item" href="javascript:void(0)"><span class="badge bg-success">Hai, <?= $user ?></span></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= base_url() ?>/auth/change_Password"><i class="fa fa-key"></i> Ganti Password</a>
                    <a class="dropdown-item" href="<?= base_url() ?>/auth/action/logout"><i class="fa fa-sign-out"></i> Keluar</a>
            </li>
            <!-- Navarbar toggle btn -->
            <li class="nav-item d-lg-none">
                <a class="nav-link px-1" data-toggle="modal" data-target="#aside">
                    <i data-feather="menu"></i>
                </a>
            </li>
        </ul>
    </div>
</div>

<script>
    var navbar = document.querySelector('#header');
    var scrolled = false;

    window.addEventListener('scroll', function() {
        if (window.pageYOffset > navbar.offsetHeight) {
            if (!scrolled) {
                navbar.classList.add('scroll');
                scrolled = true;
            }
        } else {
            if (scrolled) {
                navbar.classList.remove('scroll');
                scrolled = false;
            }
        }
    });
</script>
<!-- ############ NAVBAR END-->