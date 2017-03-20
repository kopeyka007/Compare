(function() {
	angular.module('panelApp').controller('filtersCtrl', ['$scope', '$rootScope', '$http', '$window', '$uibModal', 'validate', filtersCtrl]);
	function filtersCtrl($scope, $rootScope, $http, $window, $uibModal, validate) {
		$scope.cats = [];
		$http.get('/api/cats/list').then(function(response) {
			$scope.cats = response.data.data;
		});
		
		$scope.groups = [];
		$http.get('/api/filters/list_groups').then(function(response) {
			$scope.groups = response.data.data;
			console.log($scope.groups);
		});
		

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
					items: {'cats': $scope.cats, 'groups': $scope.groups, 'filter': filter, 'list': $scope.list}
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
	angular.module('panelApp').controller('ModalFiltersCtrl', ['$scope', '$rootScope', '$http', '$uibModalInstance', '$timeout', 'validate', 'items', ModalFiltersCtrl]);
	function ModalFiltersCtrl($scope, $rootScope, $http, $uibModalInstance, $timeout, validate, items) {
		$scope.errors = [];
		$scope.cats = [{'cats_id': 0, 'cats_name': 'Choose Category'}].concat(items.cats);
		$scope.groups = [{'groups_id': 0, 'groups_name': 'New Group'}].concat(items.groups);
		$scope.filter = {'filters_id': 0,
						  'cats_id': {'cats_id': 0, 'cats_name': 'Choose Category'},
						  'groups_id': {'groups_id': 0, 'groups_name': 'New Group'},
						  'groups_name': '',
					  	  'filters_name': '',
					  	  'filters_type': 'check',
					  	  'filters_filter': 0
						  };
		
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
			error *= validate.check($scope, $scope.form.filters_name, 'Name');
			error *= validate.check($scope, $scope.form.cats_id, 'Category');
			error *= validate.check($scope, $scope.form.groups_name, 'Group Name');

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