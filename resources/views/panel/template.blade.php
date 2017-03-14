<html lang="en" ng-app="panelApp" ng-controller="panelCtrl">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Compare.da</title>
		<link href="/css/bootstrap.min.css" rel="stylesheet" />
		<link href="/css/font-awesome.min.css" rel="stylesheet" />
		<link href="/css/style.css" rel="stylesheet" />
		<script src="/js/angular.min.js"></script>
		<script src="/js/angular-route.min.js"></script>
	</head>
	
    <body>
		<section>
			<nav class="navbar navbar-default" ng-if="user">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">Brand</a>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
						<li><a href="/panel/users">Users</a></li>
						<li><a href="/panel/categories">Categories</a></li>
						<li><a href="/panel/attributes">Attributes</a></li>
						<li><a href="/panel/products">Products</a></li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
						<li><a href="" ng-click="logout()">Sign out</a></li>
						</ul>
					</div>
				</div>
			</nav>
			<div class="container">
				<div class="error-msg" ng-show="errors.length">
					<div class="alert alert-@{{msg.type}}" ng-repeat="msg in errors" ng-init="showme = true" ng-show="showme" role="alert">@{{msg.text}}
						 <button type="button" class="close" data-dismiss="alert" aria-label="Close" ng-click="showme = false"><span aria-hidden="true">&times;</span></button>
					</div>
				</div>
				<div ng-view>
				</div>
			</div>
		</section>
		
		<script src="/js/angular-animate.min.js"></script>
		<script src="/js/angular-sanitize.min.js"></script>
		<script src="/js/ui-bootstrap-tpls-2.5.0.js"></script>
		<script src="/js/panelapp.js"></script>
		<script src="/js/signin.js"></script>
		<script src="/js/users.js"></script>
		<script src="/js/validate.js"></script>
		
    </body>
</html>
