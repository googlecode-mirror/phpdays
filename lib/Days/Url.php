<?php
/**
 * Url - contain information about requested url adress.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.sf.net).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://phpdays.sf.net/
 * @see          Days_Request
 * @package      phpDays
 * @subpackage   phpDays library
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_Url {
    private static $_obj;
    private $_params = array();
    private $_specParams = array();

    private function __construct() {
        // set global variables
        global $_SERVER;
        // get site settings
        $sDefaultLang   = Days_Config::load()->get('url/lang', 'en');
        $sDefaultExt    = Days_Config::load()->get('url/ext', 'html');
        $basePath       = Days_Config::load()->get('url/base', '');
        // get url path, start from base path
        $basePath = trim($basePath, '/');
        $urlAdress = (string)substr(trim($_SERVER['REQUEST_URI'], '/'), strlen($basePath));
        // parse path
        if (0 == preg_match('`^(.+)\.([a-z]{2})\.([a-z]{3,5})/?$`', $urlAdress, $aMatches))
            $aMatches = array(1=>$urlAdress, 2=>$sDefaultLang, 3=>$sDefaultExt);
        // explode path to variables
        $aPath = explode('/', trim($aMatches[1], '/'));
        // set system variables
        $this->_specParams['protocol']    = empty($_SERVER['HTTPS']) ? 'http' : 'https';
        $this->_specParams['host']        = $_SERVER['HTTP_HOST'];
        $this->_specParams['controller']  = (! empty($aPath[0]) ? $aPath[0] : 'index');
        $this->_specParams['action']      = (! empty($aPath[1]) ? $aPath[1] : 'index');
        $this->_specParams['lang']        = $aMatches[2];
        $this->_specParams['ext']         = $aMatches[3];
        // set user variables
        foreach ($aPath as $iNum=>$sValue) {
            // not handle first two parameters (servise and action name)
            if ($iNum<=1)
                continue;
            // parse parameter as "name:value"
            $aParams = explode(':', $sValue, 2);
            $sName = $aParams[0];
            $sValue = isset($aParams[1]) ? $aParams[1] : '';
            // set value
            if (''!=$sValue)
                $this->_params[$sName] = $sValue;
            else
                $this->_params[] = $sName;
        }
    }

    /**
     * Singleton.
     *
     * @return Days_Url
     */
    public static function init() {
        if (! isset(self::$_obj))
            self::$_obj = new self();
        return self::$_obj;
    }

    /**
     * Return parameter by name or index.
     *
     * @param string $paramName Numerical index or name of parameter
     * @param string $default Return value if parameter not exists
     * @return string
     */
    public static function get($paramName=null, $default=null) {
        // get url object
        $url = self::init();
        // return all variables
        if (is_null($paramName))
            return $url->_params;
        // prepare variable name
        $paramName = strtolower($paramName);
        // numerical parameter (start from index 1)
        if (is_numeric($paramName))
            $paramName = ($paramName<=0) ? 0 : $paramName-1;
        // check variables
        if (isset($url->_params[$paramName]))
            return $url->_params[$paramName];
        // return default variable
        return $default;
    }

    public static function getSpec($paramName=null, $default=null) {
        // get url object
        $url = self::init();
        // return all variables
        if (is_null($paramName))
            return $url->_specParams;
        // prepare variable name
        $paramName = strtolower($paramName);
        // check variables
        if (isset($url->_specParams[$paramName]))
            return $url->_specParams[$paramName];
        // return default variable
        return $default;
    }

    public static function getProtocol() {
        return self::getSpec('protocol');
    }

    public static function getHost() {
        return self::getSpec('host');
    }

    public static function getController() {
        return self::getSpec('controller');
    }

    public static function getAction() {
        return self::getSpec('action');
    }

    public static function getLang() {
        return self::getSpec('lang');
    }

    public static function getExt() {
        return self::getSpec('ext');
    }

    public static function getFull() {
        // get url object
        $url = self::init();
        // return full path with all variables
        return ($url->_specParams['host'] . '://' . $_SERVER['REQUEST_URI']);
    }

    /**
     * Return adress of previous page.
     *
     * @return string
     */
    public static function prev() {
        // if not defined previous page - return current page adress
        return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : self::getFull();
    }
}