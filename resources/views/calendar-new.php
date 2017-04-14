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
		html {
		  overflow-y: scroll;
		}
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
        <?php $modalBoxes = ''; ?>
		<?php foreach($calendar as $month_index => $monthData): ?>
			<div class="col-md-4">
				<h4>
                    <?php echo $russian_months[$month_index] . ' [ <span style="color:lightseagreen;">'.  date("F", mktime(0, 0, 0, $month_index, 10)) . '</span> ]'; ?>
                </h4>
                <table class='table table-striped table-bordered'>
                    <tr>
                        <td>MON</td>
                        <td>TUE</td>
                        <td>WED</td>
                        <td>THU</td>
                        <td>FRI</td>
                        <td>SAT</td>
                        <td>SUN</td>
                    </tr>
                        <?php for($i = 0; $i < count($monthData); $i++) : ?>
                            <tr>
                                <?php for($j = 0; $j < 7; $j++) : ?>
                                    <?php if(!empty($monthData[$i][$j])) : ?>
                                        <?php $class = ($j == 5 || $j == 6) ? " class='weekend-day'": ""; ?>
                                        <td <?php echo $class; ?>>
                                        <?php echo $monthData[$i][$j]['dayNum']; ?>
                                            <?php if (!empty($monthData[$i][$j]['users'])): ?>
                                                <?php foreach($monthData[$i][$j]['users'] as $userIndex => $userData): ?>
                                                    <div>
                                                        <p><?php echo $userData['first_name'].' '.$userData['last_name']; ?></p>
                                                        <p>
                                                            <a href="#" data-toggle="modal" data-target="#modal-<?php echo $month_index.$i.$j.$userIndex; ?>" title="<?php echo $userData['first_name'] . ' ' . $userData['last_name']; ?>" >
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

                    </table>


			</div>
			
			<?php echo ($month_index % 3 == 0 ) ? '<div class="col-md-12"></div>' : ''; ?>
		<?php endforeach; ?>

        <?php echo $modalBoxes; ?>
	</div>
</body>
</html>