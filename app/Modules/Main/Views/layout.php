<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Trans Tangerang | Web Application</title>
    <meta name="description" content="Trans Kota Tangerang adalah sistem transportasi Bus Rapid Transit yang mulai beroperasi pada tanggal 1 Desember 2016 di Kota Tangerang, Banten. Layanan BRT ini diciptakan untuk mengurangi kemacetan dan menyediakan kendaraan massal yang nyaman, aman, bersih, dan cepat. Pada masa perkenalan, layanan BRT ini dibebaskan dari tarif selama 2 minggu." />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <!-- style -->
    <link rel="shortcut icon" href="<?= base_url(); ?>/assets/img/icon.png" type="image/png">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/theme.css" type="text/css" />

    <link rel="stylesheet" href="<?= base_url() ?>/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" type="text/css" />
    <link rel="stylesheet" href="<?= base_url() ?>/assets/libs/select2/dist/css/select2.min.css" type="text/css" />
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/leaflet.css" type="text/css" />
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/L.Icon.Pulse.css" type="text/css">
    <!-- datepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" integrity="sha512-34s5cpvaNG3BknEWSuOncX28vz97bRI59UnVtEEpFX536A7BtZSJHsDyFoCl8S7Dt2TPzcrCEoHBGeM4SUBDBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- not use -->  
    <!-- <link rel="stylesheet" href="<?= base_url() ?>/assets/libs/daterangepicker/daterangepicker.css"> -->

    <!-- <link rel="stylesheet" -->
    <link href='<?= base_url() ?>/assets/css/leaflet.fullscreen.css' rel='stylesheet' />
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/leaflet.draw-src.css" />

    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/easy-button.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/js/context/dist/leaflet.contextmenu.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/Control.Geocoder.css" />
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/style.css?tm=<?= date('HisYmd') ?>" type="text/css" />
    <!-- jQuery -->
    <script src="<?= base_url() ?>/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <script src="<?= base_url() ?>/assets/js/jquery.ui.widget.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>/assets/js/jquery.iframe-transport.js" type="text/javascript"></script>
    <script src="https://trans.my.id/ulins/template/assets/bundles/fileupload/jquery.fileupload.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>/assets/js/leaflet.js" type="text/javascript"></script>
    <script src='<?= base_url() ?>/assets/js/Leaflet.fullscreen.min.js'></script>
    <script src="<?= base_url() ?>/assets/js/L.Icon.Pulse.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>/assets/js/easy-button.js"></script>
    <script src="<?= base_url() ?>/assets/js/leaflet.draw.js"></script>
    <script src="<?= base_url() ?>/assets/js/Polyline.encoded.js"></script>
    <script src="<?= base_url() ?>/assets/js/context/dist/leaflet.contextmenu.min.js"></script>
    <script src="<?= base_url() ?>/assets/js/editable/src/Leaflet.Editable.js"></script>
    <script src="<?= base_url() ?>/assets/js/Control.Geocoder.js"></script>
    <script src="<?= base_url() ?>/assets/js/jquery-ui.min.js"></script>
    <!-- endbuild -->

    <script type="text/javascript" src="<?= base_url() ?>/assets/js/moment.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/bootstrap-datetimepicker-standalone.css">
    <script type="text/javascript" src="<?= base_url() ?>/assets/js/bootstrap-datetimepicker.min.js"></script>

    <style type="text/css">
        body {
            font-family: 'Manrope', sans-serif !important;
        }

        .btn-icon-datatable {
            width: 2.125rem;
            height: 2.125rem;
            padding: 7px;
            margin: 0 3px;
        }

        .column-2action {
            width: 100px !important;
        }

        @media only screen and (min-device-width: 1024px) {

            /* For portrait layouts only */
            .content-dashboard {
                margin-top: -50px;
            }

            #header {
                background: transparent;
                box-shadow: 0 1px 3px rgba(255, 255, 255, 0.22), 0 1px 2px rgba(0, 0, 0, 0);
                z-index: 1000;
                top: 0;
                right: 0;
                height: 56px;
                transition: background-color .3s ease-in-out;
            }

            #header.scroll {
                background-color: transparent;
                box-shadow: none;
                height: 56px;
            }
        }

        @media only screen and (min-device-width: 320px) and (max-device-width: 1024px) and (orientation:portrait) {

            /* For portrait layouts only */
            .content-dashboard {
                margin-top: 0px;
            }

            #header {
                background: rgba(249, 250, 251, 0.9);
                box-shadow: 0 1px 3px rgba(255, 255, 255, 0.22), 0 1px 2px rgba(0, 0, 0, 0);
                z-index: 1000;
                top: 0;
                right: 0;
                height: 56px;
                transition: all .3s ease;
            }

            #header.scroll {
                background: rgba(249, 250, 251, 0.7);
                box-shadow: none;
                height: 56px;
            }
        }

        @media only screen and (min-device-width: 320px) and (max-device-width: 1024px) and (orientation:landscape) {

            /* For landscape layouts only */
            .content-dashboard {
                margin-top: 0px;
                padding: 0rem;
            }

            #header {
                background: rgba(249, 250, 251, 0.9);
                box-shadow: 0 1px 3px rgba(255, 255, 255, 0.22), 0 1px 2px rgba(0, 0, 0, 0);
                z-index: 1000;
                top: 0;
                right: 0;
                height: 56px;
                transition: all .3s ease;
            }

            #header.scroll {
                background: rgba(249, 250, 251, 0.7);
                box-shadow: 0 1px 3px rgba(255, 255, 255, 0.22), 0 1px 2px rgba(0, 0, 0, 0);
                box-shadow: none;
                height: 56px;
            }
        }
    </style>
