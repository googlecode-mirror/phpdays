<?php
/**
 * View - php adapter.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.sf.net).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysViewPhp
 * @package      phpDays
 * @subpackage   phpDays library
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_View_Php implements Days_View_Interface {
    /** @var array */
    protected $_vars = array();

    public function __construct() {
    }

    public function render($template) {
        $templatePath = Days_Engine::appPath() . 'View/' . $template;
        if (! file_exists($templatePath))
            throw new Days_Exception("Template file '{$template}' not found");
        extract($this->_vars);

        //connection and perform template
        ob_start();
        require ($templatePath);
        return ob_get_clean();
    }

    public function get($var, $default=null) {
        return (isset($this->_vars[$var]) ? $this->_vars[$var] : $default);
    }

    /**
     *
     * @param <type> $var
     * @param <type> $value
     * @param bool $merge Merge new value with old value
     * @param string $delimiter Values separator
     */
    public function set($var, $value, $merge=false, $delimiter='-') {
        // add value to existing
        if ($merge) {
            $oldValue = $this->get($var, '');
            // set seperator for existing value only
            if (! empty($oldValue))
                $value = "{$value} {$delimiter} {$oldValue}";
        }
        // set new value
        $this->_vars[$var] = $value;
    }
}