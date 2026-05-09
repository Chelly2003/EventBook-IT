<!DOCTYPE html>
<html lang="en" class="h-100">

<!-- Mirrored from www.gambolthemes.net/html-items/barren-html/disable-demo-link/my_organisation_dashboard.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 23 Oct 2025 08:26:29 GMT -->
<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, shrink-to-fit=9">
		<meta name="description" content="Gambolthemes">
		<meta name="author" content="Gambolthemes">
	   <title>@yield('title','Event Booker - Simple Online Event Ticketing System')</title>

		<!-- Favicon Icon -->
		<link rel="icon" type="image/png" href="images/eventlogo.png">

		<!-- Stylesheets -->
		<link rel="preconnect" href="https://fonts.googleapis.com/">
		<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
		<link href="{{asset('vendor/unicons-2.0.1/css/unicons.css')}}" rel='stylesheet'>
		<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

		<link href="{{asset('assets/css/vertical-responsive-menu.min.css')}}"rel="stylesheet">
		<link href="{{asset('assets/css/analytics.css')}} " rel=stylesheet">
		<link href="{{asset('assets/css/responsive.css')}}" rel="stylesheet">
		<link href="{{asset('assets/css/night-mode.css')}}" rel="stylesheet">

		<!-- Vendor Stylesheets -->
		<link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
		<link href="{{asset('vendor/OwlCarousel/assets/owl.carousel.css')}}" rel="stylesheet">
		<link href="{{asset('vendor/OwlCarousel/assets/owl.theme.default.min.css')}}" rel="stylesheet">
		<link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
		<link href="{{asset('vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
		<link href="{{asset('vendor/chartist/dist/chartist.min.css')}}" rel="stylesheet">
		<link href="{{asset('vendor/chartist-plugin-tooltip/dist/chartist-plugin-tooltip.css')}}" rel="stylesheet">

	</head>

