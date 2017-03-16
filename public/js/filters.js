(function() {
	angular.module('panelApp').controller('filtersCtrl', ['$scope', '$rootScope', '$http', '$window', '$uibModal', 'validate', filtersCtrl]);
	function filtersCtrl($scope, $rootScope, $http, $window, $uibModal, validate) {
		$scope.add = function(id) {
			id = id || false;

			var filter = {};
			if (id)
			{
				for (var k in $scope.list)
				{
					if ($scope.list[k].filters_id == id)
					{
						filter = $scope.list[k];
					}
				}
			}

			var modalInstance;
            modalInstance = $uibModal.open({
                templateUrl: "ModalFiltersContent.html",
                controller: 'ModalFiltersCtrl',
				resolve: {
					items: {'filter': filter, 'list': $scope.list}
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
				$http.delete('/api/filters/delete/' + id).then(function(response) {
					$rootScope.errors = [response.data.message];
					$scope.get_list();
				});
			}
		};
		
		$scope.list = [];
		$scope.get_list = function() {
			$http.get('/api/filters/list').then(function(response) {
				$scope.list = response.data.data;
			});
		};
		$scope.get_list();
	}
})();

(function() {
	angular.module('panelApp').controller('ModalFiltersCtrl', ['$scope', '$rootScope', '$http', '$uibModalInstance', 'validate', 'items', ModalFiltersCtrl]);
	function ModalFiltersCtrl($scope, $rootScope, $http, $uibModalInstance, validate, items) {
		$scope.errors = [];
		$scope.filter = {'filters_id': 0,
					  	'filters_name': ''};
		
		if (items.filter && items.filter.filters_id)
		{
			for (var k in items.filter)
			{
				$scope.filter[k] = items.filter[k];
			}
		}
													
		$scope.save = function () {
			$scope.errors = [];
			var error = 1;
			error *= validate.check($scope, $scope.form.name, 'Name');

			if (error)
			{
				$http.post('/api/filters/save', $scope.filter).then(function(response) {
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