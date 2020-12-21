<?php

require_once 'console_input.php';
require_once LIB_PATH.'/comaseparatedparser/Parser.php';

class UserInput
{
    /**
     * Solicita un entero al usuario
     */
    public static function solicitarINT($msg = null, $min = INT_MIN, $max = PHP_INT_MAX)
    {
        if($msg)
            echo $msg."\n";
        
        do
        {
            try {
                $res = ConsoleInput::readInt($min, $max);
                return $res;
            } catch (Exception $ex) {
                echo "entrada incorrecta, intentelo nuevamente\n";
            }
        }while (true);
    }
    /**
     * Solicita un float al usuario
     */
    public static function solicitarFLOAT($msg = null)
    {
        if($msg)
            echo $msg."\n";
        
        do
        {
            try {
                $res = ConsoleInput::readFloat();
                return $res;
            } catch (Exception $ex) {
                echo "entrada incorrecta, intentelo nuevamente\n";
            }
        }while (true);
    }
    /**
     * Solicita un booleano al usuario
     */
    public static function solicitarBOOLEAN($msg = null)
    {
        if($msg)
            echo $msg."\n";
        
        do
        {
            try {
                $res = ConsoleInput::readBoolean();
                return $res;
            } catch (Exception $ex) {
                echo "entrada incorrecta, intentelo nuevamente\n";
            }
        }while (true);
    }
    /**
     * Solicita un String al usuario
     */
    public static function solicitarSTRING($msg = null)
    {
        if($msg)
            echo $msg."\n";
        
        do
        {
            try {
                $res = ConsoleInput::readString();
                return $res;
            } catch (Exception $ex) {
                echo "¿Esta seguro de dejar este valor vacio?\n";
                if (UserInput::solicitarSIoNO()) {
                    return "";
                }
                
                echo "Intentelo nuevamente.\n";
            }
        }while (true);
    }
    /**
     * Solicita un arreglo en forma de lista separadas por comas, y por espacios para los elementos correspondiente a cada campo.
     */
    public static function solicitarARRAY($fields_array = null, $msg = null)
    {
        do
        {
            $input = UserInput::solicitarSTRING($msg);
            if (empty($input)) {
                return array();
            }

            $e = new Parser($input, $fields_array);

            try {
                return $e->parse();
            }
            catch(Exception $e) {
                echo $e->getMessage()."\n";
                echo "Intentelo nuevamente.";
            }
            
        }while(true);
    }
    /**
     * Solicita ENTER al usuario
     */
    public static function solicitarEnter()
    {   
        echo "Presione ENTER para continuar\n";
        
        ConsoleInput::readEnter();
    }
    /**
     * Solicita Si o No al usuario
     * retorno true si el usuario entra s o S, false en cualquier otro caso
     */
    public static function solicitarSIoNO()
    {
        while(true)
        {
            $res = self::solicitarSTRING("Escriba s para Si, n para No\n");

            if(strtolower($res) == "s")
                return true;
            if(strtolower($res) == "n")
                return false;
            
            echo "entrada invalida\n";
        }
    }
}