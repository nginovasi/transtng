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
									<div class="px-4">
										<div class="text-center mb-3 bg-primary">
											<small class="font-weight-bold">Aktivitas</small>
										</div>
										<div class="row text-center mb-5">
											<div class="col">
												<span class="text-sm">Penumpang Hari Ini</span>
												<div class="text-muted text-md">0</div>
											</div>
											<div class="col">
												<span class="text-sm">Pendapatan Hari Ini</span>
												<div class="text-muted text-md">Rp. 0</div>
											</div>
										</div>
										<div class="row text-center mb-5">
											<div class="col">
												<span class="text-sm">Jumlah Pegawai</span>
												<div class="text-muted text-md">0</div>
											</div>
											<div class="col">
												<span class="text-sm">Jumlah Jalur</span>
												<div class="text-muted text-md">0</div>
											</div>
										</div>
										<div class="row text-center mb-5">
											<div class="col">
												<span class="text-sm">POS On Bus</span>
												<div class="text-muted text-md">0</div>
											</div>
											<div class="col">
												<span class="text-sm">POS On Halte</span>
												<div class="text-muted text-md">0</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<div class="row">
						<div class="col-md-3" style="border-right: 1px solid #e0e0e0; border-bottom: 1px solid #e0e0e0;">
							<!-- <div class=" p-3">.col-md-3</div> -->
							<div class="row d-flex">
								<div class="col-md-9">
									<h5 class="text-left">AstraPay</h5>
									<h6 class="text-sm-left text-muted">Penumpang Hari Ini</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center">0</h5>
								</div>
							</div>
							<br>
							<div class="row d-flex">
								<div class="col-md-9">
									<h6 class="text-sm-left text-muted">(0)</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center"><i class="fa fa-arrow-down" aria-hidden="true"></i></h5>
								</div>
							</div>
							<div class="row d-flex">
								<div class="col-md-9">
									<h6 class="text-sm-left text-muted">Penumpang kemarin</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center">0</h5>
								</div>
							</div>
						</div>
						<div class="col-md-3" style="border-right: 1px solid #e0e0e0; border-bottom: 1px solid #e0e0e0;">
							<!-- <div class=" p-3">.col-md-3</div> -->
							<div class="row d-flex">
								<div class="col-md-9">
									<h5 class="text-left">AstraPay</h5>
									<h6 class="text-sm-left text-muted">Penumpang Hari Ini</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center">0</h5>
								</div>
							</div>
							<br>
							<div class="row d-flex">
								<div class="col-md-9">
									<h6 class="text-sm-left text-muted">(0)</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center"><i class="fa fa-arrow-down" aria-hidden="true"></i></h5>
								</div>
							</div>
							<div class="row d-flex">
								<div class="col-md-9">
									<h6 class="text-sm-left text-muted">Penumpang kemarin</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center">0</h5>
								</div>
							</div>
						</div>
						<div class="col-md-3" style="border-right: 1px solid #e0e0e0; border-bottom: 1px solid #e0e0e0;">
							<!-- <div class=" p-3">.col-md-3</div> -->
							<div class="row d-flex">
								<div class="col-md-9">
									<h5 class="text-left">AstraPay</h5>
									<h6 class="text-sm-left text-muted">Penumpang Hari Ini</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center">0</h5>
								</div>
							</div>
							<br>
							<div class="row d-flex">
								<div class="col-md-9">
									<h6 class="text-sm-left text-muted">(0)</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center"><i class="fa fa-arrow-down" aria-hidden="true"></i></h5>
								</div>
							</div>
							<div class="row d-flex">
								<div class="col-md-9">
									<h6 class="text-sm-left text-muted">Penumpang kemarin</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center">0</h5>
								</div>
							</div>
						</div>
						<div class="col-md-3" style="border-right: 1px solid #e0e0e0; border-bottom: 1px solid #e0e0e0;">
							<!-- <div class=" p-3">.col-md-3</div> -->
							<div class="row d-flex">
								<div class="col-md-9">
									<h5 class="text-left">AstraPay</h5>
									<h6 class="text-sm-left text-muted">Penumpang Hari Ini</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center">0</h5>
								</div>
							</div>
							<br>
							<div class="row d-flex">
								<div class="col-md-9">
									<h6 class="text-sm-left text-muted">(0)</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center"><i class="fa fa-arrow-down" aria-hidden="true"></i></h5>
								</div>
							</div>
							<div class="row d-flex">
								<div class="col-md-9">
									<h6 class="text-sm-left text-muted">Penumpang kemarin</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center">0</h5>
								</div>
							</div>
						</div>
						<div class="col-md-3" style="border-right: 1px solid #e0e0e0; border-bottom: 1px solid #e0e0e0;">
							<!-- <div class=" p-3">.col-md-3</div> -->
							<div class="row d-flex">
								<div class="col-md-9">
									<h5 class="text-left">AstraPay</h5>
									<h6 class="text-sm-left text-muted">Penumpang Hari Ini</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center">0</h5>
								</div>
							</div>
							<br>
							<div class="row d-flex">
								<div class="col-md-9">
									<h6 class="text-sm-left text-muted">(0)</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center"><i class="fa fa-arrow-down" aria-hidden="true"></i></h5>
								</div>
							</div>
							<div class="row d-flex">
								<div class="col-md-9">
									<h6 class="text-sm-left text-muted">Penumpang kemarin</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center">0</h5>
								</div>
							</div>
						</div>
						<div class="col-md-3" style="border-right: 1px solid #e0e0e0; border-bottom: 1px solid #e0e0e0;">
							<!-- <div class=" p-3">.col-md-3</div> -->
							<div class="row d-flex">
								<div class="col-md-9">
									<h5 class="text-left">AstraPay</h5>
									<h6 class="text-sm-left text-muted">Penumpang Hari Ini</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center">0</h5>
								</div>
							</div>
							<br>
							<div class="row d-flex">
								<div class="col-md-9">
									<h6 class="text-sm-left text-muted">(0)</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center"><i class="fa fa-arrow-down" aria-hidden="true"></i></h5>
								</div>
							</div>
							<div class="row d-flex">
								<div class="col-md-9">
									<h6 class="text-sm-left text-muted">Penumpang kemarin</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center">0</h5>
								</div>
							</div>
						</div>
						<div class="col-md-3" style="border-right: 1px solid #e0e0e0; border-bottom: 1px solid #e0e0e0;">
							<!-- <div class=" p-3">.col-md-3</div> -->
							<div class="row d-flex">
								<div class="col-md-9">
									<h5 class="text-left">AstraPay</h5>
									<h6 class="text-sm-left text-muted">Penumpang Hari Ini</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center">0</h5>
								</div>
							</div>
							<br>
							<div class="row d-flex">
								<div class="col-md-9">
									<h6 class="text-sm-left text-muted">(0)</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center"><i class="fa fa-arrow-down" aria-hidden="true"></i></h5>
								</div>
							</div>
							<div class="row d-flex">
								<div class="col-md-9">
									<h6 class="text-sm-left text-muted">Penumpang kemarin</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center">0</h5>
								</div>
							</div>
						</div>
						<div class="col-md-3" style="border-right: 1px solid #e0e0e0; border-bottom: 1px solid #e0e0e0;">
							<!-- <div class=" p-3">.col-md-3</div> -->
							<div class="row d-flex">
								<div class="col-md-9">
									<h5 class="text-left">AstraPay</h5>
									<h6 class="text-sm-left text-muted">Penumpang Hari Ini</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center">0</h5>
								</div>
							</div>
							<br>
							<div class="row d-flex">
								<div class="col-md-9">
									<h6 class="text-sm-left text-muted">(0)</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center"><i class="fa fa-arrow-down" aria-hidden="true"></i></h5>
								</div>
							</div>
							<div class="row d-flex">
								<div class="col-md-9">
									<h6 class="text-sm-left text-muted">Penumpang kemarin</h6>
								</div>
								<div class="col-md-3">
									<h5 class="text-primary text-md-center">0</h5>
								</div>
							</div>
						</div>
						<!-- <div class="col-md-3" style="border-right: 1px solid #e0e0e0;">
							<div class=" p-3">.col-md-3</div>
						</div>
						<div class="col-md-3" style="border-right: 1px solid #e0e0e0;">
							<div class=" p-3">.col-md-3</div>
						</div>
						<div class="col-md-3" style="border-right: 1px solid #e0e0e0;">
							<div class=" p-3">.col-md-3</div>
						</div>
						<div class="col-md-3" style="border-right: 1px solid #e0e0e0;">
							<div class=" p-3">.col-md-3</div>
						</div>
						<div class="col-md-3" style="border-right: 1px solid #e0e0e0;">
							<div class=" p-3">.col-md-3</div>
						</div>
						<div class="col-md-3" style="border-right: 1px solid #e0e0e0;">
							<div class=" p-3">.col-md-3</div>
						</div>
						<div class="col-md-3" style="border-right: 1px solid #e0e0e0;">
							<div class=" p-3">.col-md-3</div>
						</div> -->
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
	});

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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