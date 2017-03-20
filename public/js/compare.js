(function() {
	angular.module('compareApp').controller('compareCtrl', ['$scope', '$rootScope', '$http', '$window', '$location', compareCtrl]);
	function compareCtrl($scope, $rootScope, $http, $window, $location) {
		$scope.mode = 'all';
		$scope.filterList = [];
		$scope.compareList = [];
		var url = $location.path();
		
		$http.post('/api/compare/list', {url}).then(function(response){
			$scope.compareList = response.data.data;
		});
		
		$http.post('/api/compare/catsfilters', {url}).then(function(response){
			$scope.filterList = response.data.data;
		});
		
		$scope.closeLink = function(prods_id) {
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
			return '/compare/' + aliases.join('-vs-');
		};

		$scope.checkDifferences = function(value, index, array) {
			if ($scope.mode == 'diff')
			{
				var check = false;
				var start = '';
				for (var id in $scope.compareList)
				{
					var prod = $scope.compareList[id];
					if (start == '')
					{
						start = prod.filters[value.filters_id];
					}

					if (start != prod.filters[value.filters_id])
					{
						check = true;
					}
				}

				return check;
			}
			else
			{
				return true;
			}
		};
	}
})();