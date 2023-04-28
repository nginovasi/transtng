<!DOCTYPE html>
<html lang="en">

<head>
	<base href="../../../../">
	<meta charset="utf-8" />
	<title>Reset Password | Trans Tangerang</title>
	<meta name="description" content="Reset Password Trans Tangerang" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<!-- style -->
	<!-- endbuild -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<!--end::Fonts-->
	<link href="<?= base_url() ?>/assets/css/style.bundle.min.css" rel="stylesheet" type="text/css" />
	<!--end::Layout Themes-->
	<link rel="shortcut icon" href="<?= base_url() ?>/assets/img/icon.png" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="<?= base_url() ?>/assets/js/plugins.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<script src="https://accounts.google.com/gsi/client" async defer></script>

</head>
<style type="text/css">
	#buttonDiv {
		display: flex;
		justify-content: center;
		align-items: center;
		margin-top: 20px;
		width: 100%;
	}

	.ngi {
		width: 100%;
		text-align: center;
		margin-bottom: 10px;
	}

	.embuh {
		width: 100%;
		text-align: center;
		margin-bottom: 10px;
	}
</style>

<body class="body" style="background-image: url(https://simpelpol.id/assets/img/bg-3.jpg);background-position: center; background-size: 50%;">

	<div class="d-flex flex-column flex-root">
		<!--begin::Login-->
		<div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
			<div class="d-flex flex-center flex-row-fluid t" style="">
				<div class="login-form text-center p-7 position-relative overflow-hidden">
					<!--begin::Login Header-->
					<div class="d-flex flex-center mb-3">
						<a href="<?= base_url() ?>">
							<img src="<?= base_url() ?>/assets/img/icon.png" alt="" style="width: 50%; height: auto" />
						</a>
					</div>
					<!--end::Login Header-->
					<!--begin::Login Sign in form-->
					<div class="login-signin">
						<div class="mb-10">
							<h3>Halaman Ganti Password</h3>
							<div class="text-muted font-weight-bold">Silahkan masukan password menggunakan akun terdaftar anda</div>
						</div>
						<form class="form" id="form1" action="" class="sign-in-form" method="post" enctype="multipart/form-data" autocomplete="off">
							<?= csrf_field() ?>
							<div class="form-group mb-5">
								<input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="current-password" name="current-password" id="current-password" />
							</div>
							<div class="form-group mb-5">
								<input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="New Password" name="new-password" id="new-password" />
							</div>
							<div class="form-group mb-5">
								<input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Confirm Password" name="confirm-password" id="confirm-password" />
							</div>
							<button id="kt_login_signin_submit" class="btn btn-primary font-weight-bold btn-block" style="background-color: #224DDD; border-color: #224DDD; margin-top: 40px; height: 48px;">Ganti</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
	$(document).ready(function() {
		$("#form1").submit(function(event) {
			event.preventDefault();
			var $form = $(this);
			Swal.fire({
				title: "",
				icon: "info",
				text: "Mohon ditunggu...",
				onOpen: function() {
					Swal.showLoading()
				}
			});
			var url = '<?= base_url() ?>/auth/action/changePassword';
			$.post(url, $form.serialize(), function(data) {
				var ret = $.parseJSON(data);
				swal.close();
				if (ret.success) {
					Swal.fire({
						title: ret.title,
						text: ret.text,
						icon: 'success',
						showConfirmButton: false,
						timer: 2500
					});
					setTimeout(function() {
						window.location = "<?= base_url() ?>/auth";
					}, 2500);
				} else {
					Swal.fire({
						title: ret.title,
						text: ret.text,
						icon: 'warning',
						showConfirmButton: false,
						timer: 2500
					});
				}
			}).fail(function(data) {
				swal.close();
				Swal.fire({
					title: 'Error',
					text: '404 Halaman Tidak Ditemukan',
					icon: 'error',
					showConfirmButton: false,
					timer: 2500
				});
			});
		})

		$('#current-password').keyup(function() {
			var value = $(this).val();
			clearTimeout($(this).data('timeout'));
			$(this).data('timeout', setTimeout(function() {
				$.ajax({
					url: '<?= base_url() ?>/auth/action/checkpassword',
					type: 'post',
					dataType: 'json',
					data: {
						'<?= csrf_token() ?>': '<?= csrf_hash() ?>',
						'pass': value
					},
					success: function(result) {
						if (result.success) {
							$('.ngi').html('<i class="fa fa-check" style="color: green"></i>');
						} else {
							$('.ngi').html('<i class="fa fa-times" style="color: red"></i>');
						}
					}
				});
			}, 500));
		});
	});
</script>
</html>