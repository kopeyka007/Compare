(function() {
	angular.module('panelApp').controller('prodsCtrl', ['$scope', '$rootScope', '$http', '$window', '$uibModal', 'validate', prodsCtrl]);
	function prodsCtrl($scope, $rootScope, $http, $window, $uibModal, validate) {
		$scope.cats = [];
		$http.get('/api/cats/list').then(function(response) {
			$scope.cats = response.data.data;
		});
		
		$scope.brands = [];
		$http.get('/api/brands/list').then(function(response) {
			$scope.brands = response.data.data;
		});
		
		$scope.add = function(id) {
			id = id || false;

			var prod = {};
			if (id)
			{
				for (var k in $scope.list)
				{
					if ($scope.list[k].prods_id == id)
					{
						prod = $scope.list[k];
					}
				}
			}

			var modalInstance;
            modalInstance = $uibModal.open({
                templateUrl: "ModalProdsContent.html",
                controller: 'ModalProdsCtrl',
				resolve: {
					items: {'cats': $scope.cats, 'prod': prod, 'brands': $scope.brands, 'list': $scope.list}
				}
			});	
			
			modalInstance.result.then(function (result) {
				$rootScope.errors = [result];
				$scope.get_list();
			}, function() {

			}); 
		};

		$scope.remove = function(id) {
			if (confirm('Do you realy want to remove this item?'))
			{
				$http.delete('/api/prods/delete/' + id).then(function(response) {
					$rootScope.errors = [response.data.message];
					$scope.get_list();
				});
			}
		};
		
		$scope.list = [];
		$scope.get_list = function() {
			$http.get('/api/prods/list').then(function(response) {
				$scope.list = response.data.data;
			});
		};
		$scope.get_list();
	}
})();

(function() {
	angular.module('panelApp').controller('ModalProdsCtrl', ['$scope', '$rootScope', '$http', '$uibModalInstance', '$timeout', 'validate', 'items', ModalProdsCtrl]);
	function ModalProdsCtrl($scope, $rootScope, $http, $uibModalInstance, $timeout, validate, items) {
		$scope.errors = [];
		$scope.cats = [{'cats_id': 0, 'cats_name': 'Choose Category'}].concat(items.cats);
		$scope.brands = [{'brands_id': 0, 'brands_name': 'Choose Brand'}].concat(items.brands);
		$scope.prod = {'prods_id': 0,
						  'cats_id': {'cats_id': 0, 'cats_name': 'Choose Category'},
						  'brands_id': {'brands_id': 0, 'brands_name': 'Choose Brand'},
					  	  'prods_name': '',
					  	  'prods_alias': '',
						  'prods_amazon': '',
						  'prods_price': '',
						  'prods_active': 1
						  };
		
		if (items.prod && items.prod.prods_id)
		{
			for (var k in items.prod)
			{
				$scope.prod[k] = items.prod[k];
			}
		}	
		
		$scope.slug = function() {
			if ( ! $scope.prod.prods_id && $scope.form.slug.$pristine)
			{
				$scope.prod.prods_alias = $scope.prod.prods_name.replace(/ /gi, '-').toLowerCase();
			}
		};
		
		$scope.save = function () {
			$scope.errors = [];
			var error = 1;
			error *= validate.check($scope, $scope.form.prods_name, 'Name');
			error *= validate.check($scope, $scope.form.slug, 'Slug');
			error *= validate.check($scope, $scope.form.prods_id, 'Product');
			
			for (var k in items.list)
			{
				if ($scope.prod.prods_alias.toLowerCase() == items.list[k].prods_alias.toLowerCase() && $scope.prod.prods_id != items.list[k].prods_id)
				{
					error *= 0;
					$scope.errors.push({'text': ('This slug is already in database'), 'type': 'danger'});
				}
			}

			if (error)
			{
				$http.post('/api/prods/save', $scope.prod).then(function(response) {
					if (response.data.data)
					{
						$uibModalInstance.close(response.data.message);
					}
				});
			}
		};

		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};
	}
})();