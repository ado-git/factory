<?php

if(!defined("INT_MIN"))
{
    define("INT_MIN", PHP_INT_MAX * -1);
}

class ConsoleInput
{
    /**
     * Lee un string desde la consola
     */
    public static function readLine()
    {
        $line = trim(fgets(STDIN));
        return $line;
    }
    /**
     * Lee un entero de la consola dentro del rango especificado, lanza una excepcion si no se obtiene un entero
     */
    public static function readInt($min = INT_MIN, $max = PHP_INT_MAX)
    {
        $res = filter_var(self::readLine(), FILTER_VALIDATE_INT);
        
        if($res === false)
            throw new Exception("no es un entero");
        
        if($res < $min || $res > $max)
            throw new Exception("fuera de rango");
        
        return $res;
    }
    /**
     * Lee un float de la consola, lanza una excepcion si no se obtiene un float
     */
    public static function readFloat()
    {
        $res = filter_var(self::readLine(), FILTER_VALIDATE_FLOAT);
        
        if($res === false)
            throw new Exception("valor invalido");
        
        return $res;
    }
    /**
     * Lee un boolean de la consola, lanza una excepcion si no se obtiene un boolean
     */
    public static function readBoolean()
    {
        $res = filter_var(self::readLine(), FILTER_VALIDATE_BOOLEAN, array('flags' => FILTER_NULL_ON_FAILURE));
        
        if($res === null)//notar aqui que es null
            throw new Exception("valor invalido");
        
        return $res;
    }
    /**
     * Lee un string que no este vacio.
     */
    public static function readString()
    {
        $res = self::readLine();
        
        if ($res === null || $res == "") {
            throw new Exception("valor invalido");
        }

        return $res;
    }
    /**
     * Lee un ENTER
     */
    public static function readEnter()
    {
        $res = self::readLine();
    }
}
