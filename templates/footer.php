<!--footer-->
<footer class="bg-dark text-white mt-3">
	<div class="container-fluid padding">
		<div class="row text-center">
			<div class="col-md-4 mt-2">
				<a class="navbar-brand" href="<?=Helper::getHomeLink()?>">
					<img src="<?= FILE_PATH['logo'] ?>" alt="Logo" class="d-inline-block align-text-top" width="30" height="30"> <?= LOGO_TEXT ?>
				</a>
				<hr class="bg-light mt-4">

			</div>

			<div class="col-md-4">
				<hr class="bg-light">
				<h5>Useful links</h5>
				<hr class="bg-light">
				<?php if (Helper::studentIsLoggedIn()) : ?>

					<p><a href="<?= FILE_PATH['dashboard'] ?>">Dashboard</a></p>
					<p><a href="<?= FILE_PATH['calendar'] ?>">Calendar</a></p>
					<p><a href="<?= FILE_PATH['coursework'] ?>">Coursework</a></p>
					<p><a href="<?= FILE_PATH['modulesAndTeachers'] ?>">Modules & Teachers</a></p>
				<?php elseif ((Helper::adminIsLoggedIn())) : ?>
					<p><a href="<?= FILE_PATH['admin_dashboard'] ?>">Dashboard</a></p>

				<?php else : ?>
					<p><a href="index.php">Home</a></p>
					<p><a href="login.php">Login</a></p>
					<p><a href="register.php">Register</a></p>
					<p><a href="terms_and_conditions.php">Terms & conditions and privacy policy</a></p>
				<?php endif; ?>
			</div>
		</div>
		<div class="col-12 text-center">
			<hr>
			
			<h5 id="copyrightInfo">&copy; <?= LOGO_TEXT ?> 2021 – <?= date("Y") ?></h5>
		</div>
	</div>
</footer>

<!-- Bootstrap 5 Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<!-- JQuery required for AJAX to work -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- JQuery UI -->
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<!-- moment js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<!-- full-Calendar js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>

<!-- Time-Picker -->
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<!-- input mask -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8-beta.1/jquery.inputmask.min.js"></script>
<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
<!-- Sweet-Alert-2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Chart js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
<!-- Data-table js -->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.4/datatables.min.js"></script>
<!-- flat-picker js -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<!-- custom js -->
<script src="<?= FILE_PATH['script'] ?>"></script>
</body>

</html>