<!DOCTYPE html>
<html lang="en" class="h-100">

<!-- Mirrored from www.gambolthemes.net/html-items/barren-html/disable-demo-link/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 23 Oct 2025 08:30:36 GMT -->
<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, shrink-to-fit=9">
		<meta name="description" content="Gambolthemes">
		<meta name="author" content="Gambolthemes">
          <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<title>@yield('title','Event Booker - Simple Online Event<!-- Favicon Icon -->') </title>

		<link rel="icon" type="image/png" href="images/fav.png">

		<!-- Stylesheets -->
		<link rel="preconnect" href="https://fonts.googleapis.com/">
		<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
		<link href="{{asset('vendor/unicons-2.0.1/css/unicons.css')}}" rel='stylesheet'>
		<link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
		<link href="{{asset('assets/css/responsive.css')}}" rel="stylesheet">
		<link href="{{asset('assets/css/night-mode.css')}}" rel="stylesheet">

		<!-- Vendor Stylesheets -->
		<link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
		<link href="{{asset('vendor/OwlCarousel/assets/owl.carousel.css')}}" rel="stylesheet">
		<link href="{{asset('vendor/OwlCarousel/assets/owl.theme.default.min.css')}}" rel="stylesheet">
		<link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
		<link href="{{asset('vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">

	</head>

<body class="d-flex flex-column h-100 has-fixed-navbar @stack('body-class')">
    @if(session('error'))
    <div id="toast-error"
         style="position: fixed; top: 20px; right: 20px; background: #f44336; color: white; padding: 15px 25px; border-radius: 8px; z-index: 9999; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
        {{ session('error') }}
    </div>

    <script>
        setTimeout(function() {
            const toast = document.getElementById('toast-error');
            if(toast) {
                toast.style.transition = "opacity 0.5s";
                toast.style.opacity = 0;
                setTimeout(() => toast.remove(), 500);
            }
        }, 4000);
    </script>
@endif

@if(session('success'))
    <div id="toast-success"
         style="position: fixed; top: 20px; right: 20px; background: #4CAF50; color: white; padding: 15px 25px; border-radius: 8px; z-index: 9999; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
        {{ session('success') }}
    </div>

    <script>
        setTimeout(function() {
            const toast = document.getElementById('toast-success');
            if(toast) {
                toast.style.transition = "opacity 0.5s";
                toast.style.opacity = 0;
                setTimeout(() => toast.remove(), 500);
            }
        }, 4000);
    </script>
@endif

    @if(!isset($hideHeader) || $hideHeader !== true)
    @include('frontend.layouts.header')
@endif

 <main class="flex-shrink-0 "style="padding-top: 80px;">
	@yield('content')
 </main>
	<!-- Footer End-->
      @if(!isset($hideFooter) || $hideFooter !== true)
    @include('frontend.layouts.footer')
@endif


	<!-- jQuery first (only once, correct path)
<script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>

<!-- Bootstrap 4 JS (keep this, remove the BS5 CDN if possible) 
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Other vendor scripts
<script src="{{ asset('vendor/OwlCarousel/owl.carousel.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('vendor/mixitup/dist/mixitup.min.js') }}"></script>

<!-- Your custom scripts
<script src="{{ asset('public/assets/js/custom.js') }}"></script>
<script src="{{ asset('public/assets/js/night-mode.js') }}"></script> -->

<!-- Remove these if not needed on this page (they can conflict) -->
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}
{{-- <script src="https://cdn.tailwindcss.com"></script> --}}
{{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
<script src="public/assets/js/jquery.min.js"></script>
<script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/OwlCarousel/owl.carousel.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('vendor/mixitup/dist/mixitup.min.js') }}"></script>
	<script src="public/assets/js/custom.js"></script>
	<script src="public/assets/js/night-mode.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

	<script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // MixItUp
    var containerEl = document.querySelector('[data-ref~="event-filter-content"]');
    if (containerEl) {
        mixitup(containerEl, {
            selectors: {
                target: '[data-ref~="mixitup-target"]'
            }
        });
    }

    // Initialize Bootstrap Select
    if (typeof $.fn.selectpicker !== 'undefined') {
        $('.selectpicker').selectpicker({
            liveSearch: true,      // for the category one
            width: '100%'
        });
    } else {
        console.warn('Bootstrap Select not loaded');
    }
});
</script>

@stack('scripts')
</body>

<!-- Mirrored from www.gambolthemes.net/html-items/barren-html/disable-demo-link/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 23 Oct 2025 08:31:48 GMT -->
</html>


