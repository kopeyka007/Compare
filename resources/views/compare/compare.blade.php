<div ng-controller="compareCtrl">
	<div class="container">
		<div class="recompare">
			<a href="/" type="button" class="btn btn-info"><i class="fa fa-repeat fa-flip-horizontal" aria-hidden="true"></i> Compare Wearables</a>
			<i class="fa fa-chevron-right" aria-hidden="true"></i>
			<span>@{{}}</span>
		</div>
		<div class="table-responsive">
			<table class="table compare-table">
				<thead>
					<tr>
						<th class="filters-cell"></th>
						<th class="prods-cell" ng-repeat="i in [0, 1, 2, 3]">
							<h4 ng-if="compareList[i]">@{{compareList[i].prods_name}}</h4>
							<p>@{{compareList[i].brands_id.brands_name}}</p>
						</th>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td class="filters-cell">
							<button type="button" class="btn btn-success btn-block" ng-class="{'active': mode == 'all'}" ng-click="mode = 'all'">
								All Features
							</button>

							<button type="button" class="btn btn-success btn-block" ng-class="{'active': mode == 'diff'}" ng-click="mode = 'diff'">
								Differences
							</button>
						</td>

						<td class="prods-cell" ng-repeat="i in [0, 1, 2, 3]">
							<div class="compare-head" ng-if="compareList[i]" ng-init="prod = compareList[i]">
								<a href="/@{{ prod.cats_id }}/" class="compare-link">
									<img src="@{{prod.prods_foto}}" alt="#" />

									<span class="compare-price text-danger">
										$@{{prod.prods_price}}
									</span>
								</a>

								<a href="@{{closeLink(prod.prods_id)}}" class="compare-close">
									<i class="fa fa-times-circle" aria-hidden="true"></i>
								</a>
							</div>

							<div ng-if="! compareList[i]" class="compare-head inactive">
								<div class="compare-link">
									<img src="http://comparewear.com/images/products/apple-watch.jpg" alt="#" />

									<span class="compare-price text-danger">
										$9.999
									</span>
								</div>

								<div class="wrap-add-btn">
									<button class="btn btn-info add-btn">Add Another Product</button>
								</div>
							</div>
						</td>
					</tr>

					<tr>
						<td class="filters-cell">
							Features Present In Only One Device (Unique Features)
						</td>

						<td class="prods-cell" ng-repeat="i in [0, 1, 2, 3]">
							<div class="features-cell" ng-if="compareList[i]" ng-init="prod = compareList[i]">
								<div class="features-box" ng-repeat="feature in prod.features" ng-show="checkFeatures(prod, feature.features_id)">
									<div class="features-head">
										<img src="@{{feature.features_icon}}" ng-show="feature.features_icon != ''" alt="" />
										<span>@{{feature.features_name}}</span>
									</div>

									<div class="features-content">
										<div class="features-prods" ng-repeat="p in compareList" ng-class="{'active': p.prods_id == prod.prods_id}">
											<div class="row">
												<div class="col-xs-7">
													@{{p.prods_name}}
												</div>

												<div class="col-xs-5 text-right">
													@{{p.features[feature.features_id].features_value}} @{{p.features[feature.features_id].features_units}}
												</div>
											</div>
										</div>
										
										<div class="features-desc">
											@{{feature.features_around}} @{{closestProd}}. @{{feature.features_desc}}
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr-->
				</tbody>
			</table>
			
			<div class="groups-box" ng-repeat="group in filterList">
				<h3>@{{group.groups_name}}</h3>
				<table class="table table-striped">
					<tbody>
						<tr ng-repeat="filter in group.groups_filters | filter:checkDifferences">
							<td class="filters-cell">@{{filter.filters_name}}</td>
							<td class="prods-cell" ng-repeat="i in [0, 1, 2, 3]">
								<div ng-if="compareList[i]" ng-init="prod = compareList[i]">
									<i class="fa fa-check-circle text-success" ng-show="filter.filters_type == 'check' && prod.filters[filter.filters_id].filters_value"></i>
									<i class="fa fa-times-circle text-danger" ng-show="filter.filters_type == 'check' && ! prod.filters[filter.filters_id].filters_value"></i>
									<span ng-show="filter.filters_type != 'check'">@{{prod.filters[filter.filters_id].filters_value}}</span>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="amazon-links">
				<h3>Amazon Links</h3>
				<table class="table table-striped">
					<tbody>
						<tr>
							<td></td>
							<td class="prods-cell" ng-repeat="i in [0, 1, 2, 3]">
								<div class="btn-amazon">
									<a class="btn btn-warning" href="@{{compareList[i].prods_amazon}}">Buy on Amazon</a>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>