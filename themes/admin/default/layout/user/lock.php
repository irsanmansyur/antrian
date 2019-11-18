<!DOCTYPE html>
<html lang="en">
<?php $this->load->view($thema_load . 'element/template/head_meta'); ?>

<body class="off-canvas-sidebar">
    <!-- Navbar -->
    <?php $this->load->view($thema_load . 'element/template/auth/navbar'); ?>

    <!-- content -->
    <div class="wrapper wrapper-full-page">
        <div class="page-header register-page header-filter" filter-color="black" style="background-image: url('<?= $thema_folder ?>assets/img/register.jpg')">

            <div class="container">
                <div class="row">
                    <div class="col-md-4 ml-auto mr-auto">
                        <div class="card card-profile text-center">
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

                                <form class="form" method="post" action="<?= @$form['action'] ?>">
                                    <input type="hidden" class="form-control" placeholder="Password..." name="email" value="<?= $user['email'] ?>">
                                    <div class="bmd-form-group">
                                        <div class="input-group">
                                            <label for="#password" class="bmd-label-floating">Enter Password</label>
                                            <input type="password" id="password" class="form-control" name="password">
                                        </div>
                                        <?= form_error('password', '<label id="min-error" class="error" for="password">', '</label>'); ?>
                                    </div>
                                    <input type="submit" class="btn btn-rose btn-round" value="Unlock!">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <!-- end content -->

    <!-- !-- footer --> -->
    <?php $this->load->view($thema_load . 'element/template/auth/footer'); ?>
    <script>
        $(document).ready(function() {
            // md.checkFullPageBackgroundImage();
            setTimeout(function() {
                // after 1000 ms we add the class animated to the login/register card
                $('.card').removeClass('card-hidden');
            }, 700);
        });
    </script>
</body>

</html>