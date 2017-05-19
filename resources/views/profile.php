<!-- View stored in resources/views/calendar.php -->

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Profile <?php echo $userData->first_name; ?> <?php echo $userData->last_name; ?></title>
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	
	<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
		
	<!-- Bootstrap core CSS -->
	<link href="../../vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('#tabs').tab();
    });
</script>    
</head>
<body>
	<div class="container">

		<h4><?php echo $userData->first_name; ?> <?php echo $userData->last_name; ?></h4>


		 <ul class="nav nav-tabs" style="position:relative;display:inline;float:left;">		
			<li><a href="/calendar/<?php echo date('Y'); ?>">Calendar</a></li>	 			
		</ul>

		 <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
			<li class="active"><a href="#profile" data-toggle="tab">Profile</a></li>
			<li><a href="#password" data-toggle="tab">Change Password</a></li>
		</ul>
		
		<div id="my-tab-content" class="tab-content">
			<div class="tab-pane active" id="profile">
				<h1>Profile</h1>
				<center>

				<?php $gravatar_image_url = \App\Http\Controllers\Calendar::getGravatarURL($userData->email, 200,200); ?>
				<?php if(!empty($gravatar_image_url)): ?>
					<p><img src="<?php echo $gravatar_image_url; ?>" name="aboutme" width="200" height="200" border="0" class="img-circle"></p>
				<?php endif; ?>
				
				<form id="tab" action="/profile/<?php echo $userData->id; ?>" method="post">
					
					<div class="row">
						<div class="col-md-3 text-right">
							<label for="email">Email</label>						
						</div>
						<div class="col-md-6">
							<input id="email" name="email" type="email" value="<?php echo $userData->email; ?>" class="form-control">						
						</div>						
						<div class="col-md-3">
						</div>												
					</div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3 text-right">
                            <label for="last_name">Skype Login</label>
                        </div>
                        <div class="col-md-6">
                            <input id="last_name" name="skype" type="text" value="<?php echo $userData->skype; ?>" class="form-control">
                        </div>
                        <div class="col-md-3">
                        </div>
                    </div>
                    <hr>
					<div class="row">
						<div class="col-md-3 text-right">
							<label for="first_name">First Name</label>						
						</div>
						<div class="col-md-6">
							<input id="first_name" name="first_name" type="text" value="<?php echo $userData->first_name; ?>" class="form-control">						
						</div>						
						<div class="col-md-3">
						</div>												
					</div>
					<hr>
					<div class="row">
						<div class="col-md-3 text-right">
							<label for="last_name">Last Name</label>
						</div>
						<div class="col-md-6">
							<input id="last_name" name="last_name" type="text" value="<?php echo $userData->last_name; ?>" class="form-control">												
						</div>						
						<div class="col-md-3">
						</div>												
					</div>
					<hr>
					<div class="row">
						<div class="col-md-3 text-right">
							<label for="birthday_date">Birthday</label>
						</div>
						<div class="col-md-6">
							<input id="birthday_date" name="birthday_date" type="date" value="<?php echo $userData->birthday_date; ?>" class="form-control">												
						</div>						
						<div class="col-md-3">
						</div>												
					</div>
					<hr>
					<div class="row">
						<div class="col-md-3 text-right">
							<label for="wishlist">Wish List</label>
						</div>
						<div class="col-md-6">
							<textarea id="wishlist" name="wishlist" class="form-control"><?php echo $userData->wishlist; ?></textarea>						
						</div>						
						<div class="col-md-3">
						</div>												
					</div>
					
					<br>
					<div>
						<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
						<button class="btn btn-primary">Update</button>
					</div>
				  </form>
					 
				<br>
				</center>
			</div>
			<div class="tab-pane" id="password">
				<h1>Change Password</h1>
				<form id="tab" action="/profile/<?php echo $userData->id; ?>" method="post">
					<label>Password</label>
					<input name="password" type="password" value="" class="form-control">				
					
					<br>
					<div>
						<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
					  <button class="btn btn-primary">Update</button>
					</div>					
				</form>
						
			</div>

		</div>
		


	</div>
</body>
</html>