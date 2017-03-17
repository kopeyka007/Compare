(function() {
	angular.module('compareApp').controller('compareCtrl', ['$scope', '$rootScope', '$http', '$window', '$location', compareCtrl]);
	function compareCtrl($scope, $rootScope, $http, $window, $location) {
		
		$scope.filterList = [];
		$scope.compareList = [];
		var url = $location.path();
		
		$http.post('/api/compare/list', {url}).then(function(response){
			$scope.compareList = response.data.data;
		});
		
		$http.post('/api/compare/catsfilters', {url}).then(function(response){
			$scope.filterList = response.data.data;
			console.log($scope.filterList);
			console.log($scope.filterList[0].groups[1].groups_filters[0].filters_name);
		});
	}
})();