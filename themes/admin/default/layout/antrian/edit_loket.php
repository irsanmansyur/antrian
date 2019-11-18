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
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <form action="<?= base_url('admin/antrian/editloket/') . $loket['id']; ?>" method="post">
        <div class="modal-body">
          <div class="form-group">
            <input class="form-control" type="number" value="<?= $loket['client'] ?>" id="example-number-input" name="client">
          </div>
          <div class=" form-group">
            <div class="form-check">
              <div class="togglebutton">
                <label>
                  <input type="checkbox" <?= ($loket['status'] == 1) ? 'checked' : '' ?>" value="1" name="status" id="is_active">
                  <span class="toggle"></span>
                  Is Active ?
                </label>
              </div>
            </div>
            <div class="form-group">
              <input class="btn btn-primary" type="submit" value="Ganti" />
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php
  $this->load->view($thema_load . 'element/template/footer.php');
  ?>
  <?php
  $this->load->view($thema_load . 'element/template/fixed-setting.php');
  ?>

</body>

</html>