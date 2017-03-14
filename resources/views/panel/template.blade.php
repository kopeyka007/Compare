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
			<div class="container">
				<div ng-view>
				</div>
			</div>
		</section>
		
		<script src="/js/panelapp.js"></script>
		<script src="/js/signin.js"></script>
		<script src="/js/validate.js"></script>
		
    </body>
</html>
