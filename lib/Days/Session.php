<?php
/**
 * Session - contain information about session.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2010 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysSession
 * @package      Days
 * @subpackage   Days
 * @author       Alexandr Janzen <xaoc2007@gmail.com>
 */
class Days_Session {
    private static $_obj;
    private $_session_vars = array();

    private function __construct() {
        session_start();
        $this->_session_vars = & $_SESSION;
    }

    /**
     * Singleton.
     *
     * @return Days_Session
     */
    public static function init() {
        if (! isset(self::$_obj))
            self::$_obj = new self();
        return self::$_obj;
    }

    /**
     * Return parameter by name.
     *
     * @param string $paramName Name of parameter
     * @param string $default Return value if parameter not exists
     * @return string
     */
    public static function get($paramName=null, $default=null) {
        // get session object
        $session = self::init();
        // return all variables
        if (is_null($paramName))
            return $session;
        // prepare variable name
        $paramName = strtolower($paramName);
        // check variables
        if (isset($session->_session_vars[$paramName]))
            return $session->_session_vars[$paramName];
        // return default variable
        return $default;
    }

    public function __get($paramName) {
        // get session object
        $session = self::init();
        // check variables
        if (isset($session->_session_vars[$paramName]))
            return $session->_session_vars[$paramName];
        return false;
    }

    public static function set($paramName, $value='') {
        // get session object
        $session = self::init();
        // prepare variable name
        $paramName = strtolower($paramName);
        $session->_session_vars[$paramName] = $value;
    }
}