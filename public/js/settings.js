(function() {
	angular.module('panelApp').controller('settingsCtrl', ['$scope', '$rootScope', '$http', '$window', '$uibModal', 'validate', settingsCtrl]);
	
	function settingsCtrl($scope, $rootScope, $http, $window, $uibModal, validate) {
		$scope.settingList = [];
		$rootScope.errors = [];
		$http.get('/api/settings/list').then(function(response) {
			$scope.settingList = response.data.data;
		});
		
		$scope.save = function () {
			$http.post('/api/settings/save', $scope.settingList).then(function(response) {
				$rootScope.errors = [response.data.message];
			});
		};
	}
	
})();