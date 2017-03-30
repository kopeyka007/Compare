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
	
    <body ng-class="loaderClass">
		<div class="loader">
			<i class="fa fa-refresh fa-spin fa-5x fa-fw"></i>
		</div>
		<section class="header">
			<div class="container">
				<a href="/" class="home-link">Compare</a>
			</div>
		</section>
		<section class="cats-menu">
			<div class="navbar navbar-default" role="navigation">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" ng-click="isNavCollapsed = !isNavCollapsed">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div>
					<div class="collapse navbar-collapse" uib-collapse="isNavCollapsed">
						<ul class="nav navbar-nav">
							<li ng-repeat="cat in products" ng-class="{'active': activeCat(cat)}"><a href="/@{{cat.cats_default == '1' ? '' : cat.cats_alias}}">@{{cat.cats_name}}</a></li>
						</ul>
					</div>
				</div>
			</div>
		</section>
		<section class="content" ng-view>
		</section>
		<section class="footer">
			<div class="container">
				<div class="row">
					<div class="groups-footer col-md-6" ng-repeat="cat in products">
						<h3 ng-if="cat.prods.length"><i class="fa fa-folder-open-o" aria-hidden="true"></i> @{{cat.cats_name}}</h3>
						<span class="footer-content" ng-repeat="prod in cat.prods">
							<span>&bull; </span><a href="/@{{cat.cats_alias}}/@{{prod.prods_full_alias}}">@{{prod.brands_id.brands_name}} @{{prod.prods_name}}</a>
						</span>
					</div>
				</div>
			</div>
		</section>

		<script src="/js/libs/angular.min.js"></script>
		<script src="/js/libs/angular-route.min.js"></script>
		<script src="/js/libs/ui-bootstrap-tpls-2.5.0.js"></script>
		<script src="/js/compareapp.js"></script>
		<script src="/js/index.js"></script>
		<script src="/js/compare.js"></script>
		<script src="/js/dirDisqus.js"></script>
		<script src="/js/prods_info.js"></script>
    </body>
</html>
