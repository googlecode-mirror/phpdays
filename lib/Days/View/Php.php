<?php
/**
 * Php View - php adapter.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysViewPhp
 * @package      Days
 * @subpackage   View
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_View_Php extends Days_View_Abstract implements Days_View_Interface {
    /** @var array */
    protected $_vars = array();

    public function __construct() {
    }

    public function render($template) {
        return $this->_include($template, $this->_vars);
    }

    /**
     * Return value of specified variable.
     *
     * @param string $var Variable name
     * @param mixed $default Return this value if variable not exists
     * @return mixed
     */
    public function get($var, $default=null) {
        return (isset($this->_vars[$var]) ? $this->_vars[$var] : $default);
    }

    /**
     * Set variable.
     *
     * @param string $var Variable name
     * @param mixed $value Variable value
     * @param string $delimiter Values separator
     */
    public function set($var, $value, $delimiter=null) {
        // add value to existing
        if (! is_null($delimiter) AND is_string($delimiter)) {
            $oldValue = $this->get($var, '');
            // set seperator for existing value only
            if (! empty($oldValue))
                $value = "{$value}{$delimiter}{$oldValue}";
        }
        // set new value
        $this->_vars[$var] = $value;
    }
}