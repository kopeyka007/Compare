<div ng-controller="signinCtrl">
	<div class="signin-header">
		<a><img src="#" alt="#"></a>
	</div>

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="error-msg">
				<div class="alert alert-@{{msg.type}}" ng-repeat="msg in errors" role="alert">@{{msg.text}}</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-body">
					<form name="form" novalidate="novalidate">
						<div class="form-group">
							<label>Email address</label>
							<input type="email" class="form-control" placeholder="Email" name="email" ng-model="email" required="required" />
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" class="form-control" placeholder="Password" name="password" ng-model="password" required="required" />
						</div>
						<div class="form-group text-center">
							<button type="submit" class="btn btn-success text-center" ng-click="signin()">Log in</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>