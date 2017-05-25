<?php 

namespace App\Http\Controllers\API\v1;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Database\Eloquent\Model;
use App\User;

use Request;
use Config;
use App\Helpers\APIConnection;

class Calendar extends BaseController
{

	/**
	 * @property APIConnection $apiConnection
	 */
	protected $apiConnection;
	
	/**
	 * __construct
	 * @param APIConnection $apiConnection
	 * */
	public function __construct(APIConnection $apiConnection) {
		$this->apiConnection = $apiConnection;
	}
	
	public function index(){

		$access = $this->apiConnection->isAPIAccessAllowed();
		if ( false == $access['success'] ) {
			return response('', $access['code'] )->send();
		}
		
		$collection = User::where('blocked', 0)->get();

		if(count($collection)){
			$users = $collection->toArray();			
		}else{
			$users = [];
		}
		
		return response()->json($users);
	}
	
	/**
	 * Function date
	 *
	 * @param $year
	 * @param $month
	 * @param $day
	 *
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function date($year,$month,$day=''){
		
		$access = $this->apiConnection->isAPIAccessAllowed();
		if ( false == $access['success'] ) {
			return response('', $access['code'] )->send();
		}

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
		
		return response()->json($users);
	}

	/**
	 * Function test
	 *
	 * @return \Illuminate\Http\JsonResponse
	 *
	 */
	public function test() {
		return response()->json($this->apiConnection->isAPIAccessAllowed());
	}
}
