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
  <div class="col-md-6 offset-md-3">
    <div class="card ">
      <form method="post" action="<?= base_url('admin/antrian/pin') ?>">
        <div class="card-header card-header-rose card-header-icon">
          <div class="card-icon">
            <i class="material-icons">mail_outline</i>
          </div>
          <h4 class="card-title">Masukkan Pin</h4>
        </div>
        <div class="card-body ">
          <div class="form-group bmd-form-group">
            <label for="pin" class="bmd-label-floating">Insert PIN</label>
            <input type="text" name="pin" class="form-control" id="pin">
          </div>
        </div>
        <div class="card-footer ">
          <button type="submit" class="btn btn-fill btn-rose">Submit</button>
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


  <script>
    var a = `
    <div class="col-md-6 text-center">
        <div class="antrian-active" style="padding-top:20px;padding-bottom:20px;">
          <h1>Loket ${data['loket'][i].client}</h1>`;
    if (data['loket'][i].status == 1) {
      a += `<button cass='btn btn-primary' btn-lg' type='button'><span class='fa fa-university'>&nbsp;</span> Antrian ${data['antrian'][i].id}</button>`;
    } else if (data['loket'][i].status == 0) {
      a += `<button class='btn btn-light' btn-lg' type='button'><span class='fa fa-university'>&nbsp;</span> TUTUP</button>`;
    } else {
      a += `<button class='btn btn-warning' btn-lg' type='button'><span class='fa fa-university'>&nbsp;</span>OPEN</button>`;
    }
    a += `</div> </div>`;
  </script>


</body>

</html>