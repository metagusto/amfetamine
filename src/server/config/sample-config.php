<?php

/**
 * AMFetamine server configuration
 */
$config = array
(
    /**
     *  Main configuration
     */
    "amf" => array
    (
        "mapping" => array
        (
            // In this section you can specify the deployment
            // path for services and objects
            "path" => array
            (
                "services" => "{root}/amf/services",
                "classes" => "{root}/amf/objects",
            ),

            // Specify here the class name implementing the
            // ClassMapperInterface that provides the local-to-remote. 
            // Leave it null if you don't need class mapping feature
            "mapper" => null,
        ),

        // Raw message dumping path for low-level debug purpose
        "raw-dumping-path" => array
        (
            "incoming" => "{root}/logs/raw/in",
            "outcoming" => "{root}/logs/raw/out",
        )
    ),

    /**
     * Logging configuration
     */
    "logging" => array
    (
        "path" => "{root}/logs",
        "filename" => "amfetamine.log",
    ),

    /**
     * Server settings
     */
    "settings" => array
    (
        // For production mode, switch debug-mode OFF!!
        "debug-mode" => true,

        // If enabled dumps raw amf message on filesystem
        // (see raw-dumping-path directive).
        "dump-amf-messages" => false,
    ),

    /**
     * Application facilities
     */
    "facilities" => array
    (
        // Use this directive to specify a class implementing
        // DatabaseProviderInterface interface to open/close
        // database connection. Set null to ignore this feature
        "databaseProviderClass" => null,
    )
);
