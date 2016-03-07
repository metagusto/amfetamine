<?php

// Registering Zend autoloader function
spl_autoload_register("zend_package_autoload");

/**
 * Performs Zend classes autoload
 * @author metagûsto
 * @param string $classname The class name
 */
function zend_package_autoload($classname)
{
    static $items;
    static $packageRoot;
    if (is_null($items)) {
        $items = array
        (
            // Logging
            "Zend_Log" => "log/Zend_Log.php",
            "Zend_Log_Exception" => "log/Zend_Log_Exception.php",

            "Zend_Log_Filter_Interface" => "log/filter/Zend_Log_Filter_Interface.php",
            "Zend_Log_Filter_Message" => "log/filter/Zend_Log_Filter_Message.php",
            "Zend_Log_Filter_Priority" => "log/filter/Zend_Log_Filter_Priority.php",
            "Zend_Log_Filter_Suppress" => "log/filter/Zend_Log_Filter_Suppress.php",

            "Zend_Log_Formatter_Interface" => "log/formatter/Zend_Log_Formatter_Interface.php",
            "Zend_Log_Formatter_Simple" => "log/formatter/Zend_Log_Formatter_Simple.php",
            "Zend_Log_Formatter_Xml" => "log/formatter/Zend_Log_Formatter_Xml.php",

            "Zend_Log_Writer_Abstract" => "log/writer/Zend_Log_Writer_Abstract.php",
            "Zend_Log_Writer_Db" => "log/writer/Zend_Log_Writer_Db.php",
            "Zend_Log_Writer_Firebug" => "log/writer/Zend_Log_Writer_Firebug.php",
            "Zend_Log_Writer_Mock" => "log/writer/Zend_Log_Writer_Mock.php",
            "Zend_Log_Writer_Stream" => "log/writer/Zend_Log_Writer_Stream.php",
            "Zend_Log_Writer_Null" => "log/writer/Zend_Log_Writer_Null.php",

            // Exceptions
            "Zend_Exception" => "exceptions/Zend_Exception.php",
        );
    }
    if (is_null($packageRoot)) {
        $packageRoot = dirname(__FILE__);
    }
    if (array_key_exists($classname, $items)) {
        require_once $packageRoot . "/" . $items[$classname];
    }
}

