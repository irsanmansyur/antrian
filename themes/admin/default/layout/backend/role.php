<!DOCTYPE html>
<html lang="en">
<?php
$this->load->view($thema_load . 'element/template/head_meta.php');
?>

<body class="">
    <!-- sidebar   -->
    <?php $this->load->view($thema_load . 'element/template/sidebar.php'); ?>
    <!-- end sidebar -->

    <?php
    $this->load->view($thema_load . 'element/template/navbar.php');
    ?>
    <!-- content -->
    <!-- isi content -->
    <div class="card">
        <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
                <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">Daftar menu</h4>
        </div>
        <div class="card-body">
            <a href="" class="btn btn-primary mb-3" data-url="<?= base_url('admin/admin/role') ?>" data-toggle="modal" id="addRole" data-target="#newRoleModal">Add New Role</a>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Role</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($role as $r) : ?>
                            <tr>
                                <th scope="row"><?= $i; ?></th>
                                <td><?= $r['name']; ?></td>
                                <td>
                                    <a href="<?= base_url('admin/admin/roleaccess/') . $r['id']; ?>" class="badge badge-warning">access</a>
                                    <a href="" data-toggle="modal" data-target="#newRoleModal" data-url="<?= base_url('admin/admin/roleedit/') . $r['id']; ?>" data-role="<?= $r['name']; ?>" class="badge badge-success editRole">edit</a>
                                    <a data-toggle="modal" data-target="#deleteRole" data-url="<?= base_url('admin/admin/roledelete/') . $r['id']; ?>" class="badge badge-danger delete">delete</a>
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

    <!-- Modal -->
    <div class="modal fade" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newRoleModalLabel">Add New Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('admin/admin/role_add'); ?>" method="post" id="formInput">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="role" name="role" placeholder="Role name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary submit">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

    <script src="<?= $thema_folder ?>assets/js/plugins/jquery.validate.min.js"></script>

    <script>
        $('a#addRole').on('click', function() {
            const url_add = $(this).data('url');
            $('#formInput').attr('action', url_add).parent().find("#newRoleModalLabel").html('Add Role');
            $('#formInput').find("button.submit").html('Add Role');
            $('#formInput').find("#role").val('').parent().removeClass('is-filled');
        });

        $('.delete').on('click', function() {
            console.log('delete');
            const url_delete = $(this).data('url');
            $('.deletethis').attr('href', url_delete);
        });


        $('.editRole').each(function(index) {
            $(this).on('click', function() {
                const val_role = $(this).data('role');
                const url_edit = $(this).data('url');
                $('#formInput').attr('action', url_edit).parent().find("#newRoleModalLabel").html('Edit Role');
                $('#formInput').find("button.submit").html('Edit Role');
                $('#formInput').find("#role").val(val_role).parent().addClass('is-filled');
            });
        })


        // validate modal
        $(function() {
            $("#formInput").validate({
                rules: {
                    role: {
                        required: true,
                        minlength: 4
                    }
                }
            });
        });
    </script>

</body>

</html>