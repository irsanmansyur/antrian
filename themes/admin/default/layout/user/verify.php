<!DOCTYPE html>
<html lang="en">
<?php $this->load->view($thema_load . 'element/template/head_meta'); ?>

<body class="off-canvas-sidebar">
  <!-- Navbar -->
  <?php $this->load->view($thema_load . 'element/template/auth/navbar'); ?>

  <!-- content -->
  <div class="wrapper wrapper-full-page">
    <div class="page-header login-page header-filter" filter-color="black" style="background-image: url('<?= $thema_folder; ?>/assets/img/login.jpg'); background-size: cover; background-position: top center;">
      <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
            <form class="form" method="get" action="<?= base_url('admin/auth/verify') ?>">
              <div class="card card-login card-hidden">
                <div class="card-header card-header-rose text-center">
                  <h4 class="card-title">Verifikasi</h4>
                </div>

                <div class="card-body ">
                  <?= $this->session->flashdata('message'); ?>
                  <span class="bmd-form-group">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                      <strong>Halo <?= $this->input->get('email'); ?>.!</strong> Kami sudah mengirim kode Token ke emailmu, Cek emailmu baru klik verifikasi,atau tempelkan disini Tokennya <a href="<?= base_url('admin/auth/send_token?email=' . $this->input->get('email')) ?>" class="badge badge-primary badge-sm">Send Again</a>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  </span>
                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">
                            fingerprint
                          </i>
                        </span>
                      </div>
                      <input type="text" class="form-control" placeholder="Input Token..." name="token" value="<?= $this->input->get('token') ?>" />
                      <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                      <input type="email" class="hidden" name="email" value="<?= $this->input->get('email') ?>" />
                    </div>
                  </span>
                </div>
                <div class="card-footer justify-content-center">
                  <input type="submit" name="submit" class="btn btn-rose btn-link btn-lg" value="Lets Go!">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- footer -->
      <?php $this->load->view($thema_load . 'element/template/auth/footer'); ?>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      // md.checkFullPageBackgroundImage();
      setTimeout(function() {
        // after 1000 ms we add the class animated to the login/register card
        $('.card').removeClass('card-hidden');
      }, 700);
    });
  </script>
</body>

</html>