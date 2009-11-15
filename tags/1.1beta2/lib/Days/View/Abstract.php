<?php
/**
 * Abstract View - base class for all view adapters.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysViewAbstract
 * @package      Days
 * @subpackage   View
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
abstract class Days_View_Abstract implements Days_View_Interface {
    protected function _helper($name, $method, array $params=array()) {
        // set correct helper name
        $name = ucfirst($name);
        $name = "Days_Helper_{$name}";
        // check helper
        if (! class_exists($name) OR ! is_callable($name))
            return null;
        // return helper result
        return call_user_func_array(array($name, $method), $params);
    }
}