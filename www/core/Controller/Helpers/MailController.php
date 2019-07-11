<?php

namespace Core\Controller\Helpers;

use \Swift_Mailer;

class MailController
{
    public function sendMail($subject, $pMailTo, $pMessage, $pMailToBcc = true){//:string
        
        // Create the Transport, tls = plus secure que ssl
        if (getenv('ENV_DEV')) {
            $transport = (new \Swift_SmtpTransport('mailcatcher', 25));
        } else {
            $transport = (new \Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
              ->setUsername(getenv('SETUSERNAME'))
              ->setPassword(getenv('SETPASSWORD'))
            ;
            //dd($transport);
        }
        
        // Create the Mailer using your created Transport
            $mailer = new Swift_Mailer($transport);
        
        // Create a message
            if (!is_array($pMailTo)) {
                $pMailTo = [$pMailTo];
            }
            
            /*if ($pMailToBcc == true) {
                $message = (new Swift_Message($subject))
                  ->setFrom([$setUsername => $pseudo])
                  ->setBody($pMessage)
                  ->setBcc($pMailTo);
              }else{
                  $message = (new Swift_Message($subject))
                  ->setFrom([$setUsername => $pseudo])
                  ->setBody($pMessage)
                  ->setTo($pMailTo);
              }*/
              //ma condition correspondant à
              $message = (new \Swift_Message($subject));
              $message->setFrom([(getenv('SETUSERNAME')) => (getenv('SETPSEUDO'))]);
        
              if ($pMailToBcc == true){
                  $message->setBcc($pMailTo);
              }else{
                  $message->setTo($pMailTo);
              }
        
              if (is_array($pMessage) && array_key_exists("html", $pMessage) && array_key_exists("text", $pMessage)) {
                $message->setBody($pMessage["html"], 'text/html');
                //ou
                $message->addPart($pMessage["text"], 'text/plain');
        
            }elseif (is_array($pMessage) && array_key_exists("html", $pMessage)) {
                $message->setBody($pMessage["html"], 'text/html');
                $message->addPart($pMessage["html"], 'text/plain');
        
            }elseif (is_array($pMessage) && array_key_exists("text", $pMessage)) {
                $message->setBody($pMessage["text"], 'text/plain');
        
            }elseif (is_array($pMessage)) {
                die('erreur une clé n\'est pas bonne');
        
            }else{
                $message->setBody($pMessage, 'text/plain');
            }
        // Send the message
            return $mailer->send($message);//donne le nb de message ou false
        
        }
}


