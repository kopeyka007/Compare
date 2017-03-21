(function() {
	angular.module('panelApp').controller('dashboardCtrl', ['$scope', '$http', '$window', dashboardCtrl]);
	function dashboardCtrl($scope, $http, $window) {
		
		$http.get('/api/history/get').then(function(response){
			console.log(response.data.data);
		});
	}
})();