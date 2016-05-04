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
	.run(["$rootScope", "$idle", "$location", "logger", function ($rootScope, $idle, $location, logger) {
		$rootScope.events = [];
		$idle.watch();

		$rootScope.$on('$idleTimeout', function () {
			$location.path("/admin/lock-screen")
		});

        //MomentJS functions
        $rootScope.toDate = function(string) {
            return moment(string).toDate();
        };

		$rootScope.tempDir = window.location.origin + '/temp/';
		$rootScope.imageDeals = 'https://dsp-gorigins.cloud.dreamfactory.com/rest/files/applications/Marketplace/images/deals/';
		$rootScope.imageCoupons = 'https://dsp-gorigins.cloud.dreamfactory.com/rest/files/applications/Marketplace/images/coupons/';

	}])
	.controller("AppCtrl", ["$scope", "$location", "DreamFactory", "logger", "UserDataService", function ($scope, $location, DreamFactory, logger, UserDataService) {
		// Add $scope variable to store the user
		$scope.currentUser = UserDataService.getCurrentUser();
		$scope.hasUser = !!$scope.currentUser || false;

		$scope.$on('event:auth-loginRequired', function (e, userDataObj) {
			//angular.element('body').addClass("body-special body-lock")
			$location('/admin/lock-screen');
		});

		$scope.isSpecificPage = function () {
			var path;
			return path = $location.path(), _.contains(["/admin/404", "/admin/500", "/admin/login", "/admin/logout", "/admin/register", "/admin/forgot", "/admin/lock-screen", "/admin/pricing", "/admin/home", "/admin/services", "/admin/about", "/admin/contact"], path)
		}, $scope.main = {brand: "Marketplace", name: "", image: 'https://dsp-gorigins.cloud.dreamfactory.com/rest/files/applications/Marketplace/me-avatar_300.jpg?app_name=Marketplace'},
			$scope.isLockScreen = function () {
				var path;
				return path = $location.path(), _.contains(["/admin/lock-screen"], path)
			},
			$scope.isHome = function () {
				var path;
				return path = $location.path(), _.contains(["/admin/home"], path)
			}
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
			password: null,
			duration: 3600
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
			$location.url('/admin/');
		});

		$scope.$on(UserEventsService.login.loginSuccess, function (e, userDataObj) {
			$scope.$parent.currentUser = userDataObj;
			$location.url('/admin/');
		})
	}])
	.controller('LogoutCtrl', ['$scope', '$location', 'UserEventsService', function ($scope, $location, UserEventsService) {
		$scope.$on(UserEventsService.logout.logoutSuccess, function (e, userDataObj) {
			$scope.$parent.currentUser = userDataObj;
			$location.url('/admin/');
		});
	}])
	.controller('RegisterCtrl', ['$scope', '$location', 'UserEventsService', function ($scope, $location, UserEventsService) {
		$scope.$on(UserEventsService.register.registerSuccess, function (e, userCredsObj) {
			$scope.$broadcast(UserEventsService.login.loginRequest, userCredsObj);
		});

		$scope.$on(UserEventsService.register.registerConfirmation, function (e) {
			$location.url('/admin/register-confirm');
		});

		$scope.$on(UserEventsService.login.loginRequest, function (e, userDataObj) {
			$scope.$parent.currentUser = userDataObj;
			$location.url('/admin/');
		})

	}])
	.controller("HomeCtrl", ["$scope", function ($scope) {
		$scope.myInterval = 5000;
		var slides = $scope.slides = [];
		$scope.addSlide = function() {
			var newWidth = 600 + slides.length;
			slides.push({
				image: 'http://placekitten.com/' + newWidth + '/300',
				text: ['More','Extra','Lots of','Surplus'][slides.length % 4] + ' ' +
					['Cats', 'Kittys', 'Felines', 'Cutes'][slides.length % 4]
			});
		};
		for (var i=0; i<4; i++) {
			$scope.addSlide();
		}
	}])
	.controller('ErrorCtrl', ['$scope', function($scope) {

		$scope.currentError = null;


		$scope.parseDreamFactoryError = function (errorDataObj) {

			// create a place to store the error
			var error = null;

			// If the exception type is a string we don't need to go any further
			// This was thrown explicitly by the module due to a module error
			// unrelated to the server
			if (typeof errorDataObj.exception === 'string') {

				// store the error
				// and we're done
				error = errorDataObj.exception;

				// the exception is not a string
				// let's assume it came from the server
			}else {

				// is there more than one error contained in the object
				// I don't think I've ever encountered more than one message
				// in the error object but we should check
				if(errorDataObj.exception.data.error.length > 1) {

					// yes. Let's loop through and concat these to display to the user
					angular.forEach(errorDataObj.exception.data.error, function(obj) {

						// add the message from each error obj to the error store
						error += obj.message + '\n';
					})

					// We have only one error message
					// 99.9% of the time this is the case
				}else {

					// store that error message
					error = errorDataObj.exception.data.error[0].message;
				}
			}

			// return the built message to display to the user
			return errorDataObj.module + ': ' + error

		};

		$scope.clearError = function() {

			$scope.currentError = null;
		};


		$scope.$on('error:dreamfactory', function(e, errorMessageObj) {

			$scope.currentError = $scope.parseDreamFactoryError(errorMessageObj);
		});

	}])
	.controller("ForgotCtrl", ["$scope", function ($scope) {
	}])
	.controller('ProfileCtrl', ['$scope', function ($scope) {
	}])
	.controller('PricingCtrl', ['$scope', function ($scope) {
	}])
	.controller("DashboardCtrl", ["$scope", function ($scope) {
	}])
	.controller('LockScreenCtrl', ['$scope', '$location', 'UserEventsService', function ($scope, $location, UserEventsService) {
		$scope.userCreds = {
			email   : $scope.$parent.currentUser.email,
			password: null,
			duration: 0
		};

		$scope.login = function () {
			$scope.$broadcast(UserEventsService.login.loginRequest, $scope.userCreds);
		};

		// Here we capture the successful message
		// same as before
		$scope.$on(UserEventsService.login.loginSuccess, function (e, userDataObj) {

			// assign the user
			$scope.$parent.currentUser = userDataObj;
			$scope.$parent.main.name = userDataObj.first_name + ' ' + userDataObj.last_name;

			//authService.loginConfirmed();
			// redirect to home
			$location.url('/admin/dashboard');

		})
	}])
	.controller("CategoriesCtrl", ["$scope", "Category", "logger", function ($scope, Category, logger) {
		$scope.Categories = Category.query();
		$scope.newCategory = {
			title        : '',
			title_alias  : '',
			category_icon: ''
		};

		// Create
		$scope.createCategory = function () {
			Category.save($scope.newCategory, function (data) {
				$scope.Categories.push(data);
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
				updateByAttr($scope.Categories, 'id', category.id, category);
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
    .controller("IssuesCtrl", ["$scope", "Issue", "Shop", "logger", "$filter", "$modal", function ($scope, Issue, Shop, logger, $filter, $modal) {
        $scope.start = function () {
            $scope.Shops = Shop.query();
            Issue.get(function(data){
                angular.forEach(data, function(i) {
                    i.start_date = moment(i.start_date).toDate();
                    i.end_date = moment(i.end_date).toDate();
                });
                $scope.Issues = data;
                $scope.initTable();
            });
        };
        $scope.start();


		// Create
		$scope.createIssue = function (issue) {
            Issue.save(issue, function (data) {
				$scope.Issues.push(data);
                logger.logSuccess("Issue Created");
                $scope.initTable();
			});
		};

		// Update
		$scope.updateIssue = function (issue) {
            Issue.update({id: issue.id}, issue, function () {
				updateByAttr($scope.Issues, 'id', issue.id, issue);
                logger.log("Issue Updated");
                $scope.initTable();
			});
		};

		// Delete
		$scope.deleteIssue = function (issue) {
            Issue.delete({ id: issue.id }, function () {
				angular.element("#issue_" + issue.id).fadeOut(400);
                $timeout(angular.element("#issue_" + issue.id).remove(),500);
                logger.logError("Issue Deleted");
                $scope.initTable();
			});

		};

        /*Issue Table*/
        $scope.initTable = function () {
            var init;
            $scope.searchKeywords = "", $scope.filteredIssues = [], $scope.row = "", $scope.select = function (page) {
                var end, start;
                return start = (page - 1) * $scope.numPerPage, end = start + $scope.numPerPage, $scope.currentPageIssues = $scope.filteredIssues.slice(start, end)
            }, $scope.onFilterChange = function () {
                return $scope.select(1), $scope.currentPage = 1, $scope.row = ""
            }, $scope.onNumPerPageChange = function () {
                return $scope.select(1), $scope.currentPage = 1
            }, $scope.onOrderChange = function () {
                return $scope.select(1), $scope.currentPage = 1
            }, $scope.search = function () {
                return $scope.filteredIssues = $filter("filter")($scope.Issues, $scope.searchKeywords), $scope.onFilterChange()
            }, $scope.order = function (rowName) {
                return $scope.row !== rowName ? ($scope.row = rowName, $scope.filteredIssues = $filter("orderBy")($scope.Issues, rowName), $scope.onOrderChange()) : void 0
            }, $scope.numPerPageOpt = [3, 5, 10, 20], $scope.numPerPage = $scope.numPerPageOpt[2], $scope.currentPage = 1, $scope.currentPageIssues = [], (init = function () {
                return $scope.search(), $scope.select($scope.currentPage)
            })()
        };

        // Misc Functions
        var dFormat = 'dd/MM';
        $scope.genTitle = function(issue) {
            return issue.shop_by_shop_id.title + ': ' + $filter('date')(moment(issue.start_date).toDate(), dFormat) + ' - ' + $filter('date')(moment(issue.end_date).toDate(), dFormat);
        }

        $scope.open = function($event) {
            $event.preventDefault();
            $event.stopPropagation();

            $scope.opened = true;
        };

        // Issue Modal
        $scope.openIssueModal = function ($event, issue, updateMode) {
            if (angular.isUndefined(updateMode))
                return console.log('Parameter not set.');
            else $scope.updateMode = updateMode;

            $scope.thisIssue = issue;
            $scope.thisIssue.expire_date = moment($scope.thisIssue.expire_date).toDate();
            var modalInstance;
            modalInstance = $modal.open({
                templateUrl: "issueModal.html",
                scope: this,
                backdrop: 'static',
                size: 'lg'
            }), modalInstance.result.then(function () {
            }, function () {
                $scope.thisIssue = undefined;
                //$log.info("Modal dismissed at: " + new Date)
            });
        };

        $scope.submitModal = function () {
            if ($scope.updateMode) {
                $scope.updateIssue(this.thisIssue);
            } else {
                $scope.createIssue(this.thisIssue);
            }
            $scope.updateMode = undefined;
        };
	}])
	.controller("ShopsCtrl", ["$scope", "Shop", "logger", "$modal", "$timeout", function ($scope, Shop, logger, $modal, $timeout) {
		$scope.Shops = Shop.query();
		$scope.newShop = {
			title      : '',
			title_alias: '',
			status     : 'active'
		};
		$scope.oFReader = undefined;

		// Create
		$scope.createShop = function () {
			Shop.save($scope.newShop, function (data) {
				$scope.Shops.push(data);
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
		 updateByAttr($scope.Shops, 'id', shop.id, shop);
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
		Shop.get({id: $routeParams.id}, function (res) {
            console.log(res);
            $scope.shop = res;
            $scope.shop.edit_image = 0;

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
					Shop.update({id: $scope.shop.id}, $scope.shop, function (res) {
                        console.log(res);
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
				updateByAttr($scope.Shops, 'id', shop.id, shop);
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
	.controller("CouponsCtrl", ["$scope", "Category", "Shop", "Coupon", "Images", "logger", "$filter", "$resource", "$timeout", function ($scope, Category, Shop, Coupon, Images, logger, $filter, $resource, $timeout) {
		$scope.start = function () {
			$scope.Coupons = Coupon.query({}, function (data) {
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
		$scope.Categories = Category.query();
		$scope.Shops = Shop.query();
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
				var Image = $resource('/admin/saveImage');
				Image.save({
					image: $('.example3 canvas')[0].toDataURL(),
					index: "1",
					id   : $scope.newCoupon.title_alias
				}, function (data) {
					console.log(data);
					Images.create({url: $scope.tempDir + data.name
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
			var newCoupon = $scope.newCoupon;
			if (newCoupon.coupon_type != 'code' && newCoupon.coupon_code != '')
				newCoupon.coupon_code = '';

			newCoupon.coupon_tags = JSON.stringify($scope.newCoupon.coupon_tags);
			Coupon.save(newCoupon, function (data) {
				$scope.Coupons.push(data);
				$scope.start();
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
				return $scope.filteredCoupons = $filter("filter")($scope.Coupons, $scope.searchKeywords), $scope.onFilterChange()
			}, $scope.order = function (rowName) {
				return $scope.row !== rowName ? ($scope.row = rowName, $scope.filteredCoupons = $filter("orderBy")($scope.Coupons, rowName), $scope.onOrderChange()) : void 0
			}, $scope.numPerPageOpt = [3, 5, 10, 20], $scope.numPerPage = $scope.numPerPageOpt[2], $scope.currentPage = 1, $scope.currentPageCoupons = [], (init = function () {
				return $scope.search(), $scope.select($scope.currentPage)
			})()
		};

	}])
	.controller("CouponEditCtrl", ["$scope", "Images", "Category", "Shop", "Coupon", "logger", "$timeout", "$routeParams", "$resource", function ($scope, Images, Category, Shop, Coupon, logger, $timeout, $routeParams, $resource) {
		$scope.thisCoupon = Coupon.get({id: $routeParams.id}, function (data) {
			$scope.thisCoupon.coupon_tags = JSON.parse(data.coupon_tags);
			$scope.Categories = Category.query();
			$scope.Shops = Shop.query();
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
					var Image = $resource('/admin/saveImage');
					Image.save({
						image: $('.example3 canvas')[0].toDataURL(),
						index: "1",
						id   : $scope.thisCoupon.title_alias
					}, function (data) {
						console.log(data);
						Images.create({
							url: $scope.tempDir + data.name
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
			coupon.coupon_tags = JSON.stringify(coupon.coupon_tags);

			Coupon.update({id: coupon.id}, coupon, function () {
				logger.logSuccess("Shop Updated");
			});

		};
	}])
    .controller("DealsCtrl", ["$scope", "Category", "Issue", "Shop", "Deal", "Images", "$modal", "logger", "$filter", "$timeout", "$http", "$resource", function ($scope, Category, Issue, Shop, Deal, Images, $modal, logger, $filter, $timeout, $http, $resource) {
        $scope.start = function () {
            Deal.query({}, function (data) {

                angular.forEach(data, function (a) {
                    if (angular.isString(a.deal_tags) && a.deal_tags.length > 1){
                        var tags = a.deal_tags.split(',');
                        var arr = [];

                        angular.forEach(tags, function (value, key) {
                            arr.push({text:value})
                        });
                        a.deal_tags = arr;
                        console.log(a.deal_tags);
                    }
                });
                $scope.Deals = data;
                $scope.initTable();
            }, function (data) {
                logger.logError(data);
            });
        };
        $scope.start();

        // New Deal Form
        $scope.Categories = Category.query();
        Issue.query({}, function (res) {
            $scope.Issues = res;
            $scope.Issues.push({id:0, title:'None', title_alias:'none'});
        });
        $scope.Shops = Shop.query();
        $scope.today = new Date();
        $scope.toSlug = function (text) {
            return convertToSlug(text);
        };

        $scope.testUpload = function () {
            Images.test({}, function (res) {
                debugger;
            }, function (res) {
                debugger;
            })
        };

        // Create
        $scope.createDeal = function (deal) {
            var newDeal = deal;
            if ( angular.isArray(newDeal.deal_tags) ) {
                var tags = '';
                angular.forEach(newDeal.deal_tags, function (value, key) {
                    tags += (value.text) + ',';
                });
                newDeal.deal_tags = tags.slice(0, -1);
            }
            if (deal.issue_id == 0) deal.issue_id = null;

            Deal.save(newDeal, function (data) {
                $scope.Deals.push(data);
                $scope.initTable();
                angular.element('#addDeal .accordion-toggle').click();
                logger.logSuccess("Deal Created");
            }, function (data) {
                console.log(data);
                logger.logError(data);
            });

			// Get and save Deal image
	        /*var Image = $resource('/admin/downloadImage');
	        Image.save({
		        image: newDeal.deal_images,
		        index: "1",
		        id   : newDeal.shop_id + '_' + newDeal.issue_id + '_' + newDeal.title_alias
	        }, function (data) {
		        console.log(data);
		        Images.create({ url: $scope.tempDir + data.name }, function (response) {
			        console.log('success');
			        console.log(response);
			        newDeal.deal_images = $scope.imageDeals + data.name + '?app_name=Marketplace';
			        logger.logSuccess('Image Uploaded!');

			        // Now save deal
			        Deal.save(newDeal, function (data) {
				        $scope.Deals.push(data);
				        $scope.initTable();
				        angular.element('#addDeal .accordion-toggle').click();
				        logger.logSuccess("Deal Created");
			        }, function (data) {
				        console.log(data);
				        logger.logError(data);
			        });

		        }, function (response) {
			        console.log('error');
			        console.log(response);
			        if (response.data.error[0].message.indexOf('already exists') != -1) {
				        //newDeal.deal_images = $scope.imageDeals + response.name + '?app_name=Marketplace';
				        logger.log('Image Replaced!');
			        }
		        });

	        }, function (data) {
		        logger.logError('Please check that you have uploaded an image!');
		        logger.logWarning(data);
	        });*/

        };

        // Update
        $scope.updateDeal = function (deal) {
            var thisDeal = deal;
            if (angular.isArray(thisDeal.deal_tags)){
                var tags = '';
                angular.forEach(thisDeal.deal_tags, function (value, key) {
                    tags += (value.text) + ',';
                });
                thisDeal.deal_tags = tags.slice(0, -1);
            }
            if (thisDeal.issue_id == 0) thisDeal.issue_id = null;

            Deal.update({id:thisDeal.id}, thisDeal, function (data) {
                console.log(data);
                updateByAttr($scope.Deals, 'id', deal.id, deal);
                $scope.initTable();
                logger.logSuccess("Deal Updated");
            }, function (data) {
                console.log(data);
                logger.logError(data);
            });

        };

        // Delete
        $scope.deleteDeal = function (deal) {
            Deal.delete({ id: deal.id }, function () {
                angular.element("#deal_" + deal.id).fadeOut().remove();
                logger.logError("Deal Deleted");
                $scope.start();
            });
        };

        /*Deal Table*/
        $scope.initTable = function () {
            var init;
            $scope.searchKeywords = "", $scope.searchIssues = "", $scope.filteredDeals = [], $scope.row = "", $scope.select = function (page) {
                var end, start;
                return start = (page - 1) * $scope.numPerPage, end = start + $scope.numPerPage, $scope.currentPageDeals = $scope.filteredDeals.slice(start, end)
            }, $scope.onFilterChange = function () {
                return $scope.select(1), $scope.currentPage = 1, $scope.row = ""
            }, $scope.onNumPerPageChange = function () {
                return $scope.select(1), $scope.currentPage = 1
            }, $scope.onOrderChange = function () {
                return $scope.select(1), $scope.currentPage = 1
            }, $scope.search = function () {
                return $scope.filteredDeals = $filter("filter")($scope.Deals, $scope.searchKeywords), $scope.onFilterChange()
            }, $scope.searchIssue = function () {
                return $scope.filteredDeals = $filter("filter")($scope.Deals, {issue_id: $scope.searchIssues}), $scope.onFilterChange()
            }, $scope.order = function (rowName) {
                return $scope.row !== rowName ? ($scope.row = rowName, $scope.filteredDeals = $filter("orderBy")($scope.Deals, rowName), $scope.onOrderChange()) : void 0
            }, $scope.numPerPageOpt = [3, 5, 10, 20], $scope.numPerPage = $scope.numPerPageOpt[3], $scope.currentPage = 1, $scope.currentPageDeals = [], (init = function () {
                return $scope.search(), $scope.select($scope.currentPage)
            })()
        };

        // Confirm Delete Modal for Group
        $scope.openDeleteConfirmDeal = function ($event, group, array) {
            var modalInstance;
            modalInstance = $modal.open({
                templateUrl: "deleteConfirmation.html",
                size: 'sm',
                resolve: {
                    thisGroup: function () {
                        return group;
                    },
                    thisArray: function () {
                        return array;
                    }
                }
            }), modalInstance.result.then(function (thisGroup, thisArray) {
                //$scope.deleteGuest($event, group);
                if (array.length != 0) {
                    logger.log('Please empty this group first.');
                } else {
                    /*Groups.delete({ id: group.id }, function () {
                        angular.element('#group_' + group.id).fadeOut(800);
                        logger.log("Group, " + group.name +" was deleted.");
                    });*/
                }
            }, function () {
                //$log.info("Modal dismissed at: " + new Date)
            });
        };

        // New Deal Modal
        $scope.openDealModal = function ($event, deal, updateMode) {
            console.log(deal);
            if (angular.isUndefined(updateMode))
                return console.log('Parameter not set.');
            else $scope.updateMode = updateMode;
            console.log($scope.updateMode);

            $scope.thisDeal = deal;
            $scope.thisDeal.edit_image = !!updateMode ? 0 : 1 ;

            $scope.thisDeal.image_url = angular.isDefined(deal.photos) && angular.isDefined(deal.photos[0])  ? deal.photos[0].path : '';
            $scope.thisDeal.expire_date = moment($scope.thisDeal.expire_date).toDate();
            var modalInstance;
            modalInstance = $modal.open({
                templateUrl: "dealModal.html",
                scope: this,
                backdrop: 'static',
                size: 'lg'
            }), modalInstance.result.then(function () {
            }, function () {
                $scope.thisDeal = undefined;
                //$log.info("Modal dismissed at: " + new Date)
            });
        };

        $scope.submitModal = function () {
            if ($scope.updateMode) {
                $scope.updateDeal(this.thisDeal);
            } else {
                $scope.createDeal(this.thisDeal);
            }
            $scope.updateMode = undefined;
        };

        // Misc Functions
        var dFormat = 'dd/MM';
        $scope.genTitle = function(issue) {
            return angular.isDefined(issue.shop_by_shop_id) ? issue.shop_by_shop_id.title + ': ' + $filter('date')(moment(issue.start_date).toDate(), dFormat) + ' - ' + $filter('date')(moment(issue.end_date).toDate(), dFormat) : issue.title;
        };
        $scope.genTableTitle = function(deal) {
            return $filter('date')(moment(deal.issues_by_issue_id.start_date).toDate(), dFormat) + ' - ' + $filter('date')(moment(deal.issues_by_issue_id.end_date).toDate(), dFormat);
        };

        $scope.APISearch = function(value){
            //console.log();
            //if (e.keyCode == 13) {
                return $http.post('/admin/api/itemmaster', {
                    query: value
                }).then(function(res){
                    lol = res.data.item;
                    var items = [];
                    angular.forEach(res.data.item, function(v){
                        if(angular.isArray(v.media) && v.media.length > 0){
                            v.image = v.media.medium[0].url;
                        } else if (angular.isObject(v.media) && angular.isDefined(v.media.medium)) {
                            v.image = v.media.medium.url;
                        }
                        items.push(v);
                    });
	                console.log(items);
                    return items;
                });
                //return false;
            //}
        };

        $scope.loadingItemMaster = false;

        $scope.autoFillDeal = function(a){
            this.thisDeal.brand = a.products.product.brand;
            this.thisDeal.title = a.products.product.description;
            this.thisDeal.title_alias = convertToSlug(this.thisDeal.title);
            this.thisDeal.image_url = a.image;
            this.thisDeal.description = a.marketingDescription || a.otherDescription;
            this.thisDeal.status = 'active';
            this.thisDeal.size = 'per ' + a.packageData.packageSize.uom.toLowerCase();
            console.log(a);
        };
        $scope.asyncSelected = void 0;
    }]);