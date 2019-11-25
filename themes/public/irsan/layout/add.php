<!DOCTYPE html>
<html lang="en">

<head>
    <link href="<?= base_url() ?>assets/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" />
    <!-- js -->

    <script src="<?= base_url() ?>assets/vendor/jquery-3-3-1/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/jquery-3-3-1/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="<?= base_url() ?>assets/vendor/bootstrap-4.1/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</head>

<body class="">


    <div class="container text-center">
        <h1><button class="btn btn-primary bt-lg" data-toggle="modal" data-target="#tambah">Tambah</button></h1>
        Silahkan Tekan Tombol Tambah Untuk Mengambil antrian
    </div>
    <!-- isi content -->
    <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <h1>Nomor antrian anda</h1>
                        <div class="text-left"><?= date("d - M - Y", time()) ?></div>
                    </div>
                    <div class="jumbotron text-center">
                        <h1 class="counter display-5"><?= $next ?></h1>
                        <p>
                            <a class="btn btn-lg btn-primary next_queue" href="#" role="button">
                                Cetak &nbsp;<span class="fa fa-chevron-circle-right"></span>
                            </a>
                        </p>
                        <p class="pv-5">Sebelum mengkilk tombol cetak harap ingat baik baik nomor antrian anda, silahkan screen shot</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        $('.next_queue').click(function() {
            var no = $("h1.counter").text();
            $.ajax({
                type: "POST",
                data: {
                    "id": no,
                    "client": 2
                },
                dataType: "json",
                url: "<?= base_url('home/addAntrian') ?>", //request
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