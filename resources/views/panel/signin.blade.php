<div class="relative" ng-controller="signinCtrl">
	<div class="signin-row">
		<h3 class="text-center">Admin Panel</h3>

		<div class="panel panel-default">
			<div class="panel-body">
				<form name="form" novalidate="novalidate">
					<div class="form-group">
						<label>Email address</label>
						<input type="email" class="form-control" name="email" ng-model="email" required="required" />
					</div>

					<div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control" name="password" ng-model="password" required="required" />
					</div>
					
					<div class="text-center">
						<button type="submit" class="btn btn-success text-center" ng-click="signin()">Log in</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>