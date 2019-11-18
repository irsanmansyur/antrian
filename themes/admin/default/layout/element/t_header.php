  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container">
          <a class="navbar-brand" href="<?= base_url() ?>"> <?= $site_setting['site_name'] ?></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
              <div class="navbar-nav ml-auto">
                  <a class="nav-item nav-link <?= (!@$page['class'] || @$page['class'] == "Home" && !$page['method']) ? "active" : ""; ?>" href="<?= base_url("home") ?>">Home <span class="sr-only">(current)</span></a>
                  <a class="nav-item nav-link <?= (@$page['class'] == "Home" && @$page['method'] == "profile") ? "active" : ""; ?>" href="<?= base_url('home/profile') ?>">Profile</a>
                  <a class="nav-item nav-link <?= (@$page['class'] == "Home" && @$page['method'] == "profileg") ? "active" : ""; ?>" href="<?= base_url('struktur') ?>">STRUKTUR ORGANISASI</a>
                  <a class="nav-item nav-link <?= (@$page['class'] == "Home" && @$page['method'] == "publikasi") ? "active" : ""; ?>" href="<?= base_url('home/publikasi') ?>">Publikasi</a>

                  <?php
                    if ($this->session->userdata('email')) : ?>
                      <a class="nav-item nav-link btn btn-danger text-white tombol" href="<?= base_url('admin/auth/logout') ?>">Logout</a>
                  <?php else : ?>
                      <a class="nav-item nav-link btn btn-primary text-white tombol" href="<?= base_url('admin/auth') ?>">Join Us</a>
                  <?php endif; ?>
              </div>
          </div>
      </div>
  </nav>
  <!-- akhir Navbar -->