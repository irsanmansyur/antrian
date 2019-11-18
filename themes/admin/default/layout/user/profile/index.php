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
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-profile">
                    <div class="card-avatar">
                        <a href="#pablo" id="changePhoto">
                            <img class="img" src="<?= getProfile($user['image'], 'thumbnail') ?>">
                        </a>
                    </div>
                    <div class="card-body">
                        <h6 class="card-category text-gray"><?= $user['role_name'] ?></h6>
                        <h4 class="card-title"><?= $user['name'] ?></h4>
                        <p class="card-description">
                            <?= $user['tentang_saya'] ?>.
                        </p>

                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header card-header-icon card-header-rose">
                        <div class="card-icon">
                            <i class="material-icons">perm_identity</i>
                        </div>
                        <h4 class="card-title">Edit Profile -
                            <small class="category">Complete your profile</small>
                        </h4>
                    </div>
                    <div class="card-body">
                        <?php echo form_open_multipart(base_url('admin/user/profile')); ?>
                        <div class="row">
                            <input type="file" name="image" id="imagechange" class="d-none" />
                            <div class="col-md-12">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Full Name</label>
                                    <input type="text" class="form-control" name="name" value="<?= $user['name'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Email address</label>
                                    <input type="email" name="email" readonly class="form-control" value="<?= $user['email'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group bmd-form-group">
                                    <label for="tgl_lahir" class="bmd-label-floating ml-1">Tgl Lahir</label>
                                    <input type="text" class="form-control datepicker" id="tgl_lahir" name="tgl_lahir" value="<?= date('m-d-Y', $user['tgl_lahir']); ?>">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">No Hp</label>
                                    <input type="text" class="form-control" name="no_hp" value="<?= $user['no_hp'] ?>">
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Adress</label>
                                    <input type="text" class="form-control" name="alamat" value="<?= $user['alamat'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>About Me</label>
                                    <div class="form-group bmd-form-group">
                                        <label class="bmd-label-floating"> Tulis sesuatu tentang dirimi.</label>
                                        <textarea class="form-control" rows="5" name="tentang_saya"><?= $user['tentang_saya'] ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-rose pull-right">Update Profile</button>
                        <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- end content -->

    <?php
    $this->load->view($thema_load . 'element/template/footer.php');
    ?>
    <?php
    $this->load->view($thema_load . 'element/template/fixed-setting.php');
    ?>


    <script src="<?= $thema_folder; ?>assets/js/plugins/moment.min.js"></script>
    <script src="<?= $thema_folder; ?>assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
    <script>
        // initialise Datetimepicker and Sliders
        md.initFormExtendedDatetimepickers();
        if ($('.slider').length != 0) {
            md.initSliders();
        }


        // scrip ganti gambar
        $("#changePhoto").click(function() {
            $('input#imagechange').click();
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#changePhoto').find('.img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $('input#imagechange').change(function() {
            readURL(this);
        });
    </script>
</body>

</html>