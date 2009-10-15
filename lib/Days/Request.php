<?php
/**
 * Request - contain information about user request (without url information).
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.sf.net).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://phpdays.sf.net/
 * @see          Days_Url
 * @package      phpDays
 * @subpackage   phpDays library
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_Request {
    public static function server($name=null, $default=null) {
        // return all variables
        if (is_null($name))
            return $_SERVER;
        // return specified variable
        if (isset($_SERVER[$name]))
            return $_SERVER[$name];
        // return default variable
        return $default;
    }

    /**
     * Check current request type and return true if it is AJAX.
     *
     * @return bool
     */
    public static function isAjax() {
        return ('xmlhttprequest' == strtolower(self::server('HTTP_X_REQUESTED_WITH')));
    }


    /**
     * Check current request type and return true if it is POST.
     *
     * @return bool
     */
    public static function isPost() {
        return ('POST' == $_SERVER["REQUEST_METHOD"]);
    }

}