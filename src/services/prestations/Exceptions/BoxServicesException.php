<?php

namespace gift\app\services\prestations\Exceptions;

use Exception;

class BoxServicesException extends Exception
{
    public function __construct($msg = "Objet non trouvé")
    {
        parent::__construct($msg);
    }
}

?>