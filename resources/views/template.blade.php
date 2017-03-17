<html lang="en" ng-app="compareApp" ng-controller="mainCtrl">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Compare.da</title>
		<link href="/css/bootstrap.min.css" rel="stylesheet" />
		<link href="/css/font-awesome.min.css" rel="stylesheet" />
		<link href="/css/style.css" rel="stylesheet" />
	</head>
	
    <body>
		<section class="header">
			<div class="container">
				<h3>Compare</h3>
			</div>
		</section>
			
		<section class="content" ng-view>
		</section>
		
		<section class="footer">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-xs-12">
						<h4><i class="fa fa-home" aria-hidden="true"></i> Compare Wearables</h4>
						<p><a href="/">Home</a></p>
						<p><a href="/">About the developer</a></p>
						<div class="groups-footer" ng-repeat="cats in cats">
							<h4>@{{cat.cats_name}}</h4>
							<div ng-repeat="prod in cat.prods">
								<p ><a>@{{prod.brands_id.brands_name}}</a></p>
							</div>
						</div>
					</div>
					
					<div class="col-md-6col-xs-12">
					</div>
				</div>
			</div>
		</section>

		<script src="/js/libs/angular.min.js"></script>
		<script src="/js/libs/angular-route.min.js"></script>
		<script src="/js/compareapp.js"></script>
		<script src="/js/compare.js"></script>
		
    </body>
</html>
