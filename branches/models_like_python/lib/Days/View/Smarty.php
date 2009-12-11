<?php
/**
 * Smarty View - Smarty adapter.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysViewSmarty
 * @package      Days
 * @subpackage   View
 * @author       Anton Danilchenko <happy@phpdays.org>
 */
class Days_View_Smarty extends Days_View_Abstract implements Days_View_Interface {
    /** @var Smarty Template engine */
    protected $_engine;

    /**
     * Initialize template engine.
     */
    public function __construct(Days_View_Config $viewConfig) {
        // create template engine instance
        $this->_engine = new Smarty();
        // configure template engine
        $this->_engine->template_dir  = $viewConfig->getTemplateDir();
        $this->_engine->compile_dir   = $viewConfig->getCompileDir();
        $this->_engine->cache_dir     = $viewConfig->getCacheDir();
        if ($viewConfig->getCaching() > 0) {
            $this->_engine->cache_lifetime = $viewConfig->getCaching();
            $this->_engine->caching       = 1;
        }
        $this->_engine->plugins_dir   = array('phpdays', 'plugins');
    }

    /**
     * Return result template with setted variables.
     *
     * @param string $template Template name
     * @return string
     */
    public function render($template) {
        if (! $this->_engine->template_exists($template))
            throw new Days_Exception("Template file '{$template}' not found");
        return $this->_engine->fetch($template);
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
        $value = $this->_engine->get_template_vars($var);
        return isset($value)? $value : $default;
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
        if (is_string($delimiter)) {
            $oldValue = $this->get($var);
            // set seperator for existing value only
            if (! empty($oldValue))
                $value = "{$value}{$delimiter}{$oldValue}";
        }
        // set new value
        $this->_engine->assign($var, $value);
    }
}