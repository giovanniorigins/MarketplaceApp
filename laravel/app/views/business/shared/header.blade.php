<div class="top-main-area text-center">
    <div class="container">
        <a href="/" class="logo mt5">
            <img src="img/agora2_header.png" alt="Image Alternative text" title="Image Title" />
        </a>
    </div>
</div>
<header class="main">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <!-- MAIN NAVIGATION -->
                <div class="flexnav-menu-button" id="flexnav-menu-button">Menu</div>
                <nav>
                    <ul class="nav nav-pills flexnav" id="flexnav" data-breakpoint="800">
                        <li class="{{Active::pattern(["business", "/business"])}}">
                            <a href="{{url('/business')}}">Home</a>
                        </li>
                        <li class="{{Active::pattern("/business/products-and-services")}}"><a href="{{url('/business/products-and-services')}}">Products & Services</a></li>
                        <li class="{{Active::pattern("/about-us")}}"><a href="{{url('/about-us')}}">About Us</a></li>
                        <li class="{{Active::pattern("/contact-us")}}"><a href="{{url('/contact-us')}}">Contact Us</a></li>
                    </ul>
                </nav>
                <!-- END MAIN NAVIGATION -->
            </div>
        </div>
    </div>
</header>

<!-- TOP AREA -->
<div class="top-area {{ $page or 'hidden' }}">

    <div class="bg-holder">
        <div class="bg-mask"></div>
        <div class="bg-blur" style="background-image:url(img/backgrounds/keyboard.jpg)"></div>
        <div class="container bg-holder-content">
            <div class="gap"></div>
            <div class="row row-wrap">
                <div class="col-md-10 col-md-offset-1">
                    <div class="text-center text-white">
                        @if( isset($page) && $page == 'home')
                        <h1>Business Solutions</h1>
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

    {{--<div class="owl-carousel owl-slider" id="owl-carousel-slider" data-inner-pagination="true" data-white-pagination="true" data-nav="false">
        <div>
            <div class="bg-holder">
                <img src="img/1200x480.png" alt="Image Alternative text" title="Bridge" />
                <div class="bg-mask"></div>
                <div class="bg-front vert-center text-white text-center">
                    <h2 class="text-hero">London Weekends</h2>
                    <div class="countdown countdown-big" data-countdown="Jul 16, 2014 5:30:00"></div><a class="btn btn-lg btn-ghost btn-white" href="#">Save 90% Now</a>
                </div>
            </div>
        </div>
        <div>
            <div class="bg-holder">
                <img src="img/1200x480.png" alt="Image Alternative text" title="4 Strokes of Fun" />
                <div class="bg-mask"></div>
                <div class="bg-front vert-center text-white text-center">
                    <h2 class="text-hero">Adrenaline Madness</h2>
                    <div class="countdown countdown-big" data-countdown="Jul 12, 2014 5:30:00"></div><a class="btn btn-lg btn-ghost btn-white" href="#">Save 80% Now</a>
                </div>
            </div>
        </div>
        <div>
            <div class="bg-holder">
                <img src="img/1200x480.png" alt="Image Alternative text" title="LHOTEL PORTO BAY SAO PAULO luxury suite" />
                <div class="bg-mask"></div>
                <div class="bg-front vert-center text-white text-center">
                    <h2 class="text-hero">Premium Apartments</h2>
                    <div class="countdown countdown-big" data-countdown="Jul 8, 2014 5:30:00"></div><a class="btn btn-lg btn-ghost btn-white" href="#">Save 50% Now</a>
                </div>
            </div>
        </div>
    </div>--}}
</div>
<!-- END TOP AREA -->

<!-- SEARCH AREA -->
{{--<form class="search-area form-group search-area-dark">
    <div class="container">
        <div class="row">
            <div class="col-md-11 clearfix">
                <label><i class="fa fa-search"></i><span>I am searching for</span>
                </label>
                <div class="search-area-division search-area-division-input">
                    <input class="form-control" type="text" placeholder="Gatorade" />
                </div>
            </div>
            --}}{{--<div class="col-md-3 clearfix">
                <label><i class="fa fa-map-marker"></i><span>In</span>
                </label>
                <div class="search-area-division search-area-division-location">
                    <input class="form-control" type="text" placeholder="Boston" />
                </div>
            </div>--}}{{--
            <div class="col-md-1">
                <button class="btn btn-block btn-white search-btn" type="submit">Search</button>
            </div>
        </div>
    </div>
</form>--}}
        <!-- END SEARCH AREA -->

        {{--<div class="gap"></div>--}}

