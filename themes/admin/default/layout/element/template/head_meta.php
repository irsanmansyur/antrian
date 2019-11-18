<head>
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

    <!-- font -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link href="<?= $thema_folder; ?>assets/vendor/materialicon/material-icons.css" rel="stylesheet" />
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
    <?php
    if (@$page['method'] == "edit") : ?>
        <!-- summernote -->
        <link rel="stylesheet" href="<?= $thema_folder; ?>assets/vendor/summernote/summernote-bs4.css">
        <script src="<?= $thema_folder; ?>assets/vendor/summernote/summernote-bs4.min.js"></script>
    <?php endif; ?>

</head>