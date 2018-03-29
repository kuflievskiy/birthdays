<?php

namespace App\Console;

use DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\User;

class Kernel extends ConsoleKernel
{
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		//\App\Console\Commands\Inspire::class,
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{

		$schedule->call(function () {


            // Numeric representation of a month, without leading zeros.
            $currentMonth = date('n');
            $nextMonth = ( 12 == $currentMonth ) ? 1 : ( $currentMonth + 1 );

            $query = User::where('blocked', 0)->where( DB::raw( 'MONTH(STR_TO_DATE(birthday_date, \'%Y-%m-%d\'))'), $nextMonth )->orderBy('birthday_date','asc');
            $collection = $query->get();
            $users = $collection->toArray();

			if ( $users ) {
				foreach( $users as $userRow ){

				    $subject = 'CRON JOB NOTIFICATION (BirthDays site)';

				    $message = __METHOD__ . ' test cron job! Next month Birthdays: ' . $userRow->email . $userRow->birthday_date;

					mail('kuflievskiy@gmail.com',$subject, $message );
				}
			}

		})->everyMinute();//daily everyFiveMinutes();

	}
}