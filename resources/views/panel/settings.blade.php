<div ng-controller="settingsCtrl">
	<h1>Settings</h1>
	
	<form>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label>S3 Bucket</label>
					<input type="text" class="form-control" required="required" ng-model="settingList.s3_bucket" />
					<span>@{{settingList.s3_bucket}}</span>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label>S3 Key</label>
					<input type="text" class="form-control" required="required" ng-model="settingList.s3_key" />
					<span>@{{settingList.s3_key}}</span>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label>S3 Region</label>
					<input type="text" class="form-control" required="required" ng-model="settingList.s3_region" />
					<span>@{{settingList.s3_region}}</span>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label>S3 Secret</label>
					<input type="text" class="form-control" required="required" ng-model="settingList.s3_secret" />
					<span>@{{settingList.s3_secret}}</span>
				</div>
			</div>
			<div class="col-sm-6">
				<button class="btn btn-primary" type="button" ng-click="save()">Save</button>
			</div>
		</div>
	</form>
</div>