<?php namespace App\Http\Controllers;


namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


use Illuminate\Database\Eloquent\Model;
use App\User;

class Profile extends BaseController
{

	/**
	 * Function index
	 *
	 * @param $userId
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
	 */
	public function index($userId){

		if( ! \Auth::check() ) {
			return redirect('/');
		}

		return view('profile', [
			'userData' => \Auth::user(),
		]);
	}
	
	public function update($userId){

		if( ! \Auth::check() ) {
			return redirect('/');
		}
		
		if( filter_input( INPUT_POST, 'password', FILTER_SANITIZE_STRING ) ) {
			$user = User::where('id', '=', $userId)->firstOrFail();
			// password_confirmation
			$user->password = bcrypt( $_POST['password'] );
			$user->save();
		} else {
			$user = User::where('id', '=', $userId)->firstOrFail();
			$user->email = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL );
			$user->first_name = filter_input( INPUT_POST, 'first_name', FILTER_SANITIZE_STRING );
			$user->last_name = filter_input( INPUT_POST, 'last_name', FILTER_SANITIZE_STRING );
			$user->birthday_date = filter_input( INPUT_POST, 'birthday_date', FILTER_SANITIZE_STRING );
			$user->wishlist = filter_input( INPUT_POST, 'wishlist', FILTER_SANITIZE_STRING );
			$user->save();		
			
			\Cache::flush();
		}

		
		return view('profile', [
			'userData' => $user, //\Auth::user(),
		]);
	}
}
