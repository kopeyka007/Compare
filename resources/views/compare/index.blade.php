<div ng-controller="compareCtrl">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="filter-section">
					Filter
				</div>
			</div>
			<div class="col-md-8">
				<div class="content-section" ng-repeat="item in products">
					<div class="categories">
						<h2>@{{item.cats_name}}</h2>
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="content-border" ng-class="{'selected': selected}" ng-click="chooseProd()">
								<div class="content-inner">
									<div class="content-img">
										<div class="content-img-check">
											<i class="fa fa-check-square fa-2x" aria-hidden="true"></i>
										</div>
										<img src="http://comparewear.com/images/products/asus-zenwatch-3.jpg" alt="#" />
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="content-brand">
												@{{item.prods.brands_id.brands_name}}
											</div>
										</div>
										<div class="col-md-6">
											<div class="content-price pull-right">
												$@{{item.prods.prods_price}}
											</div>
										</div>
									</div>
									<div class="content-name text-center">
										<a href="/@{{item.prods.prods_alias}}">@{{item.prods.prods_name}}</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="content-border">
								<div class="content-inner">
									<div class="content-img">
										<div class="content-img-check">
											<i class="fa fa-check-square fa-2x" aria-hidden="true"></i>
										</div>
										<img src="http://comparewear.com/images/products/asus-zenwatch-3.jpg" alt="#" />
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="content-brand">
												Apple
											</div>
										</div>
										<div class="col-md-6">
											<div class="content-price pull-right">
												$ 300
											</div>
										</div>
									</div>
									<div class="content-name text-center">
										<a href="#">Watch series 2</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="content-border">
								<div class="content-inner">
									<div class="content-img">
										<div class="content-img-check">
											<i class="fa fa-check-square fa-2x" aria-hidden="true"></i>
										</div>
										<img src="http://comparewear.com/images/products/asus-zenwatch-3.jpg" alt="#" />
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="content-brand">
												Apple
											</div>
										</div>
										<div class="col-md-6">
											<div class="content-price pull-right">
												$ 300
											</div>
										</div>
									</div>
									<div class="content-name text-center">
										<a href="#">Watch series 2</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="btn-compare">
					<button type="button" class="btn btn-info btn-block" ng-click="">COMPARE <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
				</div>
			</div>
		</div>
	</div>
</div>