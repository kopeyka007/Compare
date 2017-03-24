<div ng-controller="currencyCtrl">
	<h1>Currencies</h1>
	<div class="form-group">
		<button type="button" class="btn btn-primary" ng-click="add()">Create Currencies</button>
	</div>
	
	<div class="table-responsive">
		<table class="table table-striped table-hover" ng-show="currList.length">
			<thead>
				<tr>
					<th class="td-id">ID</th>
					<th class="td-type">Name</th>
					<th class="td-icon">Symbol</th>
					<th class="td-icon">Edit</th>
					<th class="td-icon">Remove</th>
				</tr>
			</thead>
			
			<tbody>
				<tr ng-repeat="currency in currList">
					<td>@{{currency.currencies_id}}</td>
					<td>@{{currency.currencies_name}}</td>
					<td>@{{currency.currencies_symbol}}</td>
					<td class="td-icon"><button type="button" class="btn btn-link" ng-click="add(currency.id)"><i class="fa fa-pencil-square-o text-success"></i></button></td>
					<td class="td-icon"><button type="button" class="btn btn-link" ng-click="remove(currency.id)"><i class="fa fa-trash-o text-danger"></i></button></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<script type="text/ng-template" id="ModalCurrContent.html">
	<div class="modal-header">
		<h3 ng-show=" ! currency.id">Create Carrency</h3>
		<h3 ng-show="currency.id">Edit Currency</h3>
	</div>

	<form name="form" class="modal-body coverletter-modal" novalidate="novalidate">
		<div ng-show="errors.length">
			<div class="alert alert-@{{msg.type}}" ng-repeat="msg in errors" role="alert" ng-init="showme = true" ng-show="showme">@{{msg.text}}
				 <button type="button" class="close" data-dismiss="alert" aria-label="Close" ng-click="showme = false"><span aria-hidden="true">&times;</span></button>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label>Name</label>
					<input type="text" class="form-control" ng-model="currency.currencies_name" required="required" />
				</div>
			</div>
			
			<div class="col-sm-12">
				<div class="form-group">
					<label>Symbol</label>
					<input type="text" class="form-control" ng-model="currency.currencies_symbol" required="required" />
				</div>
			</div>
		</div>
	</form>

	<div class="modal-footer">
		<button class="btn btn-primary" type="button" ng-click="save()">Save</button>
		<button class="btn btn-default" type="button" ng-click="cancel()">Cancel</button>
	</div>
</script>