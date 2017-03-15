<div ng-controller="catsCtrl">
	<h1>Categories</h1>
	<div class="form-group">
		<button type="button" class="btn btn-primary" ng-click="add()">Create Category</button>
	</div>
	
	<div class="table-responsive">
		<table class="table table-striped table-hover" ng-show="list.length">
			<thead>
				<tr>
					<th class="td-id">ID</th>
					<th class="td-type">Slug</th>
					<th>Email</th>
					<th class="td-icon">Edit</th>
					<th class="td-icon">Remove</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="user in list">
					<td class="td-id">@{{cat.id}}</td>
					<td class="td-type">@{{cat.slug}}</td>
					<td>@{{cat.name}}</td>
					<td class="td-icon"><button type="button" class="btn btn-link" ng-click="add(cat.id)"><i class="fa fa-pencil-square-o text-success"></i></button></td>
					<td class="td-icon"><button type="button" class="btn btn-link" ng-click="remove(cat.id)"><i class="fa fa-trash-o text-danger"></i></button></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<script type="text/ng-template" id="ModalCatsContent.html">
	<div class="modal-header">
		<h3 ng-show=" ! cat.id">Create Category</h3>
		<h3 ng-show="cat.id">Edit Category</h3>
	</div>

	<form name="form" class="modal-body coverletter-modal" novalidate="novalidate">
		<div ng-show="errors.length">
			<div class="alert alert-@{{msg.type}}" ng-repeat="msg in errors" ng-init="showme = true" ng-show="showme" role="alert">@{{msg.text}}
				 <button type="button" class="close" data-dismiss="alert" aria-label="Close" ng-click="showme = false"><span aria-hidden="true">&times;</span></button>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label>Name</label>
					<input type="text" class="form-control" name="name" ng-model="cat.name" ng-change="slug()" required="required" />
				</div>
			</div>

			<div class="col-sm-12">
				<div class="form-group">
					<label>Slug</label>
					<input type="text" class="form-control" name="slug" ng-model="cat.slug" required="required" />
				</div>
			</div>
		</div>
	</form>

	<div class="modal-footer">
		<button class="btn btn-primary" type="button" ng-click="save()">OK</button>
		<button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
	</div>
</script>