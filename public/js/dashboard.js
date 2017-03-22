(function() {
	angular.module('panelApp').controller('dashboardCtrl', ['$scope', '$http', '$window', dashboardCtrl]);
	function dashboardCtrl($scope, $http, $window) {
		$scope.statDashboard = [];
		$http.get('/api/history/get').then(function(response){
			$scope.statDashboard = response.data.data;
		});

		$scope.dayOfWeek = function(i) {
			var days = {'1': 'Monday',
						'2': 'Tuesday',
						'3': 'Wednesday',
						'4': 'Thursday',
						'5': 'Friday',
						'6': 'Saturday',
						'7': 'Sunday'};
			return days[i];
		};
	}
})();