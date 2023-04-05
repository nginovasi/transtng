<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title>Halaman Login | Trans Tangerang</title>
	<meta name="description" content="Responsive, Bootstrap, BS4" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<!-- style -->
	<!-- build:css ../assets/css/site.min.css -->
	<link rel="stylesheet" href="<?= base_url() ?>/assets/css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="<?= base_url() ?>/assets/css/theme.css" type="text/css" />
	<link rel="stylesheet" href="<?= base_url() ?>/assets/css/style.css" type="text/css" />
	<!-- endbuild -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="shortcut icon" href="<?= base_url() ?>assets/img/favicon.ico"/>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<!-- <script src="https://accounts.google.com/gsi/client" async defer></script> -->
</head>

<style type="text/css">
	@charset "UTF-8";

	body {
		margin: 0;
		height: 100%;
		overflow: hidden;
		width: 100% !important;
		box-sizing: border-box;
		font-family: "Roboto", sans-serif;
	}

	.backRight {
		position: absolute;
		right: 0;
		width: 50%;
		height: 100%;
		background: #03a9f4;
	}

	.backLeft {
		position: absolute;
		left: 0;
		width: 50%;
		height: 100%;
		background: #673ab7;
	}

	#back {
		width: 100%;
		height: 100%;
		position: absolute;
		z-index: -999;
	}

	.canvas-back {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		z-index: 10;
	}

	#slideBox {
		width: 50%;
		max-height: 100%;
		height: 100%;
		overflow: hidden;
		margin-left: 50%;
		position: absolute;
		box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
	}

	.topLayer {
		width: 200%;
		height: 100%;
		position: relative;
		left: 0;
		left: -100%;
	}

	label {
		font-size: 0.8em;
		text-transform: uppercase;
	}

	input {
		background-color: transparent;
		border: 0;
		outline: 0;
		font-size: 1em;
		padding: 8px 1px;
		margin-top: 0.1em;
	}

	.left {
		width: 50%;
		height: 100%;
		overflow: scroll;
		background: #2c3034;
		left: 0;
		position: absolute;
	}

	.left label {
		color: #e3e3e3;
	}

	.left input {
		border-bottom: 1px solid #e3e3e3;
		color: #e3e3e3;
	}

	.left input:focus,
	.left input:active {
		border-color: #03a9f4;
		color: #03a9f4;
	}

	.left input:-webkit-autofill {
		-webkit-box-shadow: 0 0 0 30px #2c3034 inset;
		-webkit-text-fill-color: #e3e3e3;
	}

	.left a {
		color: #03a9f4;
	}

	.right {
		width: 50%;
		height: 100%;
		overflow: scroll;
		background: #f9f9f9;
		right: 0;
		position: absolute;
	}

	.right label {
		color: #212121;
	}

	.right input {
		border-bottom: 1px solid #212121;
	}

	.right input:focus,
	.right input:active {
		border-color: #673ab7;
	}

	.right input:-webkit-autofill {
		-webkit-box-shadow: 0 0 0 30px #f9f9f9 inset;
		-webkit-text-fill-color: #212121;
	}

	.content {
		display: flex;
		flex-direction: column;
		justify-content: center;
		min-height: 100%;
		width: 80%;
		margin: 0 auto;
		position: relative;
	}

	.content h2 {
		font-weight: 300;
		font-size: 2.6em;
		margin: 0.2em 0 0.1em;
	}

	.left .content h2 {
		color: #03a9f4;
	}

	.right .content h2 {
		color: #673ab7;
	}

	.form-element {
		margin: 1.6em 0;
	}

	.form-element.form-submit {
		margin: 1.6em 0 0;
	}

	.form-stack {
		display: flex;
		flex-direction: column;
	}

	.checkbox {
		-webkit-appearance: none;
		outline: none;
		background-color: #e3e3e3;
		border: 1px solid #e3e3e3;
		box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
		padding: 12px;
		border-radius: 4px;
		display: inline-block;
		position: relative;
	}

	.checkbox:focus,
	.checkbox:checked:focus,
	.checkbox:active,
	.checkbox:checked:active {
		border-color: #03a9f4;
		box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px 1px 3px rgba(0, 0, 0, 0.1);
	}

	.checkbox:checked {
		outline: none;
		box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05), inset 15px 10px -12px rgba(255, 255, 255, 0.1);
	}

	.checkbox:checked:after {
		outline: none;
		content: "✓";
		color: #03a9f4;
		font-size: 1.4em;
		font-weight: 900;
		position: absolute;
		top: -4px;
		left: 4px;
	}

	.form-checkbox {
		display: flex;
		align-items: center;
	}

	.form-checkbox label {
		margin: 0 6px 0;
		font-size: 0.72em;
	}

	button {
		padding: 0.8em 1.2em;
		margin: 0 10px 0 0;
		width: auto;
		font-weight: 600;
		text-transform: uppercase;
		font-size: 1em;
		color: #fff;
		line-height: 1em;
		letter-spacing: 0.6px;
		border-radius: 3px;
		box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1), 0 3px 6px rgba(0, 0, 0, 0.1);
		border: 0;
		outline: 0;
		transition: all 0.25s;
	}

	button.signup {
		background: #03a9f4;
	}

	button.login {
		background: #673ab7;
	}

	button.off {
		background: none;
		box-shadow: none;
		margin: 0;
	}

	button.off.signup {
		color: #03a9f4;
	}

	button.off.login {
		color: #673ab7;
	}

	button:focus,
	button:active,
	button:hover {
		box-shadow: 0 4px 7px rgba(0, 0, 0, 0.1), 0 3px 6px rgba(0, 0, 0, 0.1);
	}

	button:focus.signup,
	button:active.signup,
	button:hover.signup {
		background: #0288d1;
	}

	button:focus.login,
	button:active.login,
	button:hover.login {
		background: #512da8;
	}

	button:focus.off,
	button:active.off,
	button:hover.off {
		box-shadow: none;
	}

	button:focus.off.signup,
	button:active.off.signup,
	button:hover.off.signup {
		color: #03a9f4;
		background: #212121;
	}

	button:focus.off.login,
	button:active.off.login,
	button:hover.off.login {
		color: #512da8;
		background: #e3e3e3;
	}

	@media only screen and (max-width: 768px) {
		#slideBox {
			width: 80%;
			margin-left: 20%;
		}

		.signup-info,
		.login-info {
			display: none;
		}
	}
