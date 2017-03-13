<div ng-controller="signinCtrl">
	<div class="signin-header">
		<a><img src="#" alt="#"></a>
	</div>


	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="form-container">
					<form name="form">
						<div class="form-group">
							<label>Email address</label>
							<input type="email" class="form-control" placeholder="Email" name="email" ng-model="email" />
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" class="form-control" placeholder="Password" name="password" ng-model="password" />
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-success btn-block text-center" ng-click="signin()">Log in</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>