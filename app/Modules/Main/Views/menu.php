<?php
$session = \Config\Services::session();
$user = $session->get('name');
$request = \Config\Services::request();
$uri = $request->uri;
$module_active = $uri->getSegment(1); 

?>
<style type="text/css">
	/* Font */
	@import url('https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap');

	/* style */
	.page-sidenav.sticky {
		/* height: 100vh; */
		border-right: 2px #E4E7EC solid;
	}

	#sidenav-ngi {
		font-family: 'Manrope', sans-serif;
		font-style: normal;
		font-weight: 400;
		font-size: 12px;
		line-height: 16px;
	}

	a.menu1:hover,
	a.menu1:focus,
	a.menu1:active,
	a.menu1:visited {
		background: #F5F7FF;
		border-radius: 4px;
	}

	a.non-submenu1:hover,
	a.non-submenu1:focus,
	a.non-submenu1:active,
	a.non-submenu1:visited {
		background: #F5F7FF;
		border-radius: 4px;
	}

	.italicthis{
		font-style: oblique;
	}

	.largerfont{
		font-size: 16px;
	}
</style>
<!--############ Aside START-->
<div id="aside" class="page-sidenav no-shrink bg-light nav-dropdown fade" aria-hidden="true">
	<div class="sidenav h-100 modal-dialog bg-white">
		<!-- sidenav top -->
		<div class="navbar">
			<!-- brand -->
			<a href="<?= base_url() ?>/main" class="navbar-brand ">

				<img src="<?= base_url(); ?>/assets/img/logo.svg" alt="...">
				<!-- <span class="hidden-folded d-inline l-s-n-1x ">Mitra Darat</span> -->
			</a>
			<!-- / brand -->
		</div>
		<!-- Flex nav content -->
		<div class="flex scrollable hover" id="sidenav-ngi">
			<?php
			if($module_active!='main'){
			?>
			<div class="pt-2" id="mobile-profile">
				<div class="nav-fold px-2">
					<a class="d-flex p-2" data-toggle="dropdown">
						<img src="<?= base_url() ?>/assets/img/avatar-pri.svg" alt="..." class="w-40 r">
					</a>
					<div class="flex p-2">
						<div class="">
								<div class="largerfont"><?= $user ?></div>
								<div class="boldthis"><?= $session->get('username') ?></div>
								<div class="italicthis"><?= $session->get('role_name')?></div>
						</div>
					</div>
				</div>
			</div>
			<?php
			}
			?>
			<div class="nav-active-text-primary" data-nav>
				<ul class="nav bg">
					<li class="nav-header hidden-folded">
						<span class="text-muted">MAIN</span>
					</li>
					<?php $module_active = uri_segment(0);
					$menu_active = uri_segment(1); ?>
					<li class="<?= (($module_active == 'main') ? 'active' : '') ?>">
						<a href="<?= base_url() ?>/main" style="margin:8px 12px 8px 13px; border-radius: 12px; padding: 0px !important;">
							<span class="nav-icon "><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M19.77 13.75H15.73C13.72 13.75 12.75 12.82 12.75 10.9V4.1C12.75 2.18 13.73 1.25 15.73 1.25H19.77C21.78 1.25 22.75 2.18 22.75 4.1V10.9C22.75 12.82 21.77 13.75 19.77 13.75ZM15.73 2.75C14.46 2.75 14.25 3.09 14.25 4.1V10.9C14.25 11.91 14.46 12.25 15.73 12.25H19.77C21.04 12.25 21.25 11.91 21.25 10.9V4.1C21.25 3.09 21.04 2.75 19.77 2.75H15.73Z" fill="#224DDD" />
									<path d="M19.77 22.75H15.73C13.72 22.75 12.75 21.82 12.75 19.9V18.1C12.75 16.18 13.73 15.25 15.73 15.25H19.77C21.78 15.25 22.75 16.18 22.75 18.1V19.9C22.75 21.82 21.77 22.75 19.77 22.75ZM15.73 16.75C14.46 16.75 14.25 17.09 14.25 18.1V19.9C14.25 20.91 14.46 21.25 15.73 21.25H19.77C21.04 21.25 21.25 20.91 21.25 19.9V18.1C21.25 17.09 21.04 16.75 19.77 16.75H15.73Z" fill="#224DDD" />
									<path d="M8.27 22.75H4.23C2.22 22.75 1.25 21.82 1.25 19.9V13.1C1.25 11.18 2.23 10.25 4.23 10.25H8.27C10.28 10.25 11.25 11.18 11.25 13.1V19.9C11.25 21.82 10.27 22.75 8.27 22.75ZM4.23 11.75C2.96 11.75 2.75 12.09 2.75 13.1V19.9C2.75 20.91 2.96 21.25 4.23 21.25H8.27C9.54 21.25 9.75 20.91 9.75 19.9V13.1C9.75 12.09 9.54 11.75 8.27 11.75H4.23Z" fill="#224DDD" />
									<path d="M8.27 8.75H4.23C2.22 8.75 1.25 7.82 1.25 5.9V4.1C1.25 2.18 2.23 1.25 4.23 1.25H8.27C10.28 1.25 11.25 2.18 11.25 4.1V5.9C11.25 7.82 10.27 8.75 8.27 8.75ZM4.23 2.75C2.96 2.75 2.75 3.09 2.75 4.1V5.9C2.75 6.91 2.96 7.25 4.23 7.25H8.27C9.54 7.25 9.75 6.91 9.75 5.9V4.1C9.75 3.09 9.54 2.75 8.27 2.75H4.23Z" fill="#224DDD" />
								</svg>
							</span>
							<span class="nav-text" style="font-size: 16px;color: #1D2939;">Main Dashboard </span>
						</a>
					</li>

					<?php
					$session = \Config\Services::session();

					function group_by($array, $by)
					{
						$groups = array();

						foreach ($array as $key => $value) {
							$groups[$value->$by][] = $value;
						}

						return $groups;
					}

					$module = group_by($session->get('menu'), 'module_name');

					foreach ($module as $key => $_module) {

						echo '<li class="nav-header hidden-folded">
							<span class="text-muted" style="color: #98A2B3 !important; font-size: 12px !important;">' . strtoupper($key) . '</span>
							</li>';

						$grouped = group_by($_module, 'menu_parent');

						foreach ($grouped as $_key => $_grouped) {
							if ($_key == "") {
								foreach ($_grouped as $__key => $menu) {
									$checkStatus = $menu->menu_status;
										if($checkStatus == 'new'){
											$isNew = '<span class="badge badge-pill badge-danger" style="margin-left: 10px;">New</span>';
										} else {
											$isNew = '';
										}
									
									echo '<li class="' . (($menu_active == $menu->menu_url) ? 'active' : '') . '">
											<a href="' . base_url() . '/' . $menu->module_url . '/' . $menu->menu_url . '" class="menu1" style="margin:4px 8px 4px 8px; border-radius: 12px; padding: 0px !important;">
											<span class="nav-icon"><i data-feather="chevrons-right"></i>
											</span>
											<span class="nav-text" style="color: #1D2939; font-size: 16px !important;">' . $menu->menu_name . $isNew . '</span>
											</a>
											</li>';
								}
							} else {
								echo '<li class="' . ((count(array_filter($_grouped, function ($arr) use ($menu_active) {
									return strtolower($arr->menu_url) == strtolower($menu_active);
								})) > 0) ? 'active' : '') . '">
										<a href="#" class="menu1" style="margin:4px 8px 4px 8px; border-radius: 12px; padding: 0px !important;">
										<span class="nav-icon"><i data-feather="chevrons-right"></i></span>
										<span class="nav-text" style="color: #1D2939; font-size: 16px !important;">' . $_key . '</span>
										<span style="padding-right: 10px;"><svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" clip-rule="evenodd" d="M0.351472 0.751496C0.820101 0.282867 1.5799 0.282867 2.04853 0.751496L6 4.70297L9.95147 0.751496C10.4201 0.282867 11.1799 0.282867 11.6485 0.751496C12.1172 1.22013 12.1172 1.97992 11.6485 2.44855L6.84853 7.24855C6.3799 7.71718 5.6201 7.71718 5.15147 7.24855L0.351472 2.44855C-0.117157 1.97992 -0.117157 1.22013 0.351472 0.751496Z" fill="#98A2B3"/>
										</svg>
										</span>
										</a>
										<ul class="nav-sub nav-mega">';

								foreach ($_grouped as $__key => $menu) {
									$checkStatus = $menu->menu_status;
										if($checkStatus == 'new'){
											$isNew = '<span class="badge badge-pill badge-danger" style="margin-left: 10px;">New</span>';
										} else {
											$isNew = '';
										}

									echo '<li class="' . (($menu_active == $menu->menu_url) ? 'active' : '') . '">
											<a href="' . base_url() . '/' . $menu->module_url . '/' . $menu->menu_url . '" class="non-submenu1" style="padding-left: 3.3rem !important;">
											<span class="nav-text" style="color: #1D2939; font-size: 16px !important;">' . $menu->menu_name . $isNew . '</span>
											</a>
											</li>';
								}
								echo    '</ul></li>';
							}
						}
					}
					?>
				</ul>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		hideDiv();
		$(window).resize(function() {
			hideDiv();
		});
	});

	function hideDiv() {
		if ($(window).width() < 1024) {
			// $("#mobile-profile").fadeIn("slow");
			// $("#d-profile").fadeOut("slow");
		} else {
			// $("#mobile-profile").fadeOut("slow");
			// $("#d-profile").fadeIn("slow");
		}
	}
</script>
<!-- ############ Aside END -->