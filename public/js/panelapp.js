(function(){
	var panelApp = angular.module('panelApp', ['ngRoute']);
	
	panelApp.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
		
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
					if (params.controller)
					{
						return '/pages/panel/' + params.controller + '/' + params.id;
					}
					else if (params.controller)
					{
						return '/pages/panel/' + params.controller;
					}
					else
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