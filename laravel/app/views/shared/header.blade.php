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
                        <li class="{{Active::pattern(["", "/"])}}">
                            <a href="{{url('/')}}">Home</a>
                        </li>
                        <li class="{{Active::pattern(["category", "category/*"])}}">
                            <a href="#">Category</a>
                            <ul>
                                @foreach($categories as $cat)
                                <li class="{{Active::pattern("category/" . $cat->title_alias)}}  {{--{{count($cat->deals) == 0 ? 'hidden' :null;}}--}}">
                                    <a href="{{url('/category/' . $cat->title_alias)}}">{{$cat->title}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="{{Active::pattern(["shops", "shops/*"])}}"><a href="{{url('/shops')}}">Shops</a></li>
                    </ul>
                </nav>
                <!-- END MAIN NAVIGATION -->
            </div>
            {{--<div class="col-md-6">
                <div class="pull-right">
                    <div class="header-search-bar">
                    {{ Form::open(array('url' => 'search')) }}
                        {{Form::label('search', 'Search')}}
                        <input name="search" type="text" placeholder="fruits, Shoes, ect" id="search">
                        <button type="submit" value="search"><i class="fa fa-search"></i></button>
                    {{ Form::close() }}
                    </div>
                </div>
                <div class="pull-right hidden">
                    <div class="header-search-bar">
                        <label for="search">Search</label>
                        <input type="text" placeholder="Glasses, Shoes, ect" />
                        <button><i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>--}}
            <div class="col-md-6">
                <!-- LOGIN REGISTER LINKS -->
                <ul class="login-register">
                    {{--<li class="shopping-cart"><a href="page-cart.html"><i class="fa fa-shopping-cart"></i>My Cart</a>
                        <div class="shopping-cart-box">
                            <ul class="shopping-cart-items">
                                <li>
                                    <a href="product-shop-sidebar.html">
                                        <img src="img/70x70.png" alt="Image Alternative text" title="AMaze" />
                                        <h5>New Glass Collection</h5><span class="shopping-cart-item-price">$150</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="product-shop-sidebar.html">
                                        <img src="img/70x70.png" alt="Image Alternative text" title="Gamer Chick" />
                                        <h5>Playstation Accessories</h5><span class="shopping-cart-item-price">$170</span>
                                    </a>
                                </li>
                            </ul>
                            <ul class="list-inline text-center">
                                <li><a href="page-cart.html"><i class="fa fa-shopping-cart"></i> View Cart</a>
                                </li>
                                <li><a href="page-checkout.html"><i class="fa fa-check-square"></i> Checkout</a>
                                </li>
                            </ul>
                        </div>
                    </li>--}}
                    @if ( Auth::user() )
                    <li><a href="{{{ URL::to('/me') }}}"><i class="fa fa-user"></i>Hi, {{{isset(Confide::user()->account->first_name) ? Confide::user()->account->first_name : Confide::user()->username}}}</a></li>
                    <li><a href="{{{ URL::to('/users/logout') }}}"><i class="fa fa-sign-out"></i>Log Out</a></li>
                    @else
                    <li><a class="popup-text" href="#login-dialog" data-effect="mfp-move-from-top"><i class="fa fa-sign-in"></i>Sign in</a></li>
                    <li><a class="popup-text" href="#register-dialog" data-effect="mfp-move-from-top"><i class="fa fa-edit"></i>Sign up</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</header>

<!-- LOGIN REGISTER LINKS CONTENT -->
<div id="login-dialog" class="mfp-with-anim mfp-hide mfp-dialog clearfix">
    <i class="fa fa-sign-in dialog-icon"></i>
    <h3>Member Login</h3>
    <h5>Welcome back, friend. Login to get started</h5>
    {{ Form::open(['url' => '/users/login', 'class' => 'dialog-form']) }}
        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
        <div class="form-group">
            <label>E-mail</label>
            <input type="text" placeholder="{{{ Lang::get('confide::confide.username_e_mail') }}}" class="form-control" name="email">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" placeholder="{{{ Lang::get('confide::confide.password') }}}" class="form-control" name="password">
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember" value="1">Remember me
            </label>
        </div>
        @if (Session::get('error'))
            <div class="alert alert-error alert-danger">{{{ Session::get('error') }}}</div>
        @endif

        @if (Session::get('notice'))
            <div class="alert">{{{ Session::get('notice') }}}</div>
        @endif
        <input type="submit" value="Sign in" class="btn btn-primary">
    {{ Form::close() }}
    <ul class="dialog-alt-links">
        <li><a class="popup-text" href="#register-dialog" data-effect="mfp-zoom-out">Not member yet</a>
        </li>
        <li><a class="popup-text" href="#password-recover-dialog" data-effect="mfp-zoom-out">Forgot password</a>
        </li>
    </ul>
</div>


<div id="register-dialog" class="mfp-with-anim mfp-hide mfp-dialog clearfix">
    <i class="fa fa-edit dialog-icon"></i>
    <h3>Member Register</h3>
    <h5>Ready to get best offers? Let's get started!</h5>
    {{ Form::open(['url' => 'users', 'class' => 'dialog-form']) }}
        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Username" class="form-control">
        </div>
        <div class="form-group">
            <label>E-mail</label>
            <input type="email" name="email" placeholder="{{'email@domain.com'}}" class="form-control">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="My secret password" class="form-control">
        </div>
        <div class="form-group">
            <label>Repeat Password</label>
            <input type="password" name="password_confirmation" placeholder="Type your password again" class="form-control">
        </div>
        {{--<div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label>Your Area</label>
                    <input type="password" placeholder="Boston" class="form-control">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Postal/Zip</label>
                    <input type="password" placeholder="12345" class="form-control">
                </div>
            </div>
        </div>--}}
        @if (Session::get('error'))
            <div class="alert alert-error alert-danger">
                @if (is_array(Session::get('error')))
                    {{ head(Session::get('error')) }}
                @endif
            </div>
        @endif

        @if (Session::get('notice'))
            <div class="alert">{{ Session::get('notice') }}</div>
        @endif
        <div class="checkbox">
            <label>
                <input type="checkbox" name="newsletter">Get hot deals via e-mail
            </label>
        </div>
        <input type="submit" value="Sign up" class="btn btn-primary">
    {{ Form::close() }}
    <ul class="dialog-alt-links">
        <li><a class="popup-text" href="#login-dialog" data-effect="mfp-zoom-out">Already member</a>
        </li>
    </ul>
</div>


<div id="password-recover-dialog" class="mfp-with-anim mfp-hide mfp-dialog clearfix">
    <i class="icon-retweet dialog-icon"></i>
    <h3>Password Recovery</h3>
    <h5>Fortgot your password? Don't worry we can deal with it</h5>
    <form class="dialog-form">
        <label>E-mail</label>
        <input type="text" placeholder="{{'email@domain.com'}}" class="span12">
        <input type="submit" value="Request new password" class="btn btn-primary">
    </form>
</div>
<!-- END LOGIN REGISTER LINKS CONTENT -->


<!-- TOP AREA -->
<div class="top-area {{ $page or 'hidden' }}">

    <div class="bg-holder">
        <div class="bg-mask"></div>
        <div class="bg-blur" style="background-image:url(img/backgrounds/beach.jpg)"></div>
        <div class="container bg-holder-content">
            <div class="gap"></div>
            <div class="row row-wrap">
                <div class="col-md-10 col-md-offset-1">
                    <div class="text-center text-white">
                        @if( isset($page) && $page == 'homepage')
                        <h1>Explore the Best Deals in Your City</h1>
                        <p class="text-bigger">We just want to bring you the best deals in town! <span class="fa fa-smile-o"></span></p>
                        @elseif( isset($page) && $page == 'shops')
                        <h1>Shops</h1>
                        <p class="text-bigger">Find out what your favorite shops are up to!</p>
                        @elseif( isset($page) && $page == 'categories')
                        <h1>Shops</h1>
                        <p class="text-bigger">Find out what your favorite shops are up to!</p>
                        @endif
                        <p>DISCLAIMER: All Currently listed Items are fake.</p>
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

