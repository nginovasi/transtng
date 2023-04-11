<?php
$session = \Config\Services::session();
?>
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
			<div class="card">
				<div class="card-header">Mapping dan Pendapatan Umum</div>
				<div class="card-body">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<div class="col-xl-8 col-lg-12 col-md-12" style="position: relative">
							<div style="z-index: 3; position: absolute;margin-top:10px; margin-left:200px">
								<select class="form-control" id="select-koridor">
									<option value="" selected="">Semua Jalur</option>
									<option value="1A">Jalur 1A</option>
									<option value="1B">Jalur 1B</option>
									<option value="2A">Jalur 2A</option>
									<option value="2B">Jalur 2B</option>
									<option value="3A">Jalur 3A</option>
									<option value="3B">Jalur 3B</option>
									<option value="4A">Jalur 4A</option>
									<option value="4B">Jalur 4B</option>
									<option value="5A">Jalur 5A</option>
									<option value="5B">Jalur 5B</option>
									<option value="6A">Jalur 6A</option>
									<option value="6B">Jalur 6B</option>
									<option value="7">Jalur 7</option>
									<option value="8">Jalur 8</option>
									<option value="9">Jalur 9</option>
									<option value="10">Jalur 10</option>
									<option value="11">Jalur 11</option>
									<option value="CAD1">Jalur CAD1</option>
									<option value="CAD2">Jalur CAD2</option>
									<option value="13">Jalur 13</option>
									<option value="14">Jalur 14</option>
									<option value="15">Jalur 15</option>
								</select>
							</div>
							<div class="page-map page-container " id="page-map">
								<!-- <div class="padding"> -->
								<div class="card">
									<div id="card-body">
										<div id="map"></div>
									</div>
								</div>
								<!-- </div> -->
							</div>
						</div>
						<div class="col-xl-4 col-lg-12 col-md-12">
							<div class="card">
								<div class="card-header">Featured</div>
								<!-- <div class="card-body">
									<h5 class="card-title">Special title treatment</h5>
									<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
									<a href="#" class="btn btn-primary">Go somewhere</a>
								</div> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- ############ Main END-->
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
	$(document).ready(function() {

		var stateChangingButton = L.easyButton({
			states: [{
				stateName: 'zoom-to-indonesia', // name the state
				icon: 'fa-globe', // and define its properties
				title: 'zoom to a indonesia', // like its title
				onClick: function(btn, map) { // and its callback
					map.setView([-0.789275, 113.921327], 5);
					btn.state('zoom-to-java'); // change state on click!
				}
			}, {
				stateName: 'zoom-to-java',
				icon: 'fa-map',
				title: 'zoom to a java',
				onClick: function(btn, map) {
					map.setView([-7.614529, 110.712246], 7);
					btn.state('zoom-to-indonesia');
				}
			}]
		});

		stateChangingButton.addTo(map);
	});

	var google = L.tileLayer("https://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}", {
		maxZoom: 20,
		subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
		attribution: '&copy; Trans Tangerang <?php echo date("Y"); ?>'
	});

	var satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {});
	var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 20});

	var map = L.map('map', {
		center: [-0.789275, 113.921327],
		zoom: 5,
		fullscreenControl: true,
		layers: [satellite, osm, google]
	});

	var baseMaps = {
		"Satellite": satellite,
		"OSM": osm,
		"Google": google,
	};

		// var atms = L.layerGroup();
		var cctv = L.layerGroup();
	var kspn = L.layerGroup();
	var terminal = L.layerGroup();
	var jto = L.layerGroup();
	// var trafficLight = L.layerGroup();
	// var simpang = L.layerGroup();
	// var ruteMudik = L.layerGroup();
	var poskoMudik = L.layerGroup();
    var ruteArusMudik = L.layerGroup();
    var ruteArusBalik = L.layerGroup();


	var overlays = {
		// "ATMS": atms,
		// "CCTV": cctv,
		// "KSPN": kspn,
		// "Terminal": terminal,
		// "JTO": jto,
		// "Traffic Light": trafficLight,
		// "Simpang": simpang,
		// "Rute Mudik": ruteMudik,
		// "Posko Mudik": poskoMudik,
        // "Rute Arus Mudik": ruteArusMudik,
        // "Rute Arus Balik": ruteArusBalik,
	};

	L.control.layers(baseMaps, overlays).addTo(map);

	function get_random_color() {
		var letters = '0123456789ABCDEF'.split('');
		var color = '#';
		for (var i = 0; i < 6; i++) {
			color += letters[Math.round(Math.random() * 15)];
		}
		return color;
	}
</script>