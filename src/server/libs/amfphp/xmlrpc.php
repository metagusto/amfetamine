<?php

/**
 * XML-RPC server
 */
include("globals.php");

include "core/xmlrpc/app/XmlRpcGateway.php";

$gateway = new Gateway();

$gateway->setBaseClassPath($servicesPath);

$gateway->service();
