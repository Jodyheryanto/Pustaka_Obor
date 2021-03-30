<!DOCTYPE html>
<html lang="id">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<title>Forbidden Page</title>

	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

	<!-- BEGIN: Vendor CSS-->
	<link rel="stylesheet" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}">

	<!-- BEGIN: Theme CSS-->
	<link rel="stylesheet" href="{{ asset('app-assets/css/bootstrap.css') }}">
	<link rel="stylesheet" href="{{ asset('app-assets/css/bootstrap-extended.css') }}">
	<link rel="stylesheet" href="{{ asset('app-assets/css/colors.css') }}">
	<link rel="stylesheet" href="{{ asset('app-assets/css/components.css') }}">
	<link rel="stylesheet" href="{{ asset('app-assets/css/themes/dark-layout.css') }}">
	<link rel="stylesheet" href="{{ asset('app-assets/css/themes/semi-dark-layout.css') }}">

	<!-- BEGIN: Page CSS-->
	<link rel="stylesheet" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
	<link rel="stylesheet" href="{{ asset('app-assets/css/core/colors/palette-gradient.css') }}">
	<link rel="stylesheet" href="{{ asset('app-assets/css/pages/error.css') }}">

	<!-- BEGIN: Custom CSS-->
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

</head>

<body class="vertical-layout vertical-menu-modern semi-dark-layout 1-column  navbar-floating footer-static bg-full-screen-image  blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column" data-layout="semi-dark-layout">

	<div class="app-content content">
		<div class="content-overlay"></div>
		<div class="header-navbar-shadow"></div>
		<div class="content-wrapper">
			<div class="content-header row">
			</div>
			<div class="content-body">
				<section class="row flexbox-container">
					<div class="col-xl-7 col-md-8 col-12 d-flex justify-content-center">
						<div class="card auth-card bg-transparent shadow-none rounded-0 mb-0 w-100">
							<div class="card-content">
								<div class="card-body text-center">
									<img src="{{ asset('app-assets/images/pages/404.png') }}" class="img-fluid align-self-center" alt="branding logo">
									<h1 class="font-large-2 my-1">Forbidden! Access Denied.</h1>
									<p class="p-2">
										Sorry but you don't have permission to access this page.
									</p>
									<button class="btn btn-primary btn-lg mt-2" onclick="goBack()">Back to Previous Page</button>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>

	<!-- BEGIN: Vendor JS-->
	<script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>

	<!-- BEGIN: Theme JS-->
	<script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
	<script src="{{ asset('app-assets/js/core/app.js') }}"></script>
	<script src="{{ asset('app-assets/js/scripts/components.js') }}"></script>

	<!-- BEGIN: Page JS-->
	<script>
		function goBack() {
			window.history.back();
		}
	</script>

</body>

</html>
