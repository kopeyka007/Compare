(function() {
	angular.module('panelApp').controller('currencyCtrl', ['$scope', '$rootScope', '$http', '$window', '$uibModal', 'validate', currencyCtrl]);
	function currencyCtrl($scope, $rootScope, $http, $window, $uibModal, validate) {
		$scope.currList = [];
		$scope.get_list = function() {
			$http.get('/api/').then(function(response) {
				$scope.currList = response.data.data;
			});
		};
		$scope.get_list();
		
		$scope.add = function(id) {
			id = id || false;

			var currency = {};
			if (id)
			{
				for (var k in $scope.currList)
				{
					if ($scope.currList[k].id == id)
					{
						currency = $scope.currList[k];
					}
				}
			}

			var modalInstance;
            modalInstance = $uibModal.open({
                templateUrl: "ModalCurrContent.html",
                controller: 'ModalCurrCtrl',
				resolve: {
					items: {'list': $scope.currList}
				}
			});	
			
			modalInstance.result.then(function (result) {
				$rootScope.errors = [result];
				$scope.get_list();
			}, function() {

			});
			
			$scope.remove = function(id) {
			if (confirm('Do you realy want to remove this item?'))
			{
				$http.delete('/api' + id).then(function(response) {
					$rootScope.errors = [response.data.message];
					$scope.get_list();
				});
			}
		};
		};
	}
})();

(function() {
	angular.module('panelApp').controller('ModalCurrCtrl', ['$scope', '$rootScope', '$http', '$uibModalInstance', 'validate', 'items', ModalCurrCtrl]);
	function ModalCurrCtrl($scope, $rootScope, $http, $uibModalInstance, validate, items) {
		$scope.errors = [];
		$scope.currencies = {'id': 0,
							 'currencies_name': '',
							 'currencies_symbol': ''};
		
		if (items.user && items.user.id)
		{
			for (var k in items.user)
			{
				$scope.user[k] = items.user[k];
			}
		}
													
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