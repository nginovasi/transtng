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
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/img/TNGLogo-TNGIcon.svg" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/plugins.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

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
    <div class="d-flex flex-column flex-root">
        <!--begin::Login-->
        <div class="d-flex flex-row-fluid">
            <div class="d-flex flex-center flex-row-fluid t">
                <div class="text-center p-7 position-relative overflow-hidden d-flex flex-column justify-content-center align-items-center">
                    <!--begin::Login Header-->
                    <div class="d-flex flex-center mb-3">
                        <a class="mb-3" href="#">
                            <img src="<?= base_url() ?>/assets/img/TNGLogo-TNGIcon.svg" alt="" style="width: 20%; height: auto" />
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
                                <input class="form-control h-auto  py-4 px-8" type="text" placeholder="Username" name="username" maxlength="30" />
                            </div>
                            <div class="input-group mb-5">
                                <input class="form-control h-auto  py-4 px-8" type="password" id="password" placeholder="Password" name="password" maxlength="50" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fa fa-eye-slash" id="show_password" onclick="showPassword()" style="cursor: pointer; color: #224DDD;"></i>
                                    </span>
                                </div>
                            </div>
                            <button id="kt_login_signin_submit" class="btn btn-primary font-weight-bold btn-block" style="background-color: #224DDD; border-color: #224DDD; margin-top: 40px; height: 48px;">Masuk</button>
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

    function showPassword() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
            $('#show_password').removeClass('fa-eye-slash');
            $('#show_password').addClass('fa-eye');
            $('#show_password').attr('cursor', 'pointer');
            $('#show_password').attr('color', '#224DDD');
            $('#show_password').attr('title', 'Sembunyikan Password');
        } else {
            x.type = "password";
            $('#show_password').removeClass('fa-eye');
            $('#show_password').addClass('fa-eye-slash');
            $('#show_password').attr('cursor', 'pointer');
            $('#show_password').attr('color', '#224DDD');
            $('#show_password').attr('title', 'Tampilkan Password');
        }
    }
</script>

</html>