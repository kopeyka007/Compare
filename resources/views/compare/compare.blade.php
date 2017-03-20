<div ng-controller="compareCtrl">
	<div class="container">
		<div class="table-responsive">
			<table class="table table-striped compare-table">
				<thead>
					<tr>
						<th></th>
						<th ng-repeat="i in [0, 1, 2, 3]">
							<h4 ng-if="compareList[i]">@{{compareList[i].brands_id.brands_name}} @{{compareList[i].prods_name}}</h4>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<h3>Show:</h3>
							<div>
								<label class="btn btn-success btn-block">
									<input type="checkbox" />
									<span>All Features</span>
								</label>
							</div>
							<div>
								<label class="btn btn-success btn-block">
									<input type="checkbox" />
									<span>Differences</span>
								</label>
							</div>
						</td>
						<td class="td-header" ng-repeat="i in [0, 1, 2, 3]">
							<div class="compare-head" ng-if="compareList[i]" ng-init="prod = compareList[i]">
								<div class="compare-img text-center">
									<img src="@{{prod.prods_foto}}" alt="#" />
								</div>
								<div class="compare-price text-danger">
									$@{{prod.prods_price}}
								</div>
								<a href="@{{closeLink(prod.prods_id)}}" class="compare-close">
									<i class="fa fa-times-circle" aria-hidden="true"></i>
								</a>
								<div class="wrap-add-btn">
									<button class="btn btn-info add-btn">Add Another Products</button>
								</div>
							</div>
							<div ng-if="! compareList[i]" class="compare-head inactive">
								<div class="compare-img text-center">
									<img src="http://comparewear.com/images/products/apple-watch.jpg" alt="#" />
								</div>
								<div class="compare-price text-danger">
									$9.999
								</div>
								<div class="compare-close">
									<i class="fa fa-times-circle" aria-hidden="true" ng-click=""></i>
								</div>
								<div class="wrap-add-btn">
									<button class="btn btn-info add-btn">Add Another Products</button>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td><h3>Overview</h3></td>
						<td colspan="4"><h3>Advantages (Factors To Decide Which Device You Should Buy)</h3></td>
					</tr>
					<tr>
						<td>Features Present In Only One Device(Unique Features)</td>
						<td></td>
						<td>
							<div class="features-block">
								<div class="features-head">
									<img src="#" alt="#" />
									<span>Light Weight</span>
								</div>
								<div class="features-content">
									<div class="oponents">
										<span>Xiaomi Redmi Note 4</span>
										<span>165 grams</span>
									</div>
									<div class="oponents">
										<span>Xiaomi Redmi Note 4</span>
										<span>165 grams</span>
									</div>
									<div class="oponents">
										<span>Xiaomi Redmi Note 4</span>
										<span>165 grams</span>
									</div>
									<p>Around 12% lighter than Xiaomi Redmi Note 4. Light weight devices are easier to hold without tiring your arms.</p>
								</div>
							</div>
						</td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
			</table>
			
			<div class="groups-box" ng-repeat="group in filterList">
				<h3>@{{group.groups_name}}</h3>
				<table class="table">
					<tbody>
						<tr ng-repeat="filter in group.groups_filters">
							<td class="td-name">@{{filter.filters_name}}</td>
							<td class="td-header" ng-repeat="i in [0, 1, 2, 3]">
								<div class="compare-head" ng-if="compareList[i]" ng-init="prod = compareList[i]">
									<div class="compare-price text-danger">
										@{{prod.filters[filter.filters_id].filters_value}}
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>