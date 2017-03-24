(function() {
	angular.module('panelApp').controller('currencyCtrl', ['$scope', '$rootScope', '$http', '$window', '$uibModal', 'validate', currencyCtrl]);
	function currencyCtrl($scope, $rootScope, $http, $window, $uibModal, validate) {
		$scope.currList = [];
		$scope.get_list = function() {
			$http.get('/api/currencies/list').then(function(response) {
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
					items: {'currency': currency, 'list': $scope.currList}
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
		$scope.currency = {'id': 0,
							 'currencies_name': '',
							 'currencies_symbol': ''};
		
		if (items.currency && items.currency.id)
		{
			for (var k in items.currency)
			{
				$scope.currency[k] = items.currency[k];
			}
		}
													
		$scope.save = function () {
			$scope.errors = [];
			var error = 1;
			
			if (error)
			{
				$http.post('/api/', $scope.user).then(function(response) {
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