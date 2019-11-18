<!DOCTYPE html>
<html lang="en">
<?php $this->load->view($thema_load . 'element/template/head_meta'); ?>

<body class="off-canvas-sidebar">
  <!-- Navbar -->
  <?php $this->load->view($thema_load . 'element/template/auth/navbar'); ?>

  <!-- content -->
  <div class="wrapper wrapper-full-page">
    <div class="page-header login-page header-filter" filter-color="black" style="background-image: url('<?= $thema_folder; ?>/assets/img/clint-mckoy.jpg'); background-size: cover; background-position: top center;">
      <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
            <form class="form" method="post" action="<?= $form['action_login'] ?>">

              <div class="card card-login card-hidden">
                <div class="card-header card-header-rose text-center">
                  <h4 class="card-title">Login Page</h4>
                  <!-- <div class="social-line">
                    <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                      <i class="fa fa-facebook-square"></i>
                    </a>
                    <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                      <i class="fa fa-twitter"></i>
                    </a>
                    <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                      <i class="fa fa-google-plus"></i>
                    </a>
                  </div> -->
                </div>

                <div class="card-body ">
                  <?= $this->session->flashdata('message'); ?>
                  <div class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">email</i>
                        </span>
                      </div>
                      <input type="email" class="form-control" placeholder="Email" name="email" value="<?= set_value('email'); ?>" />
                    </div>
                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                  <span class="bmd-form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="material-icons">lock</i>
                        </span>
                      </div>
                      <input type="password" class="form-control" placeholder="Password" name="password">
                    </div>
                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                  </span>
                </div>
                <div class="card-footer justify-content-center">
                  <input type="submit" name="loginnow" class="btn btn-rose btn-link btn-lg" value="Lets Go!">
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