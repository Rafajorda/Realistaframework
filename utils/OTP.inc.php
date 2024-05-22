<?php
require __DIR__ . '/vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

 // if you use Composer
//require_once('ultramsg.class.php'); // if you download ultramsg.class.php
class OTP{

    public static function OTP_send($values){
        $cred = parse_ini_file(UTILS . "credentials.ini");
        $ultramsg_token=$cred['OTP_TOKEN'];// Ultramsg.com token
        $instance_id=$cred['OTP_INSTANCE']; // Ultramsg.com instance id
        $client = new UltraMsg\WhatsAppApi($ultramsg_token,$instance_id);

        $to= $cred['OTP_PHONE'];
        $body="please enter the current number $values"; 
        $api=$client->sendChatMessage($to,$body);
        return $api->toJson();
    }

    public static function OTP_send2($values){

        $body = "Please use this one-time code: $values";
        $cred = parse_ini_file(UTILS . "credentials.ini");
    
        $ultramsg_token = $cred['OTP_TOKEN'];
        $instance_id = $cred['OTP_INSTANCE'];
        $phone_number = $cred['OTP_UMPHONE'];
        
        $params = [
            'token' => $ultramsg_token,
            'to' => $phone_number,
            'body' => $body,
            'priority' => '1',
            'referenceId' => '',
            'msgId' => '',
            'mentions' => ''
        ];
    
        $client = new GuzzleHttp\Client();
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $options = ['form_params' => $params];
        
        try {
            $request = new GuzzleHttp\Psr7\Request('POST', "https://api.ultramsg.com/$instance_id/messages/chat", $headers);
            $res = $client->send($request, $options);
            return (string) $res->getBody();
        } catch (GuzzleHttp\Exception\RequestException $e) {
            return 'Request failed: ' . $e->getMessage();
        }
    }

       
    

}