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
  <div class="row loket">
    <div class="col-sm-6 offset-sm-3 text-center">
      <div class="antrian-active" data-active="<?= @$row['type'] ?>" style="padding-top:20px;padding-bottom:20px;">
        <h1>Loket <?= $s_loket['client'] ?></h1>

        <?php if ($s_loket['status'] == 1)
          echo "<button class='btn btn-primary btn-lg tutup'  data-toggle='modal' data-target='#open' type='button'><span class='fa fa-university'>&nbsp;</span> Antrian {$s_antrian['id']}</button>";
        elseif ($s_loket['status'] == 0)
          echo "<button class='btn btn-light buka'  data-toggle='modal' data-target='#open' btn-lg buka' type='button'><span class='fa fa-university'>&nbsp;</span> TUTUP</button>";
        else
          echo "<button class='btn btn-warning btn-lg process' data-toggle='modal' data-target='#open' type='button'><span class='fa fa-university'>&nbsp;</span>OPEN</button>";
        ?>
        <div class="container">
          <a href="<?= base_url('api/petugas/memanggil/') . $s_antrian['id'] ?>" class="panggil btn btn-primary" id="panggil" data-urut="<?= @$s_antrian['id'] ?>" data-counter="<?= @$s_antrian['counter'] ?>"><?= @($s_antrian['type'] == 1) ? "Panggil" : "Panggil Ulang" ?></a>
          <?php if ($antrian_next) : ?>
            <a href="<?= base_url("admin/antrian/lewati/" . @$s_antrian['id'] . "?counter=" . @$s_antrian['counter']) ?>" class="btn btn-danger">Lewati</a>
            <a href="<?= base_url("admin/antrian/selesai/" . @$s_antrian['id'] . "?counter=" . @$s_antrian['counter']) ?>" class="btn btn-success">Selesai</a>
          <?php else : ?>
            <!-- <a href="<?= base_url("admin/antrian/selesai/" . @$s_antrian['id'] . "?counter=" . @$s_antrian['counter']) ?>" class="btn btn-success">Selesai</a> -->
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <hr />
  <div class="row">
    <div class="col-md text-center">
      <div class="1 jumbotron" style="padding-top:20px;padding-bottom:20px;">
        <?php if ($antrian_next) : ?>
          <h1><span>Siap siap </span> <?= $antrian_next['id'] ?></h1><button class="btn btn-light btn-lg" type="button"><span class="fa fa-university">&nbsp;</span>Di LOKET .?</button>
          <div class="container">
            <a href="<?= base_url("admin/antrian/selesai/" . $antrian_next['id']) ?>?>" class="btn btn-warning">Waiting..!</a>
          </div>
        <?php else : ?>
          <h1><span>Sudah tidak ada Antrian </span> <?= $antrian_next['id'] ?></h1><button class="btn btn-light btn-lg" type="button"><span class="fa fa-university">&nbsp;</span>Kosong.!</button>
        <?php endif; ?>
      </div>
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
  <script src="https://js.pusher.com/5.1/pusher.min.js"></script>
  <script>
    loadFileJs("assets/js/Config/index.js");
  </script>


  <script>
    var status = 1;
    var content = '';
    $("button.tutup").click(() => {
      status = 0;
      $("span#contentku").html("TUTUP");
    });
    $("button.buka").click(() => {
      status = 2;
      $("span#contentku").html("BUKA");
    });
    $("button.process").click(() => {
      status = 1;
      content = "<?= $s_antrian['id'] ?>";
      $("span#contentku").html(content);
    });

    $("#open").on('shown', function() {
      $("span#contentku").html(content)
    });
    $('.next_queue').click(function() {
      $.ajax({
        type: "POST",
        data: {
          "id": "<?= $s_antrian['id'] ?>",
          "client": "<?= $s_loket['client'] ?>",
          "status": status
        },
        dataType: "json",
        url: "<?= base_url('admin/antrian/updateLoket') ?>", //request
        success: function(data) {
          $(".preloader").fadeIn();
          location.reload();
        }
      });
      return false;

    })
  </script>


</body>

</html>