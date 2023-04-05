<style>
.select2-container {
    width: 100% !important;
}

#loading {
    display: none;
}
</style>
<div>
    <div class="page-hero page-container " id="page-hero">
        <div class="padding d-flex">
            <div class="page-title">
                <h2 class="text-md text-highlight"><?= $page_title ?></h2>
            </div>
            <div class="flex"></div>
        </div>
    </div>
    <div class="page-content page-container" id="page-content">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills no-border" id="tab">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab-data" role="tab"
                            aria-controls="tab-data" aria-selected="false">Data</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="padding">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-data" role="tabpanel" aria-labelledby="tab-data">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Bulan Rampcheck</label>
                                            <select class="form-control" id="rampcheck_month" name="rampcheck_month"
                                                required></select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tahun Rampcheck</label>
                                            <select class="form-control" id="rampcheck_year" name="rampcheck_year"
                                                required></select>
                                        </div>
                                    </div>
                                </div>
                                <div id="loading">
                                    <img src="<?=base_url()?>/assets/img/loading.gif"
                                        style="display: block; margin-left: auto; margin-right: auto; width: 100%;">
                                </div>
                                <div class="col-md-12">
                                    <div class="chart" id="chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
$(document).ready(function() {
    getRampcheckData();
    var rampcheck_month = $('#rampcheck_month');
    var rampcheck_year = $('#rampcheck_year');

    var date = new Date();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();

    rampcheck_month.val(month);
    rampcheck_year.val(year);

    rampcheck_month.select2({
        placeholder: 'Pilih Bulan Rampcheck',
        allowClear: true,
        width: '100%',
        data: [{
                id: '0',
                text: 'Semua'
            },
            {
                id: '01',
                text: 'Januari'
            },
            {
                id: '02',
                text: 'Februari'
            },
            {
                id: '03',
                text: 'Maret'
            },
            {
                id: '04',
                text: 'April'
            },
            {
                id: '05',
                text: 'Mei'
            },
            {
                id: '06',
                text: 'Juni'
            },
            {
                id: '07',
                text: 'Juli'
            },
            {
                id: '08',
                text: 'Agustus'
            },
            {
                id: '09',
                text: 'September'
            },
            {
                id: '10',
                text: 'Oktober'
            },
            {
                id: '11',
                text: 'November'
            },
            {
                id: '12',
                text: 'Desember'
            }
        ]
    });

    var currentYear = new Date().getFullYear();
    var minYear = currentYear - 1;
    var maxYear = currentYear + 1;
    var yearOptions = [];
    for (var i = currentYear; i >= minYear; i--) {
        yearOptions.push({
            id: i,
            text: i
        });
    }
    rampcheck_year.select2({
        placeholder: 'Pilih Tahun Rampcheck',
        allowClear: true,
        width: '100%',
        data: yearOptions
    });

    $('#rampcheck_month').on('change', function() {
        month = $(this).val();
        rampcheck_month.val(month);
        $('#chart').html('');
        getRampcheckData();
    });

    $('#rampcheck_year').on('change', function() {
        year = $(this).val();
        rampcheck_year.val(year);
        $('#chart').html('');
        getRampcheckData();
    });

    function getRampcheckData() {
        var month = $('#rampcheck_month').val();
        var year = $('#rampcheck_year').val();


        console.log(month + ' ' + year);
        $.ajax({
            url: '<?=base_url()?>/laporan/getRampcheckHistory',
            type: 'POST',
            dataType: 'json',
            data: {
                '<?=csrf_token()?>': '<?=csrf_hash()?>',
                month: month,
                year: year
            },
            beforeSend: function() {
            $('#loading').show();
            },
            success: function(data) {
                var options = {
                    chart: {
                        type: 'line',
                        toolbar: {
                            show: false
                        }
                    },
                    dataLabels: {
                        enabled: true
                    },
                    stroke: {
                        curve: 'straight'
                    },
                    series: [],
                    xaxis: {
                        categories: []
                    },
                    yaxis: {
                        title: {
                            text: 'Total Ramp Check'
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                }

                // Assuming you have your data in a variable named 'data'
                var seriesData = {};
                data.forEach(function(item) {
                    if (seriesData[item.rampcheck_kesimpulan_status] === undefined) {
                        seriesData[item.rampcheck_kesimpulan_status] = [];
                    }
                    seriesData[item.rampcheck_kesimpulan_status].push(item.ttl_rampcheck);
                    if (options.xaxis.categories.indexOf(item.rampcheck_date) === -1) {
                        options.xaxis.categories.push(item.rampcheck_date);
                    }
                });

                for (var key in seriesData) {
                    var seriesItem = {
                        name: key,
                        data: seriesData[key]
                    };
                    options.series.push(seriesItem);
                }
                var chart = new ApexCharts(document.querySelector('#chart'), options);
                chart.render();
            }, complete: function() {
                $('#loading').hide();
            }
        });
    }
});
</script>
