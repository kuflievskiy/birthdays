<!-- View stored in resources/views/calendar.php -->

<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $year; ?></title>
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Bootstrap core CSS -->
	<link href="../../vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		.centered{text-align:center;}
		.weekend-day{
			color:red;
		}
			.weekend-day>*{
				color:black;
			}
	</style>
	<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<script src="/resources/views/js/calendar.js"></script>

	<!-- ghost front end start -->
	<link href="/resources/assets/ghost-front-end/ghost-styles.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/resources/assets/ghost-front-end/tooltipster.bundle.min.css" />

	<script src="/resources/assets/ghost-front-end/tooltipster.bundle.min.js"></script>
	<script src="/resources/assets/ghost-front-end/main.js"></script>
	<!-- ghost front end end -->
</head>
<body class="month-<?php echo strtolower( date( 'F' ) ); ?>">

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
      </ul>
   </div>
</nav>

	<div class="container-fluid page-wrapper">
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

			<div class="calendar-container">

	        <?php $modalBoxes = ''; ?>
			<?php foreach($calendar as $month_index => $monthData): ?>

				<div class="single-calendar-month">
					<h4><?php echo date("F", mktime(0, 0, 0, $month_index, 10)); ?></h4>
	                <table class='table table-striped table-bordered'>
						<thead>
		                    <tr>
		                        <th>MON</th>
		                        <th>TUE</th>
		                        <th>WED</th>
		                        <th>THU</th>
		                        <th>FRI</th>
		                        <th>SAT</th>
		                        <th>SUN</th>
		                    </tr>
						</thead>
						<tbody>

	                        <?php for($i = 0; $i < count($monthData); $i++) : ?>
	                            <tr>
	                                <?php for($j = 0; $j < 7; $j++) : ?>
	                                    <?php if(!empty($monthData[$i][$j])) : ?>
	                                        <?php $weekendDay = ($j == 5 || $j == 6) ? " class='weekend-day'": ""; ?>

											<?php $dayWithBirthday = ( !empty($monthData[$i][$j]['users']) ) ? " attr='day-with-birthday'" : ""; ?>

	                                        <td <?php echo $weekendDay, $dayWithBirthday; ?>>

	                                        <span class="day-number"><?php echo $monthData[$i][$j]['dayNum']; ?></span>
	                                            <?php if (!empty($monthData[$i][$j]['users'])): ?>
	                                                <?php foreach($monthData[$i][$j]['users'] as $userIndex => $userData): ?>
	                                                    <div>
	                                                        <p class="birthday-man-name"><?php echo $userData['first_name'].' '.$userData['last_name']; ?></p>
	                                                        <p>
	                                                            <a href="#" data-toggle="modal"
																 	class="custom-tooltip"
																	data-target="#modal-<?php echo $month_index.$i.$j.$userIndex; ?>"
																	title="<?php echo $userData['first_name'] . ' ' . $userData['last_name']; ?>" >

	                                                            	<img src="<?php echo $userData['gravatarURL']; ?>" />
	                                                            </a>
	                                                        </p>
	                                                    </div>
	                                                    <?php
	                                                    $modalBoxes .= '
	                                                        <div class="modal fade" id="modal-'.$month_index.$i.$j.$userIndex.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	                                                          <div class="modal-dialog" role="document">
	                                                            <div class="modal-content">
	                                                              <div class="modal-header">
	                                                                <h5 class="modal-title" id="exampleModalLongTitle">'.$userData['email'].'\'s Wish List</h5>
	                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                                                                  <span aria-hidden="true">&times;</span>
	                                                                </button>
	                                                              </div>
	                                                              <div class="modal-body">
	                                                              <p>'.$userData['first_name'].' '.$userData['last_name'].'</p>
	                                                              '.nl2br($userData['wishlist']).'</div>
	                                                              <div class="modal-footer">
	                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
	                                                              </div>
	                                                            </div>
	                                                          </div>
	                                                        </div>';
	                                                    ?>
	                                                <?php endforeach; ?>
	                                        <?php endif; ?>
	                                    </td>
	                                    <?php else : ?>
	                                        <td>&nbsp;</td>
	                                    <?php endif; ?>
	                                <?php endfor; ?>
	                            </tr>
	                        <?php endfor; ?>

							</tbody>
	                    </table>


				</div>


			<?php //echo ($month_index % 3 == 0 ) ? '<div class="col-md-12"></div>' : ''; ?>
		<?php endforeach; ?>
			</div>

        <?php echo $modalBoxes; ?>
	</div>
</body>
</html>
