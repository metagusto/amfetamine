<?php
/**
 * The CharsetHandler class converts between various charsets
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright (c) 2003 amfphp.org
 * @package flashservices
 * @subpackage io
 * @author Fixed by metagûsto
 * @version $Id: CharsetHandler.php,v 1.5 2005/07/05 07:40:53 pmineault Exp $
 */
class CharsetHandler
{
    /**
     * Class constructor
     *
     * @param string $mode
     */
    public function __construct($mode)
    {
        $this->_method = CharsetHandler::getMethod();
        $this->_phpCharset = CharsetHandler::getPhpCharset();
        $this->_sqlCharset = CharsetHandler::getSqlCharset();
        $this->_mode = $mode;

        // unused: $newset = "";
        if ($this->_mode == "flashtophp") {
            $this->_fromCharset = "utf-8";
            $this->_toCharset = $this->_phpCharset;
            // unused: $newset = $this->_phpCharset;
        }
        else if ($this->_mode == "phptoflash") {
            $this->_fromCharset = $this->_phpCharset;
            $this->_toCharset = "utf-8";
            // unused: $newset = $this->_phpCharset;
        }
        else if ($this->_mode == "sqltophp") {
            $this->_fromCharset = $this->_sqlCharset;
            $this->_toCharset = $this->_phpCharset;
            // unused: $newset = $this->_sqlCharset;
        }
        else if ($this->_mode == "sqltoflash") {
            $this->_fromCharset = $this->_sqlCharset;
            $this->_toCharset = "utf-8";
            // unused: $newset = $this->_sqlCharset;
        }

        //Don't try to reencode charsets for nothing
        if ($this->_fromCharset == $this->_toCharset) {
            $this->_method = "none";
        }
    }

    public function transliterate($string)
    {
        switch ($this->_method) {
            case "none" :
                return $string;
                break;
            case "iconv" :
                return iconv($this->_fromCharset, $this->_toCharset, $string);
                break;
            case "utf8_decode" :
                return ($this->_mode == "flashtophp" ? utf8_decode($string) : utf8_encode($string));
                break;
            case "mbstring" :
                return mb_convert_encoding($string, $this->_toCharset, $this->_fromCharset);
                break;
            case "recode" :
                return recode_string($this->_fromCharset . ".." . $this->_toCharset, $string);
                break;
            default :
                return $string;
                break;
        }
    }

    /**
     * Sets the charset handling method
     *
     * @param string $location One of "none", "iconv", "mbstring", "recode"
     */
    public static function getMethod($val = NULL)
    {
        static $method = 0;
        if ($val != NULL) {
            if ($val == 'utf8_encode')
                $val = 'utf8_decode';
            $method = $val;
        }
        return $method;
    }

    public static function setMethod($val = 0)
    {
        return CharsetHandler::getMethod($val);
    }

    public static function getPhpCharset($val = NULL)
    {
        static $phpCharset = 0;
        if ($val != NULL)
            $phpCharset = strtolower($val);
        return $phpCharset;
    }

    public static function setPhpCharset($val = 0)
    {
        return CharsetHandler::getPhpCharset($val);
    }

    public static function getSqlCharset($val = NULL)
    {
        static $sqlCharset = 0;
        if ($val != NULL)
            $sqlCharset = strtolower($val);
        return $sqlCharset;
    }

    public static function setSqlCharset($val = 0)
    {
        return CharsetHandler::getSqlCharset($val);
    }
}
