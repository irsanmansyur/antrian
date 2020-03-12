<head>
    <!-- css vue , component dan animate -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/animate.css@3.5.1" rel="stylesheet" />

    <!-- pusher js -->
    <script src="https://js.pusher.com/5.1/pusher.min.js"></script>

    <!-- vue component dan Vue -->
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>

    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="<?= $thema_folder; ?>assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="<?= $thema_folder; ?>assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        <?= @$page['title'] ?>
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

    <!--  Social tags      -->
    <meta name="keywords" content="<?= @$meta_keyword; ?>">
    <meta name="description" content="<?= @$meta_description; ?>">

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="<?= @$page['title']; ?>">
    <meta itemprop="description" content="<?= @$meta_description; ?>">
    <meta itemprop="image" content="<?= @$meta_image; ?>">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="<?= @$page_type; ?>">
    <meta name="twitter:site" content="<?= @$page_site; ?>">
    <meta name="twitter:title" content="<?= @$title_page; ?>">
    <meta name="twitter:description" content="<?= @$meta_description; ?>">
    <meta name="twitter:creator" content="<?= @$site_name; ?>">
    <meta name="twitter:image" content="<?= @$meta_image; ?>">
    <!-- Open Graph data -->
    <meta property="fb:app_id" content="<?= @$meta_fb_id; ?>">
    <meta property="og:title" content="<?= @$page['title']; ?>" />
    <meta property="og:type" content="<?= @$page_type; ?>" />
    <meta property="og:url" content="<?= @$meta_url; ?>" />
    <meta property="og:image" content="<?= @$meta_image; ?>" />
    <meta property="og:description" content="<?= @$meta_description; ?>" />
    <meta property="og:site_name" content="<?= @$site_name; ?>" />
    <!--     Fonts and icons     -->


    <!-- CSS Files -->
    <link href="<?= $thema_folder; ?>assets/css/material-dashboard.min.css" rel="stylesheet" />


    <link href="<?= $thema_folder; ?>assets/vendor/fontawesome/css/all.min.css" rel="stylesheet" />
    <link href="<?= $thema_folder; ?>assets/css/style.css" rel="stylesheet" />
    <link href="<?= $thema_folder; ?>assets/css/profile/profile.css" rel="stylesheet" />

    <!-- js -->
    <script src="<?= $thema_folder; ?>assets/js/core/jquery.min.js"></script>
    <script src="<?= $thema_folder; ?>assets/js/core/popper.min.js"></script>
    <script src="<?= $thema_folder; ?>assets/js/core/bootstrap-material-design.min.js"></script>
    <script src="<?= $thema_folder; ?>assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="<?= $thema_folder ?>assets/js/plugins/bootstrap-notify.js"></script>
    <script src="<?= $thema_folder ?>assets/js/main.js"></script>
    <script>
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
    </script>

</head>