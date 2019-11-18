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
            <h4 class="card-title">Daftar Sub menu</h4>
        </div>
        <div class="card-body">
            <a href="" class="btn btn-primary mb-3" id="addSubmenu" data-toggle="modal" data-url="" <?= base_url('admin/menu/submenu'); ?>" data-target="#newSubMenuModal">Add New Submenu</a>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Menu</th>
                            <th scope="col">Url</th>
                            <th scope="col">Icon</th>
                            <th scope="col">Active</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($subMenu as $sm) : ?>
                            <tr>
                                <th scope="row"><?= $i; ?></th>
                                <td><?= $sm['title']; ?></td>
                                <td><?= $sm['menu']; ?></td>
                                <td><?= $sm['url']; ?></td>
                                <td><?= $sm['icon']; ?></td>
                                <td><?= $sm['is_active']; ?></td>
                                <td>
                                    <a href="" class="badge badge-success editSubmenu" data-toggle="modal" data-target="#newSubMenuModal" data-title="<?= $sm['title']; ?>" data-iconid="<?= $sm['icon_id'] ?>" data-class="<?= $sm['class']; ?>" data-method="<?= $sm['method']; ?>" data-isactive="<?= $sm['is_active']; ?>" data-suburl="<?= $sm['url'] ?>" data-url="<?= base_url('admin/menu/editsubmenu/') . $sm['id']; ?>" data-menuid="<?= $sm['menu_id']; ?>">edit</a>

                                    <a href="<?= base_url('admin/menu/deletesubmenu/') . $sm['id']; ?>" data-toggle="modal" data-url="<?= base_url('admin/menu/deletesubmenu/') . $sm['id']; ?>" data-target="#deletemenu" class="delete badge badge-danger">delete</a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- /.container-fluid -->

    <!-- End of Main Content -->

    <!-- Modal -->

    <!-- end content -->

    <?php
    $this->load->view($thema_load . 'element/template/footer.php');
    ?>
    <?php
    $this->load->view($thema_load . 'element/template/fixed-setting.php');
    ?>

    <!-- modal dan script -->
    <!-- Modal -->
    <div class="modal fade" id="newSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newSubMenuModalLabel">Add New Sub Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('admin/menu/submenu'); ?>" method="post" id="formInput">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Submenu title">
                        </div>
                        <div class="row my-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="#class" class="bmd-label-floating">Class .*</label>
                                    <input type="text" class="form-control" id="class" required="true" name="class">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="#method" class="bmd-label-floating">method .*</label>
                                    <input type="text" class="form-control" id="method" required="true" name="method">
                                </div>
                            </div>
                        </div>


                        <div class="form-group row mt-3 mb-5">
                            <select name="menu_id" id="menu_id" class="form-control">
                                <option value="">Select Menu</option>
                                <?php foreach ($menu as $m) : ?>
                                    <option value="<?= $m['id_menu']; ?>"><?= $m['menu']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="url" name="url" placeholder="Submenu url">
                        </div>
                        <div class="form-group bmd-form-group my-3">
                            <div for="#icon" class="">Icon Sub Menu</div>
                            <?php
                            foreach ($this->db->get('tbl_icons')->result_array() as $icon) : ?>
                                <div class="icon icon-container mb-2">
                                    <div class="icon-container-inner">
                                        <div class='icon-preview '>
                                            <?= $icon['code']; ?>
                                        </div>
                                        <div class="icon-text"><input type="radio" id="icon" name="icon" value='<?= htmlspecialchars($icon["id"]); ?>' class="d-none" /><?= $icon['name'] ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class=" form-group">
                            <div class="form-check">
                                <div class="togglebutton">
                                    <label>
                                        <input type="checkbox" checked="" value="1" name="is_active" id="is_active">
                                        <span class="toggle"></span>
                                        Is Active ?
                                    </label>
                                </div>
                            </div>
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

    <div class="modal fade" id="deletemenu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Delete?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Harap berhati hati dalam menghapus submenu, karna tidak dapat di kembalikan kecuali membuat sub menu kembali.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary deletethis" href="">Delete</a>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= $thema_folder ?>assets/js/plugins/jquery.validate.min.js"></script>

    <script>
        const icon = $('.icon-container');

        const ceklist = $('input[name=icon]');
        icon.each(function(index) {
            $(this).click(function() {
                icon.removeClass('active');
                ceklist.removeAttr('checked');
                $(this).find('input[type=radio]').attr('checked', 'checked');
                $(this).addClass("active");
            })
        });
        $('.delete').on('click', function() {
            const url_delete = $(this).data('url');
            $('.deletethis').attr('href', url_delete);
        });
        // add submenu
        $('#addSubmenu').click(function() {

            $('#formInput').attr('action', $(this).data('url')).parent().find("#newSubMenuModalLabel").html('Add Submenu');
            $('#formInput').find("button.submit").html('Edit Sub Menu');
            $('#formInput').find("#title").val('').parent().removeClass('is-filled');
            $('#formInput').find("#class").val('').parent().removeClass('is-filled');
            $('#formInput').find("#method").val('').parent().removeClass('is-filled');
            $('#formInput').find("#url").val('').parent().removeClass('is-filled');
            $('#formInput').find('option[value=""]').attr('selected', true);
            $('#formInput').find('.submit').html('Add');
            icon.each(function(index) {
                $(this).removeClass("active").find('input[type=radio]').removeAttr('checked');
            });
        });
        // edit modal
        $('.editSubmenu').each(function(index) {
            $(this).click(function() {
                const val_title = $(this).data('title');
                const val_class = $(this).data('class');
                const val_method = $(this).data('method');
                const val_urlEdit = $(this).data('url');
                const val_menu_id = $(this).data('menuid');
                const val_icon = $(this).data('iconid');
                const val_is_active = $(this).data('isactive');
                const val_submurl = $(this).data('suburl');
                $('#formInput').attr('action', val_urlEdit).parent().find("#newSubMenuModalLabel").html('Edit Submenu');
                $('#formInput').find("button.submit").html('Edit Sub Menu');
                $('#formInput').find("#title").val(val_title).parent().addClass('is-filled');
                $('#formInput').find("#class").val(val_class).parent().addClass('is-filled');
                $('#formInput').find("#method").val(val_method).parent().addClass('is-filled');
                $('#formInput').find("#url").val(val_submurl).parent().addClass('is-filled');
                $('#formInput').find('option[value=' + val_menu_id + ']').attr('selected', true);
                $('#formInput').find('.submit').html('Update');
                icon.each(function(index) {
                    var id_icon = $(this).find('input[type=radio]').val();
                    if (id_icon == val_icon) {
                        $(this).addClass("active").find('input[type=radio]').attr('checked', 'checked');
                    }
                });

            })
        })
        // valdiasi
        // validate modal
        $(function() {
            $("#formInput").validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 5
                    },
                    class: "required",
                    method: "required",
                    menu_id: "required",
                    icon: "required"
                },
                messages: {
                    class: {
                        required: "Please enter some data",
                            minlength: "Your data must be at least 2 characters"
                    }
                }
            });
        });
    </script>


</body>

</html>