<?php

    namespace gift\app\services\utils;

    session_start();

    class CsrfService {

        public static function generate(){
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            return $_SESSION['csrf_token'];
        }

        public static function check($token){
            $session_token = $_SESSION['csrf_token'] ?? null;
            if(isset($session_token)){
                unset($_SESSION['csrf_token']);
            }
            if(is_null($token) || ($session_token != $token)) {
               throw new \Exception("invalid csrf token");
            }
        }

    }

?>