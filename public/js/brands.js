(function() {
	angular.module('panelApp').controller('brandsCtrl', ['$scope', '$rootScope', '$http', '$window', '$uibModal', 'validate', brandsCtrl]);
	function brandsCtrl($scope, $rootScope, $http, $window, $uibModal, validate) {
		$scope.add = function(id) {
			id = id || false;

			var brand = {};
			if (id)
			{
				for (var k in $scope.list)
				{
					if ($scope.list[k].brands_id == id)
					{
						brand = $scope.list[k];
					}
				}
			}

			var modalInstance;
            modalInstance = $uibModal.open({
                templateUrl: "ModalBrandsContent.html",
                controller: 'ModalBrandsCtrl',
				resolve: {
					items: {'brand': brand, 'list': $scope.list}
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
				$http.delete('/api/brands/delete/' + id).then(function(response) {
					$rootScope.errors = [response.data.message];
					$scope.get_list();
				});
			}
		};
		
		$scope.list = [];
		$scope.get_list = function() {
			$http.get('/api/brands/list').then(function(response) {
				$scope.list = response.data.data;
			});
		};
		$scope.get_list();
	}
})();

(function() {
	angular.module('panelApp').controller('ModalBrandsCtrl', ['$scope', '$rootScope', '$http', '$uibModalInstance', 'validate', 'items', ModalBrandsCtrl]);
	function ModalBrandsCtrl($scope, $rootScope, $http, $uibModalInstance, validate, items) {
		$scope.errors = [];
		$scope.brand = {'brands_id': 0,
					  	'brands_name': ''};
		
		if (items.brand && items.brand.brands_id)
		{
			for (var k in items.brand)
			{
				$scope.brand[k] = items.brand[k];
			}
		}
													
		$scope.save = function () {
			$scope.errors = [];
			var error = 1;
			error *= validate.check($scope, $scope.form.name, 'Name');

			if (error)
			{
				$http.post('/api/brands/save', $scope.brand).then(function(response) {
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