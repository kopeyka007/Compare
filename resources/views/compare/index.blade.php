<div ng-controller="indexCtrl">
	<div class="container">
		<div class="row title-line">
			<div class="col-md-9 col-sm-6 col-xs-12">
				<h2>@{{products_list.cats.cats_name}}</h2>
			</div>

			<div class="col-md-3 col-sm-6 col-xs-12">
				<select class="form-control pull-right" ng-model="sort[products_list.cats.cats_id]" ng-init="sort[products_list.cats.cats_id] = 'asc'">
					<option value="asc">Low to high price</option>
					<option value="desc">High to low price</option>
				</select>
			</div>
		</div>

		<div class="row">
			<div class="col-md-3">
				<div class="filter-section">
					<div class="filters-box" ng-repeat="filter in products_list.filters">
						<h4>@{{filter.filters_name}}</h4>
						<select class="form-control" ng-change="changeFilter(filter.filters_id)" ng-model="filters_model[filter.filters_id]">
							<option value="">Select a value...</option>
							<option value="@{{option}}" ng-repeat="option in filter.filters_values">@{{option}}</option>
						</select>
					</div>
				</div>
			</div>

			<div class="col-md-9">
				<div class="content-section" ng-if="(products_list.cats.prods | filter:filterProds).length" ng-init="selectedCount[products_list.cats.cats_id] = 0; selectedProds[products_list.cats.cats_id] = {}">
					<div class="wrap-categories">	
						<div class="row">
							<div ng-repeat="prod in products_list.cats.prods | filter:filterProds | orderBy: 'prods_price':(sort[products_list.cats.cats_id] == 'desc')">	
								<div class="col-md-3 col-sm-6 col-xs-12">
									<div class="content-border" ng-class="{'selected': prod.selected == 1, 'limit': limitClass}" ng-mousedown="selectedCount[products_list.cats.cats_id] == selectedMax ? limitClass = 'limit' : ''" ng-mouseup="limitClass = ''" ng-click="chooseProd(prod, products_list.cats)" ng-init="prod.selected = 0; limitClass = ''">
										<div class="content-inner">
											<div class="content-img">
												<div class="content-img-check">
													<i class="fa fa-check-square fa-2x" aria-hidden="true"></i>
												</div>
												<span>&nbsp;<img src="@{{prod.prods_foto}}" alt="#" /></span>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="content-brand">
														@{{prod.brands_id.brands_name}}
													</div>
												</div>
												<div class="col-md-6">
													<div class="content-price pull-right">
														$@{{prod.prods_price}}
													</div>
												</div>
											</div>
											<div class="content-name text-center">
												<a href="@{{products_list.cats.cats_alias}}/@{{prod.prods_alias}}">@{{prod.prods_name}}</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="btn-compare">
							<a href="@{{compareAlias[products_list.cats.cats_id]}}" type="button" class="btn btn-info btn-block btn-lg" ng-click="goUp()">COMPARE <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>