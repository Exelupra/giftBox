<?php

namespace gift\app\services\prestations\Exceptions;

use Exception;

class PrestationsServicesNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct("Objet non trouvée");
    }
}

?>