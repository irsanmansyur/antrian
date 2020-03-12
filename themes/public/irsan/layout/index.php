<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://js.pusher.com/5.1/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <link href="<?= base_url() ?>assets/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" />
    <!-- js -->
    <style>
        .bg-utama {
            background: rgb(47, 145, 173);
            background: linear-gradient(51deg, rgba(47, 145, 173, 1) 1%, rgba(18, 71, 193, 1) 64%, rgba(10, 176, 209, 1) 100%);
            min-width: 100%;
            min-height: 100vh;
            box-sizing: border-box;
            padding: 25px;
        }

        .judul {
            margin-top: 8px;
            margin-right: -25px;
            margin-left: -25px;
            padding: 25px 20px;
            background: rgb(47, 173, 136);
            background: linear-gradient(103deg, rgba(47, 173, 136, 1) 9%, rgba(10, 94, 209, 1) 55%, rgba(18, 71, 193, 1) 100%);
        }

        .card-loket {
            background: linear-gradient(90deg, #00C9FF 0%, #92FE9D 100%);
            border: none;
        }

        .next-antri {
            margin-top: 15px;
            margin-left: 15px;
            margin-right: 15px;
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
    <div class="bg-utama" id="home-page">
        <h1 class="judul display-5 mt-0">
            <marquee behavior="scroll" scrollamount="9" direction="left">Selamat Datang di Sistem Antrian!</marquee>
        </h1>
        <div class="card-deck mt-3 mb-1" id="loket">
            <card-loket v-for="loket in loket" v-bind:loket="loket"></card-loket>
        </div>
        <div class="card-deck mt-3 mb-1">
            <div class="col-md text-center p-3 next-antri">
                <next-loket v-bind:antrian="next" v-bind:artist="'irsan'"></next-loket>
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

        function getData(url, {
            method,
            data,
            ...option
        } = {
            method: "GET"
        }) {
            let form = null;
            if (method == "POST") {
                form = new FormData();
                for (var i in data) {
                    form.append(i, data[i]);
                }
            }
            return fetch(baseUrl + url, {
                    method: method,
                    mode: "cors",
                    body: form
                })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                    return response.json()
                })
                .then(res => {
                    if (res.status === false) {
                        let msg = res.message + "</br>";
                        if (res.dataErrors) {
                            for (const [key, value] of Object.entries(res.error)) {
                                msg += `${key}  :  ${value}</br>`;
                            }
                        }
                        throw new Error(msg);
                    }
                    return res.data ? res.data : res;
                })
                .catch((error) => {
                    throw new Error(error);
                });
        }
        const addCss = (url, folder = null) => {
            let link = document.createElement("link");
            link.rel = "stylesheet";
            link.type = "text/css";
            link.href = folder ? url : themeFolder + url;
            document.querySelector("head").appendChild(link);
            return "Added";
        };
        // loadFileJs("assets/js/notification/index.js");
        loadFileJs("src/components/loket/index.js");
        loadFileJs("src/components/next/index.js");


        /**@abstract
         * !load page src
         */
        loadFileJs("src/pages/home/index.js");
    </script>



</body>

</html>