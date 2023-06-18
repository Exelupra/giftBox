<?php
/**
 * File:  Eloquents.php
 * Creation Date: 27/12/2022
 * description: classe Eloquent, service de connexion à la base de données
 *
 * 
 */

namespace gift\app\services\utils;

use Illuminate\Database\Capsule\Manager as DB ;

class Eloquent {


    public static function init ($filename) {


        $db = new DB();
        $db->addConnection(parse_ini_file($filename));
        $db->setAsGlobal();
        $db->bootEloquent();

    }


}
