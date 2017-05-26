<?php
namespace App\Helpers;

use Request;
use Config;

/**
 * Class APIConnection
 *
 */
class APIConnection {
	
    /**
     * Function isAPIAccessAllowed
     *
     * */
	public function isAPIAccessAllowed() {

		$config = Config::get('api');
		
		if(!Request::isMethod('get')) {
			// 405 Forbidden
			// A request method is not supported for the requested resource;
			// for example, a GET request on a form that requires data to be presented via POST, or a PUT request on a read-only resource.
			return [
				'success' => false,
				'code'    => 405,
				'message' => 'Forbidden',
			];
		}
		
		if( !( isset( $config['clients'] ) && $config['clients'] ) ) {
			// 403 Forbidden
			// The request was valid, but the server is refusing action. The user might not have the necessary permissions for a resource.
			return [
				'success' => false,
				'code'    => 403,
				'message' => 'Forbidden',
			];
		}
		
		$remoteServerAddr = Request::server('REMOTE_ADDR');
		if( array_key_exists( $remoteServerAddr, $config['clients'] ) ) {
			$secretKey = $config['clients'][$remoteServerAddr];
		} else {
			// 403 Forbidden
			// The request was valid, but the server is refusing action. The user might not have the necessary permissions for a resource.
			return [
				'success' => false,
				'code'    => 403,
				'message' => 'Forbidden. Your IP is not allowed.',
                'debug' => $remoteServerAddr,
			];
		}
		
		if( $secretKey != Request::header('X-SecretKey') ) {
			// 403 Forbidden
			// The request was valid, but the server is refusing action. The user might not have the necessary permissions for a resource.
			return [
				'success' => false,
				'code'    => 403,
				'message' => 'Forbidden. Header key is wrong.',
			];
		}
		
		return [
			'success' => true,
			'code'    => 200,
			'message' => 'OK',
		];
	}
}