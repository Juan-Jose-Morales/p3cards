<?php

namespace App\Http\Helpers;

class ResponseGenerator{


	public static function generateResponse($code,$data,$msg="",$extra=null){

		$response = [
			"status" => $code
		];

		if($msg)
			$response['message'] = $msg;
		if($data)
			$response['data'] = $data;

		if($extra)
			$response['extra'] = $extra;

		return json_encode($response);
	}


}