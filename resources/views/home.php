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
	
	<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
	<!-- Bootstrap core CSS -->
	<link href="../../vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="../../vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
	<style>
		#legend{
			margin : 10px 0px;
		}
	</style>
</head>
<body>

<div class="container">
	<div class="row">
        <div class="span12">
    		<div class="" id="loginModal">
              <div class="modal-header">
                <h3>Have an Account? <a class="btn btn-primary pull-right" href="/calendar/<?php echo date('Y'); ?>">View Birthdays Calendar</a></h3>								
              </div>			  
              <div class="modal-body">
                <div class="well">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#login" data-toggle="tab">Login</a></li>
                    <li><a href="#create" data-toggle="tab">Create Account</a></li>
                    <li><a href="#password-reset" data-toggle="tab">Reset Password</a></li>
                  </ul>
                  <div id="myTabContent" class="tab-content">
                    <div class="tab-pane active in" id="login">
                      <form class="form-horizontal" action='/sign-in' method="POST">
                        <fieldset>
                          <div id="legend">
                            <legend class="">Login</legend>
                          </div>    
                          <div class="control-group">
                            <!-- email -->
                            <label class="control-label"  for="email">Email</label>
                            <div class="controls">
                              <input type="text" id="email" name="email" placeholder="" class="form-control">
                            </div>
                          </div>
     
                          <div class="control-group">
                            <!-- Password-->
                            <label class="control-label" for="password">Password</label>
                            <div class="controls">
                              <input type="password" id="password" name="password" placeholder="" class="form-control">
                            </div>
                          </div>

						  <br>
							<div class="control-group">
								<input id="remember_me" name="remember_me" type="checkbox" value="1">							
								<label for="remember_me">Remember Me</label>
							</div>
						
							<br>
                          <div class="control-group">
                            <!-- Button -->
                            <div class="controls">
                              <input type="hidden" name="redirect_to" value="<?php echo filter_input( INPUT_GET, 'redirect_to', FILTER_SANITIZE_URL ); ?>">
							  <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
                              <button class="btn btn-success">Login</button>
                            </div>
                          </div>
                        </fieldset>
                      </form>
                    </div>

                    <div class="tab-pane fade" id="create">
                      <form id="tab" action="/sign-up" method="post">
						<div id="legend">
							<legend class="">Create Account</legend>
							<p class="">Note : Please wait 1 hour to have your account approved. </p>
						</div>    
                        <label>Email</label>
                        <input name="email" type="email" value="" class="form-control">

                        <label>Skype Login</label>
                        <input name="skype" type="textinput" value="" class="form-control">

						<label>First Name</label>
                        <input name="first_name" type="text" value="" class="form-control">
                        
						<label>Last Name</label>
                        <input name="last_name" type="text" value="" class="form-control">
                        
						<label>Birthday (mm/dd/yyyy)</label>
                        <input name="birthday_date" type="date" value="" class="form-control">
                           
                        <label>Password</label>
                        <input name="password" type="password" value="" class="form-control">
						
						<label>Wish List</label>
                        <textarea name="wishlist" class="form-control"></textarea>
						
						<br>
                        <div>
						  <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
                          <button class="btn btn-primary">Create Account</button>
                        </div>
                      </form>
                    </div>
					
                    <div class="tab-pane fade" id="password-reset">					
						<form id="tab" action="/" method="post">
							<div id="legend">
								<legend class="">Password Reset</legend>
							</div>
							<label>Email</label>
							<input name="email" type="email" value="" class="form-control">
							<input type="hidden" name="reset_password" value="1">
							<br>
							<div>
							  <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
							  <button class="btn btn-primary">Password Reset</button>
							</div>							
						</form>
					</div>
					
                </div>
              </div>
            </div>
        </div>
	</div>
</div>


</body>
</html>