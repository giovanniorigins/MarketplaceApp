moment.locale('en', {
    relativeTime : {
        future: "%s remaining",
        past:   "%s ago",
        s:  "seconds",
        m:  "a minute",
        mm: "%d minutes",
        h:  "an hour",
        hh: "%d hours",
        d:  "a day",
        dd: "%d days",
        M:  "a month",
        MM: "%d months",
        y:  "a year",
        yy: "%d years"
    }
});

$.cloudinary.config().cloud_name = 'agora';

angular.module('app', ['ngAnimate', 'ui.bootstrap', 'angularMoment', 'angulartics', 'angulartics.google.analytics', 'cloudinary', 'ngActivityIndicator', 'djds4rce.angular-socialshare'])
    .config(function($interpolateProvider ) {
        $interpolateProvider.startSymbol('//');
        $interpolateProvider.endSymbol('\\\\');
    })
    .constant('angularMomentConfig', {
        //preprocess: 'utc', // optional
        timezone: 'America/Nassau' // optional
    })
    .config(function ($analyticsProvider) {
        $analyticsProvider.firstPageview(true); /* Records pages that don't use $state or $route */
        $analyticsProvider.withAutoBase(true);  /* Records full path */
    })
    /*.directive("highlightActive", [function () {
        return{restrict: "A", controller: ["$scope", "$element", "$attrs", "$location", function ($scope, $element, $attrs, $location) {
            var highlightActive, links, path;
            return links = $element.find("a"), path = function () {
                return window.location.href;
            }, highlightActive = function (links, path) {
                return path = *//*"#" +*//* path, angular.forEach(links, function (link) {
                    console.log(path);
                    var $link = angular.element(link), $li = $link.parent("li"), href = $link.attr("href");
                    return $li.hasClass("active") && $li.removeClass("active"), href == path || href == window.loction.host ? $li.addClass("active") : void 0
                })
            }, highlightActive(links, window.location.href), $scope.$watch(path, function (newVal, oldVal) {
                return newVal !== oldVal ? highlightActive(links, window.location.href) : void 0
            })
        }]}
    }])*/
    .filter('cut', function () {
        return function (value, wordwise, max, tail) {
            if (!value)
                return '';

            max = parseInt(max, 10);
            if (!max)
                return value;
            if (value.length <= max)
                return value;

            value = value.substr(0, max);
            if (wordwise) {
                var lastspace = value.lastIndexOf(' ');
                if (lastspace != -1) {
                    value = value.substr(0, lastspace);
                }
            }

            return value + (tail || '…');
        };
    })
    .controller('AppCtrl', ['$scope', '$http', '$location', '$modal', '$activityIndicator', function ($scope, $http, $location, $modal, $activityIndicator) {
       console.log('Location: ',$location.path());

        $scope.quickViewDeal = function (id) {
            var modalInstance;
            modalInstance = $modal.open({
                //templateUrl: "EquipmentModal.html",
                controller: 'QuickViewDealCtrl',
                templateUrl:'QuickViewDeal.html',
                scope: this,
                backdrop: true,
                resolve: {
                    DealData: function () {
                        $activityIndicator.startAnimating();
                        return $http.get('/api/deals/' + id)
                            .success(function () {
                                $activityIndicator.stopAnimating();
                            });
                    }
                },
                backdrop: 'static'/*,
                size: 'lg'*/
            }), modalInstance.result.then(function (obj) {
            }, function () {
                //$log.info("Modal dismissed at: " + new Date)
            });
        };
    }])
    .controller('QuickViewDealCtrl', ['$scope', '$modalInstance', 'DealData', function ($scope, $modalInstance, DealData) {
        //console.log(DealData);
        $scope.deal = DealData.data;

        $scope.calcDiscount = function (deal) {
            return (deal.list_price - deal.new_price) / deal.list_price * 100;
        };

        $scope.calcSavings = function (deal) {
            return deal.list_price - deal.new_price;
        };
    }])
    .controller('ShopRatingCtrl', ['$scope', '$http', function ($scope, $http) {
        $scope.rate = 0;
        $scope.max = 5;
        $scope.isReadonly = false;
        $scope.item = {
            id:0,
            type:'Shop'
        };
        var inited = false;

        $scope.hoveringOver = function(value) {
            $scope.overStar = value;
            $scope.percent = 100 * (value / $scope.max);
        };

        $scope.ratingStates = [
            {stateOn: 'glyphicon-ok-sign', stateOff: 'glyphicon-ok-circle'},
            {stateOn: 'glyphicon-star', stateOff: 'glyphicon-star-empty'},
            {stateOn: 'glyphicon-heart', stateOff: 'glyphicon-ban-circle'},
            {stateOn: 'glyphicon-heart'},
            {stateOff: 'glyphicon-off'}
        ];

        /**/

        $scope.rateIt = function () {
            console.log('Rated: ', 100 * ($scope.rate / $scope.max));
        };

        $scope.$watch('rate', function (newValue, oldValue) {
            if (newValue > 0) {
                if (inited) {
                    $http.post('/ratings', {
                        item_id:$scope.item.id,
                        item_type: $scope.item.type,
                        score: $scope.rate
                    }).success(function (res) {
                        console.log(res);
                        $scope.rate = res.avg;
                    });
                }
                inited = true;
            }
        });

    }]);