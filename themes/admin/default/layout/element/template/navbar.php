<div class="wrapper">
    <div class="main-panel">
        <div id="loader-wrapper">
            <div id="loader">
            </div>
            <div class="text">Wait..!
            </div>
        </div>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <div class="navbar-minimize">
                        <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                            <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                            <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
                        </button>
                    </div>
                    <?php
                    $name = 'HOme';
                    $link = base_url('admin/');
                    if ($page['method']) {
                        $name = "Back";
                        $link .= strtolower($page['class']);
                    }
                    ?>

                    <a class="navbar-brand" href="<?= $link ?>"><?= $name ?></a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end">
                    <form class="navbar-form">
                        <div class="input-group no-border">
                            <input type="text" value="" class="form-control" placeholder="Search...">
                            <button type="submit" class="btn btn-white btn-round btn-just-icon">
                                <i class="material-icons">search</i>
                                <div class="ripple-container"></div>
                            </button>
                        </div>
                    </form>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#pablo">
                                <i class="material-icons">dashboard</i>
                                <p class="d-lg-none d-md-block">
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="<?= base_url('admin/user/notification') ?>" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">notifications</i>
                                <span class="notification">0</span>
                                <p class="d-lg-none d-md-block">
                                    More notification
                                </p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="#"> Tidak Ada Notifikasi Baru</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">person</i>
                                <p class="d-lg-none d-md-block">
                                    Account
                                </p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                                <a class="dropdown-item" href="#">Profile</a>
                                <a class="dropdown-item" href="#">Settings</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('admin/auth/logout'); ?>">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->

        <div class="content">
            <div class="mb-5">
                <div class="border-left border-primary pl-2">
                    <div class="position-relative" style="padding-right:135px">
                        <h3><?= $page['title'] ?></h3>
                        <div class="position-absolute" style="right:10px;top:-5px">
                            <a href="" class="btn btn-bd-download  d-lg-inline-block mb-3 mb-md-0 ml-md-3"><?= date("D,m Y") ?></a>
                        </div>
                    </div>
                    <p><?= $page['description'] ?></p>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb text-primary">
                        <li class="breadcrumb-item text-capitalize"><a href="<?= base_url("admin/user") ?>"><i class="material-icons">
                                    home
                                </i></a></li>

                        <?php if (count($page['before'])) : ?>
                            <li class="breadcrumb-item text-capitalize"><a href="<?= $page['before']['url'] ?>"><?= $page['before']['title'] ?></a></li>
                        <?php endif; ?>
                        <li class="breadcrumb-item active text-capitalize" aria-current="page"><?= $page['submenu'] ?></li>
                    </ol>
                </nav>
            </div>
            <!-- content -->
            <?= $this->session->flashdata('message'); ?>