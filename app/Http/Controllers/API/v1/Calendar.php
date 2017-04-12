<?php 

namespace App\Http\Controllers\API\v1;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Calendar extends BaseController
{

	public function index(){

		$collection = User::where('blocked', 0)->get();

		if(count($collection)){
			$users = $collection->toArray();			
		}else{
			$users = [];
		}
		
		return response()->json([$users, 200]);
	}
	
	/**
	 *
	 * */
	public function date($year,$month,$day=''){

		$query = User::where('blocked', 0)->whereMonth('birthday_date','=',$month);
		
		if($day){
			$query->whereDay('birthday_date','=',$day);
		}
		$collection = $query->get();

		if(count($collection)){
			$users = $collection->toArray();
		}else{
			$users = [];
		}
		
		return response()->json([$users, 200]);
	}
	
}
