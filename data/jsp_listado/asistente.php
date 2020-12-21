<?php

require_once LIB_PATH.'/softfactory/assistant/asistente_abstract.php';
require_once LIB_PATH.'/softfactory/assistant/variable.php';

class Asistente extends AsistenteAbstract
{
    public function __construct($basePath, $php_path, $sandboxfilepath) {
        $a = array();
        $a[] = new Variable("identificador", "STRING", array(), null);
        $a[] = new Variable("atributo_listado", "STRING", array(), null);
        $a[] = new Variable("atributos", "ARRAY", array(), null);

        parent::__construct($basePath, $php_path, $sandboxfilepath, $a);
    }
}