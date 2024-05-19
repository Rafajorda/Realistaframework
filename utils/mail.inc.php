<?php
require __DIR__ . '/vendor/autoload.php';

// Assign a new Resend Client instance to $resend variable, which is automatically autoloaded...


// try {
//     $result = $resend->emails->send([
//         'from' => 'Acme <onboarding@resend.dev>',
//         'to' => ['rafajorgis@gmail.com'],
//         'subject' => 'Hello world',
//         'html' => '<strong>It works!</strong>',
//     ]);
// } catch (\Exception $e) {
//     exit('Error: ' . $e->getMessage());
// }

// Show the response of the sent email to be saved in a log...
// echo $result->toJson();
    class mail {
        public static function send_email($email) {
             switch ($email['type']) {
            //     case 'contact';
            //         $email['toEmail'] = '13salmu@gmail.com';
            //         $email['fromEmail'] = 'secondchanceonti@gmail.com';
            //         $email['inputEmail'] = 'secondchanceonti@gmail.com';
            //         $email['inputMatter'] = 'Email verification';
            //         $email['inputMessage'] = "<h2>Email verification.</h2><a href='http://localhost/Ejercicios/Framework_PHP_OO_MVC/index.php?module=contact&op=view'>Click here for verify your email.</a>";
            //         break;
                case 'validate';
                    $email['fromEmail'] = 'Acme <onboarding@resend.dev>';
                    $email['toEmail'] = $email['toEmail'];
                    $email['inputMatter'] = 'Email verification';
                    $email['inputMessage'] = "<h2>Email verification.</h2><a href='http://realista/login/verify/$email[token]'>Click here for verify your email.</a>";
                    break;
                case 'recover';
                    $email['fromEmail'] = 'Acme <onboarding@resend.dev>';
                    $email['toEmail'] = $email['toEmail'];
                    $email['inputMatter'] = 'Recover password';
                    email['inputMessage'] = "<h2>Email verification.</h2><a href='http://realista/login/recover/$email[token]'>Click here for verify your email.</a>";
             }
            return self::send_resend($email);
        }

        public static function send_resend($values){

            $cred = parse_ini_file(UTILS . "credentials.ini");
            $api = $cred['RESEND_API'];
            $resend = Resend::client($api);

            try {
                $result = $resend->emails->send([
                    'from' => $values['fromEmail'],
                    'to' => $values['toEmail'],
                    'subject' => $values['inputMatter'],
                    'html' => $values['inputMessage'],
                ]);
            } catch (\Exception $e) {
                exit('Error: ' . $e->getMessage());
            }
            //echo $result->toJson();

            // $mailgun = parse_ini_file(UTILS . "mailgun.ini");
            // $api_key = $mailgun['api_key'];
            // $api_url = $mailgun['api_url'];

            // $config = array();
            // $config['api_key'] = $api_key; 
            // $config['api_url'] = $api_url;

            // $message = array();
            // $message['from'] = $values['fromEmail'];
            // // $message['to'] = $values['toEmail'];
            // $message['to'] = 'salmu1997@gmail.com';
            // $message['h:Reply-To'] = $values['inputEmail'];
            // $message['subject'] = $values['inputMatter'];
            // $message['html'] = $values['inputMessage'];
            
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $config['api_url']);
            // curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            // curl_setopt($ch, CURLOPT_USERPWD, "api:{$config['api_key']}");
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            // curl_setopt($ch, CURLOPT_POST, true);
            // curl_setopt($ch, CURLOPT_POSTFIELDS,$message);
            // $result = curl_exec($ch);
            // curl_close($ch);
            return $result->toJson();
        }
    }