<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
/*
Route::get('/', function () {
    return view('welcome');
});

*/



/**
 * @todo move this action to special Controller for Auth
 * */
Route::post('/sign-in', function(Request $request) {

	$data = $request->all();

	$remember = ( isset( $data['remember_me'] ) && $data['remember_me'] ) ? 1 : 0;

	if (Auth::attempt([
			'email' => $data['email'], 
			'password' => $data['password'], 
		], $remember ) ) {
		
		
		// The user is active, not suspended, and exists.

		$userData = Auth::user();

		$redirectTo = $data['redirect_to'] ? $data['redirect_to'] : url('/profile/' . $userData->id);
		return redirect($redirectTo);
	} else {
		
		return view( 'message', [
			'title' => 'Wrong credentials',
			'message' => 'Please check your credentials and <a href="' . url('/'). '">try again</a>!',
		]);					
	}

});

/**
 * @todo move this action to special Controller for Auth
 * */
Route::post('/sign-up', function(Request $request) {

	$data = $request->all();
	try{
		$user = \App\User::where('email', '=', $data['email'] )->firstOrFail();		
	} catch ( Exception $e ) {
		
		$user = new \App\User();
		$user->email = $data['email'];
		$user->password = bcrypt( $data['password'] );
		$user->first_name = $data['first_name'];
		$user->last_name = $data['last_name'];
		$user->birthday_date = date("Y-m-d", strtotime($data['birthday_date']));
		$user->wishlist = $data['wishlist'];
		$user->wish_updated_at = $data['wishlist'] ? date('Y-m-d H:i:s',time()) : null;
        $user->skype = $data['skype'];
		$user->save();

		// Flush calendar cache on user sign up action.
		Cache::flush();
	}
	\Auth::loginUsingId($user->id);
	return redirect('/');		
		
	
});

/**
 * @todo move this action to special Controller for Auth
 * */
Route::get('/logout', function(Request $request) {
	\Auth::logout();
	return redirect('/');
});




Route::get('/', function() {

	$user_activation_key = filter_input( INPUT_GET, 'password_reset_key', FILTER_SANITIZE_STRING );
	if( $user_activation_key ) {
		try{
			$user = \App\User::where('user_activation_key', '=', $user_activation_key )->firstOrFail();
			$newPassword = rand( 1,99999 );
			$user->password = bcrypt( $newPassword );
			$user->save();
			
			$message = 'Your new password for the ' . url('/') . ' is : ' . $newPassword . '. ';
			$message .= 'Please change it ASAP.';
			
			mail($user->email, 'New Password', $message );

			\Auth::loginUsingId($user->id);
			return redirect('/profile/' . $user->id );
	
		} catch ( Exception $e ){
			return view( 'message', [
				'title' => 'Error occured',
				'message' => 'Wrong password_reset_key parameter!',
			]);
		}
	}

	if ($isUserLoggedIn = Auth::check()) {
		return redirect('/calendar/' . date('Y') );
	}

    return view('home', [
		'title' => 'CMS Team Birthdays',
		'isUserLoggedIn' => $isUserLoggedIn,
	]); 
});

Route::post('/',function(){
	
	if ( 1 == filter_input( INPUT_POST, 'reset_password', FILTER_SANITIZE_NUMBER_INT ) ) {
		$email = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL );
		

		try{
			$user = \App\User::where('email', '=', $email)->firstOrFail();

			$salt = $email;		
			$user->user_activation_key = substr( hash_hmac( 'sha256', rand( 0, 100 ), $salt ), 0, 8 );
			$user->save();
			$reset_url = url('/') . '?password_reset_key=' . $user->user_activation_key;
			mail( $email, 'Reset Password', 'Password reset URL : ' . $reset_url );

			return view( 'message', [
				'title' => 'Password Reset',
				'message' => 'Please check your email box!',
			]);	

		} catch ( Exception $e ) {
			
			return view( 'message', [
				'title' => 'Error',
				'message' => 'Sorry, but there is no user with this email address. Are you a hacker?', //$e->getMessage(),
			]);
		}

	}
});


Route::get('/calendar', function(){
	return redirect('/calendar/' . date('Y') );
});

Route::get('/calendar/{year}', 'Calendar@index');
Route::get('/profile/{id}', 'Profile@index');
Route::post('/profile/{id}', 'Profile@update');
