<?php

class Utility {

	public static function generateRandomString($type,$length) {
		if($type=='numaric') {
			$characters = '0123456789';
		} else if($type=='alphabatic') {
			$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		} else if($type=='alphanumaric') {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		}
		    
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	public static function str2array($string) { // for non key-value array
		$string = substr($string, 1, -1);
		if($string == '') {
			return array();
		} else {
			$arr = explode(',',$string);
			return $arr;
		}
	}

}