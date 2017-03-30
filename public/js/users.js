(function() {
	angular.module('panelApp').controller('usersCtrl', ['$scope', '$rootScope', '$http', '$window', '$uibModal', 'validate', usersCtrl]);
	function usersCtrl($scope, $rootScope, $http, $window, $uibModal, validate) {
		$rootScope.errors = [];
		$scope.types = [];
		$scope.typesList = [];
		$http.get('/api/users/types').then(function(response) {
			$scope.types = response.data.data;
			for (var t in $scope.types)
			{
				if ($rootScope.user.type.id < $scope.types[t].id || $rootScope.user.type.id == 1)
				{
					$scope.typesList.push($scope.types[t]);
				}
			}
			
		});
		
		$scope.add = function(id) {
			id = id || false;

			var user = {};
			if (id)
			{
				for (var k in $scope.list)
				{
					if ($scope.list[k].id == id)
					{
						user = $scope.list[k];
					}
				}
			}

			var modalInstance;
            modalInstance = $uibModal.open({
                templateUrl: "ModalUsersContent.html",
                controller: 'ModalUsersCtrl',
				resolve: {
					items: {'types': $scope.typesList, 'user': user, 'list': $scope.list}
				}
			});	
			
			modalInstance.result.then(function (result) {
				$rootScope.errors = [result];
				if (id == $rootScope.user.id)
				{
					$http.get('/api/users/info').then(function(response) {
						$rootScope.user = response.data.data;
					});
				}
				$scope.get_list();
			}, function() {

			}); 
		};

		$scope.remove = function(id) {
			if (confirm('Do you realy want to remove this item?'))
			{
				$http.delete('/api/users/delete/' + id).then(function(response) {
					$rootScope.errors = [response.data.message];
					if (id == $rootScope.user.id)
					{
						$window.location.reload();
					}
					else
					{
						$scope.get_list();
					}
				});
			}
		};
		
		$scope.list = [];
		$scope.get_list = function() {
			$http.get('/api/users/list').then(function(response) {
				$scope.list = response.data.data;
			});
		};
		$scope.get_list();
	}
})();

(function() {
	angular.module('panelApp').controller('ModalUsersCtrl', ['$scope', '$rootScope', '$http', '$uibModalInstance', 'validate', 'items', ModalUsersCtrl]);
	function ModalUsersCtrl($scope, $rootScope, $http, $uibModalInstance, validate, items) {
		$scope.errors = [];
		$scope.types = items.types;
		$scope.user = {'id': 0,
					   'email': '',
					   'password': '',
					   'cats': [],
					   'type': items.types[0]};
		
		if (items.user && items.user.id)
		{
			for (var k in items.user)
			{
				$scope.user[k] = items.user[k];
			}
		}
		$http.get('/api/cats/list').then(function(response) {
			$scope.cats = response.data.data;
		});

		$scope.save = function () {
			$scope.errors = [];
			var error = 1;
			error *= validate.check($scope, $scope.form.email, 'Email');
			if ( ! $scope.user.id)
			{
				error *= validate.check($scope, $scope.form.password, 'Password');
			}

			for (var k in items.list)
			{
				if ($scope.user.email.toLowerCase() == items.list[k].email.toLowerCase() && $scope.user.id != items.list[k].id)
				{
					error *= 0;
					$scope.errors.push({'text': ('The user with this emails is already in database'), 'type': 'danger'});
				}
			}

			if (error)
			{
				$http.post('/api/users/save', $scope.user).then(function(response) {
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