angular.module("app.services", [])
	.config(['$idleProvider', '$keepaliveProvider', function ($idleProvider, $keepaliveProvider) {
		// configure $idle settings
		$idleProvider.idleDuration(3000); // in seconds
		$idleProvider.warningDuration(5); // in seconds
		$keepaliveProvider.interval(2); // in seconds
	}])
	.factory('AppData', ['DSP_URL', 'DSP_API_KEY', function (DSP_URL, DSP_API_KEY) {
		"use strict";
		return {
			DB          : DSP_URL + '/rest/db',
			Files       : DSP_URL + '/rest/files/applications/' + DSP_API_KEY,
			ShopImages  : DSP_URL + '/rest/files/applications/' + DSP_API_KEY + '/images/logos/?include_files=true',
			DealImages  : DSP_URL + '/rest/files/applications/' + DSP_API_KEY + '/images/deals/?include_files=true',
			CouponImages: DSP_URL + '/rest/files/applications/' + DSP_API_KEY + '/images/coupons/?include_files=true'
		};
	}])
	.factory('Category', ['$resource', 'AppData', function ($resource, AppData) {
		"use strict";
		return $resource('/admin/api/categories/:id', {},
			{
                update: { method: 'PUT' },
                query: { method: 'GET', isArray: true }
            });
	}])
	.factory('Issue', ['$resource', 'AppData', function ($resource, AppData) {
		"use strict";
		return $resource(AppData.DB + '/issues/:id/?app_name=Marketplace&fields=*&related=shop_by_shop_id%2Cdeals_by_issue_id', {},
			{
                update: { method: 'PUT' },
                query: { method: 'GET', isArray: true }
            });
	}])
	.factory('Shop', ['$resource', function ($resource) {
		"use strict";
		return $resource('/admin/api/shops/:id', {},
			{
                update: { method: 'PUT' },
                query: { method: 'GET', isArray: true }
            });
	}])
	.factory('Deal', ['$resource', function ($resource) {
		"use strict";
		return $resource('/admin/api/deals/:id', {},
			{
				update: { method: 'PUT' },
				query: { method: 'GET', isArray: true }
			});
	}])
	.factory('Coupon', ['$resource', function ($resource) {
		"use strict";
		return $resource('/admin/api/coupons/:id', {},
			{
                update: { method: 'PUT' },
                query: {method: 'GET', isArray: true}
            });
	}])
    .factory('Images', ['$resource', function ($resource) {
        return $resource('/admin/api/images/:id', {},
            {
                update: { method: 'PUT' },
                query: {method: 'GET', isArray: true}
            });
    }])

