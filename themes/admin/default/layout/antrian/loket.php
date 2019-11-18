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
  <div class="row">
    <div class="col-md-12">
      <a href="" data-toggle="modal" id="tambah" data-target="#addLoket" data-url='<?= base_url("admin/antrian/addloket") ?>' class="btn col-md-12 btn-success">Tambah Antry</a>
      <div class="card">
        <div class="card-header card-header-rose card-header-icon">
          <div class="card-icon">
            <i class="material-icons">assignment</i>
          </div>
          <h4 class="card-title">List Loket</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th>Nomor Loket</th>
                  <th>Status</th>
                  <th class="text-right">Actions</th>
                </tr>
              </thead>
              <tbody>

                <?php $i = 1;
                foreach ($list_loket as $row) : ?>
                  <tr>
                    <td class="text-center"><?= $i++ ?></td>
                    <td><?= $row['client'] ?></td>
                    <td><?= ($row['status'] == 1) ? "Sedang Ada Tamu" : "Lagi kosong" ?></td>
                    <td class="td-actions text-right">
                      <a href="<?= base_url('admin/antrian/editloket/') . $row['id'] ?>" rel=" tooltip" class="btn btn-success editIt" data-togle="modal" data-url="<?= base_url('admin/antrian/editloket/') . $row['id'] ?>" data-id="<?= $row['id'] ?>" data-status="<?= $row['status'] ?>" data-client="<?= $row['client'] ?>" data-target='#addLoket' data-original-title="" title="Edit Nomor Loket Yang Sesuai">
                        <i class="material-icons">edit</i>
                      </a>
                      <a href="" data-toggle="modal" data-target="#deleteLoket" data-url="<?= base_url('admin/antrian/deleteLoket/' . $row['id']) ?>" rel="tooltip" class="btn btn-danger deleteIt" data-original-title="" title="Untuk Menhapus Loket">
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
  <div class="audio">
    <audio id="playAudio" src="<?= base_url('assets/') ?>audio/new/in.wav"></audio>
  </div>


  <?php
  $this->load->view($thema_load . 'element/template/footer.php');
  ?>
  <?php
  $this->load->view($thema_load . 'element/template/fixed-setting.php');
  ?>


  <div class="modal fade" id="addLoket" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newMenuModalLabel">Add New Loket</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="jumbotron text-center">
            <h1 class="counter" url=""></h1>
            <p>
              <a class="btn btn-lg btn-primary next_queue" href="#" role="button">
                Tambah &nbsp;<span class="fa fa-chevron-circle-right"></span>
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="deleteLoket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Delete?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Delete" below if you are ready to Delete this .</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary deletethis" href="<?= base_url('admin/menu/delete'); ?>">Delete</a>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(".deleteIt").each(function() {
      $(this).click(function() {
        var url = $(this).data('url');
        $('.deletethis').attr('href', url);
      });
    });

    $("#tambah").click(function() {
      const url_tambah = $(this).data('url');
      var no = "<?= $this->antrian_m->getLastLoket(); ?>";
      $("h1.counter").attr("url", url_tambah);
      $("h1.counter").text(no);
    });
    $('.next_queue').click(function() {
      var no = $("h1.counter").text();
      var url = $("h1.counter").attr('url');
      $.ajax({
        type: "POST",
        data: {
          "id": no
        },
        dataType: "json",
        url: url, //request
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