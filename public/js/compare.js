(function() {
	angular.module('compareApp').controller('compareCtrl', ['$scope', '$rootScope', '$http', '$window', '$location', '$uibModal', compareCtrl]);
	function compareCtrl($scope, $rootScope, $http, $window, $location, $uibModal) {
		$scope.mode = 0;
		$scope.filterList = [];
		$scope.compareList = [];
		$scope.closestProd = '';
		var url = $location.path();
		$http.post('/api/compare/list', {url}).then(function(response){
			$scope.compareList = response.data.data.prods;
			$scope.compareListCats = response.data.data.cats;
			$scope.compareListCurr = response.data.data.currencies_default;
		});
		
		$http.post('/api/compare/catsfilters', {url}).then(function(response){
			$scope.filterList = response.data.data;
		});
		
		$scope.statAmazon = function(prod){
			$http.post('/api/history/amazon', {'prods_amazon': prod.prods_amazon, 'prods_id': prod.prods_id}).then(function(response){
				
			});
		};
		
		$scope.nameAllProds = function (){
			var prodsName = [];
			for (var id in $scope.compareList)
			{
				prodsName.push($scope.compareList[id].brands_id.brands_name + ' ' + $scope.compareList[id].prods_name);
			}
			return prodsName.join(' vs. ')
		}
		
		$scope.nameAllProds();
		
		$scope.closeLink = function(prods_id) {
			var aliases = [];
			var cats_alias = '';
			for (var id in $scope.compareList)
			{
				var prod = $scope.compareList[id];
				if (prod.prods_id != prods_id)
				{
					aliases.push(prod.prods_full_alias);
					$scope.selectedCount++;
				}
				else
				{
					for (var k in $scope.products)
					{
						if ($scope.products[k].cats_id == prod.cats_id && $scope.products[k].cats_default == '0')
						{
							cats_alias = $scope.products[k].cats_alias + '/';
						}
					}
				}
			}
			return aliases.length ? ('/compare/' + aliases.join('-vs-')) : '/' + cats_alias;
		};

		$scope.checkDifferences = function(value, index, array) {
			if ($scope.mode == 1)
			{
				var check = false;
				var start = '';
				for (var id in $scope.compareList)
				{
					var prod = $scope.compareList[id];
					if (start == '' && prod.filters[value.filters_id])
					{
						start = prod.filters[value.filters_id].filters_value;
					}

					if ( ! prod.filters[value.filters_id] || (prod.filters[value.filters_id] && start != prod.filters[value.filters_id].filters_value))
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

		$scope.isNumeric = function(n) {
			return ! isNaN(parseFloat(n)) && isFinite(n);
		};
		
		$scope.count = 0;

		$scope.checkFeatures = function(this_prod, features_id) {
			var check = true;
			var duplicate = false;
			var start = '';
			for (var id in $scope.compareList)
			{
				var prod = $scope.compareList[id];
				if (this_prod.prods_id != prod.prods_id)
				{
					if (prod.features[features_id] && prod.features[features_id].features_value && this_prod.features && this_prod.features[features_id].features_value)
					{
						if (this_prod.features[features_id].features_value == prod.features[features_id].features_value)
						{
							duplicate = true;
						}

						if ($scope.isNumeric(prod.features[features_id].features_value) && this_prod.features[features_id].features_value)
						{
							if ((prod.features[features_id].features_rate == '1' && prod.features[features_id].features_value * 1 >= this_prod.features[features_id].features_value * 1) || (prod.features[features_id].features_rate == '0' && prod.features[features_id].features_value * 1 <= this_prod.features[features_id].features_value * 1))
							{
								check = false;
							}
						}
						else
						{
							check = this_prod.features[features_id].features_value.toLowerCase() == 'yes'; 
						}
					}
					else
					{
						if (this_prod.features && (this_prod.features[features_id].features_value == '' || this_prod.features[features_id].features_value == null))
						{
							check = false;
						}
					}
				}
				else
				{
					if (this_prod.features && (this_prod.features[features_id].features_value == '' || this_prod.features[features_id].features_value == null))
					{
						check = false;
					}
				}
			}
			var result = ! duplicate ? check : false;
			if (result)
			{
				$scope.count++;
			}
			return result;
			
		};

		$scope.closestProd = '';
		$scope.percents = function(this_prod, features_id) {
			var min_delta = false;
			var closest = false;
			for (var id in $scope.compareList)
			{
				var prod = $scope.compareList[id];
				if (closest === false)
				{
					closest = prod;
				}

				if (this_prod.prods_id != prod.prods_id)
				{
					if (prod.features[features_id] && prod.features[features_id].features_value && this_prod.features && this_prod.features[features_id].features_value)
					{
						var delta = this_prod.features[features_id].features_value - prod.features[features_id].features_value;
						if (min_delta === false)
						{
							min_delta = delta;
							closest = prod;
						}
						else
						{
							if ((prod.features[features_id].features_rate == '1' && delta < min_delta) || (prod.features[features_id].features_rate == '0' && delta > min_delta))
							{
								min_delta = delta;
								closest = prod;
							}
						}
					}
				}
			}

			if (closest && min_delta !== false)
			{
				$scope.closestProd = closest.brands_id.brands_name + ' ' + closest.prods_name;
				var percent = Math.abs(Math.round(this_prod.features[features_id].features_value * 100 / closest.features[features_id].features_value) - 100);
				return percent + '%';
			}

			$scope.closestProd = closest.brands_id.brands_name + ' ' + closest.prods_name;
			return '100%';
		};

		$scope.productsLink = function(prod) {
			var cats_alias = '';
			for (var k in $scope.products)
			{
				if ($scope.products[k].cats_id == prod.cats_id)
				{
					cats_alias = $scope.products[k].cats_alias;
				}
			}

			return '/' + cats_alias + '/' + prod.prods_full_alias;
		};

		$scope.addToCompare = function(cats_id) {
			var prods = [];
			for (var k in $scope.products)
			{
				if ($scope.products[k].cats_id == cats_id)
				{
					prods = $scope.products[k].prods;
				}
			}

			var modalInstance;
            modalInstance = $uibModal.open({
                templateUrl: "ModalCompareContent.html",
                controller: 'ModalCompareCtrl',
				resolve: {
					items: {'prods': prods, 'compares': $scope.compareList}
				}
			});	
			
			modalInstance.result.then(function (result) {

			}, function() {

			});
		};
	}
})();

(function() {
	angular.module('compareApp').controller('ModalCompareCtrl', ['$scope', '$rootScope', '$uibModalInstance', 'items', ModalCompareCtrl]);
	function ModalCompareCtrl($scope, $rootScope, $uibModalInstance, items) {
		$scope.aliases = [];
		for (var k in items.compares)
		{
			$scope.aliases.push(items.compares[k].prods_full_alias);
		}
		$scope.prods = [];
		for (var k in items.prods)
		{
			var check = true;
			for (var i in items.compares)
			{
				if (items.compares[i].prods_id == items.prods[k].prods_id)
				{
					check = false;
				}
			}

			if (check)
			{
				$scope.prods.push(items.prods[k]);
			}
		}

		$scope.compareLink = function(alias) {
			return '/compare/' + $scope.aliases.join('-vs-') + '-vs-' + alias;
		};

		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};
	}
})();

(function() {
	angular.module('compareApp').directive('scroll', function ($window) {
    return function(scope, element, attrs) {
        angular.element($window).bind('scroll', function() {
            if (this.pageYOffset >= 190) {
                 scope.fixedClass = true;
            } else {
                 scope.fixedClass = false;
            }
            scope.$apply();
			});
		};
	});
})();