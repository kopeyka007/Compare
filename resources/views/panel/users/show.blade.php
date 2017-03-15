<div ng-controller="usersCtrl">
	<h1>Show</h1>
	<div class="form-group">
		<button type="button" class="btn btn-primary" ng-click="add_users()">Create User</button>
	</div>
	
	<table class="table table-striped table-hover" ng-show="list.length">
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
				<td><button type="button" class="btn btn-link text-success" ng-click="add_users(user.id)"><i class="fa fa-pencil-square-o"></i></button></td>
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
							<input type="email" class="form-control" name="email" ng-model="user.email" required="required" />
						</div>
					</div>
					<div class="col-sm-12" ng-show="user.id == 0">
						<div class="form-group">
							<label>Password</label>
							<input type="password" class="form-control" name="password" ng-model="user.password" required="required" />
						</div>
					</div>
					<div class="col-sm-12">
						<div class="form-group">
							<label>Type of user</label>
							<select class="form-control" ng-model="user.type" ng-options="type.name for type in types track by type.id">
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
		
	</div>
</div>