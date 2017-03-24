<div ng-controller="compareCtrl">
	<div class="container">
		<div class="recompare">
			<a href="/" type="button" class="btn btn-info"><i class="fa fa-repeat fa-flip-horizontal" aria-hidden="true"></i> Compare Wearables</a>
			<i class="fa fa-chevron-right" aria-hidden="true"></i>
			<span>@{{nameAllProds()}}</span>
		</div>
	</div>
	
	<div class="fixed-wrap">
		<div scroll ng-class="{fixed: fixedClass}">
			<div class="container">
				<div class="table-responsive">
					<table class="table compare-table">
						<thead>
							<tr>
								<th class="filters-cell"></th>
								<th class="prods-cell" ng-repeat="i in [0, 1, 2, 3]">
									<span>@{{compareList[i].brands_id.brands_name}}</span>
									<span ng-if="compareList[i]">@{{compareList[i].prods_name}}</span>
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
										<a href="@{{productsLink(prod)}}" class="compare-link">
											<img src="@{{prod.prods_foto}}" alt="#" />
											<span class="compare-price text-danger">
												@{{prod.prods_price_cur}}
											</span>
										</a>
										<a href="@{{closeLink(prod.prods_id)}}" class="compare-close">
											<i class="fa fa-times-circle" aria-hidden="true"></i>
										</a>
									</div>

									<div ng-if="! compareList[i]" class="compare-head inactive">
										<div class="compare-link">
											<img src="@{{compareList.cats_photo}}" alt="" />

											<span class="compare-price text-danger">
												$9.999
											</span>
										</div>

										<div class="wrap-add-btn">
											<button class="btn btn-info add-btn" ng-click="addToCompare(compareList[0].cats_id)">Add Another Product</button>
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
	
	<div class="container">
		<div class="table-responsive">
			<table class="table">
				<tbody>
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
											Around <b class="text-success">@{{percents(prod, feature.features_id)}} @{{feature.features_around}}</b> than @{{closestProd}}. @{{feature.features_desc}}
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr>
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
									<span ng-show="filter.filters_type == 'check' && prod.filters[filter.filters_id].filters_value == 'Yes'"><i class="fa fa-check-circle text-success"></i> @{{ prod.filters[filter.filters_id].filters_value }}</span>
									<span ng-show="filter.filters_type == 'check' && prod.filters[filter.filters_id].filters_value == 'No'"><i class="fa fa-times-circle text-danger"></i> @{{ prod.filters[filter.filters_id].filters_value }}&nbsp;</span>
									<span ng-show="filter.filters_type != 'check'">@{{prod.filters[filter.filters_id].filters_value}} @{{prod.filters[filter.filters_id].filters_units}}</span>
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
								<div class="btn-amazon" ng-if="compareList[i].prods_amazon">
									<a href="@{{compareList[i].prods_amazon}}" target="_blank" type="button" class="btn btn-warning" ng-click="statAmazon(compareList[i])">Buy on Amazon</a>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script type="text/ng-template" id="ModalCompareContent.html">
	<div class="modal-header">
		<h3>Add Product to Compare</h3>
	</div>

	<div class="modal-body">
		<div class="row">
			<div class="col-sm-6 col-xs-12" ng-repeat="prod in prods">
				<div class="form-group">
					<a href="@{{compareLink(prod.prods_full_alias)}}" ng-click="cancel()">@{{prod.brands_id.brands_name}} @{{prod.prods_name}}</a>
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button class="btn btn-default" type="button" ng-click="cancel()">Close</button>
	</div>
</script>