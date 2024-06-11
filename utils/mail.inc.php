<?php
require __DIR__ . '/vendor/autoload.php';
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
                    $email['inputMessage'] = "<h2>Email verification.</h2><a href='http://realista.fw/login/verify/$email[token]'>Click here for verify your email.</a>";
                    break;
                case 'recover';
                    $email['fromEmail'] = 'Acme <onboarding@resend.dev>';
                    $email['toEmail'] = $email['toEmail'];
                    $email['inputMatter'] = 'Recover password';
                    $email['inputMessage'] = "<h2>Email verification.</h2><a href='http://realista.fw/login/recover/$email[token]'>Click here for verify your email.</a>";
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
            return $result->toJson();
        }
    }