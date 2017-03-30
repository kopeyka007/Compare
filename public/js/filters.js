(function() {
	angular.module('panelApp').controller('filtersCtrl', ['$scope', '$rootScope', '$http', '$window', '$uibModal', 'validate', filtersCtrl]);
	function filtersCtrl($scope, $rootScope, $http, $window, $uibModal, validate) {
		$rootScope.errors = [];
		$scope.cats = [];
		$http.get('/api/cats/list').then(function(response) {
			$scope.cats = response.data.data;
		});
		
		$scope.groups = [];
		$scope.get_groups = function() {
			$http.get('/api/filters/list_groups').then(function(response) {
				$scope.groups = response.data.data;
			});
		}
		$scope.get_groups();
		
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
				$scope.get_groups();
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
						  'filters_units': '',
					  	  'filters_filter': false};
		
		if (items.filter && items.filter.filters_id)
		{
			for (var k in items.filter)
			{
				if (k == 'cats_id')
				{
					if (items.filter[k][0])
					{
						$scope.filter[k] = items.filter[k][0];
					}
				}
				else
				{
					if (k == 'filters_filter')
					{
						$scope.filter[k] = items.filter[k] == 1 ? true : false;
					}
					else
					{
						$scope.filter[k] = items.filter[k];
					}
				}
			}
		}	
		
		$scope.changeGroup = function(){
			if ($scope.filter.groups_id.groups_name == 'New Group') 
			{
				$scope.filter.groups_name = '';
			}
			else
			{
				$scope.filter.groups_name = $scope.filter.groups_id.groups_name;
			}
		};
		$scope.changeGroup();
		
		$scope.save = function () {
			$scope.errors = [];
			var error = 1;
			error *= validate.check($scope, $scope.form.filters_name, 'Name');
			error *= validate.check($scope, $scope.form.cats_id, 'Category', 'cats_id');
			error *= validate.check($scope, $scope.form.groups_name, 'Group Name', 'groups_id');

			if (error)
			{
				$scope.filter.groups_id.groups_name = $scope.filter.groups_name;
				$http.post('/api/filters/save', $scope.filter).then(function(response) {
					if (response.data.data)
					{
						$scope.groups = [];
						$http.get('/api/filters/list_groups').then(function(response) {
							$scope.groups = response.data.data;
							items.groups.push($scope.groups);
						});
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