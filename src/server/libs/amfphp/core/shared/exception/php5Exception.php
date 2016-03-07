<?php

/**
 * The VerboseException class adds level, code, file, and line info to a regular exception
 * so that PHP5 errors are as verbose as possible
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright (c) 2003 amfphp.org
 * @package flashservices
 * @subpackage exception
 * @author Justin Watkins Original Design
 * @version $Id: AMFException.php,v 1.2 2005/04/02 18:37:23 pmineault Exp $
 */
class VerboseException extends Exception
{
    public $description;
    public $level;
    public $file;
    public $line;
    public $code;
    public $message;

    public function __construct($string, $level, $file, $line)
    {
        $this->description = $string;
        $this->level = $level;
        $this->code = "AMFPHP_RUNTIME_ERROR";
        $this->file = $file;
        $this->line = $line;
        parent::__construct($string);
    }
}

/**
 * PHP error handler
 *
 * @param string $level
 * @param string $string
 * @param string $file
 * @param integer $line
 * @param string $context
 */
function amfErrorHandler($level, $string, $file, $line, $context)
{
    // TODO: check logic
    Logger::getInstance()->error("AMF Protocol error: $string / level: $level / file: $file / line: $line / $context: $context");
    //forget about errors not defined at reported
    $amfphpErrorLevel = $GLOBALS ['amfphp'] ['errorLevel'];

    if (error_reporting() != 0 && ($amfphpErrorLevel | $level) == $amfphpErrorLevel)
        throw new VerboseException($string, $level, $file, $line);
}

// Setting up error handler if requested
global $amfphp;
if ($amfphp ['CATCH_PHP_ERRORS'] == true)
    set_error_handler("amfErrorHandler");