<body class="d-flex flex-column h-100">
	<!-- Add Organisation Model Start-->
     <main class="flex-shrink-0">
	@yield('content')
 </main>
	<div class="modal fade" id="addorganisationModal" tabindex="-1" aria-labelledby="addorganisationLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addorganisationLabel">Organisation details</h5>
					<button type="button" class="close-model-btn" data-bs-dismiss="modal" aria-label="Close"><i class="uil uil-multiply"></i></button>
				</div>
				<div class="modal-body">
					<div class="model-content main-form">
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<div class="form-group text-center mt-4">
									<label class="form-label">Avatar*</label>
									<span class="org_design_button btn-file">
										<span><i class="fa-solid fa-camera"></i></span>
										<input type="file" id="org_avatar" accept="image/*" name="Organisation_avatar">
									</span>
								</div>
							</div>
							<div class="col-lg-12 col-md-12">
								<div class="form-group mt-4">
									<label class="form-label">Name*</label>
									<input class="form-control h_40" type="text" placeholder="" value="">
								</div>
							</div>
							<div class="col-lg-12 col-md-12">
								<div class="form-group mt-4">
									<label class="form-label">Profile Link*</label>
									<input class="form-control h_40" type="text" placeholder="" value="https://www.barren.com/b/organiser/" disabled>
								</div>
							</div>
							<div class="col-lg-12 col-md-12">
								<div class="form-group mt-4">
									<label class="form-label">About*</label>
									<textarea class="form-textarea"  placeholder="">About</textarea>
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="form-group mt-4">
									<label class="form-label">Email*</label>
									<input class="form-control h_40" type="text" placeholder="" value="">
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="form-group mt-4">
									<label class="form-label">Phone*</label>
									<input class="form-control h_40" type="text" placeholder="" value="">
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="form-group mt-4">
									<label class="form-label">Website*</label>
									<input class="form-control h_40" type="text" placeholder="" value="">
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="form-group mt-4">
									<label class="form-label">Facebook*</label>
									<input class="form-control h_40" type="text" placeholder="" value="">
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="form-group mt-4">
									<label class="form-label">Instagram*</label>
									<input class="form-control h_40" type="text" placeholder="" value="">
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="form-group mt-4">
									<label class="form-label">Twitter*</label>
									<input class="form-control h_40" type="text" placeholder="" value="">
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="form-group mt-4">
									<label class="form-label">LinkedIn*</label>
									<input class="form-control h_40" type="text" placeholder="" value="">
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="form-group mt-4">
									<label class="form-label">Youtube*</label>
									<input class="form-control h_40" type="text" placeholder="" value="">
								</div>
							</div>
							<div class="col-lg-12 col-md-12">
								<h4 class="address-title">Address</h4>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="form-group mt-4">
									<label class="form-label">Address 1*</label>
									<input class="form-control h_40" type="text" placeholder="" value="">
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="form-group mt-4">
									<label class="form-label">Address 2*</label>
									<input class="form-control h_40" type="text" placeholder="" value="">
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="form-group main-form mt-4">
									<label class="form-label">Country*</label>
									<select class="selectpicker" data-size="5" title="Nothing selected" data-live-search="true">
										<option value="Algeria">Algeria</option>
										<option value="Argentina">Argentina</option>
										<option value="Australia">Australia</option>
										<option value="Austria">Austria (Österreich)</option>
										<option value="Belgium">Belgium (België)</option>
										<option value="Bolivia">Bolivia</option>
										<option value="Brazil">Brazil</option>
										<option value="Canada">Canada</option>
										<option value="Chile">Chile</option>
										<option value="Colombia">Colombia</option>
										<option value="Costa Rica">Costa Rica</option>
										<option value="Cyprus">Cyprus</option>
										<option value="Czech Republic">Czech Republic</option>
										<option value="Denmark">Denmark</option>
										<option value="Dominican Republic">Dominican Republic</option>
										<option value="Estonia">Estonia</option>
										<option value="Finland">Finland</option>
										<option value="France">France</option>
										<option value="Germany">Germany</option>
										<option value="Greece">Greece</option>
										<option value="Hong Kong">Hong Kong</option>
										<option value="Iceland">Iceland</option>
										<option value="India">India</option>
										<option value="Indonesia">Indonesia</option>
										<option value="Ireland">Ireland</option>
										<option value="Israel">Israel</option>
										<option value="Italy">Italy</option>
										<option value="Japan">Japan</option>
										<option value="Latvia">Latvia</option>
										<option value="Lithuania">Lithuania</option>
										<option value="Luxembourg">Luxembourg</option>
										<option value="Malaysia">Malaysia</option>
										<option value="Mexico">Mexico</option>
										<option value="Nepal">Nepal</option>
										<option value="Netherlands">Netherlands</option>
										<option value="New Zealand">New Zealand</option>
										<option value="Norway">Norway</option>
										<option value="Paraguay">Paraguay</option>
										<option value="Peru">Peru</option>
										<option value="Philippines">Philippines</option>
										<option value="Poland">Poland</option>
										<option value="Portugal">Portugal</option>
										<option value="Singapore">Singapore</option>
										<option value="Slovakia">Slovakia</option>
										<option value="Slovenia">Slovenia</option>
										<option value="South Africa">South Africa</option>
										<option value="South Korea">South Korea</option>
										<option value="Spain">Spain</option>
										<option value="Sweden">Sweden</option>
										<option value="Switzerland">Switzerland</option>
										<option value="Tanzania">Tanzania</option>
										<option value="Thailand">Thailand</option>
										<option value="Turkey">Turkey</option>
										<option value="United Kingdom">United Kingdom</option>
										<option value="United States">United States</option>
										<option value="Vietnam">Vietnam</option>
									</select>
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="form-group mt-4">
									<label class="form-label">State*</label>
									<input class="form-control h_40" type="text" placeholder="" value="">
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="form-group mt-4">
									<label class="form-label">City/Suburb*</label>
									<input class="form-control h_40" type="text" placeholder="" value="">
								</div>
							</div>
							<div class="col-lg-6 col-md-12">
								<div class="form-group mt-4">
									<label class="form-label">Zip/Post Code*</label>
									<input class="form-control h_40" type="text" placeholder="" value="">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="co-main-btn min-width btn-hover h_40" data-bs-dismiss="modal">Cancel</button>
					<button type="button" class="main-btn min-width btn-hover h_40">Add</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Add Organisation Model End-->
	<!-- Header Start-->
	<header class="header">
		<div class="header-inner">
			<nav class="navbar navbar-expand-lg bg-barren barren-head navbar fixed-top justify-content-sm-start pt-0 pb-0 ps-lg-0 pe-2">
				<div class="container-fluid ps-0">
					<button type="button" id="toggleMenu" class="toggle_menu">
						<i class="fa-solid fa-bars-staggered"></i>
					</button>
					<button id="collapse_menu" class="collapse_menu me-4">
						<i class="fa-solid fa-bars collapse_menu--icon "></i>
						<span class="collapse_menu--label"></span>
					</button>
					<button class="navbar-toggler order-3 ms-2 pe-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
						<span class="navbar-toggler-icon">
							<i class="fa-solid fa-bars"></i>
						</span>
					</button>
					<a class="navbar-brand order-1 order-lg-0 ml-lg-0 ml-2 me-auto" href="index.html">
						<div class="res-main-logo">
							<img src="images/eventlogo.png" alt="">
						</div>
						<div class="main-logo" id="logo">
							<img src="eventlogo.png" alt="">
							<img class="logo-inverse" src="images/dark-logo.svg" alt="">
						</div>
					</a>
					<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
						<div class="offcanvas-header">
							<div class="offcanvas-logo" id="offcanvasNavbarLabel">
								<img src="images/eventlogo.png" alt="">
							</div>
							<button type="button" class="close-btn" data-bs-dismiss="offcanvas" aria-label="Close">
								<i class="fa-solid fa-xmark"></i>
							</button>
						</div>
						<div class="offcanvas-body">
							<div class="offcanvas-top-area">
								<div class="create-bg">
									<a href="{{route('createevent')}}" class="offcanvas-create-btn">
										<i class="fa-solid fa-calendar-days"></i>
										<span>Create Event</span>
									</a>
								</div>
							</div>
							<ul class="navbar-nav justify-content-end flex-grow-1 pe_5">
								<li class="nav-item">
									<a class="nav-link" href="{{route('organiserprofile')}}">
										<i class="fa-solid fa-right-left me-2"></i>My Home
									</a>
								</li>
								<li class="nav-item">
									<a class="dropdown-item" href="{{ route('exploreevents') }}">
										<i class="fa-solid fa-compass me-2"></i>Explore Events
									</a>
								</li>
							</ul>
						</div>
						<div class="offcanvas-footer">
							<div class="offcanvas-social">
								<h5>Follow Us</h5>
								<ul class="social-links">
									<li><a href="#" class="social-link"><i class="fab fa-facebook-square"></i></a>
									</li><li><a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
									</li><li><a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
									</li><li><a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
									</li><li><a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
								</li></ul>
							</div>
						</div>
					</div>
					<div class="right-header order-2">
						<ul class="align-self-stretch">
							<li>
								<a href="{{route('createevent')}}" class="create-btn btn-hover">
									<i class="fa-solid fa-calendar-days"></i>
									<span>Create Event</span>
								</a>
							</li>

							<li>
								<div class="night_mode_switch__btn">
									<div id="night-mode" class="fas fa-moon fa-sun"></div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</nav>
			<div class="overlay"></div>
		</div>
	</header>
	<!-- Header End-->
	<!-- Left Sidebar Start -->
	<nav class="vertical_nav">
		<div class="left_section menu_left" id="js-menu">
			<div class="left_section">
				<ul>
					<li class="menu--item">
						<a href="{{route('organiserdashboard')}}" class="menu--link active" title="Dashboard" data-bs-toggle="tooltip" data-bs-placement="right">
							<i class="fa-solid fa-gauge menu--icon"></i>
							<span class="menu--label">Dashboard</span>
						</a>
					</li>
					<li class="menu--item">
						<a href="{{route('organisationevents')}}" class="menu--link" title="Events" data-bs-toggle="tooltip" data-bs-placement="right">
							<i class="fa-solid fa-calendar-days menu--icon"></i>
							<span class="menu--label">Events</span>
						</a>
					</li>
                    <!--
					<li class="menu--item">
						<a href="my_organisation_dashboard_promotion.html" class="menu--link" title="Promotion" data-bs-toggle="tooltip" data-bs-placement="right">
							<i class="fa-solid fa-rectangle-ad menu--icon"></i>
							<span class="menu--label">Promotion</span>
						</a>
					</li>
                -->
					<li class="menu--item">
						<a href="{{route('organiser.contact_lists')}}" class="menu--link" title="Contact List" data-bs-toggle="tooltip" data-bs-placement="right">
							<i class="fa-regular fa-address-card menu--icon"></i>
							<span class="menu--label">Contact List</span>
						</a>
					</li>
					<li class="menu--item">
						<a href="{{route('organiser.payout')}}" class="menu--link" title="Payouts" data-bs-toggle="tooltip" data-bs-placement="right">
							<i class="fa-solid fa-credit-card menu--icon"></i>
							<span class="menu--label">Payouts</span>
						</a>
					</li>
				 <!--	<li class="menu--item">
						<a href="{{route('org_reports')}}" class="menu--link" title="Reports" data-bs-toggle="tooltip" data-bs-placement="right">
							<i class="fa-solid fa-chart-pie menu--icon"></i>
							<span class="menu--label">Reports</span>
						</a>
					</li>

					<li class="menu--item">
						<a href="my_organisation_dashboard_subscription.html" class="menu--link" title="Subscription" data-bs-toggle="tooltip" data-bs-placement="right">
							<i class="fa-solid fa-bahai menu--icon"></i>
							<span class="menu--label">Subscription</span>
						</a>
					</li>
                -->
					<li class="menu--item">
						<a href="{{route('conversion_setup')}}" class="menu--link" title="Conversion Setup" data-bs-toggle="tooltip" data-bs-placement="right">
							<i class="fa-solid fa-square-plus menu--icon"></i>
							<span class="menu--label">Conversion Setup</span>
						</a>
					</li>
                    <!--
					<li class="menu--item">
						<a href="my_organisation_dashboard_about.html" class="menu--link" title="About" data-bs-toggle="tooltip" data-bs-placement="right">
							<i class="fa-solid fa-circle-info menu--icon"></i>
							<span class="menu--label">About</span>
						</a>
					</li>
                -->
					<!--<li class="menu--item">
						<a href="{{route('dashboard.team')}}" class="menu--link team-lock" title="My Team" data-bs-toggle="tooltip" data-bs-placement="right">
							<i class="fa-solid fa-user-group menu--icon"></i>
							<span class="menu--label">My Team</span>
						</a>
					</li>-->
				</ul>
			</div>
		</div>
	</nav>
	<!-- Left Sidebar End -->
	<!-- Body Start -->

	<!-- Body End -->




</body>

<!-- Mirrored from www.gambolthemes.net/html-items/barren-html/disable-demo-link/my_organisation_dashboard.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 23 Oct 2025 08:27:11 GMT -->
</html>
