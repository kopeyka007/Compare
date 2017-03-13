(function(){
	var compareApp = angular.module('compareApp', ['ngRoute']);

	compareApp.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
		
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
	
	compareApp.controller('compareController', function() {
		
	});

})();