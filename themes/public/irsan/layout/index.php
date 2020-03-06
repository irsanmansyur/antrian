<!DOCTYPE html>
<html lang="en">

<head>
    <link href="<?= base_url() ?>assets/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" />
    <!-- js -->

    <script src="<?= base_url() ?>assets/vendor/jquery-3-3-1/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/vendor/jquery-3-3-1/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="<?= base_url() ?>assets/vendor/bootstrap-4.1/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <style>
        .bg-utama {
            background: rgb(47, 145, 173);
            background: linear-gradient(51deg, rgba(47, 145, 173, 1) 1%, rgba(18, 71, 193, 1) 64%, rgba(10, 176, 209, 1) 100%);
            min-width: 100%;
            min-height: 100vh;
            padding: 25px;
        }

        .judul {
            margin-top: 15px;
            margin-right: -25px;
            margin-left: -25px;
            padding: 25px;
            background: rgb(47, 173, 136);
            background: linear-gradient(103deg, rgba(47, 173, 136, 1) 9%, rgba(10, 94, 209, 1) 55%, rgba(18, 71, 193, 1) 100%);
        }

        .card-loket {
            background: linear-gradient(90deg, #00C9FF 0%, #92FE9D 100%);
            border: none;
        }

        .next-antri {
            background: linear-gradient(90deg, #00d2ff 0%, #3a47d5 100%);
        }

        hr.white {
            border-color: #fff;
            background: #fff;
        }
    </style>

</head>

<body>
    <!-- isi content -->
    <div class="bg-utama">
        <h1 class="judul display-5">
            <marquee behavior="scroll" scrollamount="9" direction="left">Selamat Datang di Sistem Antrian!</marquee>
        </h1>
        <div class="card-deck mt-5" id="loket">
            <div class="card card-loket">
                <div class="card-body text-center">
                    <h1 class="card-title text-center display-2">Loket 1</h1>
                    <hr class="white">
                    <button id="btn2" class="btn btn-primary btn-lg d-block w-100" type="button">
                        <h2 class="display-5 text-center">Nomor Antrian 3</h2>
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md text-center mt-5">
                <div class="jumbotron next-antri" next="0" style="padding-top:20px;padding-bottom:20px;">
                </div>
            </div>
        </div>

    </div>


    <script type="text/javascript">
        const baseUrl = "<?= base_url() ?>";
        const themeFolder = "<?= $thema_folder ?>";
        const loadFileJs = (url, folder = null) => {
            let elJs = document.createElement("script");
            elJs.src = folder ? url : themeFolder + url;
            document.querySelector("head").appendChild(elJs);
            return true;
        };

        const addCss = (url, folder = null) => {
            let link = document.createElement("link");
            link.rel = "stylesheet";
            link.type = "text/css";
            link.href = folder ? url : themeFolder + url;
            document.querySelector("head").appendChild(link);
            return "Added";
        };
        loadFileJs("https://js.pusher.com/5.1/pusher.min.js", "dd");
        loadFileJs("assets/js/notification/index.js");
    </script>



</body>

</html>