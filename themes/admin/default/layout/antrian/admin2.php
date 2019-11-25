<!DOCTYPE html>
<html lang="en">

<body class="">
  <!-- sidebar   -->
  <?php $this->load->view($thema_load . 'element/template/sidebar.php'); ?>
  <!-- end sidebara -->

  <?php
  $this->load->view($thema_load . 'element/template/navbar.php');
  ?>

  <!-- isi content -->
  <div class="row loket" id="loket">

  </div>
  <div class="row">
    <div class="col-md text-center">
      <div class="jumbotron next-antri" next="0" style="padding-top:20px;padding-bottom:20px;">
      </div>
    </div>
  </div>
  <div class="audio">
    <audio id="playAudio" autoplay="true" muted="muted" preload="none" src="<?= base_url('assets/') ?>audio/new/in.wav"></audio>
  </div>


  <?php
  $this->load->view($thema_load . 'element/template/footer.php');
  ?>
  <?php
  $this->load->view($thema_load . 'element/template/fixed-setting.php');
  ?>
  <script type="text/javascript">
    var sounds = document.getElementsByTagName('audio');
    var base_url = "<?= base_url() ?>";
    for (i = 0; i < sounds.length; i++) {
      sounds[i].currentTime = 0;
      sounds[i].pause();
    }
    var noUrut = [];

    noUrut[0] = setTimeout(() => {}, 1000);
    var playing = false;
    var audio = $('audio')[0];
    $("document").ready(function() {
      var tmp_loket = 0;
      var init = setInterval(function() {
        $.post("<?= base_url('admin/antrian/getData') ?>", function(data) {
          if (tmp_loket != data['jmlLoket']) {
            tmp_loket = 0;
          }
          if (tmp_loket == 0) {
            for (var i = 0; i <= noUrut.length; i++) {
              clearTimeout(noUrut[i]);
            }
            for (var i = 0; i < data['jmlLoket']; i++) {
              a = `<div class="col-md-6 text-center"><div class="antrian-active" style="padding-top:20px;padding-bottom:20px;"><h1><span class='fa fa-university'>&nbsp;</span> Loket ${data['loket'][i].client}</h1>`;
              if (data['loket'][i].status == 1) {
                a += `<button class='btn btn-primary btn-lg status-${i}' type='button'></button>`;
              } else if (data['loket'][i].status == 0) {
                a += `<button class='btn btn-light status-${i}' btn-lg' type='button' > TUTUP</button>`;
              } else {
                a += `<button class='btn btn-warning status-${i}' btn-lg' type='button'>OPEN</button>`;
              }
              a += `</div> </div>`;
              $(".loket").append(a);
            }
          }
          if (data['nextAntri'] != false) {
            if ($(".next-antri").attr('next') != data['nextAntri'].id) {
              $(".next-antri").attr('next', data['nextAntri'].id);
              $(".next-antri").html(`<h1><span>Siap siap </span> ${data['nextAntri'].id}</h1><button class="btn btn-light btn-lg" type="button"><span class="fa fa-university">&nbsp;</span>Di LOKET .?</button><div class="container"><a href="${base_url}admin/antrian/selesai/${data['nextAntri'].id}" class="btn btn-warning">Waiting..!</a></div>`);
            }
          } else {
            $(".next-antri").html(`<h1><span>Sudah tidak ada Antrian </span></h1><button class="btn btn-light btn-lg" type="button"><span class="fa fa-university">&nbsp;</span>Kosong.!</button>`);
          }
          for (var i = 0; i < data['jmlLoket']; i++) {
            if (data['loket'][i].status == 1) {
              $(".status-" + i).html("Antrian " + data["content"][i].id).removeClass("btn-warning").removeClass("btn-light").addClass("btn-primary");
            } else if (data['loket'][i].status == 0)
              $(".status-" + i).html("TUTUP").removeClass("btn-primary").removeClass("btn-warning").addClass("btn-light");
            else $(".status-" + i).html("OPEN").removeClass("btn-primary").removeClass("btn-light").addClass("btn-warning");;
            if (playing == false) {
              if (data['loket'][i].status == 2 && data['loket'][i].status != 1) {
                console.log('bunyi mulai');
              } else if (data['content'][i].status == 2) {
                var angka = data['content'][i].id;
                playing = true;
                mulai(data['content'][i].id, data['content'][i].counter);
              }
            }
          }
          tmp_loket = data['jmlLoket'];
        });
      }, 1000)
    });
    //change
    function mulai(urut, loket) {
      const counter = loket;
      var urut1 = urut2 = urut3 = '';
      var totalwaktu = 8568.163;
      noUrut[1] = setTimeout(() => {
        audio.src = "<?= base_url('assets/') ?>audio/new/in.wav";
        audio.currentTime = 0;
        Aplay(audio.play());
      }, 1000)
      totalwaktu = audio.duration * 1000;


      noUrut[2] = setTimeout(function() {
        audio.currentTime = 0;
        audio.src = "<?= base_url('assets/') ?>audio/new/nomor-urut.MP3";
        audio.play();
      }, totalwaktu);

      totalwaktu += 1000;
      noUrut[3] = setTimeout(function() {
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
      noUrut[3] = setTimeout(() => {
        if (urut2 != '') {
          audio.src = urut2;
          audio.play();
        }
      }, totalwaktu);


      totalwaktu += 800;
      noUrut[4] = setTimeout(() => {
        if (urut3 != "") {
          audio.src = urut3;
          audio.play();
        }
      }, totalwaktu);

      totalwaktu += 1000;
      noUrut[5] = setTimeout(() => {
        audio.src = "<?= base_url('assets/') ?>audio/new/loket.MP3";
        audio.play();
      }, totalwaktu);

      totalwaktu += 800;
      noUrut[6] = setTimeout(() => {
        audio.src = "<?= base_url('assets/') ?>audio/new/" + counter + ".MP3";
        audio.play();
      }, totalwaktu);

      totalwaktu += 1000;
      noUrut[7] = setTimeout(() => {
        audio.src = "<?= base_url('assets/') ?>audio/new/out.wav";
        audio.play();
      }, totalwaktu);
      totalwaktu += 3000;
      var selesai = setTimeout(() => {

      }, totalwaktu);
      totalwaktu += 1000;
      noUrut[8] = setTimeout(function() {
        $.post("<?= base_url('admin/antrian/setData') ?>", {
          id: urut
        }, function(data) {
          if (data.status == 1) {
            playing = false;
          }
        }, 'json');
      }, totalwaktu);
      totalwaktu = totalwaktu + 1000;
    };

    function Aplay(playPromise) {
      if (playPromise !== undefined) {
        playPromise.then(_ => {
            console.log("playing");
          })
          .catch(error => {
            console.log("playing" + error);

          });
      }
    }
  </script>



</body>

</html>