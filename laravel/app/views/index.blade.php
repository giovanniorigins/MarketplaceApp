<!DOCTYPE HTML>
<html>

<head>
    <title>Home | Marketplace</title>
    @include('shared.head')
</head>

<body ng-app="app" class="" ng-activity-indicator>


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
    @include('section.featured')

        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <aside class="sidebar-left">
                        @include('shared.categories')
                    </aside>
                </div>
                <div class="col-md-9">
                    <div class="row row-wrap" id="masonry">
                        @foreach($deals as $deal)
                        <a class="col-md-3 col-masonry" analytics-on="click" analytics-event="DealModal" href="javascript:;" ng-click="quickViewDeal({{$deal->id}})">
                            <div class="product-thumb">
                                <header class="product-header">
                                    <img src="{{isset($deal->photos[0]) ? Cloudy::show($deal->photos[0]->public_id) : Cloudy::show($deal->shop->photos[0]->public_id)}}" alt="Image Alternative text" title="{{$deal->title}}" />
                                    <div class="product-quick-view"><span class="fa fa-eye"></span>
                                    </div>
                                </header>
                                <div class="product-inner">
                                    <h5 class="product-title">{{Str::limit($deal->title, 29)}}</h5>
                                    {{--<div class="product-desciption hidden">Pellentesque laoreet lectus facilisis pretium laoreet</div>--}}
                                    <div class="product-meta"><span class="product-time"><i class="fa fa-clock-o"></i> <span am-time-ago="'{{$deal->expire_date}}'"></span></span>
                                        <ul class="product-price-list">
                                            @if( isset($deal->new_price) )
                                            <li><span class="product-price">${{$deal->new_price}}</span></li>
                                            @endif
                                            @if( isset($deal->list_price) )
                                            <li><span class="product-old-price">${{$deal->list_price}}</span></li>
                                            @endif
                                            @if( isset($deal->discount) )
                                            <li><span class="product-price">{{$deal->discount}}% off</span></li>
                                            @endif
                                        </ul>
                                    </div>
                                    <p class="product-location"><i class="fa fa-map-marker"></i> {{$deal->shop->title}}</p>
                                </div>
                            </div>
                        </a>
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
