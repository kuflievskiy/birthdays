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
	/**
	 * @property $russian_months
	 * */
	public $russian_months = [
        1 => 'Пьянварь',
        2 => 'Фигвраль',
        3 => 'Кошмарт',
        4 => 'Сопрель',
        5 => 'Сымай',
        6 => 'Теплюнь',
        7 => 'Жарюль',
        8 => 'Авгрусть',
        9 => 'Свистябрь',
        10 => 'Моктябрь',
        11 => 'Гноябрь',
        12 => 'Дубабрь'
    ];

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

		return view($template, [
			'calendar' => $calendar, 
			'year' => $year,
			'russian_months' => $this->russian_months,
			'userData' => \Auth::user(),
		]);
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
		$monthData = [];

		if ( 0 && \Cache::has('calendar'.$month.$year)) {
			$monthData = \Cache::get('calendar'.$month.$year);
		}else{
			$dayofmonth = date("t", mktime(1, 1, 1, $month, 1, $year)) ;// Вычисляем число дней в текущем месяце

			// Счётчик для дней месяца
			$day_count = 1;

			// 1. Первая неделя
			$num = 0;
			for($i = 0; $i < 7; $i++)
			{
				// Вычисляем номер дня недели для числа
				$dayofweek = date('w', mktime(0, 0, 0, $month, $day_count, $year));
				// Приводим к числа к формату 1 - понедельник, ..., 6 - суббота
				$dayofweek = $dayofweek - 1;
				if($dayofweek == -1) $dayofweek = 6;
				if($dayofweek == $i)
				{

					// Если дни недели совпадают,
					// заполняем массив $week
					// числами месяца
					$monthData[$num][$i]['dayNum'] = date('j',mktime(0, 0, 0,$month,$day_count,$year));

					// @todo
					//$week[$num][$i]['users'] = $this->getUsersByDate(date('m-d',mktime(0, 0, 0,$month,$day_count,$year)),$users);


					$day_count++;
				} else{
					$monthData[$num][$i] = "";
				}
			}

			// 2. Последующие недели месяца
			while(true){
				$num++;
				for($i = 0; $i < 7; $i++)
				{
					$monthData[$num][$i]['dayNum'] = $day_count;
					// @todo

					//$week[$num][$i]['users'] = $this->getUsersByDate(date('m-d',mktime(0, 0, 0,$month,$day_count,$year)),$users);

					$day_count++;
					// Если достигли конца месяца - выходим
					// из цикла
					if($day_count > $dayofmonth) break;
				}
				// Если достигли конца месяца - выходим
				// из цикла
				if($day_count > $dayofmonth) break;
			}

			\Cache::put('calendar'.$month.$year, $monthData, 3600);
		}

		return $monthData;
    }

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
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

//        $headers = get_headers($url,1);
//        if (strpos($headers[0],'200')) return $url;
//        else if (strpos($headers[0],'404')) return '';
    }
	
}
