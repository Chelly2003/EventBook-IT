@extends('frontend.dashboard.master')

@section('title', 'Reports')

@section('content')

<!-- Body Start -->
	<div class="wrapper wrapper-body">
		<div class="dashboard-body">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="d-main-title">
							<h3><i class="fa-solid fa-chart-pie me-3"></i>Reports</h3>
						</div>
					</div>
					<div class="col-md-12">
						<div class="main-card mt-5">
							<div class="dashboard-wrap-content p-4">
								<div class="nav custom2-tabs btn-group" role="tablist">
									<button class="tab-link ms-0 active" data-bs-toggle="tab" data-bs-target="#orders-tab" type="button" role="tab" aria-controls="orders-tab" aria-selected="true">Orders (<span class="total_event_counter">1</span>)</button>
									<button class="tab-link" data-bs-toggle="tab" data-bs-target="#customers-tab" type="button" role="tab" aria-controls="customers-tab" aria-selected="false">Customers (<span class="total_event_counter">0</span>)</button>
									<button class="tab-link" data-bs-toggle="tab" data-bs-target="#tickets-tab" type="button" role="tab" aria-controls="tickets-tab" aria-selected="false">Tickets (<span class="total_event_counter">1</span>)</button>
									<button class="tab-link" data-bs-toggle="tab" data-bs-target="#payouts-tab" type="button" role="tab" aria-controls="payouts-tab" aria-selected="false">Payouts (<span class="total_event_counter">1</span>)</button>
								</div>
								<div class="d-md-flex flex-wrap align-items-center">
									<div class="dashboard-date-wrap mt-4">
										<div class="form-group">
											<div class="relative-input position-relative">
												<input class="form-control h_40" type="text" placeholder="Search by name" value="">
												<i class="uil uil-search"></i>
											</div>
										</div>
									</div>
									<div class="rs ms-auto mt-4 mt_r4">
										<a href="#" class="pe-4 w-100 ps-4 text-center co-main-btn h_40 d-inline-block"><i class="fa-solid fa-arrow-rotate-right me-3"></i>Refresh</a>
									</div>
								</div>
								<div class="main-form mt-4">
									<div class="row g-3">
										<div class="col-lg-3 col-md-6">
											<div class="form-group">
												<select class="selectpicker" data-size="5" data-live-search="true">
													<option value="all events" selected>All Events</option>
												</select>
											</div>
										</div>
										<div class="col-lg-3 col-md-6">
											<div class="form-group">
												<select class="selectpicker">
													<option value="Today">Today</option>
													<option value="Yesterday">Yesterday</option>
													<option value="Last 7 Days">Last 7 Days</option>
													<option value="Last 30 Days" selected>Last 30 Days</option>
													<option value="This Month">This Month</option>
													<option value="Last Month">Last Month</option>
													<option value="Custom Range">Custom Range</option>
												</select>
											</div>
										</div>
										<div class="col-lg-3 col-md-6">
											<div class="form-group">
												<select class="selectpicker">
													<option value="All Orders" selected>All Orders</option>
													<option value="Refunded">Refunded</option>
													<option value="Refund Rejected">Refund Rejected</option>
													<option value="Refund Requested">Refund Requested</option>
													<option value="Partially Refunded">Partially Refunded</option>
												</select>
											</div>
										</div>
										<div class="col-lg-3 col-md-6">
											<div class="form-group">
												<select class="selectpicker">
													<option value="all">All Orders</option>
													<option value="1">Active</option>
													<option value="0">Canceled</option>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="event-list">
							<div class="tab-content">
								<div class="tab-pane fade show active" id="orders-tab" role="tabpanel">
									<div class="table-card mt-4">
										<div class="main-table">
											<div class="table-responsive">
												<table class="table">
													<thead class="thead-dark">
														<tr>
															<th scope="col">ID</th>
															<th scope="col">Name</th>
															<th scope="col">Event Name</th>
															<th scope="col">Date</th>
															<th scope="col">Reference</th>
															<th scope="col">Status</th>
															<th scope="col">Total</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>5291</td>
															<td>Larry Paige</td>
															<td><a href="#" target="_blank">Astrology on sunday event</a></td>
															<td>04/22/2022</td>
															<td>E1021100NA8711001</td>
															<td><span class="status-circle red-circle"></span>Canceled</td>
															<td>AUD $0.00</td>
														</tr>
														<tr>
															<td>5290</td>
															<td>John Cena</td>
															<td><a href="#" target="_blank">Melbourne plant sale</a></td>
															<td>04/22/2022</td>
															<td>E1021100NA8711002</td>
															<td><span class="status-circle green-circle"></span>Paid</td>
															<td>AUD $0.00</td>
														</tr>
														<tr>
															<td>5289</td>
															<td>Gleen Smith</td>
															<td><a href="#" target="_blank">Testing Events</a></td>
															<td>04/21/2022</td>
															<td>E1021100NA8711003</td>
															<td><span class="status-circle blue-circle"></span>Refunded</td>
															<td>AUD $0.00</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="customers-tab" role="tabpanel">
									<div class="table-card mt-4">
										<div class="main-table">
											<div class="table-responsive">
												<table class="table">
													<thead class="thead-dark">
														<tr>
															<th scope="col">ID</th>
															<th scope="col">Name</th>
															<th scope="col">Email address</th>
															<th scope="col">Address</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>2356</td>
															<td>Larry Paige</td>
															<td>larry@example.com</td>
															<td>140 St Kilda Rd, St Kilda, Victoria, Melbourne, Victoria, 3000, Australia</td>
														</tr>
														<tr>
															<td>2355</td>
															<td>John Cena</td>
															<td>johncena@example.com</td>
															<td>140 St Kilda Rd, St Kilda, Victoria, Melbourne, Victoria, 3000, Australia</td>
														</tr>
														<tr>
															<td>2354</td>
															<td>Jassica William</td>
															<td>jassica@example.com</td>
															<td>140 St Kilda Rd, St Kilda, Victoria, Melbourne, Victoria, 3000, Australia</td>
														</tr>
														<tr>
															<td>2353</td>
															<td>Rock William</td>
															<td>rockwilliam@example.com</td>
															<td>140 St Kilda Rd, St Kilda, Victoria, Melbourne, Victoria, 3000, Australia</td>
														</tr>
														<tr>
															<td>2352</td>
															<td>Gleen Smith</td>
															<td>gleensmith@example.com</td>
															<td>140 St Kilda Rd, St Kilda, Victoria, Melbourne, Victoria, 3000, Australia</td>
														</tr>
														<tr>
															<td>2351</td>
															<td>John Doe</td>
															<td>johndoe@example.com</td>
															<td>140 St Kilda Rd, St Kilda, Victoria, Melbourne, Victoria, 3000, Australia</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tickets-tab" role="tabpanel">
									<div class="table-card mt-4">
										<div class="main-table">
											<div class="table-responsive">
												<table class="table">
													<thead class="thead-dark">
														<tr>
															<th scope="col">Order ID</th>
															<th scope="col">Reference ID</th>
															<th scope="col">Customer Name</th>
															<th scope="col">Email Address</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>2356</td>
															<td>F6ACCM-R76MTK-1434658508</td>
															<td>Larry Paige</td>
															<td>larry@example.com</td>
														</tr>
														<tr>
															<td>2355</td>
															<td>F6ACCM-R76MTK-1434658508</td>
															<td>Gleen William</td>
															<td>gleenwilliam@example.com</td>
														</tr>
														<tr>
															<td>2354</td>
															<td>F6ACCM-R76MTK-1434658508</td>
															<td>Rock Smith</td>
															<td>rocksmith@example.com</td>
														</tr>
														<tr>
															<td>2353</td>
															<td>F6ACCM-R76MTK-1434658508</td>
															<td>John Cena</td>
															<td>johncena@example.com</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="payouts-tab" role="tabpanel">
									<div class="table-card mt-4">
										<div class="main-table">
											<div class="table-responsive">
												<table class="table">
													<thead class="thead-dark">
														<tr>
															<th scope="col">Remittance ID</th>
															<th scope="col">Remittance Date</th>
															<th scope="col">Date Paid</th>
															<th scope="col">Date</th>
															<th scope="col">Transaction ID</th>
															<th scope="col">Actions</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>12475</td>
															<td>28/1.04/2022</td>
															<td>26/04/2022</td>
															<td>22/04/2022</td>
															<td>TXR21234123UX</td>
															<td><a href="#" class="a-link">Download</a></td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Body End -->


	<script src="js/vertical-responsive-menu.min.js"></script>
	<script src="js/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="vendor/OwlCarousel/owl.carousel.js"></script>
	<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	<script src="js/custom.js"></script>
	<script src="js/night-mode.js"></script>

</body>

@endsection
