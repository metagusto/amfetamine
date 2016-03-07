<?php

/**
 * JSON gateway
 */

include("globals.php");

include "core/json/app/JsonGateway.php";

$gateway = new Gateway();

$gateway->setBaseClassPath($servicesPath);

$gateway->service();
