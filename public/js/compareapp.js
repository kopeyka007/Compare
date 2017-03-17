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
			':cat/:prod'
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
						if (params.cat && param.prod)
						{
							return '/pages/personal';
						}
						else
						{
							return  '/pages/index';
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
	angular.module('compareApp').controller('mainCtrl', ['$scope', '$rootScope', '$http', '$window', mainCtrl]);
	
	
	function mainCtrl($scope, $rootScope, $http, $window) {
		$scope.selectedMax = 4;
		$scope.cats = [];
		$scope.list_products = function() {
			$http.get('/api/cats/front/shortlist').then(function(response) {
				$scope.cats = response.data;
			});
		};
		$scope.list_products();
		
		$scope.selectedProds = {};
		
		$scope.chooseProd = function(prod) {
			prod.selected = 1 - prod.selected;
			
			if (prod.selected == 1)
			{
				if ($scope.selectedCount < $scope.selectedMax)
				{
					$scope.selectedProds[prod.prods_id] = prod;
				}
				else
				{
					prod.selected = 0;
				}
			}
			else
			{
				$scope.selectedProds[prod.prods_id] = false;
			}
			
			$scope.linkCompare();
		};
		
		
		
		$scope.preLink = '';
		$scope.selectedCount = 0;
		$scope.linkCompare = function() {
			console.log($scope.selectedProds);
			var aliases = [];
			$scope.selectedCount = 0;
			for (var id in $scope.selectedProds)
			{
				var prod = $scope.selectedProds[id];
				if (prod)
				{
					aliases.push(prod.prods_alias);
					$scope.selectedCount++;
				}
			}
			if (aliases.length > 1)
			{
				$scope.preLink = 'compare/';
				$scope.compareAlias = $scope.preLink + aliases.join('-vs-');
			}
			else
			{
				$scope.preLink = 'smartphone/'
				$scope.compareAlias = $scope.preLink + aliases.join();
			}
			
		}
		
	}
})();