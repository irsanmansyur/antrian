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
    <div class="col-md-4 ml-auto mr-auto">
        <div class="card card-profile">
            <div class="card-header ">
                <div class="card-avatar">
                    <a href="#<?= $user['image'] ?>">
                        <img class="img" src="<?= getProfile($user['image'], 'thumbnail'); ?>">
                    </a>
                </div>
            </div>

            <div class="card-body">

                <h4 class="card-title"><?= $user['name'] ?></h4>
                <?= $this->session->flashdata('message'); ?>

                <form class="form text-left" id="formInput" method="post" action="<?= base_url('admin/user/changepassword') ?>">
                    <div class="form-group">
                        <label for="#oldPassword" class="bmd-label-floating">Password Lama</label>
                        <input type="password" id="oldPassword" class="form-control" name="oldPassword">
                    </div>
                    <br>
                    <p>Masukkan Password Baru Anda</p>
                    <div class="form-group">
                        <label for="#newPassword" class="bmd-label-floating">Password baru</label>
                        <input type="password" id="newPassword" class="form-control" name="newPassword">
                    </div>
                    <div class="form-group">
                        <label for="#password" class="bmd-label-floating">Password Lama</label>
                        <input type="password" id="password" class="form-control" name="password">
                    </div>
                    <div class="d-flex justify-content-center">
                        <input type="submit" class="btn btn-rose btn-round " value="Ganti!">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end isi -->

    <?php
    $this->load->view($thema_load . 'element/template/footer.php');
    ?>
    <?php
    $this->load->view($thema_load . 'element/template/fixed-setting.php');
    ?>



    <!-- jqery required -->
    <!-- <script src="<?= $thema_folder ?>assets/js/plugins/jquery.validate.min.js"></script> -->
    <script src="<?= $thema_folder ?>assets/js/plugins/jquery.validate.min.js"></script>

    <script>
        // validate modal
        $(function() {
            $("#formInput").validate({
                rules: {
                    oldPassword: {
                        required: true,
                    },
                    newPassword: {
                        required: true,
                        minlength: 3
                    },
                    password: {
                        equalTo: "#newPassword"
                    }
                }
            });
        });
    </script>



</body>

</html>