<!-- Scripts queries -->
{{ HTML::script('js/jquery.js') }}
{{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/js/bootstrap.min.js') }}
{{ HTML::script('js/countdown.min.js') }}
{{ HTML::script('js/flexnav.min.js') }}
{{ HTML::script('js/magnific.js') }}
{{ HTML::script('js/tweet.min.js') }}
{{ HTML::script('//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false') }}
{{ HTML::script('js/fitvids.min.js') }}
{{ HTML::script('js/mail.min.js') }}
{{ HTML::script('js/ionrangeslider.js') }}
{{ HTML::script('js/icheck.js') }}
{{ HTML::script('js/fotorama.js') }}
{{ HTML::script('js/card-payment.js') }}
{{ HTML::script('js/owl-carousel.js') }}
{{ HTML::script('js/masonry.js') }}
{{ HTML::script('js/nicescroll.js') }}

<!-- AngularJS -->
{{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.2/moment.min.js') }}
{{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.2.1/moment-timezone-with-data-2010-2020.min.js') }}

{{ HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.2.25/angular.min.js') }}
{{ HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.2.25/angular-animate.min.js') }}
{{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/angular-moment/0.8.0/angular-moment.min.js') }}

{{ HTML::script('js/angulartics.min.js') }}
{{ HTML::script('js/angulartics-ga.min.js') }}

{{ HTML::script('js/ui.js') }}
{{ HTML::script('js/app.js') }}


<!-- Custom scripts -->
{{ HTML::script('js/custom.js') }}

<script type="text/ng-template" id="QuickViewDeal.html">
	{{--<div class="modal-header">
		<h3>Equipment Modal</h3>
	</div>--}}
	<div class="modal-body">
		<div class="row" ng-show="deal">
            <div class="col-md-7">
                <div class="">
                    <img ng-src="//deal.deal_images\\" alt="//deal.title\\" title="//deal.title\\" />
                </div>
            </div>
            <div class="col-md-5">
                <div class="product-page-meta">
                    <h4>//deal.title\\</h4>
                    {{--<p>//deal.description|cut:50:true\\</p>--}}
                    <a class="btn btn-primary btn-lg btn-block" href="#">$//deal.new_price\\</a>
                    <ul class="list product-page-meta-info">
                        <li>
                            <ul class="list product-page-meta-price-list text-center">
                                <li>
                                    <span class="product-page-meta-title">List Price</span>
                                    <span class="product-page-meta-price">$//deal.list_price\\</span>
                                </li>
                                <li>
                                    <span class="product-page-meta-title">Discount</span>
                                    <span class="product-page-meta-price">//calcDiscount(deal) | number:2\\%</span>
                                </li>
                                <li>
                                    <span class="product-page-meta-title">Savings</span>
                                    <span class="product-page-meta-price">$//calcSavings(deal) | number:2\\</span>
                                </li>
                            </ul>
                        </li>
                        <li class="text-center">
                            <span class="product-page-meta-title">Time Left to Buy</span>
                            <!-- COUNTDOWN -->
                            <h4 class="text-huge text-primary" am-time-ago="'//deal.expire_date\\'"></h4>
                        </li>
                        <li>
                            <div class="row">
                                <div class="col-sm-4">
                                    <a href="//'/shops/' + deal.shop_by_shop_id.title_alias\\">
                                        <img ng-src="//deal.shop_by_shop_id.shop_image\\" class="img-rounded" alt="//deal.title\\" title="//deal.title\\" />
                                    </a>
                                </div>
                                <div class="col-sm-8">
                                    <h4>
                                        <a href="//'/shops/' + deal.shop_by_shop_id.title_alias\\" class="">
                                            //deal.shop_by_shop_id.title\\
                                        </a>
                                    </h4>
                                </div>
                            </div>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
	</div>
	<div class="modal-footer">
	    {{--<a class="btn btn-primary pull-left" href="//deal.title_alias\\">More Details</a>--}}
		<button class="btn btn-link" ng-click="$dismiss('cancel')"><i class="fa fa-times"></i></button>
	</div>
</script>