<?php
$session = \Config\Services::session();
?>
<!-- style internal -->
<style>
	.select2-container {
		width: 100% !important;
	}

	.leaflet-container a {
		color: #000 !important;
	}
</style>
<link rel="stylesheet" href="<?= base_url() ?>/assets/js/Leaflet.Legend/src/leaflet.legend.css" />
<script type="text/javascript" src="<?= base_url() ?>/assets/js/Leaflet.Legend/src/leaflet.legend.js"></script>
<!-- Dashboard -->
<div id="content" class="flex ">
	<!-- ############ Main START-->
	<div>
		<div class="page-hero page-container " id="page-hero">
			<div class="padding d-flex">
				<div class="page-title">
					<h2 class="text-md text-highlight">Dashboard</h2>
					<small class="text-muted">Welcome aboard,<strong><?= $session->get('name') ?></strong> (<?= $session->get('role_name') ?>)</small>
				</div>
				<div class="flex"></div>
				<!-- <div>
					<a href="https://themeforest.net/item/basik-responsive-bootstrap-web-admin-template/23365964" class="btn btn-md text-muted">
						<span class="d-none d-sm-inline mx-1">Buy this Item</span>
						<i data-feather="arrow-right"></i>
					</a>
				</div> -->
			</div>
		</div>
		<div class="page-content page-container" id="page-content">
			<div class="card text-center">
				<div class="card-header text-uppercase font-weight-bold">Mapping dan Pendapatan Umum</div>
				<div class="card-body">
					<!-- <h5 class="card-title">Special title treatment</h5>
					<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
					<a href="#" class="btn btn-primary">Go somewhere</a> -->
					<div class="row">
						<div class="col-xl-8 col-lg-12 col-md-12">
							<div style="z-index: 3 !important;position: absolute;margin-top: 10px;margin-left: 200px;">
								<!-- <select class="form-control" id="select-koridor"></select> -->
							</div>
							<div id="map" style="height: 600px"></div>
						</div>
						<div class="col-xl-4 col-lg-12 col-md-12">
							<div class="card flex" data-sr-id="9" style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
								<div class="card-body">
									<div class="all-aktivitas">
										<div class="text-center mb-3 bg-primary">
											<small class="font-weight-bold">Aktivitas Transaksi</small>
										</div>
										<div class="row text-center mb-2">
											<div class="col-6 px-2">
												<span class="text-sm">Pendapatan Hari Ini</span>
												<div class="text-md font-weight-bold text-primary" id="ttl_kredit_now">Rp. 0</div>
											</div>
											<div class="col-6">
												<span class="text-sm">Penumpang Hari Ini</span>
												<div class="text-md font-weight-bold text-primary" id="ttl_penumpang_now">0</div>
											</div>
										</div>
										<div class="row text-center mb-3">
											<div class="col">
												<span class="text-sm">Jumlah Jalur</span>
												<div class="text-md font-weight-bold text-primary" id="ttl_jalur">0</div>
											</div>
											<div class="col">
												<span class="text-sm">Jumlah TOB</span>
												<div class="text-md font-weight-bold text-primary" id="ttl_tob">0 <small class="text-muted" id="ttl_tob_offline">(0)</small></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card flex" data-sr-id="9" style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
								<div class="card-body">
									<div class="">
										<div class="text-center mb-3 bg-primary">
											<small class="font-weight-bold">Aktivitas Grafik</small>
										</div>
										<div class="row text-center mb-3">
											<div class="col">
												<div id="ttl_trans30day_kredit"></div>
											</div>
										</div>
										<div class="row text-center mb-3">
											<div class="col">
												<div id="ttl_trans30day_penumpang"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<div class="row" id="jenis-transaksi">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="card">
						<div class="card-header text-uppercase font-weight-bold">Pendapatan per Jalur</div>
						<div class="card-body">
							<div class="mb-3">
								<ul class="nav nav-pills nav-fill" id="jalur" role="tablist">
									<!-- <li class="nav-item">
										<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home2" role="tab" aria-controls="home" aria-selected="true">Home</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile2" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact2" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
									</li> -->
								</ul>
							</div>
							<div class="tab-content mb-4" id="content-jalur">
								<!-- <div class="tab-pane fade show active" id="home2" role="tabpanel" aria-labelledby="home-tab">
									<p>Nisl natoque suspendisse consequat, nulla et facilisis tristique interdum duis nibh sagittis, magna arcu luctus ac in tortor ipsum convallis</p>
								</div>
								<div class="tab-pane fade" id="profile2" role="tabpanel" aria-labelledby="profile-tab">
									<p>Nisi, mattis sit sed dis suspendisse faucibus pellentesque at vitae quis turpis odio risus congue mi suspendisse sapien, cras cursus</p>
								</div>
								<div class="tab-pane fade" id="contact2" role="tabpanel" aria-labelledby="contact-tab">
									<p>Sit diam facilisis dictumst eu lectus felis sapien id imperdiet non cursus facilisis orci hendrerit nunc, id sed montes, id</p>
								</div> -->
							</div>
						</div>
						<div class="card-footer"></div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card">
						<div class="card-header text-uppercase font-weight-bold">Penumpang per jenis pembayaran</div>
						<div class="card-body"></div>
						<div class="card-footer"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- ############ Main END-->
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- script internal -->
<script type="text/javascript">
	const base_url = '<?= base_url() ?>';
	const url = '<?= base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1) ?>';
	const url_ajax = '<?= base_url() . "/" . uri_segment(0) . "/ajax" ?>';

	var dataStart = 0;
	var coreEvents;

	var chart1 = null;
	var chart2 = null;

	// init select2
	const select2Array = [{
		id: 'select-koridor',
		url: '/findByKoridor',
		placeholder: 'Semua Jalur',
		params: null
	}];

	$(document).ready(function() {
		// init core event
		coreEvents = new CoreEvents();
		coreEvents.url = url;
		coreEvents.ajax = url_ajax;
		coreEvents.csrf = {
			"<?= csrf_token() ?>": "<?= csrf_hash() ?>"
		};

		// datatable load
		// coreEvents.tableColumn = datatableColumn();

		// insert
		coreEvents.insertHandler = {}

		// update
		coreEvents.editHandler = {}

		// delete
		coreEvents.deleteHandler = {}

		// reset
		coreEvents.resetHandler = {}

		select2Array.forEach(function(x) {
			coreEvents.select2Init('#' + x.id, x.url, x.placeholder, x.params);
		});

		coreEvents.load(null, [0, 'asc'], null);

		var map = L.map('map').setView([-6.178306, 106.631889], 13);
		L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
			maxZoom: 20,
			attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">TNG</a> contributors',
			subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
		}).addTo(map);

		loadAllAjax();

	});

	function loadAllAjax() {
		var ajaxPromises = [];

		var getAllTransaksi =
			$.ajax({
				url: url_ajax + '/getAllTransaksi',
				type: 'GET',
				dataType: 'json',
				beforeSend: function() {
					$('#ttl_penumpang_now').html('<div class="col-sm-12 text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>');
					$('#ttl_kredit_now').html('<div class="col-sm-12 text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>');
				},
				success: function(res) {
					if (res) {
						$('#ttl_penumpang_now').html(numberWithCommas(res.data.total_penumpang));
						$('#ttl_kredit_now').html('Rp ' + numberWithCommas(res.data.total_kredit));
					} else {
						$('#all-aktivitas').html('<div class="col-md-12 text-center">Data tidak ditemukan</div>');
					}
				},
				error: function(err) {
					console.log(err);
				}
			});
		ajaxPromises.push(getAllTransaksi);

		var getAllDevice =
			$.ajax({
				url: url_ajax + '/getAllDevice',
				type: 'GET',
				dataType: 'json',
				beforeSend: function() {
					$('#ttl_tob').html('<div class="col-sm-12 text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>');
				},
				success: function(res) {
					data = res.data;
					if (res) {
						$('#ttl_tob').html(data.ttl_tob + ' <small class="text-muted" id="ttl_tob_offline">(' + data.ttl_tob_online + ' Online)</small>');

					} else {
						$('#all-aktivitas').html('<div class="col-md-12 text-center">Data tidak ditemukan</div>');
					}
				},
				error: function(err) {
					console.log(err);
				}
			});
		ajaxPromises.push(getAllDevice);

		var getAllJalur =
			$.ajax({
				url: url_ajax + '/getAllJalur',
				type: 'GET',
				dataType: 'json',
				beforeSend: function() {
					$('#ttl_jalur').html('<div class="col-sm-12 text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>');
				},
				success: function(res) {
					data = res.data;
					if (res) {
						$('#ttl_jalur').html(data.ttl_jalur);
					} else {
						$('#all-aktivitas').html('<div class="col-md-12 text-center">Data tidak ditemukan</div>');
					}
				},
				error: function(err) {
					console.log(err);
				}
			});
		ajaxPromises.push(getAllJalur);

		var getAllJalurTransaksi =
			$.ajax({
				url: url_ajax + '/getAllTransaksiJalur',
				type: 'GET',
				dataType: 'json',
				beforeSend: function() {
					// $('#jalur').html('<div class="col-sm-12 text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>');
				},
				success: function(res) {
					if (res) {
						// nav-item as jalur 
						var htmlNav = '';
						// tab-pane as jalur
						var htmlTab = '';
						var data = res.data;
						data.forEach(function(x) {
							if (x.id == 1) {
								no = 1;
								htmlNav += `<li class="nav-item">
												<a class="nav-link active text-sm px-1 py-1" id="` + x.id + `-tab" data-toggle="tab" href="#` + x.id + `" role="tab" aria-controls="` + x.id + `" aria-selected="false">` + x.jalur + `</a>
											</li>`;
								htmlTab += `<div class="tab-pane fade show active" id="` + x.id + `-jalur" role="tabpanel" aria-labelledby="` + x.id + `-tab">
												<div class="table-responsive">
													<table class="table table-striped table-hover" id="table-` + x.id + `">
														<thead>
															<tr>
																<th>No</th>
																<th>Rute</th>
																<th>Penumpang</th>
																<th>Pendapatan</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>` + no++ + `</td>
																<td>` + x.rute + `</td>
																<td>` + x.ttl_penumpang_jalur + `</td>
																<td>Rp ` + numberWithCommas(x.ttl_pendapatan_jalur) + `</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>`;
							} else {
								htmlNav += `<li class="nav-item">
												<a class="nav-link text-sm px-1 py-1" id="` + x.id + `-tab" data-toggle="tab" href="#` + x.id + `-jalur" role="tab" aria-controls="` + x.id + `" aria-selected="false">` + x.jalur + `</a>
											</li>`;
								htmlTab += `<div class="tab-pane fade" id="` + x.id + `-jalur" role="tabpanel" aria-labelledby="` + x.id + `-tab">
												<div class="table-responsive">
													<table class="table table-striped table-hover" id="table-` + x.id + `">
														<thead>
															<tr>
																<th>No</th>
																<th>Device</th>
																<th>Penumpang</th>
																<th>Pendapatan</th>
																<th>Tanggal</th>
															</tr>
														</thead>
														<tbody>
														</tbody>
													</table>
												</div>
											</div>`;
							}
						});
						$('#jalur').html(htmlNav);
						$('#content-jalur').html(htmlTab);
					}
				},
				error: function(err) {
					console.log(err);
				}
			});
		var getJenisTransaksi =
			$.ajax({
				url: url_ajax + '/getJenisTransaksi',
				type: 'GET',
				dataType: 'json',
				beforeSend: function() {
					$('#jenis-transaksi').html('<div class="col-md-12 text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>');
				},
				success: function(res) {
					if (res) {
						var data = res.data;
						var html = '';
						data.forEach(function(x) {
							if (x.selisih_penumpang == '0') {
								$color = 'color: grey !important';
								$icon = '<i class="fa fa-exchange" aria-hidden="true" style="' + $color + '"></i>';
							} else if (x.selisih_penumpang > 0) {
								$color = 'color: green !important';
								$icon = '<i class="fa fa-arrow-up" aria-hidden="true" style="' + $color + '"></i>';
							} else {
								$color = 'color: red !important';
								$icon = '<i class="fa fa-arrow-down" aria-hidden="true" style="' + $color + '"></i>';
							}

							html += `
						<div class="col-md-3 py-3" style="border-right: 1px solid #e0e0e0;">
							<div class="row d-flex">
								<div class="col-md-9">
									<h5 class="text-left">` + x.jenis_transaksi + `</h5>
									<h6 class="text-sm-left text-muted">Penumpang Hari Ini</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center">` + numberWithCommas(x.total_penumpang) + `</h5>
								</div>
							</div>
							<br>
							<div class="row d-flex">
								<div class="col-md-9">
									<h6 class="text-sm-left text-muted">(` + numberWithCommas(x.selisih_penumpang) + `)</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center">` + $icon + `</h5>
								</div>
							</div>
							<div class="row d-flex">
								<div class="col-md-9">
									<h6 class="text-sm-left text-muted">Penumpang kemarin</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center">` + numberWithCommas(x.penumpang_kemarin) + `</h5>
								</div>
							</div>
						</div>`;
						});
						$('#jenis-transaksi').html(html);
					} else {
						$('#jenis-transaksi').html('<div class="col-md-12 text-center">Data tidak ditemukan</div>');
					}
				},
				error: function(err) {
					console.log(err);
				}
			});
		ajaxPromises.push(getJenisTransaksi);

		var sumTransaksi30 =
			$.ajax({
				url: url_ajax + '/sumTransaksi30',
				type: 'GET',
				dataType: 'json',
				beforeSend: function() {
					$('#ttl_trans30day_kredit').html('<div class="col-sm-12 text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>');
				},
				success: function(res) {
					var data = res.data;
					// to array
					tgl_transaksi = [];
					sum_value = [];
					sum_penumpang = [];
					data.forEach(function(x) {
						tgl_transaksi.push(x.tgl_transaksi);
						sum_value.push(x.sum_value);
						sum_penumpang.push(x.sum_penumpang);
					});

					if (res) {
						$('#ttl_trans30day_kredit').html('');
						$('#ttl_trans30day_penumpang').html('');
						var options = {
							chart: {
								type: 'area',
								height: 130,
								foreColor: 'currentColor',
								sparkline: {
									enabled: true
								},
								zoom: {
									enabled: false
								}
							},
							stroke: {
								curve: 'straight'
							},
							fill: {
								opacity: 0.3
							},
							series: [{
								name: 'Pendapatan',
								data: sum_value
							}],
							grid: {
								row: {
									colors: ['#E2E2E2', 'transparent'],
									opacity: 0.5
								},
							},
							markers: {
								size: 4
							},
							tooltip: {
								y: {
									formatter: function(value) {
										return 'Rp. ' + value.toLocaleString();
									}
								}
							},
							dataLabels: {
								enabled: false
							},
							title: {
								text: 'Pendapatan 30 Hari Terakhir',
								offsetX: 0,
								style: {
									fontSize: '18px',
									cssClass: 'apexcharts-yaxis-title'
								}
							},
							xaxis: {
								categories: tgl_transaksi,
								labels: {
									formatter: function(value) {
										var options = {
											weekday: 'long',
											day: 'numeric',
											month: 'long',
											year: 'numeric'
										};
										var date = new Date(value);
										return date.toLocaleDateString('id-ID', options);
									}
								},
								crosshairs: {
									width: 1
								},
							},
							yaxis: {
								min: 0
							},
						}

						var options2 = {
							chart: {
								type: 'bar',
								height: 130,
								foreColor: 'currentColor',
								sparkline: {
									enabled: true
								},
								zoom: {
									enabled: false
								}
							},
							grid: {
								row: {
									colors: ['#E2E2E2', 'transparent'],
									opacity: 0.5
								},
							},
							plotOptions: {
								bar: {
									columnWidth: '50%'
								}
							},
							series: [{
								name: 'Penumpang',
								data: sum_penumpang
							}],
							dataLabels: {
								enabled: false
							},
							title: {
								text: 'Penumpang 30 Hari Terakhir',
								offsetX: 0,
								style: {
									fontSize: '18px',
									cssClass: 'apexcharts-yaxis-title'
								}
							},
							xaxis: {
								categories: tgl_transaksi,
								labels: {
									// rotate: -45,
									formatter: function(value) {
										var options = {
											weekday: 'long',
											day: 'numeric',
											month: 'long',
											year: 'numeric'
										};
										var date = new Date(value);
										return date.toLocaleDateString('id-ID', options);
									}
								},
								crosshairs: {
									width: 1
								},
							},
							tooltip: {
								fixed: {
									enabled: false
								},
								x: {
									show: true
								},
								y: {
									title: {
										formatter: function(seriesName, opts) {
											return 'Penumpang';
										}
									}
								},
								marker: {
									show: false
								}
							}
						}
						new ApexCharts(document.querySelector("#ttl_trans30day_kredit"), options).render();
						new ApexCharts(document.querySelector("#ttl_trans30day_penumpang"), options2).render();
					}
				},
				error: function(err) {
					console.log(err);
				}
			});
		ajaxPromises.push(sumTransaksi30);

		$.when.apply($, ajaxPromises).then(function() {
			// console.log('done');
		});
	}

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	}

	function addLeadingZero(value) {
		return value < 10 ? "0" + value : value;
	}

	function get_random_color() {
		var letters = '0123456789ABCDEF'.split('');
		var color = '#';
		for (var i = 0; i < 6; i++) {
			color += letters[Math.round(Math.random() * 15)];
		}
		return color;
	}
</script>