<!DOCTYPE HTML>

<html class="">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Agora Admin</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<base href="http://marketplace.gorigins.com/" />
	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    {{ HTML::style('//fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic') }}
	<!-- needs images, font... therefore can not be part of ui.css -->
	{{ HTML::style('/admin_assets/bower_components/font-awesome/css/font-awesome.min.css') }}
	{{ HTML::style('/admin_assets/bower_components/weather-icons/css/weather-icons.min.css') }}
	<!-- end needs images -->

	<!-- StrapSlide -->
	{{ HTML::style('/admin_assets/strapslide/css/strapslide.css') }}
	{{ HTML::style('/admin_assets/strapslide/css/strapslide-default-v3.css') }}
	<!-- //StrapSlide-->

	{{ HTML::style('/admin_assets/styles/main.css') }}

</head>
<body data-ng-app="app" id="app" data-custom-background="" data-off-canvas-nav="">
<!--[if lt IE 9]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
	your browser</a> to improve your experience.</p>
<![endif]-->

<div data-ng-controller="AppCtrl">
	<div data-ng-hide="isSpecificPage()" data-ng-cloak="" class="no-print">
		<section data-ng-include=" '/admin_assets/views/header.html' " id="header" class="top-header"></section>

		<aside data-ng-include=" '/admin_assets/views/nav.html' " id="nav-container"></aside>
	</div>
	<div class="no-print navbar-wrapper"  data-ng-hide="!isSpecificPage()" data-ng-cloak="">
		<div class="container">
			<nav class="navbar navbar-inverse" ng-class="{true:'navbar-static-top', false:'navbar-fixed-top'}[isHome()]" role="navigation" data-ng-show="!isLockScreen()">
				<div class="" ng-class="{true:'container', false:'container-fluid'}[isHome()]">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse"
						        data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="/admin">Marketplace</a>
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" front-nav>
						<ul class="nav navbar-nav">
							<li><a href="/admin/home">Home</a></li>
							<li><a href="/admin/about">About</a></li>
							<li><a href="/admin/pricing">Pricing</a></li>
							<li><a href="/admin/services">Services</a></li>
							<li><a href="/admin/contact">Contact</a></li>
							<li><a href="/admin/login">Login</a></li>
							<!--<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="#">Action</a></li>
									<li><a href="#">Another action</a></li>
									<li><a href="#">Something else here</a></li>
									<li class="divider"></li>
									<li><a href="#">Separated link</a></li>
									<li class="divider"></li>
									<li><a href="#">One more separated link</a></li>
								</ul>
							</li>-->
						</ul>
					</div>
					<!-- /.navbar-collapse -->
				</div>
				<!-- /.container-fluid -->
			</nav>
		</div>
	</div>
	<div class="view-container">
		<section data-ng-view="" id="content" class="animate-fade-up"></section>
	</div>
</div>


{{ HTML::script('http://maps.google.com/maps/api/js?sensor=false') }}
{{ HTML::script('/admin_assets/scripts/vendor.js') }}
{{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/json3/3.3.1/json3.min.js') }}

{{ HTML::script('/admin_assets/strapslide/js/jquery.touchSwipe.min.js') }}
{{ HTML::script('/admin_assets/strapslide/js/jquery.transit.min.js') }}
{{ HTML::script('/admin_assets/strapslide/js/jquery.mousewheel.js') }}
{{ HTML::script('/admin_assets/strapslide/js/jquery.fitVids.js') }}
<!-- Slider plugin -->
{{ HTML::script('/admin_assets/strapslide/js/strapslide.js') }}

<!-- AngularJS -->
{{ HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.2.25/angular.min.js') }}
{{ HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.2.25/angular-animate.min.js') }}
{{ HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.2.25/angular-resource.min.js') }}
{{ HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.2.25/angular-cookies.min.js') }}
{{ HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.2.25/angular-route.min.js') }}

{{ HTML::script('/admin_assets/scripts/image_crop/crop.js') }}
{{ HTML::script('/admin_assets/scripts/angular-dreamfactory.js') }}
{{ HTML::script('/admin_assets/scripts/dreamfactory-user-management.js') }}
{{ HTML::script('/admin_assets/scripts/modules.js') }}

{{ HTML::script('/admin_assets/scripts/ui.js') }}

{{ HTML::script('/admin_assets/scripts/app.js') }}
{{ HTML::script('/admin_assets/scripts/services.js') }}
{{ HTML::script('/admin_assets/scripts/directives.js') }}
{{ HTML::script('/admin_assets/scripts/controllers.js') }}
</body>
</html>