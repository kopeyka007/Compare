(function(){
	angular.module('panelApp', ['ngRoute', 'ngSanitize', 'ngAnimate', 'ui.bootstrap']);
	angular.module('panelApp').config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
		
		$locationProvider.html5Mode({
			enabled: true,
			requireBase: false
		});
		var routes, setRoutes;

		routes = [
			'panel/:controller/:id/',
			'panel/:controller/',
			'panel'
		];

		setRoutes = function(route) {
			var config, url;
			url = '/' + route;
			config = {
				templateUrl: function(params)
				{
					if (params.controller && params.id)
					{
						return '/pages/panel/' + params.controller + '/' + params.id;
					}
					else if (params.controller)
					{
						return '/pages/panel/' + params.controller;
					}
					else if (params)
					{
						return  '/pages/panel/dashboard';
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
			.when('/', {templateUrl: '/pages/panel/dashboard'});
	}]);
})();

(function(){
	angular.module('panelApp').controller('panelCtrl', ['$scope', '$rootScope', '$http', '$window', '$location', panelCtrl]);
	
	function panelCtrl($scope, $rootScope, $http, $window, $location) {
		$rootScope.errors = [];

		$rootScope.user = false;
		$scope.info = function() {
			$http.get('/api/users/info').then(function(response) {
				$rootScope.user = response.data.data;
			});
		};
		$scope.info();
		
		$scope.logout = function() {
			$http.post('/api/signout', {}).then(function(response) {
				$window.location.reload(true);
			});
		};

		$scope.access = function(page) {
			var rules = {'users': 1,
					 	 'cats': 2,
					 	 'brands': 2,
						 'features': 2,
					  	 'filters': 2,
					  	 'prods': 3};

			if (rules[page])
			{
				return $rootScope.user.type.id <= rules[page];
			}

			return false;
		};
	}
})();