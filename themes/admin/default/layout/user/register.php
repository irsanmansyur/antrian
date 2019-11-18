<!DOCTYPE html>
<html lang="en">
<?php $this->load->view($thema_load . 'element/template/head_meta'); ?>

<body class="off-canvas-sidebar">
    <!-- Navbar -->
    <?php $this->load->view($thema_load . 'element/template/auth/navbar'); ?>
    <!-- End Navbar -->

    <!-- content -->
    <div class="wrapper wrapper-full-page">
        <div class="page-header login-page header-filter bg-img" filter-color="black" style="background-image: url('<?= $thema_folder; ?>/assets/img/login.jpg')">
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
            <div class="container">
                <div class="row">
                    <div class="col-md-8  ml-auto mr-auto">
                        <form action="<?= base_url('admin/auth/registration'); ?>" enctype="multipart/form-data" method="post" id="formInput">
                            <div class="card  card-hidden">
                                <div class="card-header card-header-rose card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">
                                            group_add
                                        </i>
                                    </div>
                                    <h4 class="card-title">Form Registrasi</h4>
                                </div>

                                <div class="card-body ">
                                    <?= $this->session->flashdata('message'); ?>

                                    <div class="form-row">
                                        <div class="col-md-4 ml-auto">
                                            <div class="text-center">
                                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail img-circle">
                                                        <img src="<?= getProfile('dddd') ?>" alt="">
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
                                                    <div>
                                                        <span class="btn btn-round btn-rose btn-file">
                                                            <span class="fileinput-new">Add Photo</span>
                                                            <span class="fileinput-exists">Change</span>
                                                            <input type="file" name="image" />
                                                        </span>
                                                        <br />
                                                        <a href="#" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i>Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-row">
                                                <div class="form-group col-md-7">
                                                    <label for="name" class="bmd-label-floating ml-1">Name</label>
                                                    <input type="text" class="form-control" id="name" name="name" value="<?= set_value('name'); ?>">
                                                    <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="email" class="bmd-label-floating ml-1 ml-1">email</label>
                                                    <input type="text" class="form-control" id="email" name="email" value="<?= set_value('email'); ?>">
                                                    <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6 ml-auto">
                                                    <label for="no_hp" class="bmd-label-floating ml-1">no_hp</label>
                                                    <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= set_value('no_hp'); ?>">
                                                    <?= form_error('no_hp', '<small class="text-danger">', '</small>'); ?>
                                                </div>
                                                <div class="form-group col-md-6 ml-auto">
                                                    <label for="tgl_lahir" class="bmd-label-floating ml-1">Tgl Lahir</label>
                                                    <input type="text" class="form-control datepicker" id="tgl_lahir" name="tgl_lahir" value="<?= (set_value('tgl_lahir') != null) ? set_value('tgl_lahir') : date('m-d-1990'); ?>">
                                                    <?= form_error('tgl_lahir', '<small class="text-danger">', '</small>'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="password" class="bmd-label-floating ml-1">password</label>
                                            <input type="password" class="form-control" id="password" name="password">
                                            <?= form_error('password', '<small class="text-danger">', '</small>'); ?>

                                        </div>
                                        <div class="form-group col-md-5 ml-auto">
                                            <label for="password_confirm" class="bmd-label-floating ml-1">password_confirm</label>
                                            <input type="password" class="form-control" id="password_confirm" name="password_confirm">
                                            <?= form_error('password_confirm', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="alamat" class="bmd-label-floating ml-1">alamat</label>
                                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?= set_value('alamat'); ?>">
                                            <?= form_error('alamat', '<small class="text-danger">', '</small>'); ?>
                                        </div>
                                    </div>
                                    <div class="card-footer float-right">
                                        <button type="submit" class="btn btn-fill btn-rose" name="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- footer -->
            <?php $this->load->view($thema_load . 'element/template/auth/footer'); ?>
        </div>
    </div>

    <script src="<?= $thema_folder; ?>assets/js/plugins/moment.min.js"></script>
    <script src="<?= $thema_folder; ?>assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
    <script src="<?= $thema_folder ?>assets/js/plugins/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            // initialise Datetimepicker and Sliders
            md.initFormExtendedDatetimepickers();
            if ($('.slider').length != 0) {
                md.initSliders();
            }
            // md.checkFullPageBackgroundImage();
            setTimeout(function() {
                // after 1000 ms we add the class animated to the login/register card
                $('.card').removeClass('card-hidden');
            }, 700);


        });
        $(function() {
            $("#formInput").validate({
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                rules: {
                    name: {
                        required: true,
                        minlength: 5
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    no_hp: "required",
                    alamat: "required",
                    icon: "required"
                },
                messages: {

                }
            });
        });
    </script>
</body>

</html>