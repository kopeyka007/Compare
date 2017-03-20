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
		});
		
		$scope.closeLink = function(prods_id, alias) {
			var aliases = [];
			for (var id in $scope.compareList)
			{
				var prod = $scope.compareList[id];
				if (prod.prods_id != prods_id)
				{
					aliases.push(prod.prods_alias);
					$scope.selectedCount++;
				}
			}
console.log(prods_id);
			$scope.preLink = '/compare/';
			return $scope.preLink + aliases.join('-vs-');
			
		};
	}
})();