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

    <!-- <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css"> -->
    <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
    <!-- isi content -->
    <div class="row">
        <div class="col-md-4">
            <div class="card card-chart" data-count="7">
                <div class="card-header card-header-rose" data-header-animation="true">
                    <div class="ct-chart" id="websiteViewsChart">
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-actions">
                        <button type="button" class="btn btn-danger btn-link fix-broken-card">
                            <i class="material-icons">build</i> Fix Header!
                        </button>
                        <button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="" data-original-title="Refresh">
                            <i class="material-icons">refresh</i>
                        </button>
                        <button type="button" class="btn btn-default btn-link" rel="tooltip" data-placement="bottom" title="" data-original-title="Change Date" aria-describedby="tooltip540895">
                            <i class="material-icons">edit</i>
                            <div class="ripple-container"></div>
                        </button>
                    </div>
                    <h4 class="card-title">Website Views</h4>
                    <p class="card-category">Last Campaign Performance</p>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">access_time</i> campaign sent 2 days ago
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end isi -->
    <script>
        new Chartist.Line('#websiteViewsChart', {
            labels: [1, 2, 3, 4, 5, 6, 7, 8],
            series: [
                [5, 9, 7, 8, 5, 3, 5, 4]
            ]
        }, {
            low: 0,
            showArea: true
        });
    </script>

    <?php
    $this->load->view($thema_load . 'element/template/footer.php');
    ?>
    <?php
    $this->load->view($thema_load . 'element/template/fixed-setting.php');
    ?>

</body>

</html>