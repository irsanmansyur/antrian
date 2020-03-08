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
  <div id="loket-page">
    <div class="row loket">
      <div class="col-sm-6 offset-sm-3 text-center">
        <loket-component v-bind:loket="data.loket" v-bind:next="data.nextAntri"></loket-component>
      </div>
    </div>
    <hr />
    <div class="row">
      <next-component v-bind:selanjutnya="data.nextAntri"></next-component>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <a href="" data-url="<?= base_url("admin/antrian/admin") ?>" data-toggle="modal" id="tambah" data-target="#addAntrian" class="btn col-md-12 btn-success">Tambah Antry</a>
      <div class="card">
        <div class="card-header card-header-rose card-header-icon">
          <div class="card-icon">
            <i class="material-icons">assignment</i>
          </div>
          <h4 class="card-title">List Antrian</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th>Nomor Antrian</th>
                  <th>Loket Sementara</th>
                  <th>Status</th>
                  <th class="text-right">Actions</th>
                </tr>
              </thead>
              <tbody>

                <?php $i = 1;
                foreach ($list_antrian as $row) : ?>
                  <tr>
                    <td class="text-center"><?= $i++ ?></td>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['counter'] ?></td>
                    <td><?= ($row['status'] == 3) ? "<span class='badge badge-primary'>Belum dipanggil</span>" : "<span class='badge badge-danger' data-toggle='tooltip' title='Pengantri tidak ada di tempat saat di panggil'>Sudah dipanggil</span>" ?></td>
                    <td class="td-actions text-right">

                      <button type="button" rel="tooltip" class="btn btn-success" data-original-title="" title="Belum di berikan aksi untuk tombol edit">
                        <i class="material-icons">edit</i>
                      </button>
                      <a href="" data-toggle="modal" data-target="#deleteAntrian" data-url="<?= base_url('admin/antrian/delete/' . $row['id']) ?>" rel="tooltip" class="btn btn-danger deleteIt" data-original-title="" title="Untuk Menhapus antrian">
                        <i class="material-icons">close</i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    const idLoket = "<?= $id ?>";

    loadFileJs("src/components/loket/index.js");
    loadFileJs("src/components/next/index.js");

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