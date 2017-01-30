<!-- View stored in resources/views/calendar.php -->

<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $year; ?></title>
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<!-- Bootstrap core CSS -->
	<link href="../../vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		.centered{text-align:center;}
	</style>
	<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<script src="/resources/views/js/calendar.js"></script>
</head>
<body> 
		
<nav class="navbar navbar-default" role="navigation">
   <div class="navbar-header">
      <a class="navbar-brand" href="#">Birthdays</a>
   </div>
   <div>
      <ul class="nav navbar-nav">
		<?php if ( $userData ) : ?>
			<li><a href="/profile/<?php echo $userData->id; ?>">Profile</a></li>
			<li><a href="<?php echo url('/logout/'); ?>">Sign Out</a></li>
		<?php else : ?>
			<li><a href="/">Sign In/Up</a></li>
		<?php endif; ?>		 
         <!--
		 <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
               Java 
               <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
               <li><a href="#">jmeter</a></li>
               <li><a href="#">EJB</a></li>
               <li><a href="#">Jasper Report</a></li>
               <li class="divider"></li>
               <li><a href="#">Separated link</a></li>
               <li class="divider"></li>
               <li><a href="#">One more separated link</a></li>
            </ul>
         </li>
		 -->
      </ul>
   </div>
</nav>

	<div class="container-fluid">
	  <div class="row">
		<div class="col-md-12 centered">
			<h1 class="text-center">Birthdays Calendar <?php echo $year; ?></h1>
			<ul class="pagination">
				<li><a href="/calendar/<?php echo $year-1; ?>" title="Previous Year">Previous Year &laquo;</a></li>
				<li><a href="/calendar/<?php echo $year+1; ?>" title="Next Year">Next Year &raquo;</a></li>
			</ul>
		</div>
	  </div>

		
	<div class="row">

		<?php foreach($calendar as $month_index => $month): ?>
			<div class="col-md-4">
				<h4><?php echo $russian_months[$month_index] . ' [ <span style="color:lightseagreen;">'.  date("F", mktime(0, 0, 0, $month_index, 10)) . '</span> ]'; ?></h4>
				<?php echo $month; ?>
			</div>
			
			<?php echo ($month_index % 3 == 0 ) ? '<div class="col-md-12"></div>' : ''; ?>
		<?php endforeach; ?>
	</div>
</body>
</html>