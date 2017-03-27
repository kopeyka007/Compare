<div ng-controller="usersCtrl">
	<h1>Users</h1>
	<div class="form-group">
		<button type="button" class="btn btn-primary" ng-click="add()">Create User</button>
	</div>
	
	<div class="table-responsive">
		<table class="table table-striped table-hover" ng-show="list.length">
			<thead>
				<tr>
					<th class="td-id">ID</th>
					<th class="td-type">Type</th>
					<th>Email</th>
					<th class="td-icon">Edit</th>
					<th class="td-icon">Remove</th>
				</tr>
			</thead>
			
			<tbody>
				<tr ng-repeat="user in list">
					<td class="td-id">@{{user.id}}</td>
					<td class="td-type">@{{user.type.name}}</td>
					<td>@{{user.email}}</td>
					<td class="td-icon"><button type="button" class="btn btn-link" ng-click="add(user.id)"><i class="fa fa-pencil-square-o text-success"></i></button></td>
					<td class="td-icon"><button type="button" class="btn btn-link" ng-click="remove(user.id)"><i class="fa fa-trash-o text-danger"></i></button></td>
				</tr>
			</tbody>
		</table>

		<div class="alert alert-info text-center" role="alert" ng-show=" ! list.length">
			There is no any data
		</div>
	</div>
</div>

<script type="text/ng-template" id="ModalUsersContent.html">
	<div class="modal-header">
		<h3 ng-show=" ! user.id">Create User</h3>
		<h3 ng-show="user.id">Edit User</h3>
	</div>

	<form name="form" class="modal-body coverletter-modal" novalidate='novalidate'>
		<div ng-show="errors.length">
			<div class="alert alert-@{{msg.type}}" ng-repeat="msg in errors" role="alert" ng-init="showme = true" ng-show="showme">@{{msg.text}}
				 <button type="button" class="close" data-dismiss="alert" aria-label="Close" ng-click="showme = false"><span aria-hidden="true">&times;</span></button>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label>Email</label>
					<input type="email" class="form-control" name="email" ng-model="user.email" required="required" />
				</div>
			</div>

			<div class="col-sm-12">
				<div class="form-group">
					<label>Password</label>
					<input type="password" class="form-control" name="password" ng-model="user.password" required="required" />
				</div>
			</div>
			
			<div class="col-sm-12">
				<div class="form-group">
					<label>Type of user</label>
					<select class="form-control" name="type" ng-model="user.type" ng-options="type.name for type in types track by type.id">
					</select>
				</div>
			</div>
			
			<div class="col-sm-12" ng-show="user.type.id == 2 || user.type.id == 3">
				<div class="user-cats-box" ng-repeat="cat in cats">
					<input type="checkbox" ng-model="user.cats[cat.cats_id]" />
					<label>@{{cat.cats_name}}</label>
				</div>
			</div>
		</div>
	</form>

	<div class="modal-footer">
		<button class="btn btn-primary" type="button" ng-click="save()">Save</button>
		<button class="btn btn-default" type="button" ng-click="cancel()">Cancel</button>
	</div>
</script>