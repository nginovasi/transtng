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
									<div class="">
										<div class="text-center mb-3 bg-primary">
											<small class="font-weight-bold">Aktivitas</small>
										</div>
										<div class="row text-center">
											<div class="col">
												<h3 id="clock"></h3>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card flex" data-sr-id="9" style="visibility: visible; transform: none; opacity: 1; transition: none 0s ease 0s;">
								<div class="card-body">
									<div class="all-aktivitas">
										<div class="text-center mb-3 bg-primary">
											<small class="font-weight-bold">Aktivitas</small>
										</div>
										<div class="row text-center mb-3">
											<div class="col">
												<span class="text-sm">Penumpang Hari Ini</span>
												<div class="text-sm font-weight-bold text-primary" id="ttl_penumpang_now">0</div>
											</div>
											<div class="col">
												<span class="text-sm">Pendapatan Hari Ini</span>
												<div class="text-sm font-weight-bold text-primary" id="ttl_kredit_now">Rp. 0</div>
											</div>
										</div>
										<div class="row text-center mb-3">
											<div class="col">
												<span class="text-sm">Jumlah Jalur</span>
												<div class="text-sm font-weight-bold text-primary" id="ttl_jalur">0</div>
											</div>
											<div class="col">
												<span class="text-sm">Jumlah TOB</span>
												<div class="text-sm font-weight-bold text-primary" id="ttl_tob">0 <small class="text-muted" id="ttl_tob_offline">(0)</small></div>
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
		setInterval(updateClock, 1000);
	});

	function loadAllAjax() {
		var ajaxPromises = [];
		var getAllTransaksi = 
		$.ajax({
			url: url_ajax + '/getAllTransaksi',
			type: 'GET',
			dataType: 'json',
			beforeSend: function() {
				$('#ttl_penumpang_now').html('<div class="col-sm-12 text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
				$('#ttl_kredit_now').html('<div class="col-sm-12 text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
			},
			success: function(res) {
				if (res) {
					$('#ttl_penumpang_now').html(numberWithCommas(res.data.total_penumpang));
					$('#ttl_kredit_now').html('Rp. ' + numberWithCommas(res.data.total_kredit));
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
					$('#ttl_tob').html('<div class="col-sm-12 text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
				},
				success: function(res) {
					data = res.data;
					if (res) {
						$('#ttl_tob').html(data.ttl_tob + ' <small class="text-muted" id="ttl_tob_offline">(' + data.ttl_tob_offline + ')</small>');

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
					$('#ttl_jalur').html('<div class="col-sm-12 text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
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
		
		var getJenisTransaksi =
			$.ajax({
				url: url_ajax + '/getJenisTransaksi',
				type: 'GET',
				dataType: 'json',
				beforeSend: function() {
					$('#jenis-transaksi').html('<div class="col-md-12 text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>');
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

		$.when.apply($, ajaxPromises).then(function() {
			console.log('done');
		});
	}

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

	function updateClock() {
		var now = new Date();
		var hours = now.getHours();
		var minutes = now.getMinutes();
		var seconds = now.getSeconds();

		// Add leading zeros to hours, minutes, and seconds
		hours = addLeadingZero(hours);
		minutes = addLeadingZero(minutes);
		seconds = addLeadingZero(seconds);

		// Display the time in the "clock" element
		var clockElement = document.getElementById("clock");
		clockElement.textContent = hours + ":" + minutes + ":" + seconds;
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