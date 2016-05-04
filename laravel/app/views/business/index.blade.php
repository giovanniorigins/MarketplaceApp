<!DOCTYPE HTML>
<html>

<head>
    <title>Home | Marketplace</title>
    @include('business.shared.head')
</head>

<body ng-app="app" class="">


    <div class="global-wrap" ng-controller="AppCtrl">


        <!-- //////////////////////////////////
	//////////////MAIN HEADER/////////////
	////////////////////////////////////-->
	@include('business.shared.header')
        <!-- //////////////////////////////////
	//////////////END MAIN HEADER//////////
	////////////////////////////////////-->


        <!-- //////////////////////////////////
	//////////////PAGE CONTENT/////////////
	////////////////////////////////////-->
    @include('section.featured')

        <div class="container">
            <div class="row text-center">
                <div class="col-md-4">
                    <div><a href="#" class="fa-stack fa-5x">
                      <i class="fa fa-circle fa-stack-2x color-info-alt"></i>
                      <i class="fa fa-users fa-stack-1x fa-inverse"></i>
                    </a></div>
                    <a href="#">Consumers</a>
                </div>
                <div class="col-md-4">
                    <div><a href="#" class="fa-stack fa-5x">
                      <i class="fa fa-circle fa-stack-2x"></i>
                      <i class="fa fa-star fa-stack-1x fa-inverse"></i>
                    </a></div>
                    <a href="#">Brands</a>
                </div>
                <div class="col-md-4">
                    <div><a href="#" class="fa-stack fa-5x">
                      <i class="fa fa-circle fa-stack-2x"></i>
                      <i class="fa fa-tags fa-stack-1x fa-inverse"></i>
                    </a></div>
                    <a href="#">Retailers</a>
                </div>
                {{--<div class="col-md-3">
                    <div><span class="fa-stack fa-5x">
                      <i class="fa fa-circle fa-stack-2x"></i>
                      <i class="fa fa-flag fa-stack-1x fa-inverse"></i>
                    </span></div>
                    <a href="#">Consumers</a>
                </div>--}}
            </div>
            <div class="gap"></div>
        </div>

        <div class="bg-holder">
            <div class="bg-mask"></div>
            <div class="bg-blur" style="background-image:url(img/backgrounds/beach.jpg)"></div>
            <div class="container bg-holder-content">
                <div class="gap"></div>
                <div class="row row-wrap">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="text-center text-white">
                            @if( isset($page) && $page == 'home')
                            <h1>Business Solution</h1>
                            @elseif( isset($page) && $page == 'services')
                            <h1>Products & Services</h1>
                            <p class="text-bigger">Find out what your favorite shops are up to!</p>
                            @elseif( isset($page) && $page == 'categories')
                            <h1>Shops</h1>
                            <p class="text-bigger">Find out what your favorite shops are up to!</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="gap"></div>
            </div>
        </div>


        <!-- //////////////////////////////////
	//////////////END PAGE CONTENT/////////
	////////////////////////////////////-->



        <!-- //////////////////////////////////
	//////////////MAIN FOOTER//////////////
	////////////////////////////////////-->
    @include('business.shared.footer')
        <!-- //////////////////////////////////
	//////////////END MAIN  FOOTER/////////
	////////////////////////////////////-->


    @include('business.shared.foot')
    </div>
</body>

</html>
