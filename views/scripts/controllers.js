var lol;
var updateByAttr = function (arr, attr1, value1, newRecord) {
	if (!arr) {
		return false;
	}
	var i = arr.length;
	while (i--) {
		if (arr[i] && arr[i][attr1] && (arguments.length > 2 && arr[i][attr1] === value1 )) {
			arr[i] = newRecord;
		}
	}
	return arr;
};

var convertToSlug = function (Text) {
	return Text
		.toLowerCase()
		.replace(/[^\w ]+/g, '')
		.replace(/ +/g, '-');
};

"use strict";
angular.module("app.controllers", [])
	.run(["$rootScope", "$idle", "$location", "logger", function ($rootScope, $idle, $location, DreamFactory, logger) {
		$rootScope.events = [];
		$idle.watch();

		$rootScope.$on('$idleTimeout', function () {
			$location.path("/lock-screen")
		})

		$rootScope.tempDir = window.location.origin + '/temp/';
		$rootScope.imageCoupons = 'https://dsp-gorigins.cloud.dreamfactory.com/rest/files/applications/Marketplace/images/coupons/'

	}])
	.controller("AppCtrl", ["$scope", "$location", "DreamFactory", "logger", "UserDataService", function ($scope, $location, DreamFactory, logger, UserDataService) {
		// Add $scope variable to store the user
		$scope.currentUser = UserDataService.getCurrentUser();
		$scope.hasUser = !!$scope.currentUser || false;

		return $scope.isSpecificPage = function () {
			var path;
			return path = $location.path(), _.contains(["/404", "/500", "/login", "/logout", "/register", "/forgot", "/lock-screen"], path)
		}, $scope.main = {brand: "Marketplace", name: "", image: 'https://dsp-gorigins.cloud.dreamfactory.com/rest/files/applications/Marketplace/me-avatar_300.jpg?app_name=Marketplace'}
	}])
	.controller("NavCtrl", ["$scope", "taskStorage", "filterFilter", function ($scope, taskStorage, filterFilter) {
		$scope.$watch('currentUser', function (newValue, oldValue) {
			$scope.hasUser = !!newValue;
			$scope.$parent.main.name = newValue.first_name + ' ' + newValue.last_name;
		});
		var tasks;
		return tasks = $scope.tasks = taskStorage.get(),
			$scope.taskRemainingCount = filterFilter(tasks, {completed: !1}).length,
			$scope.$on("taskRemaining:changed", function (event, count) {
				return $scope.taskRemainingCount = count
			})
	}])
	.controller('LoginCtrl', ['$scope', '$location', 'UserEventsService', function ($scope, $location, UserEventsService) {
		$scope.userCreds = {
			email   : null,
			password: null
		};

		$scope.login = function () {
			$scope.$broadcast(UserEventsService.login.loginRequest, $scope.userCreds);
		};

		// Here we capture the successful message
		// same as before
		$scope.$on(UserEventsService.login.loginSuccess, function (e, userDataObj) {

			// assign the user
			$scope.$parent.currentUser = userDataObj;

			// redirect to home
			$location.url('/');
		});

		$scope.$on(UserEventsService.login.loginSuccess, function (e, userDataObj) {
			$scope.$parent.currentUser = userDataObj;
			$location.url('/');
		})
	}])
	.controller('LogoutCtrl', ['$scope', '$location', 'UserEventsService', function ($scope, $location, UserEventsService) {
		$scope.$on(UserEventsService.logout.logoutSuccess, function (e, userDataObj) {
			$scope.$parent.currentUser = userDataObj;
			$location.url('/');
		});
	}])
	.controller('RegisterCtrl', ['$scope', '$location', 'UserEventsService', function ($scope, $location, UserEventsService) {
		$scope.$on(UserEventsService.register.registerSuccess, function (e, userCredsObj) {
			$scope.$broadcast(UserEventsService.login.loginRequest, userCredsObj);
		});

		$scope.$on(UserEventsService.register.registerConfirmation, function (e) {
			$location.url('/register-confirm');
		});

		$scope.$on(UserEventsService.login.loginRequest, function (e, userDataObj) {
			$scope.$parent.currentUser = userDataObj;
			$location.url('/');
		})

	}])
	.controller("ForgotCtrl", ["$scope", function ($scope) {
	}])
	.controller('ProfileCtrl', ['$scope', function ($scope) {
	}])
	.controller('PricingCtrl', ['$scope', function ($scope) {
	}])
	.controller("DashboardCtrl", ["$scope", function ($scope) {
	}])
	.controller("CategoriesCtrl", ["$scope", "Category", "logger", function ($scope, Category, logger) {
		$scope.Categories = Category.get();
		$scope.newCategory = {
			title        : '',
			title_alias  : '',
			category_icon: ''
		};

		// Create
		$scope.createCategory = function () {
			Category.save($scope.newCategory, function (data) {
				$scope.Categories.record.push(data);
				$scope.newCategory = {
					newTitle     : '',
					newTitleAlias: '',
					newIcon      : ''
				};
			});
			logger.logSuccess("Category Created");
		};

		// Update
		$scope.updateCategory = function (category) {
			Category.update({id: category.id}, category, function () {
				updateByAttr($scope.Categories.record, 'id', category.id, category);
			});
			logger.log("Category Updated");
		};

		// Delete
		$scope.deleteCategory = function (category) {
			Category.delete({ id: category.id }, function () {
				angular.element("#category_" + category.id).fadeOut();
			});
			logger.logError("Category Deleted");
		}
	}])
	.controller("ShopsCtrl", ["$scope", "Shop", "logger", "$modal", "$timeout", function ($scope, Shop, logger, $modal, $timeout) {
		$scope.Shops = Shop.get();
		$scope.newShop = {
			title      : '',
			title_alias: '',
			status     : 'active'
		};
		$scope.oFReader = undefined;

		// Create
		$scope.createShop = function () {
			Shop.save($scope.newShop, function (data) {
				$scope.Shops.record.push(data);
				$scope.newShop = {
					newTitle     : '',
					newTitleAlias: '',
					status       : 'active'
				};
			});
			logger.logSuccess("Shop Created");
		};

		/*// Update
		 $scope.updateShop = function (shop) {
		 Shop.update({id: shop.id}, shop, function () {
		 updateByAttr($scope.Shops.record, 'id', shop.id, shop);
		 });
		 logger.log("Shop Updated");
		 };*/

		// Delete
		$scope.deleteShop = function (shop) {
			Shop.delete({ id: shop.id }, function () {
				angular.element("#shop_" + shop.id).fadeOut();
			});
			logger.logError("Shop Deleted");
		}
	}])
	.controller("ShopEditCtrl", ["$scope", "Shop", "logger", "$timeout", "$routeParams", function ($scope, Shop, logger, $timeout, $routeParams) {
		$scope.shop = Shop.get({id: $routeParams.id}, function () {
			$timeout(function () {
				$scope.two = {};

				$scope.initCrop = function () {
					// create new object crop
					$scope.two = new CROP();
					$scope.two.init('.default2');
					$scope.two.loadImg($scope.shop.shop_image);
				};

				if (angular.isUndefined($scope.two.imgInfo))
					$scope.initCrop();
			}, 0);

			$scope.crop = function () {
				// grab width and height of .crop-img for canvas
				var width = angular.element('.example2 .crop-container').width() - 30, // new image width
					height = angular.element('.example2 .crop-container').height() - 30;  // new image height

				$('.example2 canvas').remove();
				$('.default2').after('<canvas width="' + width + '" height="' + height + '" id="canvas"/>');

				var ctx = $('.example2 canvas')[0].getContext('2d'),
					img = new Image,
					w = coordinates($scope.two).w,
					h = coordinates($scope.two).h,
					x = coordinates($scope.two).x,
					y = coordinates($scope.two).y;

				img.src = coordinates($scope.two).image;

				img.onload = function () {
					// draw image
					ctx.drawImage(img, x, y, w, h, 0, 0, width, height);

					// display canvas image
					$('.example2 canvas').addClass('output').show().delay('16000').fadeOut('slow');

					//console.log($( '.example2 canvas' )[0].toDataURL());
					$scope.shop.shop_image = $('.example2 canvas')[0].toDataURL();
					Shop.update({id: $scope.shop.id}, shop, function () {

					});

				};

			};

			//  on click of .upload class, open .uploadfile (input file)
			// --------------------------------------------------------------------------

			angular.element('body').on("click", ".newupload2", function () {
				$('.uploadfile2').click();
			});

			// on input[type="file"] change
			angular.element('body').change(".uploadfile2", function () {
				loadImageFile();
				$timeout(function () {
					// resets input file
					$('.uploadfile2').wrap('<form>').closest('form').get(0).reset();
					$('.uploadfile2').unwrap();
				}, 30);
			});


			//  get input type=file IMG through base64 and send it to the cropper
			// --------------------------------------------------------------------------

			$scope.oFReader = $scope.oFReader || new FileReader();
			$scope.rFilter = /^(?:image\/bmp|image\/cis\-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x\-cmu\-raster|image\/x\-cmx|image\/x\-icon|image\/x\-portable\-anymap|image\/x\-portable\-bitmap|image\/x\-portable\-graymap|image\/x\-portable\-pixmap|image\/x\-rgb|image\/x\-xbitmap|image\/x\-xpixmap|image\/x\-xwindowdump)$/i;

			function loadImageFile() {

				if (document.getElementById("uploadfile2").files.length === 0)
					return;

				var oFile = document.getElementById("uploadfile2").files[0];

				if (!$scope.rFilter.test(oFile.type)) {
					return;
				}

				$scope.oFReader.readAsDataURL(oFile);
			}

			$scope.oFReader.onload = function (oFREvent) {

				angular.element('.example2').html(
						'<div class="default2">' +
						'<div class="cropMain"></div>' +
						'<div class="cropSlider"></div>' +
						'</div>'
				);

				// create new object crop
				$scope.two = new CROP();
				$scope.two.init('.default2');
				$scope.two.loadImg(oFREvent.target.result);
			};
		});

		// Update
		$scope.updateShop = function (shop) {
			Shop.update({id: shop.id}, shop, function () {
				updateByAttr($scope.Shops.record, 'id', shop.id, shop);
			});
			logger.log("Shop Updated");
		};

		// Delete
		$scope.deleteShop = function (shop) {
			Shop.delete({ id: shop.id }, function () {
				angular.element("#shop_" + shop.id).fadeOut();
			});
			logger.logError("Shop Deleted");
		}
	}])
	.controller("CouponsCtrl", ["$scope", "Category", "Shop", "Coupon", "CouponImages", "logger", "$filter", "$resource", "$timeout", function ($scope, Category, Shop, Coupon, CouponImages, logger, $filter, $resource, $timeout) {
		$scope.start = function () {
			$scope.Coupons = Coupon.get({}, function (data) {
				$scope.initTable();
			}, function (data) {
				logger.logError(data);
			});
			$scope.newCoupon = {
				title            : '',
				title_alias      : '',
				status           : 'active',
				category_id      : '',
				shop_id          : '',
				coupon_type      : 'deal',
				coupon_code      : '',
				coupon_images    : '',
				short_description: '',
				description      : '',
				coupon_tags      : [],
				expire_date      : '',
				list_price       : '',
				new_price        : '',
				discount         : ''
			};
		};
		$scope.start();

		// New Coupon Form
		$scope.Categories = Category.get();
		$scope.Shops = Shop.get();
		$scope.today = new Date();
		$scope.toSlug = function (text) {
			$scope.newCoupon.title_alias = convertToSlug(text);
		};
		$timeout(function () {
			$scope.two = {};
			$scope.initCrop = function () {
				// create new object crop
				$scope.two = new CROP();
				$scope.two.init('.default3');
				$scope.two.loadImg('');
			};

			if (angular.isUndefined($scope.two.imgInfo))
				$scope.initCrop();
		}, 0);

		$scope.crop = function () {
			// grab width and height of .crop-img for canvas
			var width = angular.element('.example3 .crop-container').width() - 30, // new image width
				height = angular.element('.example3 .crop-container').height() - 30;  // new image height

			$('.example3 canvas').remove();
			$('.default3').after('<canvas width="' + width + '" height="' + height + '" id="canvas"/>');

			var ctx = $('.example3 canvas')[0].getContext('2d'),
				img = new Image,
				w = coordinates($scope.two).w,
				h = coordinates($scope.two).h,
				x = coordinates($scope.two).x,
				y = coordinates($scope.two).y;

			img.src = coordinates($scope.two).image;

			img.onload = function () {
				// draw image
				ctx.drawImage(img, x, y, w, h, 0, 0, width, height);

				// display canvas image
				$('.example3 canvas').addClass('output').show().delay('8000').fadeOut('slow');

				// Create Image and Upload
				var Image = $resource('/saveImage');
				Image.save({
					image: $('.example3 canvas')[0].toDataURL(),
					index: "1",
					id   : $scope.newCoupon.title_alias
				}, function (data) {
					console.log(data);
					CouponImages.create({url: $scope.tempDir + data.name
					}, function (data) {
						console.log('success');
						console.log(data);
						$scope.newCoupon.coupon_images = $scope.imageCoupons + data.name + '?app_name=Marketplace';
						logger.logSuccess('Image Uploaded!');
					}, function (data) {
						console.log('error');
						console.log(data);
						if (data.data.error[0].message.indexOf('already exists') != -1) {
							$scope.newCoupon.coupon_images = $scope.imageCoupons + data.name + '?app_name=Marketplace';
							logger.log('Image Replaced!');
						}
					});

				}, function (data) {
					logger.logError('Please check that you have uploaded an image!');
					logger.logWarning(data);
				});
			};

		};

		//  on click of .upload class, open .uploadfile (input file)
		// --------------------------------------------------------------------------

		angular.element('body').on("click", ".newupload3", function () {
			$('.uploadfile3').click();
		});

		// on input[type="file"] change
		angular.element('body').change(".uploadfile3", function () {
			loadImageFile();
			$timeout(function () {
				// resets input file
				$('.uploadfile3').wrap('<form>').closest('form').get(0).reset();
				$('.uploadfile3').unwrap();
			}, 30);
		});
		//  get input type=file IMG through base64 and send it to the cropper
		// --------------------------------------------------------------------------

		$scope.oFReader = $scope.oFReader || new FileReader();
		$scope.rFilter = /^(?:image\/bmp|image\/cis\-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x\-cmu\-raster|image\/x\-cmx|image\/x\-icon|image\/x\-portable\-anymap|image\/x\-portable\-bitmap|image\/x\-portable\-graymap|image\/x\-portable\-pixmap|image\/x\-rgb|image\/x\-xbitmap|image\/x\-xpixmap|image\/x\-xwindowdump)$/i;

		function loadImageFile() {

			if (document.getElementById("uploadfile3").files.length === 0)
				return;

			var oFile = document.getElementById("uploadfile3").files[0];

			if (!$scope.rFilter.test(oFile.type)) {
				return;
			}

			$scope.oFReader.readAsDataURL(oFile);
		}

		$scope.oFReader.onload = function (oFREvent) {

			angular.element('.example3').html(
					'<div class="default3">' +
					'<div class="cropMain"></div>' +
					'<div class="cropSlider"></div>' +
					'</div>'
			);

			// create new object crop
			$scope.two = new CROP();
			$scope.two.init('.default3');
			$scope.two.loadImg(oFREvent.target.result);
		};
		// Create
		$scope.createCoupon = function () {
			var newCoupon = $scope.newCoupon, arr = [];
			if (newCoupon.coupon_type != 'code' && newCoupon.coupon_code != '')
				newCoupon.coupon_code = '';
			angular.forEach($scope.newCoupon.coupon_tags, function (i) {
				arr.push(i.text);
			});
			console.log(arr);
			newCoupon.coupon_tags = arr;
			Coupon.save(newCoupon, function (data) {
				$scope.Coupons.record.push(data);
				$scope.newCoupon = {
					title            : '',
					title_alias      : '',
					status           : 'active',
					category_id      : '',
					shop_id          : '',
					coupon_type      : 'deal',
					coupon_code      : '',
					coupon_images    : '',
					short_description: '',
					description      : '',
					coupon_tags      : [],
					expire_date      : '',
					list_price       : '',
					new_price        : '',
					discount         : ''
				};
				angular.element('#addCoupon .accordion-toggle').click();
				logger.logSuccess("Coupon Created");
			}, function (data) {
				console.log(data);
				logger.logError(data);
			});

		};

		// Delete
		$scope.deleteCoupon = function (coupon) {
			Coupon.delete({ id: coupon.id }, function () {
				angular.element("#coupon_" + coupon.id).fadeOut().remove();
				logger.logError("Coupon Deleted");
				$scope.start();
			});
		};

		/*Coupon Table*/
		$scope.initTable = function () {
			var init;
			$scope.searchKeywords = "", $scope.filteredCoupons = [], $scope.row = "", $scope.select = function (page) {
				var end, start;
				return start = (page - 1) * $scope.numPerPage, end = start + $scope.numPerPage, $scope.currentPageCoupons = $scope.filteredCoupons.slice(start, end)
			}, $scope.onFilterChange = function () {
				return $scope.select(1), $scope.currentPage = 1, $scope.row = ""
			}, $scope.onNumPerPageChange = function () {
				return $scope.select(1), $scope.currentPage = 1
			}, $scope.onOrderChange = function () {
				return $scope.select(1), $scope.currentPage = 1
			}, $scope.search = function () {
				return $scope.filteredCoupons = $filter("filter")($scope.Coupons.record, $scope.searchKeywords), $scope.onFilterChange()
			}, $scope.order = function (rowName) {
				return $scope.row !== rowName ? ($scope.row = rowName, $scope.filteredCoupons = $filter("orderBy")($scope.Coupons.record, rowName), $scope.onOrderChange()) : void 0
			}, $scope.numPerPageOpt = [3, 5, 10, 20], $scope.numPerPage = $scope.numPerPageOpt[2], $scope.currentPage = 1, $scope.currentPageCoupons = [], (init = function () {
				return $scope.search(), $scope.select($scope.currentPage)
			})()
		};

	}])
	.controller("CouponEditCtrl", ["$scope", "CouponImages", "Category", "Shop", "Coupon", "logger", "$timeout", "$routeParams", "$resource", function ($scope, CouponImages, Category, Shop, Coupon, logger, $timeout, $routeParams, $resource) {
		$scope.thisCoupon = Coupon.get({id: $routeParams.id}, function (data) {
			//$scope.thisCoupon.coupon_tags = eval(data.coupon_tags);
			$scope.Categories = Category.get();
			$scope.Shops = Shop.get();
			$scope.today = new Date();
			$scope.toSlug = function (text) {
				$scope.thisCoupon.title_alias = convertToSlug(text);
			};

			$scope.two = {};
			$scope.initCrop = function () {
				// create new object crop
				$scope.two = new CROP();
				$scope.two.init('.default3');
				$scope.two.loadImg(data.coupon_images + '?app_name=Marketplace');
			};

			if (angular.isUndefined($scope.two.imgInfo))
				$scope.initCrop();

			$scope.crop = function () {
				// grab width and height of .crop-img for canvas
				var width = angular.element('.example3 .crop-container').width() - 30, // new image width
					height = angular.element('.example3 .crop-container').height() - 30;  // new image height

				$('.example3 canvas').remove();
				$('.default3').after('<canvas width="' + width + '" height="' + height + '" id="canvas"/>');

				var ctx = $('.example3 canvas')[0].getContext('2d'),
					img = new Image,
					w = coordinates($scope.two).w,
					h = coordinates($scope.two).h,
					x = coordinates($scope.two).x,
					y = coordinates($scope.two).y;

				img.src = coordinates($scope.two).image;

				img.onload = function () {
					// draw image
					ctx.drawImage(img, x, y, w, h, 0, 0, width, height);

					// display canvas image
					$('.example3 canvas').addClass('output').show().delay('8000').fadeOut('slow');

					// Create Image and Upload
					var Image = $resource('/saveImage');
					Image.save({
						image: $('.example3 canvas')[0].toDataURL(),
						index: "1",
						id   : $scope.thisCoupon.title_alias
					}, function (data) {
						console.log(data);
						CouponImages.create({url: $scope.tempDir + data.name
						}, function (data) {
							console.log('success');
							console.log(data);
							$scope.thisCoupon.coupon_images = $scope.imageCoupons + data.name + '?app_name=Marketplace';
							logger.logSuccess('Image Uploaded!');
						}, function (data) {
							console.log('error');
							console.log(data);
							if (data.data.error[0].message.indexOf('already exists') != -1) {
								$scope.thisCoupon.coupon_images = $scope.imageCoupons + data.name + '?app_name=Marketplace';
								logger.log('Image Replaced!');
							}
						});

					}, function (data) {
						logger.logError('Please check that you have uploaded an image!');
						logger.logWarning(data);
					});

					// Save DataURL string
					//$scope.thisCoupon.coupon_images = $('.example3 canvas')[0].toDataURL();
				};

			};

			//  on click of .upload class, open .uploadfile (input file)
			// --------------------------------------------------------------------------

			angular.element('body').on("click", ".newupload3", function () {
				$('.uploadfile3').click();
			});

			// on input[type="file"] change
			angular.element('body').change(".uploadfile3", function () {
				loadImageFile();
				$timeout(function () {
					// resets input file
					$('.uploadfile3').wrap('<form>').closest('form').get(0).reset();
					$('.uploadfile3').unwrap();
				}, 30);
			});


			//  get input type=file IMG through base64 and send it to the cropper
			// --------------------------------------------------------------------------

			$scope.oFReader = $scope.oFReader || new FileReader();
			$scope.rFilter = /^(?:image\/bmp|image\/cis\-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x\-cmu\-raster|image\/x\-cmx|image\/x\-icon|image\/x\-portable\-anymap|image\/x\-portable\-bitmap|image\/x\-portable\-graymap|image\/x\-portable\-pixmap|image\/x\-rgb|image\/x\-xbitmap|image\/x\-xpixmap|image\/x\-xwindowdump)$/i;

			function loadImageFile() {

				if (document.getElementById("uploadfile3").files.length === 0)
					return;

				var oFile = document.getElementById("uploadfile3").files[0];

				if (!$scope.rFilter.test(oFile.type)) {
					return;
				}

				$scope.oFReader.readAsDataURL(oFile);
			}

			$scope.oFReader.onload = function (oFREvent) {

				angular.element('.example3').html(
						'<div class="default3">' +
						'<div class="cropMain"></div>' +
						'<div class="cropSlider"></div>' +
						'</div>'
				);

				// create new object crop
				$scope.two = new CROP();
				$scope.two.init('.default3');
				$scope.two.loadImg(oFREvent.target.result);
			};
		});

		// Update
		$scope.updateCoupon = function (coupon) {
			delete coupon.shop_by_shop_id;
			delete coupon.categories_by_category_id;
			delete coupon.hotspots_by_hotspot_id;
			delete coupon.hotspot_id;
			delete coupon.dateCreated;
			delete coupon.dateUpdated;

			debugger;

			Coupon.update({id: coupon.id}, coupon, function () {
				logger.logSuccess("Shop Updated");
			});

		};
	}])