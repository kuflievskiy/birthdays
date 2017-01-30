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
    //

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

		//$collection = User::all();
		$collection = User::where('blocked', 0)->get();

		if(count($collection)){
			$users = $collection->toArray();			
		}else{
			$users = [];
		}
		
		$calendar = [];
		for($i = 1; $i <= 12; $i++){
			$calendar[$i] = $this->calendar_show($i,$year,$users);
		}
		
		return view('calendar', [
			'calendar' => $calendar, 
			'year' => $year,
			'russian_months' => $this->russian_months,
			'userData' => \Auth::user(),
		]);
	}

	public function calendar_show($month,$year,$users_birthdays){
		if (\Cache::has('calendar'.$month.$year)) {
			$month_html = \Cache::get('calendar'.$month.$year);
		}else{
			ob_start();
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
						$week[$num][$i] = date('j',mktime(0, 0, 0,$month,$day_count,$year));

						$week[$num][$i] .= $this->return_birthdays(
							date('m-d',mktime(0, 0, 0,$month,$day_count,$year)),
							$users_birthdays
						);
						$day_count++;
					} else{
						$week[$num][$i] = "";
					}
				}

				// 2. Последующие недели месяца
				while(true){
					$num++;
					for($i = 0; $i < 7; $i++)
					{
						$week[$num][$i] = $day_count;

						$week[$num][$i] .= $this->return_birthdays(
							date('m-d',mktime(0, 0, 0,$month,$day_count,$year)),
							$users_birthdays
						);

						$day_count++;
						// Если достигли конца месяца - выходим
						// из цикла
						if($day_count > $dayofmonth) break;
					}
					// Если достигли конца месяца - выходим
					// из цикла
					if($day_count > $dayofmonth) break;
				}

				// 3. Выводим содержимое массива $week
				// в виде календаря
				// Выводим таблицу
				echo "<table class='table table-striped table-bordered'>";

			   echo '<tr>
					   <td>MON</td>
					   <td>TUE</td>
					   <td>WED</td>
					   <td>THU</td>
					   <td>FRI</td>
					   <td>SAT</td>
					   <td>SUN</td>
				   </tr>';

				for($i = 0; $i < count($week); $i++) {
					echo "<tr>";
					for($j = 0; $j < 7; $j++){
						if(!empty($week[$i][$j])){
							// Если имеем дело с субботой и воскресенья
							// подсвечиваем их
							if($j == 5 || $j == 6)
								echo "<td><font color=red>".$week[$i][$j]."</font></td>";
							else echo "<td>".$week[$i][$j]."</td>";
						}
						else echo "<td>&nbsp;</td>";
					}
					echo "</tr>";
				}
				echo "</table>";
			$month_html = ob_get_contents();
			ob_end_clean();

			\Cache::put('calendar'.$month.$year, $month_html, 3600);
		}
		
		return $month_html;
    }

    function return_birthdays($md,$users_birthdays){
        $return = '';
        foreach($users_birthdays as $user_data){
            if(isset($user_data['birthday_date'])){
                if( $md == substr($user_data['birthday_date'],5,5) ){

                    $gravatar = $this->get_gravatar($user_data['email']);
					$wishList = ! empty( trim( $user_data['wishlist'] ) ) ? $user_data['wishlist'] : 'Wish List is Empty';
                    $text = '<br>
                    <p>
                    ' . $user_data['first_name'] . '
                    <a href="#" data-toggle="popover" title="' . $user_data['first_name'] . ' ' . $user_data['last_name'] . '" data-content="' . '<p>' . $user_data['email'] . '</p>' . $wishList . '">';					
                    if($gravatar) {
                        $text .= "<img src=" . $this->get_gravatar($user_data['email']) . " />";
					}
                    $text .= "</a></p>";
                    $return .= $text;
                }
            }
        }
        return $return;
    }


    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param boole $img True to return a complete IMG tag False for just the URL
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @return String containing either just a URL or a complete image tag
     * @source http://gravatar.com/site/implement/images/php/
     */
    public static function get_gravatar( $email, $s = 40, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
        if ( $img ) {
            $url = '<img src="' . $url . '"';
            foreach ( $atts as $key => $val )
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }

        $headers = get_headers($url,1);
        if (strpos($headers[0],'200')) return $url;
        else if (strpos($headers[0],'404')) return '';

    }
	
}
