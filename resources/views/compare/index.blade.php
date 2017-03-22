<div ng-controller="indexCtrl">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="filter-section">
					<div class="title-line">
						<h2>Filter</h2>
					</div>
					
					<div class="filters-box">
						<h4>Category</h4>
						<select class="form-control" ng-model="cats_model">
							<option value="">All Categories</option>
							<option value="@{{cat.cats_id}}" ng-repeat="cat in products">@{{cat.cats_name}}</option>
						</select>
					</div>

					<div class="filters-box" ng-repeat="filter in filters">
						<h4>@{{filter.filters_name}}</h4>
						<select class="form-control" ng-change="changeFilter(filter.filters_id)" ng-model="filters_model[filter.filters_id]">
							<option value="">Select a value...</option>
							<option value="@{{option}}" ng-repeat="option in filter.filter_values">@{{option}}</option>
						</select>
					</div>
				</div>
			</div>

			<div class="col-md-9">
				<div class="content-section" ng-repeat="cat in products | filter:{'cats_id': cats_model}" ng-if="(cat.prods | filter:filterProds).length" ng-init="selectedCount[cat.cats_id] = 0; selectedProds[cat.cats_id] = {}">
					<div class="wrap-categories">	
						<div class="categories">
							<div class="row title-line">
								<div class="col-md-9 col-sm-6 col-xs-12">
									<h2>@{{cat.cats_name}}</h2>
								</div>

								<div class="col-md-3 col-sm-6 col-xs-12">
									<select class="form-control pull-right" ng-model="sort[cat.cats_id]" ng-init="sort[cat.cats_id] = 'asc'">
										<option value="asc">Low to high price</option>
										<option value="desc">High to low price</option>
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div ng-repeat="prod in cat.prods | filter:filterProds | orderBy: 'prods_price':(sort[cat.cats_id] == 'desc')">
								<div class="col-md-3 col-sm-6 col-xs-12">
									<div class="content-border" ng-class="{'selected': prod.selected == 1, 'limit': limitClass}" ng-mousedown="selectedCount[cat.cats_id] == selectedMax ? limitClass = 'limit' : ''" ng-mouseup="limitClass = ''" ng-click="chooseProd(prod, cat)" ng-init="prod.selected = 0; limitClass = ''">
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
												<a href="@{{cat.cats_alias}}/@{{prod.prods_alias}}">@{{prod.prods_name}}</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="btn-compare">
							<a href="@{{compareAlias[cat.cats_id]}}" type="button" class="btn btn-info btn-block btn-lg" ng-click="goUp()">COMPARE <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
						</div>
					</div>

					<div class="cats-hr">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>