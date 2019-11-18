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
    <?php foreach ($antrian_active as $row) : ?>
      <div class="col-md-6 col-sm-6 text-center">
        <div class="antrian-active" data-active="<?= $row['type'] ?>" style="padding-top:20px;padding-bottom:20px;">
          <h1><?= $row['id'] ?></h1><button class="btn btn-light btn-lg" type="button"><span class="fa fa-university">&nbsp;</span>DI Loked <?= $row['counter'] ?></button>
          <div class="container">

            <button class="panggil btn btn-primary" id="panggil" data-urut="<?= $row['id'] ?>" data-counter="<?= $row['counter'] ?>"><?= ($row['type'] == 1) ? "Panggil" : "Panggil Ulang" ?></button>
            <a href="<?= base_url("admin/antrian/lewati/" . $row['id'] . "?counter=" . $row['counter']) ?>" class="btn btn-danger">Lewati</a>
            <a href="<?= base_url("admin/antrian/selesai/" . $row['id'] . "?counter=" . $row['counter']) ?>" class="btn btn-success">Selesai</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
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
                    <td><?= ($row['status'] == 2) ? "<span class='badge badge-primary'>Belum dipanggil</span>" : "<span class='badge badge-danger' data-toggle='tooltip' title='Pengantri tidak ada di tempat saat di panggil'>Sudah dipanggil</span>" ?></td>
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
  <div class="audio">
    <audio id="playAudio" src="<?= base_url('assets/') ?>audio/new/in.wav"></audio>
  </div>

  <script type="text/javascript">
    var audio = $("#playAudio")[0];
    var noUrut, noPertama, noKedua, noKetiga, loked, lokedNumber, out;

    $("document").ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
      var tmp_loket = 0;

      var panggil = $(".panggil");
      var playing = true;
      // var init = setInterval(function() {
      //   $.post("<?= base_url('admin/antrian/getData') ?>", function(data) {
      //     if ()
      //       mulai(data['antrian_active'], data['antrian_next']);
      //   });

      // }, 1000)
      panggil.each(function(index) {
        $(this).click(function() {
          var urut = $(this).data('urut');
          var counter = $(this).data('counter');
          $(this).text("Sedang Memanggil..!").removeClass("btn-primary").addClass("btn-danger");
          panggil.attr("disabled", true);
          setTimeout(() => {
            $(this).text("Panggil Ulang").removeClass("btn-danger").addClass("btn-primary");
            panggil.attr("disabled", false);

          }, 13000);
          clearTimeout(noUrut);
          clearTimeout(noPertama);
          clearTimeout(noKedua);
          clearTimeout(noKetiga);
          clearTimeout(loked);
          clearTimeout(lokedNumber);
          clearTimeout(out);
          mulai(urut, counter);
        });
      });

      audio.addEventListener("ended", function() {
        audio.src = "<?= base_url('assets/') ?>audio/new/in.wav";
      })
    });
    //change
    function mulai(urut, loket) {
      const counter = loket;
      var urut1 = urut2 = urut3 = '';
      var totalwaktu = 8568.163;
      audio.pause();
      audio.currentTime = 0;
      audio.play();
      totalwaktu = audio.duration * 1000;

      noUrut = setTimeout(function() {
        audio.currentTime = 0;
        audio.src = "<?= base_url('assets/') ?>audio/new/nomor-urut.MP3";
        audio.play();
      }, totalwaktu);
      totalwaktu += 1000;


      noPertama = setTimeout(function() {
        audio.currentTime = 0;
        if (urut < 10) {
          audio.src = "<?= base_url('assets/') ?>audio/new/" + urut + ".MP3";
        } else if (urut == 10) {
          audio.src = "<?= base_url('assets/') ?>audio/new/sepuluh.MP3";
        } else if (urut == 11) {
          audio.src = "<?= base_url('assets/') ?>audio/new/sebelas.MP3";
        } else if (urut < 20) {
          urut1 = "" + urut;
          urut2 = "<?= base_url('assets/') ?>audio/new/belas.MP3";
          urut1 = urut1.substr(-1);
          audio.src = "<?= base_url('assets/') ?>audio/new/" + urut1 + ".MP3";
        } else if (urut == 20 || urut == 30 || urut == 40 || urut == 50 || urut == 60 || urut == 70 || urut == 80 || urut == 90) {
          urut1 = "" + urut;
          belas = true;
          urut1 = urut1.substr(0, 1);
          urut2 = "<?= base_url('assets/') ?>audio/new/puluh.MP3";
          audio.src = "<?= base_url('assets/') ?>audio/new/" + urut1 + ".MP3";
        } else if (urut < 100) {
          urut1 = "" + urut;
          urut3 = urut1.substr(-1);
          urut1 = urut1.substr(0, 1);
          urut3 = "<?= base_url('assets/') ?>audio/new/" + urut3 + ".MP3";
          urut2 = "<?= base_url('assets/') ?>audio/new/puluh.MP3";
          audio.src = "<?= base_url('assets/') ?>audio/new/" + urut1 + ".MP3";
        }
        audio.play();
      }, totalwaktu);

      totalwaktu += 1000;
      noKedua = setTimeout(() => {
        if (urut2 != '') {

          audio.src = urut2;
          audio.play();
        }
      }, totalwaktu);


      totalwaktu += 800;
      noKetiga = setTimeout(() => {
        if (urut3 != "") {
          audio.src = urut3;
          audio.play();
        }
      }, totalwaktu);

      totalwaktu += 1000;
      loked = setTimeout(() => {
        audio.src = "<?= base_url('assets/') ?>audio/new/loket.MP3";
        audio.play();
      }, totalwaktu);

      totalwaktu += 800;
      lokedNumber = setTimeout(() => {
        audio.src = "<?= base_url('assets/') ?>audio/new/" + counter + ".MP3";
        audio.play();
      }, totalwaktu);

      totalwaktu += 1000;
      out = setTimeout(() => {
        audio.src = "<?= base_url('assets/') ?>audio/new/out.wav";
        audio.play();
      }, totalwaktu);
      totalwaktu += 1000;

    };
  </script>
  <?php
  $this->load->view($thema_load . 'element/template/footer.php');
  ?>
  <?php
  $this->load->view($thema_load . 'element/template/fixed-setting.php');
  ?>


  <div class="modal fade" id="addAntrian" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newMenuModalLabel">Add New Antria</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="">
            <div class="text-left border-bottom">Pilih Loket</div>
            <?php foreach ($list_loket as $row) : ?>
              <div class="form-check form-check-radio form-check-inline">
                <label class="form-check-label">
                  <input class="form-check-input radioCheck" type="radio" name="inlineRadioOptions" id="inlineRadio1<?= $row['client'] ?>" value="<?= $row['client'] ?>"> <?= $row['client'] ?>
                  <span class="circle">
                    <span class="check"></span>
                  </span>
                </label>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="jumbotron text-center">

            <h1 class="counter"></h1>
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
  <div class="modal fade" id="deleteAntrian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
      var no = "<?= $this->antrian_m->getLastId(); ?>";
      $("h1.counter").text(no);
    });
    $('.next_queue').click(function() {
      var client;
      $(".radioCheck").each(function() {
        if ($(this).is(':checked')) {
          client = $(this).val();
          console.log("ok");
        }
      });
      var no = $("h1.counter").text();
      $.ajax({
        type: "POST",
        data: {
          "id": no,
          "client": client
        },
        dataType: "json",
        url: "<?= base_url('admin/antrian/addAntrian') ?>", //request
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