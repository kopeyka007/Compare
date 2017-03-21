(function() {
	angular.module('panelApp').controller('dashboardCtrl', ['$scope', '$http', '$window', dashboardCtrl]);
	function dashboardCtrl($scope, $http, $window) {
		
		$http.get('/api/history/get/amazon/last10day').then(function(response){
			console.log(response.data);
		});
		
		$http.get('/api/history/get/amazon/top10').then(function(response){
			console.log(response.data);
		});
	}
})();