(function(){
	panelApp.controller('signinCtrl', ['$scope', '$http', signinCtrl]);
	
	function signinCtrl($scope, $http){
		$scope.signin = function() {
			
			var post_mas = {
				users_email: $scope.email,
				users_password: $scope.password
			};
			
			$http.post("/api/signin", post_mas).then(function(response) {
				console.log(response.data);
			});
		}
	}
})();