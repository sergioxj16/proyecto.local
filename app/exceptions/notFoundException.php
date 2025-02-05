<?php

class NotFoundException extends Exception
{
    public function __construct($message = "Página no encontrada", $code = 404)
    {
        parent::__construct($message, $code);
    }
}
