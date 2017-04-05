<div ng-controller="importCtrl">
	<h1>Import</h1>
	<div class="form-horizontal">
		<div class="form-group">
			<div class="col-md-2">
				<select class="form-control" required="required" ng-model="importData.cats_id" ng-options="cat.cats_name for cat in cats track by cat.cats_id">
				</select>
			</div>
			<a href="javascript:void(0);" type="button" class="btn btn-info btn-file">
				<span>Browse file...</span>
				<input type="file" accept=".csv" name="file" ng-model="import_file" ngf-select />
			</a>
			<button class="btn btn-primary" type="button" ng-click="save(import_file)">Save</button>
		</div>
	</div>
	<div>@{{import_file.name}}</div><br />
	<uib-progressbar max="max" value="progress"><span style="color:white; white-space:nowrap;"></span></uib-progressbar>
</div>