</style>

<body class="layout-row">
	<!-- <div class="d-flex flex-column flex">
            <div class="row no-gutters h-100">
                <div class="col-md-6 bg-primary" style="">
                    <div class="p-3 p-md-5 d-flex flex-column h-100">
                        <h4 class="mb-3 text-white">Dashboard Admin</h4>
                        <div class="text-fade">Trans Tangerang<br>Dinas Perhubungan Provinsi Banten</div>
                        <div class="d-flex flex align-items-center justify-content-center"></div> -->
	<!-- <div class="d-flex text-sm text-fade">
                            <a href="index.html" class="text-white">About</a>
                            <span class="flex"></span>
                            <a href="#" class="text-white mx-1">Terms</a>
                            <a href="#" class="text-white mx-1">Policy</a>
                        </div> -->
	<!-- </div>
                </div>
                <div class="col-md-6">
                    <div id="content-body">
                        <div class="p-3 p-md-5">
                            <h5>Selamat Datang</h5>
                            <p>
                                <small class="text-muted">Silahkan masuk dengan menggunakan akun anda</small>
                            </p>
                            <form id="form1" name="form1" class="sign-in-form" method="post" enctype="multipart/form-data" autocomplete="off">
                                <?= csrf_field() ?>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" placeholder="Username" id="username" name="username" required="">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" placeholder="Password" id="password" name="password" required="">
                                </div>
                                <button type="submit" class="btn btn-primary mb-4">Sign in</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
	<div id="back">
		<canvas id="canvas" class="canvas-back"></canvas>
		<div class="backRight"></div>
		<div class="backLeft"></div>
	</div>

	<div id="slideBox">
		<div class="topLayer">
			<!-- <div class="left">
				<div class="content">
					<h2>Sign Up</h2>
					<form id="form-signup" method="post" onsubmit="return false;">
						<div class="form-element form-stack">
							<label for="email" class="form-label">Email</label>
							<input id="email" type="email" name="email">
						</div>
						<div class="form-element form-stack">
							<label for="username-signup" class="form-label">Username</label>
							<input id="username-signup" type="text" name="username">
						</div>
						<div class="form-element form-stack">
							<label for="password-signup" class="form-label">Password</label>
							<input id="password-signup" type="password" name="password">
						</div>
						<div class="form-element form-checkbox">
							<input id="confirm-terms" type="checkbox" name="confirm" value="yes" class="checkbox">
							<label for="confirm-terms">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label>
						</div>
						<div class="form-element form-submit">
							<button id="signUp" class="signup" type="submit" name="signup">Sign up</button>
							<button id="goLeft" class="signup off">Log In</button>
						</div>
					</form>
				</div>
			</div> -->
			<div class="right">
				<div class="content">
					<h2>Login</h2>
					<form  class="form" id="form1" action="" class="sign-in-form" method="post" enctype="multipart/form-data" autocomplete="off">
					<?= csrf_field() ?>
						<div class="form-element form-stack">
							<label for="username-login" class="form-label">Username</label>
							<input id="username-login" type="text" name="username">
						</div>
						<div class="form-element form-stack">
							<label for="password-login" class="form-label">Password</label>
							<input id="password-login" type="password" name="password">
						</div>
						<div class="form-element form-submit">
							<button id="logIn" class="login" type="submit" name="login">Log In</button>
							<!-- <button id="goRight" class="login off" name="signup">Sign Up</button> -->
							<!-- <div class="login off row"><div class="col-lg-12"><div id="buttonDiv"></div></div></div> -->
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- build:js ../assets/js/site.min.js -->
	<!-- jQuery -->
	<script src="<?= base_url() ?>/assets/libs/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="<?= base_url() ?>/assets/libs/popper.js/dist/umd/popper.min.js"></script>
	<script src="<?= base_url() ?>/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- ajax page -->
	<script src="<?= base_url() ?>/assets/libs/pjax/pjax.min.js"></script>
	<script src="<?= base_url() ?>/assets/js/ajax.js"></script>
	<!-- lazyload plugin -->
	<script src="<?= base_url() ?>/assets/js/lazyload.config.js"></script>
	<script src="<?= base_url() ?>/assets/js/lazyload.js"></script>
	<script src="<?= base_url() ?>/assets/js/plugin.js"></script>
	<!-- scrollreveal -->
	<script src="<?= base_url() ?>/assets/libs/scrollreveal/dist/scrollreveal.min.js"></script>
	<!-- feathericon -->
	<script src="<?= base_url() ?>/assets/libs/feather-icons/dist/feather.min.js"></script>
	<script src="<?= base_url() ?>/assets/js/plugins/feathericon.js"></script>
	<!-- paper.js -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/paper.js/0.12.17/paper-full.min.js" integrity="sha512-NApOOz1j2Dz1PKsIvg1hrXLzDFd62+J0qOPIhm8wueAnk4fQdSclq6XvfzvejDs6zibSoDC+ipl1dC66m+EoSQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<!-- theme -->
	<script src="<?= base_url() ?>/assets/js/theme.js"></script>
	<script src="<?= base_url() ?>/assets/js/utils.js"></script>
	<!-- endbuild -->
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
				})

				var url = '<?= base_url() ?>/auth/action/login';

				$.post(url, $form.serialize(), function(data) {
					var ret = $.parseJSON(data);
					swal.close();
					if (ret.success) {
						window.location = "<?= base_url() ?>/main";
					} else {
						Swal.fire({
							title: ret.title,
							text: ret.text,
							icon: 'error',
							showConfirmButton: false,
							timer: 2500
						})
					}
				}).fail(function(data) {
					swal.close();
					Swal.fire({
						title: 'Error',
						text: '404 Halaman Tidak Ditemukan',
						icon: 'error',
						showConfirmButton: false,
						timer: 2500
					})
				});
			});

			$('#goRight').on('click', function() {
				$('#slideBox').animate({
					'marginLeft': '0'
				});
				$('.topLayer').animate({
					'marginLeft': '100%'
				});
			});
			$('#goLeft').on('click', function() {
				if (window.innerWidth > 769) {
					$('#slideBox').animate({
						'marginLeft': '50%'
					});
				} else {
					$('#slideBox').animate({
						'marginLeft': '20%'
					});
				}
				$('.topLayer').animate({
					'marginLeft': '0'
				});
			});

			// function handleCredentialResponse(response) {
            //     let jwt = parseJwt(response.credential)
            //     let email = jwt.email;

            //     loginWithGoogle(email);
            // }

            // function loginWithGoogle(email) {
            //     Swal.fire({
            //         title: "",
            //         icon: "info",
            //         text: "Mohon ditunggu...",
            //         onOpen: function () {
            //             Swal.showLoading()
            //         }
            //     })

            //     var url = '<?= base_url() ?>/auth/action/loginGoogle';

            //     $.post(url, {
            //         email: email,
            //         "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
            //     }, function (data) {
            //         console.log(data);
            //         var ret = $.parseJSON(data);
            //         swal.close();
            //         if (ret.success) {
            //             window.location = "<?= base_url() ?>/main";
            //         } else {
            //             Swal.fire({
            //                 title: ret.title,
            //                 text: ret.text,
            //                 icon: 'error',
            //                 showConfirmButton: false,
            //                 timer: 2500
            //             })
            //         }
            //     }).fail(function (data) {
            //         swal.close();
            //         Swal.fire({
            //             title: 'Error',
            //             text: '404 Halaman Tidak Ditemukan',
            //             icon: 'error',
            //             showConfirmButton: false,
            //             timer: 2500
            //         })
            //     });
            // }

            // function parseJwt(token) {
            //     var base64Url = token.split('.')[1];
            //     var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
            //     var jsonPayload = decodeURIComponent(window.atob(base64).split('').map(function (c) {
            //         return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
            //     }).join(''));

            //     return JSON.parse(jsonPayload);
            // };

            // window.onload = function () {
            //     google.accounts.id.initialize({
            //         client_id: "952480244845-on52q6pv8f20mnlat55ip23uddpjldsg.apps.googleusercontent.com",
            //         callback: handleCredentialResponse
            //     });

            //     google.accounts.id.renderButton(
            //         document.getElementById("buttonDiv"), {
            //         theme: "outline",
            //         size: "large"
            //     } // customization attributes
            //     );

            //     google.accounts.id.prompt(); // also display the One Tap dialog
            // }

            // $('input[name="username"]').keypress(function (e) {
            //     var txt = String.fromCharCode(e.which);
            //     if (!txt.match(/[a-z0-9_]/)) {
            //         return false;
            //     }
            // });
		});

		/* ====================== *
		 *  Initiate Canvas       *
		 * ====================== */
		paper.install(window);
		paper.setup(document.getElementById("canvas"));

		// Paper JS Variables
		var canvasWidth,
			canvasHeight,
			canvasMiddleX,
			canvasMiddleY;

		var shapeGroup = new Group();

		var positionArray = [];

		function getCanvasBounds() {
			// Get current canvas size
			canvasWidth = view.size.width;
			canvasHeight = view.size.height;
			canvasMiddleX = canvasWidth / 2;
			canvasMiddleY = canvasHeight / 2;
			// Set path position
			var position1 = {
				x: (canvasMiddleX / 2) + 100,
				y: 100,
			};

			var position2 = {
				x: 200,
				y: canvasMiddleY,
			};

			var position3 = {
				x: (canvasMiddleX - 50) + (canvasMiddleX / 2),
				y: 150,
			};

			var position4 = {
				x: 0,
				y: canvasMiddleY + 100,
			};

			var position5 = {
				x: canvasWidth - 130,
				y: canvasHeight - 75,
			};

			var position6 = {
				x: canvasMiddleX + 80,
				y: canvasHeight - 50,
			};

			var position7 = {
				x: canvasWidth + 60,
				y: canvasMiddleY - 50,
			};

			var position8 = {
				x: canvasMiddleX + 100,
				y: canvasMiddleY + 100,
			};

			positionArray = [position3, position2, position5, position4, position1, position6, position7, position8];
		};

		/* ====================== *
		 * Create Shapes          *
		 * ====================== */
		function initializeShapes() {
			// Get Canvas Bounds
			getCanvasBounds();

			var shapePathData = [
				'M231,352l445-156L600,0L452,54L331,3L0,48L231,352',
				'M0,0l64,219L29,343l535,30L478,37l-133,4L0,0z',
				'M0,65l16,138l96,107l270-2L470,0L337,4L0,65z',
				'M333,0L0,94l64,219L29,437l570-151l-196-42L333,0',
				'M331.9,3.6l-331,45l231,304l445-156l-76-196l-148,54L331.9,3.6z',
				'M389,352l92-113l195-43l0,0l0,0L445,48l-80,1L122.7,0L0,275.2L162,297L389,352',
				'M 50 100 L 300 150 L 550 50 L 750 300 L 500 250 L 300 450 L 50 100',
				'M 700 350 L 500 350 L 700 500 L 400 400 L 200 450 L 250 350 L 100 300 L 150 50 L 350 100 L 250 150 L 450 150 L 400 50 L 550 150 L 350 250 L 650 150 L 650 50 L 700 150 L 600 250 L 750 250 L 650 300 L 700 350 '
			];

			for (var i = 0; i <= shapePathData.length; i++) {
				// Create shape
				var headerShape = new Path({
					strokeColor: 'rgba(255, 255, 255, 0.5)',
					strokeWidth: 2,
					parent: shapeGroup,
				});
				// Set path data
				headerShape.pathData = shapePathData[i];
				headerShape.scale(2);
				// Set path position
				headerShape.position = positionArray[i];
			}
		};

		initializeShapes();

		/* ====================== *
		 * Animation              *
		 * ====================== */
		view.onFrame = function paperOnFrame(event) {
			if (event.count % 4 === 0) {
				// Slows down frame rate
				for (var i = 0; i < shapeGroup.children.length; i++) {
					if (i % 2 === 0) {
						shapeGroup.children[i].rotate(-0.1);
					} else {
						shapeGroup.children[i].rotate(0.1);
					}
				}
			}
		};

		view.onResize = function paperOnResize() {
			getCanvasBounds();

			for (var i = 0; i < shapeGroup.children.length; i++) {
				shapeGroup.children[i].position = positionArray[i];
			}

			if (canvasWidth < 700) {
				shapeGroup.children[3].opacity = 0;
				shapeGroup.children[2].opacity = 0;
				shapeGroup.children[5].opacity = 0;
			} else {
				shapeGroup.children[3].opacity = 1;
				shapeGroup.children[2].opacity = 1;
				shapeGroup.children[5].opacity = 1;
			}
		};
	</script>
</body>

</html>