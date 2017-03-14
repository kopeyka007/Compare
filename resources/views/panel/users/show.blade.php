<div ng-controller="usersCtrl">
	<h1>Show</h1>

	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Email</th>
				<th>Type</th>
				<th>Edit</th>
				<th>Remove</th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="user in list">
				<td>@{{user.id}}</td>
				<td>@{{user.email}}</td>
				<td>@{{user.role}}</td>
				<td></td>
				<td></td>
			</tr>
		</tbody>
	</table>

	<div class="modal-demo">
		<script type="text/ng-template" id="myModalContent.html">
			<div class="modal-header">
				<h3>Add User</h3>
			</div>
			<div class="modal-body  coverletter-modal">
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control" name="email" ng-model="email" required="required" />
						</div>
					</div>
					<div class="col-sm-12">
						<div class="form-group">
							<label>Password</label>
							<input type="password" class="form-control" name="password" ng-model="password" required="required" />
						</div>
					</div>
					<div class="col-sm-12">
						<div class="form-group">
							<label>Type of user</label>
							<select class="form-control" ng-model="user_type" ng-options="type as type.name for type in type_users track by type.id">
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" type="button" ng-click="ok()">OK</button>
				<button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
			</div>
		</script>
		<button type="button" class="btn btn-default" ng-click="add_users()">Open me!</button>
	</div>
</div>