<?php 
//error_reporting(E_ALL);
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

		$collection = User::where('blocked', 0)->orderBy(\DB::raw("DATE_FORMAT(birthday_date,'%m%d')"), 'asc')->get();

		if(count($collection)){
			$users = $collection->toArray();			
		}else{
			$users = [];
		}

		$calendar = [];
		for($i = 1; $i <= 12; $i++){
			$calendar[$i] = $this->getMonth($i,$year,$users);
		}

		// Fill in calendar with data from database.
		foreach ($users as $userData) {
			$dateMonth = substr($userData['birthday_date'], 5, 2);
			$dateDay   = substr($userData['birthday_date'], 8, 2);

			// Remove leading zero in strings.
			$dateMonth = (int)ltrim($dateMonth, '0');
			$dateDay   = (int)ltrim($dateDay, '0');

			foreach ($calendar[$dateMonth] as &$weekDays) {
				foreach ($weekDays as $dayIndex => &$dayData) {
					if (isset($dayData['dayNum']) && $dateDay == $dayData['dayNum']) {
						$dayData['users'][] = [
							'gravatarURL' => $this->getGravatarURL($userData['email']),
							'wishlist'    => $userData['wishlist'],
							'email'       => $userData['email'],
							'updated_at'  => $userData['updated_at'],
							'first_name'  => $userData['first_name'],
							'last_name'   => $userData['last_name'],
						];
					}
				}
			}
		}

		if('true' == filter_input(INPUT_GET,'showMeYourSecret')){
			$template = 'calendar-new';
		}else{
			$template = 'calendar';
		}

        return view($template, ['calendar' => $calendar, 'year' => $year, 'userData' => \Auth::user()]);
	}

	/**
	 * Function getCalendarData
	 *
	 * @param $month
	 * @param $year
	 *
	 * @return mixed
	 */
	public function getMonth($month,$year)
	{
        if (\Cache::has('calendar'.$month.$year)) {
            $monthData = \Cache::get('calendar'.$month.$year);
        }else{
            $monthData = $this->buildMonthData($month, $year);

            \Cache::put('calendar'.$month.$year, $monthData, 3600);
        }

		return $monthData;
    }

    /**
     * Function buildMonthData
     *
     * @param $month
     * @param $year
     *
     * @return array
     */
    private function buildMonthData($month,$year)
    {
        $monthData = [];
        $dayofmonth = date("t", mktime(1, 1, 1, $month, 1, $year)) ;// Вычисляем число дней в текущем месяце

        // Day counter in a month.
        $day_count = 1;

        // 1. First week
        $num = 0;
        for($i = 0; $i < 7; $i++)
        {
            // Calculate day number
            $dayofweek = date('w', mktime(0, 0, 0, $month, $day_count, $year));

            // Format:
            // 1 - Monday
            // 6 - Saturday
            $dayofweek = $dayofweek - 1;
            if($dayofweek == -1) $dayofweek = 6;
            if($dayofweek == $i)
            {
                // Set day num in each cell for this week
                $monthData[$num][$i]['dayNum'] = date('j',mktime(0, 0, 0,$month,$day_count,$year));

                $day_count++;
            } else{
                $monthData[$num][$i] = "";
            }
        }

        // 2. All next weeks
        while(true){
            $num++;
            for($i = 0; $i < 7; $i++)
            {
                $monthData[$num][$i]['dayNum'] = $day_count;
                $day_count++;
                if ($day_count > $dayofmonth) {
                    break;
                }
            }

            if ($day_count > $dayofmonth) {
                break;
            }
        }

        return $monthData;
    }

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param int|string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @return String containing either just a URL or a complete image tag
     * @source http://gravatar.com/site/implement/images/php/
     */
    public static function getGravatarURL( $email, $s = 40, $d = 'mm', $r = 'g', $atts = array() ) {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
	    return $url;
    }
	
}
