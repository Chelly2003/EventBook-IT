

@extends('frontend.master')

@section('title', 'Create Event')

@section('content')


	<!-- Body Start-->

<div class="event-dt-block p-80">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-12 col-md-12">
						<div class="main-title text-center checkout-title">
							<h3>Create New Event</h3>
						</div>
					</div>
					<div class="col-xl-6 col-lg-8 col-md-12">
						<div class="create-block">
							<div class="row">
								<div class="col-md-6">
									<div class="main-card create-card mt-4">
										<div class="create-icon">
											<i class="fa-solid fa-video"></i>
										</div>
										<h4>Create an Online Event</h4>
										<a href="{{route('online_event')}}" class="main-btn btn-hover h_40 w-100">Create<i class="fa-solid fa-arrow-right ms-2"></i></a>
									</div>
								</div>
								<div class="col-md-6">
									<div class="main-card create-card mt-4">
										<div class="create-icon">
											<i class="fa-solid fa-location-dot"></i>
										</div>
										<h4>Create an Venue Event</h4>
										<a href="{{route('venue_event')}}" class="main-btn btn-hover h_40 w-100">Create<i class="fa-solid fa-arrow-right ms-2"></i></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
