<?php

/**
 * AMF PHP Package
 * -----------------------------------------------------------------------------
 * Release 1.9.metag
 */
$packagePath = dirname(__FILE__);
require_once($packagePath . "/core/amf/app/Gateway.php");
require_once($packagePath . "/core/shared/util/MethodTable.php");

/**
 * Default Settings
 */
global $amfphp;

$amfphp['CATCH_PHP_ERRORS'] = true;
$amfphp["errorLevel"] = E_ALL ^ E_NOTICE;
$amfphp["instanceName"] = NULL;
$amfphp["classPath"] = "services/";
$amfphp["customMappingsPath"] = "services/";
$amfphp["webServiceMethod"] = "php5";
$amfphp["disableDescribeService"] = false;
$amfphp["disableTrace"] = false;
$amfphp["disableDebug"] = false;
$amfphp["lastMethodCall"] = "/1";
$amfphp["lastMessageId"] = "";
$amfphp["isFlashComm"] = false;
$amfphp["classInstances"] = array();
$amfphp["encoding"] = "amf0";
$amfphp["native"] = true;
$amfphp["totalTime"] = 0;
$amfphp["callTime"] = 0;
$amfphp["decodeTime"] = 0;
$amfphp["includeTime"] = 0;
//Because startTime is defined BEFORE this file is called, we don"t define it here (else 
//we would overwrite it

$amfphpMapping = array();
$amfphpMapping["db_result"] = "peardb"; //PEAR::DB
$amfphpMapping["pdostatement"] = "pdo"; //PDO
$amfphpMapping["mysqli_result"] = "mysqliobject"; //Mysqli
$amfphpMapping["sqliteresult"] = "sqliteobject"; //SQLite
$amfphpMapping["sqliteunbuffered"] = "sqliteobject";
$amfphpMapping["adorecordset"] = "adodb"; //ADODB
$amfphpMapping["zend_db_table_row"] = "zendrow"; //Zend::DB
$amfphpMapping["zend_db_table_rowset"] = "zendrowset";
$amfphpMapping["recordset"] = "plainrecordset"; //Plain recordset
$amfphpMapping["doctrine_collection_immediate"] = "doctrine"; //Doctrine table
$amfphp["adapterMappings"] = $amfphpMapping;

define ("AMFPHP_VERSION", "1.10.1512-metag");

