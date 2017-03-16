(function(){
	angular.module('compareApp', ['ngRoute']);
	angular.module('compareApp').config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
		
		$locationProvider.html5Mode({
			enabled: true,
			requireBase: false
		});
		var routes, setRoutes;

		routes = [
			'compare/:alias/',
			'compare'
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
						return  '/pages/index';
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
	angular.module('compareApp').controller('compareCtrl', ['$scope', '$rootScope', '$http', '$window', compareCtrl]);
	
	
	function compareCtrl($scope, $rootScope, $http, $window) {
		$scope.products = [];
		$scope.list_products = function() {
			$http.get('/api/cats/front/shortlist').then(function(response) {
				$scope.products = response.data;
				console.log($scope.products[0].cats_alias);
			});
		}
		$scope.list_products();
		
	}
})();