<style>
    .select2-container {
        width: 100% !important;
    }
</style>
<div>
    <div class="page-hero page-container " id="page-hero">
        <div class="padding d-flex">
            <div class="page-title">
                <h2 class="text-md text-highlight">
                    <?= $page_title ?>
                </h2>
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
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-form" role="tab" aria-controls="tab-form"
                            aria-selected="false">Form</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="padding">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-data" role="tabpanel" aria-labelledby="tab-data">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-hover no-wrap">
                                    <thead>
                                        <tr>
                                            <th><span>#</span></th>
                                            <th><span>Area Posko</span></th>
                                            <th><span>Nama Posko</span></th>
                                            <th><span>Lokasi Daerah</span></th>
                                            <th><span>Alamat Posko</span></th>
                                            <th class="column-2action"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tab-form" role="tabpanel" aria-labelledby="tab-form">
                            <form data-plugin="parsley" data-option="{}" id="form">
                                <input type="hidden" class="form-control" id="id" name="id" value="" required>
                                <?= csrf_field(); ?>
                                <div class="form-group">
                                    <label>Nama Posko</label>
                                    <input type="text" class="form-control" id="posko_mudik_name"
                                        name="posko_mudik_name" maxlength="100" required autocomplete="off"
                                        placeholder="Tentukan Nama Posko">
                                </div>
                                <div class="form-group">
                                    <label>Area Posko</label>
                                    <select class="form-control sel2" id="klas_posko_id" name="klas_posko_id" required>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Provinsi</label>
                                            <select class="form-control sel2" id="lokprov_id" name="lokprov_id"
                                                required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Kab / Kota</label>
                                            <select class="form-control sel2" id="idkabkota" name="idkabkota" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Alamat Posko</label>
                                    <textarea class="form-control" id="posko_mudik_address" name="posko_mudik_address"
                                        maxlength="255" required autocomplete="off"
                                        placeholder="Tentukan alamat posko_mudik"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Latitude & Longitude</label>
                                            <input type="text" class="form-control" name="posko_mudik_latlong"
                                                placeholder="Masukkan Latitude & Longitude untuk menentukan lokasi posko atau anda dapat menentukan lokasi dengan klik pada peta"
                                                id="posko_mudik_latlong">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Search Lokasi</label>
                                            <input type="text" class="form-control" name="posko_mudik_latlong_nominatim"
                                                placeholder="Atau Cari Lokasi Disini"
                                                id="posko_mudik_latlong_nominatim">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div style="height: 500px;" id="map"></div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    const auth_insert = '<?= $rules->i ?>';
    const auth_edit = '<?= $rules->e ?>';
    const auth_delete = '<?= $rules->d ?>';
    const auth_otorisasi = '<?= $rules->o ?>';

    const url = '<?= base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1) ?>';
    const url_ajax = '<?= base_url() . "/" . uri_segment(0) . "/ajax" ?>';
    //alert(url);

    var dataStart = 0;
    var coreEvents;

    const select2Array = [
    {
        id: 'klas_posko_id',
        url: '/klas_posko_id_select_get',
        placeholder: 'Pilih Area Posko',
        params: null
    },
    {
        id: 'lokprov_id',
        url: '/lokprov_id_select_get',
        placeholder: 'Pilih Provinsi',
        params: null
    },
    {
        id: 'idkabkota',
        url: '/idkabkota_select_get',
        placeholder: 'Pilih Kab / Kota',
        params: {
            idprov: function () {
                return $('#lokprov_id').val()
            }
        }
    }
    ];


    $(document).ready(function () {
        coreEvents = new CoreEvents();
        coreEvents.url = url;
        coreEvents.ajax = url_ajax;
        coreEvents.csrf = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
        };
        coreEvents.tableColumn = datatableColumn();

        var decodedData;
        //coreEvents.load();

        

        // onblur posko_mudik_latlong, place marker
        $('#posko_mudik_latlong').on('blur', function (e) {
            var latlong = $(this).val();
            var latlongArray = latlong.split(',');
            var lat = latlongArray[0];
            var lng = latlongArray[1];

            map.eachLayer(function (layer) {
                if (layer instanceof L.Marker) {
                    map.removeLayer(layer);
                }
            });

            L.marker([lat, lng]).on('click', function (e) { }).addTo(map);
        });

        // search location by nominatim on blur posko_mudik_latlong_nominatim
        $('#posko_mudik_latlong_nominatim').on('blur', function (e) {
            var nominatim = $(this).val();
            var url = 'https://nominatim.openstreetmap.org/search?q=' + nominatim + '&format=json&polygon=1&addressdetails=1';

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    if (data.length > 0) {
                        var lat = data[0].lat;
                        var lng = data[0].lon;

                        map.eachLayer(function (layer) {
                            if (layer instanceof L.Marker) {
                                map.removeLayer(layer);
                            }
                        });

                        map.setView([lat, lng], 13);

                        var marker = L.marker([lat, lng],
                        {
                            draggable: true
                        }).addTo(map);
                        marker.on('dragend', function (e) {
                            $('#posko_mudik_latlong').val(marker.getLatLng().lat.toFixed(6) + ',' + marker.getLatLng().lng.toFixed(6));
                        });

                        $('#posko_mudik_latlong').val(lat + ',' + lng);
                    } else {
                        // show sweetalert
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Location not found!',
                        })
                    }
                }, error: function (xhr, status, error) {
                    // show sweetalert
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                    })
                }
            });
        });

        var map = L.map('map', {
            fullscreenControl: true
        }).setView([-6.966667, 110.416664], 13);
        $('ul#tab li a').on('shown.bs.tab', function (e) {
            map.invalidateSize();
        });
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        map.on('click', function (e) {
            map.eachLayer(function (layer) {
                if (layer instanceof L.Marker) {
                    map.removeLayer(layer);
                }
            });
            L.marker(e.latlng).on('click', function (e) { }).addTo(map);


            $('#terminal_lat').val(e.latlng.lat);
            $('#terminal_lng').val(e.latlng.lng);
        });


        coreEvents.insertHandler = {
            placeholder: 'Berhasil menyimpan data Lokasi Posko',
            afterAction: function (result) {
                map.eachLayer(function (layer) {
                    if (layer instanceof L.Marker) {
                        map.removeLayer(layer);
                    }
                    if (layer instanceof L.Polyline) {
                        map.removeLayer(layer);
                        map.setView([-6.966667, 110.416664], 13);
                    }
                });
                // reload window
                window.location.reload();
            }
        }

        coreEvents.editHandler = {
            placeholder: '',
            afterAction: function (result) {
                // console.log(result);
                map.eachLayer(function (layer) {
                    if (layer instanceof L.Marker) {
                        map.removeLayer(layer);
                    }
                    if (layer instanceof L.Polyline) {
                        map.removeLayer(layer);
                    }
                });

                var customMarker = L.icon({
                    iconUrl: '<?= base_url() ?>/assets/icon/posko.png',
                    iconSize: [38, 38],
                    iconAnchor: [22, 94],
                    popupAnchor: [-3, -76]
                });

                var customPopup = result.data.posko_mudik_name + "<br>" + result.data.posko_mudik_address;
                var customOptions = {
                    'maxWidth': '300',
                    'className': 'custom'
                }
                var latLong = [result.data.posko_mudik_latlong];
                var lt = latLong[0].split(",")[0];
                var lg = latLong[0].split(",")[1];
                var latlng = new L.LatLng(lt, lg);
                var lat = latlng.lat;
                var lng = latlng.lng;
                map.setView(latlng, 15);
                var marker = L.marker([lat, lng],{ draggable:true }).bindPopup(customPopup,
                    customOptions).on('click', function (e) { }).addTo(map);


                map.on('click', function (e) {
                    map.eachLayer(function (layer) {
                        if (layer instanceof L.Marker) {
                            map.removeLayer(layer);
                        }
                    });
                    marker = L.marker(e.latlng,{ draggable:true }).addTo(map);


                    $('#posko_mudik_latlong').val(e.latlng.lat.toFixed(6) + ',' + e.latlng.lng.toFixed(6));
                    marker.on('dragend', function (e) {
                        $('#posko_mudik_latlong').val(marker.getLatLng().lat.toFixed(6) + ',' + marker.getLatLng().lng.toFixed(6));
                    });
                });

                marker.on('dragend', function (e) {
                    $('#posko_mudik_latlong').val(marker.getLatLng().lat.toFixed(6) + ',' + marker.getLatLng().lng.toFixed(6));
                });

                $('#klas_posko_id').html('<option value = "' + result.data.klas_posko_id + '" selected >' + result
                    .data.klas_posko + '</option>');
                $('#lokprov_id').html('<option value = "' + result.data.lokprov_id + '" selected >' + result
                    .data.prov + '</option>');
                $('#idkabkota').html('<option value = "' + result.data.idkabkota + '" selected >' + result
                    .data.kabkota + '</option>');

            }
        }

        coreEvents.deleteHandler = {
            placeholder: 'Berhasil menghapus data Lokasi Posko',
            afterAction: function () {

            }
        }

        coreEvents.resetHandler = {
            action: function () {

            }
        }

        coreEvents.load();

        select2Array.forEach(function (x) {
            coreEvents.select2Init('#' + x.id, x.url, x.placeholder, x.params, null);
        });

    });

    function select2Init(id, url, placeholder, parameter) {
        $(id).select2({
            id: function(e) {
                return e.id
            },
            placeholder: placeholder,
            multiple: false,
            ajax: {
                url: url_ajax + url,
                dataType: 'json',
                quietMillis: 500,
                delay: 500,
                data: function(param) {
                    var def_param = {
                        keyword: param.term, //search term
                        perpage: 5, // page size
                        page: param.page || 0, // page number
                    };

                    return Object.assign({}, def_param, parameter);
                },
                processResults: function(data, params) {
                    params.page = params.page || 0

                    return {
                        results: data.rows,
                        pagination: {
                            more: false
                        }
                    }
                }
            },
            templateResult: function(data) {
                return data.text;
            },
            templateSelection: function(data) {
                if (data.id === '') {
                    return placeholder;
                }

                return data.text;
            },
            escapeMarkup: function(m) {
                return m;
            }
        });
    }


    function datatableColumn() {
        let columns = [{
            data: "id",
            orderable: false,
            width: 100,
            render: function (a, type, data, index) {
                return dataStart + index.row + 1
            }
        },
        {
            data: "klas_posko",
            orderable: true
        },
        {
            data: "posko_mudik_name",
            orderable: true
        },
        {
            data: "prov",
            orderable: true,
            render: function (a, type, data, index) {
                return data.prov+'<br/>'+data.kabkota
            }
        },
        {
            data: "posko_mudik_address",
            width: '250px',
            orderable: true,
            render: function (a, type, data, index) {
                return data.posko_mudik_address
            }
        },
        {
            data: "id",
            orderable: false,
            render: function (a, type, data, index) {
                let button = ''

                if (auth_edit == "1") {
                    button += '<button class="btn btn-sm btn-outline-primary edit" data-id="' + data.id + '" title="Edit">\
                                    <i class="fa fa-edit"></i>\
                                </button>\
                                ';
                }

                if (auth_delete == "1") {
                    button += '<button class="btn btn-sm btn-outline-danger delete" data-id="' + data.id + '" title="Delete">\
                                        <i class="fa fa-trash-o"></i>\
                                    </button></div>';
                }


                button += (button == '') ? "<b>Tidak ada aksi</b>" : ""

                return button;
            }
        }
        ];

        return columns;
    }


</script>