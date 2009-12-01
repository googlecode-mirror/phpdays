<?php
/**
 * Dwoo View - Dwoo adapter.
 *
 * Part of "php:Days - php5 framework" project (http://phpdays.googlecode.com).
 *
 * @copyright    Copyright (c) 2009 phpDays foundation (http://phpdays.org)
 * @license      http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link         http://code.google.com/p/phpdays/wiki/EnLibDaysViewDwoo
 * @package      Days
 * @subpackage   View
 * @author       Anton Danilchenko <happy@phpdays.org>
 */

class Days_View_Dwoo extends Days_View_Abstract implements Days_View_Interface {
    /** @var Dwoo_Data Template variables */
    protected $_vars = array();
    /** @var Dwoo Template engine */
    protected $_engine;
    /** @var string Template directory */
    private $_templateDir;

    /**
     * Initialize template engine.
     */
    public function __construct(Days_View_Config $viewConfig) {
        $this->_templateDir = $viewConfig->getTemplateDir();
        // create template engine instance
        $this->_engine = new Dwoo(
            $viewConfig->getCompileDir(),
            $viewConfig->getCacheDir());
        // collect vars
        $this->_vars = new Dwoo_Data(); 
    }

    /**
     * Return result template with setted variables.
     *
     * @param string $template Template name
     * @return string
     */
    public function render($template) {
        $templatePath = $this->_templateDir . $template;
        if (! file_exists($templatePath))
            throw new Days_Exception("Template file '{$template}' not found");
        return $this->_engine->get($templatePath, $this->_vars);
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
        $value = $default;
        try {
            $value = $this->_vars->get($var);
        } catch (Dwoo_Exception $e) {
        }
        return $value;
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
        $this->_vars->assign($var, $value);
    }
}