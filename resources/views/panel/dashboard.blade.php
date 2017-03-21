<div ng-controller="dashboardCtrl">
	<div class="container">
		<h1>Dashboard</h1>
		<div class="row">
			<div class="col-md-6 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">Comparison count Timeline</div>
					<div class="panel-body">
						
					</div>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">Top 10 Most Compared products (Single)</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped">
								<tbody>
									<tr ng-repeat="(i, singleTop) in statDashboard.single_compare_top10">
										<td class="td-number">@{{i + 1}}.</td>
										<td>@{{singleTop.prods.brands_id.brands_name}} @{{singleTop.prods.prods_name}}</td>
										<td class="td-counter">@{{singleTop.prods_count}}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">Top 10 Most Compared products (Pair)</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped">
								<tbody>
									<tr ng-repeat="(i, singleTop) in statDashboard.single_compare_top10">
										<td class="td-number">@{{i + 1}}.</td>
										<td>@{{singleTop.prods.brands_id.brands_name}} @{{singleTop.prods.prods_name}}</td>
										<td class="td-counter">@{{singleTop.prods_count}}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">Amazon redirects timeline</div>
					<div class="panel-body">
						
					</div>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">Top 10 Products with Most Amazon Clicks</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped">
								<tbody>
									<tr ng-repeat="(i, singleTop) in statDashboard.single_compare_top10">
										<td class="td-number">@{{i + 1}}.</td>
										<td>@{{singleTop.prods.brands_id.brands_name}} @{{singleTop.prods.prods_name}}</td>
										<td class="td-counter">@{{singleTop.prods_count}}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">Total Products Count categorywise</div>
					<div class="panel-body">
						
					</div>
				</div>
			</div>
			<div class="col-md-6 col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">Day wise comparison</div>
					<div class="panel-body">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>