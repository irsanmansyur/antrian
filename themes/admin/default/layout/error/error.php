<!DOCTYPE html>
<html lang="en">
<?php $this->load->view($thema_load . 'element/template/head_meta'); ?>

<body class="off-canvas-sidebar">
  <!-- Navbar -->
  <?php $this->load->view($thema_load . 'element/template/auth/navbar'); ?>
  <!-- End Navbar -->

  <div class="wrapper wrapper-full-page">
    <div class="page-header error-page header-filter" style="background-image: url('<?= @$thema_folder ?>assets/img/clint-mckoy.jpg')">
      <!--   you can change the color of the filter page using: data-color="blue | green | orange | red | purple" -->
      <div class="content-center">
        <div class="row">
          <div class="col-md-12">
            <h1 class="mx-auto error" data-text="404">404</h1>
            <h2>Page not found :(</h2>
            <h4>Ooooups! Looks like you got lost.</h4>
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container">
          <div class="copyright float-right">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script>, made with Irsan Mansyur
          </div>
        </div>
      </footer>
    </div>
  </div>

  <!-- footer -->
  <?php $this->load->view($thema_load . 'element/template/auth/footer'); ?>
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