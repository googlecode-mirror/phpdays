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
    /** @var Templum Template engine */
    protected $_engine;
    /** @var array Template variables */
    private $_vars = array();

    /**
     * Initialize template engine.
     */
    public function __construct(Days_View_Config $viewConfig) {
        // configure template engine
        Templum::setTemplateDir($viewConfig->getTemplateDir());
        Templum::setCompileDir($viewConfig->getCompileDir());
        // create template engine instance
        $this->_engine = Templum::singleton();
    }

    /**
     * Return result template with setted variables.
     *
     * @param string $template Template name
     * @return string
     */
    public function render($template) {
        if (! $this->_engine->exists($template))
            throw new Days_Exception("Template file '{$template}' not found");
        return $this->_engine->get($template, $this->_vars);
    }

    /** 
     * Returns a value of a template variable.
     *
     * If a template variable does not exist or its value is null,
     * returns a default value.
     *
     * @param string $var Name of a template variable
     * @param string $default Default value to return
     * @return string 
     */
    public function get($var, $default=null) {
        return isset($this->_vars[$var])? $this->_vars[$var] : $default;
    }

    /**
     * Set a variable.
     *
     * @param string $var Variable name
     * @param mixed $value Variable value
     */
    public function set($var, $value) {
        $this->_vars[$var] = $value;
    }
}