(function() {
	angular.module('compareApp').controller('indexCtrl', ['$scope', '$rootScope', '$http', '$window', indexCtrl]);
	
	function indexCtrl($scope, $rootScope, $http, $window) {
		$scope.products = [];
		$scope.filters = [];

		$scope.products_list = function() {
			$http.get('/api/cats/front/shortlist').then(function(response) {
				$scope.products = response.data;
			});
		};
		$scope.products_list();

		$scope.filters_list = function() {
			$http.get('/api/filters/front/filtersfilter').then(function(response) {
				$scope.filters = response.data.data;
				console.log($scope.filters);
			});
		};
		$scope.filters_list();
	}
})();