<?php
include($_SERVER['DOCUMENT_ROOT'] . "/Realistaframework/model/JWT.php");

function decode_token($token){
    $jwt = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/Realistaframework/model/credentials.ini');
    $secret = $jwt['JWT_SECRET'];

    $JWT = new JWT;
    $token_dec = $JWT->decode($token,$secret);
    $rt_token = json_decode($token_dec, TRUE);
    return $rt_token;
}

function create_accesstoken($username,$id){
    $jwt = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/Realistaframework/model/credentials.ini');
    $header = $jwt['JWT_HEADER'];
    // $header = '{
    //     "alg": "HS256",
    //     "typ": "JWT"
    //   }';
    $secret = $jwt['JWT_SECRET'];
   // $payload = '{"iat":"' . time() . '","exp":"' . time() + (300) . '","username":"' . $username . '" }';
   $payload = '{"iat":"' . time() . '","exp":"' . (time() + 600) . '","username":"' . $username . '","id":"' . $id . '"}';
    $JWT = new JWT;
    $token = $JWT->encode($header, $payload, $secret);
    return $token;
}
function create_refreshtoken($username,$id){
    $jwt = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/Realistaframework/model/credentials.ini');
    $header = $jwt['JWT_HEADER'];
    // $header = '{
    //     "alg": "HS256",
    //     "typ": "JWT"
    //   }';
    $secret = $jwt['JWT_SECRET'];
   // $payload = '{"iat":"' . time() . '","exp":"' . time() + (600) . '","username":"' . $username . '"}';
    $payload = '{"iat":"' . time() . '","exp":"' . (time() + 2400) . '","username":"' . $username . '","id":"' . $id . '"}';

    $JWT = new JWT;
    $token = $JWT->encode($header, $payload, $secret);
    return $token;
}