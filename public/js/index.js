(function() {
	angular.module('compareApp').controller('indexCtrl', ['$scope', '$rootScope', '$http', '$window', '$location', indexCtrl]);
	
	function indexCtrl($scope, $rootScope, $http, $window, $location) {
		$scope.sort = 'asc';
		$scope.filters = [];
		$scope.products_list = [];
		var urlCat = $location.path();
		
		$http.post('/api/cats/front/list', {urlCat}).then(function(response){
			$scope.products_list = response.data.data;
			$scope.getBrands($scope.products_list.cats.prods);
		});
		
		$scope.allBrands = {};
		$scope.getBrands = function(prods) {
			for (var k in prods)
			{
				$scope.allBrands[prods[k].brands_id.brands_id] = prods[k].brands_id.brands_name;
			}
		};
		
		$scope.filters_list = function() {
			$http.get('/api/filters/front/filtersfilter').then(function(response) {
				$scope.filters = response.data.data;
			});
		};
		$scope.filters_list();
		
		$scope.filters_model = {};
		$scope.filters_brand = {};
		$scope.slectedFilters = {};
		$scope.slectedBrands = {};
		
		$scope.changeFilter = function(id, option, key) {
			if ( ! $scope.slectedFilters[id])
			{
				$scope.slectedFilters[id] = {};
			}
			$scope.slectedFilters[id][key] = option;
		};

		$scope.changeBrand = function(id) {
			$scope.slectedBrands[id] = $scope.filters_brand[id];
		};

		$scope.filterProds = function(value, index, array) {
			var show = true;
			for (var i in $scope.slectedFilters)
			{
				var filter_count = 0;
				var all_count = 0;
				for (var k in $scope.slectedFilters[i])
				{
					if ($scope.slectedFilters[i][k] != '' && $scope.filters_model[i][k])
					{
						if ((value.filters[i] && value.filters[i] != $scope.slectedFilters[i][k]) || ! value.filters[i])
						{
							filter_count++;
						}
						all_count++;
					}
				}

				if (filter_count == all_count && all_count > 0)
				{
					show = false;
				}
			}

			var brand_count = 0;
			var all_brand_count = 0;
			for (var id in $scope.slectedBrands)
			{
				if ($scope.slectedBrands[id])
				{
					if (id != value.brands_id.brands_id)
					{
						brand_count++;
					}
					all_brand_count++;
				}
			}
			
			if (all_brand_count == brand_count && brand_count > 0)
			{
				show = false;
			}
			return show ? value : false;
		};
		
		$scope.goDetail = function(id){
			$location.hash('.header');
		}
		
		$scope.goUp = function(){
			$location.hash('.header');
		}
		
		
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
					aliases.push(prod.prods_full_alias);
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