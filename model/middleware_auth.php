<?php
class middleware{
    public static function decode_username($get_token){
		$jwt = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/utils/credentials.ini');
		$secret = $jwt['JWT_SECRET'];
		$token = $get_token;

		$JWT = new JWT;
		$json = $JWT -> decode($token, $secret);
		$json = json_decode($json, TRUE);

        $decode_user = $json['name'];
        return $decode_user;
    }
    public static function decode_token($get_token){
        $jwt = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/utils/credentials.ini');
        $secret = $jwt['JWT_SECRET'];
        $token = $get_token;
        $JWT = new JWT;
        $token_dec = $JWT->decode($token,$secret);
        $rt_token = json_decode($token_dec, TRUE);
        return $rt_token;
    }
	public static function decode_exp($get_token){
		$jwt = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/utils/credentials.ini');
		$secret = $jwt['JWT_SECRET'];
		$token = $get_token;

		$JWT = new JWT;
		$json = $JWT -> decode($token, $secret);
		$json = json_decode($json, TRUE);

        $decode_exp = $json['exp'];
        return $decode_exp;
    }

	public static function encode($user) {
        $jwt = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/utils/credentials.ini');

        $header = $jwt['JWT_HEADER'];
        $secret = $jwt['JWT_SECRET'];
        $payload = json_encode(['iat' => time(), 'exp' => time() + (60 * 60), 'name' => $user]);

        $JWT = new jwt();
        return $JWT -> encode($header, $payload, $secret);
    }

     public static function create_accesstoken($username,$id){
        $jwt = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/utils/credentials.ini');
        $header = $jwt['JWT_HEADER'];
    
        $secret = $jwt['JWT_SECRET'];
        // $payload = '{"iat":"' . time() . '","exp":"' . time() + (300) . '","username":"' . $username . '" }';
        $payload = '{"iat":"' . time() . '","exp":"' . (time() + 600) . '","username":"' . $username . '","id":"' . $id . '"}';
        $JWT = new JWT;
        $token = $JWT->encode($header, $payload, $secret);
        return $token;
    }
    public static function create_refreshtoken($username,$id){
        $jwt = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/utils/credentials.ini');
        $header = $jwt['JWT_HEADER'];
       
        $secret = $jwt['JWT_SECRET'];
    // $payload = '{"iat":"' . time() . '","exp":"' . time() + (600) . '","username":"' . $username . '"}';
        $payload = '{"iat":"' . time() . '","exp":"' . (time() + 2400) . '","username":"' . $username . '","id":"' . $id . '"}';

        $JWT = new JWT;
        $token = $JWT->encode($header, $payload, $secret);
        return $token;
    }




}