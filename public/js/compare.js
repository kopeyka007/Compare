(function() {
	angular.module('compareApp').controller('compareCtrl', ['$scope', '$rootScope', '$http', '$window', '$location', '$uibModal', compareCtrl]);
	function compareCtrl($scope, $rootScope, $http, $window, $location, $uibModal) {
		$scope.mode = 'all';
		$scope.filterList = [];
		$scope.compareList = [];
		$scope.closestProd = '';
		var url = $location.path();
		$http.post('/api/compare/list', {url}).then(function(response){
			$scope.compareList = response.data.data;
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
			for (var id in $scope.compareList)
			{
				var prod = $scope.compareList[id];
				if (prod.prods_id != prods_id)
				{
					aliases.push(prod.prods_full_alias);
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
						start = prod.filters[value.filters_id].filters_value;
					}

					if (start != prod.filters[value.filters_id].filters_value)
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

		$scope.checkFeatures = function(this_prod, features_id) {
			var check = true;
			var start = '';
			for (var id in $scope.compareList)
			{
				var prod = $scope.compareList[id];
				if (this_prod.prods_id != prod.prods_id)
				{
					if (prod.features[features_id] && prod.features[features_id].features_value && this_prod.features && this_prod.features[features_id].features_value)
					{
						if ((prod.features[features_id].features_rate == '1' && prod.features[features_id].features_value * 1 >= this_prod.features[features_id].features_value * 1) || (prod.features[features_id].features_rate == '0' && prod.features[features_id].features_value * 1 <= this_prod.features[features_id].features_value * 1))
						{
							check = false;
						}
					}
				}
			}

			return check;
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
				var percent = Math.round(min_delta * 100 / this_prod.features[features_id].features_value);
				return percent + '%';
			}

			$scope.closestProd = closest.brands_id.brands_name + ' ' + closest.prods_name;
			return '100%';
		};

		$scope.closestProd = function(this_prod, features_id) {

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