<?php $rating = Jraty::get($shop->id, 'Shop'); ?>
<!DOCTYPE HTML>
<html>

<head>
    <title>{{$shop->title}} on Marketplace</title>
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
        <div class="bg-holder">
            <div class="bg-mask"></div>
            <div class="bg-blur" style="background-image:url(img/backgrounds/phone.jpg)"></div>
            <div class="container bg-holder-content">
                <div class="gap"></div>
                <div class="row row-wrap bg-white">
                <div class="gap gap-small"></div>
                    <div class="col-sm-3">
                        <img class="img-thumbnail" src="{{isset($shop->photos[0]) ? Cloudy::show($shop->photos[0]->public_id) : '/temp/default.jpg';}}" alt=""/>
                    </div>
                    <div class="col-sm-6">
                        <h2>{{$shop->title}}</h2>
                        <p>{{$shop->summary or 'Donec luctus maximus tortor sit amet fringilla. Vivamus euismod consequat ante sed posuere. Morbi non urna id velit lobortis lobortis. Vestibulum eleifend odio turpis. Nam tincidunt dui a turpis fermentum, et malesuada libero posuere. Fusce ex turpis, vehicula non diam ut, egestas pretium ligula. In vitae viverra justo, non bibendum elit. Vestibulum consectetur erat ut volutpat fermentum.'}}</p>
                    </div>
                    <div class="col-sm-3">
                        <form action="">
                            <div class="form-group" ng-controller="ShopRatingCtrl">
                                <label>Rating</label>
                                <ul class="icon-list icon-list-inline" ng-init="rate = {{$rating->avg;}}; item.id = {{$shop->id}}">
                                    <rating ng-model="rate"
                                            max="max"
                                            ng-mouseup="rateIt()"
                                            class="ui-rating size-h4 fa-2x"
                                            readonly="isReadonly"
                                            on-hover="hoveringOver(value)"
                                            on-leave="overStar = null"
                                            state-on="'fa fa-star'"
                                            state-off="'fa fa-star-o'"
                                    ></rating>
                                    {{--<span class="label" ng-class="{'label-warning': percent<30, 'label-info': percent>=30 && percent<70, 'label-success': percent>=70}" ng-show="overStar && !isReadonly">//percent\\%</span>--}}
                                </ul>
                                {{Jraty::html($shop->id, 'Shop', $shop->title, isset($shop->photos[0]) ? Cloudy::show($shop->photos[0]->public_id) : '/temp/default.jpg', true);}}
                            </div>
                        </form>
                        <hr/>
                        <h4 class="text-huge text">Deals:&nbsp;<span class="text-primary text-huge text">{{count($shop->deals)}}</span></h4>
                        {{--<hr/>
                        <button class="btn btn-primary btn-block">Follow Shop</button>--}}
                    </div>
                </div>
                <div class="gap"></div>
            </div>
        </div>
        <div class="gap"></div>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row row-wrap" id="masonry">
                        @foreach($shop->deals as $deal)
                        <a class="col-md-3 col-masonry" href="javascript:;" analytics-on="click" analytics-event="DealModal" {{-- href="#product-quick-view-dialog" data-effect="mfp-move-from-top"--}} ng-click="quickViewDeal({{$deal->id}})">
                            <div class="product-thumb">
                                <header class="product-header">
                                    <img src="{{isset($deal->photos[0]) ? Cloudy::show($deal->photos[0]->public_id) : Cloudy::show($shop->photos[0]->public_id)}}" alt="Image Alternative text" title="{{$deal->title}}" />
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
                                    <p class="product-location"><i class="fa fa-map-marker"></i> {{$shop->title}}</p>
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
