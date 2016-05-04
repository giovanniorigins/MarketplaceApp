<?php
    use Underscore\Underscore;
    use Underscore\Types\Arrays;
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>{{$category->title}} | Marketplace</title>
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
                        @foreach($category->deals as $deal)
                        <a class="col-md-3 col-masonry" href="" ng-click="quickViewDeal({{$deal->id}})">
                            <div class="product-thumb">
                                <header class="product-header">
                                    <img src="{{isset($deal->photos[0]) ? $deal->photos[0]->path: null;}}" alt="Image Alternative text" title="{{$deal->title}}" />
                                    <div class="product-quick-view"><span class="fa fa-eye"></span>
                                    </div>
                                </header>
                                <div class="product-inner">
                                    <h5 class="product-title">{{Str::limit($deal->title, 29)}}</h5>
                                    {{--<div class="product-desciption hidden">Pellentesque laoreet lectus facilisis pretium laoreet</div>--}}
                                    <div class="product-meta"><span class="product-time"><i class="fa fa-clock-o"></i> <span am-time-ago="'{{$deal->expire_date}}'"></span></span>
                                        <ul class="product-price-list">
                                            <li><span class="product-price">${{$deal->new_price}}</span>
                                            </li>
                                            <li><span class="product-old-price">${{$deal->list_price}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <p class="product-location">
                                        <i class="fa fa-map-marker"></i>
                                        {{$deal->shop->title}}
                                    </p>
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
