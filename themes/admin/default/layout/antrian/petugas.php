<!DOCTYPE html>
<html lang="en">
<?php
$this->load->view($thema_load . 'element/template/head_meta.php');
?>

<body class="">
  <!-- sidebar   -->
  <?php $this->load->view($thema_load . 'element/template/sidebar.php'); ?>
  <!-- end sidebara -->

  <?php
  $this->load->view($thema_load . 'element/template/navbar.php');
  ?>

  <!-- isi content -->
  <div id="loket-page" class="card">
    <div class="row loket">
      <div class="col-sm-6 text-center border-right-1">
        <loket-component v-bind:loket="loket" v-bind:next="next"></loket-component>
      </div>
      <div class="col-sm-6 text-center">
        <next-loket v-bind:antrian="next"></next-loket>
      </div>
    </div>
  </div>

  <div id="antrian-page" class="row">
    <div class="col-md-12">
      <a href="" data-url="<?= base_url("admin/antrian/admin") ?>" data-toggle="modal" id="tambah" data-target="#addAntrian" class="btn col-md-12 btn-success">Tambah Antry</a>
      <div class="card">
        <div class="card-header card-header-rose card-header-icon">
          <div class="card-icon">
            <i class="material-icons">assignment</i>
          </div>
          <h4 class="card-title">List Antrian</h4>
        </div>
        <antrian-component :antrians="antrians"></antrian-component>
      </div>
    </div>
  </div>
  <script>
    const idLoket = "<?= $id ?>";

    loadFileJs("src/components/loket/index.js");
    loadFileJs("src/components/next/index.js");
    loadFileJs("src/components/antrian/index.js");
    addCss("assets/css/petugas/petugas.css");
    loadFileJs("src/pages/loket/index.js");
  </script>

  <?php
  $this->load->view($thema_load . 'element/template/footer.php');
  ?>
  <?php
  $this->load->view($thema_load . 'element/template/fixed-setting.php');
  ?>
  <div class="modal fade" id="open" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newMenuModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="jumbotron text-center">
            <p>
              <a class="btn btn-lg btn-primary next_queue" href="#" role="button"><span id="contentku">Antrian <?= $s_antrian['id'] ?></span>
                &nbsp;<span class="fa fa-chevron-circle-right"></span>
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>