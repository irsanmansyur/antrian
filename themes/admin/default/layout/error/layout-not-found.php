<!DOCTYPE html>
<html lang="en">
<?php $this->load->view($thema_load . 'element/template/head_meta'); ?>

<body class="off-canvas-sidebar">
	<!-- Navbar -->
	<?php $this->load->view($thema_load . 'element/template/auth/navbar'); ?>

	<!-- content -->
	<div class="wrapper wrapper-full-page">
		<div class="page-header login-page header-filter" filter-color="black" style="background-image: url('<?= $thema_folder; ?>/assets/img/background.jpg'); background-size: cover; background-position: top center;">
			<!-- Begin Page Content -->
			<div class="container-fluid mt-5">

				<!-- 404 Error Text -->
				<div class="text-center page">
					<div class="error mx-auto" data-text="403">403</div>
					<p class="lead text-gray-800 mb-5">Your page request empty</p>
					<p class="text-gray-500 mb-0">Tidak Ada Layout Tersedia</p>
					<a href="<?= base_url('user'); ?>">&larr; Back to Dashboard</a>
				</div>

			</div>
			<!-- /.container-fluid -->

			<!-- footer -->
			<?php $this->load->view($thema_load . 'element/template/auth/footer'); ?>
		</div>
		<!-- End of Main Content -->
	</div>
	<!-- End of Content Wrapper -->

	<!-- end isi -->

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