</head>
<body class="layout-row">
    <?php echo view('App\Modules\Main\Views\menu'); ?>
    <div id="main" class="layout-column flex">
        <?php echo view('App\Modules\Main\Views\navbar'); ?>
        <!-- ############ Content START-->
        <div id="content" class="flex " style="background:#F9FAFB">
            <!-- ############ Main START-->
            <?php if (isset($load_view)) {
                echo view($load_view);
            } else {
                $session = \Config\Services::session();
                $login_id = $session->get('role');
                echo view('App\Modules\Main\Views\dashboard');
            } ?>
            <!-- ############ Main END-->
        </div>
        <!-- ############ Content END-->
        <?php echo view('App\Modules\Main\Views\footer'); ?>
    </div>
</body>
<script type="text/javascript">
    function debounce(func, wait, immediate) {
        let timeout;
        return function executedFunction() {
            let context = this;
            let args = arguments;
            let later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            let callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }
</script>
<!-- Bootstrap -->
<script src="<?= base_url() ?>/assets/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- lazyload plugin -->
<script src="<?= base_url() ?>/assets/js/lazyload.config.js"></script>
<script src="<?= base_url() ?>/assets/js/lazyload.js"></script>
<script src="<?= base_url() ?>/assets/js/plugin.js"></script>
<!-- scrollreveal -->
<script src="<?= base_url() ?>/assets/libs/scrollreveal/dist/scrollreveal.min.js"></script>
<!-- feathericon -->
<script src="<?= base_url() ?>/assets/libs/feather-icons/dist/feather.min.js"></script>
<script src="<?= base_url() ?>/assets/js/plugins/feathericon.js"></script>
<!-- theme -->
<script src="<?= base_url() ?>/assets/js/theme.js"></script>
<script src="<?= base_url() ?>/assets/js/utils.js"></script>
<!-- endbuild -->
<script src="<?= base_url() ?>/assets/libs/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>/assets/libs/select2/dist/js/select2.full.min.js"></script>
<script src="<?= base_url() ?>/assets/js/plugins/sweetalert.js"></script>
<!-- datepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js" integrity="sha512-LsnSViqQyaXpD4mBBdRYeP6sRwJiJveh2ZIbW41EBrNmKxgr/LFZIiWT6yr+nycvhvauz8c2nYMhrP80YhG7Cw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- noy use -->
<!-- <script src="<?= base_url() ?>/assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> -->

<!-- coreEvents -->
<script src="<?= base_url() ?>/assets/js/coreevents.js?dt=<?= date('HisYmd') ?>"></script>

</html>