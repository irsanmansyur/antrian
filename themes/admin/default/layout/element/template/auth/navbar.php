<div id="loader-wrapper">
    <div id="loader">
    </div>
    <div class="text">Wait..!
    </div>
</div>
<!-- navbar -->
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top text-white">
    <div class="container">
        <div class="navbar-wrapper">
            <a class="navbar-brand" href="#Home"><?= @$page['title'] ?></a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="<?= base_url('home') ?>" class="nav-link">
                        <i class="fa fa-university"></i> Home
                    </a>
                </li>
                <li class="nav-item <?= is_active('auth', "registration") ?>">
                    <a href="<?= base_url('admin/auth/registration') ?>" class="nav-link">
                        <i class="fa fa-user-plus"></i> Register
                    </a>
                </li>
                <li class="nav-item <?= is_active('auth') ?>">
                    <a href="<?= base_url('admin/auth') ?>" class="nav-link">
                        <i class="fa fa-user-secret"></i> Login
                    </a>
                </li>
                <?php
                if ($this->session->userdata('email')) : ?>
                    <li class="nav-item <?= (@$page['method'] == 'lock') ? 'active' : '' ?>">
                        <a href="<?= base_url('admin/auth/lock') ?>" class="nav-link">
                            <i class="fa fa-lock"></i> Lock
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href=" <?= base_url('admin/auth/logout') ?>" class="nav-link text-danger">
                            <i class="fa fa-power-off "> </i> Logout
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->