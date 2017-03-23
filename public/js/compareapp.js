(function(){
	angular.module('compareApp', ['ngRoute', 'angularUtils.directives.dirDisqus', 'ui.bootstrap']);
	angular.module('compareApp').config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
		
		$locationProvider.html5Mode({
			enabled: true,
			requireBase: false
		});
		var routes, setRoutes;

		routes = [
			'compare/:alias/',
			':cat/:prod',
			':cat'
		];

		setRoutes = function(route) {
			var config, url;
			url = '/' + route;
			config = {
				templateUrl: function(params)
				{
					if (params.alias)
					{
						return '/pages/' + params.alias;
					}
					else
					{
						if (params.cat && params.prod)
						{
							return '/pages/products';
						}
						else
						{
							return '/pages/index';
						}
					}
				}
			};
			
			$routeProvider.when(url, config);
			return $routeProvider;
		};

		routes.forEach(function(route) {
			return setRoutes(route);
		});

	   $routeProvider
			.when('/', {templateUrl: '/pages/index'});
	}]);
})();

(function(){
	angular.module('compareApp').controller('mainCtrl', ['$scope', '$rootScope', '$http', '$window', '$location', '$route', '$timeout', mainCtrl]);
	
	function mainCtrl($scope, $rootScope, $http, $window, $location, $route, $timeout) {
		$scope.products = [];
		$scope.products_list = function() {
			$http.get('/api/cats/front/shortlist').then(function(response) {
				$scope.products = response.data;
				console.log($scope.products[1]);
			});
		};
		$scope.products_list();
		
		$scope.loaderClass = 'loader-init';
		$scope.$on('$routeChangeStart', function(next, current) {
			$scope.loaderClass = 'loader-init';
		});
		$scope.$on('$viewContentLoaded', function(){
			$timeout(function () {
				$scope.loaderClass = 'loader-hide';
				$timeout(function () {
					$scope.loaderClass = 'loader-none';
				}, 300);
			}, 500);
		});
	}
})();

(function(){
	angular.module('compareApp').filter('checkmark', function() {
    return function(input) {
		return input ? '\u2713' : '\u2718';
    };
  });
})();