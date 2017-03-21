(function() {
	angular.module('panelApp').controller('dashboardCtrl', ['$scope', '$http', '$window', dashboardCtrl]);
	function dashboardCtrl($scope, $http, $window) {
		$scope.statDashboard = [];
		$http.get('/api/history/get').then(function(response){
			$scope.statDashboard = response.data.data;
			console.log($scope.statDashboard);
		});
	}
})();