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
    <div class="card">
        <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
                <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">Daftar menu</h4>
        </div>
        <div class="card-body">
            <a href="" data-url="<?= base_url('admin/menu'); ?>" id="addMenu" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMenuModal">Add New Menu</a>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Menu</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($menu as $m) : ?>
                            <tr>
                                <th scope="row"><?= $i; ?></th>
                                <td><?= $m['menu']; ?></td>
                                <td>
                                    <a href="" data-menu="<?= $m['menu'] ?>" data-url="<?= base_url('admin/menu/edit/') . $m['id_menu']; ?>" class="badge badge-success editMenu" data-toggle="modal" data-target="#newMenuModal">edit</a>
                                    <a href="" class="delete badge badge-danger" data-toggle="modal" data-url="<?= base_url('admin/menu/delete/') . $m['id_menu']; ?>" data-target="#deletemenu">delete</a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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


    <!-- modal dan scrip code -->
    <!-- Modal -->
    <div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newMenuModalLabel">Add New Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('admin/menu'); ?>" method="post" id="formInput">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="#name" class="bmd-label-floating">Name Menu .*</label>
                            <input type="text" class="form-control" id="menu" required="true" name="menu">
                        </div>

                        <!-- <div class="form-group bmd-form-group">
                            <label for="#name" class="bmd-label-floating">Name Menu .*</label>
                            <input type="text" class="form-control" placeholder="Input" id="menu" required="true" name="menu">
                        </div> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary submit">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deletemenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Delete?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Delete" below if you are ready to Delete this .</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary deletethis" href="<?= base_url('admin/menu/delete'); ?>">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <!-- jqery required -->
    <!-- <script src="<?= $thema_folder ?>assets/js/plugins/jquery.validate.min.js"></script> -->
    <script src="<?= $thema_folder ?>assets/js/plugins/jquery.validate.min.js"></script>

    <script>
        $('a#addMenu').on('click', function() {
            const url_add = $(this).data('url');
            $('#formInput').attr('action', url_add).parent().find("#newMenuModalLabel").html('Add Menu');
            $('#formInput').find("button.submit").html('Add Menu');
            $('#formInput').find("#menu").val('').parent().removeClass('is-filled');
        });
        $('.delete').on('click', function() {
            const url_delete = $(this).data('url');
            $('.deletethis').attr('href', url_delete);
        });

        $('.editMenu').each(function(index) {
            $(this).on('click', function() {
                const val_menu = $(this).data('menu');
                const url_edit = $(this).data('url');
                $('#formInput').attr('action', url_edit).parent().find("#newMenuModalLabel").html('Edit Menu');
                $('#formInput').find("button.submit").html('Edit Menu');
                $('#formInput').find("#menu").val(val_menu).parent().addClass('is-filled');
            });
        })


        // validate modal
        $(function() {
            $("#formInput").validate({
                rules: {
                    menu: {
                        required: true,
                        minlength: 4
                    },
                    action: "required"
                },
                messages: {
                    pName: {
                        required: "Please enter some data",
                        minlength: "Your data must be at least 4 characters"
                    },
                    action: "Please provide some data"
                }
            });
        });
    </script>



</body>

</html>