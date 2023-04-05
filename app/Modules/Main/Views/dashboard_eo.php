<!-- get session php -->
<?php
$session = \Config\Services::session();
?>
<style>
    #persentaseJadwalMudik_length {
        margin-left: 0;
        display: flex;
    }
</style>
<div class="">
    <!-- page hero -->
    <div class="page-hero page-container " id="page-hero">
        <div class="padding d-flex">
            <div class="page-title">
                <h2 class="text-md text-highlight">Dashboard <?= $session->get('role_name') ?></h2>
                <small class="text-muted">Welcome
                    <strong><?= $session->get('name') ?></strong>
                </small>
            </div>
            <div class="flex"></div>
        </div>
    </div>

    <!-- page content -->
    <div class="page-content page-container" id="page-content">
        <div class="padding">
            <div class="row row-sm sr">
                <div class="col-md-12">
                    <div class="row row-sm">
                        <?php if ($session->get('id') == 229) { ?>
                            <div class="col-md-6">
                                <div class="row row-sm">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row row-sm">
                                                    <div class="col-6 text-center mb-2">
                                                        <div class="text-highlight text-md armada-bis">0</div>
                                                        <small>Armada Bis</small>
                                                    </div>
                                                    <div class="col-6 text-center">
                                                        <div class="text-highlight text-md armada-truck">0</div>
                                                        <small>Armada Truck</small>
                                                    </div>
                                                    <div class="col-6 text-center mb-2">
                                                        <div class="text-highlight text-md jadwal-mudik">0</div>
                                                        <small>Jadwal Mudik</small><br>
                                                        <!-- <small>Open:
                                                            <strong class="text-primary jadwal-mudik-open">0</strong>
                                                        </small> |
                                                        <small>Close:
                                                            <strong class="text-primary jadwal-mudik-close">0</strong>
                                                        </small> -->
                                                    </div>
                                                    <div class="col-6 text-center">
                                                        <div class="text-highlight text-md jadwal-motis">0</div>
                                                        <small>Jadwal Motis</small><br>
                                                        <!-- <small>Open:
                                                            <strong class="text-primary jadwal-motis-open">0</strong>
                                                        </small> |
                                                        <small>Close:
                                                            <strong class="text-primary jadwal-motis-close">0</strong>
                                                        </small> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row row-sm">
                                    <div class="col-6 d-flex">
                                        <div class="card flex">
                                            <div class="card-body">
                                                <small>Bis full complete:
                                                    <strong class="text-primary armada-bis-full-percentage">0%</strong>
                                                </small>
                                                <div class="progress my-3 circle" style="height:6px;">
                                                    <div class="progress-bar circle gd-primary armada-bis-full-progress-percentage" data-toggle="tooltip" title="0%" style="width: 0%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 d-flex">
                                        <div class="card flex">
                                            <div class="card-body">
                                                <small>Truck full complete:
                                                    <strong class="text-primary armada-truck-full-percentage">0%</strong>
                                                </small>
                                                <div class="progress my-3 circle" style="height:6px;">
                                                    <div class="progress-bar circle gd-warning armada-truck-full-progress-percentage" data-toggle="tooltip" title="0%" style="width: 0%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex">
                                <div class="card flex">
                                    <div class="card-body text-center">
                                        <small class="text-muted">Total Kuota Pemudik</small>
                                        <div class="pt-3">
                                            <div style="height: 150px" class="pos-rlt">
                                                <div class="pos-abt w-100 h-100 d-flex align-items-center justify-content-center">
                                                    <div class="w-100">
                                                        <div class="row my-2">
                                                            <div class="col">
                                                                <div class="text-highlight text-md total-all-mudik">
                                                                    0
                                                                </div>
                                                                <small class="text-muted">Total Kuota</small>
                                                            </div>
                                                        </div>
                                                        <div class="row my-2">
                                                            <div class="col-6">
                                                                <div class="text-highlight text-md total-all-mudik2">
                                                                    0
                                                                </div>
                                                                <small class="text-muted">Kuota Mudik</small>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="text-highlight text-md total-all-balik">
                                                                    0
                                                                </div>
                                                                <small class="text-muted">Kuota Balik</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex">
                                <div class="card flex">
                                    <div class="card-body text-center">
                                        <small class="text-muted">Total Kuota Pemudik Terisi</small>
                                        <div class="pt-3">
                                            <div style="height: 150px" class="pos-rlt">
                                                <div class="pos-abt w-100 h-100 d-flex align-items-center justify-content-center">
                                                    <div class="w-100">
                                                        <div class="row my-2">
                                                            <div class="col">
                                                                <div class="text-highlight text-md total-all-mudik-filled">
                                                                    0
                                                                </div>
                                                                <small class="text-muted">Total Terisi</small>
                                                            </div>
                                                        </div>
                                                        <div class="row my-2">
                                                            <div class="col-6">
                                                                <div class="text-highlight text-md total-all-mudik2-filled">
                                                                    0
                                                                </div>
                                                                <small class="text-muted">Total Terisi Mudik</small>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="text-highlight text-md total-all-balik-filled">
                                                                    0
                                                                </div>
                                                                <small class="text-muted">Total Terisi Balik</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex">
                                <div class="card flex">
                                    <div class="card-body text-center">
                                        <small class="text-muted">Total Kuota Pemudik Tersedia</small>
                                        <div class="pt-3">
                                            <div style="height: 150px" class="pos-rlt">
                                                <div class="pos-abt w-100 h-100 d-flex align-items-center justify-content-center">
                                                    <div class="w-100">
                                                        <div class="row my-2">
                                                            <div class="col">
                                                                <div class="text-highlight text-md total-all-mudik-avail">
                                                                    0
                                                                </div>
                                                                <small class="text-muted">Kuota Tersedia</small>
                                                            </div>
                                                        </div>
                                                        <div class="row my-2">
                                                            <div class="col-6">
                                                                <div class="text-highlight text-md total-all-mudik2-avail">
                                                                    0
                                                                </div>
                                                                <small class="text-muted">Tersedia Mudik</small>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="text-highlight text-md total-all-balik-avail">
                                                                    0
                                                                </div>
                                                                <small class="text-muted">Tersedia Balik</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex">
                                <div class="card flex">
                                    <div class="card-body text-center">
                                        <small class="text-muted">Total Kuota Motis</small>
                                        <div class="pt-3">
                                            <div style="height: 150px" class="pos-rlt">
                                                <div class="pos-abt w-100 h-100 d-flex align-items-center justify-content-center">
                                                    <div class="w-100">
                                                        <div class="row my-2">
                                                            <div class="col">
                                                                <div class="text-highlight text-md total-all-motis">
                                                                    0
                                                                </div>
                                                                <small class="text-muted">Kuota Motis</small>
                                                            </div>
                                                        </div>
                                                        <div class="row my-2">
                                                            <div class="col-6">
                                                                <div class="text-highlight text-md total-all-motis-mudik">
                                                                    0
                                                                </div>
                                                                <small class="text-muted">Motis Mudik</small>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="text-highlight text-md total-all-motis-balik">
                                                                    0
                                                                </div>
                                                                <small class="text-muted">Motis Balik</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex">
                                <div class="card flex">
                                    <div class="card-body text-center">
                                        <small class="text-muted">Total Kuota Motis Tersedia</small>
                                        <div class="pt-3">
                                            <div style="height: 150px" class="pos-rlt">
                                                <div class="pos-abt w-100 h-100 d-flex align-items-center justify-content-center">
                                                    <div class="w-100">
                                                        <div class="row my-2">
                                                            <div class="col">
                                                                <div class="text-highlight text-md total-all-motis-avail">
                                                                    0
                                                                </div>
                                                                <small class="text-muted">Kuota Motis tersedia</small>
                                                            </div>
                                                        </div>
                                                        <div class="row my-2">
                                                            <div class="col-6">
                                                                <div class="text-highlight text-md total-all-motis-mudik-avail">
                                                                    0
                                                                </div>
                                                                <small class="text-muted">Tersedia Motis Mudik</small>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="text-highlight text-md total-all-motis-balik-avail">
                                                                    0
                                                                </div>
                                                                <small class="text-muted">Terdia Motis Balik</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-md-4 d-flex">
                            <div class="card flex" style="border: 1px solid #31c971">
                                <div class="card-body text-center">
                                    <small class="text-muted">Total Validasi</small>
                                    <div class="pt-3">
                                        <div style="height: 150px" class="pos-rlt">
                                            <div class="pos-abt w-100 h-100 d-flex align-items-center justify-content-center">
                                                <div class="w-100">
                                                    <div class="row my-2">
                                                        <div class="col">
                                                            <div class="text-highlight text-md total-all-validasi">
                                                                0
                                                            </div>
                                                            <small class="text-muted">Total Validasi</small>
                                                        </div>
                                                    </div>
                                                    <div class="row my-2">
                                                        <div class="col-6">
                                                            <div class="text-highlight text-md total-all-validasi-mudik">
                                                                0
                                                            </div>
                                                            <small class="text-muted">Validasi Mudik</small>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="text-highlight text-md total-all-validasi-balik">
                                                                0
                                                            </div>
                                                            <small class="text-muted">Validasi Balik</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex">
                            <div class="card flex">
                                <div class="card-body text-center">
                                    <small class="text-muted">Total Belum Validasi</small>
                                    <div class="pt-3">
                                        <div style="height: 150px" class="pos-rlt">
                                            <div class="pos-abt w-100 h-100 d-flex align-items-center justify-content-center">
                                                <div class="w-100">
                                                    <div class="row my-2">
                                                        <div class="col">
                                                            <div class="text-highlight text-md total-all-validasi-pending">
                                                                0
                                                            </div>
                                                            <small class="text-muted">Total Belum Validasi</small>
                                                        </div>
                                                    </div>
                                                    <div class="row my-2">
                                                        <div class="col-6">
                                                            <div class="text-highlight text-md total-all-validasi-mudik-pending">
                                                                0
                                                            </div>
                                                            <small class="text-muted">Belum Validasi Mudik</small>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="text-highlight text-md total-all-validasi-balik-pending">
                                                                0
                                                            </div>
                                                            <small class="text-muted">belum Validasi Balik</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex">
                            <div class="card flex" style="border: 1px solid #f54394">
                                <div class="card-body text-center">
                                    <small class="text-muted">Total Gagal Validasi</small>
                                    <div class="pt-3">
                                        <div style="height: 150px" class="pos-rlt">
                                            <div class="pos-abt w-100 h-100 d-flex align-items-center justify-content-center">
                                                <div class="w-100">
                                                    <div class="row my-2">
                                                        <div class="col">
                                                            <div class="text-highlight text-md total-all-validasi-fail">
                                                                0
                                                            </div>
                                                            <small class="text-muted">Total Gagal Validasi</small>
                                                        </div>
                                                    </div>
                                                    <div class="row my-2">
                                                        <div class="col-6">
                                                            <div class="text-highlight text-md total-all-validasi-mudik-fail">
                                                                0
                                                            </div>
                                                            <small class="text-muted">Gagal Validasi Mudik</small>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="text-highlight text-md total-all-validasi-balik-fail">
                                                                0
                                                            </div>
                                                            <small class="text-muted">Gagal Validasi Balik</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($session->get('id') == 229) { ?>
                        <div class="col-12 d-flex">
                            <div class="card flex">
                                <div class="card-body text-center">
                                    <small class="text-muted">List Jadwal Mudik Tersedia</small>
                                    <div class="pt-2">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-sm" id="persentaseJadwalMudikAvail" style="width:100% !important">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th class="">Armada</th>
                                                        <th class="">Armada Code</th>
                                                        <th class="">Route</th>
                                                        <th class="">Tipe Jadwal</th>
                                                        <th class="text-center">Kuota</th>
                                                        <th class="text-center">Terisi</th>
                                                        <th class="text-center">Sisa</th>
                                                        <th class="text-center">Persentase</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if ($session->get('id') != 284) { ?>
                        <div class="col-12 d-flex">
                            <div class="card flex">
                                <div class="card-body text-center">
                                    <small class="text-muted">List Jadwal Mudik</small>
                                    <div class="pt-2">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-sm" id="persentaseJadwalMudik" style="width:100% !important">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th class="">Armada</th>
                                                        <th class="">Armada Code</th>
                                                        <th class="">Route</th>
                                                        <th class="">Tipe Jadwal</th>
                                                        <th class="text-center">Kuota</th>
                                                        <th class="text-center">Terisi</th>
                                                        <th class="text-center">Sisa</th>
                                                        <th class="text-center">Persentase</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex">
                            <div class="card flex">
                                <div class="card-body text-center">
                                    <small class="text-muted">List Jadwal Motis</small>
                                    <div class="pt-2">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover table-sm" id="persentaseJadwalMotis">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th class="">Route</th>
                                                        <th class="text-center" style="width: 200px">Armada</th>
                                                        <th class="text-center">Jadwal Keberangkatan</th>
                                                        <th class="text-center">Waktu Keberangkatan</th>
                                                        <th class="text-center">Jadwal Kedatangan</th>
                                                        <th class="text-center">Waktu Kedatangan</th>
                                                        <th class="">Tipe Jadwal</th>
                                                        <th class="text-center">Kuota Public</th>
                                                        <th class="text-center">Kuota Paguyuban</th>
                                                        <th class="text-center">Kuota Max</th>
                                                        <th class="text-center">Persentase</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- script internal -->
<script>
    $(document).ready(function() {
        // ajax count armada bis by eo
        $.ajax({
            url: '<?= base_url() ?>/main/getCountArmadaBisByEO',
            type: "GET",
            dataType: "json",
            success: function(data) {
                $('.armada-bis').text(data.count_armada_bis)
            },
            error: function(data) {
                console.log('error not fix');
            }
        });

        // ajax count jadwal mudik by eo 
        $.ajax({
            url: '<?= base_url() ?>/main/getCountJadwalMudikByEO',
            type: "GET",
            dataType: "json",
            success: function(data) {
                $('.jadwal-mudik').text(data.count_jadwal_mudik)
                $('.jadwal-mudik-open').text(data.open)
                $('.jadwal-mudik-close').text(data.close)
            },
            error: function(data) {
                console.log('error not fix');
            }
        });

        // ajax count armada truck by eo 
        $.ajax({
            url: '<?= base_url() ?>/main/getCountArmadaTruckByEO',
            type: "GET",
            dataType: "json",
            success: function(data) {
                $('.armada-truck').text(data.count_armada_truck)
            },
            error: function(data) {
                console.log('error not fix');
            }
        });

        // ajax count jadwal motis by eo 
        $.ajax({
            url: '<?= base_url() ?>/main/getCountJadwalMotisByEO',
            type: "GET",
            dataType: "json",
            success: function(data) {
                $('.jadwal-motis').text(data.count_jadwal_motis)
                $('.jadwal-motis-open').text(data.open)
                $('.jadwal-motis-close').text(data.close)
            },
            error: function(data) {
                console.log('error not fix');
            }
        });

        // ajax count percentage armada bis by eo 
        // $.ajax({
        //     url: '<?= base_url() ?>/main/getCountPercentageArmadaBisByEO',
        //     type: "GET",
        //     dataType: "json",
        //     success: function(data) {
        //         $('.armada-bis-full-percentage').text((data.percentage_armada_bis == 0 || data.percentage_armada_bis == null ? 0 : data.percentage_armada_bis) + '%')

        //         $('.armada-bis-full-progress-percentage').attr('title', data.percentage_armada_bis + '%')
        //         $('.armada-bis-full-progress-percentage').css('width', data.percentage_armada_bis + '%')
        //     },
        //     error: function(data) {
        //         console.log('error not fix');
        //     }
        // });

        // ajax count percentage armada truck by eo 
        $.ajax({
            url: '<?= base_url() ?>/main/getCountPercentageArmadaTruckByEO',
            type: "GET",
            dataType: "json",
            success: function(data) {
                $('.armada-truck-full-percentage').text((data.percentage_armada_truck == 0 || data.percentage_armada_truck == null ? 0 : data.percentage_armada_truck) + '%')

                $('.armada-truck-full-progress-percentage').attr('title', data.percentage_armada_truck + '%')
                $('.armada-truck-full-progress-percentage').css('width', data.percentage_armada_truck + '%')
            },
            error: function(data) {
                console.log('error not fix');
            }
        });

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        // ajax count all pemudik by eo 
        $.ajax({
            url: '<?= base_url() ?>/main/getCountAllPemudikByEO',
            type: "GET",
            dataType: "json",
            success: function(data) {
                $('.total-all-mudik').text(numberWithCommas(parseInt(data.kuota_all)))
                $('.total-all-mudik2').text(numberWithCommas(parseInt(data.kuota_all_mudik)))
                $('.total-all-balik').text(numberWithCommas(parseInt(data.kuota_all_balik)))

                $('.total-all-mudik-filled').text(numberWithCommas(parseInt(data.count_filled)))
                $('.total-all-mudik2-filled').text(numberWithCommas(parseInt(data.count_filled_mudik)))
                $('.total-all-balik-filled').text(numberWithCommas(parseInt(data.count_filled_balik)))

                $('.total-all-mudik-avail').text(numberWithCommas(parseInt(data.count_all_remainder_kuota)))
                $('.total-all-mudik2-avail').text(numberWithCommas(parseInt(data.count_all_remainder_kuota_mudik)))
                $('.total-all-balik-avail').text(numberWithCommas(parseInt(data.count_all_remainder_kuota_balik)))

                // $('.total-all-mudik-avail').text('on devel')
                // $('.total-all-mudik2-avail').text('on devel')
                // $('.total-all-balik-avail').text('on devel')

                $('.total-all-validasi').text(numberWithCommas(parseInt(data.count_success_verif)));
                $('.total-all-validasi-mudik').text(numberWithCommas(parseInt(data.count_success_verif_mudik)));
                $('.total-all-validasi-balik').text(numberWithCommas(parseInt(data.count_success_verif_balik)));

                $('.total-all-validasi-pending').text(numberWithCommas(parseInt(data.count_pending_verif)));
                $('.total-all-validasi-mudik-pending').text(numberWithCommas(parseInt(data.count_pending_verif_mudik)));
                $('.total-all-validasi-balik-pending').text(numberWithCommas(parseInt(data.count_pending_verif_balik)));

                $('.total-all-validasi-fail').text(numberWithCommas(parseInt(data.count_fail_verif)));
                $('.total-all-validasi-mudik-fail').text(numberWithCommas(parseInt(data.count_fail_verif_mudik)));
                $('.total-all-validasi-balik-fail').text(numberWithCommas(parseInt(data.count_fail_verif_balik)));

                $('.armada-bis-full-percentage').text((data.bis_fully_percentage == 0 || data.bis_fully_percentage == null ? 0 : data.bis_fully_percentage) + '%')
                $('.armada-bis-full-progress-percentage').attr('title', data.bis_fully_percentage + '%')
                $('.armada-bis-full-progress-percentage').css('width', data.bis_fully_percentage + '%')

            },
            error: function(data) {
                console.log('error not fix');
            }
        });

        // ajax count all pemudik by eo 
        $.ajax({
            url: '<?= base_url() ?>/main/getCountAllMotisByEO',
            type: "GET",
            dataType: "json",
            success: function(data) {
                $('.total-all-motis').text(data.kuota_motis)
                $('.total-all-motis-mudik').text(data.kuota_motis_mudik)
                $('.total-all-motis-balik').text(data.kuota_motis_balik)

                $('.total-all-motis-avail').text(data.motis_avail)
                $('.total-all-motis-mudik-avail').text(data.motis_mudik_avail)
                $('.total-all-motis-balik-avail').text(data.motis_balik_avail)
            },
            error: function(data) {
                console.log('error not fix');
            }
        });

        // ajax count all pemudik verif by eo 
        // $.ajax({
        //     url: '<?= base_url() ?>/main/getCountAllVerifByEO',
        //     type: "GET",
        //     dataType: "json",
        //     success: function(data) {
        //         $('.total-all-verif').text(numberWithCommas(parseInt(data.count_verif) + 7516));
        //         $('.total-all-unverif').text(numberWithCommas(parseInt(data.count_fail)));
        //         $('.total-all-nonverif').text(numberWithCommas(parseInt(data.count_not_yet_verif)));
        //         // $('.total-all-nonverif2').text(numberWithCommas(parseInt(7516)));
        //         // $('.total-all-exverif').text(numberWithCommas(parseInt(data.count_expired)));
        //     },
        //     error: function(data) {
        //         console.log('error not fix');
        //     }
        // });

        // ajax call list jadwal mudik percentage
        $.ajax({
            url: '<?= base_url() ?>/main/getListJadwalMudikPercentage',
            type: "GET",
            dataType: "json",
            success: function(result) {
                // console.log(result);
                var table = $('#persentaseJadwalMudik').DataTable({
                    data: result,
                    columns: [{
                            data: 'id',
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'armada_name'
                        },
                        {
                            data: 'armada_code'
                        },
                        {
                            data: 'route_name'
                        },
                        {
                            data: 'jadwal_type',
                            render: function(a, type, data, index) {
                                let button = ''

                                if (data.jadwal_type == 1) {
                                    button += 'Mudik'
                                } else {
                                    button += 'Balik'
                                }

                                return button;
                            }
                        },
                        {
                            data: 'seat_total'
                        },
                        {
                            data: 'seat_filled'
                        },
                        {
                            data: 'seat_avail'
                        },
                        {
                            data: 'seat_filled',
                            render: function(a, type, data, index) {
                                let button = ''
                                button += `<small>Status : 
                                                <strong class="text-primary">${data.percentage_fully}%</strong>
                                            </small>
                                            <div class="progress my-3 circle" style="height:6px;">
                                                <div class="progress-bar circle gd-primary" data-toggle="tooltip" title="${data.percentage_fully}%" style="width: ${data.percentage_fully}%"></div>
                                            </div>`

                                return button;
                            }
                        },
                    ],
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "All"]
                    ],
                    "columnDefs": [{
                            "targets": 1,
                            "className": "text-left"
                        },
                        {
                            "targets": 2,
                            "className": "text-left"
                        },
                        {
                            "targets": 3,
                            "className": "text-left"
                        }
                    ],
                    "pageLength": 5,
                    "bLengthChange": true,
                    "bInfo": false,
                    // "bFilter": true,
                    "bPaginate": true,
                });
            }
        });

        // ajax call list jadwal mudik percentage
        $.ajax({
            url: '<?= base_url() ?>/main/getListJadwalMudikPercentageAvail',
            type: "GET",
            dataType: "json",
            success: function(result) {
                // console.log(result);
                var table = $('#persentaseJadwalMudikAvail').DataTable({
                    data: result,
                    columns: [{
                            data: 'id',
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'armada_name'
                        },
                        {
                            data: 'armada_code'
                        },
                        {
                            data: 'route_name'
                        },
                        {
                            data: 'jadwal_type',
                            render: function(a, type, data, index) {
                                let button = ''

                                if (data.jadwal_type == 1) {
                                    button += 'Mudik'
                                } else {
                                    button += 'Balik'
                                }

                                return button;
                            }
                        },
                        {
                            data: 'seat_total'
                        },
                        {
                            data: 'seat_filled'
                        },
                        {
                            data: 'seat_avail'
                        },
                        {
                            data: 'seat_filled',
                            render: function(a, type, data, index) {
                                let button = ''
                                button += `<small>Status : 
                                                <strong class="text-primary">${data.percentage_fully}%</strong>
                                            </small>
                                            <div class="progress my-3 circle" style="height:6px;">
                                                <div class="progress-bar circle gd-primary" data-toggle="tooltip" title="${data.percentage_fully}%" style="width: ${data.percentage_fully}%"></div>
                                            </div>`

                                return button;
                            }
                        },
                    ],
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "All"]
                    ],
                    "columnDefs": [{
                            "targets": 1,
                            "className": "text-left"
                        },
                        {
                            "targets": 2,
                            "className": "text-left"
                        },
                        {
                            "targets": 3,
                            "className": "text-left"
                        }
                    ],
                    "pageLength": 5,
                    "bLengthChange": true,
                    "bInfo": false,
                    // "bFilter": true,
                    "bPaginate": true,
                });
            }
        });

        // ajax call list jadwal motis percentage
        $.ajax({
            url: '<?= base_url() ?>/main/getListJadwalMotisPercentage',
            type: "GET",
            dataType: "json",
            success: function(result) {
                var table = $('#persentaseJadwalMotis').DataTable({
                    data: result,
                    columns: [{
                            data: 'id',
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'route_name'
                        },
                        {
                            data: 'armada',
                            render: function(a, type, data, index) {
                                let button = `<ul>`

                                var map_detail = JSON.parse(data.armada)

                                for (i = 0; i < map_detail.length; i++) {
                                    button += `<li><p style= width:200px>` + map_detail[i].armada_name + `</p></li>`
                                }

                                button += `</ul>`

                                return button;
                            }
                        },
                        {
                            data: 'jadwal_date_depart'
                        },
                        {
                            data: 'jadwal_time_depart'
                        },
                        {
                            data: 'jadwal_date_arrived'
                        },
                        {
                            data: 'jadwal_time_arrived'
                        },
                        {
                            data: 'jadwal_type',
                            render: function(a, type, data, index) {
                                let button = ''

                                if (data.jadwal_type == 1) {
                                    button += 'Mudik'
                                } else {
                                    button += 'Balik'
                                }

                                return button;
                            }
                        },
                        {
                            data: 'quota_public'
                        },
                        {
                            data: 'quota_paguyuban'
                        },
                        {
                            data: 'quota_max'
                        },
                        {
                            data: 'seat_filled',
                            render: function(a, type, data, index) {
                                let button = ''

                                button += `<small>Status : 
                                                <strong class="text-primary">${data.percentage_fully}%</strong>
                                            </small>
                                            <div class="progress my-3 circle" style="height:6px;">
                                                <div class="progress-bar circle gd-primary" data-toggle="tooltip" title="${data.percentage_fully}%" style="width: ${data.percentage_fully}%"></div>
                                            </div>`

                                return button;
                            }
                        },
                    ],
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "All"]
                    ],
                    "columnDefs": [{
                            "targets": 1,
                            "className": "text-left"
                        },
                        {
                            "targets": 2,
                            "className": "text-left"
                        },
                        {
                            "targets": 6,
                            "className": "text-left"
                        }
                    ],
                    "pageLength": 5,
                    "bLengthChange": false,
                    "bInfo": false,
                    // "bFilter": false,
                    "bPaginate": true,
                });
            }
        });
    });
</script>