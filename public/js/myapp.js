(function(){
	var compare = angular.module('compare', []);

	compare.controller('compareController', function() {
		
	});

	compare.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
		$locationProvider.html5Mode(true);
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