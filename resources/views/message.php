<!-- View stored in resources/views/calendar.php -->

<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $title; ?></title>

	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<!-- Bootstrap core CSS -->
	<link href="../../vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
	<div class="row">
		<h1><?php echo $title; ?></h1>
        <div class="col-md-12">
			<div class="alert alert-info" role="alert"><?php echo $message; ?></div>
        </div>
	</div>
</div>


</body>
</html>