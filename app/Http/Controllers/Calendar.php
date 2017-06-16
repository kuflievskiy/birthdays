<?php 
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Database\Eloquent\Model;
use App\User;


class Calendar extends BaseController
{
	public function index( $year ){

		if( ! \Auth::check() ) {
			return redirect('/?redirect_to=' . url('/calendar/' . $year));
		}

		$calendarModel = new \App\Calendar;

		$collection = User::where('blocked', 0)->orderBy(\DB::raw("DATE_FORMAT(birthday_date,'%m%d')"), 'asc')->get();

		if(count($collection)){
			$users = $collection->toArray();			
		}else{
			$users = [];
		}

		$calendar = [];
		for($i = 1; $i <= 12; $i++){
			$calendar[$i] = $calendarModel->getMonth($i,$year,$users);
		}

		$calendar = $calendarModel->extendCalendarWithData( $calendar, $users );

		if('true' == filter_input(INPUT_GET,'showMeYourSecret')){
			$template = 'calendar-new';
		}else{
			$template = 'calendar';
		}

        return view($template, ['calendar' => $calendar, 'year' => $year, 'userData' => \Auth::user()]);
	}
}
