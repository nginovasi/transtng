<!DOCTYPE html>
<html lang="en">

<head>
    <base href="../../../../">
    <meta charset="utf-8" />
    <title>Halaman Login | Trans Tangerang</title>
    <meta name="description" content="Login Trans Tangerang" />
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
    <style type="text/css">
        #buttonDiv {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            width: 100%;
        }
    </style>
    <div class="d-flex flex-column flex-root">
        <!--begin::Login-->
        <div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
            <div class="d-flex flex-center flex-row-fluid t">
                <div class="login-form text-center p-7 position-relative overflow-hidden">
                    <!--begin::Login Header-->
                    <div class="d-flex flex-center mb-3">
                        <a href="#">
                            <img src="<?= base_url() ?>/assets/img/icon.png" alt="" style="width: 50%; height: auto" />
                        </a>
                    </div>
                    <!--end::Login Header-->
                    <!--begin::Login Sign in form-->
                    <div class="login-signin">
                        <div class="mb-10">
                            <h3>Halaman Login</h3>
                            <div class="text-muted font-weight-bold">Silahkan masuk dengan menggunakan akun terdaftar anda</div>
                        </div>
                        <form class="form" id="form1" action="" class="sign-in-form" method="post" enctype="multipart/form-data" autocomplete="off">
                            <?= csrf_field() ?>
                            <div class="form-group mb-5">
                                <input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Username" name="username" maxlength="30" />
                            </div>
                            <div class="form-group mb-5">
                                <input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Password" name="password" maxlength="50" />
                            </div>
                            <button id="kt_login_signin_submit" class="btn btn-primary font-weight-bold btn-block" style="background-color: #224DDD; border-color: #224DDD; margin-top: 40px; height: 48px;">Masuk</button>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="buttonDiv"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Login-->
    </div>
    <!-- <a href="#">
        <img src="<?= base_url() ?>/assets/img/hubdat.png" alt="Kementerian Perhubungan" style="width: 130pt; height: auto; margin-bottom: 10px; margin-left: auto; margin-right: auto; display: flex" />
    </a> -->
    <div class="embuh" style="color: #224DDD">Copyright &copy; <?= date("Y") ?> Nusantara Global Inovasi.<br>All rights reserved. </div>
</body>
<script type="text/javascript">
    $(document).ready(function() {
        $("#form1").submit(function(event) {
            console.log("submit");
            event.preventDefault();
            var $form = $(this);
            Swal.fire({
                title: "",
                icon: "info",
                text: "Mohon ditunggu...",
                onOpen: function() {
                    Swal.showLoading();
                }
            });
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
        });

        function handleCredentialResponse(response) {
            let jwt = parseJwt(response.credential)
            let email = jwt.email;
            loginWithGoogle(email);
        }

        function loginWithGoogle(email) {
            Swal.fire({
                title: "",
                icon: "info",
                text: "Mohon ditunggu...",
                onOpen: function() {
                    Swal.showLoading()
                }
            });

            var url = '<?= base_url() ?>/auth/action/loginGoogle';

            $.post(url, {
                email: email,
                "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
            }, function(data) {
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
        }

        function parseJwt(token) {
            var base64Url = token.split('.')[1];
            var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
            var jsonPayload = decodeURIComponent(window.atob(base64).split('').map(function(c) {
                return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
            }).join(''));
            return JSON.parse(jsonPayload);
        };

        window.onload = function() {
            google.accounts.id.initialize({
                client_id: "952480244845-on52q6pv8f20mnlat55ip23uddpjldsg.apps.googleusercontent.com",
                callback: handleCredentialResponse
            });
            google.accounts.id.renderButton(
                document.getElementById("buttonDiv"), {
                    theme: "outline",
                    size: "large"
                } // customization attributes
            );
            google.accounts.id.prompt(); // also display the One Tap dialog
        }

        $('input[name="username"]').keypress(function(e) {
            var txt = String.fromCharCode(e.which);
            if (txt.match(/[a-z0-9_]/)) {
                return true;
            } else {
                Swal.fire({
                    title: 'Perhatian',
                    text: 'Capslock aktif',
                    icon: 'warning',
                    showConfirmButton: false,
                    timer: 2500
                });
                return false;
            }
        });
    });
</script>

</html>