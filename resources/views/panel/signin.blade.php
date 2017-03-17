<div ng-controller="signinCtrl">
	<div class="row signin-row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default signin-body">
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
						
						<div class="form-group text-center">
							<button type="submit" class="btn btn-success text-center" ng-click="signin()">Log in</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>