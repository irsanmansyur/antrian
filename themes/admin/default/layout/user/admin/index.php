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
        <div class="card-header card-header-rose card-header-icon">
            <div class="card-icon">
                <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">Daftar User</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>nip</th>
                            <th>name</th>
                            <th>email</th>
                            <th>alamat</th>
                            <th>date_created</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>no</th>
                            <th>nip</th>
                            <th>name</th>
                            <th>email</th>
                            <th>alamat</th>
                            <th>date_created</th>
                            <th>action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <script src="<?= $thema_folder; ?>assets/js/plugins/jquery.dataTables.min.js"></script>
    <script>
        var table;

        $(document).ready(function() {

            //datatables
            table = $('#datatables').DataTable({

                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.

                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo base_url('admin/admin/getAllUser') ?>",
                    "type": "POST",
                    "data": function(data) {
                        // data.country = $('#country').val();
                        // data.FirstName = $('#FirstName').val();
                        // data.LastName = $('#LastName').val();
                        // data.address = $('#address').val();
                    }
                },

                //Set column definition initialisation properties.
                "columnDefs": [{
                    "targets": [0], //first column / numbering column
                    "orderable": false, //set not orderable
                }, ],

            });
        });
    </script>
    <!-- end content -->

    <?php
    $this->load->view($thema_load . 'element/template/footer.php');
    ?>
    <?php
    $this->load->view($thema_load . 'element/template/fixed-setting.php');
    ?>

</body>

</html>