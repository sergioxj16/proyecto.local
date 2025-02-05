<?php

class Utils
{
    public static function esOpcionMenuActiva($opcion)
    {
        $actual = explode('/', $_SERVER['REQUEST_URI']);
        $actual = rtrim($actual[count($actual) - 1], '/');
        return $actual === $opcion;
    }
}
