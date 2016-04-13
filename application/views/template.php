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
		<ul class="nav navbar-nav">
		  <li class="active"></a></li>
		  <li><a href="/homepage">Home</a></li>
		  <li><a href="/history">Stock History</a></li>
		  <li><a href="/profile">Player Profile</a></li>
                  <li><a href="/gameplay">Play!</a></li>
		  <li><a href="/login">{loginText}</a></li>
		</ul>
	  </div>
	</nav>
  <div class="row">
    {content}
  </div>
</div>

</body>
</html>