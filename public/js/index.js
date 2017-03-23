(function() {
	angular.module('compareApp').controller('indexCtrl', ['$scope', '$rootScope', '$http', '$window', '$location', indexCtrl]);
	
	function indexCtrl($scope, $rootScope, $http, $window, $location) {
		$scope.filters = [];
		$scope.urlCat = $location.path();
		
		$http.post('/api/cats/front/list', {$scope.urlCat}).then(function(response){
			console.log(response);
		});
		
		$scope.filters_list = function() {
			$http.get('/api/filters/front/filtersfilter').then(function(response) {
				$scope.filters = response.data.data;
			});
		};
		$scope.filters_list();

		$scope.sort = {};
		$scope.filters_model = {};
		$scope.slectedFilters = {};
		$scope.changeFilter = function(id) {
			$scope.slectedFilters[id] = $scope.filters_model[id];
		};

		$scope.filterProds = function(value, index, array) {
			var show = true;
			for (var i in $scope.slectedFilters)
			{
				if ($scope.slectedFilters[i] != '')
				{
					if ((value.filters[i] && value.filters[i] != $scope.slectedFilters[i]) || ! value.filters[i])
					{
						show = false;
					}
				}
			}

			return show ? value : false;
		};

		$scope.selectedCount = {};
		$scope.selectedProds = {};
		$scope.compareAlias = {};
		$scope.selectedMax = 4;
		$scope.chooseProd = function(prod, cat) {
			prod.selected = 1 - prod.selected;
			if (prod.selected == 1)
			{
				if ($scope.selectedCount[cat.cats_id] < $scope.selectedMax)
				{
					$scope.selectedProds[cat.cats_id][prod.prods_id] = prod;
				}
				else
				{
					prod.selected = 0;
				}
			}
			else
			{
				$scope.selectedProds[cat.cats_id][prod.prods_id] = false;
			}
			
			$scope.linkCompare(cat);
		};

		$scope.linkCompare = function(cat) {
			var aliases = [];
			$scope.selectedCount[cat.cats_id] = 0;
			for (var id in $scope.selectedProds[cat.cats_id])
			{
				var prod = $scope.selectedProds[cat.cats_id][id];
				if (prod)
				{
					aliases.push(prod.prods_alias);
					$scope.selectedCount[cat.cats_id]++;
				}
			}

			if (aliases.length > 1)
			{
				$scope.compareAlias[cat.cats_id] = '/compare/' + aliases.join('-vs-');
			}
			else
			{
				$scope.compareAlias[cat.cats_id] = '/' + cat.cats_alias + '/' + aliases.join();
			}
		}
	}
})();