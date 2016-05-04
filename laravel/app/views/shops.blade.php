<!DOCTYPE HTML>
<html>

<head>
    <title>Shops | Marketplace</title>
    @include('shared.head')
</head>

<body ng-app="app" class="">


    <div class="global-wrap" ng-controller="AppCtrl">


        <!-- //////////////////////////////////
	//////////////MAIN HEADER///////////// 
	////////////////////////////////////-->
	@include('shared.header')
        <!-- //////////////////////////////////
	//////////////END MAIN HEADER////////// 
	////////////////////////////////////-->


        <!-- //////////////////////////////////
	//////////////PAGE CONTENT///////////// 
	////////////////////////////////////-->
        <div class="gap"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <aside class="sidebar-left">
                        @include('shared.categories')
                    </aside>
                </div>
                <div class="col-md-9">
                    <div class="row row-wrap" id="">
                        @foreach($shops as $shop)
                        <div class="col-md-4">

                                <div class="product-banner">
                                    <img src="{{isset($shop->photos[0]) ? $shop->photos[0]->path: null;}}" alt="{{$shop->title}}" title="{{$shop->title}}" />
                                    <div class="product-banner-inner">
                                        <h5 class="">{{$shop->title}}</h5>
                                        <a analytics-on="click" analytics-event="ShopView" href="{{url('/shops/' . $shop->title_alias)}}" class="btn btn-sm btn-white">Explore {{count($shop->deals)}} Deals</a>
                                    </div>
                                </div>

                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="gap"></div>
        </div>


        <!-- //////////////////////////////////
	//////////////END PAGE CONTENT///////// 
	////////////////////////////////////-->



        <!-- //////////////////////////////////
	//////////////MAIN FOOTER////////////// 
	////////////////////////////////////-->
    @include('shared.footer')
        <!-- //////////////////////////////////
	//////////////END MAIN  FOOTER///////// 
	////////////////////////////////////-->


    @include('shared.foot')
    </div>
</body>

</html>
