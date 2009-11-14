<?php
/**
 * Templum View - Templum adapter.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysViewTemplum
 * @package      Days
 * @subpackage   View
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_View_Templum extends Days_View_Abstract implements Days_View_Interface {
    /** @var Templum */
    protected $_engine;
    
    /**
     * Template variables
     * 
     * @var array
     */
    private $_vars = array();

    public function __construct() {
        // configure template engine
        $config = array(
            'template_dir'  => Days_Engine::appPath() . 'View/',
            'compile_dir'   => Days_Engine::appPath() . 'system/view/',
            'cache_dir'     => Days_Engine::appPath() . 'system/cache/',
            'caching'       => Days_Config::load()->get('cache/lifetime', 0) > 0,
        );
        Templum::setTemplateDir($config['template_dir']);
        Templum::setCompileDir($config['compile_dir']);
        // create template engine instance
        $this->_engine = Templum::singleton();
    }

    public function render($template) {
        if (! $this->_engine->exists($template))
            throw new Days_Exception("Template file '{$template}' not found");
        return $this->_engine->get($template, $this->_vars);
    }

    /** 
     * Returns a value of a template variable.
     * If a template variable does not exist or its value is null,
     * returns a default value.
     * 
     * @param string $var     a name of a template variable
     * @param string $default a default value to return
     * @return string 
     */
    public function get($var, $default=null) {
        return isset($this->_vars[$var])? $this->_vars[$var] : $default;
    }

    /**
     * Set value.
     *
     * @param string $var
     * @param mixed $value
     * @param bool $merge Merge new value with old value
     * @param string $delimiter Values separator
     */
    public function set($var, $value, $delimiter=null) {
        // add value to existing
        if (is_string($delimiter)) {
            $oldValue = $this->get($var);
            // set seperator for existing value only
            if (! empty($oldValue))
                $value = "{$value}{$delimiter}{$oldValue}";
        }
        // set new value
        $this->_vars[$var] = $value;
    }
}