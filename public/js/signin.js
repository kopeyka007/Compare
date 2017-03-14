(function(){
	angular.module('panelApp').controller('signinCtrl', ['$scope', '$http', 'validate', signinCtrl]);
	
	function signinCtrl($scope, $http, validate){
		$scope.signin = function() {
			console.log($scope.errors);
			var error = 1;
			error *= validate.check($scope, $scope.form.email, 'Email');
			error *= validate.check($scope, $scope.form.password, 'Password');
			
			if (error) 
			{
				var post_mas = {
					users_email: $scope.email,
					users_password: $scope.password
				};
			
				$http.post("/api/signin", post_mas).then(function(response) {
					console.log(response.data);
				});
			}
		};
	}
})();