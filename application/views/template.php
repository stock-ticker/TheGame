<!DOCTYPE html>
<html lang="en">
<head>
  <title>{pagetitle}</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
  <div class="jumbotron">
    <h1>Stock Ticker</h1>
    <!--<p></p>-->
  </div>
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
		<div class="navbar-header">
		  <a class="navbar-brand" href="#">Stock Ticker</a>
		</div>
		<ul class="nav navbar-nav">
		  <li class="active"></a></li>
		  <li><a href="#">Home</a></li>
		  <li><a href="#">Stock History</a></li>
		  <li><a href="#">Users</a></li>
		  <li><a href="#">Login</a></li>
		</ul>
	  </div>
	</nav>
  <div class="row">
    {content}
  </div>
</div>

</body>
</html>